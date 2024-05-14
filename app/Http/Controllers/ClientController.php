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
use App\Models\User;
use App\Models\Utility;
// use http\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    function positionNumber()
    {
        $latest = Client::latest()->value('id');
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
        if(\Auth::user()->can('manage client'))
        {
            $user    = \Auth::user();
            $clients = Client::all();

            return view('clients.index', compact('clients'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create(Request $request)
    {

        if(\Auth::user()->can('create client'))
        {
            if($request->ajax)
            {
                return view('clients.createAjax');
            }
            else
            {
                $customFields = CustomField::where('module', '=', 'client')->get();
                $clientId      = idFormat('client',$this->positionNumber());
                return view('clients.create', compact('customFields','clientId'));
            }
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->can('create client'))
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

            $client = Client::create([
                'name' => $request->name,
                'industry' => $request->industry,
                'address' => $request->address,
                'created_by'  => auth()->user()->id
            ]);

            for ($i=0; $i < count($request->contact_name); $i++) { 
                ClientContact::create([
                    'contact_name' => $request->contact_name[$i],
                    'position' => $request->position[$i],
                    'mobile' => $request->mobile[$i],
                    'email' => $request->email[$i],
                    'client_id' => $client->id,
                ]);
            }

            return redirect()->route('clients.index')->with('success', __('Client successfully created.'));
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

    public function show(User $client)
    {
        $usr = Auth::user();
        if(!empty($client) && $usr->id == $client->creatorId() && $client->id != $usr->id && $client->type == 'client')
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
            $contracts   = $client->clientContracts()->orderByDesc('id')->get();
            $curr_month  = $client->clientContracts()->whereMonth('start_date', '=', date('m'))->get();
            $curr_week   = $client->clientContracts()->whereBetween(
                'start_date', [
                                \Carbon\Carbon::now()->startOfWeek(),
                                \Carbon\Carbon::now()->endOfWeek(),
                            ]
            )->get();
            $last_30days = $client->clientContracts()->whereDate('start_date', '>', \Carbon\Carbon::now()->subDays(30))->get();

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

            return view('clients.show', compact('client', 'estimations', 'cnt_estimation', 'contracts', 'cnt_contract'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function edit(Client $client)
    {
        if(\Auth::user()->can('edit client'))
        {
            $user = \Auth::user();
            $clientId      = idFormat('client',$this->positionNumber());
            return view('clients.edit', compact('client','clientId'));
        }
        else
        {
            return response()->json(['error' => __('Permission Denied.')], 401);
        }
    }

    public function update(Client $client, Request $request)
    {
        if(\Auth::user()->can('edit client'))
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

            $client->update([
                'name' => $request->name,
                'industry' => $request->industry,
                'address' => $request->address,
            ]);

            if (isset($request->contact_name)) {
                \DB::select('DELETE FROM client_contacts WHERE client_id = '.$client->id);
                for ($i=0; $i < count($request->contact_name); $i++) { 
                    ClientContact::create([
                        'contact_name' => $request->contact_name[$i],
                        'position' => $request->position[$i],
                        'mobile' => $request->mobile[$i],
                        'email' => $request->email[$i],
                        'client_id' => $client->id,
                    ]);
                }
            }

            

            return redirect()->route('clients.index')->with('success', __('Client successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function destroy(Client $client)
    {
        $user = \Auth::user();
        $client->delete();
        return redirect()->back()->with('success', __('Client Deleted Successfully!'));
    }

    public function clientPassword($id)
    {
        $eId        = \Crypt::decrypt($id);
        $user = User::find($eId);
        $client = User::where('created_by', '=', $user->creatorId())->where('type', '=', 'client')->first();


        return view('clients.reset', compact('user', 'client'));
    }

    public function clientPasswordReset(Request $request, $id)
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

        return redirect()->route('clients.index')->with(
            'success', 'Client Password successfully updated.'
        );


    }


}
