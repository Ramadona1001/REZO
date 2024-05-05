<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    function positionNumber()
    {
        $latest = Designation::latest()->value('id');
        if(!$latest)
        {
            return 1;
        }

        return $latest + 1;
    }

    public function index()
    {

        if(\Auth::user()->can('manage designation'))
        {
            $designations = Designation::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('designation.index', compact('designations'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create designation'))
        {
            $departments = Department::where('created_by', '=', \Auth::user()->creatorId())->get();
            $departments = $departments->pluck('name', 'id');
            $statement = \DB::select("SHOW TABLE STATUS LIKE 'designations'");
            $nextId = $statement[0]->Auto_increment;
            $sectionId      = idFormat('section',$this->positionNumber());
            return view('designation.create', compact('departments','nextId','sectionId'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('create designation'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'department_id' => 'required',
                                   'name' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $designation                = new Designation();
            $designation->department_id = $request->department_id;
            $designation->name          = $request->name;
            $designation->descriptions          = $request->descriptions;
            $designation->created_by    = \Auth::user()->creatorId();

            $designation->save();

            return redirect()->route('designation.index')->with('success', __('Designation  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Designation $designation)
    {
        return redirect()->route('designation.index');
    }

    public function edit(Designation $designation)
    {

        if(\Auth::user()->can('edit designation'))
        {
            if($designation->created_by == \Auth::user()->creatorId())
            {

                $departments = Department::where('id', $designation->department_id)->first();
                $departments = $departments->pluck('name', 'id');
                $sectionId      = idFormat('section',$this->positionNumber());
                return view('designation.edit', compact('designation', 'departments','sectionId'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Designation $designation)
    {
        if(\Auth::user()->can('edit designation'))
        {
            if($designation->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'department_id' => 'required',
                                       'name' => 'required|max:20',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $designation->name          = $request->name;
                $designation->department_id = $request->department_id;
                $designation->descriptions          = $request->descriptions;
                $designation->save();

                return redirect()->route('designation.index')->with('success', __('Designation  successfully updated.'));
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

    public function destroy(Designation $designation)
    {
        if(\Auth::user()->can('delete designation'))
        {
            if($designation->created_by == \Auth::user()->creatorId())
            {
                $designation->delete();

                return redirect()->route('designation.index')->with('success', __('Designation successfully deleted.'));
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
}
