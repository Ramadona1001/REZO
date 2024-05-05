<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    function positionNumber()
    {
        $latest = Department::latest()->value('id');
        if(!$latest)
        {
            return 1;
        }

        return $latest + 1;
    }

    public function index()
    {
        if(\Auth::user()->can('manage department'))
        {
            $departments = Department::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('department.index', compact('departments'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create department'))
        {
            $employees = Employee::get()->pluck('name', 'id');
            $statement = \DB::select("SHOW TABLE STATUS LIKE 'departments'");
            $nextId = $statement[0]->Auto_increment;
            $departmentId      = idFormat('department',$this->positionNumber());
            return view('department.create', compact('employees','nextId','departmentId'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create department'))
        {

            $validator = \Validator::make(
                $request->all(), [
                                //    'branch_id' => 'required',
                                   'manager_id' => 'required',
                                   'name' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $department             = new Department();
            $department->branch_id  = Branch::first()->id;
            $department->name       = $request->name;
            $department->manager_id       = $request->manager_id;
            $department->created_by = \Auth::user()->creatorId();
            $department->save();

            return redirect()->route('department.index')->with('success', __('Department  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Department $department)
    {
        return redirect()->route('department.index');
    }

    public function edit(Department $department)
    {
        if(\Auth::user()->can('edit department'))
        {
            if($department->created_by == \Auth::user()->creatorId())
            {
                $branch = Branch::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $employees = Employee::get()->pluck('name', 'id');
                $departmentId      = idFormat('department',$this->positionNumber());
                return view('department.edit', compact('department', 'branch','employees','departmentId'));
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

    public function update(Request $request, Department $department)
    {
        if(\Auth::user()->can('edit department'))
        {
            if($department->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                    //    'branch_id' => 'required',
                                       'manager_id' => 'required',
                                       'name' => 'required|max:20',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $department->branch_id  = Branch::first()->id;
                $department->name      = $request->name;
                $department->manager_id      = $request->manager_id;
                $department->save();

                return redirect()->route('department.index')->with('success', __('Department successfully updated.'));
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

    public function destroy(Department $department)
    {
        if(\Auth::user()->can('delete department'))
        {
            if($department->created_by == \Auth::user()->creatorId())
            {
                $department->delete();

                return redirect()->route('department.index')->with('success', __('Department successfully deleted.'));
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
