<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SettingMerchantBonus;
use App\SettingMerchantRebate;
use App\SettingMerchantCommission;
use App\SettingPerformanceDividend;
use App\SettingPerformanceMain;
use App\SettingTeamDividend;
use App\SettingTeamMain;
use App\SettingRefferalReward;
use App\AgentLevel;
use App\Product;
use App\Transaction;
use App\Merchant;
use App\SettingShippingFee;
use App\SettingUom;
use App\SettingBanner;
use App\SettingBannerTesting;
use App\SettingBannerVideo;
use App\SettingDualMain;
use App\SettingDualCommission;
use App\SettingMonthlyAgentSalesBonus;
use App\SettingDownlineBonus;
use App\State;
use App\SettingPickUpAddress;
use App\SettingGalleryImage;
use App\SettingTopup;
use App\SettingExtraCashRebate;
use App\SettingAffiliateTopup;
use App\SettingCharge;

use Validator, Redirect, Toastr, DB, File;

class SettingController extends Controller
{   
    public function setting_merchant_bonus()
    {
        $selects = SettingMerchantBonus::get();
        $levels = AgentLevel::where('status', '1')->get();

        // $selectDetails = [];

        // foreach($selects as $select){
        //     $selectDetails[$select->agent_lvl] = array($select->id, $select->type, $select->amount);
        // }

        return view('backend.settings.setting_merchant_bonus', ['selects'=>$selects, 'levels'=>$levels]);
    }

    public function save_setting_merchant_bonus(Request $request)
    {
        $insert = [];
        $caseString = $caseString1 = $caseString2 = 'case id';
        $ids = '';

        for($a=0; $a<count($request->amount); $a++){

            if(!empty($request->sid[$a])){
                
                $sid = $request->sid[$a];
                $qty = $request->qty[$a];
                $type = $request->type[$a];
                $amount = $request->amount[$a];

                $caseString .= " when $sid then '$qty'";
                $caseString1 .= " when $sid then '$type'";
                $caseString2 .= " when $sid then '$amount'";

                $ids .= "$sid,";
            }else{
                
                if(!empty($request->amount[$a])){
                    
                    $insert[] = [
                                    "agent_lvl"=>$request->lvl[$a],
                                    "qty"=>$request->qty[$a],
                                    "type"=>$request->type[$a],
                                    "amount"=>$request->amount[$a],
                                ];
                }
            }
            
        }
        
        $ids = trim($ids, ',');

        $create = SettingMerchantBonus::insert($insert);
        if($ids != ''){
            DB::update("update setting_merchant_bonuses set qty = $caseString end,
                                                            type = $caseString1 end,
                                                            amount = $caseString2 end
                                                            where id in ($ids)");
        }

        Toastr::success("Setting Agent Rebate Successful");
        return redirect()->route('setting_merchant_bonus');
    } 

    public function setting_agent_rebate()
    {
    	$selects = SettingMerchantRebate::get();
        $levels = AgentLevel::where('status', '1')->get();
        $selectDetails = [];

        foreach($selects as $select){
            $selectDetails[$select->agent_lvl] = array($select->id, $select->type, $select->amount,
                                                       $select->personal_sale, $select->line_group_sale);
        }

        return view('backend.settings.setting_agent_rebate', ['selects'=>$selects, 'levels'=>$levels], compact('selectDetails'));
    }

    public function save_setting_agent_rebate(Request $request)
    {
        $caseString1 = $caseString2 = $caseString3 = $caseString4 = 'case id';
        $ids = '';
        $insert = [];
        for($a=0; $a<count($request->agent_lvl); $a++){
            if(!empty($request->sid[$a])){
                //Update
                $id = $request->sid[$a];
                $type = $request->type[$a];
                $amount = $request->amount[$a];
                $personal_sale = $request->personal_amount[$a];
                $line_group_sale = $request->line_group[$a];

                $caseString1 .= " when $id then '$type'";
                $caseString2 .= " when $id then '$amount'";
                $caseString3 .= " when $id then '$personal_sale'";
                $caseString4 .= " when $id then '$line_group_sale'";

                $ids .= "$id,";

            }else{
                //Create
                if(!empty($request->amount[$a])){
                    $insert[] = [
                                    'agent_lvl'=>$request->agent_lvl[$a],
                                    'type'=>$request->type[$a],
                                    'amount'=>$request->amount[$a],
                                    'personal_sale'=>$request->personal_amount[$a],
                                    'line_group_sale'=>$request->line_group[$a]
                                ];
                }
            }
        }

        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update setting_merchant_rebates set type = $caseString1 end,
                                                amount = $caseString2 end,
                                                personal_sale = $caseString3 end,
                                                line_group_sale = $caseString4 end
                                                where id in ($ids)");
        }


        $create = SettingMerchantRebate::insert($insert);

        Toastr::success("Merchant Bonus Updated!");
        return redirect()->route('setting_agent_rebate');
    }

