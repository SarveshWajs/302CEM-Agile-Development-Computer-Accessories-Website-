<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Cart;
use App\Transaction;
use App\WithdrawalTransaction;

use App\SettingPerformanceMain;
use App\SettingPerformanceDividend;
use App\Merchant;
use App\User;
use App\Affiliate;
use App\AffiliateCommission;
use App\TopupTransaction;
use App\OveridingQualification;
use App\SettingMerchantRebate;
use App\AgentLevel;

use App\SettingTeamMain;
use App\SettingTeamDividend;
use App\SettingMonthlyAgentSalesBonus;
use App\SettingDownlineBonus;

use DB;

date_default_timezone_set("Asia/Kuala_Lumpur");
class RunPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:cronjob';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Cron Job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        //Clear Cart
        $cart = Cart::where(DB::raw('DATE_ADD(created_at, INTERVAL 7 DAY)'), '<=', date('Y-m-d H:i:s'))->delete();

        $transaction = Transaction::where('status', '99')->where(DB::raw('DATE_ADD(created_at, INTERVAL 7 DAY)'), '<=', date('Y-m-d H:i:s'))->update(['status'=>'55']);

        $lastYear = date("Y",strtotime("-1 year"));
        $lastMonth = date("Y-m", strtotime("previous month"));
        // $yesterday = date('Y-m-d', strtotime("-1 days"));
        $yesterday = "2020-12-23";

        $allmerchants = Merchant::where('status', '1')->get();

        $merchants = Merchant::where('status', '1')->where('lvl', '6')->get();

        if(date('Y-m-d') == date('Y-01-01')){
          $yearlySales = $this->getYearTotalSales();
          $yearlyTopup = $this->getYearTotaltopup();

          $totalSales = $yearlySales * 2 / 100;
          $netSales = $totalSales / $yearlyTopup;

          foreach($merchants as $merchant){
              $toplvlGroupLvl[$merchant->code] = $this->getTotalGroupTopup($merchant->code);

              if($toplvlGroupLvl[$merchant->code] > 0 && $netSales > 0){
                AffiliateCommission::create(['type'=>'11',
                                             'user_id'=>$merchant->code,
                                             'product_amount'=>$yearlySales,
                                             'product_qty'=>$toplvlGroupLvl[$merchant->code],
                                             'comm_pa_type'=>'Amount',
                                             'comm_pa'=>$netSales,
                                             'comm_amount'=>$netSales * $toplvlGroupLvl[$merchant->code],
                                             'status'=>'99',
                                             'comm_desc'=>'President Council Pool Bonus - '.$lastYear]);
              }
          }
        }
        
        // Yesterday Topup
        $topups = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalTopup'), 'user_id')
                                  ->where('status', '1')
                                  ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), $yesterday)
                                  ->groupBy('user_id')
                                  ->get();

        $non_deduct_wallets = Transaction::select(DB::raw('SUM(grand_total - processing_fee - shipping_fee) as totalPurchase'), 'user_id')
                                        ->join('users as u', 'u.code', 'transactions.user_id')
                                        ->whereNull('transactions.deduct_wallet')
                                        ->where('transactions.status', '1')
                                        ->where(DB::raw('DATE_FORMAT(transactions.created_at, "%Y-%m-%d")'), $yesterday)
                                        ->groupBy('transactions.user_id')
                                        ->get();

        $checkCommission = AffiliateCommission::where('status', '99')
                                              ->where(DB::raw('DATE_ADD(DATE_FORMAT(created_at, "%Y-%m-%d"), INTERVAL 12 DAY)'), '=', date('Y-m-d'))
                                              ->update(['status'=>'1']);

        foreach($topups as $topup){
            $this->cashRebate($topup->user_id, $topup->totalTopup, '1', $topup->user_id);
        }

        foreach($non_deduct_wallets as $non_deduct_wallet){
            $upline = User::where('code', $non_deduct_wallet->user_id)->first();
            $this->cashRebate($upline->master_id, $non_deduct_wallet->totalPurchase, '2', $non_deduct_wallet->user_id);
        }

            $this->checkQualification();

        foreach($allmerchants as $allmerchant){
            $this->AgentUpgrade($allmerchant->code);
        }
    }


    public function cashRebate($user_id, $totalAmount, $type, $own)
    {
        $affiliates = Affiliate::select('affiliates.*', 'm.lvl as upline_lvl', 'user_id as m_user_id', 'm.created_at as m_created_at')
                               ->join('merchants as m', 'm.code', 'affiliates.user_id')
                               ->where('affiliate_id', $user_id)
                               ->where('user_id', '!=', 'AD000001')
                               ->where('m.status', '1')
                               ->groupBy('m.code')
                               ->get();

        $mer = Merchant::select('merchants.*', 'lvl as upline_lvl', 'code as m_user_id', 
                                'merchants.created_at as m_created_at')
                       ->where('code', $user_id)
                       ->get();

        $all = $affiliates->concat($mer);
        $all = array_reverse(array_sort($all, function ($value) {
            return $value['m_created_at'];
        }));

        $uplineDetail = "";
        
        $ownDetail = Merchant::where('code', $user_id)->first();
        if(!empty($ownDetail->id)){
          $uplineDetail = Merchant::where('code', $ownDetail->master_id)->first();
        }

        foreach($all as $affiliate){
            //if(!empty($affiliate->upline_lvl))
              //if($affiliate->'upline_lvl','1') && ($affiliate->'point') {
               //$qualified = 0;
              //}

            if(!empty($affiliate->upline_lvl)){
              $SettingMerchantRebate = SettingMerchantRebate::where('agent_lvl', $affiliate->upline_lvl)->first();
              $qualified = 0; //gets the first agent with in rebate list with the same level 
              
              if(!empty($SettingMerchantRebate->personal_sale) || !empty($SettingMerchantRebate->line_group_sale)){
                  if(!empty($uplineDetail->id) && $uplineDetail->code == $affiliate->m_user_id){
                      $qualified = '1';
                  }else{
                    $oq = OveridingQualification::where('user_id', $affiliate->m_user_id)->first();
                    if(!empty($oq->id)){
                      $qualified = '1'; //qualified for cash rebate if the agent's personal sale or line_group_sale is not equal to 0
                    }
                  }
              }else{
                  $qualified = '1';
              }

              if($qualified == 1){ 
                  if(isset($currentM)){
                    if($currentM != $affiliate->m_user_id){
                        if(!empty($current_comm)){
                          $pay_comm = $SettingMerchantRebate->amount - $current_comm; // if current merchant is qualified for cash rebate, the payout comm = fixed comm - current comm
                          if($pay_comm <= 0){
                            $notsame = $current_comm;
                            $current_comm = $current_comm;
                            continue;
                          }else{
                            $notsame = $pay_comm;
                            $current_comm = $SettingMerchantRebate->amount;
                          }
                        }else{
                          $pay_comm = $SettingMerchantRebate->amount;  //if current comm is empty, pay comm is set to default comm in table
                        }
                        $currentM = $affiliate->m_user_id;
                    }else{
                      if(isset($notsame)){
                        $pay_comm = $notsame;
                      }else{
                        $pay_comm = $SettingMerchantRebate->amount;
                      }
                    }

                  }else{
                    $currentM = $affiliate->m_user_id; //currentM is set to the agent specified in the loop
                    if(!empty($SettingMerchantRebate->amount)){
                      $current_comm = $SettingMerchantRebate->amount; 
                      $pay_comm = $SettingMerchantRebate->amount;
                    }
                  }

                  if(isset($pay_comm) && $pay_comm > 0){
                    // echo $pay_comm;
                    if($type == 2){
                      $comm_desc = 'Transaction Cash Rebate From #'.$user_id."'s Downline ".$own;
                    }else{
                      $comm_desc = 'Cash Rebate From #'.$user_id;
                    }
                    AffiliateCommission::create(['type'=>'8',
                                                 'user_id'=>$affiliate->m_user_id,
                                                 'product_amount'=>$totalAmount,
                                                 'comm_pa_type'=>'Percentage',
                                                 'comm_pa'=>$pay_comm,
                                                 'comm_amount'=>($totalAmount * $pay_comm / 100),
                                                 'status'=>'99',
                                                 'comm_desc'=>$comm_desc]);

                    // echo $affiliate->m_user_id.' Get Commission';
                    // echo "<br>";
                  }
              }
            }
        }
        // exit();

        //Extra 5%
        $merchant = Merchant::where('code', $user_id)->first();
        $upline = Merchant::where('code', $merchant->master_id)->first();

        if(!empty($merchant->id) && !empty($upline->id) && $merchant->lvl == 6){
            if($upline->lvl == $merchant->lvl){
                $uplineOQ = SettingMerchantRebate::where('agent_lvl', $upline->lvl)->first();
                $qualified = 0;
              
                if(!empty($uplineOQ->personal_sale) || !empty($uplineOQ->line_group_sale)){
                    $oq = OveridingQualification::where('user_id', $upline->code)->first();
                    if(!empty($oq->id)){
                      $qualified = '1';
                    }
                }
                if($qualified == 1){
                  AffiliateCommission::create(['type'=>'99',
                                               'user_id'=>$upline->code,
                                               'product_amount'=>$totalAmount,
                                               'comm_pa_type'=>'Percentage',
                                               'comm_pa'=>5,
                                               'comm_amount'=>($totalAmount * 5 / 100),
                                               'status'=>'99',
                                               'comm_desc'=>'Extra Cash Rebate From #'.$user_id]);
                  // echo $upline->code.' Get Extra Commission';
                  // echo "<br>";
                }
            }
        }
    }

    public function AgentUpgrade($user_id)
    {

        $merchant = Merchant::where('code', $user_id)->first();

        if(!empty($merchant->id)){
            $getTotalGroupTopup = $this->getTotalGroupTopup($user_id);

            $uplineAffs = Affiliate::select('affiliates.sort_level', 'affiliates.affiliate_id', 'affiliates.user_id')
                                     ->join('merchants as m', 'm.code', 'affiliates.user_id')
                                     ->where('affiliate_id', $user_id)
                                     ->where('user_id', '!=', 'AD000001')
                                     ->where('m.status', '1')
                                     ->get();

            foreach($uplineAffs as $upline){
                $getTotalGroupTopup = $this->getTotalGroupTopup($upline->user_id);
            }
        }
    }

    public function getTotalGroupTopup($user_id)
    {
        
        $merchant = Merchant::where('code', $user_id)->first();

        $downlineAffs = Affiliate::select('affiliates.sort_level', 'affiliates.affiliate_id', 'u.f_name')
                                 ->join('merchants AS u', 'u.code', 'affiliates.affiliate_id')
                                 ->where('user_id', $user_id)
                                 ->where('u.status', '1')
                                 ->orderBy('sort_level', 'asc')
                                 ->get();

        $myGroup = [];
        foreach($downlineAffs as $aff){
            $myGroup[] = $aff->affiliate_id;
        }
        
        $myGroupTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalAmount'))
                                           ->where('status', '1')
                                           ->whereIn('user_id', $myGroup)
                                           ->first();

        $myTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalAmount'))
                                           ->where('status', '1')
                                           ->where('user_id', $user_id)
                                           ->first();

        $downlineMems = User::whereIn('master_id', $myGroup)->get();
        $mydownlineMems = User::where('master_id', $user_id)->get();

        $DownlineMem = [];
        foreach($downlineMems as $downlineMem){
            $DownlineMem[] = $downlineMem->code;
        }

        $myDownlineMem = [];
        foreach($mydownlineMems as $mydownlineMem){
            $myDownlineMem[] = $mydownlineMem->code;
        }

        $DownMemTran = Transaction::select(DB::raw('SUM(grand_total - processing_fee - shipping_fee) as totalPurchase'))
                                  ->whereIn('user_id', $DownlineMem)
                                  ->where('status', '1')
                                  ->whereNull('deduct_wallet')
                                  ->first();

        $myMemTran = Transaction::select(DB::raw('SUM(grand_total - processing_fee - shipping_fee) as totalPurchase'))
                                  ->whereIn('user_id', $myDownlineMem)
                                  ->where('status', '1')
                                  ->whereNull('deduct_wallet')
                                  ->first();

        $myGroupTotal = $myTopup->totalAmount + $myGroupTopup->totalAmount + $DownMemTran->totalPurchase + $myMemTran->totalPurchase;

        $levels = AgentLevel::where('buy_quantity', '<=', $myGroupTotal)
                            ->orderBy('id', 'desc')
                            ->first();
        $merchant_lvl = !empty($merchant->lvl) ? $merchant->lvl : '0';
        if(!empty($levels->id) && $merchant_lvl < $levels->id){
          $ownLevel = Merchant::where('code', $user_id);
          $ownLevel = $ownLevel->update(['lvl'=>$levels->id]);

          echo $user_id.' Up level';
          echo "<br>";
        }

        // return $myGroupTotal;
    }

    public function checkQualification()
    {
        // $lastMonth = date("Y-m", strtotime("previous month"));
        $transaction = OveridingQualification::where(DB::raw('DATE_FORMAT(due_date, "%Y-%m-%d")'), '>', date('Y-m-d'))->delete();
        $lastMonth = date("Y-m");
        $nextMonth = date("Y-m-t", strtotime("+1 month"));

        $merchants = Merchant::where('status', '1')->get();

        foreach($merchants as $merchant)
        {
            $setting_rebates = SettingMerchantRebate::where('agent_lvl', $merchant->lvl)->first();
            if(!empty($setting_rebates->id)){
                if(!empty($setting_rebates->personal_sale) || !empty($setting_rebates->line_group_sale)){
                    // Agent 1 2 3 4 Personal Sales
                    $ownTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalAmount'))
                                                ->where('status', '1')
                                                ->where('user_id', $merchant->code)
                                                ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $lastMonth)
                                                ->first();

                    // Select Agent 1 2 3 4 All Direct Downlines
                    $selectDownlines = Merchant::where('master_id', $merchant->code)->get();
                    $totalCount[$merchant->code] = 0;
                    foreach($selectDownlines as $selectDownline){
                        // Select Agent 1 2 3 4 All Direct Downlines Group
                        $downlineAffs = Affiliate::select('affiliates.sort_level', 'affiliates.affiliate_id', 'u.f_name')
                                                 ->join('merchants AS u', 'u.code', 'affiliates.affiliate_id')
                                                 ->where('user_id', $selectDownline->code)
                                                 ->get();
                        // Select Agent 1 2 3 4 All Direct Downlines Group into an array
                        $myGroup = [];
                        foreach($downlineAffs as $aff){
                            $myGroup[] = $aff->affiliate_id;
                        }
                        // End Select Agent 1 2 3 4 All Direct Downlines Group into an array

                        // Select Agent 1 2 3 4 All Direct Downlines Group Sales 
                        $myGroupTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalAmount'))
                                                        ->where('status', '1')
                                                        ->whereIn('user_id', $myGroup)
                                                        ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $lastMonth)
                                                        ->first();

                        // Select Agent 1 2 3 4 All Direct Downlines Sales 
                        $myTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalAmount'))
                                                   ->where('status', '1')
                                                   ->where('user_id', $selectDownline->code)
                                                   ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $lastMonth)
                                                   ->first();

                        $TotalTopup = $myTopup->totalAmount + $myGroupTopup->totalAmount;

                        if($TotalTopup >= 2000){
                            $totalCount[$merchant->code]++;
                        }
                    }


                    if((!empty($totalCount[$merchant->code]) && $totalCount[$merchant->code] >= $setting_rebates->line_group_sale) || $ownTopup->totalAmount > $setting_rebates->personal_sale){
                        $boq = OveridingQualification::where('user_id', $merchant->code)->first();
                        if(!empty($boq->id)){
                          $updateOQ = OveridingQualification::find($boq->id);
                          $updateOQ = $updateOQ->update(['due_date'=>$nextMonth]);
                        }else{
                          $input = [];
                          $input['user_id'] = $merchant->code;
                          $input['due_date'] = $nextMonth;

                          OveridingQualification::create($input);
                          // echo $merchant->code.' hit qualification.';
                          // echo "<br>";
                        }
                    }
                }

            }
        }
    }

    public function getYearTotalSales()
    {
        $transaction = Transaction::select(DB::raw('SUM(grand_total - processing_fee - shipping_fee) as totalTransaction'))
                                  ->join('users as u', 'u.code', 'transactions.user_id')
                                  ->whereNull('deduct_wallet')
                                  ->where('status', '1')
                                  ->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), $lastYear)
                                  ->first();

        $topup = TopupTransaction::select(DB::raw('SUM(actual_amount) as TotalTopup'))
                                 ->where('status', '1')
                                 ->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), $lastYear)
                                 ->first();


        return $topup->TotalTopup + $transaction->totalTransaction;
    }

    public function getYearTotaltopup()
    {

        $topup = TopupTransaction::select(DB::raw('SUM(actual_amount) as TotalTopup'))
                                 ->where('status', '1')
                                 ->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), $lastYear)
                                 ->first();


        return $topup->TotalTopup;
    }
}
