<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\Bill;
use App\Models\BillAccount;
use App\Models\BillPayment;
use App\Models\BillProduct;
use App\Models\ChartOfAccount;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\StockReport;
use App\Models\TransactionLines;
use App\Models\Utility;
use App\Models\Vender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ChartController extends Controller
{

    public function employees(){
        $title = __('Employee Charts');
        return view('dashboard.employee-charts',['title'=>$title]);
    }
    
    public function projects(){
        $title = __('Project Charts');
        return view('dashboard.project-charts',['title'=>$title]);
    }

}