    public function setting_merchant_commission()
    {
        $setting_merchant_commissions = SettingMerchantCommission::get();
        $levels = AgentLevel::get();
        $value = [];
        foreach($setting_merchant_commissions as $smc){
            $value[$smc->level][$smc->agent_lvl] = array($smc->comm_type, $smc->comm_amount, $smc->id);
        }

        return view('backend.settings.setting_merchant_commission', ['levels'=>$levels], compact('value'));
    }

    public function save_setting_merchant_commission(Request $request)
    {
        $caseString = $caseString1 = "case id";
        $ids = '';

        $insert = [];
        for($a=0; $a<count($request->comm_amount); $a++){
            if(!empty($request->ids[$a])){
                //Update
                $id = $request->ids[$a];
                $comm_type = $request->comm_type[$a];
                $comm_amount = $request->comm_amount[$a];

                $caseString .= " when $id then '$comm_type'";
                $caseString1 .= " when $id then '$comm_amount'";

                $ids .= "$id,";
            }else{
                //Create

                if(!empty($request->comm_amount[$a])){
                    $insert[] = [
                                    'agent_lvl'=>$request->agent_lvl[$a],
                                    'level'=>$request->level[$a],
                                    'comm_type'=>$request->comm_type[$a],
                                    'comm_amount'=>$request->comm_amount[$a]
                                ];
                }
            }
        }

        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update setting_merchant_commissions set comm_type = $caseString end,
                                                                comm_amount = $caseString1 end
                                                                where id in ($ids)");
        }


        $create = SettingMerchantCommission::insert($insert);

