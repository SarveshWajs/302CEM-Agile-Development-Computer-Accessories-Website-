<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\ProductImage;
use App\Cart;
use App\UserShippingAddress;
use App\Favourite;
use App\Product;
use App\Promotion;
use App\Transaction;
use App\TransactionDetail;
use App\BankAccount;
use App\AffiliateCommission;
use App\WithdrawalTransaction;
use App\Bank;
use App\AppliedPromotion;
use App\Merchant;
use App\Admin;
use App\User;
use App\VerifyCode;
use App\ProductVariation;
use App\SettingTopup;
use App\CartLink;
use App\RegisterWallet;
use App\TransferProductWallet;
use App\SettingCharge;
use App\SettingAffiliateTopup;


use Validator, Redirect, Toastr, DB, File, Auth, Session, DateTime;

class AjaxController extends Controller
{

    public function AddToCart(Request $request)
    {

    	if($request->quantity <= 0){
    		return "quantity error";
    	}

    	$product = Product::find($request->product_id);
      if($product->variation_enable == '1'){
          $BalanceQty = $this->VariationBalanceQuantity($request->sub_category_id);
      }else{
        if($product->packages == 1){
          $BalanceQty = "1000000000";
        }else{
          $BalanceQty = HomeController::BalanceQuantity($request->product_id);
        }        
      }

      if(!empty(Auth::guard('admin')->check())){
          $BuyerCode = Auth::guard('admin')->user()->code;
      }elseif(!empty(Auth::guard('merchant')->check())){
          $BuyerCode = Auth::guard('merchant')->user()->code;
      }elseif(!empty(Auth::guard('web')->check())){
          $BuyerCode = Auth::guard('web')->user()->code;
      }else{
        if(empty($_COOKIE['new_guest'])){
          $BuyerCode = setcookie('new_guest', strtotime(date('Y-m-d H:i:s')).rand(100000, 999999), time() + (86400 * 30), "/");
        }else{
          $BuyerCode = $_COOKIE['new_guest'];
        }
      }

      $product = Product::find($request->product_id);

      if($product->mall == 1){
          if(Auth::guard('admin')->check() || Auth::guard('merchant')->check()){
            $actual_price = (!empty($product->agent_special_price) && $product->agent_special_price != 0) ? $product->agent_special_price : $product->agent_price;
          }else{
            $actual_price = (!empty($product->special_price) && $product->special_price != 0) ? $product->special_price : $product->price;
          }
          $totalBalance = $this->GetWalletBalance();

          if($totalBalance < $actual_price){
              return "wallet not enough balance";
          }
      }


    	if($BalanceQty < $request->quantity){
    		return "quantity exceed error";
    	}

    	$check = Cart::where('user_id', $BuyerCode)
    			         ->where('product_id', $request->product_id)
    			         ->where('status', '1');

      if(isset($request->sub_category_id) && !empty($request->sub_category_id) && isset($request->second_sub_category_id) && !empty($request->second_sub_category_id)){
          $check = $check->where('sub_category_id', $request->sub_category_id)
                         ->where('second_sub_category_id', $request->second_sub_category_id);
      }

    	$check = $check->first();

    	if(isset($check) && !empty($check->id)){

    		$update = Cart::find($check->id);
    		$totalQty = $update->qty + $request->quantity;
    		if($totalQty <= $BalanceQty){
    			$update = $update->update(['qty'=>$totalQty]);
    		}else{
    			return "quantity personal exceed";
    		}

    		return "ok";
    	}

    	$input = $request->all();
      $input['product_id'] = $request->product_id;
      $input['sub_category_id'] = $request->sub_category_id;
    	$input['second_sub_category_id'] = $request->second_sub_category_id;
      $input['user_id'] = $BuyerCode;
    	$input['qty'] = $request->quantity;

    	$cart = Cart::create($input);

    	return "ok";
    }

