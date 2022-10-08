<?php

namespace App\Exports;

use App\AffiliateCommission;
use App\Transaction;
use App\SettingAgentPackage;
use App\SettingMerchantBonus;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Auth, DB;

class CommissionExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $start, $end;

	 function __construct($start, $end) {
	        $this->start = $start;
	        $this->end = $end;
	 }


    public function view(): View
    {
    	$commissions = AffiliateCommission::select(DB::raw('COALESCE(CONCAT(m.f_name, " ", m.l_name), CONCAT(a.f_name, " ", a.l_name)) AS agentName'), 
                                                  'affiliate_commissions.*', 't.id AS tID', 't.grand_total', 't.shipping_fee', 't.processing_fee', 't.discount',
                                                  't.created_at AS transaction_date', 't.user_id AS buyer', 
                                                  'affiliate_commissions.product_amount', 'affiliate_commissions.product_qty', 'affiliate_commissions.product_name')
                                          ->leftJoin('merchants AS m', 'm.code', 'affiliate_commissions.user_id')
                                          ->leftJoin('admins AS a', 'a.code', 'affiliate_commissions.user_id')
                                          ->leftJoin('transactions AS t', 't.transaction_no', 'affiliate_commissions.transaction_no')
                                          ->where('affiliate_commissions.status', '1')
                                          ->whereBetween(DB::raw('DATE_FORMAT(affiliate_commissions.created_at, "%Y-%m-%d")'), array($this->start, $this->end))
                                          ->orderBy('affiliate_commissions.created_at', 'desc')
                                          ->get();

        $totalCommission = AffiliateCommission::select(DB::raw("SUM(IF(type = '1', comm_amount, NULL)) as totalAgentBonus"),
                                                       DB::raw("SUM(IF(type = '2', comm_amount, NULL)) as totalAgentRebateBonus"),
                                                       DB::raw("SUM(IF(type = '3', comm_amount, NULL)) as totalAffiliateBonus"),
                                                       DB::raw("SUM(IF(type = '4', comm_amount, NULL)) as totalPerformance"),
                                                       DB::raw("SUM(IF(type = '5', comm_amount, NULL)) as totalTeam"),
                                                       DB::raw("SUM(IF(type = '6', comm_amount, NULL)) as totalRefferal"),
                                                       DB::raw("SUM(IF(type = '7', comm_amount, NULL)) as totalProduct"))
                                              ->leftjoin('merchants AS m', 'm.code', 'affiliate_commissions.user_id')
                                              ->leftjoin('admins AS a', 'a.code', 'affiliate_commissions.user_id')
                                              ->whereBetween(DB::raw('DATE_FORMAT(affiliate_commissions.created_at, "%Y-%m-%d")'), array($this->start, $this->end))
                                              ->where('affiliate_commissions.status', '1')
                                              ->first();

        $netTotal = AffiliateCommission::select(DB::raw('SUM(comm_amount) AS netTotalCommission'))
                                       ->where('status', '1')
                                       ->first();
        

        return view('backend.reports.download_commission_report', ['commissions'=>$commissions, 'totalCommission'=>$totalCommission]);

    }

    
}
