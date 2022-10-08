<?php

namespace App\Exports;

use App\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Auth, DB;

class SalesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $start, $end;

	function __construct($start, $end, $item_code, $product_code) {
	    $this->start = $start;
      $this->end = $end;
      $this->item_code = $item_code;
	    $this->product_code = $product_code;
	}

    public function view(): View
    {
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
                                       ->whereBetween(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), array($this->start, $this->end))
                                       ->groupBy('d.item_code')
                                       ->orderBy('transactions.created_at', 'desc');
        if(!empty($this->item_code)){
            $transactions = $transactions->where('d.item_code', $this->item_code);
        }

        if(!empty($this->product_code)){
            $transactions = $transactions->where('d.product_code', $this->product_code);
        }
                                     
        $transactions = $transactions->get();

        return view('backend.reports.download_sales_report', ['transactions'=>$transactions, 'start'=>$this->start, 'end'=>$this->end]);
    }
}