    public function SelectCart(Request $request)
    {
        $amount = 0;
        $count = 0;
        $totalWeight = 0;
        if(!empty($request->cart_id)){

            $explode = explode(",", $request->cart_id);
            foreach(array_unique($explode) as $key => $value){
                $count++;
                $carts = Cart::select('carts.qty', 'p.weight', 
                                      DB::raw('COALESCE(special_price, price) AS actual_price'),
                                      DB::raw('COALESCE(agent_special_price, agent_price) AS agent_actual_price'), 'p.*')
                             ->join('products AS p', 'p.id', 'carts.product_id')
                             ->where(DB::raw('md5(carts.id)'), $value)
                             ->first();
                // if(Auth::guard('merchant')->check() || Auth::guard('admin')->check()){
                //     $amount += $carts->agent_actual_price * $carts->qty;                    
                // }else{
                //     $amount += $carts->actual_price * $carts->qty;
                // }
                if(!empty($carts->special_price)){
                  $amount += $carts->special_price * $carts->qty;
                }else{
                  $amount += $carts->price * $carts->qty;
                }
                $totalWeight += $carts->weight * $carts->qty;
            }
            
        }


        return array(number_format($amount, 2), $count, $totalWeight);
    }

    public function updateQuantity(Request $request)
    {

        $update = Cart::where(DB::raw('md5(id)'), $request->cart_id);
        $update = $update->update(['qty'=>$request->quantity]);

        $carts = Cart::select('carts.qty', DB::raw('COALESCE(special_price, price) AS actual_price'),
                                      DB::raw('COALESCE(agent_special_price, agent_price) AS agent_actual_price'), 'p.*')
                     ->join('products AS p', 'p.id', 'carts.product_id')
                     ->where(DB::raw('md5(carts.id)'), $request->cart_id)
                     ->first();

        // if(Auth::guard('merchant')->check() || Auth::guard('admin')->check()){
        //     return number_format($carts->agent_actual_price * $request->quantity, 2);
        // }else{
        //     return number_format($carts->actual_price * $request->quantity, 2);
        // }

        if(!empty($carts->special_price)){
          return number_format($carts->special_price * $request->quantity, 2);
        }else{
          return number_format($carts->price * $request->quantity, 2);
        }
    }

    public function deleteCart(Request $request)
    {
        
        $delete = Cart::where(DB::raw('md5(id)'), $request->cart_id);
        $delete = $delete->delete();

        
    }

    public function CountCart(Request $request)
    {
        if(!empty(Auth::guard('admin')->check())){
            $BuyerCode = Auth::guard('admin')->user()->code;
        }elseif(!empty(Auth::guard('merchant')->check())){
            $BuyerCode = Auth::guard('merchant')->user()->code;
        }elseif(!empty(Auth::guard('web')->check())){
            $BuyerCode = Auth::guard('web')->user()->code;
        }else{
          if(empty($_COOKIE['new_guest'])){
            $BuyerCode = setcookie('new_guest', strtotime(date('Y-m-d H:i:s')).rand(100000, 999999), time() + (86400 * 30), "/");
          }else{
            $BuyerCode = $_COOKIE['new_guest'];
          }
        }

        $cart = Cart::select(DB::raw('SUM(qty) AS totalCart'))
                    ->where('user_id', $BuyerCode)->first();

        $cartP = Cart::select(DB::raw("IF(special_price != '0', special_price, price) AS Price"),
                                      DB::raw("IF(agent_special_price != '0', agent_special_price, agent_price) AS AgentPrice"),
                                      DB::raw("IF(variation_agent_special_price != '0', variation_agent_special_price, variation_agent_price) AS VAgentPrice"),
                                      DB::raw("IF(variation_special_price != '0', variation_special_price, variation_price) AS VPrice"),
                                      'qty', 'variation_enable')
                            ->join('products AS p', 'p.id', 'carts.product_id')
                            ->leftJoin('product_variations AS v', 'v.id', 'carts.sub_category_id')
                            ->where('user_id', $BuyerCode)
                            ->get();
        $totalPrice = 0;
        
        foreach($cartP as $cartP_item){
          if(Auth::guard('merchant')->check() || Auth::guard('admin')->check()){
            if($cartP_item->variation_enable == 1){
              $totalPrice += $cartP_item->VAgentPrice * $cartP_item->qty;
            }else{
              $totalPrice += $cartP_item->AgentPrice * $cartP_item->qty;
            }
          }else{
            if($cartP_item->variation_enable == 1){
              $totalPrice += $cartP_item->VPrice * $cartP_item->qty;
            }else{
              $totalPrice += $cartP_item->Price * $cartP_item->qty;
            }
          }
        }
                            
        

        return array($cart->totalCart, $totalPrice);
    }

