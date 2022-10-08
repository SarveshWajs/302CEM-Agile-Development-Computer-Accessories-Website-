<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use App\Admin;
use App\Merchant;
use App\Affiliate;
use App\VerifyCode;
use App\State;
use App\SettingRefferalReward;
use App\AgentLevel;
use App\SettingMerchantBonus;
use App\AffiliateCommission;
use App\AgentRebateHistory;
use App\Transaction;
use App\AffiliateDual;
use App\TopupTransaction;
use App\SettingAffiliateTopup;
use App\WithdrawalTransaction;
use App\TransferProductWallet;
use App\AdjustProductWallet;

use App\Exports\AgentAboutExport;

use Validator, Redirect, Toastr, DB, File, Auth, Excel;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchants = Merchant::select('l.agent_lvl AS l_agent_lvl', 'merchants.*')
                             ->leftJoin('agent_levels AS l', 'l.id', 'merchants.lvl')
                             ->whereNotIn('merchants.status', ['99', '3'])
                             ->orderBy('merchants.created_at', 'desc');

        if(Auth::guard('merchant')->check()){
            $merchants = $merchants->where('master_id', Auth::user()->code);
        }
        $queries = [];
        $columns = [
            'code', 'merchant_name', 'lvl', 'status', 'agent_type'
        ];
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'merchant_name'){
                    $merchants = $merchants->where(DB::raw('CONCAT(f_name, " ", l_name)'), 'like', "%".request($column)."%");
                }elseif($column == 'status'){
                    $merchants = $merchants->where('merchants.status', 'like', "%".request($column)."%");
                }else{
                    $merchants = $merchants->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }
        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }
        $merchants = $merchants->paginate($per_page)->appends($queries);
        $agent_lvls = AgentLevel::get();
        $packages = SettingAffiliateTopup::get();

        $agentProductBalance = [];
        foreach($merchants as $merchant){
            $agentProductBalance[$merchant->code] = $this->GetProductWalletBalance($merchant->code);
        }

        return view('backend.merchants.index', ['merchants'=>$merchants, 'agent_lvls'=>$agent_lvls, 'packages'=>$packages],
                                                compact('agentProductBalance'));
    }


    public function pending_merchant()
    {

        $merchants = Merchant::where('status', '99')->orderBy('created_at', 'desc');
        if(Auth::guard('merchant')->check()){
            $merchants = $merchants->where('master_id', Auth::user()->code);
        }
        $queries = [];
        $columns = [
            'merchant_name', 'code'
        ];
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'merchant_name'){
                    $merchants = $merchants->where(DB::raw('CONCAT(f_name, " ", l_name)'), 'like', "%".request($column)."%");
                }else{
                    $merchants = $merchants->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }
        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }
        $merchants = $merchants->paginate($per_page)->appends($queries);

        $topup_bank_slip = [];
        foreach($merchants as $merchant){
            $topup_bank_slip[$merchant->code] = TopupTransaction::where('user_id', $merchant->code)
                                                                ->where('status', '99')
                                                                ->orderBy('created_at', 'asc')
                                                                ->first();
        }

        return view('backend.merchants.pending', ['merchants'=>$merchants], compact('topup_bank_slip'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::get();
        $levels = AgentLevel::get();
        $aff_topups = SettingAffiliateTopup::get();

        return view('backend.merchants.create', ['states'=>$states, 'levels'=>$levels, 'aff_topups'=>$aff_topups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'phone' => ['required', 'unique:merchants', 'unique:users', 'unique:admins'],
            'email' => ['required', 'unique:merchants', 'unique:users', 'unique:admins'],
            'password' => ['required', 'min:6'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        if(!empty($request->e_shop_name)){
            $checkMerch = Merchant::get();
            foreach ($checkMerch as $merchant) {
                if(($request->e_shop_name == $merchant->e_shop_name) && ($merchant->status != '3')){
                    return Redirect::back()->withInput(Input::all())->withErrors("E-Shop Name is similar to active users");
                }
            }
        }

        if(!empty($request->agent_pno)){
            $checkmAff = Merchant::where('code', $request->agent_pno)->first();
            $checkaAff = Admin::where('code', $request->agent_pno)->first();
            if(empty($checkmAff->id) && empty($checkaAff->id)){
                return Redirect::back()->withInput(Input::all())->withErrors("Refferal Code Not Exists");
            }

            if(!empty($checkmAff->id)){
                $master_id = $checkmAff->code;
                $agent_lvl = $checkmAff->lvl;
            }else{
                $master_id = $checkaAff->code;
                $agent_lvl = $checkaAff->lvl;
            }
            
        }else{
            $master_id = "AD000001";
            $agent_lvl = "";
        }

        $input = $request->all();
        $input['country_code'] = $request->country_code;
        $input['master_id'] = $master_id;
        $input['f_name'] = htmlspecialchars(trim($request->f_name));
        $input['l_name'] = htmlspecialchars(trim($request->l_name));
        $input['gender'] = htmlspecialchars(trim($request->gender));
        $input['phone'] = htmlspecialchars(trim($request->phone));
        $input['code'] = htmlspecialchars(trim($this->MerchantCode()));
        $input['email'] = htmlspecialchars(trim($request->email));
        $input['address'] = htmlspecialchars(trim($request->email));
        $input['password'] = Hash::make($request->password);

        $merchant = Merchant::create($input);

        if($master_id == 'AD000001'){
              $affiliate = Affiliate::create(['affiliate_id' => $merchant->code,
                                              'user_id' => 'AD000001',
                                              'sort_level' => '1']);
        }else{
            //downline
            $create = Affiliate::create(['affiliate_id'=>$merchant->code,
                                         'user_id'=>$master_id,
                                         'sort_level' => '1']);

            $getAff = Affiliate::where('affiliate_id', $master_id)->orderBy('id', 'asc')->get();
            $affiliate = [];
            $sort_level = 2;
            foreach($getAff as $aff){

                $affiliate[] = [
                                'affiliate_id' => $merchant->code,
                                'user_id' => $aff->user_id,
                                'sort_level' => $sort_level++,
                                'status' => '1',
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s'),
                               ];
            }
            $insert = Affiliate::insert($affiliate);
        }

        if(!empty($request->packages_list)){

            $selectTPKG = SettingAffiliateTopup::find($request->packages_list);
            $profit_bonus = 0;
            if(!empty($selectTPKG->profit_amount)){
              if($selectTPKG->profit_type == 'Percentage'){
                $profit_bonus = $selectTPKG->topup_amount * $selectTPKG->profit_amount / 100;
              }else{
                $profit_bonus = $selectTPKG->profit_amount;
              }
            }

            $profit_display = "";

            if($profit_bonus > 0){
                $profit_display = " + (RM ".$profit_bonus.")";
            }
            
            $input_topup = [];
            $input_topup['topup_payment_method'] = '2';
            $input_topup['topup_no'] = $this->GenerateTopupNo();
            $input_topup['user_id'] = $merchant->code;
            $input_topup['amount'] = $selectTPKG->topup_amount + $profit_bonus;
            $input_topup['actual_amount'] = $selectTPKG->topup_amount;
            $input_topup['amount_desc'] = "RM ".$selectTPKG->topup_amount.$profit_display;
            $input_topup['package_id'] = $selectTPKG->id;
            $input_topup['topup_type'] = '2';
            $input_topup['created_by'] = Auth::user()->code;
            $input_topup['status'] = "1";

            $createTopup = TopupTransaction::create($input_topup);
        }

        Toastr::success("$merchant->f_name Created!");
        return redirect()->route('merchant.merchants.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $merchant = Merchant::select('merchants.*', DB::raw('COALESCE(m.code, a.code) AS master_code'))
                            ->leftJoin('merchants AS m', 'm.code', 'merchants.master_id')
                            ->leftJoin('admins AS a', 'a.code', 'merchants.master_id')
                            ->where('merchants.id', $id)
                            ->first();

        $levels = AgentLevel::get();

        $aff_topups = SettingAffiliateTopup::get();

        return view('backend.merchants.edit', ['merchant'=>$merchant, 'levels'=>$levels, 'aff_topups'=>$aff_topups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }


        $input = $request->all();
        $input['f_name'] = htmlspecialchars(trim($request->f_name));
        $input['l_name'] = htmlspecialchars(trim($request->l_name));

        $merchant = Merchant::find($id);

        if(!empty($request->e_shop_name)){
            // $checkMerch = Merchant::get();
            $checkMerch = Merchant::where('e_shop_name', $request->e_shop_name)
                                  ->where('code', '<>', $merchant->code)
                                  ->where('status', '!=', '3')
                                  ->exists();
            if($checkMerch == 1){
                return Redirect::back()->withInput(Input::all())->withErrors("E-Shop Name is similar to active users");
            }  
        }

        $merchant_name = $merchant->f_name;
        $merchant = $merchant->update($input);

        Toastr::success("$merchant_name Updated!");
        return redirect()->route('merchant.merchants.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // protected function MerchantCode()
    // {
    //     $user = Merchant::select(DB::raw("COUNT(id) AS totalUser"))->first();
    //     $totalCount = $user->totalUser + 1;

    //     if(strlen($totalCount) == '1'){
    //         $member_id = "M00000".$totalCount;
    //     }elseif(strlen($totalCount) == '2'){
    //         $member_id = "M0000".$totalCount;
    //     }elseif(strlen($totalCount) == '3'){
    //         $member_id = "M000".$totalCount;
    //     }elseif(strlen($totalCount) == '4'){
    //         $member_id = "M00".$totalCount;
    //     }elseif(strlen($totalCount) == '5'){
    //         $member_id = "M0".$totalCount;
    //     }else{
    //         $member_id = "M".$totalCount;
    //     }

    //     return $member_id;
    // }

    protected function MerchantCode()
    {
        $id = mt_rand(10000,99999);

        $generated_id = "MYA".$id;

        $agent = Merchant::get();

        foreach ($agent as $agents) {
            if ($agents->code == $generated_id) {
                return MerchantCode();
            }
            else{
                return $generated_id;
            }
        }
    }

    public function saveNewPassword(Request $request, $id)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->new_password);
        $update = Merchant::find($id);
        $update = $update->update($input);

        Toastr::success("Password Changed!");
        return redirect()->route('merchant.merchants.edit', $id);
    }

    public function RebateAgentCommission($user_id, $agent_lvl)
    {
        $countAff = Merchant::select(DB::raw('COUNT(id) AS totalAff'))
                                    ->where('master_id', $user_id)
                                    ->where('status', '1')
                                    ->first();

        // $lvl = AgentLevel::where('agent_lvl', $agent_lvl)->first();
        // if(!empty($lvl->lvl)){
        //     $agent_lvl = $lvl->id;
        // }else{
        //     $agent_lvl = "";
        // }
        $totalAgentAff = 0;

        if(!empty($countAff->totalAff)){
            $totalAgentAff = $countAff->totalAff;
        }


        $selectBate = SettingMerchantBonus::where(DB::raw('CAST(qty AS UNSIGNED INTEGER)'), '<=', $totalAgentAff)
                                           ->where('agent_lvl', $agent_lvl)
                                           ->orderBy('amount', 'desc')
                                           ->first();
        

        if(!empty($selectBate->id)){
            if($selectBate->type == '1'){
                //累计人数
                $exists = AgentRebateHistory::where('user_id', $user_id)
                                            ->where('commision_id', $selectBate->id)
                                            ->exists();
                // return $exists;
                if($exists != 1){                            
                  $create = AffiliateCommission::create(['type'=>'1',
                                                         'user_id'=>$user_id,
                                                         'comm_pa_type'=>'Amount',
                                                         'comm_pa'=>$selectBate->amount,
                                                         'comm_amount'=>$selectBate->amount,
                                                         'comm_desc'=>"Agent Bonus - You've hit the agent bonus target of ".$totalAgentAff." and you get RM ".$selectBate->amount." bonus"]);

                  $createH = AgentRebateHistory::create(['user_id'=>$user_id,
                                                               'commision_id'=> $selectBate->id]);
                }
            }elseif($selectBate->type == '2'){
                //每个月
                $countMonthAff = Merchant::select(DB::raw('COUNT(id) AS totalAff'))
                                    ->where('master_id', $user_id)
                                    ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), date('Y-m'))
                                    ->first();
                
                if(!empty($countMonthAff->totalAff)){
                    $exists = AgentRebateHistory::join('setting_merchant_rebates AS r', 'r.id', 'agent_rebate_histories.commision_id')
                                                ->where('user_id', $user_id)
                                                ->where('commision_id', $selectBate->id)
                                                ->where(DB::raw('DATE_FORMAT(agent_rebate_histories.created_at, "%Y-%m")'), date('Y-m'))
                                                ->exists();
                    if($exists != 1){
                        
                        $create = AffiliateCommission::create(['type'=>'1',
                                                               'user_id'=>$user_id,
                                                               'comm_pa_type'=>'Amount',
                                                               'comm_pa'=>$selectBate->amount,
                                                               'comm_amount'=>$selectBate->amount,
                                                               'comm_desc'=>"Agent Bonus - You've hit the agent bonus target of ".$totalAgentAff." and you get RM ".$selectBate->amount." bonus"]);

                        $createH = AgentRebateHistory::create(['user_id'=>$user_id,
                                                               'commision_id'=> $selectBate->id]);

                    }
                }
            }elseif($selectBate->type == '3'){
                //每个星期
                $countMonthAff = Merchant::select(DB::raw('COUNT(id) AS totalAff'))
                                    ->where('master_id', $user_id)
                                    ->whereBetween('created_at', [
                                        Carbon\Carbon::parse('last monday')->startOfDay(),
                                        Carbon\Carbon::parse('next friday')->endOfDay(),
                                    ])
                                    ->first();
                
                if(!empty($countMonthAff->totalAff)){
                    $exists = AgentRebateHistory::join('setting_merchant_rebates AS r', 'r.id', 'agent_rebate_histories.commision_id')
                                                ->where('user_id', $user_id)
                                                ->where('commision_id', $selectBate->id)
                                                ->whereBetween('agent_rebate_histories.created_at', [
                                                    Carbon\Carbon::parse('last monday')->startOfDay(),
                                                    Carbon\Carbon::parse('next friday')->endOfDay(),
                                                ])
                                                ->exists();
                    if($exists != 1){
                      $create = AffiliateCommission::create(['type'=>'1',
                                                             'user_id'=>$user_id,
                                                             'comm_pa_type'=>'Amount',
                                                             'comm_pa'=>$selectBate->amount,
                                                             'comm_amount'=>$selectBate->amount,
                                                             'comm_desc'=>"Agent Bonus - You've hit the agent bonus target of ".$totalAgentAff." and you get RM ".$selectBate->amount." bonus"]);

                      $createH = AgentRebateHistory::create(['user_id'=>$user_id,
                                                             'commision_id'=> $selectBate->id]);
                    }
                }
            }elseif($selectBate->type == '4'){
                //每年
                $countMonthAff = Merchant::select(DB::raw('COUNT(id) AS totalAff'))
                                    ->where('master_id', $user_id)
                                    ->where(DB::raw('DATE_FORMAT(created_at, "%Y")'), date('Y'))
                                    ->first();

                if(!empty($countMonthAff->totalAff)){

                    $exists = AgentRebateHistory::join('setting_merchant_rebates AS r', 'r.id', 'agent_rebate_histories.commision_id')
                                                ->where('user_id', $user_id)
                                                ->where('commision_id', $selectBate->id)
                                                ->where(DB::raw('DATE_FORMAT(agent_rebate_histories.created_at, "%Y")'), date('Y'))
                                                ->exists();

                    if($exists != 1){
                      $create = AffiliateCommission::create(['type'=>'1',
                                                             'user_id'=>$user_id,
                                                             'comm_pa_type'=>'Amount',
                                                             'comm_pa'=>$selectBate->amount,
                                                             'comm_amount'=>$selectBate->amount,
                                                             'comm_desc'=>"Agent Bonus - You've hit the agent bonus target of ".$totalAgentAff." and you get RM ".$selectBate->amount." bonus"]);

                      $createH = AgentRebateHistory::create(['user_id'=>$user_id,
                                                             'commision_id'=> $selectBate->id]);
                    }
                }
            }
        }
    }

    public function AgentUpgrade($master_id)
    {

        $levels = AgentLevel::get();
        $merchant = Merchant::where('code', $master_id)->first();
        
        if(!empty($merchant->id)){
          foreach($levels as $level){
              // echo $level->agent_lvl.' - '.$level->product_id.' - '.$level->buy_quantity;
              // echo "<br>";

              $transaction1 = Transaction::select(DB::raw('SUM(d.quantity) AS totalQty'))
                                                    ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                                    ->where('user_id', $master_id)
                                                    ->where('transactions.status', '1')
                                                    ->first();

              $transaction2 = Transaction::select(DB::raw('SUM(d.quantity) AS totalQty'))
                                                    ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                                    ->where('user_id', $master_id)
                                                    ->where('d.product_id', $level->product_id)
                                                    ->where('transactions.status', '1')
                                                    ->first();

              

              $affiliate = Merchant::select(DB::raw('COUNT(id) AS totalAffiliate'))
                                           ->where('master_id', $master_id)
                                           ->where('status', '1')
                                           ->first();

              if(!empty($level->product_id) && !empty($level->affiliate_quantity) && $level->affiliate_quantity != 0){
                  if($level->product_id == 'all' && $affiliate->totalAffiliate >= $level->affiliate_quantity){

                      if($transaction1->totalQty >= $level->buy_quantity){
                          $merchant1 = Merchant::find($merchant->id);
                          $merchant1 = $merchant1->update(['lvl'=>$level->id]);
                      }

                  }else{
                      

                      if($transaction2->totalQty >= $level->buy_quantity && $affiliate->totalAffiliate >= $level->affiliate_quantity){
                          $merchant1 = Merchant::find($merchant->id);
                          $merchant1 = $merchant1->update(['lvl'=>$level->id]);
                      }
                  }
              }else{
                  if(!empty($level->product_id)){
                      if($level->product_id == 'all'){
                          
                          if($transaction1->totalQty >= $level->buy_quantity){
                              $merchant1 = Merchant::find($merchant->id);
                              $merchant1 = $merchant1->update(['lvl'=>$level->id]);
                          }
                      }else{
                          

                          if($transaction2->totalQty >= $level->buy_quantity){

                              $merchant1 = Merchant::find($merchant->id);
                              $merchant1 = $merchant1->update(['lvl'=>$level->id]);
                          }
                      }
                  }

                  if(!empty($level->affiliate_quantity) && $level->affiliate_quantity != 0){
                      

                      if($affiliate->totalAffiliate >= $level->affiliate_quantity){
                          $merchant1 = Merchant::find($merchant->id);
                          $merchant1 = $merchant1->update(['lvl'=>$level->id]);
                      }
                  }                
              }
              
          }
          
          $detail = Merchant::where('code', $master_id)->first();

          
          return $detail->lvl;
        }

        
    }


    public function tree($agent_code)
    {
        $merchant = Merchant::where('code', $agent_code)->first();
        $admin = Merchant::where('code', $agent_code)->first();

        $merchantD = Merchant::where('master_id', $agent_code)
                             ->where('status', '1')
                             ->get();

        $mdd = [];
        $mddd = [];
        $sg  = 0;
        $tg  = 0;
        foreach($merchantD as $merchantdv){
            $mdd[$merchantdv->code] = Merchant::where('master_id', $merchantdv->code)->where('status', '1')->get();
            $sg += count($mdd[$merchantdv->code]);

            foreach($mdd[$merchantdv->code] as $mddv){
                $mddd[$mddv->code] = Merchant::where('master_id', $mddv->code)->where('status', '1')->get();
                $tg += count($mddd[$mddv->code]);
            }
        }

        $fg = count($merchantD);
        

        $total = $fg + $sg + $tg;
        // echo $tg;
        if($total > 0){
            $fgp = round($fg / $total * 100, 2);
            $sgp = round($sg / $total * 100, 2);
            $tgp = round($tg / $total * 100, 2);            
        }else{
            $fgp = 0;
            $sgp = 0;
            $tgp = 0;            
        }


        return view('backend.merchants.tree', ['merchantD'=>$merchantD, 'merchant'=>$merchant,
                                               'fg'=>$fg, 'fgp'=>$fgp,
                                               'sg'=>$sg, 'sgp'=>$sgp,
                                               'tg'=>$tg, 'tgp'=>$tgp], compact('mdd', 'mddd'));
    }

     public function tree_details($agent_code, $g)
    {
        if(!empty($g) && $g <= 3 && $g > 0){
            if($g == '1'){
                $generation = "1st";
            }elseif($g == '2'){
                $generation = "2nd";
            }else{
                $generation = "3th";
            }            
        }else{
            abort(404);
        }


        if($g == 1){
            $merchants = Merchant::where('master_id', $agent_code)
                                 ->where('status', '1')
                                 ->get();
        }elseif($g == 2){
            $merchants = Merchant::select('d.*')
                                 ->join('merchants AS d', 'd.master_id', 'merchants.code')
                                 ->where('merchants.master_id', $agent_code)
                                 ->where('d.status', '1')
                                 ->get();

        }else{
            $merchants = Merchant::select('dd.*')
                                 ->join('merchants AS d', 'd.master_id', 'merchants.code')
                                 ->join('merchants AS dd', 'dd.master_id', 'd.code')
                                 ->where('merchants.master_id', $agent_code)
                                 ->where('dd.status', '1')
                                 ->get();
        }


        return view('backend.merchants.tree_details', ['generation'=>$generation, 'merchants'=>$merchants]);
    }

    public function GenerateTopupNo()
    {
      $topup = TopupTransaction::select(DB::raw('COUNT(id) AS TotalTopup'))->first();
      $TotalTopup = $topup->TotalTopup + 1;

      if(strlen($TotalTopup) == 1){
          $TNo = 'T'.strtotime(date('Y-m-d H:i:s'))."0000".$TotalTopup;
      }elseif(strlen($TotalTopup) == 2){
          $TNo = 'T'.strtotime(date('Y-m-d H:i:s'))."000".$TotalTopup;
      }elseif(strlen($TotalTopup) == 3){
          $TNo = 'T'.strtotime(date('Y-m-d H:i:s'))."00".$TotalTopup;
      }elseif(strlen($TotalTopup) == 4){
          $TNo = 'T'.strtotime(date('Y-m-d H:i:s'))."0".$TotalTopup;
      }else{
          $TNo = 'T'.strtotime(date('Y-m-d H:i:s')).$TotalTopup;
      }
      return $TNo;
    }

    public function GetProductWalletBalance($buyerCode)
    {   
        $balance = AffiliateCommission::select(DB::raw('SUM(comm_amount) as totalBalance'))
                                      ->where('user_id', $buyerCode)
                                      ->where('status', '1')
                                      ->first();

        $withdrawal = WithdrawalTransaction::select(DB::raw('SUM(amount) as totalWithdrawal'))
                                             ->where('user_id', $buyerCode)
                                             ->where('status', '1')
                                             ->first();

        $transaction = Transaction::select(DB::raw('SUM(grand_total) AS totalUsedPoint'))
                                  ->where('user_id', $buyerCode)
                                  ->where('mall', '1')
                                  ->where('status', '1')
                                  ->first();
        
        $topup = TopupTransaction::select(DB::raw('SUM(amount) as TotalTopup'))
                                 ->where('user_id', $buyerCode)
                                 ->where('status', '1')
                                 ->first();
        
        $transferPW = TransferProductWallet::select(DB::raw('SUM(amount) as TotaltransferPW'))
                                           ->where('user_id', $buyerCode)
                                           ->where('status', '1')
                                           ->first();

        $deductWallet = Transaction::select(DB::raw('SUM(grand_total - shipping_fee - processing_fee) as TotalGrandTotal'))
                                   ->join('users as u', 'u.code', 'transactions.user_id')
                                   ->where('u.master_id', $buyerCode)
                                   ->where('deduct_wallet', 1)
                                   ->first();

        $adjustWallet = AdjustProductWallet::select(DB::raw('SUM(amount) as totalAdjust'))
                                           ->where('status', '1')
                                           ->where('type', '1')
                                           ->where('user_id', $buyerCode)
                                           ->first();

        $adjustDeductWallet = AdjustProductWallet::select(DB::raw('SUM(amount) as totalAdjust'))
                                           ->where('status', '1')
                                           ->where('type', '2')
                                           ->where('user_id', $buyerCode)
                                           ->first();


        $totalBalance = 0;
        
        $totalBalance = $topup->TotalTopup - $transaction->totalUsedPoint + $transferPW->TotaltransferPW - $deductWallet->TotalGrandTotal + $adjustWallet->totalAdjust - $adjustDeductWallet->totalAdjust;
        

        return $totalBalance;
    }

    public function agent_about()
    {
        $merchants = Merchant::select('l.agent_lvl AS l_agent_lvl', 'merchants.*')
                             ->leftJoin('agent_levels AS l', 'l.id', 'merchants.lvl')
                             ->whereNotIn('merchants.status', ['99', '3'])
                             ->orderBy('merchants.created_at', 'desc');

        if(Auth::guard('merchant')->check()){
            $merchants = $merchants->where('master_id', Auth::user()->code);
        }
        $queries = [];
        $columns = [
            'code', 'merchant_name', 'lvl', 'status', 'agent_type'
        ];
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'merchant_name'){
                    $merchants = $merchants->where(DB::raw('CONCAT(f_name, " ", l_name)'), 'like', "%".request($column)."%");
                }elseif($column == 'status'){
                    $merchants = $merchants->where('merchants.status', 'like', "%".request($column)."%");
                }else{
                    $merchants = $merchants->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }
        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }
        $merchants = $merchants->paginate($per_page)->appends($queries);
        $agent_lvls = AgentLevel::get();
        $packages = SettingAffiliateTopup::get();

        $agentProductBalance = [];
        foreach($merchants as $merchant){
            $agentProductBalance[$merchant->code] = $this->GetProductWalletBalance($merchant->code);
        }

        return view('backend.merchants.about', ['merchants'=>$merchants, 'agent_lvls'=>$agent_lvls, 'packages'=>$packages],
                                                compact('agentProductBalance'));
    }

    public function print_agent_list()
    {
        $merchants = Merchant::select('l.agent_lvl AS l_agent_lvl', 'merchants.*')
                             ->leftJoin('agent_levels AS l', 'l.id', 'merchants.lvl')
                             ->get();

        $agent_lvls = AgentLevel::get();


        return view('backend.merchants.print_agent_list', ['merchants'=>$merchants]);
    }

    public function exportAgentAbout()
    {
        $start = "";
        $end = "";
        return Excel::download(new AgentAboutExport($start, $end), 'AgentAbout'.strtotime(now()).'.xlsx');
    }

    public function Adjust($id)
    {
        $merchant = Merchant::find($id);
        if(!isset($merchant) && empty($merchant)){
            abort(404);
        }

        $adjusts = AdjustProductWallet::where('user_id', $merchant->code)
                         ->where('status', '1')
                         ->orderBy('created_at', 'desc');

        $itemPerPage = 10;
        if(request()->has('per_page') && !empty(request('per_page'))){
            $itemPerPage = request('per_page');
        }
        $queries = [];
        $columns = [
            'type', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                
                if($column == 'status'){
                    $adjusts = $adjusts->where($column, ''.request($column).'');
                }else{
                    $adjusts = $adjusts->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }

        $GetProductWalletBalance = $this->GetProductWalletBalance($merchant->code);

        $adjusts = $adjusts->paginate($itemPerPage)->appends($queries);

        return view('backend.merchants.adjust', ['merchant'=>$merchant, 'adjusts'=>$adjusts, 
                                               'GetProductWalletBalance'=>$GetProductWalletBalance]);
    }

    public function SubmitAdjust(Request $request, $id)
    {
        $merchant = Merchant::find($id);
        $GetProductWalletBalance = $this->GetProductWalletBalance($merchant->code);

        $validator = Validator::make($request->all(), [
            'adjust_type' => 'required',
            'adjust_amount' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }


        if($GetProductWalletBalance < $request->adjust_amount && $request->adjust_type == '2'){
            return Redirect::back()->withInput(Input::all())->withErrors('Amount Exceed! Amount More Than Balance.');
        }

        $input = [];
        $input['user_id'] = $merchant->code;
        $input['amount'] = preg_replace("/[^0-9\.]/", '', $request->adjust_amount);
        $input['type'] = $request->adjust_type;
        $input['remark'] = $request->remark;
        $input['created_by'] = Auth::user()->code;
        $input['updated_by'] = Auth::user()->code;

        $AdjustProductWallet = AdjustProductWallet::create($input);

        Toastr::success("$request->type Create Successfully!");
        return redirect()->route('adjust', $id);
    }

    public function BalanceQuantity($id)
    {
        $stockBalance = Stock::select(DB::raw('SUM(IF(type = "Increase", quantity, NULL)) AS totalStockIn'),
                                      DB::raw('SUM(IF(type = "Decrease", quantity, NULL)) AS totalStockOut'))
                                ->where('product_id', $id)
                                ->first();

        $cart = Cart::select(DB::raw('SUM(qty) AS InCart'))
                    ->where('status', '1')
                    ->where('product_id', $id)
                    ->first();

        $transaction = TransactionDetail::select(DB::raw('SUM(quantity) AS TransCart'))
                                        ->join('transactions AS t', 't.id', 'transaction_details.transaction_id')
                                        ->whereIn('t.status', ['1', '97', '98', '99'])
                                        ->where('product_id', $id)
                                        ->whereNull('variation_id')
                                        ->first();

        return $stockBalance->totalStockIn - $stockBalance->totalStockOut - $cart->InCart - $transaction->TransCart;
    }
}
