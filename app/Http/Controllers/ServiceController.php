<?php

namespace App\Http\Controllers;

use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountType;
use App\Models\CustomField;
use App\Exports\ProductServiceExport;
use App\Imports\ProductServiceImport;
use App\Models\Product;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\ProductServiceUnit;
use App\Models\Service;
use App\Models\Tax;
use App\Models\User;
use App\Models\Utility;
use App\Models\Vender;
use App\Models\WarehouseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;




class ServiceController extends Controller
{
    function positionNumber()
    {
        $latest = Service::latest()->value('id');
        if(!$latest)
        {
            return 1;
        }

        return $latest + 1;
    }

    public function index(Request $request)
    {

        if(\Auth::user()->can('manage service'))
        {
            $productServices = Service::where('created_by',auth()->user()->id)->get();
            return view('service.index', compact('productServices'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->can('create service'))
        {
            $statement = DB::select("SHOW TABLE STATUS LIKE 'services'");
            $nextId = $statement[0]->Auto_increment;
            $serviceId      = idFormat('service',$this->positionNumber());
            return view('service.create',compact('nextId','serviceId'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {

        if(\Auth::user()->can('create service'))
        {

            $rules = [
                'name' => 'required',
                'hourly_rate' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->route('service.index')->with('error', $messages->first());
            }

            $productService                      = new Service();
            $productService->name                = $request->name;
            $productService->description         = $request->description;
            $productService->hourly_rate          = $request->hourly_rate;

            $productService->created_by       = \Auth::user()->creatorId();
            $productService->save();

            return redirect()->route('service.index')->with('success', __('Service successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show()
    {
        return redirect()->route('service.index');
    }

    public function edit($id)
    {
        $productService = Service::find($id);

        if(\Auth::user()->can('edit service'))
        {
            if($productService->created_by == \Auth::user()->creatorId())
            {
                $serviceId      = idFormat('service',$this->positionNumber());
                return view('service.edit', compact('productService','serviceId'));
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

    public function update(Request $request, $id)
    {

        if(\Auth::user()->can('edit service'))
        {
            $productService = Service::find($id);
            if($productService->created_by == \Auth::user()->creatorId())
            {
                $rules = [
                    'name' => 'required',
                    'hourly_rate' => 'required',

                ];

                $validator = \Validator::make($request->all(), $rules);

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('service.index')->with('error', $messages->first());
                }

                $productService->name           = $request->name;
                $productService->description    = $request->description;
                $productService->hourly_rate            = $request->hourly_rate;

                $productService->created_by     = \Auth::user()->creatorId();
                $productService->save();

                return redirect()->route('service.index')->with('success', __('Service successfully updated.'));
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

    public function destroy($id)
    {
        if(\Auth::user()->can('delete service'))
        {
            $productService = Service::find($id);
            if($productService->created_by == \Auth::user()->creatorId())
            {
                $productService->delete();

                return redirect()->route('service.index')->with('success', __('Service successfully deleted.'));
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

    public function export()
    {
        $name = 'service_' . date('Y-m-d i:h:s');
        $data = Excel::download(new ProductServiceExport(), $name . '.xlsx');

        return $data;
    }

    public function importFile()
    {
        return view('service.import');
    }

    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:csv,txt',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }
        $products     = (new ProductServiceImport)->toArray(request()->file('file'))[0];
        $totalProduct = count($products) - 1;
        $errorArray   = [];
        for ($i = 1; $i <= count($products) - 1; $i++) {
            $items  = $products[$i];

            $taxes     = explode(';', $items[5]);

            $taxesData = [];
            foreach ($taxes as $tax)
            {
                $taxes       = Tax::where('id', $tax)->first();
                //                $taxesData[] = $taxes->id;
                $taxesData[] = !empty($taxes->id) ? $taxes->id : 0;


            }

            $taxData = implode(',', $taxesData);
            //            dd($taxData);

            if (!empty($productBySku)) {
                $productService = $productBySku;
            } else {
                $productService = new ProductService();
            }

            $productService->name           = $items[0];
            $productService->sku            = $items[1];
            $productService->sale_price     = $items[2];
            $productService->purchase_price = $items[3];
            $productService->quantity       = $items[4];
            $productService->tax_id         = $items[5];
            $productService->category_id    = $items[6];
            $productService->unit_id        = $items[7];
            $productService->type           = $items[8];
            $productService->description    = $items[9];
            $productService->created_by     = \Auth::user()->creatorId();

            if (empty($productService)) {
                $errorArray[] = $productService;
            } else {
                $productService->save();
            }
        }

        $errorRecord = [];
        if (empty($errorArray)) {

            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {
            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalProduct . ' ' . 'record');


            foreach ($errorArray as $errorData) {

                $errorRecord[] = implode(',', $errorData);
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }

}
