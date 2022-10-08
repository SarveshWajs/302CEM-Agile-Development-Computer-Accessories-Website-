<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator, Redirect, Toastr, DB, File, Auth, Mail;
use App\Transaction;
use App\WithdrawalTransaction;
use App\TransactionDetail;
use App\User;
use App\Merchant;
use App\Admin;
use App\AffiliateCommission;
use App\Bank;
use App\TopupTransaction;
use App\Affiliate;
use App\RegisterWallet;
use App\Product;
use App\Stock;
use App\ProductVariation;
use App\TransferProductWallet;
use App\UserShippingAddress;
use App\AdjustProductWallet;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->check()){
            $transactions = Transaction::select(DB::raw('COALESCE(COALESCE(CONCAT(m.f_name, " ", m.l_name), CONCAT(s.f_name, " ", s.l_name)), CONCAT(a.f_name, " ", a.l_name)) AS customer_name'),
                                                'transactions.transaction_no', 'product_name', 'unit_price', 'quantity', 'total_amount', 'transactions.status', 'transactions.created_at', 'd.sub_category',
                                                'transactions.id AS Tid', 'transactions.grand_total', 'transactions.shipping_fee', 
                                                'transactions.processing_fee', 'transactions.completed', 
                                                'transactions.address_name', 'm.code as Acode', 's.code as Ccode', 
                                                'a.code as ADcode', 'm.agent_type', 'to_receive', 'transactions.mall',
                                                'order_number', 'transactions.awb_no', 'transactions.tracking_no', 'courier')
                                       ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                                       ->leftJoin('users AS s', 's.code', 'transactions.user_id')
                                       ->leftJoin('admins AS a', 'a.code', 'transactions.user_id')
                                       ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                       ->groupBy('transactions.id')
                                       ->orderBy('transactions.created_at', 'desc');
        }else{
            $transactions = Transaction::select(DB::raw('COALESCE(CONCAT(m.f_name, " ", m.l_name), CONCAT(s.f_name, " ", s.l_name)) AS customer_name'),
                                                'transactions.transaction_no', 'product_name', 'unit_price', 'quantity', 'total_amount', 'transactions.status', 'transactions.created_at', 'd.sub_category')
                                       ->leftJoin('merchants AS m', 'm.code', 'transactions.user_id')
                                       ->leftJoin('users AS s', 's.code', 'transactions.user_id')
                                       ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                                       ->leftJoin('affiliates AS a', 'a.affiliate_id', 's.id')
                                       ->where('a.user_id', Auth::user()->code)
                                       ->orderBy('transactions.created_at', 'desc');            
        }
        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        $queries = [];
        $columns = [
            'transaction_no', 'status', 'per_page'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'status'){
                    $transactions = $transactions->where("transactions.status", 'like', "%".request($column)."%");
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
        // $transactions = $transactions->paginate($per_page)->appends($queries);

        $ship_details = [];
        $print_ship_details = [];
        $transaction_total_weight = [];
        $promoWeight = 0;
        foreach($transactions as $transaction){

           $domain = "http://connect.easyparcel.my/?ac=";

           $action = "EPParcelStatusBulk";
           $postparam = array(
           'api'   => 'EP-GwSDN6WXv',
            'bulk'  => array(
            array(
            'order_no'  => $transaction->order_number,
            ),
            ),
            );

            $url = $domain.$action;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postparam));
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

            ob_start(); 
            $return = curl_exec($ch);
            ob_end_clean();
            curl_close($ch);

            $json = json_decode($return);
            if(!empty($json->result)){
              foreach($json->result as $value){
                  foreach($value->parcel as $value2){
                      $ship_details[$transaction->Tid] = $value2->ship_status;
                      $print_ship_details[$transaction->Tid] = $value2->awb_id_link;
                  }
              }              
            }
        }
        // exit();


        $netTransaction = Transaction::select(DB::raw('SUM(transactions.grand_total) AS netTotal'))
                                     ->where('status', '1')
                                     ->first();

        return view('backend.transactions.index', ['transactions'=>$transactions, 'netTransaction'=>$netTransaction],
                                                   compact('ship_details', 'print_ship_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $merchants = Merchant::where('status', '1')->get();
        $products = Product::Where('status', '1')->get();

        foreach($merchants as $merchant){
            $GetProductWalletBalance[$merchant->code] = $this->GetProductWalletBalance($merchant->code);
        }

        return view('backend.transactions.create', ['merchants'=>$merchants, 'products'=>$products],
                                                    compact('GetProductWalletBalance'));
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
            'merchants' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        $GetProductWalletBalance = $this->GetProductWalletBalance($request->merchants);

        if($request->grandTotal > $GetProductWalletBalance){
            return Redirect::back()->withInput(Input::all())->withErrors("Agent Insufficient balance");
        }

        $array = [];
        $v_array = [];
        $totalProductQty = [];
        $totalVariationQty = [];
        $b = 0;
        for($a=0; $a<count($request->product_id); $a++){
            $b++;
            if(empty($request->product_id[$a])){
                return Redirect::back()->withInput(Input::all())->withErrors("Please select at least one product.");
            }
            if(!empty($request->product_id[$a]) && empty($request->quantity[$a])){
                return Redirect::back()->withInput(Input::all())->withErrors("Please fill in quantity");
            }
            if(!empty($request->product_id[$a]) && !empty($request->quantity[$a])){
                if(!empty($request['product_variation'.$b])){
                    if(!empty($v_array)){
                        if(in_array($request['product_variation'.$b], $v_array)){
                            $totalVariationQty[$request['product_variation'.$b]] = $totalVariationQty[$request['product_variation'.$b]] + $request->quantity[$a];
                        }else{
                            array_push($v_array, $request['product_variation'.$b]);
                            $totalVariationQty[$request['product_variation'.$b]] = $request->quantity[$a];  
                        }
                    }else{
                        array_push($v_array, $request['product_variation'.$b]);
                        $totalVariationQty[$request['product_variation'.$b]] = $request->quantity[$a];
                    }
                }else{
                    if(!empty($array)){
                        if(in_array($request->product_id[$a], $array)){
                            $totalProductQty[$request->product_id[$a]] = $totalProductQty[$request->product_id[$a]] + $request->quantity[$a];
                        }else{
                            array_push($array, $request->product_id[$a]);
                            $totalProductQty[$request->product_id[$a]] = $request->quantity[$a];  
                        }
                    }else{
                        array_push($array, $request->product_id[$a]);
                        $totalProductQty[$request->product_id[$a]] = $request->quantity[$a];
                    }
                }
            }
        }

        $exceedBalanceProduct = [];
        foreach($array as $product_id){
            $checkStock = $this->BalanceQuantity($product_id);
            if($totalProductQty[$product_id] > $checkStock){
                $exceedBalanceProduct[] = $product_id;
            }
        }

        $exceedBalanceVariation = [];
        foreach($v_array as $variation_id){
            
            $checkVStock = $this->getVariationStock($variation_id);
            if($totalVariationQty[$variation_id] > $checkVStock){
                $exceedBalanceVariation[] = $variation_id;
            }
        }

        // exit();

        if(!empty($exceedBalanceProduct)){
            $getProduct = Product::whereIn('id', $exceedBalanceProduct)->get();
            $totalProd = [];
            foreach($getProduct as $prod){
                $totalProd[] = $prod->product_name;
            }

            $im = implode(", ", $totalProd);

            return Redirect::back()->withInput(Input::all())->withErrors($im." Stock Balance not enough");
        }

        if(!empty($exceedBalanceVariation)){
            $getProduct = ProductVariation::whereIn('id', $exceedBalanceVariation)->get();
            $totalVarian = [];
            foreach($getProduct as $prod){
                $totalVarian[] = $prod->variation_name;
            }

            $imv = implode(", ", $totalVarian);

            return Redirect::back()->withInput(Input::all())->withErrors($imv." Stock Balance not enough");
        }
        $shipping_address = UserShippingAddress::where('user_id', $request->merchants)->where('default', '1')->first();
        $input = $request->all();
        $input['user_id'] = $request->merchants;
        $input['transaction_no'] = $this->GenerateTransactionNo();
        $input['created_by'] = Auth::user()->code;
        if(!empty($shipping_address->id)){
          $input['address_name'] = $shipping_address->f_name;
          $input['address'] = $shipping_address->address;
          $input['postcode'] = $shipping_address->postcode;
          $input['city'] = $shipping_address->city;
          $input['state'] = $shipping_address->state;
          $input['email'] = $shipping_address->email;
          $input['phone'] = $shipping_address->phone;
        }
        $input['mall'] = '1';
        // $input['discount'] = $request->discount;

        // if(!empty($request->fileToUpload)){
        //     $files = $request->file('fileToUpload'); 
        //     $name = $files->getClientOriginalName();
        //     $exp = explode(".", $name);
        //     $file_ext = end($exp);
        //     $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
        //     $files->move("uploads/bank_slip/", $name);

        //     $input['bank_slip'] = "uploads/bank_slip/".$name;

        // }

        $transaction = Transaction::create($input);

        $num = 0;
        $grand_total = 0;
        $weight_total = 0;
        foreach($request->product_id as $key => $value){
            $num++;
            $product_detail = Product::select('i.image', 'products.*')
                                     ->leftJoin('product_images as i', 'i.product_id', 'products.id')
                                     ->where('products.id', $value)
                                     ->first();

            if(!empty($request['product_variation'.$num])){
               $variation_detail = ProductVariation::find($request['product_variation'.$num]);
            }

            $input_detail = [];
            $input_detail['transaction_id'] = $transaction->id;
            $input_detail['product_id'] = $value;
            // $input_detail['variation_id'] = !empty($request['product_variation'.$num]) ? $request['product_variation'.$num] : '';

            if(!empty($variation_detail->id)){
              $input_detail['variation_id'] = $variation_detail->id;
              $input_detail['unit_weight'] = $variation_detail->variation_weight;
              $input_detail['unit_price'] = (!empty($variation_detail->variation_agent_special_price)) ? $variation_detail->variation_agent_special_price : $variation_detail->variation_agent_price;
              $input_detail['sub_category'] = $variation_detail->variation_name;
              

              $grand_total += (!empty($variation_detail->variation_agent_special_price)) ? $variation_detail->variation_agent_special_price * $request->quantity[$key] : $variation_detail->variation_agent_price * $request->quantity[$key];
              $weight_total += $variation_detail->variation_weight * $request->quantity[$key];


            }else{
              $input_detail['unit_weight'] = $product_detail->weight;
              $input_detail['unit_price'] = (!empty($product_detail->agent_special_price)) ? $product_detail->agent_special_price : $product_detail->agent_price;
              

              $grand_total += (!empty($product_detail->agent_special_price)) ? $product_detail->agent_special_price * $request->quantity[$key] : $product_detail->agent_price * $request->quantity[$key];
              $weight_total += $product_detail->weight * $request->quantity[$key];
            }

            $input_detail['product_name'] = $product_detail->product_name;
            $input_detail['item_code'] = $product_detail->item_code;
            $input_detail['product_code'] = $product_detail->product_code;
            $input_detail['quantity'] = $request->quantity[$key];
            $input_detail['product_image'] = $product_detail->image;
            
            

            $detail = TransactionDetail::create($input_detail);
        }

        $update = Transaction::find($transaction->id);
        $update = $update->update(['weight'=>$weight_total,
                                   'sub_total'=>$grand_total,
                                   'grand_total'=>$grand_total]);
        
        $totalBalance = $this->GetProductWalletBalance($request->merchants);
        $merchant = Merchant::where('code', $request->merchants)->first();
        if($totalBalance <= 100){
          $this->ProductPointNotication($merchant->email, "noreplay@vesson.my", "Zack", "Product Wallet Notification", $merchant);
        }

        Toastr::success("Transaction Create Successfully!");
        return redirect()->route('transaction.transactions.index');
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
        $transaction = Transaction::select('transactions.*', 'p.amount_type', 'p.amount AS discount_amount', 'p.discount_code')
                                  ->leftJoin('promotions AS p', 'p.id', 'transactions.discount_code')
                                  ->where('transactions.id', $id)
                                  ->first();
        if(empty($transaction->id)){
            abort(404);
        }

        $bank_online = Bank::find($transaction->bank_id);
        $bank_cdm = Bank::where('bank_code', $transaction->cdm_bank_id)->first();

        $details = TransactionDetail::where('transaction_id', $transaction->id)->get();
        
        return view('backend.transactions.view', ['transaction'=>$transaction, 'details'=>$details, 'bank_online'=>$bank_online, 'bank_cdm'=>$bank_cdm]);
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
        //
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

    public function withdrawal_list()
    {
        $transactions = WithdrawalTransaction::select(DB::raw('coalesce(CONCAT(m.f_name, " ", m.l_name), CONCAT(a.f_name, " ", a.l_name)) AS agent_name'), 'withdrawal_transactions.*')
                                             ->leftJoin('merchants AS m', 'm.code', 'withdrawal_transactions.user_id')
                                             ->leftJoin('admins AS a', 'a.code', 'withdrawal_transactions.user_id')
                                             ->orderBy('withdrawal_transactions.id', 'desc');
        $queries = [];
        $columns = [
            'withdrawal_no', 'agent_name', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'agent_name'){
                    $transactions = $transactions->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%");
                }elseif($column == 'status'){
                    $transactions = $transactions->where('withdrawal_transactions.status', 'like', "%".request($column)."%");
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

        $GetWalletBalance = [];
        foreach($transactions as $transaction){
          $GetWalletBalance[$transaction->user_id] = $this->GetWalletBalance($transaction->user_id);
        }

        return view('backend.transactions.withdrawal_list', ['transactions'=>$transactions],
                                                            compact('GetWalletBalance'));
    }

    public function uploadBankSlip(Request $request)
    {

        $files = $request->file('uploadSlip'); 
        $name = $files->getClientOriginalName();
        $exp = explode(".", $name);
        $file_ext = end($exp);
        $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
        $files->move("uploads/withdrawal_bank_slip/", $name);

        $input = $request->all();
        $input['withdrawal_slip'] = "uploads/withdrawal_bank_slip/".$name;

        $withdrawal = WithdrawalTransaction::find($request->wid);

        $merchants = Merchant::where('code', $withdrawal->user_id)->first();
        $admins = Admin::where('code', $withdrawal->user_id)->first();

        if(!empty($merchants->id)){
            $phone = $merchants->phone;
        }else{
            $phone = $admins->phone;
        }

        if($request->withAction == 1){
            // $destination = urlencode($phone);
            // $message = "因诗美: 您的提款号: ".$withdrawal->withdrawal_no." 已批准";
            // $message = html_entity_decode($message, ENT_QUOTES, 'utf-8'); 
            // $message = urlencode($message);
              
            // $username = urlencode("yinshimei");
            // $password = urlencode("yinshimei1234");
            // $sender_id = urlencode("66300");
            // $type = "2";

            // $fp = "https://www.isms.com.my/isms_send_all.php";
            // $fp .= "?un=$username&pwd=$password&dstno=$destination&msg=$message&type=$type&sendid=$sender_id&agreedterm=YES";
            // //echo $fp;
              
            // $http = curl_init($fp);

            // curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
            // $http_result = curl_exec($http);
            // $http_status = curl_getinfo($http, CURLINFO_HTTP_CODE);
            // curl_close($http);

            
            $totalBalance = $this->GetWalletBalance($withdrawal->user_id);
            if($totalBalance < $withdrawal->amount){
                Toastr::error("This user has insufficient balance!");
            }else{
                $input['status'] = 1;
            }
        }

        $withdrawal = $withdrawal->update($input);

        Toastr::success("Upload Successful!");
        return redirect()->route('withdrawal_list');
    }

    public function GetWalletBalance($user)
    {
        $balance = AffiliateCommission::select(DB::raw('SUM(comm_amount) as totalBalance'))
                                      ->where('user_id', $user)
                                      ->where('status', '1')
                                      ->first();

        $withdrawal = WithdrawalTransaction::select(DB::raw('SUM(amount) as totalWithdrawal'))
                                             ->where('user_id', $user)
                                             ->where('status', '1')
                                             ->first();

        $totalIn = RegisterWallet::select(DB::raw('SUM(amount) as totalBalance'))
                                      ->where('user_id', $user)
                                      ->where('transfer_type', '1')
                                      ->where('status', '1')
                                      ->first();

        $totalBalance = 0;
        
        $totalBalance = $balance->totalBalance - $withdrawal->totalWithdrawal - $totalIn->totalBalance;
        

        return $totalBalance;
    }

    public function transaction_invoice($transaction_no)
    {
        $transaction = Transaction::select('transactions.*', 'p.amount_type', 'p.amount AS discount_amount', 'p.discount_code')
                                  ->leftJoin('promotions AS p', 'p.id', 'transactions.discount_code')
                                  ->where('transactions.transaction_no', $transaction_no)
                                  ->first();

        if(empty($transaction->id)){
            abort(404);
        }

        $bank_online = Bank::find($transaction->bank_id);
        $bank_cdm = Bank::where('bank_code', $transaction->cdm_bank_id)->first();

        $details = TransactionDetail::select('transaction_details.*', 'transaction_details.quantity as t_qty', 'u.uom_name', 'p.packages')
                                    ->join('products AS p', 'p.id', 'transaction_details.product_id')
                                    ->leftJoin('setting_uoms AS u', 'u.id', 'p.product_type')
                                    ->where('transaction_id', $transaction->id)
                                    ->get();

        return view('backend.transactions.invoice', ['transaction'=>$transaction, 'details'=>$details]);
    }

    public function topup_list()
    {
        $topups = TopupTransaction::select('topup_transactions.*', 
                                            DB::raw('COALESCE(CONCAT(m.f_name, " ", m.l_name), CONCAT(u.f_name, " ", u.l_name)) AS agent_name'))
                                  ->leftJoin('merchants AS m', 'm.code', 'topup_transactions.user_id')
                                  ->leftJoin('users AS u', 'u.code', 'topup_transactions.user_id')
                                  ->orderBy('topup_transactions.id', 'desc');
                                  
        // $topups = TopupTransaction::select(DB::raw('coalesce(CONCAT(m.f_name, " ", m.l_name), CONCAT(a.f_name, " ", a.l_name)) AS agent_name'), 'topup_transactions.*')
        //                           ->leftJoin('merchants AS m', 'm.code', 'topup_transactions.user_id')
        //                           ->leftJoin('admins AS a', 'a.code', 'topup_transactions.user_id')
        //                           ->orderBy('topup_transactions.id', 'desc');
        $queries = [];
        $columns = [
            'topup_no', 'agent_name', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'agent_name'){
                    $topups = $topups->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%");
                }elseif($column == 'status'){
                    $topups = $topups->where('topup_transactions.status', 'like', "%".request($column)."%");
                }else{
                    $topups = $topups->where($column, 'like', "%".request($column)."%");                    
                }

                $queries[$column] = request($column);

            }
        }

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }
        $topups = $topups->paginate($per_page)->appends($queries);

        

        return view('backend.transactions.topup_list', ['topups'=>$topups]);
    }

    public function topup_invoice($topup_no)
    {
        $transaction = TopupTransaction::select('topup_transactions.*', DB::raw('CONCAT(m.f_name, " ", m.l_name) AS agent_name'))
                                       ->join('merchants as m', 'm.code', 'topup_transactions.user_id')
                                       ->where('topup_no', $topup_no)
                                       ->first();

        return view('backend.transactions.topup_invoice', ['transaction'=>$transaction]);
    }

    public function add_awb_no(Request $request)
    {
        $transaction = Transaction::find($request->transaction_id);
        if(!empty($transaction->id)){
            if(empty($transaction->awb_no)){
                $this->ParcelCreatedMessage($transaction->email, 'noreplay@vesson.my', $transaction->address_name, 'Parcel Shipped', $transaction);
            }

            $transaction = $transaction->update(['awb_no'=>$request->awb_no, 'courier'=>$request->courier]);
        }

        Toastr::success("Successful!");
        return redirect()->back();
    }

    public static function BalanceQuantity($id)
    {
        $stockBalance = Stock::select(DB::raw('SUM(IF(type = "Increase", quantity, NULL)) AS totalStockIn'),
                                      DB::raw('SUM(IF(type = "Decrease", quantity, NULL)) AS totalStockOut'))
                                ->where('product_id', $id)
                                ->first();

        $transaction = TransactionDetail::select(DB::raw('SUM(quantity) AS TransCart'))
                                        ->join('transactions AS t', 't.id', 'transaction_details.transaction_id')
                                        ->whereIn('t.status', ['1', '98', '99', '97'])
                                        ->whereNull('transaction_type')
                                        ->where('product_id', $id)
                                        ->first();


        return $stockBalance->totalStockIn - $stockBalance->totalStockOut - $transaction->TransCart;
    }

    public function getVariationStock($id)
    {
        $quantityAmount = ProductVariation::find($id);

        $transaction = TransactionDetail::select(DB::raw('SUM(quantity) AS TransCart'))
                                        ->join('transactions AS t', 't.id', 'transaction_details.transaction_id')
                                        ->whereIn('t.status', ['1', '97', '98', '99'])
                                        ->where('variation_id', $id)
                                        ->first();

        return $quantityAmount->variation_stock - $transaction->TransCart;
    }

    public static function GenerateTransactionNo()
    {
      $transaction = Transaction::select(DB::raw('COUNT(id) AS TotalTransaction'))
                                ->first();
      $TotalTransaction = $transaction->TotalTransaction + 1;
      if(strlen($TotalTransaction) == 1){
          $tNo = strtotime(date('Y-m-d H:i:s'))."0000".$TotalTransaction;
      }elseif(strlen($TotalTransaction) == 2){
          $tNo = strtotime(date('Y-m-d H:i:s'))."000".$TotalTransaction;
      }elseif(strlen($TotalTransaction) == 3){
          $tNo = strtotime(date('Y-m-d H:i:s'))."00".$TotalTransaction;
      }elseif(strlen($TotalTransaction) == 4){
          $tNo = strtotime(date('Y-m-d H:i:s'))."0".$TotalTransaction;
      }else{
          $tNo = strtotime(date('Y-m-d H:i:s')).$TotalTransaction;
      }
      return $tNo;
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

    public function shipping_details($transaction_no)
    {
        $transaction = Transaction::where('transaction_no', $transaction_no)->first();

        if(empty($transaction->id)){
          abort(404);
        }



        $domain = "http://connect.easyparcel.my/?ac=";

        $action = "EPTrackingBulk";
        $postparam = array(
        'api'   => 'EP-qHmHHuRcu',
        'bulk'  => array(
        array(
        'awb_no'    => $transaction->tracking_no,
        ),
        ),
        );

        $url = $domain.$action;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postparam));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        ob_start(); 
        $return = curl_exec($ch);
        ob_end_clean();
        curl_close($ch);

        $json = json_decode($return, true);
        // echo "<pre>"; print_r($json); echo "</pre>";
        // exit();

        return view('backend.transactions.shipping_details', ['transaction'=>$transaction, 'results'=>$json]);
    }

    public function ParcelCreatedMessage($to, $from, $name, $subject, $transaction)
    {
        $headers = "From: $from";
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8";
        $headers .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';

        // $subject = "Testing.";


        $link = 'www.weshare.my';

        $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title></title></head><body>";
        $body .= "<table style='width: 100%;'>";
        $body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";

        $body .= "</td></tr></thead><tbody><tr>";
        $body .= "<td style='border:none;'><strong>YOUR PARCEL HAS BEEN CREATED</strong></td></tr>";
        $body .= "<tr>
                    <td style='border:none;'>
                      <strong>Dear ".$name."</strong>
                    </td>
                  </tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td>We had shipped your parcel.</td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td>New member information below :</td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td>Courier Company Name: ".$transaction->courier."</td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td>Tracking Number: ".$transaction->awb_no."</td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td>Regards,</td></tr>";
        $body .= "<tr><td>Zstore</td></tr>";
        $body .= "<tr><td></td></tr>";
        // $body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
        $body .= "</tbody></table>";
        $body .= "</body></html>";

        $send = mail($to, $subject, $body, $headers);
    }

    public function ProductPointNotication($to, $from, $name, $subject, $user)
    {
        $headers = "From: $from";
        $headers = "From: " . $from . "\r\n";
        $headers .= "Reply-To: ". $from . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8";
        $headers .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';

        // $subject = "Testing.";


        $link = 'www.weshare.my';

        $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title></title></head><body>";
        $body .= "<table style='width: 100%;'>";
        $body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";

        $body .= "</td></tr></thead><tbody><tr>";
        $body .= "<td style='border:none;'><strong>WELCOME TO WESHARE2YOU!</strong></td></tr>";
        $body .= "<tr>
                    <td style='border:none;'>
                      <strong>Dear ".$user->f_name."</strong>
                    </td>
                  </tr>";
        $body .= "<tr><td>Your Product Wallet Balance was less than 100</td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td>Regards,</td></tr>";
        $body .= "<tr><td>WeShare2you</td></tr>";
        $body .= "<tr><td></td></tr>";
        // $body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
        $body .= "</tbody></table>";
        $body .= "</body></html>";

        $send = mail($to, $subject, $body, $headers);
    }
}
