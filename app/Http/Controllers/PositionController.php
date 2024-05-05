<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    function positionNumber()
    {
        $latest = Position::latest()->value('id');
        if(!$latest)
        {
            return 1;
        }

        return $latest + 1;
    }

    public function index()
    {

        if(\Auth::user()->can('manage position'))
        {
            $positions = Position::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('position.index', compact('positions'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if(\Auth::user()->can('create position'))
        {
            $statement = \DB::select("SHOW TABLE STATUS LIKE 'positions'");
            $nextId = $statement[0]->Auto_increment;
            $positionId      = idFormat('position',$this->positionNumber());
            return view('position.create',compact('nextId','positionId'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('create position'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required|max:20',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $position                = new Position();
            $position->name          = $request->name;
            $position->descriptions          = $request->descriptions;
            $position->slaray_range    = $request->slaray_range;
            $position->created_by    = \Auth::user()->creatorId();
            $position->save();

            return redirect()->route('position.index')->with('success', __('Position  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    
    public function newPostionAjax(Request $request)
    {
        $position                = new Position();
        $position->name          = $request->position_name;
        $position->descriptions          = $request->position_descriptions;
        $position->slaray_range    = $request->position_slaray_range;
        $position->created_by    = \Auth::user()->creatorId();
        $position->save();

        return response()->json(['data'=>[
            'id' => $position->id,
            'name' => $position->name
        ]]);
    }

    public function show(Position $position)
    {
        return redirect()->route('position.index');
    }

    public function edit(Position $position)
    {

        if(\Auth::user()->can('edit position'))
        {
            if($position->created_by == \Auth::user()->creatorId())
            {
                return view('position.edit', compact('position'));
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

    public function update(Request $request, Position $position)
    {
        if(\Auth::user()->can('edit position'))
        {
            if($position->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $position->name          = $request->name;
                $position->descriptions          = $request->descriptions;
                $position->slaray_range    = $request->slaray_range;
                $position->save();

                return redirect()->route('position.index')->with('success', __('Position  successfully updated.'));
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

    public function destroy(Position $position)
    {
        if(\Auth::user()->can('delete position'))
        {
            if($position->created_by == \Auth::user()->creatorId())
            {
                $position->delete();

                return redirect()->route('position.index')->with('success', __('Position successfully deleted.'));
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