    public function changeDefaultAddress(Request $request)
    {
        $clearDefault = UserShippingAddress::where('user_id', Auth::user()->code)->update(['default' => NULL]);

        $setDefault = UserShippingAddress::where(DB::raw('md5(id)'), $request->address_id);
        $setDefault = $setDefault->update(['default' => '1']);

    }

    public function deleteAddress(Request $request)
    {
        $delete = UserShippingAddress::where(DB::raw('md5(id)'), $request->address_id);
        $delete = $delete->delete();
    }

    public function add_wish(Request $request)
    {
        $favourite = Favourite::where('user_id', Auth::user()->code)
                              ->where('product_id', $request->product_id)
                              ->first();

        if(!empty($favourite->id)){
          $delete = Favourite::find($favourite->id);
          $delete = $delete->delete();

          // return 0;
          $return_value = "2";
        }else{
          $create = Favourite::create(['user_id'=>Auth::user()->code,
                                       'product_id'=>$request->product_id]);
          // return 1;
          $return_value = "1";
        }

        $wish = Favourite::select(DB::raw('COUNT(id) AS totalWish'))
                                 ->where('user_id', Auth::user()->code)
                                 ->first();
                                 
        return array($return_value, $wish->totalWish);
    }


    public function add_to_wish(Request $request)
    {
        $favourite = Favourite::where('user_id', Auth::user()->code)
                              ->where('product_id', $request->product_id)
                              ->first();

        if(!empty($favourite->id)){
          return 0;
        }else{
          $create = Favourite::create(['user_id'=>Auth::user()->code,
                                       'product_id'=>$request->product_id]);
          return 1;
        }
    }


    public function remove_wish(Request $request)
    {
        
        $favourite = Favourite::where('user_id', Auth::user()->code)
                              ->where('product_id', $request->product_id)
                              ->first();

        $delete = Favourite::where('id', $favourite->id)->delete();
    }

    public function ApplyPromo(Request $request)
    {
        if(!empty(Auth::guard('admin')->check())){
            $BuyerCode = Auth::guard('admin')->user()->code;
        }elseif(!empty(Auth::guard('merchant')->check())){
            $BuyerCode = Auth::guard('merchant')->user()->code;
        }elseif(!empty(Auth::guard('web')->check())){
            $BuyerCode = Auth::guard('web')->user()->code;
        }else{
          if(empty($_COOKIE['new_guest'])){
            $BuyerCode = setcookie('new_guest', strtotime(date('Y-m-d H:i:s')).rand(100000, 999999), time() + (86400 * 30), "/");
          }else{
            $BuyerCode = $_COOKIE['new_guest'];
          }
        }

        if(!empty($request->use)){
          $update = AppliedPromotion::find($request->apid);
          $update = $update->update(['status'=>'1']);
          return "ok";
        }
           
        $promotion = Promotion::where('discount_code', $request->discount_code)
                              ->where('status', '1')
                              ->first();
        if(!empty($promotion->id)){
            $transaction = AppliedPromotion::select(DB::raw('COUNT(id) AS CodeBalance'))
                                           ->where('promotion_id', $promotion->id)
                                           ->where('status', '1')
                                           ->first();
          
            $codeBalance = $promotion->quantity - $transaction->CodeBalance;

            if($codeBalance <= 0){
                return 1;
            }

            if(!empty($promotion->start_date) && !empty($promotion->end_date)){
                $t = date('Y-m-d H:i:s');
                $today = date('Y-m-d H:i:s', strtotime($t));
                $start = date('Y-m-d H:i:s', strtotime($promotion->start_date));
                $end = date('Y-m-d H:i:s', strtotime($promotion->end_date));
                if(($today <= $start) || ($today >= $end)){
                    return 2;
                }                
            }

            if(!empty($promotion->products) && empty($request->save)){
                $product = Cart::whereIn('product_id', explode(",", $promotion->products))->where('user_id', $BuyerCode)->get();
                if($product->isEmpty()){
                    return 3;
                }
            }

            if($promotion->limit_type == 2){
                $transaction = Transaction::where('discount_code', $promotion->id)
                                          ->where('user_id', $BuyerCode)
                                          ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), date('Y-m-d'))
                                          ->where('status', '!=', '95')
                                          ->get();
                $count = count($transaction);


                if($count >= $promotion->usage_limit){
                    return 4;
                }
            }

