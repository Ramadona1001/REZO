<?php

namespace App\Http\Controllers;

use App\Models\ProjectStage;
use App\Models\Task;
use App\Models\TaskComment;
use App\Models\TaskFile;
use App\Models\TaskStage;
use App\Models\TimeTracker;
use App\Models\User;
use App\Models\Project;
use App\Models\Utility;
use App\Models\Bug;
use App\Models\BugStatus;
use App\Models\BugFile;
use App\Models\BugComment;
use App\Models\Milestone;
use Carbon\Carbon;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\CustomProject;
use App\Models\Employee;
use App\Models\Position;
use App\Models\ProjectEmployee;
use App\Models\ProjectPosition;
use App\Models\ProjectService;
use App\Models\ProjectTask;
use App\Models\ProjectUser;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class CustomProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($view = 'list')
    {
        if(\Auth::user()->can('manage project'))
        {
            $positions = Position::get()->pluck('name','id');
            $services = Service::where('created_by',auth()->user()->id)->get();
            return view('custom-projects.index', compact('view','positions','services'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->can('create project'))
        {
          $employees   = Employee::where('created_by',auth()->user()->id)->get()->pluck('name', 'id');
          $clients = Client::where('created_by',auth()->user()->id)->get()->pluck('name', 'id');
          $services = Service::where('created_by',auth()->user()->id)->get();
          $clients->prepend('Select Client', '');
          $employees->prepend('Select Employee', '');
            return view('custom-projects.create', compact('clients','employees','services'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if(\Auth::user()->can('create project'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                'project_name' => 'required',
                            ]
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }
            $project = new CustomProject();
            $project->project_name = $request->project_name;
            $project->positions = $request->positions;
            $project->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            $project->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));

            if($request->hasFile('project_image'))
            {
                //storage limit
                $image_size = $request->file('project_image')->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                if($result==1)
                {
                    $imageName = time() . '.' . $request->project_image->extension();
                    $request->file('project_image')->storeAs('projects', $imageName);
                    $project->project_image      = 'projects/'.$imageName;
                }
            }

            $project->client_id = $request->client;
            $project->budget = !empty($request->budget) ? $request->budget : 0;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->estimated_hrs = $request->estimated_hrs;
            $project->tags = $request->tag;
            $project->created_by = \Auth::user()->creatorId();
            $project['copylinksetting']   = '{"member":"on","milestone":"off","basic_details":"on","activity":"off","attachment":"on","bug_report":"on","task":"off","tracker_details":"off","timesheet":"off" ,"password_protected":"off"}';

            $project->save();

            if (isset($request->services)) {
                for ($i=0; $i < count($request->services); $i++) {
                    if ($request->financial_value[$i] > 0 || $request->financial_value[$i] != null || $request->financial_value[$i] != '') {
                        $project_service = ProjectService::where('project_id',$project->id)->where('service_id',$request->services[$i])->first();
                        if ($project_service == null) {
                            ProjectService::create([
                                'service_id' => $request->services[$i],
                                'financial_value' => $request->financial_value[$i],
                                'project_id' => $project->id,
                            ]);
                        }else{
                            $project_service->update([
                                'service_id' => $request->services[$i],
                                'financial_value' => $request->financial_value[$i],
                                'project_id' => $project->id,
                            ]);
                        }
                    }
                }
            }


            // if(\Auth::user()->type=='company'){

            //     ProjectUser::create(
            //         [
            //             'project_id' => $project->id,
            //             'user_id' => Auth::user()->id,
            //         ]
            //     );

            //     if($request->user){
            //         foreach($request->user as $key => $value) {
            //             ProjectUser::create(
            //                 [
            //                     'project_id' => $project->id,
            //                     'user_id' => $value,
            //                 ]
            //             );
            //         }
            //     }


            // }else{
            //     ProjectUser::create(
            //         [
            //             'project_id' => $project->id,
            //             'user_id' => Auth::user()->creatorId(),
            //         ]
            //     );

            //     ProjectUser::create(
            //         [
            //             'project_id' => $project->id,
            //             'user_id' => Auth::user()->id,
            //         ]
            //     );

            //     if($request->user){
            //         foreach($request->user as $key => $value) {
            //             ProjectUser::create(
            //                 [
            //                     'project_id' => $project->id,
            //                     'user_id' => $value,
            //                 ]
            //             );
            //         }
            //     }

            // }


            //For Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            $projectNotificationArr = [
                'project_name' => $request->project_name,
                'user_name' => \Auth::user()->name,
            ];
            //Slack Notification
            if(isset($setting['project_notification']) && $setting['project_notification'] ==1)
            {
                Utility::send_slack_msg('new_project', $projectNotificationArr);
            }

            //Telegram Notification
            if(isset($setting['telegram_project_notification']) && $setting['telegram_project_notification'] ==1)
            {
                Utility::send_telegram_msg('new_project', $projectNotificationArr);
            }

            //webhook
            $module ='New Project';
            $webhook=  Utility::webhookSetting($module);
            if($webhook)
            {
                $parameter = json_encode($project);
                $status = Utility::WebhookCall($webhook['url'],$parameter,$webhook['method']);
                if($status == false)
                {
                    return redirect()->back()->with('error', __('Webhook call failed.'));
                }

            }


            return redirect()->route('custom-projects.index')->with('success', __('Project Add Successfully'). ((isset($result) && $result!=1) ? '<br> <span class="text-danger">' . $result . '</span>' : ''));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        if(\Auth::user()->can('view project'))
        {

            $usr           = Auth::user();
            if(\Auth::user()->type == 'client'){
              $user_projects = CustomProject::where('client_id',\Auth::user()->id)->pluck('id','id')->toArray();;
            }else{
              $user_projects = $usr->projects->pluck('id')->toArray();
            }
            if(in_array($project->id, $user_projects))
            {
                $project_data = [];
                // Task Count
                $tasks = CustomProject::projectTask($project->id);
                $project_task         = $tasks->count();
                $completedTask = ProjectTask::where('project_id',$project->id)->where('is_complete',1)->get();

                $project_done_task    = $completedTask->count();

                $project_data['task'] = [
                    'total' => number_format($project_task),
                    'done' => number_format($project_done_task),
                    'percentage' => Utility::getPercentage($project_done_task, $project_task),
                ];

                // end Task Count

                // Expense
                $expAmt = 0;
                foreach($project->expense as $expense)
                {
                    $expAmt += $expense->amount;
                }

                $project_data['expense'] = [
                    'allocated' => $project->budget,
                    'total' => $expAmt,
                    'percentage' => Utility::getPercentage($expAmt, $project->budget),
                ];
                // end expense


                // Users Assigned
                $total_users = User::where('created_by', '=', $usr->id)->count();


                $project_data['user_assigned'] = [
                    'total' => number_format($total_users) . '/' . number_format($total_users),
                    'percentage' => Utility::getPercentage($total_users, $total_users),
                ];
                // end users assigned

                // Day left
                $total_day                = Carbon::parse($project->start_date)->diffInDays(Carbon::parse($project->end_date));
                $remaining_day            = Carbon::parse($project->start_date)->diffInDays(now());
                $project_data['day_left'] = [
                    'day' => number_format($remaining_day) . '/' . number_format($total_day),
                    'percentage' => Utility::getPercentage($remaining_day, $total_day),
                ];
                // end Day left

                // Open Task
                    $remaining_task = ProjectTask::where('project_id', '=', $project->id)->where('is_complete', '=', 0)->where('created_by',\Auth::user()->creatorId())->count();
                    $total_task     = $project->tasks->count();

                $project_data['open_task'] = [
                    'tasks' => number_format($remaining_task) . '/' . number_format($total_task),
                    'percentage' => Utility::getPercentage($remaining_task, $total_task),
                ];
                // end open task

                // Milestone
                $total_milestone           = $project->milestones()->count();
                $complete_milestone        = $project->milestones()->where('status', 'LIKE', 'complete')->count();
                $project_data['milestone'] = [
                    'total' => number_format($complete_milestone) . '/' . number_format($total_milestone),
                    'percentage' => Utility::getPercentage($complete_milestone, $total_milestone),
                ];
                // End Milestone

                // Time spent

                    $times = $project->timesheets()->where('created_by', '=', $usr->id)->pluck('time')->toArray();
                $totaltime                  = str_replace(':', '.', Utility::timeToHr($times));
                $project_data['time_spent'] = [
                    'total' => number_format($totaltime) . '/' . number_format($totaltime),
                    'percentage' => Utility::getPercentage(number_format($totaltime), $totaltime),
                ];
                // end time spent

                // Allocated Hours
                $hrs = CustomProject::projectHrs($project->id);

                $project_data['task_allocated_hrs'] = [
                    'hrs' => number_format($hrs['allocated']) . '/' . number_format($hrs['allocated']),
                    'percentage' => Utility::getPercentage($hrs['allocated'], $hrs['allocated']),
                ];
                // end allocated hours

                // Chart
                $seven_days      = Utility::getLastSevenDays();
                $chart_task      = [];
                $chart_timesheet = [];
                $cnt             = 0;
                $cnt1            = 0;

                foreach(array_keys($seven_days) as $k => $date)
                {
                        $task_cnt     = $project->tasks()->where('is_complete', '=', 1)->whereRaw("find_in_set('" . $usr->id . "',assign_to)")->where('marked_at', 'LIKE', $date)->count();
                        $arrTimesheet = $project->timesheets()->where('created_by', '=', $usr->id)->where('date', 'LIKE', $date)->pluck('time')->toArray();

                    // Task Chart Count
                    $cnt += $task_cnt;

                    // Timesheet Chart Count
                    $timesheet_cnt = str_replace(':', '.', Utility::timeToHr($arrTimesheet));
                    $cn[]          = $timesheet_cnt;
                    $cnt1          += $timesheet_cnt;

                    $chart_task[]      = $task_cnt;
                    $chart_timesheet[] = $timesheet_cnt;
                }

                $project_data['task_chart']      = [
                    'chart' => $chart_task,
                    'total' => $cnt,
                ];
                $project_data['timesheet_chart'] = [
                    'chart' => $chart_timesheet,
                    'total' => $cnt1,
                ];

                $last_task      = TaskStage::orderBy('order', 'DESC')->where('created_by',\Auth::user()->creatorId())->first();
            
                // end chart

                return view('custom-projects.view',compact('project','project_data' , 'last_task'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if(\Auth::user()->can('edit project'))
        {
        $clients = Client::get()->pluck('name', 'id');
          $project = CustomProject::findOrfail($project->id);
          $services = Service::all();
          $project_services = ProjectService::where('project_id',$project->id)->get();
          if($project->created_by == \Auth::user()->creatorId())
          {
              return view('custom-projects.edit', compact('project', 'clients','services','project_services'));
          }
          else
          {
              return response()->json(['error' => __('Permission denied.')], 401);
          }
            return view('custom-projects.edit',compact('project','services','clients','project_services'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        if(\Auth::user()->can('edit project'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                'project_name' => 'required',
                            ]
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }
            $project = CustomProject::find($project->id);
            $project->project_name = $request->project_name;
            $project->start_date = date("Y-m-d H:i:s", strtotime($request->start_date));
            $project->end_date = date("Y-m-d H:i:s", strtotime($request->end_date));
            if($request->hasFile('project_image'))
            {
                //storage limit
                $file_path = $project->project_image;
                $image_size = $request->file('project_image')->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);

                if($result==1) {
//                Utility::checkFileExistsnDelete([$project->project_image]);
                    Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);
                    $imageName = time() . '.' . $request->project_image->extension();
                    $request->file('project_image')->storeAs('projects', $imageName);
                    $project->project_image = 'projects/' . $imageName;
                }
            }
            $old_positions = $project->positions;
            $project->budget = $request->budget;
            $project->client_id = $request->client;
            $project->positions = $request->positions;
            $project->description = $request->description;
            $project->status = $request->status;
            $project->estimated_hrs = $request->estimated_hrs;
            $project->tags = $request->tag;
            $project->save();

            if (isset($request->services)) {
                for ($i=0; $i < count($request->services); $i++) {
                    if ($request->financial_value[$i] > 0 || $request->financial_value[$i] != null || $request->financial_value[$i] != '') {
                        $project_service = ProjectService::where('project_id',$project->id)->where('service_id',$request->services[$i])->first();
                        if ($project_service == null) {
                            ProjectService::create([
                                'service_id' => $request->services[$i],
                                'financial_value' => $request->financial_value[$i],
                                'project_id' => $project->id,
                            ]);
                        }else{
                            $project_service->update([
                                'service_id' => $request->services[$i],
                                'financial_value' => $request->financial_value[$i],
                                'project_id' => $project->id,
                            ]);
                        }
                    }
                }
            }

            if ($request->positions < $old_positions) {
                ProjectPosition::where('project_id',$project->id)->truncate();
                ProjectEmployee::where('project_id',$project->id)->truncate();
                // \DB::select('delete from project_positions where project_id = '.$project->id);
                // \DB::select('delete from project_employees where project_id = '.$project->id);
            }

            return redirect()->route('custom-projects.index')->with('success', __('Project Updated Successfully'). ((isset($result) && $result!=1) ? '<br> <span class="text-danger">' . $result . '</span>' : ''));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Poject  $poject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if(\Auth::user()->can('delete project'))
        {
            if(!empty($project->project_image))
            {
                $file_path = $project->project_image;
                $result = Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);
            }
            $project->delete();
            return redirect()->back()->with('success', __('Project Successfully Deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    
    public function services($id)
    {
        $project = CustomProject::findOrfail($id);
        $project_services = ProjectService::where('project_id',$project->id)->get();
        return view('custom-projects.services', compact('project','project_services'));
    }
    
    public function deleteServices($id)
    {
        ProjectService::where('id',$id)->delete();
        return redirect()->back()->with('success', __('Project Service Successfully Deleted.'));
    }
    
    public function positions($id)
    {
        $project = CustomProject::findOrfail($id);
        $positions = Position::get()->pluck('name','id');
        $project_position = ProjectPosition::where('project_id',$project->id)->sum('position_employees_number');
        return view('custom-projects.positions', compact('project','positions','project_position'));
    }
    
    public function editPositions($id)
    {
        $project = CustomProject::findOrfail($id);
        $positions = Position::get()->pluck('name','id');
        $project_position = ProjectPosition::where('project_id',$project->id)->get();
        return view('custom-projects.edit-positions', compact('project','positions','project_position'));
    }
    
    public function deletePositions($id)
    {
        $project_position = ProjectPosition::findOrfail($id);
        $project_position->delete();
        return redirect()->back()->with('success', __('Position Deleted Successfully'));
    }
    
    public function editPosition($id,Request $request)
    {
        $project_position = ProjectPosition::findOrfail($id);
        $project = CustomProject::findOrfail($project_position->project_id);
        $position_count = $project->positions;
        $sum_position_request = $request->positions_count;
        $project_position_count = ProjectPosition::where('project_id',$project->id)->sum('position_employees_number');
        $old_position = $project_position->position_employees_number;
        if ($project_position_count <= $position_count && ($project_position_count + $sum_position_request - $old_position) <= $position_count) {
            if ($sum_position_request <= $position_count) {
                $project_position->position_employees_number = $request->positions_count;
                $project_position->project_id = $project->id;
                $project_position->save();
                return redirect()->back()->with('success', __('Position Updated Successfully'));
            }else{
                return redirect()->back()->with('error', __('The Count Of Position Should Be Or Less Than').' : '.$position_count);
            }
        }else{
            return redirect()->back()->with('error', __('The Count Of Position Should Be Or Less Than').' : '.$position_count);
        }
        
    }
    
    public function storePositions($id,Request $request)
    {
        $project = CustomProject::findOrfail($id);
        $position_count = $project->positions;
        $sum_position_request = array_sum($request->positions_count);
        $project_position_count = ProjectPosition::where('project_id',$project->id)->sum('position_employees_number');
        
        if ($project_position_count < $position_count) {
            if ($sum_position_request <= $position_count) {
                for ($i=0; $i < count($request->positions); $i++) { 
                    $project_position = ProjectPosition::where('project_id',$project->id)->where('position_id',$request->positions[$i])->first();
                    if ($project_position == null && $request->positions_count[$i] < $position_count) {
                        $position = new ProjectPosition();
                        $position->position_id = $request->positions[$i];
                        $position->project_id = $project->id;
                        $position->position_employees_number = $request->positions_count[$i];
                        $position->save();
                        return redirect()->back()->with('success', __('Project Assigned Successfully'));
                    }
                    else if ($project_position != null && $request->positions_count[$i] < $position_count) {
                        if ($project_position->position_employees_number < $position_count && ($project_position_count + $sum_position_request) < $position_count) {
                            $project_position->position_employees_number = $project_position->position_employees_number + $request->positions_count[$i];
                            $project_position->project_id = $project->id;
                            $project_position->save();
                            return redirect()->back()->with('success', __('Project Assigned Successfully'));
                        }else{
                            return redirect()->back()->with('error', __('The Count Of Position Should Be Or Less Than').' : '.$position_count);
                        }
                    }else{
                        return redirect()->back()->with('error', __('The Count Of Position Should Be Or Less Than').' : '.$position_count);
                    }
                }
                
            }else{
                return redirect()->back()->with('error', __('The Count Of Position Should Be Or Less Than').' : '.$position_count);
            }
        }else{
            return redirect()->back()->with('error', __('The Count Of Position Should Be Or Less Than').' : '.$position_count);
        }
        
    }


    public function employees($id)
    {
        $project = CustomProject::findOrfail($id);
        $project_position = ProjectPosition::where('project_id',$project->id)->get();
        $positions = Position::get()->pluck('name','id');
        $employees = Employee::all();
        return view('custom-projects.employees', compact('project','positions','project_position','employees'));
    }


    public function storeEmployees($id,Request $request)
    {
        $project = CustomProject::findOrfail($id);
        ProjectEmployee::where('project_id',$project->id)->truncate();
        foreach ($request->positions_count as $position => $employees) {
            foreach ($employees as $employee => $count) {
                if ($count > 0) {
                    $check_employee = ProjectEmployee::where('project_id',$project->id)->where('employee_id',$employee)->where('position_id',$position)->first();
                    $project_position = ProjectPosition::where('project_id',$project->id)->where('position_id',$position)->sum('position_employees_number');
                    $project_position_employee = ProjectEmployee::where('project_id',$project->id)->where('position_id',$position)->sum('count');

                    if ($count <= $project_position) {
                        if ($check_employee == null && $project_position_employee < $project_position) {
                            ProjectEmployee::create([
                                'project_id' => $project->id,
                                'employee_id' => $employee,
                                'position_id' => $position,
                                'count' => $count,
                            ]);
                        }elseif($check_employee != null){
                            $check_employee->update([
                                'project_id' => $project->id,
                                'employee_id' => $employee,
                                'position_id' => $position,
                                'count' => $count,
                            ]);
                        }else{
                            return redirect()->back()->with('error', __('The Count Of Employee is Bigger Than No. Position Need'));
                        }
                    }else{
                        return redirect()->back()->with('error', __('The Count Of Employee is Bigger Than No. Position Need'));
                    }
                }
            }
        }

        // foreach ($request->positions_count as $position => $employees) {
        //     foreach ($employees as $employee) {
        //         if ($employee != null) {
        //             $project_position_employee = ProjectEmployee::where('project_id',$project->id)->where('employee_id',$employee)->where('position_id',$position)->first();
        //             $project_position_employees = ProjectEmployee::where('project_id',$project->id)->where('position_id',$position)->count();
        //             $project_position = ProjectPosition::select(\DB::raw('SUM(position_employees_number) as position_employees_number'))->where('position_id',$position)->first();
        //             if ($project_position_employee == null || $project_position_employees < $project_position->position_employees_number) {
        //                 ProjectEmployee::create([
        //                     'project_id' => $project->id,
        //                     'employee_id' => $employee,
        //                     'position_id' => $position,
        //                 ]);
        //             }else{
        //                 $project_position_employee->update([
        //                     'project_id' => $project->id,
        //                     'employee_id' => $employee,
        //                     'position_id' => $position,
        //                 ]);
        //             }
        //         }
        //     }
        // }
        return redirect()->back()->with('success', __('Employee Assigned Successfully'));
    }

    public function editEmployees($id)
    {
        $project = CustomProject::findOrfail($id);
        $project_positions = ProjectEmployee::where('project_id',$project->id)->get();
        return view('custom-projects.edit-employees', compact('project','project_positions'));
    }
    
    public function deleteEmployees($id)
    {
        $employee = ProjectEmployee::findOrfail($id);
        $employee->delete();
        return redirect()->back()->with('success', __('Employee Deleted Successfully'));
    }
    

    public function inviteMemberView(Request $request, $project_id)
    {
        $usr          = Auth::user();
        $project      = CustomProject::find($project_id);

        $user_project = $project->users->pluck('id')->toArray();

        $user_contact = User::where('created_by', \Auth::user()->creatorId())->where('type','!=','client')->whereNOTIn('id', $user_project)->pluck('id')->toArray();
        $arrUser      = array_unique($user_contact);
        $users        = User::whereIn('id', $arrUser)->get();

        return view('custom-projects.invite', compact('project_id', 'users'));
    }

    public function inviteProjectUserMember(Request $request)
    {
        $authuser = Auth::user();

        // Make entry in project_user tbl
        ProjectUser::create(
            [
                'project_id' => $request->project_id,
                'user_id' => $request->user_id,
                'invited_by' => $authuser->id,
            ]
        );

        // Make entry in activity_log tbl
        ActivityLog::create(
            [
                'user_id' => $authuser->id,
                'project_id' => $request->project_id,
                'log_type' => 'Invite User',
                'remark' => json_encode(['title' => $authuser->name]),
            ]
        );

        return json_encode(
            [
                'code' => 200,
                'status' => 'Success',
                'success' => __('User invited successfully.'),
            ]
        );
    }





    public function destroyProject($id)
    {
        $project = CustomProject::find($id);
        $project->delete();
        return redirect()->back()->with('success', __('Project successfully deleted!'));
    }
    
    public function destroyProjectUser($id, $user_id)
    {
        $project = CustomProject::find($id);
            if($project->created_by == \Auth::user()->ownerId())
            {
                ProjectUser::where('project_id', '=', $project->id)->where('user_id', '=', $user_id)->delete();

                return redirect()->back()->with('success', __('User successfully deleted!'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }

    }

    public function loadUser(Request $request)
    {
        if($request->ajax())
        {
            $project    = CustomProject::find($request->project_id);
            $returnHTML = view('custom-projects.users', compact('project'))->render();

            return response()->json(
                [
                    'success' => true,
                    'html' => $returnHTML,
                ]
            );
        }
    }

    public function milestone($project_id)
    {
        if(\Auth::user()->can('create milestone'))
        {
            $project = CustomProject::find($project_id);

            return view('custom-projects.milestone', compact('project'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneStore(Request $request, $project_id)
    {
        if(\Auth::user()->can('create milestone'))
        {
            $project   = CustomProject::find($project_id);
            $validator = Validator::make(
                $request->all(), [
                                    'title' => 'required',
                                    'status' => 'required',
                                    'cost' => 'required',
                                    'due_date' => 'required',
                                    'start_date'=>'required'
                               ]
            );

            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }

            $milestone              = new Milestone();
            $milestone->project_id  = $project->id;
            $milestone->title       = $request->title;
            $milestone->status      = $request->status;
            $milestone->cost        = $request->cost;
            $milestone->start_date    = $request->start_date;
            $milestone->due_date    = $request->due_date;
            $milestone->description = $request->description;
            $milestone->save();

            ActivityLog::create(
                [
                    'user_id' => \Auth::user()->id,
                    'project_id' => $project->id,
                    'log_type' => 'Create Milestone',
                    'remark' => json_encode(['title' => $milestone->title]),
                ]
            );

            return redirect()->back()->with('success', __('Milestone successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneEdit($id)
    {
        if(\Auth::user()->can('edit milestone'))
        {
            $milestone = Milestone::find($id);

            return view('custom-projects.milestoneEdit', compact('milestone'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneUpdate($id, Request $request)
    {
        if(\Auth::user()->can('edit milestone'))
        {
            $validator = Validator::make(
                $request->all(), [
                                    'title' => 'required',
                                    'status' => 'required',
                                    'cost' => 'required',
                                    'due_date' => 'required',
                                    'start_date'=>'required'
                            ]
            );

            if($validator->fails())
                {
                    return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
                }

            $milestone              = Milestone::find($id);
            $milestone->title       = $request->title;
            $milestone->status      = $request->status;
            $milestone->cost        = $request->cost;
            $milestone->progress    = $request->progress;
            $milestone->due_date    = $request->duedate;
            $milestone->start_date  = $request->start_date;
            $milestone->description = $request->description;
            $milestone->save();

            return redirect()->back()->with('success', __('Milestone updated successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneDestroy($id)
    {
        if(\Auth::user()->can('delete milestone'))
        {
            $milestone = Milestone::find($id);
            $milestone->delete();

            return redirect()->back()->with('success', __('Milestone successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function milestoneShow($id)
    {
        if(\Auth::user()->can('view milestone'))
        {
            $milestone = Milestone::find($id);

            return view('custom-projects.milestoneShow', compact('milestone'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function filterProjectView(Request $request)
    {

        if(\Auth::user()->can('manage project'))
        {
            $usr           = Auth::user();
            $user_projects = CustomProject::where('created_by',\Auth::user()->creatorId())->pluck('id','id')->toArray();
            // if(\Auth::user()->type == 'client'){
            //   $user_projects = CustomProject::where('client_id',\Auth::user()->id)->where('created_by',\Auth::user()->creatorId())->pluck('id','id')->toArray();
            // }else{
            //   $user_projects = $usr->projects()->pluck('project_id', 'project_id')->toArray();
            // }
            if($request->ajax() && $request->has('view') && $request->has('sort'))
            {
                $sort     = explode('-', $request->sort);
                $projects = CustomProject::whereIn('id', array_keys($user_projects))->orderBy($sort[0], $sort[1]);

                if(!empty($request->keyword))
                {
                    $projects->where('project_name', 'LIKE', $request->keyword . '%')->orWhereRaw('FIND_IN_SET("' . $request->keyword . '",tags)');
                }
                if(!empty($request->status))
                {
                    $projects->whereIn('status', $request->status);
                }
                $projects   = $projects->get();
                $last_task      = TaskStage::orderBy('order', 'DESC')->where('created_by',\Auth::user()->creatorId())->first();
                
                $returnHTML = view('custom-projects.' . $request->view, compact('projects', 'user_projects', 'last_task'))->render();

                return response()->json(
                    [
                        'success' => true,
                        'html' => $returnHTML,
                    ]
                );
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    // Project Gantt Chart
    public function gantt($projectID, $duration = 'Week')
    {
        if(\Auth::user()->can('view grant chart'))
        {
            $project = CustomProject::find($projectID);
            $tasks   = [];

            if($project)
            {
                $tasksobj = $project->tasks;

                foreach($tasksobj as $task)
                {
                    $tmp                 = [];
                    $tmp['id']           = 'task_' . $task->id;
                    $tmp['name']         = $task->name;
                    $tmp['start']        = $task->start_date;
                    $tmp['end']          = $task->end_date;
                    $tmp['custom_class'] = (empty($task->priority_color) ? '#ecf0f1' : $task->priority_color);
                    $tmp['progress']     = str_replace('%', '', $task->taskProgress($task)['percentage']);
                    $tmp['extra']        = [
                        'priority' => ucfirst(__($task->priority)),
                        'comments' => count($task->comments),
                        'duration' => Utility::getDateFormated($task->start_date) . ' - ' . Utility::getDateFormated($task->end_date),
                    ];
                    $tasks[]             = $tmp;
                }
            }

            return view('custom-projects.gantt', compact('project', 'tasks', 'duration'));
        }

        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function ganttPost($projectID, Request $request)
    {
        $project = CustomProject::find($projectID);

        if($project)
        {
            if(\Auth::user()->can('view project task'))
            {
                $id               = trim($request->task_id, 'task_');
                $task             = ProjectTask::find($id);
                $task->start_date = $request->start;
                $task->end_date   = $request->end;
                $task->save();

                return response()->json(
                    [
                        'is_success' => true,
                        'message' => __("Time Updated"),
                    ], 200
                );
            }
            else
           {
                return response()->json(
                    [
                        'is_success' => false,
                        'message' => __("You can't change Date!"),
                    ], 400
                );
            }
        }
        else
        {
            return response()->json(
                [
                    'is_success' => false,
                    'message' => __("Something is wrong."),
                ], 400
            );
        }
    }

    public function bug($project_id)
    {


        $user = Auth::user();
        if($user->can('manage bug report'))
        {
            $project = CustomProject::find($project_id);

            if(!empty($project) && $project->created_by == Auth::user()->creatorId())
            {

                if($user->type != 'company')
                {
                    if(\Auth::user()->type == 'client'){
                      $bugs = Bug::where('project_id',$project->id)->get();
                    }else{
                      $bugs = Bug::where('project_id',$project->id)->whereRaw("find_in_set('" . $user->id . "',assign_to)")->get();
                    }
                }

                if($user->type == 'company')
                {
                    $bugs = Bug::where('project_id', '=', $project_id)->get();
                }

                return view('custom-projects.bug', compact('project', 'bugs'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function bugCreate($project_id)
    {
        if(\Auth::user()->can('create bug report'))
        {

            $priority     = Bug::$priority;
            $status       = BugStatus::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('title', 'id');
            $project_user = ProjectUser::where('project_id', $project_id)->get();
            
            $users        = [];
            foreach($project_user as $key=>$user)
            {

                $user_data = User::find($user->user_id);
                $key = $user->user_id;
                $user_name = !empty($user_data)? $user_data->name:'';
                $users[$key] = $user_name;
            }

            return view('custom-projects.bugCreate', compact('status', 'project_id', 'priority', 'users'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }

    }

    function bugNumber()
    {
        $latest = Bug::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->bug_id + 1;
    }

    public function bugStore(Request $request, $project_id)
    {
        if(\Auth::user()->can('create bug report'))
        {
            $validator = \Validator::make(
                $request->all(), [

                                   'title' => 'required',
                                   'priority' => 'required',
                                   'status' => 'required',
                                   'assign_to' => 'required',
                                   'start_date' => 'required',
                                   'due_date' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('task.bug', $project_id)->with('error', $messages->first());
            }

            $usr         = \Auth::user();
            $userProject = ProjectUser::where('project_id', '=', $project_id)->pluck('user_id')->toArray();
            $project     = CustomProject::where('id', '=', $project_id)->first();

            $bug              = new Bug();
            $bug->bug_id      = $this->bugNumber();
            $bug->project_id  = $project_id;
            $bug->title       = $request->title;
            $bug->priority    = $request->priority;
            $bug->start_date  = $request->start_date;
            $bug->due_date    = $request->due_date;
            $bug->description = $request->description;
            $bug->status      = $request->status;
            $bug->assign_to   = $request->assign_to;
            $bug->created_by  = \Auth::user()->creatorId();
            $bug->save();

            ActivityLog::create(
                [
                    'user_id' => $usr->id,
                    'project_id' => $project_id,
                    'log_type' => 'Create Bug',
                    'remark' => json_encode(['title' => $bug->title]),
                ]
            );

            $projectArr = [
                'project_id' => $project_id,
                'name' => $project->name,
                'updated_by' => $usr->id,
            ];

            return redirect()->route('task.bug', $project_id)->with('success', __('Bug successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function bugEdit($project_id, $bug_id)
    {
        if(\Auth::user()->can('edit bug report'))
        {
            $bug          = Bug::find($bug_id);
            $priority     = Bug::$priority;
            $status       = BugStatus::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('title', 'id');
            $project_user = ProjectUser::where('project_id', $project_id)->get();
            $users        = array();
            foreach($project_user as $user)
            {
              $user_data = User::where('id',$user->user_id)->first();
              $key = $user->user_id;
              $user_name = !empty($user_data) ? $user_data->name:'';
              $users[$key] = $user_name;
            }

            return view('custom-projects.bugEdit', compact('status', 'project_id', 'priority', 'users', 'bug'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }

    public function bugUpdate(Request $request, $project_id, $bug_id)
    {


        if(\Auth::user()->can('edit bug report'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'title' => 'required',
                                   'priority' => 'required',
                                   'status' => 'required',
                                   'assign_to' => 'required',
                                   'start_date' => 'required',
                                   'due_date' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('task.bug', $project_id)->with('error', $messages->first());
            }
            $bug              = Bug::find($bug_id);
            $bug->title       = $request->title;
            $bug->priority    = $request->priority;
            $bug->start_date  = $request->start_date;
            $bug->due_date    = $request->due_date;
            $bug->description = $request->description;
            $bug->status      = $request->status;
            $bug->assign_to   = $request->assign_to;
            $bug->save();

            return redirect()->route('task.bug', $project_id)->with('success', __('Bug successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function bugDestroy($project_id, $bug_id)
    {


        if(\Auth::user()->can('delete bug report'))
        {
            $bug = Bug::find($bug_id);
            $bug->delete();

            return redirect()->route('task.bug', $project_id)->with('success', __('Bug successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function bugKanban($project_id)
    {

        $user = Auth::user();
        if($user->can('move bug report'))
        {

            $project = CustomProject::find($project_id);

            if(!empty($project) && $project->created_by == $user->creatorId())
            {
                if($user->type != 'company')
                {
                    $bugStatus = BugStatus::where('created_by', '=', Auth::user()->creatorId())->orderBy('order', 'ASC')->get();
                }

                if($user->type == 'company' || $user->type == 'client')
                {
                    $bugStatus = BugStatus::where('created_by', '=', Auth::user()->creatorId())->orderBy('order', 'ASC')->get();
                }

                return view('custom-projects.bugKanban', compact('project', 'bugStatus'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function bugKanbanOrder(Request $request)
    {
//        dd($request->all());
        if(\Auth::user()->can('move bug report'))
        {
            $post   = $request->all();
            $bug    = Bug::find($post['bug_id']);

            $status = BugStatus::find($post['status_id']);

            if(!empty($status))
            {
                $bug->status = $post['status_id'];
                $bug->save();
            }

            foreach($post['order'] as $key => $item)
            {
                if($item != 'null'){
                    $bug_order         = Bug::find($item);
                    if(!empty($bug_order)){
                        $bug_order->order  = $key;
                        $bug_order->status = $post['status_id'];
                        $bug_order->save();
                    }
                }
            }

        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }


    }

    public function bugShow($project_id, $bug_id)
    {
        $bug = Bug::find($bug_id);

        return view('custom-projects.bugShow', compact('bug'));
    }

    public function bugCommentStore(Request $request, $project_id, $bug_id)
    {

        $post               = [];
        $post['bug_id']     = $bug_id;
        $post['comment']    = $request->comment;
        $post['created_by'] = \Auth::user()->authId();
        $post['user_type']  = \Auth::user()->type;
        $comment            = BugComment::create($post);
        $comment->deleteUrl = route('bug.comment.destroy', [$comment->id]);

        return response()->json(
            [
                'is_success' => true,
                'message' => __("Bug comment successfully created."),
                'data'=>$comment
            ], 200
        );
    }

    public function bugCommentDestroy($comment_id)
    {
        $comment = BugComment::find($comment_id);
        $comment->delete();

        return "true";
    }

    public function bugCommentStoreFile(Request $request, $bug_id)
    {
        $request->validate(
            ['file' => 'required']
        );
        $fileName = $bug_id . time() . "_" . $request->file->getClientOriginalName();

        $request->file->storeAs('bugs', $fileName);
        $post['bug_id']     = $bug_id;
        $post['file']       = $fileName;
        $post['name']       = $request->file->getClientOriginalName();
        $post['extension']  = "." . $request->file->getClientOriginalExtension();
        $post['file_size']  = round(($request->file->getSize() / 1024) / 1024, 2) . ' MB';
        $post['created_by'] = \Auth::user()->authId();
        $post['user_type']  = \Auth::user()->type;

        $BugFile            = BugFile::create($post);
        $BugFile->deleteUrl = route('bug.comment.file.destroy', [$BugFile->id]);

        return $BugFile->toJson();
    }

    public function bugCommentDestroyFile(Request $request, $file_id)
    {
        $commentFile = BugFile::find($file_id);
        $path        = storage_path('bugs/' . $commentFile->file);
        if(file_exists($path))
        {
            \File::delete($path);
        }
        $commentFile->delete();

        return "true";
    }

    public function tracker($id)
    {
        $treckers =TimeTracker::where('project_id',$id)->get();
        return view('time_trackers.index',compact('treckers'));
    }

    public function getProjectChart($arrParam)
    {
        $arrDuration = [];
        if ($arrParam['duration'] && $arrParam['duration'] == 'week') {
            $previous_week = Utility::getFirstSeventhWeekDay(-1);
            foreach ($previous_week['datePeriod'] as $dateObject) {
                $arrDuration[$dateObject->format('Y-m-d')] = $dateObject->format('D');
            }
        }

        $arrTask = [
            'label' => [],
            'color' => [],
        ];
        $stages = TaskStage::where('created_by', '=', $arrParam['created_by'])->orderBy('order');

        foreach ($arrDuration as $date => $label) {
            $objProject = projectTask::select('stage_id', \DB::raw('count(*) as total'))->whereDate('updated_at', '=', $date)->groupBy('stage_id');

            if (isset($arrParam['project_id'])) {
                $objProject->where('project_id', '=', $arrParam['project_id']);
            }


            $data = $objProject->pluck('total', 'stage_id')->all();

            foreach ($stages->pluck('name', 'id')->toArray() as $id => $stage) {
                $arrTask[$id][] = isset($data[$id]) ? $data[$id] : 0;
            }
            $arrTask['label'][] = __($label);
        }
        $arrTask['stages'] = $stages->pluck('name', 'id')->toArray();

        return $arrTask;
    }

    //project duplicate module
    public function copyproject($id)
    {
        if(Auth::user()->can('create project'))
        {
            $project = CustomProject::find($id);

            return view('custom-projects.copy',compact('project'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function copyprojectstore(Request $request,$id)
    {

        if(Auth::user()->can('create project'))
        {
            $project                            = CustomProject::find($id);
            $duplicate                          = new CustomProject();
            $duplicate['project_name']          = $project->project_name;
            $duplicate['status']                = $project->status;
            $duplicate['project_image']         = $project->project_image;
            $duplicate['client_id']             = $project->client_id;
            $duplicate['description']           = $project->description;
            $duplicate['start_date']            = $project->start_date;
            $duplicate['end_date']              = $project->end_date;
            $duplicate['estimated_hrs']         = $project->estimated_hrs;
            $duplicate['created_by']            = \Auth::user()->creatorId();
            $duplicate->save();



            if(isset($request->user) && in_array("user", $request->user)){
                $users = ProjectUser::where('project_id',$project->id)->get();
                foreach($users as $user){
                    $users = new ProjectUser();
                    $users['user_id'] = $user->user_id;
                    $users['project_id'] = $duplicate->id;
                    $users->save();
                }
            }
            else{
                $objUser = Auth::user();
                $users              = new ProjectUser();
                $users['user_id']   = $objUser->id;
                $users['project_id']= $duplicate->id;
                $users->save();
            }


            if(isset($request->task) && in_array("task", $request->task)){

                $tasks = ProjectTask::where('project_id',$project->id)->get();

                foreach($tasks as $task){
                    $project_task                   = new ProjectTask();
                    $project_task['name']           = $task->name;
                    $project_task['description']    = $task->description;
                    $project_task['estimated_hrs']  = $task->estimated_hrs;
                    $project_task['start_date']     = $task->start_date;
                    $project_task['end_date']       = $task->end_date;
                    $project_task['priority']       = $task->priority;
                    $project_task['priority_color'] = $task->priority_color;
                    $project_task['assign_to']      = $task->assign_to;
                    $project_task['project_id']     = $duplicate->id;
                    $project_task['milestone_id']   = $task->milestone_id;
                    $project_task['stage_id']       = $task->stage_id;
                    $project_task['order']          = $task->order;
                    $project_task['created_by']     = \Auth::user()->creatorId();
                    $project_task['is_favourite']   = $task->is_favourite;
                    $project_task['is_complete']    = $task->is_complete;
                    $project_task['marked_at']      = $task->marked_at;
                    $project_task['progress']       = $task->progress;
                    $project_task->save();


                    if(in_array("task_comment",$request->task)){
                        $task_comments = TaskComment::where('task_id',$task->id)->get();
                        foreach($task_comments as $task_comment){
                            $comment                = new TaskComment();
                            $comment['comment']     = $task_comment->comment;
                            $comment['task_id']     = $project_task->id;
                            $comment['user_id']     = !empty($task_comment)? $task_comment->user_id :0;
                            $comment['user_type']   = $task_comment->user_type;
                            $comment['created_by']  = $task_comment->created_by;
                            $comment->save();
                        }

                    }
                    if(in_array("task_files",$request->task)){
                        $task_files = TaskFile::where('task_id',$task->id)->get();
                        foreach($task_files as $task_file){
                            $file               = new TaskFile();
                            $file['file']       = $task_file->file;
                            $file['name']       = $task_file->name;
                            $file['extension']  = $task_file->extension;
                            $file['file_size']  = $task_file->file_size;
                            $file['created_by'] = $task_file->created_by;
                            $file['task_id']    = $project_task->id;
                            $file['user_type']  = $task_file->user_type;
                            $file->save();
                        }
                    }
                }
            }
            if(isset($request->bug) && in_array("bug", $request->bug)){
                $bugs = Bug::where('project_id',$project->id)->get();

                foreach($bugs as $bug){
                    $project_bug                   = new Bug();
                    $project_bug['bug_id']          = $bug->bug_id;
                    $project_bug['project_id']     = $duplicate->id;
                    $project_bug['title']          = $bug->title;
                    $project_bug['priority']       = $bug->priority;
                    $project_bug['start_date']          = $bug->start_date;
                    $project_bug['due_date']          = $bug->due_date;
                    $project_bug['description']    = $bug->description;
                    $project_bug['status']         = $bug->status;
                    $project_bug['order']          = $bug->order;
                    $project_bug['assign_to']      = $bug->assign_to;
                    $project_bug['created_by']         = \Auth::user()->creatorId();
                    $project_bug->save();

                    if(in_array("bug_comment",$request->bug)){
                        $bug_comments = BugComment::where('bug_id',$bug->id)->get();
                        foreach($bug_comments as $bug_comment){
                            $bugcomment                 = new BugComment();
                            $bugcomment['comment']      = $bug_comment->comment;
                            $bugcomment['bug_id']       = $project_bug->id;
                            $bugcomment['user_type']    = $bug_comment->user_type;
                            $bugcomment['created_by']   = $bug_comment->created_by;
                            $bugcomment->save();
                        }

                    }
                    if(in_array("bug_files",$request->bug)){
                        $bug_files = BugFile::where('bug_id',$bug->id)->get();

                        foreach($bug_files as $bug_file){
                            $bugfile               = new BugFile();
                            $bugfile['file']       = $bug_file->file;
                            $bugfile['name']       = $bug_file->name;
                            $bugfile['extension']  = $bug_file->extension;
                            $bugfile['file_size']  = $bug_file->file_size;
                            $bugfile['bug_id']     = $project_bug->id;
                            $bugfile['user_type']  = $bug_file->user_type;
                            $bugfile['created_by'] = $bug_file->created_by;
                            $bugfile->save();
                        }
                    }
                }
            }
            if(isset($request->milestone) && in_array("milestone", $request->milestone)){
                $milestones = Milestone::where('project_id',$project->id)->get();

                foreach ($milestones as $milestone) {
                    $post                   = new Milestone();
                    $post['project_id']     = $duplicate->id;
                    $post['title']          = $milestone->title;
                    $post['status']         = $milestone->status;
                    $post['due_date']       = $milestone->due_date;
                    $post['start_date']     = $milestone->start_date;
                    $post['cost']           = $milestone->cost;
                    $post['progress']       = $milestone->progress;
                    $post->save();
                }
            }
            if(isset($request->project_file) && in_array("project_file",$request->project_file)){
                $project_files = TaskFile::where('task_id',$task->id)->get();
//                dd($project_files);
                foreach ($project_files as $project_file) {
                    $ProjectFile                = new TaskFile();
                    $ProjectFile['task_id']  = $duplicate->id;
                    $ProjectFile['file']   = $project_file->file;
                    $ProjectFile['name']   = $project_file->name;
                    $ProjectFile['extension']   = $project_file->extension;
                    $ProjectFile['file_size']   = $project_file->file_size;
                    $ProjectFile['user_type']   = $project_file->user_type;
                    $ProjectFile['created_by']   = $project_file->created_by;
                    $ProjectFile->save();
                }
            }
            if(isset($request->activity) && in_array('activity',$request->activity))
            {
                $where_in_array = [];
                if( isset($request->milestone) && in_array("milestone", $request->milestone))
                {
                    array_push($where_in_array,"Create Milestone");
                }
                if(isset($request->task) && in_array("task", $request->task))
                {
                    array_push($where_in_array,"Create Task","Move");
                }
                if(isset($request->bug) && in_array("bug", $request->bug))
                {
                    array_push($where_in_array,"Create Bug","Move Bug");
                }
//                if(isset($request->client) && in_array("client", $request->client))
//                {
//                    array_push($where_in_array,"Share with Client");
//                }
                if(isset($request->user) && in_array("user", $request->user))
                {
                    array_push($where_in_array,"Invite User");
                }
                if(isset($request->project_file) && in_array("project_file", $request->project_file))
                {
                    array_push($where_in_array,"Upload File");
                }
                if(count($where_in_array) > 0)
                {
                    $activities = ActivityLog::where('project_id',$project->id)->whereIn('log_type',$where_in_array)->get();

                    foreach($activities as $activity){
                        $activitylog                = new ActivityLog();
                        $activitylog['user_id']     = $activity->user_id;
                        $activitylog['project_id']  = $duplicate->id;
                        $activitylog['project_id']  = $duplicate->id;
                        $activitylog['log_type']    = $activity->log_type;
                        $activitylog['remark']      = $activity->remark;
                        $activitylog->save();
                    }
                }
            }
            return redirect()->back()->with('success', 'Project Created Successfully');
        }
        else
        {
            return redirect()->back()->with('error', 'permission Denied');
        }

    }

    //share project module

    public function copylink_setting_create( $projectID)
    {
        $objUser = Auth::user();
        $project = CustomProject::select('custom-projects.*')->join('project_users', 'custom-projects.id', '=', 'project_users.project_id')->where('project_users.user_id', '=', $objUser->id)->where('custom-projects.id', '=', $projectID)->first();
        $result = json_decode($project->copylinksetting);
        return view('custom-projects.copylink_setting', compact('project','projectID','result'));
    }

    public function copylinksetting(Request $request, $id  )
    {
        $objUser = Auth::user();

        $data = [];
        $data['basic_details']  = isset($request->basic_details) ? 'on' : 'off';
        $data['member']  = isset($request->member) ? 'on' : 'off';
        $data['milestone']  = isset($request->milestone) ? 'on' : 'off';
        $data['client']  = isset($request->client) ? 'on' : 'off';
        $data['progress']  = isset($request->progress) ? 'on' : 'off';
        $data['activity']  = isset($request->activity) ? 'on' : 'off';
        $data['attachment']  = isset($request->attachment) ? 'on' : 'off';
        $data['bug_report']  = isset($request->bug_report) ? 'on' : 'off';
        $data['expense']  = isset($request->expense) ? 'on' : 'off';
        $data['task']  = isset($request->task) ? 'on' : 'off';
        $data['tracker_details']  = isset($request->tracker_details) ? 'on' : 'off';
        $data['timesheet']  = isset($request->timesheet) ? 'on' : 'off';
        $data['password_protected']  = isset($request->password_protected) ? 'on' : 'off';
        $project = CustomProject::select('custom-projects.*')
            ->join('project_users', 'custom-projects.id', '=', 'project_users.project_id')
            ->where('project_users.user_id', '=', $objUser->id)
            ->where('custom-projects.id', '=', $id)->first();

        if(isset($request->password_protected) && $request->password_protected == 'on' ){
            $project->password = base64_encode($request->password);

        }else{
            $project->password = null;
        }


        $project->copylinksetting = (count($data) > 0 ) ? json_encode($data) : null;
        $project->save();
        return redirect()->back()->with('success', __('Copy Link Setting Save Successfully!'));
    }

    public function projectlink(Request $request,$project_id, $lang='')
    {
        try {
            $id=\Illuminate\Support\Facades\Crypt::decrypt($project_id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Project Not Found.'));
        }

        $id=\Illuminate\Support\Facades\Crypt::decrypt($project_id);

        $project = CustomProject::find($id);

        $data = [];
        $data['basic_details']  = isset($request->basic_details) ? 'on' : 'off';
        $data['member']  = isset($request->member) ? 'on' : 'off';
        $data['milestone']  = isset($request->milestone) ? 'on' : 'off';
        $data['activity']  = isset($request->activity) ? 'on' : 'off';
        $data['attachment']  = isset($request->attachment) ? 'on' : 'off';
        $data['bug_report']  = isset($request->bug_report) ? 'on' : 'off';
        $data['expense']  = isset($request->expense) ? 'on' : 'off';
        $data['task']  = isset($request->task) ? 'on' : 'off';
        $data['tracker_details']  = isset($request->tracker_details) ? 'on' : 'off';
        $data['timesheet']  = isset($request->timesheet) ? 'on' : 'off';
        $data['password_protected']  = isset($request->password_protected) ? 'on' : 'off';


        if(Auth::user() != null){
            $usr         = Auth::user();
        }else{
            $usr         = User::where('id',$project->created_by)->first();
        }

        $user_projects = $usr->projects->pluck('id')->toArray();

        $project_data = [];

        // Task Count
        $project_task         = $project->tasks->count();

        $project_done_task    = $project->tasks->where('is_complete', '=', 1)->count();

        $project_data['task'] = [
            'total' => number_format($project_task),
            'done' => number_format($project_done_task),
            'percentage' => Utility::getPercentage($project_done_task, $project_task),
        ];

        // end Task Count


        // Users Assigned
        $total_users = User::where('created_by', '=', $usr->id)->count();

        $project_data['user_assigned'] = [
            'total' => number_format($total_users) . '/' . number_format($total_users),
            'percentage' => Utility::getPercentage($total_users, $total_users),
        ];
        // End Users Assigned


        // Day left
        $total_day   = Carbon::parse($project->start_date)->diffInDays(Carbon::parse($project->end_date));
        $remaining_day = Carbon::parse($project->start_date)->diffInDays(now());
        $project_data['day_left'] = [
            'day' => number_format($remaining_day) . '/' . number_format($total_day),
            'percentage' => Utility::getPercentage($remaining_day, $total_day),
        ];
        // end day left

        if($usr->checkProject($project->id) == 'Owner')
        {
            $remaining_task = ProjectTask::where('project_id', '=', $project->id)->where('is_complete', '=', 0)->count();
            $total_task     = ProjectTask::where('project_id', '=', $project->id)->count();
        }
        else
        {
            $remaining_task = ProjectTask::where('project_id', '=', $project->id)->where('is_complete', '=', 0)->whereRaw("find_in_set('" . $usr->id . "',assign_to)")->count();
            $total_task     = ProjectTask::where('project_id', '=', $project->id)->whereRaw("find_in_set('" . $usr->id . "',assign_to)")->count();
        }
        $project_data['open_task'] = [
            'tasks' => number_format($remaining_task) . '/' . number_format($total_task),
            'percentage' => Utility::getPercentage($remaining_task, $total_task),
        ];

        // Milestone
        $total_milestone           = $project->milestones()->count();

        $complete_milestone        = $project->milestones()->where('status', 'LIKE', 'complete')->count();
        $project_data['milestone'] = [
            'total' => number_format($complete_milestone) . '/' . number_format($total_milestone),
            'percentage' => Utility::getPercentage($complete_milestone, $total_milestone),
        ];
        // End Milestone


        // Chart
        $seven_days      = Utility::getLastSevenDays();
        $chart_task      = [];
        $chart_timesheet = [];
        $cnt             = 0;
        $cnt1            = 0;

        foreach(array_keys($seven_days) as $k => $date)
        {
            if($usr->checkProject($project->id) == 'Owner')
            {
                $task_cnt     = $project->tasks()->where('is_complete', '=', 1)->where('marked_at', 'LIKE', $date)->count();
                $arrTimesheet = $project->timesheets()->where('date', 'LIKE', $date)->pluck('time')->toArray();
            }
            else
            {
                $task_cnt     = $project->tasks()->where('is_complete', '=', 1)->whereRaw("find_in_set('" . $usr->id . "',assign_to)")->where('marked_at', 'LIKE', $date)->count();
                $arrTimesheet = $project->timesheets()->where('created_by', '=', $usr->id)->where('date', 'LIKE', $date)->pluck('time')->toArray();
            }

            // Task Chart Count
            $cnt += $task_cnt;

            // Timesheet Chart Count
            $timesheet_cnt = str_replace(':', '.', Utility::timeToHr($arrTimesheet));
            $cn[]          = $timesheet_cnt;
            $cnt1          += number_format($timesheet_cnt, 2);

            $chart_task[]      = $task_cnt;
            $chart_timesheet[] = number_format($timesheet_cnt, 2);
        }

        // Allocated Hours
        $hrs                                = CustomProject::projectHrs($project->id);


        $project_data['task_allocated_hrs'] = [
            'hrs' => number_format($hrs['allocated']) . '/' . number_format($hrs['allocated']),
            'percentage' => Utility::getPercentage($hrs['allocated'], $hrs['allocated']),
        ];

        // end allocated hours

        // Time spent
        if($usr->checkProject($project->id) == 'Owner')
        {
            $times = $project->timesheets->pluck('time')->toArray();
        }
        else
        {
            $times = $project->timesheets()->where('created_by', '=', $usr->id)->pluck('time')->toArray();
        }
        $totaltime                  = str_replace(':', '.', Utility::timeToHr($times));
        $estimatedtime              = $project->estimated_hrs != '' ? $project->estimated_hrs : '0';
        $project_data['time_spent'] = [
            'total' => number_format($totaltime) . '/' . number_format($estimatedtime),
            'percentage' => Utility::getPercentage(number_format($totaltime), $estimatedtime),
        ];
        // end time spent

        $project_data['task_chart']      = [
            'chart' => $chart_task,
            'total' => $cnt,
        ];

        $project_data['timesheet_chart'] = [
            'chart' => $chart_timesheet,
            'total' => $cnt1,
        ];
        if(isset($request->milestone) && in_array("milestone", $request->milestone)){
            $milestones = Milestone::where('project_id',$project->id)->get();

            foreach ($milestones as $milestone) {

                $post                   = new Milestone();
                $post['project_id']     = $milestone->id;
                $post['title']          = $milestone->title;
                $post['status']         = $milestone->status;
                $post['description']    = $milestone->description;
                $post->save();
            }
        }

        if(isset($request->task) && in_array("task", $request->task)){
            $tasks = ProjectTask::where('project_id',$project->id)->where('stage_id',$stage->id)->get();
            $activities = ActivityLog::where('project_id',$project->id)->where('task_id',$task->id)->get();

            foreach($activities as $activity){

                $activitylog                = new ActivityLog();
                $activitylog['user_id']     = $activity->user_id;
                $activitylog['project_id']  = $activity->id;
                $activitylog['task_id']     = $activity->id;
                $activitylog['log_type']    = $activity->log_type;
                $activitylog['remark']      = $activity->remark;
                $activitylog->save();
            }
        }

        $stages = TaskStage::where('project_id', '=', $id)->orderBy('order')->get();
        foreach ($stages as &$status)
        {
            $stageClass[] = 'task-list-' . $status->id;
            $task = ProjectTask::where('project_id', '=', $id);

            // check project is shared or owner
            if ($usr->checkProject($project_id) == 'Shared') {
                $task->whereRaw(
                    "find_in_set('" . $usr->id . "',assign_to)"
                );
            }
            //end

            $task->orderBy('order');
            $status['tasks'] = $task ->where('stage_id', '=', $status->id) ->get();
        }

        $treckers=TimeTracker::where('project_id',$id)->where('created_by',$usr->id)->get();

        //bug report

            $bugs = Bug::where('project_id',$project->id)->get();


        //task
        $tasks = ProjectTask::where('project_id',$project->id)->get();

        //lang


        $lang = !empty($lang) ? $lang : (!empty($usr->lang) ? $usr->lang : env('DEFAULT_ADMIN_LANG')) ;

        \App::setLocale($lang);

//        dd($lang);



        if(\Session::get('copy_pass_true'. $id) == $project->password . '-' . $id)
        {

            return view('custom-projects.copylink', compact('data','project','project_data','stages','treckers','usr','bugs','tasks','lang'));
        }else
        {

            if(!isset(json_decode($project->copylinksetting)->password_protected) || json_decode($project->copylinksetting)->password_protected != 'on')
            {

                return view('custom-projects.copylink', compact('data','project','project_data','stages','treckers','usr','lang','tasks','bugs'));

            }elseif(isset(json_decode($project->copylinksetting)->password_protected) && json_decode($project->copylinksetting)->password_protected == 'on' && $request->password == base64_decode($project->password)){

                \Session::put('copy_pass_true'.$id, $project->password . '-' . $id);


                return view('custom-projects.copylink', compact('data','project','project_data','stages','treckers','usr','lang','bugs','tasks'));

            }else{


                return view('custom-projects.copylink_password', compact('id'));
            }
        }

    }









}
