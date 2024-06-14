<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\ClientDeal;
use App\Models\ClientPermission;
use App\Models\Contract;
use App\Models\CustomField;
use App\Models\Estimation;
use App\Models\Invoice;
use App\Models\Plan;
use App\Models\Supplier;
use App\Models\SupplierContact;
use App\Models\SupplierProject;
use App\Models\User;
use App\Models\Utility;
// use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class SupplierController extends Controller
{
    function positionNumber()
    {
        $latest = Supplier::latest()->value('id');
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
        if(\Auth::user()->can('manage supplier'))
        {
            $user    = \Auth::user();
            $suppliers = Supplier::where('created_by',auth()->user()->id)->get();

            return view('suppliers.index', compact('suppliers'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create(Request $request)
    {

        if(\Auth::user()->can('create supplier'))
        {
            if($request->ajax)
            {
                return view('suppliers.createAjax');
            }
            else
            {
                $customFields = CustomField::where('module', '=', 'freelancer')->get();

                $supplierId      = idFormat('freelancer',$this->positionNumber());
                return view('suppliers.create', compact('customFields','supplierId'));
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create supplier'))
        {
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->where('created_by', '=', \Auth::user()->creatorId())->first();

            $user      = \Auth::user();
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'industry' => 'required',
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

            $supplier = Supplier::create([
                'name' => $request->name,
                'industry' => $request->industry,
                'address' => $request->address,
                'created_by' => auth()->user()->id,
            ]);

            for ($i=0; $i < count($request->contact_name); $i++) { 
                SupplierContact::create([
                    'contact_name' => $request->contact_name[$i],
                    'position' => $request->position[$i],
                    'mobile' => $request->mobile[$i],
                    'email' => $request->email[$i],
                    'supplier_id' => $supplier->id,
                ]);
            }

            return redirect()->route('suppliers.index')->with('success', __('Freelancer successfully created.'));
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

    public function show(User $supplier)
    {
        $usr = Auth::user();
        if(!empty($supplier) && $usr->id == $supplier->creatorId() && $supplier->id != $usr->id && $supplier->type == 'freelancer')
        {
            // For Estimations
            $estimations = $client->clientEstimations()->orderByDesc('id')->get();
            $curr_month  = $client->clientEstimations()->whereMonth('issue_date', '=', date('m'))->get();
            $curr_week   = $client->clientEstimations()->whereBetween(
                'issue_date', [
                                \Carbon\Carbon::now()->startOfWeek(),
                                \Carbon\Carbon::now()->endOfWeek(),
                            ]
            )->get();
            $last_30days = $client->clientEstimations()->whereDate('issue_date', '>', \Carbon\Carbon::now()->subDays(30))->get();
            // Estimation Summary
            $cnt_estimation                = [];
            $cnt_estimation['total']       = Estimation::getEstimationSummary($estimations);
            $cnt_estimation['this_month']  = Estimation::getEstimationSummary($curr_month);
            $cnt_estimation['this_week']   = Estimation::getEstimationSummary($curr_week);
            $cnt_estimation['last_30days'] = Estimation::getEstimationSummary($last_30days);

            $cnt_estimation['cnt_total']       = $estimations->count();
            $cnt_estimation['cnt_this_month']  = $curr_month->count();
            $cnt_estimation['cnt_this_week']   = $curr_week->count();
            $cnt_estimation['cnt_last_30days'] = $last_30days->count();

            // For Contracts
            $contracts   = $supplier->clientContracts()->orderByDesc('id')->get();
            $curr_month  = $supplier->clientContracts()->whereMonth('start_date', '=', date('m'))->get();
            $curr_week   = $supplier->clientContracts()->whereBetween(
                'start_date', [
                                \Carbon\Carbon::now()->startOfWeek(),
                                \Carbon\Carbon::now()->endOfWeek(),
                            ]
            )->get();
            $last_30days = $supplier->clientContracts()->whereDate('start_date', '>', \Carbon\Carbon::now()->subDays(30))->get();

            // Contracts Summary
            $cnt_contract                = [];
            $cnt_contract['total']       = Contract::getContractSummary($contracts);
            $cnt_contract['this_month']  = Contract::getContractSummary($curr_month);
            $cnt_contract['this_week']   = Contract::getContractSummary($curr_week);
            $cnt_contract['last_30days'] = Contract::getContractSummary($last_30days);

            $cnt_contract['cnt_total']       = $contracts->count();
            $cnt_contract['cnt_this_month']  = $curr_month->count();
            $cnt_contract['cnt_this_week']   = $curr_week->count();
            $cnt_contract['cnt_last_30days'] = $last_30days->count();

            return view('suppliers.show', compact('freelancer', 'estimations', 'cnt_estimation', 'contracts', 'cnt_contract'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function createProjects(Supplier $supplier)
    {
        if(\Auth::user()->can('manage supplier'))
        {
            $user = \Auth::user();
            return view('suppliers.create-project', compact('supplier'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }
    
    public function storeProjects(Supplier $supplier,Request $request)
    {
        if(\Auth::user()->can('manage supplier'))
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

            SupplierProject::create([
                'name' => $request->name,
                'amount' => $request->amount,
                'total_hours' => $request->total_hours,
                'content' => $request->content,
                'supplier_id' => $supplier->id
            ]);


            return redirect()->route('suppliers.index')->with('success', __('Supplier Project successfully created.'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function allProjects(Supplier $supplier)
    {
        if(\Auth::user()->can('manage supplier'))
        {
            $user = \Auth::user();
            $projects = SupplierProject::where('supplier_id',$supplier->id)->get();
            return view('suppliers.all-project', compact('supplier','projects'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }
    
    public function deleteProjects(SupplierProject $supplier)
    {
        if(\Auth::user()->can('manage supplier'))
        {
            $supplier->delete();
            return redirect()->route('freelancers.index')->with('success', __('Supplier Project successfully deleted.'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function edit(Supplier $supplier)
    {
        if(\Auth::user()->can('edit supplier'))
        {
            $user = \Auth::user();
            $supplierId      = idFormat('freelancer',$this->positionNumber());
            return view('suppliers.edit', compact('supplier','supplierId'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function update(Supplier $supplier, Request $request)
    {
        if(\Auth::user()->can('edit supplier'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'industry' => 'required',
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

            $supplier->update([
                'name' => $request->name,
                'industry' => $request->industry,
                'address' => $request->address,
            ]);

            if (isset($request->contact_name)) {
                \DB::select('DELETE FROM supplier_contacts WHERE supplier_id = '.$supplier->id);
                for ($i=0; $i < count($request->contact_name); $i++) { 
                    SupplierContact::create([
                        'contact_name' => $request->contact_name[$i],
                        'position' => $request->position[$i],
                        'mobile' => $request->mobile[$i],
                        'email' => $request->email[$i],
                        'supplier_id' => $supplier->id,
                    ]);
                }
            }

            

            return redirect()->route('suppliers.index')->with('success', __('Supplier successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function destroy(Supplier $supplier)
    {
        $user = \Auth::user();
        $supplier->delete();
        return redirect()->back()->with('success', __('Supplier Deleted Successfully!'));
    }

    public function freelancerPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::find($eId);
        $supplier = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'freelancer')->first();


        return view('suppliers.reset', compact('user', 'freelancer'));
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

        return redirect()->route('suppliers.index')->with(
            'success', 'Freelancer Password successfully updated.'
        );


    }


}