            if($promotion->limit_type == 3){
                $transaction = AppliedPromotion::where('promotion_id', $promotion->id)
                                               ->where('user_id', $BuyerCode)
                                               ->where('status', '1')
                                               ->get();

                $count = count($transaction);

                // return $count;
                if($count >= $promotion->usage_limit){
                    return 4;
                }
            }
            // return $request->discount_code;
            $input = [];
            $input['promotion_id'] = $promotion->id;
            $input['user_id'] = $BuyerCode;
            $input['status'] = '1';
            

            if(!empty($request->save)){
              $checkApplied = AppliedPromotion::whereIn('status', ['1', '99'])->where('user_id', $BuyerCode)->where('promotion_id', $promotion->id)->first();
              if(!empty($checkApplied->id)){
                  return 6;
              }
              $input['status'] = '99';
            }

            if(!empty($request->checkout_apply)){
              $checkClaimed = AppliedPromotion::where('status', '99')->where('user_id', $BuyerCode)->where('promotion_id', $promotion->id)->first();
              if(!empty($checkClaimed->id)){
                  $updateClaimed = AppliedPromotion::find($checkClaimed->id)->update(['status'=>'1']);
                  $create = AppliedPromotion::find($checkClaimed->id);
              }else{
                $create = AppliedPromotion::create($input);  
              }

            }else{
              $create = AppliedPromotion::create($input);              
            }



            if($promotion->amount_type == 'Percentage'){
              $applied_discount_type = $promotion->amount."%";
            }else{
              $applied_discount_type = "RM ".$promotion->amount;
            }

