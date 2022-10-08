<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\TransactionDetail;
use App\SettingAgentPackage;
use App\AffiliateCommission;
use App\SettingMerchantBonus;

use App\Exports\RedemptionExport;
use App\Exports\OrderExport;
use App\Exports\SalesExport;
use App\Exports\AgentStock;
use App\Exports\CommissionExport;
use Maatwebsite\Excel\Facades\Excel;
use Validator, Redirect, Toastr, DB, File, Auth, DateTime;

class ReportController extends Controller
{
    public function agent_stock_report()
    {
      if(!empty(request('dates'))){

        $new_dates = explode('-', request('dates'));
        $start = date('Y-m-d', strtotime($new_dates[0]));
        $end = date('Y-m-d', strtotime($new_dates[1]));

        $startDate = $new_dates[0];
        $endDate = $new_dates[1];

      }else{

        $ds = new DateTime("first day of this month");
        $de = new DateTime("last day of this month");

        $start = $ds->format('Y-m-d');
        $end = $de->format('Y-m-d');

        $startDate = $ds->format('m/d/Y');
        $endDate = $de->format('m/d/Y');
      }

  	  if(Auth::guard('admin')->check()){
          $transactions = Transaction::select(DB::raw('SUM(quantity) AS totalQty'), DB::raw('SUM(transactions.grand_total) AS totalGrand'), 
                                              DB::raw('SUM(transactions.shipping_fee) AS totalShippingFee'), 
                                              DB::raw('SUM(transactions.discount) AS totalDiscount'), 
                                              'd.item_code', 'd.product_code',
                                              DB::raw('CONCAT(m.f_name, " ", m.l_name) AS buyer_name'))
                                     ->join('merchants AS m', 'm.code', 'transactions.user_id')
                                     ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                     ->where('transactions.status', '1')
                                     ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                                     ->groupBy('m.code')
                                     ->orderBy('transactions.created_at', 'desc');
      }else{
          $transactions = Transaction::select(DB::raw('COALESCE(CONCAT(m.f_name, " ", m.l_name), CONCAT(s.f_name, " ", s.l_name)) AS customer_name'),
                                              'transactions.transaction_no', 'product_name', 'unit_price', 'quantity', 'total_amount', 'transactions.status', 
                                              'transactions.created_at', 'd.sub_category',
                                              'transactions.id AS Tid', 'transactions.grand_total', 'transactions.shipping_fee')
                                     ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                                     ->leftJoin('users AS s', 's.code', 'transactions.user_id')
                                     ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                     ->where('m.master_id', Auth::user()->code)
                                     ->orWhere('s.master_id', Auth::user()->code)
                                     ->groupBy('transactions.id')
                                     ->orderBy('transactions.created_at', 'desc');
      }

      $queries = [];
      $columns = [
          'item_code', 'dates', 'buyer', 'status'
      ];

      foreach($columns as $column){
          if(request()->has($column) && !empty(request($column))){
              if($column == 'status'){
                  $transactions = $transactions->where('transactions.status', 'like', "%".request($column)."%");
              }elseif($column == 'dates'){
                  $transactions = $transactions->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end));
              }elseif($column == 'buyer'){
                  $transactions = $transactions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%");
              }else{
                  $transactions = $transactions->where($column, 'like', "%".request($column)."%");
              }

              $queries[$column] = request($column);

          }
      }

      $per_page = 10;
      if(!empty(request('per_page'))){
          $per_page = request('per_page');
      }
      $transactions = $transactions->paginate($per_page)->appends($queries);

    	return view('backend.reports.agent_stock_report', ['transactions'=>$transactions, 'startDate'=>$startDate, 'endDate'=>$endDate]);
    }

    public function print_agent_stock_report()
    {

        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }
        
        if(Auth::guard('admin')->check()){
            $transactions = Transaction::select(DB::raw('SUM(quantity) AS totalQty'), DB::raw('SUM(transactions.grand_total) AS totalGrand'), 
                                              DB::raw('SUM(transactions.shipping_fee) AS totalShippingFee'), 
                                              DB::raw('SUM(transactions.discount) AS totalDiscount'), 
                                              'd.item_code', 'd.product_code',
                                              DB::raw('CONCAT(m.f_name, " ", m.l_name) AS buyer_name'))
                                     ->join('merchants AS m', 'm.code', 'transactions.user_id')
                                     ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                     ->where('transactions.status', '1')
                                     ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                                     ->groupBy('m.code')
                                     ->orderBy('transactions.created_at', 'desc');
        }else{
            $transactions = Transaction::select('quantity', 'transactions.grand_total', 'transactions.shipping_fee', 'transactions.discount', 'd.item_code', 'd.product_code')
                                       ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                                       ->leftJoin('users AS s', 's.code', 'transactions.user_id')
                                       ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                       ->where('m.master_id', Auth::user()->code)
                                       ->orWhere('s.master_id', Auth::user()->code)
                                       ->groupBy('transactions.id')
                                       ->orderBy('transactions.created_at', 'desc');
        }

        $queries = [];
        $columns = [
            'transaction_no', 'dates', 'buyer', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $transactions = $transactions->where('transactions.status', 'like', "%".request($column)."%");
                }elseif($column == 'dates'){
                    $transactions = $transactions->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end));
                }elseif($column == 'buyer'){
                    $transactions = $transactions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%");
                }else{
                    $transactions = $transactions->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        $transactions = $transactions->get();

        return view('backend.reports.print_agent_stock_report', ['transactions'=>$transactions, 'startDate'=>$startDate, 'endDate'=>$endDate]);
    }

    public function exportAgentStockReport()
    {
        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }

        $item_code = "";
        if(!empty(request('item_code'))){
          $item_code = request('item_code');
        }

        $buyer = "";
        if(!empty(request('buyer'))){
          $buyer = request('buyer');
        }

        return Excel::download(new AgentStock($start, $end, $item_code, $buyer), 'AgentStockReport'.$start.' - '.$end.'.xlsx');
    }

    public function sales_report()
    {
      if(!empty(request('dates'))){

        $new_dates = explode('-', request('dates'));
        $start = date('Y-m-d', strtotime($new_dates[0]));
        $end = date('Y-m-d', strtotime($new_dates[1]));

        $startDate = $new_dates[0];
        $endDate = $new_dates[1];

      }else{

        $ds = new DateTime("first day of this month");
        $de = new DateTime("last day of this month");

        $start = $ds->format('Y-m-d');
        $end = $de->format('Y-m-d');

        $startDate = $ds->format('m/d/Y');
        $endDate = $de->format('m/d/Y');
      }


      if(Auth::guard('admin')->check()){
            $transactions = Transaction::select(DB::raw('SUM(quantity) AS totalQty'), DB::raw('SUM(transactions.grand_total) AS totalGrand'), 
                                                DB::raw('SUM(transactions.shipping_fee) AS totalShippingFee'), 
                                                DB::raw('SUM(transactions.discount) AS totalDiscount'),
                                                DB::raw('SUM(d.unit_price * d.quantity) AS totalNet'),
                                                'd.item_code', 'd.product_code', 'd.unit_price', 'd.product_name')
                                       ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                                       ->leftJoin('users AS u', 'u.code', 'transactions.user_id')
                                       ->leftJoin('admins AS a', 'a.code', 'transactions.user_id')
                                       ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                       ->where('transactions.status', '1')
                                       ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                                       ->groupBy('d.item_code')
                                       ->orderBy('transactions.created_at', 'desc');
        }else{
            $transactions = Transaction::select(DB::raw('COALESCE(CONCAT(m.f_name, " ", m.l_name), CONCAT(s.f_name, " ", s.l_name)) AS customer_name'),
                                                'transactions.transaction_no', 'product_name', 'unit_price', 'quantity', 'total_amount', 'transactions.status', 
                                                'transactions.created_at', 'd.sub_category',
                                                'transactions.id AS Tid', 'transactions.grand_total', 'transactions.shipping_fee', 'd.item_code', 'd.product_code')
                                       ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                                       ->leftJoin('users AS s', 's.code', 'transactions.user_id')
                                       ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                       ->where('m.master_id', Auth::user()->code)
                                       ->orWhere('s.master_id', Auth::user()->code)
                                       ->groupBy('transactions.id')
                                       ->orderBy('transactions.created_at', 'desc');
        }

        $queries = [];
        $columns = [
            'transaction_no', 'dates', 'item_code', 'product_code', 'buyer', 'status', 'per_page'
        ];
        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $transactions = $transactions->where('transactions.status', 'like', "%".request($column)."%");
                }elseif($column == 'dates'){
                    $transactions = $transactions->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end));
                }elseif($column == 'buyer'){
                    $transactions = $transactions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(a.f_name, " ", a.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(u.f_name, " ", u.l_name)'), 'like', "%".request($column)."%");
                }elseif($column == 'per_page'){
                  $transactions = $transactions->paginate($per_page);
                }else{
                    $transactions = $transactions->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }

        
        
        if(!empty(request('per_page'))){
            $transactions = $transactions->appends($queries);        
        }else{
            $transactions = $transactions->paginate($per_page)->appends($queries);        
        }

        return view('backend.reports.sales_report', ['transactions'=>$transactions, 'startDate'=>$startDate, 'endDate'=>$endDate]);
    }

    public function print_sales_report()
    {

        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }
        
        if(Auth::guard('admin')->check()){
            $transactions = Transaction::select(DB::raw('SUM(quantity) AS totalQty'), DB::raw('SUM(transactions.grand_total) AS totalGrand'), 
                                                DB::raw('SUM(transactions.shipping_fee) AS totalShippingFee'), 
                                                DB::raw('SUM(transactions.discount) AS totalDiscount'),
                                                DB::raw('SUM(d.unit_price * d.quantity) AS totalNet'),
                                                'd.item_code', 'd.product_code', 'd.unit_price', 'd.product_name')
                                       ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                                       ->leftJoin('users AS u', 'u.code', 'transactions.user_id')
                                       ->leftJoin('admins AS a', 'a.code', 'transactions.user_id')
                                       ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                       ->where('transactions.status', '1')
                                       ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                                       ->groupBy('d.item_code')
                                       ->orderBy('transactions.created_at', 'desc');
        }else{
            $transactions = Transaction::select('quantity', 'transactions.grand_total', 'transactions.shipping_fee', 'transactions.discount', 'd.item_code', 'd.product_code')
                                       ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                                       ->leftJoin('users AS s', 's.code', 'transactions.user_id')
                                       ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                       ->where('m.master_id', Auth::user()->code)
                                       ->orWhere('s.master_id', Auth::user()->code)
                                       ->groupBy('transactions.id')
                                       ->orderBy('transactions.created_at', 'desc');
        }

        $queries = [];
        $columns = [
            'dates', 'item_code', 'product_code', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $transactions = $transactions->where('transactions.status', 'like', "%".request($column)."%");
                }elseif($column == 'dates'){
                    $transactions = $transactions->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end));
                }elseif($column == 'buyer'){
                    $transactions = $transactions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(a.f_name, " ", a.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(u.f_name, " ", u.l_name)'), 'like', "%".request($column)."%");
                }else{
                    $transactions = $transactions->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        $transactions = $transactions->get();

        return view('backend.reports.print_sales_report', ['transactions'=>$transactions, 'startDate'=>$startDate, 'endDate'=>$endDate]);
    }

    public function exportSales()
    {
        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }


        $item_code = "";
        if(!empty(request('item_code'))){
          $item_code = request('item_code');
        }

        $product_code = "";
        if(!empty(request('product_code'))){
          $product_code = request('product_code');
        }

        return Excel::download(new SalesExport($start, $end, $item_code, $product_code), 'salesReport'.$start.' - '.$end.'.xlsx');
    }

    public function order_report()
    {
      if(!empty(request('dates'))){

        $new_dates = explode('-', request('dates'));
        $start = date('Y-m-d', strtotime($new_dates[0]));
        $end = date('Y-m-d', strtotime($new_dates[1]));

        $startDate = $new_dates[0];
        $endDate = $new_dates[1];

      }else{

        $ds = new DateTime("first day of this month");
        $de = new DateTime("last day of this month");

        $start = $ds->format('Y-m-d');
        $end = $de->format('Y-m-d');

        $startDate = $ds->format('m/d/Y');
        $endDate = $de->format('m/d/Y');
      }


        $transactions = Transaction::select(DB::raw('CASE 
                                                     WHEN m.id != "" THEN COALESCE(m.f_name, m.phone)
                                                     WHEN a.id != "" THEN COALESCE(a.f_name, a.phone)
                                                     WHEN u.id != "" THEN COALESCE(u.f_name, u.phone)
                                                 END AS buyer_name'),
                                        DB::raw('CASE 
                                                     WHEN m.id != "" THEN "Agent"
                                                     WHEN a.id != "" THEN "Admin"
                                                     WHEN u.id != "" THEN "Customer"
                                                 END AS buyer_role'),
                                        'transactions.transaction_no', 'transactions.status', 'transactions.created_at',
                                        'transactions.id AS Tid', 'transactions.grand_total', 'transactions.shipping_fee', 
                                        'transactions.processing_fee', 'transactions.discount', 'transactions.address_name',
                                        'transactions.ad_discount')
                               ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                               ->leftJoin('admins AS a', 'a.code', 'transactions.user_id')
                               ->leftJoin('users AS u', 'u.code', 'transactions.user_id')
                               ->where('transactions.status', '1')
                               ->whereNull('transactions.mall')
                               ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                               ->orderBy('transactions.created_at', 'desc');

        $totalT = Transaction::select(DB::raw('SUM(d.quantity) as totalQty'),
                                      DB::raw('SUM(d.unit_price) as totalUnitPrice'),
                                      DB::raw('SUM(d.unit_price * d.quantity) as totalNet'),
                                      DB::raw('SUM((d.unit_price * d.quantity) + transactions.processing_fee + transactions.shipping_fee + transactions.tax) as totalGrand'))
                                   ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                   ->where('transactions.status', '1')
                                   ->whereNull('transactions.mall')
                                   ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                                   ->orderBy('transactions.created_at', 'desc');

        $totalT2 = Transaction::select(DB::raw('SUM(transactions.processing_fee) as totalProcessingFee'),
                                      DB::raw('SUM(transactions.shipping_fee) as totalShippingFee'),
                                      DB::raw('SUM(transactions.tax) as totalTax'),
                                      DB::raw('SUM(transactions.discount) as totalDiscount'),
                                      DB::raw('SUM(transactions.ad_discount) as totalAdDiscount'))
                              ->where('transactions.status', '1')
                              ->whereNull('transactions.mall')
                              ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                              ->orderBy('transactions.created_at', 'desc');

        $queries = [];
        $columns = [
            'transaction_no', 'dates', 'buyer', 'per_page', 'status'
        ];

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $transactions = $transactions->where('transactions.status', 'like', "%".request($column)."%");
                }elseif($column == 'dates'){
                    $transactions = $transactions->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end));
                }elseif($column == 'buyer'){
                    $transactions = $transactions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(a.f_name, " ", a.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(u.f_name, " ", u.l_name)'), 'like', "%".request($column)."%");
                }elseif($column == 'per_page'){
                  $transactions = $transactions->paginate($per_page);
                }else{
                    $transactions = $transactions->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }

        
        if(!empty(request('per_page'))){
            $transactions = $transactions->appends($queries);        
        }else{
            $transactions = $transactions->paginate($per_page)->appends($queries);        
        }

        $totalT = $totalT->first();
        $totalT2 = $totalT2->first();

        $details = [];
        $details2 = [];
        foreach($transactions as $transaction){
            $details[$transaction->Tid] = TransactionDetail::where("transaction_id", $transaction->Tid)->get();   
            $details2[$transaction->Tid] = TransactionDetail::select(DB::raw('SUM(unit_price*quantity) AS totalPrice'))
                                                            ->where("transaction_id", $transaction->Tid)
                                                            ->first();
        }

        return view('backend.reports.order_report', ['transactions'=>$transactions, 'startDate'=>$startDate, 'endDate'=>$endDate, 
                                                     'totalT'=>$totalT, 'totalT2'=>$totalT2],
                                                     compact('details', 'details2'));
    }

    public function print_order_report()
    {

        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }
        
        $transactions = Transaction::select(DB::raw('CASE 
                                                     WHEN m.id != "" THEN COALESCE(m.f_name, m.phone)
                                                     WHEN a.id != "" THEN COALESCE(a.f_name, a.phone)
                                                     WHEN u.id != "" THEN COALESCE(u.f_name, u.phone)
                                                 END AS buyer_name'),
                                        DB::raw('CASE 
                                                     WHEN m.id != "" THEN "Agent"
                                                     WHEN a.id != "" THEN "Admin"
                                                     WHEN u.id != "" THEN "Customer"
                                                 END AS buyer_role'),
                                        'transactions.transaction_no', 'transactions.status', 'transactions.created_at',
                                        'transactions.id AS Tid', 'transactions.grand_total', 'transactions.shipping_fee', 
                                        'transactions.processing_fee', 'transactions.discount', 'transactions.address_name',
                                        'transactions.ad_discount')
                               ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                               ->leftJoin('admins AS a', 'a.code', 'transactions.user_id')
                               ->leftJoin('users AS u', 'u.code', 'transactions.user_id')
                               ->where('transactions.status', '1')
                               ->whereNull('transactions.mall')
                               ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                               ->orderBy('transactions.created_at', 'desc');

        $totalT = Transaction::select(DB::raw('SUM(d.quantity) as totalQty'),
                                      DB::raw('SUM(d.unit_price) as totalUnitPrice'),
                                      DB::raw('SUM(d.unit_price * d.quantity) as totalNet'),
                                      DB::raw('SUM((d.unit_price * d.quantity) + transactions.processing_fee + transactions.shipping_fee + transactions.tax) as totalGrand'))
                                   ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                   ->where('transactions.status', '1')
                                   ->whereNull('transactions.mall')
                                   ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                                   ->orderBy('transactions.created_at', 'desc');

        $totalT2 = Transaction::select(DB::raw('SUM(transactions.processing_fee) as totalProcessingFee'),
                                      DB::raw('SUM(transactions.shipping_fee) as totalShippingFee'),
                                      DB::raw('SUM(transactions.tax) as totalTax'),
                                      DB::raw('SUM(transactions.discount) as totalDiscount'),
                                      DB::raw('SUM(transactions.ad_discount) as totalAdDiscount'))
                              ->where('transactions.status', '1')
                              ->whereNull('transactions.mall')
                              ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                              ->orderBy('transactions.created_at', 'desc');

        $queries = [];
        $columns = [
            'transaction_no', 'dates', 'buyer', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $transactions = $transactions->where('transactions.status', 'like', "%".request($column)."%");
                }elseif($column == 'dates'){
                    $transactions = $transactions->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end));
                }elseif($column == 'buyer'){
                    $transactions = $transactions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(a.f_name, " ", a.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(u.f_name, " ", u.l_name)'), 'like', "%".request($column)."%");
                }else{
                    $transactions = $transactions->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        $transactions = $transactions->get();

        $totalT = $totalT->first();
        $totalT2 = $totalT2->first();

        $details = [];
        $details2 = [];
        foreach($transactions as $transaction){
            $details[$transaction->Tid] = TransactionDetail::where("transaction_id", $transaction->Tid)->get();   
            $details2[$transaction->Tid] = TransactionDetail::select(DB::raw('SUM(unit_price*quantity) AS totalPrice'))
                                                            ->where("transaction_id", $transaction->Tid)
                                                            ->first();
        }

        return view('backend.reports.print_order_report', ['transactions'=>$transactions, 'startDate'=>$startDate, 'endDate'=>$endDate, 
                                                     'totalT'=>$totalT, 'totalT2'=>$totalT2],
                                                     compact('details', 'details2'));
    }

    public function exportOrder()
    {
        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }

        return Excel::download(new OrderExport($start, $end), 'OrdersReport'.strtotime(now()).'.xlsx');
    }


    public function commission_report()
    {
        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }

        $commissions = AffiliateCommission::select(DB::raw('COALESCE(CONCAT(m.f_name, " ", m.l_name), CONCAT(u.f_name, " ", u.l_name)) AS agentName'), 
                                                  'affiliate_commissions.*', 't.id AS tID', 't.grand_total', 't.shipping_fee', 't.processing_fee', 't.discount',
                                                  't.created_at AS transaction_date', 't.user_id AS buyer', 
                                                  'affiliate_commissions.product_amount', 'affiliate_commissions.product_qty', 'affiliate_commissions.product_name')
                                          ->leftJoin('merchants AS m', 'm.code', 'affiliate_commissions.user_id')
                                          ->leftJoin('admins AS a', 'a.code', 'affiliate_commissions.user_id')
                                          ->leftJoin('users AS u', 'u.code', 'affiliate_commissions.user_id')
                                          ->leftJoin('transactions AS t', 't.transaction_no', 'affiliate_commissions.transaction_no')
                                          ->where('affiliate_commissions.status', '1')
                                          ->where('affiliate_commissions.user_id', '!=', 'AD000001')
                                          ->whereBetween(DB::raw('DATE_FORMAT(affiliate_commissions.created_at, "%Y-%m-%d")'), array($start, $end))
                                          ->orderBy('affiliate_commissions.created_at', 'desc')
                                          ->orderBy('affiliate_commissions.user_id', 'desc');

        $totalCommission = AffiliateCommission::select(DB::raw("SUM(IF(type = '1', comm_amount, NULL)) as totalAgentBonus"),
                                                       DB::raw("SUM(IF(type = '8', comm_amount, NULL)) as totalAgentRebateBonus"),
                                                       DB::raw("SUM(IF(type = '3', comm_amount, NULL)) as totalAffiliateBonus"),
                                                       DB::raw("SUM(IF(type = '4', comm_amount, NULL)) as totalPerformance"),
                                                       DB::raw("SUM(IF(type = '5', comm_amount, NULL)) as totalTeam"),
                                                       DB::raw("SUM(IF(type = '6', comm_amount, NULL)) as totalRefferal"),
                                                       DB::raw("SUM(IF(type = '7', comm_amount, NULL)) as totalProduct"))
                                              ->leftjoin('merchants AS m', 'm.code', 'affiliate_commissions.user_id')
                                              ->leftjoin('admins AS a', 'a.code', 'affiliate_commissions.user_id')
                                              ->where('affiliate_commissions.status', '1')
                                              ->where('affiliate_commissions.user_id', '!=', 'AD000001')
                                              ->whereBetween(DB::raw('DATE_FORMAT(affiliate_commissions.created_at, "%Y-%m-%d")'), array($start, $end));


        $queries = [];
        $columns = [
            'transaction_no', 'dates', 'agent', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $commissions = $commissions->where('affiliate_commissions.status', 'like', "%".request($column)."%");
                    $totalCommission = $totalCommission->where('affiliate_commissions.status', 'like', "%".request($column)."%");
                }elseif($column == 'dates'){
                    $commissions = $commissions->whereBetween(DB::raw('DATE_FORMAT(affiliate_commissions.created_at, "%Y-%m-%d")'), array($start, $end));
                    $totalCommission = $totalCommission->whereBetween(DB::raw('DATE_FORMAT(affiliate_commissions.created_at, "%Y-%m-%d")'), array($start, $end));
                }elseif($column == 'agent'){

                    $commissions = $commissions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%");
                    $totalCommission = $totalCommission->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%");

                }elseif($column == 'transaction_no'){
                    $commissions = $commissions->where('affiliate_commissions.transaction_no', 'like', "%".request($column)."%");
                    $totalCommission = $totalCommission->where('affiliate_commissions.transaction_no', 'like', "%".request($column)."%");
                }else{
                    $commissions = $commissions->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        $totalCommission = $totalCommission->first();

        $commissions = $commissions->paginate($per_page)->appends($queries);

        $netTotal = AffiliateCommission::select(DB::raw('SUM(comm_amount) AS netTotalCommission'))
                                       ->where('status', '1')
                                       ->first();
        
        
        return view('backend.reports.commission_report', ['startDate'=>$startDate, 'endDate'=>$endDate,
                                                          'commissions'=>$commissions, 'totalCommission'=>$totalCommission,
                                                          'netTotal'=>$netTotal]);
    }

    public function print_commission_report()
    {

        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }
        
        $commissions = AffiliateCommission::select(DB::raw('COALESCE(CONCAT(m.f_name, " ", m.l_name), CONCAT(a.f_name, " ", a.l_name)) AS agentName'), 
                                                  'affiliate_commissions.*', 't.id AS tID', 't.grand_total', 't.shipping_fee', 't.processing_fee', 't.discount',
                                                  't.created_at AS transaction_date', 't.user_id AS buyer', 
                                                  'affiliate_commissions.product_amount', 'affiliate_commissions.product_qty', 'affiliate_commissions.product_name')
                                          ->leftJoin('merchants AS m', 'm.code', 'affiliate_commissions.user_id')
                                          ->leftJoin('admins AS a', 'a.code', 'affiliate_commissions.user_id')
                                          ->leftJoin('transactions AS t', 't.transaction_no', 'affiliate_commissions.transaction_no')
                                          ->where('affiliate_commissions.status', '1')
                                          ->where('affiliate_commissions.user_id', '!=', 'AD000001')
                                          ->whereBetween(DB::raw('DATE_FORMAT(affiliate_commissions.created_at, "%Y-%m-%d")'), array($start, $end))
                                          ->orderBy('affiliate_commissions.created_at', 'desc');

        $totalCommission = AffiliateCommission::select(DB::raw("SUM(IF(type = '1', comm_amount, NULL)) as totalAgentBonus"),
                                                       DB::raw("SUM(IF(type = '2', comm_amount, NULL)) as totalAgentRebateBonus"),
                                                       DB::raw("SUM(IF(type = '3', comm_amount, NULL)) as totalAffiliateBonus"),
                                                       DB::raw("SUM(IF(type = '4', comm_amount, NULL)) as totalPerformance"),
                                                       DB::raw("SUM(IF(type = '5', comm_amount, NULL)) as totalTeam"),
                                                       DB::raw("SUM(IF(type = '6', comm_amount, NULL)) as totalRefferal"),
                                                       DB::raw("SUM(IF(type = '7', comm_amount, NULL)) as totalProduct"))
                                              ->leftjoin('merchants AS m', 'm.code', 'affiliate_commissions.user_id')
                                              ->leftjoin('admins AS a', 'a.code', 'affiliate_commissions.user_id')
                                              ->where('affiliate_commissions.status', '1')
                                              ->where('affiliate_commissions.user_id', '!=', 'AD000001');

        $queries = [];
        $columns = [
            'transaction_no', 'dates', 'buyer', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $commissions = $commissions->where('affiliate_commissions.status', 'like', "%".request($column)."%");
                    $totalCommission = $totalCommission->where('affiliate_commissions.status', 'like', "%".request($column)."%");
                }elseif($column == 'dates'){
                    $commissions = $commissions->whereBetween(DB::raw('DATE_FORMAT(affiliate_commissions.created_at, "%Y-%m-%d")'), array($start, $end));
                    $totalCommission = $totalCommission->whereBetween(DB::raw('DATE_FORMAT(affiliate_commissions.created_at, "%Y-%m-%d")'), array($start, $end));
                }elseif($column == 'buyer'){
                    $commissions = $commissions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%");
                    $totalCommission = $totalCommission->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%");
                }else{
                    $commissions = $commissions->where($column, 'like', "%".request($column)."%");
                    $totalCommission = $totalCommission->where('affiliate_commissions.transaction_no', 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }


        $commissions = $commissions->get();
        $totalCommission = $totalCommission->first();

        $netTotal = AffiliateCommission::select(DB::raw('SUM(comm_amount) AS netTotalCommission'))
                                       ->where('status', '1')
                                       ->first();
        

        

        return view('backend.reports.print_commission_report', ['startDate'=>$startDate, 'endDate'=>$endDate,
                                                                'commissions'=>$commissions, 'totalCommission'=>$totalCommission,
                                                                'netTotal'=>$netTotal]);
    }

    public function exportCommissionReport()
    {
        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }

        return Excel::download(new CommissionExport($start, $end), 'CommissionReport'.strtotime(now()).'.xlsx');
    }

    public function redemption_report()
    {
      if(!empty(request('dates'))){

        $new_dates = explode('-', request('dates'));
        $start = date('Y-m-d', strtotime($new_dates[0]));
        $end = date('Y-m-d', strtotime($new_dates[1]));

        $startDate = $new_dates[0];
        $endDate = $new_dates[1];

      }else{

        $ds = new DateTime("first day of this month");
        $de = new DateTime("last day of this month");

        $start = $ds->format('Y-m-d');
        $end = $de->format('Y-m-d');

        $startDate = $ds->format('m/d/Y');
        $endDate = $de->format('m/d/Y');
      }


        $transactions = Transaction::select(DB::raw('CASE 
                                                     WHEN m.id != "" THEN COALESCE(m.f_name, m.phone)
                                                     WHEN a.id != "" THEN COALESCE(a.f_name, a.phone)
                                                     WHEN u.id != "" THEN COALESCE(u.f_name, u.phone)
                                                 END AS buyer_name'),
                                        DB::raw('CASE 
                                                     WHEN m.id != "" THEN "Agent"
                                                     WHEN a.id != "" THEN "Admin"
                                                     WHEN u.id != "" THEN "Customer"
                                                 END AS buyer_role'),
                                        'transactions.transaction_no', 'transactions.status', 'transactions.created_at',
                                        'transactions.id AS Tid', 'transactions.grand_total', 'transactions.shipping_fee', 
                                        'transactions.processing_fee', 'transactions.discount', 'transactions.address_name',
                                        'transactions.ad_discount')
                               ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                               ->leftJoin('admins AS a', 'a.code', 'transactions.user_id')
                               ->leftJoin('users AS u', 'u.code', 'transactions.user_id')
                               ->where('transactions.status', '1')
                               ->where('transactions.mall', '1')
                               ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                               ->orderBy('transactions.created_at', 'desc');

        $totalT = Transaction::select(DB::raw('SUM(d.quantity) as totalQty'),
                                      DB::raw('SUM(d.unit_price) as totalUnitPrice'),
                                      DB::raw('SUM(d.unit_price * d.quantity) as totalNet'),
                                      DB::raw('SUM((d.unit_price * d.quantity) + transactions.processing_fee + transactions.shipping_fee + transactions.tax) as totalGrand'))
                                   ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                   ->where('transactions.status', '1')
                                   ->where('transactions.mall', '1')
                                   ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                                   ->orderBy('transactions.created_at', 'desc');

        $totalT2 = Transaction::select(DB::raw('SUM(transactions.processing_fee) as totalProcessingFee'),
                                      DB::raw('SUM(transactions.shipping_fee) as totalShippingFee'),
                                      DB::raw('SUM(transactions.tax) as totalTax'),
                                      DB::raw('SUM(transactions.discount) as totalDiscount'),
                                      DB::raw('SUM(transactions.ad_discount) as totalAdDiscount'))
                              ->where('transactions.status', '1')
                              ->where('transactions.mall', '1')
                              ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                              ->orderBy('transactions.created_at', 'desc');

        $queries = [];
        $columns = [
            'transaction_no', 'dates', 'buyer', 'per_page', 'status'
        ];

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $transactions = $transactions->where('transactions.status', 'like', "%".request($column)."%");
                }elseif($column == 'dates'){
                    $transactions = $transactions->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end));
                }elseif($column == 'buyer'){
                    $transactions = $transactions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(a.f_name, " ", a.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(u.f_name, " ", u.l_name)'), 'like', "%".request($column)."%");
                }elseif($column == 'per_page'){
                  $transactions = $transactions->paginate($per_page);
                }else{
                    $transactions = $transactions->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }

        
        if(!empty(request('per_page'))){
            $transactions = $transactions->appends($queries);        
        }else{
            $transactions = $transactions->paginate($per_page)->appends($queries);        
        }

        $totalT = $totalT->first();
        $totalT2 = $totalT2->first();

        $details = [];
        $details2 = [];
        foreach($transactions as $transaction){
            $details[$transaction->Tid] = TransactionDetail::where("transaction_id", $transaction->Tid)->get();   
            $details2[$transaction->Tid] = TransactionDetail::select(DB::raw('SUM(unit_price*quantity) AS totalPrice'))
                                                            ->where("transaction_id", $transaction->Tid)
                                                            ->first();
        }

        return view('backend.reports.redemption_report', ['transactions'=>$transactions, 'startDate'=>$startDate, 'endDate'=>$endDate, 
                                                     'totalT'=>$totalT, 'totalT2'=>$totalT2],
                                                     compact('details', 'details2'));
    }

    public function print_redemption_report()
    {

        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }
        
        $transactions = Transaction::select(DB::raw('CASE 
                                                     WHEN m.id != "" THEN COALESCE(m.f_name, m.phone)
                                                     WHEN a.id != "" THEN COALESCE(a.f_name, a.phone)
                                                     WHEN u.id != "" THEN COALESCE(u.f_name, u.phone)
                                                 END AS buyer_name'),
                                        DB::raw('CASE 
                                                     WHEN m.id != "" THEN "Agent"
                                                     WHEN a.id != "" THEN "Admin"
                                                     WHEN u.id != "" THEN "Customer"
                                                 END AS buyer_role'),
                                        'transactions.transaction_no', 'transactions.status', 'transactions.created_at',
                                        'transactions.id AS Tid', 'transactions.grand_total', 'transactions.shipping_fee', 
                                        'transactions.processing_fee', 'transactions.discount', 'transactions.address_name',
                                        'transactions.ad_discount')
                               ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                               ->leftJoin('admins AS a', 'a.code', 'transactions.user_id')
                               ->leftJoin('users AS u', 'u.code', 'transactions.user_id')
                               ->where('transactions.status', '1')
                               ->where('transactions.mall', '1')
                               ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                               ->orderBy('transactions.created_at', 'desc');

        $totalT = Transaction::select(DB::raw('SUM(d.quantity) as totalQty'),
                                      DB::raw('SUM(d.unit_price) as totalUnitPrice'),
                                      DB::raw('SUM(d.unit_price * d.quantity) as totalNet'),
                                      DB::raw('SUM((d.unit_price * d.quantity) + transactions.processing_fee + transactions.shipping_fee + transactions.tax) as totalGrand'))
                                   ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                   ->where('transactions.status', '1')
                                   ->where('transactions.mall', '1')
                                   ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                                   ->orderBy('transactions.created_at', 'desc');

        $totalT2 = Transaction::select(DB::raw('SUM(transactions.processing_fee) as totalProcessingFee'),
                                      DB::raw('SUM(transactions.shipping_fee) as totalShippingFee'),
                                      DB::raw('SUM(transactions.tax) as totalTax'),
                                      DB::raw('SUM(transactions.discount) as totalDiscount'),
                                      DB::raw('SUM(transactions.ad_discount) as totalAdDiscount'))
                              ->where('transactions.status', '1')
                              ->where('transactions.mall', '1')
                              ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end))
                              ->orderBy('transactions.created_at', 'desc');

        $queries = [];
        $columns = [
            'transaction_no', 'dates', 'buyer', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $transactions = $transactions->where('transactions.status', 'like', "%".request($column)."%");
                }elseif($column == 'dates'){
                    $transactions = $transactions->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($start, $end));
                }elseif($column == 'buyer'){
                    $transactions = $transactions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(a.f_name, " ", a.l_name)'), 'like', "%".request($column)."%")
                                                 ->orWhere(DB::raw('CONCAT(u.f_name, " ", u.l_name)'), 'like', "%".request($column)."%");
                }else{
                    $transactions = $transactions->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        $transactions = $transactions->get();

        $totalT = $totalT->first();
        $totalT2 = $totalT2->first();

        $details = [];
        $details2 = [];
        foreach($transactions as $transaction){
            $details[$transaction->Tid] = TransactionDetail::where("transaction_id", $transaction->Tid)->get();   
            $details2[$transaction->Tid] = TransactionDetail::select(DB::raw('SUM(unit_price*quantity) AS totalPrice'))
                                                            ->where("transaction_id", $transaction->Tid)
                                                            ->first();
        }

        return view('backend.reports.print_redemption_report', ['transactions'=>$transactions, 'startDate'=>$startDate, 'endDate'=>$endDate, 
                                                     'totalT'=>$totalT, 'totalT2'=>$totalT2],
                                                     compact('details', 'details2'));
    }

    public function ExportRedemtion()
    {
        if(!empty(request('dates'))){

          $new_dates = explode('-', request('dates'));
          $start = date('Y-m-d', strtotime($new_dates[0]));
          $end = date('Y-m-d', strtotime($new_dates[1]));

          $startDate = $new_dates[0];
          $endDate = $new_dates[1];

        }else{

          $ds = new DateTime("first day of this month");
          $de = new DateTime("last day of this month");

          $start = $ds->format('Y-m-d');
          $end = $de->format('Y-m-d');

          $startDate = $ds->format('m/d/Y');
          $endDate = $de->format('m/d/Y');
        }

        return Excel::download(new RedemptionExport($start, $end), 'RedemptionReport'.strtotime(now()).'.xlsx');
    }
}