        Toastr::success("Setting Affiliate Bonus Successful");
        return redirect()->route('setting_merchant_commission');
    }

    public function setting_performance_dividend()
    {
        $selects = SettingPerformanceDividend::get();
        $levels = AgentLevel::get();
        $setting = SettingPerformanceMain::first();

        $selectDetails = [];

        foreach($selects as $select){
            $selectDetails[$select->lvl] = array($select->id, $select->type, $select->amount, $select->target);
        }

        return view('backend.settings.setting_performance_dividend', ['levels'=>$levels, 'setting'=>$setting], compact('selectDetails'));
    }

    public function save_setting_performance_dividend(Request $request)
    {
           
        $input = $request->all();
        
        $insert = [];
        $caseString1 = $caseString2 = $caseString3 = 'case id';

        $ids = "";
        for($a=0; $a<count($request->amount); $a++){

            if(!empty($request->sid[$a])){
                $sid = $request->sid[$a];

                $amount = $request->amount[$a];
                $lvl = $request->lvl[$a];
                $target = $request->target[$a];

                $caseString1 .= " when $sid then '$target'";
                $caseString2 .= " when $sid then '$amount'";
                $caseString3 .= " when $sid then '$lvl'";

                $ids .= "$sid,";
            }else{
                if(!empty($request->amount[$a])){

                    $insert[] = [
                                    "target"=>$request->target[$a],
                                    "amount"=>$request->amount[$a],
                                    "lvl"=>$request->lvl[$a],
                                ];
                }
            }
            
        }
        $ids = trim($ids, ',');

        $create = SettingPerformanceDividend::insert($insert);
        if($ids != ''){
            DB::update("update setting_performance_dividends set amount = $caseString2 end,
                                                                    lvl = $caseString3 end,
                                                                 target = $caseString1 end
                                                               where id in ($ids)");
        }

        $checkSetting = SettingPerformanceMain::first();
        if(!empty($checkSetting->id)){
            $setting = SettingPerformanceMain::find(1);
            $setting = $setting->update($input);
        }else{
            $setting = SettingPerformanceMain::create($input);            
        }
        

        Toastr::success("Setting Performance Dividend Successful");
        return redirect()->route('setting_performance_dividend');
    }

     public function setting_team_dividend()
    {
        $selects = SettingTeamDividend::get();
        $levels = AgentLevel::get();
        $setting = SettingTeamMain::first();

        $selectDetails = [];

        foreach($selects as $select){
            $selectDetails[$select->lvl] = array($select->id, $select->target_box, $select->amount, $select->target);
        }

        return view('backend.settings.setting_team_dividend', ['levels'=>$levels, 'setting'=>$setting], compact('selectDetails'));
    }

    public function save_setting_team_dividend(Request $request)
    {
        $input = $request->all();
        
        $insert = [];
        $caseString2 = $caseString3 = $caseString4 = 'case id';

        $ids = "";
        for($a=0; $a<count($request->amount); $a++){

            if(!empty($request->sid[$a])){
                $sid = $request->sid[$a];

                $target_box = $request->target_box[$a];
                $amount = $request->amount[$a];
                $lvl = $request->lvl[$a];

                $caseString2 .= " when $sid then '$amount'";
                $caseString3 .= " when $sid then '$lvl'";
                $caseString4 .= " when $sid then '$target_box'";

                $ids .= "$sid,";
            }else{
                if(!empty($request->amount[$a])){

                    $insert[] = [
                                    "target_box"=>$request->target_box[$a],
                                    "amount"=>$request->amount[$a],
                                    "lvl"=>$request->lvl[$a],
                                ];
                }
            }
            
        }
        $ids = trim($ids, ',');

        $create = SettingTeamDividend::insert($insert);
        if($ids != ''){
            DB::update("update setting_team_dividends set amount = $caseString2 end,
                                                             lvl = $caseString3 end,
                                                      target_box = $caseString4 end
                                                        where id in ($ids)");
        }
        
        $checkSetting = SettingTeamMain::first();
        if(!empty($checkSetting->id)){
            $setting = SettingTeamMain::find(1);
            $setting = $setting->update($input);
        }else{
            $setting = SettingTeamMain::create($input);            
        }

        Toastr::success("Setting Performance Dividend Successful");
        return redirect()->route('setting_team_dividend');
    }


    public function setting_recommend_bonus()
    {
        $selects = SettingRefferalReward::get();
        $levels = AgentLevel::get();

        $selectDetails = [];

        foreach($selects as $select){
            $selectDetails[$select->agent_lvl] = array($select->id, $select->amount);
        }

        return view('backend.settings.setting_recommend_bonus', ['levels'=>$levels], compact('selectDetails'));
    }

    public function save_setting_recommend_bonus(Request $request)
    {
        $insert = [];
        $caseString = 'case id';

        $ids = "";

        for($a=0; $a<count($request->amount); $a++){
            if(!empty($request->ids[$a])){
                //Update
                $id = $request->ids[$a];

                $amount = $request->amount[$a];

                $caseString .= " when $id then '$amount'";

                $ids .= "$id,";
            }else{
                //Create

                if(!empty($request->amount[$a])){

                    $insert[] = [
                                    "agent_lvl"=>$request->agent_lvl[$a],
                                    "amount"=>$request->amount[$a],
                                ];
                }
            }
        }

        $ids = trim($ids, ',');

        $create = SettingRefferalReward::insert($insert);
        if($ids != ''){
            DB::update("update setting_refferal_rewards set amount = $caseString end
                                                        where id in ($ids)");
        }

        Toastr::success("Setting Recommended Reward Successful");
        return redirect()->route('setting_recommend_bonus');
    }

    public function setting_agent_level()
    {
        $products = Product::where('status', '1')->get();
        $levels = AgentLevel::where('status', '1')->get();
        
        return view('backend.settings.setting_agent_lvl', ['products'=>$products, 'levels'=>$levels]);
    }

    public function setting_agent_level_save(Request $request)
    {
        $caseString = $caseString1 = $caseString2 = $caseString3 = 'case id';
        $ids = '';

        $insert = [];
        for($a=0; $a<count($request->agent_lvl); $a++){
            if(!empty($request->lvl_id[$a])){
                //Update

                $id = $request->lvl_id[$a];
                $agent_lvl = $request->agent_lvl[$a];
                $product_id = $request->product_id[$a];
                $buy_quantity = $request->buy_quantity[$a];
                $affiliate_quantity = $request->affiliate_quantity[$a];

                $caseString .= " when $id then '$agent_lvl'";
                $caseString1 .= " when $id then '$product_id'";
                $caseString2 .= " when $id then '$buy_quantity'";
                $caseString3 .= " when $id then '$affiliate_quantity'";

                $ids .= "$id,";
            }else{
                //Create
                if(!empty($request->agent_lvl[$a])){
                    $insert[] = [
                                    'agent_lvl'=>$request->agent_lvl[$a],
                                    'product_id'=>$request->product_id[$a],
                                    'buy_quantity'=>$request->buy_quantity[$a],
                                    'affiliate_quantity'=>$request->affiliate_quantity[$a],
                                ];
                }                
            }
        }
        //Update
        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update agent_levels set agent_lvl = $caseString end,
                                                            product_id = $caseString1 end,
                                                            buy_quantity = $caseString2 end,
                                                            affiliate_quantity = $caseString3 end
                                                            where id in ($ids)");
        }

        //Insert
        $create = AgentLevel::insert($insert);


        Toastr::success("Agent Level Setting Updated!");
        return redirect()->route('setting_agent_level');
    }

    public function setting_shipping_fee()
    {
        $settingShippingFees = SettingShippingFee::get();
        return view('backend.settings.setting_shipping_fee', ['settingShippingFees'=>$settingShippingFees]);
    }

    public function save_setting_shipping_fee(Request $request)
    {
        $b = [];
        $caseString = $caseString1 = $caseString2 = 'case id';
        $ids = '';
        for($a=0; $a<count($request->type); $a++){
            if(empty($request->sid[$a])){
                if(!empty($request->weight[$a]) && !empty($request->shipping_fee[$a])){
                    $b[] = [
                              "area"=>$request->type[$a],
                              "weight"=>$request->weight[$a],
                              "shipping_fee"=>$request->shipping_fee[$a],
                           ];
                }
            }else{
                $sid = $request->sid[$a];
                $area = $request->type[$a];
                $weight = $request->weight[$a];
                $shipping_fee = $request->shipping_fee[$a];

                $caseString .= " when $sid then '$area'";
                $caseString1 .= " when $sid then '$weight'";
                $caseString2 .= " when $sid then '$shipping_fee'";

                $ids .= "$sid,";
            }
        }

        $insert = SettingShippingFee::insert($b);
        

        
        $ids = trim($ids, ',');
        if($ids != ''){
            DB::update("update setting_shipping_fees set area = $caseString end,
                                                                weight = $caseString1 end,
                                                                shipping_fee = $caseString2 end
                                                            where id in ($ids)");
        }

        Toastr::success("Shipping Fee Setting Successful");
        return redirect()->route('setting_shipping_fee');
    }

    public function setting_uom()
    {
        $select = SettingUom::get();

        return view('backend.settings.setting_uom', ['setting_uoms'=>$select]);
    }


    public function setting_uom_save(Request $request)
    {
        $caseString = 'case id';
        $ids = '';

        $insert = [];
        for($a=0; $a<count($request->uom_name); $a++){
            if(!empty($request->uid[$a])){
                //Update

                $id = $request->uid[$a];
                $uom_name = $request->uom_name[$a];

                $caseString .= " when $id then '$uom_name'";

                $ids .= "$id,"; 
            }else{
                //Create
                if(!empty($request->uom_name[$a])){
                    $insert[] = [
                                    'uom_name'=>$request->uom_name[$a],
                                    'status'=>'1',
                                    'created_at'=>date('Y-m-d H:i:s'),
                                    'updated_at'=>date('Y-m-d H:i:s'),
                                ];
                }                
            }
        }
        //Update
        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update setting_uoms set uom_name = $caseString end
                                                            where id in ($ids)");
        }

        //Insert
        $create = SettingUom::insert($insert);

        Toastr::success("Updated UOM setting Successful");
        return redirect()->route('setting_uom');
    }

    public function setting_banner()
    {
        // $select = SettingUom::get();
        return view('backend.settings.setting_banner');
    }

    public function setting_banner_testing()
    {
        // $select = SettingUom::get();
        return view('backend.settings.setting_banner_testing');
    }

    public function setting_banner_video()
    {
        // $select = SettingUom::get();
        $select = SettingBannerVideo::find(1);
        return view('backend.settings.setting_banner_video', ['select'=>$select]);
    }

    public function setting_pop_up_image()
    {
        // $select = SettingUom::get();
        return view('backend.settings.setting_pop_up_image');
    }

    public function setting_dual_commission()
    {
        $levels = AgentLevel::where('status', '1')->get();
        $SettingDualMain = SettingDualMain::find(1);

        $SettingDualCommission = [];
        foreach($levels as $level){
            $SettingDualCommission[$level->id] = SettingDualCommission::where('agent_lvl', $level->id)->first();
        }

        return view('backend.settings.setting_dual_commission', ['levels'=>$levels, 'SettingDualMain'=>$SettingDualMain],
                                                                compact('SettingDualCommission'));
    }

    public function save_setting_dual_commission(Request $request)
    {
        $SettingDualMain = SettingDualMain::find(1);
        if(!empty($SettingDualMain->id)){
            $SettingDualMain = $SettingDualMain->update(['comm_type'=>$request->commission_p_t_type,
                                                         'comm_amount'=>$request->commission_p_t]);
        }else{
            $insertDualMain = SettingDualMain::insert(['comm_type'=>$request->commission_p_t_type,
                                                       'comm_amount'=>$request->commission_p_t,
                                                       'status'=>'1',
                                                       'created_at'=>date('Y-m-d H:i:s'),
                                                       'updated_at'=>date('Y-m-d H:i:s')]);
        }
        // SettingDualCommission
        $caseString = $caseString1 = 'case id';
        $ids = '';
        $insert = [];
        for($a=0; $a<count($request->level_comm_amount); $a++){
            if(!empty($request->did[$a])){

                $id = $request->did[$a];
                $level_comm_type = $request->level_comm_type[$a];
                $level_comm_amount = $request->level_comm_amount[$a];

                $caseString .= " when $id then '$level_comm_type'";
                $caseString1 .= " when $id then '$level_comm_amount'";

                $ids .= "$id,"; 
            }else{
                $insert[] = ['agent_lvl'=>$request->agent_lvl[$a],
                             'comm_type'=>$request->level_comm_type[$a],
                             'comm_amount'=>$request->level_comm_amount[$a],
                             'status'=>'1',
                             'created_at'=>date('Y-m-d H:i:s'),
                             'updated_at'=>date('Y-m-d H:i:s')];
            }
        }
        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update setting_dual_commissions set comm_type = $caseString end,
                                                            comm_amount = $caseString1 end
                                                            where id in ($ids)");
        }

        $create = SettingDualCommission::insert($insert);

        Toastr::success("Update Successful");
        return redirect()->route('setting_dual_commission');
    }

    public function setting_agent_monthly_sales_bonus()
    {
        $monthly_s = SettingMonthlyAgentSalesBonus::where('monthly_type', '1')->get();
        $quaterly_s = SettingMonthlyAgentSalesBonus::where('monthly_type', '2')->get();

        return view('backend.settings.setting_agent_monthly_sales_bonus', ['monthly_s'=>$monthly_s, 'quaterly_s'=>$quaterly_s]);
    }

    public function save_setting_agent_monthly_sales_bonus(Request $request)
    {
        $insert = [];
        $caseString = $caseString1 =  $caseString2 = 'case id';
        $ids = '';
        for($a=0; $a<count($request->m_target_amount); $a++){
            if(!empty($request->mid[$a])){

                $id = $request->mid[$a];
                $m_target_amount = $request->m_target_amount[$a];
                $m_comm_type = $request->m_comm_type[$a];
                $m_comm_amount = $request->m_comm_amount[$a];

                $caseString .= " when $id then '$m_target_amount'";
                $caseString1 .= " when $id then '$m_comm_type'";
                $caseString2 .= " when $id then '$m_comm_amount'";

                $ids .= "$id,"; 

            }else{
                if(!empty($request->m_target_amount[$a])){
                    $insert[] = ['monthly_type'=>'1',
                                 'target'=>$request->m_target_amount[$a],
                                 'comm_type'=>$request->m_comm_type[$a],
                                 'comm_amount'=>$request->m_comm_amount[$a],
                                 'status'=>'1',
                                 'created_at'=>date('Y-m-d H:i:s'),
                                 'updated_at'=>date('Y-m-d H:i:s')];                    
                }
            }
        }

        $create = SettingMonthlyAgentSalesBonus::insert($insert);

        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update setting_monthly_agent_sales_bonuses set target = $caseString end,
                                                                       comm_type = $caseString1 end,
                                                                       comm_amount = $caseString2 end
                                                                   where id in ($ids)");
        }

        $insert_q = [];
        $caseString3 = $caseString4 =  $caseString5 = 'case id';
        $qids = '';
        for($b=0; $b<count($request->q_target_amount); $b++){
            if(!empty($request->qid[$b])){
                $qid = $request->qid[$b];
                $q_target_amount = $request->q_target_amount[$b];
                $q_comm_type = $request->q_comm_type[$b];
                $q_comm_amount = $request->q_comm_amount[$b];

                $caseString3 .= " when $qid then '$q_target_amount'";
                $caseString4 .= " when $qid then '$q_comm_type'";
                $caseString5 .= " when $qid then '$q_comm_amount'";

                $qids .= "$qid,"; 
            }else{
                if(!empty($request->q_target_amount[$b])){
                    $insert_q[] = ['monthly_type'=>'2',
                                   'target'=>$request->q_target_amount[$b],
                                   'comm_type'=>$request->q_comm_type[$b],
                                   'comm_amount'=>$request->q_comm_amount[$b],
                                   'status'=>'1',
                                   'created_at'=>date('Y-m-d H:i:s'),
                                   'updated_at'=>date('Y-m-d H:i:s')];                    
                }
            }
        }

        $create = SettingMonthlyAgentSalesBonus::insert($insert_q);

        $qids = trim($qids, ',');

        if($qids != ''){
            DB::update("update setting_monthly_agent_sales_bonuses set target = $caseString3 end,
                                                                       comm_type = $caseString4 end,
                                                                       comm_amount = $caseString5 end
                                                                   where id in ($qids)");
        }

        Toastr::success("Update Successful");
        return redirect()->route('setting_agent_monthly_sales_bonus');
    }

    public function setting_downline_bonus()
    {
        $levels = AgentLevel::get();
        $settings = SettingDownlineBonus::get();

        return view('backend.settings.setting_downline_bonus', ['levels'=>$levels, 'settings'=>$settings]);
    }

    public function save_setting_downline_bonus(Request $request)
    {

        $caseString3 = $caseString4 =  $caseString5 = 'case id';
        $ids = '';
        for($a=0; $a<count($request->level_id); $a++){
            $l = $request->level_id[$a];

            for($b=0; $b<count($request['target'.$l]); $b++){
                if(!empty($request['lid'.$l][$b])){
                    $id = $request['lid'.$l][$b];
                    $q_target_amount = $request['target'.$l][$b];
                    $q_comm_type = $request['comm_type'.$l][$b];
                    $q_comm_amount = $request['comm_amount'.$l][$b];

                    $caseString3 .= " when $id then '$q_target_amount'";
                    $caseString4 .= " when $id then '$q_comm_type'";
                    $caseString5 .= " when $id then '$q_comm_amount'";

                    $ids .= "$id,";
                }else{
                    if(!empty($request['comm_amount'.$l][$b])){
                        SettingDownlineBonus::insert(
                                                      ['level_id'=>$l,
                                                       'target'=>$request['target'.$l][$b],
                                                       'comm_type'=>$request['comm_type'.$l][$b],
                                                       'comm_amount'=>$request['comm_amount'.$l][$b]
                                                      ]
                                                    );
                    }
                }
            }
        }

        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update setting_downline_bonuses set target = $caseString3 end,
                                                            comm_type = $caseString4 end,
                                                            comm_amount = $caseString5 end
                                                        where id in ($ids)");
        }

        Toastr::success("Update Successful");
        return redirect()->route('setting_downline_bonus');
    }

    public function setting_pick_up_address()
    {
        $states = State::get();
        $select = SettingPickUpAddress::first();

        return view('backend.settings.setting_pick_up_address', ['states'=>$states, 'select'=>$select]);
    }

    public function save_setting_pick_up_address(Request $request)
    {
        $input = $request->all();

        $select = SettingPickUpAddress::get();

        if(!$select->isEmpty()){
            $shipping = SettingPickUpAddress::find(1);
            $shipping = $shipping->update($input);
        }else{
            $shipping = SettingPickUpAddress::create($input);
        }

        Toastr::success("The courier pickup address is saved successfully");
        return redirect()->route('setting_pick_up_address');
    }

    public function setting_gallery_image()
    {
         return view('backend.settings.setting_gallery_image');
    }

    public function setting_topup_amount()
    {
        $selects = SettingTopup::get();
        return view('backend.settings.setting_topup_amount', ['selects'=>$selects]);
    }

    public function save_setting_topup_amount(Request $request)
    {
        $caseString3 = $caseString4 = $caseString5 = 'case id';
        $ids = '';
        for($a=0; $a<count($request['topup_amount']); $a++){
            if(!empty($request['tid'][$a])){
                $id = $request['tid'][$a];
                $topup_amount = $request['topup_amount'][$a];
                $profit_type = $request['profit_type'][$a];
                $profit_amount = $request['profit_amount'][$a];

                $caseString3 .= " when $id then '$topup_amount'";
                $caseString4 .= " when $id then '$profit_type'";
                $caseString5 .= " when $id then '$profit_amount'";

                $ids .= "$id,";
            }else{
                if(!empty($request['topup_amount'][$a])){
                    SettingTopup::insert(
                                          [
                                            'topup_amount'=>$request->topup_amount[$a],
                                            'profit_type'=>$request->profit_type[$a],
                                            'profit_amount'=>$request->profit_amount[$a]
                                          ]
                                        );
                }
            }
        }

        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update setting_topups set topup_amount = $caseString3 end,
                                                  profit_type = $caseString4 end,
                                                  profit_amount = $caseString5 end
                                              where id in ($ids)");
        }

        Toastr::success("Topup Amount Saved!");
        return redirect()->route('setting_topup_amount');
    }

    public function setting_extra_cash_rebate()
    {
        $selects = SettingExtraCashRebate::get();
        $levels = AgentLevel::where('status', '1')->get();
        $selectDetails = [];

        foreach($selects as $select){
            $selectDetails[$select->agent_lvl] = array($select->id, $select->type, $select->amount,
                                                       $select->personal_sale, $select->line_group_sale);
        }

        return view('backend.settings.setting_extra_cash_rebate', ['selects'=>$selects, 'levels'=>$levels],
                                                              compact('selectDetails'));
    }

    public function save_setting_extra_cash_rebate(Request $request)
    {
        $caseString1 = $caseString2 = 'case id';
        $ids = '';
        $insert = [];
        for($a=0; $a<count($request->agent_lvl); $a++){
            if(!empty($request->sid[$a])){
                //Update
                $id = $request->sid[$a];
                $type = $request->type[$a];
                $amount = $request->amount[$a];

                $caseString1 .= " when $id then '$type'";
                $caseString2 .= " when $id then '$amount'";

                $ids .= "$id,";

            }else{
                //Create
                if(!empty($request->amount[$a])){
                    $insert[] = [
                                    'agent_lvl'=>$request->agent_lvl[$a],
                                    'type'=>$request->type[$a],
                                    'amount'=>$request->amount[$a]
                                ];
                }
            }
        }

        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update setting_merchant_rebates set type = $caseString1 end,
                                                amount = $caseString2 end
                                                where id in ($ids)");
        }


        $create = SettingExtraCashRebate::insert($insert);

        Toastr::success("Extra Cash Rebate Updated!");
        return redirect()->route('setting_extra_cash_rebate');
    }

    public function setting_affiliate_topups()
    {
        $selects = SettingAffiliateTopup::get();
        return view('backend.settings.setting_affiliate_topup_amount', ['selects'=>$selects]);
    }

    public function save_setting_affiliate_topups(Request $request)
    {
        $caseString3 = $caseString4 = $caseString5 = 'case id';
        $ids = '';
        for($a=0; $a<count($request['topup_amount']); $a++){
            if(!empty($request['tid'][$a])){
                $id = $request['tid'][$a];
                $topup_amount = $request['topup_amount'][$a];
                $profit_type = $request['profit_type'][$a];
                $profit_amount = $request['profit_amount'][$a];

                $caseString3 .= " when $id then '$topup_amount'";
                $caseString4 .= " when $id then '$profit_type'";
                $caseString5 .= " when $id then '$profit_amount'";

                $ids .= "$id,";
            }else{
                if(!empty($request['topup_amount'][$a])){
                    SettingAffiliateTopup::insert(
                                          [
                                            'topup_amount'=>$request->topup_amount[$a],
                                            'profit_type'=>$request->profit_type[$a],
                                            'profit_amount'=>$request->profit_amount[$a]
                                          ]
                                        );
                }
            }
        }

        $ids = trim($ids, ',');

        if($ids != ''){
            DB::update("update setting_affiliate_topups set topup_amount = $caseString3 end,
                                                            profit_type = $caseString4 end,
                                                            profit_amount = $caseString5 end
                                                        where id in ($ids)");
        }

        Toastr::success("Topup Amount Saved!");
        return redirect()->route('setting_affiliate_topups');
    }

    public function setting_charges()
    {
        $setting_charges = SettingCharge::first();

        return view('backend.settings.setting_charges', ['setting_charges'=>$setting_charges]);
    }

    public function save_setting_charges(Request $request)
    {
        $setting_charges = SettingCharge::find(1);

        if(!empty($setting_charges->id)){
            $setting_charges = $setting_charges->update(['purchase_charges_type'=>$request->purchase_charges_type,
                                                         'purchase_charges_amount'=>$request->purchase_charges_amount,
                                                         'withdrawal_charges_type'=>$request->withdrawal_charges_type,
                                                         'withdrawal_charges_amount'=>$request->withdrawal_charges_amount,
                                                         'transfer_wallet_charges_type'=>$request->transfer_wallet_charges_type,
                                                         'transfer_wallet_charges_amount'=>$request->transfer_wallet_charges_amount,
                                                        ]);
        }else{
            $input = [];
            $input['purchase_charges_type'] = $request->purchase_charges_type;
            $input['purchase_charges_amount'] = $request->purchase_charges_amount;
            $input['withdrawal_charges_type'] = $request->withdrawal_charges_type;
            $input['withdrawal_charges_amount'] = $request->withdrawal_charges_amount;
            $input['transfer_wallet_charges_type'] = $request->transfer_wallet_charges_type;
            $input['transfer_wallet_charges_amount'] = $request->transfer_wallet_charges_amount;

            SettingCharge::create($input);
        }

        Toastr::success("Setting Saved!");
        return redirect()->route('setting_charges');
    }

    public function uploadBannerVideo(Request $request)
    {
        $select = SettingBannerVideo::find(1);
        if(!empty($request->file('filename'))){
            $files = $request->file('filename'); 
            $name = $files->getClientOriginalName();
            $exp = explode(".", $name);
            $file_ext = end($exp);
            $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
              
            $input = $request->all();
              
            $input['status'] = '1';
            $input['video'] = "uploads/bannervideo/".$name;

            $files->move("uploads/bannervideo/", $name);
            if(!empty($select->id)){ 
                $select = $select->update(['video'=>"uploads/bannervideo/".$name]);
            }else{ 
                $product_image = SettingBannerVideo::create($input);
            }
        }
        

        Toastr::success("Setting Saved!");
        return redirect()->route('setting_banner_video');
        
    }
}
