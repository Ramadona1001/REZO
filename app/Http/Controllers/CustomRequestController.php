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
use App\Models\CustomRequest;
use App\Models\CustomRequestPosition;
use App\Models\Designation;
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

class CustomRequestController extends Controller
{
    function positionNumber()
    {
        $latest = CustomRequest::latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->id + 1;
    }

    public function index($view = 'list')
    {
        if(\Auth::user()->can('manage custom request'))
        {
            $positions = Position::where('created_by',auth()->user()->id)->get()->pluck('name','id');
            $units = Designation::where('created_by',auth()->user()->id)->get();
            return view('custom_requests.index', compact('view','positions','units'));
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
        if(\Auth::user()->can('create custom request'))
        {
            $positions = Position::where('created_by',auth()->user()->id)->get();
            $units = Designation::where('created_by',auth()->user()->id)->get();
            $projectId      = idFormat('custom_request',$this->positionNumber());
            return view('custom_requests.create', compact('units','positions','projectId'));
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
        if(\Auth::user()->can('create custom request'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                'request_name' => 'required',
                            ]
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }
            $custom_request = new CustomRequest();
            $custom_request->request_name = $request->request_name;
            $custom_request->positions = $request->positions;
            $custom_request->unit_position = $request->unit_position;
            $custom_request->description = $request->description;
            $custom_request->status = $request->status;
            $custom_request->budget = $request->budget;
            $custom_request->created_by = \Auth::user()->creatorId();

            $custom_request->save();

            
            return redirect()->route('customs.index')->with('success', __('Custom Request Add Successfully'). ((isset($result) && $result!=1) ? '<br> <span class="text-danger">' . $result . '</span>' : ''));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function edit(CustomRequest $custom)
    {
        if(\Auth::user()->can('edit custom request'))
        {
          $custom_request = CustomRequest::findOrfail($custom->id);
          $positions = Position::where('created_by',auth()->user()->id)->get();
          $units = Designation::where('created_by',auth()->user()->id)->get();
          $projectId      = idFormat('custom_request',$this->positionNumber());
          if($custom_request->created_by == \Auth::user()->creatorId())
          {
              return view('custom_requests.edit', compact('custom_request', 'positions','units','projectId'));
          }
          else
          {
              return response()->json(['error' => __('Permission denied.')], 401);
          }
            return view('custom_requests.edit',compact('custom_request', 'positions','units','projectId'));
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
    public function update(Request $request, CustomRequest $custom)
    {
        if(\Auth::user()->can('edit custom request'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                'request_name' => 'required',
                            ]
            );
            if($validator->fails())
            {
                return redirect()->back()->with('error', Utility::errorFormat($validator->getMessageBag()));
            }
            $custom_request = CustomRequest::find($custom->id);
            $custom_request->request_name = $request->request_name;
            $custom_request->positions = $request->positions;
            $custom_request->unit_position = $request->unit_position;
            $custom_request->description = $request->description;
            $custom_request->status = $request->status;
            $custom_request->budget = $request->budget;


            return redirect()->route('customs.index')->with('success', __('Custom Request Updated Successfully'). ((isset($result) && $result!=1) ? '<br> <span class="text-danger">' . $result . '</span>' : ''));

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
    public function destroy(CustomRequest $custom)
    {
        if(\Auth::user()->can('delete custom requests'))
        {
            $custom->delete();
            return redirect()->back()->with('success', __('Custom Request Successfully Deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function filterCustomView(Request $request)
    {

        if(\Auth::user()->can('manage custom request'))
        {
            $usr           = Auth::user();
            $user_custom_requests = CustomRequest::where('created_by',\Auth::user()->creatorId())->pluck('id','id')->toArray();
            if($request->ajax() && $request->has('view') && $request->has('sort'))
            {
                $sort     = explode('-', $request->sort);
                $custom_requests = CustomRequest::whereIn('id', array_keys($user_custom_requests))->orderBy($sort[0], $sort[1]);
                
                if(!empty($request->keyword))
                {
                    $custom_requests->where('request_name', 'LIKE', $request->keyword . '%')->orWhereRaw('FIND_IN_SET("' . $request->keyword . '",tags)');
                }
                if(!empty($request->status))
                {
                    $custom_requests->whereIn('status', $request->status);
                }
                $custom_requests   = $custom_requests->get();
                $last_task      = TaskStage::orderBy('order', 'DESC')->where('created_by',\Auth::user()->creatorId())->first();
                
                $returnHTML = view('custom_requests.' . $request->view, compact('custom_requests', 'user_custom_requests', 'last_task'))->render();

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

    public function positions($id)
    {
        $custom_request = CustomRequest::findOrfail($id);
        $positions = Position::get()->pluck('name','id');
        $custom_request_position = CustomRequestPosition::where('custom_request_id',$custom_request->id)->sum('position_employees_number');
        return view('custom_requests.positions', compact('custom_request','positions','custom_request_position'));
    }
    
    public function editPositions($id)
    {
        $custom_request = CustomRequest::findOrfail($id);
        $positions = Position::get()->pluck('name','id');
        $custom_request_position = CustomRequestPosition::where('custom_request_id',$custom_request->id)->get();
        return view('custom_requests.edit-positions', compact('custom_request','positions','custom_request_position'));
    }
    
    public function deletePositions($id)
    {
        $custom_request_position = CustomRequestPosition::findOrfail($id);
        $custom_request_position->delete();
        return redirect()->back()->with('success', __('Position Deleted Successfully'));
    }
    
    public function editPosition($id,Request $request)
    {
        $custom_request_position = CustomRequestPosition::findOrfail($id);
        $custom_request = CustomRequest::findOrfail($custom_request_position->custom_request_id);
        $position_count = $custom_request->positions;
        $sum_position_request = $request->positions_count;
        $custom_request_position_count = CustomRequestPosition::where('custom_request_id',$custom_request->id)->sum('position_employees_number');
        $old_position = $custom_request_position->position_employees_number;
        if ($custom_request_position_count <= $position_count && ($custom_request_position_count + $sum_position_request - $old_position) <= $position_count) {
            if ($sum_position_request <= $position_count) {
                $custom_request_position->position_employees_number = $request->positions_count;
                $custom_request_position->custom_request_id = $custom_request->id;
                $custom_request_position->save();
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
        $custom_request = CustomRequest::findOrfail($id);
        $position_count = $custom_request->positions;
        $sum_position_request = array_sum($request->positions_count);
        $custom_request_position_count = CustomRequestPosition::where('custom_request_id',$custom_request->id)->sum('position_employees_number');
        
        if ($custom_request_position_count < $position_count) {
            if ($sum_position_request <= $position_count) {
                for ($i=0; $i < count($request->positions); $i++) { 
                    $custom_request_position = CustomRequestPosition::where('custom_request_id',$custom_request->id)->where('position_id',$request->positions[$i])->first();
                    if ($custom_request_position == null && $request->positions_count[$i] < $position_count) {
                        $position = new CustomRequestPosition();
                        $position->position_id = $request->positions[$i];
                        $position->custom_request_id = $custom_request->id;
                        $position->position_employees_number = $request->positions_count[$i];
                        $position->save();
                        return redirect()->back()->with('success', __('Custom Request Assigned Successfully'));
                    }
                    else if ($custom_request_position != null && $request->positions_count[$i] < $position_count) {
                        if ($custom_request_position->position_employees_number < $position_count && ($custom_request_position_count + $sum_position_request) < $position_count) {
                            $custom_request_position->position_employees_number = $custom_request_position->position_employees_number + $request->positions_count[$i];
                            $custom_request_position->custom_request_id = $custom_request->id;
                            $custom_request_position->save();
                            return redirect()->back()->with('success', __('Custom Request Assigned Successfully'));
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
    



}