            return array($promotion->amount, $promotion->amount_type, $promotion->id, $create->id, $applied_discount_type, $promotion->discount_code);

        }else{
            return 0;
        }
    }

    public function Repayment(Request $request)
    {
        $transaction = Transaction::where(DB::raw('md5(id)'), $request->transaction_id)
                                  ->first();

        $transactionDs =  TransactionDetail::where('transaction_id', $transaction->id)->get();

        $transaction_no = $transaction->transaction_no;
        $explodeTransaction = explode('-', $transaction_no);

        if(!empty($explodeTransaction[1])){
            ++$transaction_no;
        }else{
            $transaction_no = $transaction_no."-A";
        }

        $bank = Bank::where('bank_code', $request->bank_code)->first();

        // Set Old Transaction Status to Failed
        $updateOldTstatus = Transaction::where(DB::raw('md5(id)'), $request->transaction_id)
                                       ->update(['status'=>'95']);

        $createNewTransaction = Transaction::create(['transaction_no'=>$transaction_no,
                                                     'user_id'=>$transaction->user_id,
                                                     'weight'=>$transaction->weight,
                                                     'discount_code'=>$transaction->discount_code,
                                                     'sub_total'=>$transaction->sub_total,
                                                     'discount'=>$transaction->discount,
                                                     'tax'=>$transaction->tax,
                                                     'processing_fee'=>$transaction->processing_fee,
                                                     'shipping_fee'=>$transaction->shipping_fee,
                                                     'grand_total'=>$transaction->grand_total,
                                                     'address_name'=>$transaction->address_name,
                                                     'address'=>$transaction->address,
                                                     'postcode'=>$transaction->postcode,
                                                     'city'=>$transaction->city,
                                                     'state'=>$transaction->state,
                                                     'country'=>$transaction->country,
                                                     'phone'=>$transaction->phone,
                                                     'email'=>$transaction->email,
                                                     'bank_id'=>$bank->id,
                                                     'status'=>$transaction->status]);
        $tdetails = [];
        foreach($transactionDs as $transactionD){
            $tdetails[] = [
                            'transaction_id'=>$createNewTransaction->id,
                            'product_image'=>$transactionD->product_image,
                            'product_id'=>$transactionD->product_id,
                            'item_code'=>$transactionD->item_code,
                            'product_code'=>$transactionD->product_code,
                            'unit_weight'=>$transactionD->weight,
                            'sub_category'=>$transactionD->sub_category,
                            'product_name'=>$transactionD->product_name,
                            'unit_price'=>$transactionD->unit_price,
                            'quantity'=>$transactionD->quantity,
                            'total_amount'=>$transactionD->total_amount,
                            'status'=>$transactionD->status,
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s')
                          ];
        }
        
        $createNewTransactionD = TransactionDetail::insert($tdetails);
        

        return md5($createNewTransaction->id);
    }

    public function setBankDefault(Request $request)
    {
        $clearDefault = BankAccount::where('user_id', Auth::user()->code)->update(['default_banks' => NULL]);

        $setDefault = BankAccount::where("id", $request->bid);
        $setDefault = $setDefault->update(['default_banks' => '1']);

        $getDefault = BankAccount::where('default_banks', '1')
                                 ->where('user_id',  Auth::user()->code)
                                 ->first();

        return array($getDefault->bank_name, $getDefault->bank_holder_name, $getDefault->bank_account);
    }

    public function GetWalletBalance()
    {
        $balance = AffiliateCommission::select(DB::raw('SUM(comm_amount) as totalBalance'))
                                      ->where('user_id', Auth::user()->code)
                                      ->where('status', '1')
                                      ->first();

        $withdrawal = WithdrawalTransaction::select(DB::raw('SUM(amount) as totalWithdrawal'))
                                             ->where('user_id', Auth::user()->code)
                                             ->whereNotIn('status', ['97', '98'])
                                             ->first();

        $purchase = Transaction::select(DB::raw('SUM(grand_total) as totalPurchase'))
                               ->where('user_id', Auth::user()->code)
                               ->where('status', '1')
                               ->where('mall', '1')
                               ->first();

        $totalBalance = 0;
        
        $totalBalance = $balance->totalBalance - $withdrawal->totalWithdrawal - $purchase->totalPurchase;
        

        return $totalBalance;
    }


    public function getBankDetails(Request $request)
    {
        $bank = Bank::where('bank_code', $request->bank_id)->first();
        if(!empty($bank->id)){
            return array($bank->bank_name, $bank->bank_account, $bank->bank_holder_name);
        }else{
            return 0;
        }
    }

    public function removePromotion(Request $request)
    {
        $remove = AppliedPromotion::find($request->id)->update(['status' => '99']);
    }
    
    public function setNewGuest()
    {
        Session::put('continue_guest', '1');
    }

    public function Confirmation_message()
    {
        Session::forget('registered_account');
        Session::forget('registered_account_topup');
    }

    public function getVerifyCode(Request $request)
    {
        $phone = preg_replace("/^\+?{$request->country_code}/", '', $request->phone);

        if(empty($request->register)){
            $merchant = Merchant::where('phone', $phone)->first();
            $admin = Admin::where('phone', $phone)->first();
            $user = User::where('phone', $phone)->first();

            if(empty($merchant->id) && empty($admin->id) && empty($user->id)){
                return 1;
            }            
        }

        $verify_code = VerifyCode::where('phone', $phone)
                                 ->where('status', '1')
                                 ->orderBy('created_at', 'desc')
                                 ->first();
        if(empty($verify_code->id)){
            $input = [];
            $input['code'] = mt_rand(100000, 999999);
            $input['phone'] = $phone;
            $verify_code = VerifyCode::create($input);
        }

        //if exists but time ady exceed 10min
        //Delete & Reset
        if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($verify_code->created_at." +10 minutes"))){
            $delete = VerifyCode::where('phone', $phone)
                              ->delete();
            $input = [];
            $input['code'] = mt_rand(100000, 999999);
            $input['phone'] = $phone;
            $verify_code = VerifyCode::create($input);   
        }

        $verify = $this->sendVerifyCode($phone, $verify_code->code);

        if($verify != '2000 = SUCCESS'){
            $this->sendVerifyCode($phone, $verify_code->code);
        }
        
        $date_a = new DateTime(date('Y-m-d H:i:s', strtotime($verify_code->created_at." +10 minutes")));
        $date_b = new DateTime(date('Y-m-d H:i:s'));

        $interval = date_diff($date_a,$date_b);

        return array($verify_code->code, $interval->format('%I:%S'));
    }

    public function sendVerifyCode($phone, $code)
    {
        $destination = urlencode($phone);
        $message = "Hwajing: Your verification code is: ".$code;
        $message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
        $message = urlencode($message);
          
        $username = urlencode("hwajing2020");
        $password = urlencode("hwajing20201234");
        $sender_id = urlencode("66300");
        $type = "1";

        $fp = "https://www.isms.com.my/isms_send_all.php";
        $fp .= "?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id&agreedterm=YES";
        //echo $fp;
          
        $http = curl_init($fp);

        curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
        $http_result = curl_exec($http);
        $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
        curl_close($http);

        return $http_result;
    }

    public function resetVerifyCode(Request $request)
    {
        $delete = VerifyCode::where('phone', $request->phone)
                            ->delete();
    }

    public function updateEShopName(Request $request)
    {
        $merch = Merchant::get();

        foreach ($merch as $list_merch) {
          if(($request->e_shop_name ==  $list_merch->e_shop_name) && ($list_merch->status != '3')){
            return 1;
          }else{
            return 2;
          }
        }
    }

    public function checkRefferalCode(Request $request)
    {
      // return $request->master_id;
      $admins = Admin::where('code', $request->master_id)
                      ->exists();
      if($admins == 1){
        return 3;
      }

      $agent = Merchant::where('code', $request->master_id)
                        ->exists();
      if($agent == 0){
        return 2;
      }
    }

    public function CheckLogin(Request $request)
    {

        $phone = preg_replace("/^\+?{$request->country_code}/", '', $request->phone);
         
        if(isset($request->code) && !empty($request->code)){
            $code = VerifyCode::where('code', $request->code)
                              ->where('phone', $phone)
                              ->where('status', '1')
                              ->first();

            if(empty($code->id)){
                return 1;
            }

            if(date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime($code->created_at." +10 minutes")))
            {
                return 1; 
            }
        }

        
        if(!empty($request->refferal_code)){
            $merchant = Merchant::where('phone', $request->refferal_code)->first();
            $admin = Admin::where('phone', $request->refferal_code)->first();

            if(empty($merchant->id) && empty($admin->id)){
                return 4;
            }
        }



        $user = User::where('phone', $phone)
                    ->where('country_code', $request->country_code)
                    ->where('status', '1')
                    ->exists();
        $merchant = Merchant::where('phone', $phone)
                            ->where('country_code', $request->country_code)
                            ->where('status', '1')
                            ->exists();

        $admin = Admin::where('phone', $phone)
                            ->where('country_code', $request->country_code)
                            ->where('status', '1')
                            ->exists();

        if($user == 0 && $merchant == 0 && $admin == 0){
            return 2;
        }else{
            return 3;
        }
    }

    public function getVariation(Request $request)
    {
        $variation = ProductVariation::find($request->vid);
        $price = 0;
        $special_price = 0;

        if(Auth::guard('admin')->check() || Auth::guard('merchant')->check()){
          
          $price = $variation->variation_agent_price;
          $special_price = $variation->variation_agent_special_price;

        }else{

          $price = $variation->variation_price;
          $special_price = $variation->variation_special_price;

        }

        $balance = $this->VariationBalanceQuantity($request->vid);

        return array(number_format($special_price, 2), number_format($price, 2), $balance);
    }


    public function VariationBalanceQuantity($id)
    {
        $quantityAmount = ProductVariation::find($id);

        $cart = Cart::select(DB::raw('SUM(qty) AS InCart'))
                    ->where('status', '1')
                    ->where('sub_category_id', $id)
                    ->first();

        $transaction = TransactionDetail::select(DB::raw('SUM(quantity) AS TransCart'))
                                        ->join('transactions AS t', 't.id', 'transaction_details.transaction_id')
                                        ->whereIn('t.status', ['1', '97', '98', '99'])
                                        ->where('variation_id', $id)
                                        ->first();

        return $quantityAmount->variation_stock - $cart->InCart - $transaction->TransCart;
    }

    public function guestAgent(Request $request)
    {
        Session::put('guest_agent', $request->agent);
    }

    public function getTopupPackages(Request $request)
    {
        $topup = SettingTopup::find($request->tid);
        $profit_bonus = 0;
        if(!empty($topup->profit_amount)){
          if($topup->profit_type == 'Percentage'){
            $profit_bonus = $topup->topup_amount * $topup->profit_amount / 100;
          }else{
            $profit_bonus = $topup->profit_amount;
          }
        }

        $profit_display = "";

        if($profit_bonus > 0){
            $profit_display = " + (RM ".$profit_bonus.")";
        }
        return array($topup->topup_amount, $profit_display);
    }

    public function getAffPackages(Request $request)
    {
        $topup = SettingAffiliateTopup::find($request->pid);
        $profit_bonus = 0;
        if(!empty($topup->profit_amount)){
          if($topup->profit_type == 'Percentage'){
            $profit_bonus = $topup->topup_amount * $topup->profit_amount / 100;
          }else{
            $profit_bonus = $topup->profit_amount;
          }
        }

        $profit_display = "";

        if($profit_bonus > 0){
            $profit_display = " + (RM ".$profit_bonus.")";
        }
        return array($topup->topup_amount, $profit_display);
    }

    public function CreateCartLink()
    {
        $carts = Cart::where('user_id', Auth::user()->code)->get();
        $unique_id = strtotime(date('Y-m-d H:i:s'));
        foreach($carts as $cart){
            $input = [];

            $input['unique_id'] = $unique_id;
            $input['user_id'] = $cart->user_id;
            $input['product_id'] = $cart->product_id;
            $input['sub_category_id'] = $cart->sub_category_id;
            $input['qty'] = $cart->qty;

            $links = CartLink::create($input);
        }

        // Cart::where('user_id', Auth::user()->code)->delete();

        return $unique_id;
    }

    public function ProceedCartLink(Request $request)
    {
        if(!empty(Auth::guard('admin')->check())){
            $BuyerCode = Auth::guard('admin')->user()->code;
        }elseif(!empty(Auth::guard('merchant')->check())){
            $BuyerCode = Auth::guard('merchant')->user()->code;
        }elseif(!empty(Auth::guard('web')->check())){
            $BuyerCode = Auth::guard('web')->user()->code;
        }else{
            $BuyerCode = $_COOKIE['new_guest'];
        }

        if($BuyerCode == ""){
          Session::put('cart_link_id', $request->link_id);
        }else{
          $cart_links = CartLink::where('unique_id', $request->link_id)->get();

          foreach($cart_links as $cart){
              Session::put('share_agent_id', $cart->user_id);
              
              $input = [];
              $input['user_id'] = $BuyerCode;
              $input['product_id'] = $cart->product_id;
              $input['sub_category_id'] = $cart->sub_category_id;
              $input['qty'] = $cart->qty;

              $cart = Cart::create($input);
              // setcookie('share_agent_id', $cart_links->user_id, time() + (86400 * 30), "/");
          }
          $userCart = CartLink::where('unique_id', $request->link_id)->first();
          Session::put('agent_code', $userCart->user_id);
          CartLink::where('unique_id', $request->link_id)->delete();

          // session()->forget('cart_link_id');
        }
    }

    public function TransferRegisterWallet(Request $request)
    {
        $amount = preg_replace("/[^0-9\.]/", '', $request->amount);
          
        if(floatval($amount) <= 0){
            return 'Please key in correct amount';
        }
        // return (float)$amount.' - '.(float)$request->wallet_balance;
        if(floatval($this->GetCashWalletBalance()) < floatval($amount)){
            // return 123;
            return 'Insufficient balance';
        }

        $input = [];
        $input['user_id'] = Auth::user()->code;
        $input['amount'] = $amount;
        $input['transfer_type'] = 1;
        $input['created_by'] = Auth::user()->code;

        $withdrawal = RegisterWallet::create($input);

        return 1;
    }

    public function TransferRegisterWalletMember(Request $request)
    {
        $amount = preg_replace("/[^0-9\.]/", '', $request->amount);
        
        if(empty($request->transfer_to)){
            return 'Please select downline';
        }

        if(floatval($amount) <= 0){
            return 'Please key in correct amount';
        }
        // return (float)$amount.' - '.(float)$request->wallet_balance;
        if(floatval($this->GetCashWalletBalance()) < floatval($amount)){
            // return 123;
            return 'Insufficient balance';
        }

        $input = [];
        $input['user_id'] = $request->transfer_to;
        $input['amount'] = $amount;
        $input['transfer_type'] = 1;
        $input['created_by'] = Auth::user()->code;

        $withdrawal = RegisterWallet::create($input);

        return 1;
    }

    public function GetCashWalletBalance()
    {
        if(!empty(Auth::guard('admin')->check())){
            $buyerCode = Auth::guard('admin')->user()->code;
        }elseif(!empty(Auth::guard('merchant')->check())){
            $buyerCode = Auth::guard('merchant')->user()->code;
        }elseif(!empty(Auth::guard('web')->check())){
            $buyerCode = Auth::guard('web')->user()->code;
        }else{
          if(empty($_COOKIE['new_guest'])){
            $buyerCode = setcookie('new_guest', strtotime(date('Y-m-d H:i:s')).rand(100000, 999999), time() + (86400 * 30), "/");
          }else{
            $buyerCode = $_COOKIE['new_guest'];
          }
        }
        
        $balance = AffiliateCommission::select(DB::raw('SUM(comm_amount) as totalBalance'))
                                      ->where('user_id', $buyerCode)
                                      ->where('status', '1')
                                      ->first();

        $withdrawal = WithdrawalTransaction::select(DB::raw('SUM(amount) as totalWithdrawal'))
                                             ->where('user_id', $buyerCode)
                                             ->where('status', '1')
                                             ->first();

        $totalBalance = 0;
        
        $totalBalance = $balance->totalBalance - $withdrawal->totalWithdrawal;
        

        return $totalBalance;
    }

    public function TransferProductWallet(Request $request)
    {
        $amount = preg_replace("/[^0-9\.]/", '', $request->amount);

        if(floatval($amount) <= 0){
            return 'Please key in correct amount';
        }
        // return (float)$amount.' - '.(float)$request->wallet_balance;
        if(floatval($this->GetCashWalletBalance()) < floatval($amount)){
            // return 123;
            return 'Insufficient balance';
        }

        $setting_charges = SettingCharge::find(1);

        $charges = 0;
        $charges_type = "";
        $charges_amount = 0;
        if(!empty($setting_charges->id) && !empty($setting_charges->transfer_wallet_charges_amount)){
            if($setting_charges->transfer_wallet_charges_type == 'Percentage'){
                $charges = $amount * $setting_charges->transfer_wallet_charges_amount / 100;
            }else{
                $charges = $amount - $setting_charges->transfer_wallet_charges_amount;
            }
            $charges_type = $setting_charges->transfer_wallet_charges_type;
            $charges_amount = $setting_charges->transfer_wallet_charges_amount;
        }

        $input = [];
        $input['user_id'] = Auth::user()->code;
        $input['amount'] = $amount - $charges;
        $input['actual_amount'] = $amount;
        $input['charges_type'] = $charges_type;
        $input['charges_amount'] = $charges_amount;

        $withdrawal = TransferProductWallet::create($input);

        return 1;
    }

    public function ConfirmPassword(Request $request)
    {
        
        if(Hash::check($request->password, Auth::user()->password)){
            return 1;
        }else{
            return 0;
        }
    }

    public function UpdateAboutUs(Request $request)
    {
        $merchant = Merchant::where('code', Auth::user()->code)->update(['about_us'=>$request->about_us]);
    }

    public function checkUserActive()
    {
         if(!empty(Auth::guard('admin')->check())){
            $userCode = Auth::guard('admin')->user()->code;
            $checkAdmin = Admin::find(Auth::guard('admin')->user()->id);

            return $checkAdmin->status;

        }elseif(!empty(Auth::guard('merchant')->check())){
            $userCode = Auth::guard('merchant')->user()->code;
            $checkMerchant = Merchant::find(Auth::guard('merchant')->user()->id);

            return $checkMerchant->status;
        }elseif(!empty(Auth::guard('web')->check())){
            $userCode = Auth::guard('web')->user()->code;
            $checkUser = User::find(Auth::guard('web')->user()->id);

            return $checkUser->status;
        }else{
            $userCode = "";
        }
    }

    public function forceLogout()
    {
        if(Auth::guard('admin')->check()){
            Auth::logout();
            return 1;
        }elseif(Auth::guard('merchant')->check()){
            Auth::logout();
            return 2;
        }else{
            Auth::logout();
            return 3;
        }
    }
}
