<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\ClientDeal;
use App\Models\ClientPermission;
use App\Models\Contract;
use App\Models\CustomField;
use App\Models\Estimation;
use App\Models\Freelancer;
use App\Models\FreelancerContact;
use App\Models\FreelancerProject;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
// use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class FreelancerController extends Controller
{
    function positionNumber()
    {
        $latest = Freelancer::latest()->value('id');
        if(!$latest)
        {
            return 1;
        }

        return $latest + 1;
    }

    public function __construct()
    {
        $this->middleware(
            [
                'auth',
                'XSS',
            ]
        );
    }

    public function index()
    {
        if(\Auth::user()->can('manage freelancer'))
        {
            $user    = \Auth::user();
            $freelancers = Freelancer::where('created_by',auth()->user()->id)->get();

            return view('freelancers.index', compact('freelancers'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create(Request $request)
    {

        if(\Auth::user()->can('create freelancer'))
        {
            if($request->ajax)
            {
                return view('freelancers.createAjax');
            }
            else
            {
                $customFields = CustomField::where('module', '=', 'freelancer')->get();
                $freelancerId      = idFormat('freelancer',$this->positionNumber());
                return view('freelancers.create', compact('customFields','freelancerId'));
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create freelancer'))
        {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->where('created_by', '=', \Auth::user()->creatorId())->first();

            $user      = \Auth::user();
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'email' => 'required',
                    'main_category' => 'required',
                    'sub_category' => 'required',
                    'hourly_rate' => 'required',
                    'profile_link' => 'required',
                    'city' => 'required',
                    'country' => 'required',
                    'mobile' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                if($request->ajax)
                {
                    return response()->json(['error' => $messages->first()], 401);
                }
                else
                {
                    return redirect()->back()->with('error', $messages->first());
                }
            }

            // dd($request->all());

            $freelancer = Freelancer::create([
                'name' => $request->name,
                'email' => $request->email,
                'main_category' => $request->main_category,
                'sub_category' => $request->sub_category,
                'hourly_rate' => $request->hourly_rate,
                'profile_link' => $request->profile_link,
                'city' => $request->city,
                'country' => $request->country,
                'comment' => $request->comment,
                'mobile' => $request->mobile,
                'created_by' => auth()->user()->id,
            ]);


            return redirect()->route('freelancers.index')->with('success', __('Freelancer successfully created.'));
        }
        else
        {
            if($request->ajax)
            {
                return response()->json(['error' => __('Permission Denied.')], 401);
            }
            else
            {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
    }

    public function show(Freelancer $freelancer)
    {
        if(\Auth::user()->can('manage freelancer'))
        {
            $user = \Auth::user();
            return view('freelancers.show', compact('freelancer'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }
    
    public function createProjects(Freelancer $freelancer)
    {
        if(\Auth::user()->can('manage freelancer'))
        {
            $user = \Auth::user();
            return view('freelancers.create-project', compact('freelancer'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }
    
    public function storeProjects(Freelancer $freelancer,Request $request)
    {
        if(\Auth::user()->can('manage freelancer'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'total_hours' => 'required',
                    'amount' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                if($request->ajax)
                {
                    return response()->json(['error' => $messages->first()], 401);
                }
                else
                {
                    return redirect()->back()->with('error', $messages->first());
                }
            }

            FreelancerProject::create([
                'name' => $request->name,
                'amount' => $request->amount,
                'total_hours' => $request->total_hours,
                'content' => $request->content,
                'freelancer_id' => $freelancer->id
            ]);


            return redirect()->route('freelancers.index')->with('success', __('Freelancer Project successfully created.'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function allProjects(Freelancer $freelancer)
    {
        if(\Auth::user()->can('manage freelancer'))
        {
            $user = \Auth::user();
            $projects = FreelancerProject::where('freelancer_id',$freelancer->id)->get();
            return view('freelancers.all-project', compact('freelancer','projects'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }
    
    public function deleteProjects(FreelancerProject $project)
    {
        if(\Auth::user()->can('manage freelancer'))
        {
            $project->delete();
            return redirect()->route('freelancers.index')->with('success', __('Freelancer Project successfully deleted.'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function edit(Freelancer $freelancer)
    {
        if(\Auth::user()->can('edit freelancer'))
        {
            $user = \Auth::user();
            $freelancerId      = idFormat('freelancer',$this->positionNumber());
            return view('freelancers.edit', compact('freelancer','freelancerId'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function update(Freelancer $freelancer, Request $request)
    {
        if(\Auth::user()->can('edit freelancer'))
        {
            $validator = \Validator::make(
                $request->all(), [
                   'name' => 'required',
                    'email' => 'required',
                    'main_category' => 'required',
                    'sub_category' => 'required',
                    'hourly_rate' => 'required',
                    'profile_link' => 'required',
                    'city' => 'required',
                    'country' => 'required',
                    'mobile' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                if($request->ajax)
                {
                    return response()->json(['error' => $messages->first()], 401);
                }
                else
                {
                    return redirect()->back()->with('error', $messages->first());
                }
            }

            // dd($request->all());

            $freelancer->update([
                'name' => $request->name,
                'email' => $request->email,
                'main_category' => $request->main_category,
                'sub_category' => $request->sub_category,
                'hourly_rate' => $request->hourly_rate,
                'profile_link' => $request->profile_link,
                'city' => $request->city,
                'country' => $request->country,
                'comment' => $request->comment,
                'mobile' => $request->mobile,
            ]);


            

            return redirect()->route('freelancers.index')->with('success', __('Freelancer successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function destroy(Freelancer $freelancer)
    {
        $user = \Auth::user();
        $freelancer->delete();
        return redirect()->back()->with('success', __('Freelancer Deleted Successfully!'));
    }

    public function freelancerPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::find($eId);
        $freelancer = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'freelancer')->first();


        return view('freelancers.reset', compact('user', 'freelancer'));
    }

    public function freelancerPasswordReset(Request $request, $id)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'password' => 'required|confirmed|same:password_confirmation',
                           ]
        );

        if($validator->fails())
        {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }


        $user                 = User::where('id', $id)->first();
        $user->forceFill([
                             'password' => Hash::make($request->password),
                         ])->save();

        return redirect()->route('freelancers.index')->with(
            'success', 'Freelancer Password successfully updated.'
        );


    }


}
