<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Bank;
use App\User;
use App\Diet;
use App\Merchant;
use App\Product;
use App\ProductImage;
use App\State;
use App\Stock;
use App\Cart;
use App\Favourite;
use App\Transaction;
use App\TransactionDetail;
use App\UserShippingAddress;
use App\SettingMerchantBonus;
use App\SettingMerchantRebate;
use App\Promotion;
use App\Category;
use App\Brand;
use App\SubCategory;
use App\SettingShippingFee;
use App\AffiliateCommission;
use App\SettingMerchantCommission;
use App\Affiliate;
use App\AgentLevel;
use App\WithdrawalTransaction;
use App\BankAccount;
use App\Admin;
use App\AppliedPromotion;
use App\PackageItem;
use App\TblCountry;
use App\ProductVariation;
use App\SettingBanner;
use App\SettingBannerTesting;
use App\SettingBannerVideo;
use App\AffiliateDual;
use App\TopupTransaction;
use App\SettingAgentDiscount;
use App\Blog;
use App\BlogComment;
use App\SettingDualMain;
use App\SettingDualCommission;
use App\SettingTopup;
use App\OveridingQualification;
use App\SettingAffiliateTopup;
use App\RegisterWallet;
use App\SettingCharge;
use App\TransferProductWallet;
use App\PaymentBank;
use App\AdjustProductWallet;
use App\SettingPopUpImage;
use App\SettingGalleryImage;
use App\TreeView;

use Twilio\Rest\Client;

use DB, Auth, Validator, Redirect, Toastr, Session, DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function MyGroupSales()
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

        $groups = Affiliate::select('m.*', 'agent_lvl', 'upline.f_name as upline_name', 'sort_level')
                            ->join('merchants as m', 'm.code', 'affiliates.affiliate_id')
                            ->join('merchants as upline', 'upline.code', 'm.master_id')
                            ->leftJoin('agent_levels as l', 'l.id', 'm.lvl')
                            ->where('affiliates.user_id', Auth::user()->code)
                            ->where('m.status', '1')
                            ->orderBy('sort_level', 'asc');
        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        $queries = [];
        $columns = [
            'downline', 'upline', 'per_page'
        ];
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'downline'){
                    $groups = $groups->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%")
                                     ->orWhere('m.code', request($column));
                }elseif($column == 'upline'){
                    $groups = $groups->where(DB::raw('CONCAT(upline.f_name, " ", upline.l_name)'), 'like', "%".request($column)."%")
                                     ->orWhere('upline.code', request($column));
                }elseif($column == 'per_page'){
                    $groups = $groups->paginate($per_page);
                }

                $queries[$column] = request($column);

            }
        }

        if(!empty(request('per_page'))){
            $groups = $groups->appends($queries);        
        }else{
            $groups = $groups->paginate($per_page)->appends($queries);        
        }

        $getTotalGroupTopup = [];
        $getOwnSales = [];
        foreach($groups as $group){
            $getTotalGroupTopup[$group->code] = $this->getDownlineTotalGroupTopup($group->code, $start, $end);
            $getOwnSales[$group->code] = $this->getOwnSales($group->code, $start, $end);
        }

        return view('frontend.my_group_sales', ['groups'=>$groups, 'startDate'=>$startDate, 'endDate'=>$endDate], 
                                               compact('getTotalGroupTopup', 'getOwnSales'));
    }

    public function PrintMyGroupSales()
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

        $groups = Affiliate::select('m.*', 'agent_lvl', 'upline.f_name as upline_name', 'sort_level')
                            ->join('merchants as m', 'm.code', 'affiliates.affiliate_id')
                            ->join('merchants as upline', 'upline.code', 'm.master_id')
                            ->leftJoin('agent_levels as l', 'l.id', 'm.lvl')
                            ->where('affiliates.user_id', Auth::user()->code)
                            ->where('m.status', '1')
                            ->orderBy('sort_level', 'asc');

        $queries = [];
        $columns = [
            'downline', 'upline'
        ];
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'downline'){
                    $groups = $groups->where(DB::raw('CONCAT(m.f_name, " ", m.l_name)'), 'like', "%".request($column)."%")
                                     ->orWhere('m.code', request($column));
                }elseif($column == 'upline'){
                    $groups = $groups->where(DB::raw('CONCAT(upline.f_name, " ", upline.l_name)'), 'like', "%".request($column)."%")
                                     ->orWhere('upline.code', request($column));
                }

                $queries[$column] = request($column);

            }
        }
        $groups = $groups->get();

        $getTotalGroupTopup = [];
        $getOwnSales = [];
        foreach($groups as $group){
            $getTotalGroupTopup[$group->code] = $this->getDownlineTotalGroupTopup($group->code, $start, $end);
            $getOwnSales[$group->code] = $this->getOwnSales($group->code, $start, $end);
        }

        return view('frontend.print_my_group_sales', ['groups'=>$groups], compact('getTotalGroupTopup', 'getOwnSales'));   
    }

    public function blogs()
    {
        $blogs = Blog::where('status', '1')->get();
        return view('frontend.blogs', ['blogs'=>$blogs]);
    }

    public function blog_details($id)
    {
        $blog = Blog::find($id);
        $comments = BlogComment::select('blog_comments.comment', 'blog_comments.created_at',
                                        DB::raw('CONCAT(u.f_name, " ", u.l_name) AS u_name'),
                                        DB::raw('CONCAT(a.f_name, " ", a.l_name) AS a_name'),
                                        DB::raw('CONCAT(m.f_name, " ", m.l_name) AS m_name'))
                               ->leftJoin('users as u', 'u.code', 'blog_comments.user_id')
                               ->leftJoin('admins as a', 'a.code', 'blog_comments.user_id')
                               ->leftJoin('merchants as m', 'm.code', 'blog_comments.user_id')
                               ->where('blog_comments.blog_id', $id)
                               ->where('blog_comments.status', '1')
                               ->orderBy('blog_comments.created_at', 'desc')
                               ->get();

        if(empty($blog->id)){
          abort(404);
        }

        return view('frontend.blog_details', ['blog'=>$blog, 'comments'=>$comments]);
    }

    public function blog_comment(Request $request, $id)
    {
        $product = Product::find($id);
        BlogComment::create([
                              'blog_id'=>$product->id,
                              'user_id'=>Auth::user()->code,
                              'comment'=>$request->comment,
                            ]);

        Toastr::success("Comment Successful!");
        return redirect()->back();
    }

    public function about()
    {
        return view('frontend.about');
    }


public function faqs()
   {

       
        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY sort_level ASC) AS i");
        $diets = Diet::select('diets.*')
                           ->where('diets.status', '1')
                           ->whereNull('mall')
                           ->groupBy('diets.id')
                           ->orderBy('diets.product_name', 'asc');

        $queries = [];
        
        $p = $diets->get();
        $count_p = count($p);
        $diets = $diets->paginate(24)->appends($queries);
       
     
        
       

        
        $favourite = [];
        $listingImages = [];
        foreach ($diets as $key => $value) {
            if(!empty($userCode)){
              $favourite[$value->id] = Favourite::where('product_id', $value->id)->where('user_id', $userCode)->exists();
            }

            $listingImages[$value->id] = ProductImage::where('product_id', $value->id)->orderBy('sort_level', 'asc')->first();
        }

       
       

        return view('frontend.faqs', ['diets'=>$diets,  'count_p'=>$count_p, ], 
                                        compact('favourite',   'listingImages', ));
    }

    public function contact()
    {
        return view('frontend.contact');
    }

     public function tree_view()
    {
        $merchant = Merchant::where('code', Auth::user()->code)->first();
        $admin = Merchant::where('code', Auth::user()->code)->first();

        $merchantD = Merchant::where('master_id', Auth::user()->code)
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


        return view('frontend.tree_view', ['merchantD'=>$merchantD, 'merchant'=>$merchant,
                                               'fg'=>$fg, 'fgp'=>$fgp,], compact('mdd', 'mddd'));
    }

    public function gallery()
    {
      $gallery = SettingGalleryImage::where('status','1')->get();
      return view('frontend.gallery',['galleries'=>$gallery]);
    }

    public function merchant_register()
    {
        $pcs = SettingAffiliateTopup::find(request('pc'));
        $merchants = Merchant::where('status', '1')->get();
        $countries = TblCountry::get();
        return view('auth.merchant_register', ['merchants'=>$merchants, 'countries'=>$countries, 'pcs'=>$pcs]);
    }


    public function name_card($name, $id)
    {
        if(!empty(Auth::guard('admin')->check())){
            $buyerCode = Auth::guard('admin')->user()->code;
            $buyerLevel = Auth::guard('admin')->user()->lvl;
        }elseif(!empty(Auth::guard('merchant')->check())){
            $buyerCode = Auth::guard('merchant')->user()->code;
            $buyerLevel = Auth::guard('merchant')->user()->lvl;
        }elseif(!empty(Auth::guard('web')->check())){
            $buyerCode = Auth::guard('web')->user()->code;
            $buyerLevel = Auth::guard('web')->user()->lvl;
        }else{
            $buyerCode = "";
            $buyerLevel = "";
        }

        $userProfile = Merchant::where('code', $id)->first();

        if(empty($userProfile->id)){
            $userProfile = Admin::where('code', $id)->first();
        }

        if(empty($userProfile->id)){
          abort(404);
        }

        $level = "";
        if(!empty($userProfile->id)){
            $sLevel = AgentLevel::find($userProfile->lvl);
            if(!empty($sLevel->id)){
              $level = $sLevel->agent_lvl;
            }else{
              $level = "";
            }
        }
        $leftJoin = DB::raw("(SELECT * FROM product_images WHERE image NOT LIKE '%.mp4%' ORDER BY created_at ASC) AS i");
        $products_latest = Product::select('products.*', 'i.image', 'c.category_name',
                                           DB::raw('(CASE WHEN agent_special_price != 0  THEN agent_special_price ELSE agent_price END) AS agent_actual_price'),
                                           DB::raw('(CASE WHEN special_price != 0  THEN special_price ELSE price END) AS retail_price'))
                                 ->leftJoin($leftJoin, function($join) {
                                      $join->on('products.id', '=', 'i.product_id');
                                 })
                                 ->join('categories as c', 'c.id', 'products.category_id')
                                 ->where('products.status', '1')
                                 ->groupBy('products.id')
                                 ->orderBy('products.created_at', 'desc')
                                 ->take(12)
                                 ->get();
        $images = [];
        $Pimage = [];
        $stockBalance = [];
        $Ppackages = [];
        foreach($products_latest as $latest){
          $images[$latest->id] = ProductImage::where('product_id', $latest->id)
                                              ->where('status', '1')
                                              ->orderBy('created_at', 'asc')
                                              ->get();

          $Pimage[$latest->id] = ProductImage::where('product_id', $latest->id)->orderBy('product_id', 'asc')->first();

          if($latest->packages == 1 || $latest->variation_enable == 1){
            $stockBalance[$latest->id] = 1000000000;
          }else{
            $stockBalance[$latest->id] = $this->BalanceQuantity($latest->id);
          }

          $Ppackages[$latest->id] = PackageItem::select('p.product_name', 'package_items.*', 'i.image')
                                               ->join('products AS p', 'p.id', 'package_items.products')
                                               ->leftJoin($leftJoin, function($join) {
                                                   $join->on('p.id', '=', 'i.product_id');
                                               })
                                               ->where('package_items.product_id', $latest->id)
                                               ->groupBy('package_items.products')
                                               ->get();
        }

        return view('frontend.name_card', ['userProfile'=>$userProfile, 'level'=>$level, 'products_latest'=>$products_latest],
                                           compact('images', 'Pimage', 'stockBalance', 'Ppackages'));
    }

    public function index()
    {
        $leftJoin = DB::raw("(SELECT * FROM product_images WHERE image NOT LIKE '%.mp4%' ORDER BY created_at ASC) AS i");
        $leftJoin2 = DB::raw("(SELECT * FROM category_images ORDER BY created_at ASC) AS i");

        $products_top = Product::select('products.*', 'i.image')
                           ->leftJoin($leftJoin, function($join) {
                                $join->on('products.id', '=', 'i.product_id');
                           })
                           ->where('products.status', '1')
                           ->where('products.category_id', '1')
                           ->whereNull('mall')
                           ->groupBy('products.id')
                           ->get();


        $products_featured = Product::select('products.*', 'i.image', 'c.category_name',
                                             DB::raw('(CASE WHEN agent_special_price != 0  THEN agent_special_price ELSE agent_price END) AS agent_actual_price'),
                                             DB::raw('(CASE WHEN special_price != 0  THEN special_price ELSE price END) AS retail_price'))
                                   ->leftJoin($leftJoin, function($join) {
                                        $join->on('products.id', '=', 'i.product_id');
                                   })
                                   ->join('categories as c', 'c.id', 'products.category_id')
                                   ->where('products.status', '1')
                                   ->where('products.featured', '1')
                                   ->whereNull('mall')
                                   ->groupBy('products.id')
                                   ->orderBy('products.created_at', 'desc')
                                   ->take(12)
                                   ->get();

        $products_latest = Product::select('products.*', 'i.image', 'c.category_name',
                                             DB::raw('(CASE WHEN agent_special_price != 0  THEN agent_special_price ELSE agent_price END) AS agent_actual_price'),
                                             DB::raw('(CASE WHEN special_price != 0  THEN special_price ELSE price END) AS retail_price'))
                                   ->leftJoin($leftJoin, function($join) {
                                        $join->on('products.id', '=', 'i.product_id');
                                   })
                                   ->join('categories as c', 'c.id', 'products.category_id')
                                   ->where('products.status', '1')
                                   ->whereNull('mall')
                                   ->groupBy('products.id')
                                   ->orderBy('products.created_at', 'desc')
                                   ->take(12)
                                   ->get();

        $favourite = [];
        $priceV = [];
        $soldCount = [];
        foreach ($products_featured as $key => $value) {
            $favourite[$value->id] = Favourite::where('product_id', $value->id)->exists();

            $variations = ProductVariation::select(DB::raw("max(IF(variation_special_price != '0', variation_special_price, variation_price)) AS maxVPrice"),
                                                   DB::raw("max(IF(variation_agent_special_price != '0', variation_agent_special_price, variation_agent_price)) AS maxVAPrice"),
                                                   DB::raw("min(IF(variation_special_price != '0', variation_special_price, variation_price)) AS minVPrice"),
                                                   DB::raw("min(IF(variation_agent_special_price != '0', variation_agent_special_price, variation_agent_price)) AS minVAPrice"))
                                          ->where('product_id', $value->id)
                                          ->where('variation_name', '!=', '')
                                          ->first();
            $priceV[$value->id] = [$variations->maxVPrice, $variations->minVPrice, $variations->maxVAPrice, $variations->minVAPrice];
            
        }

        $featured_categories = Category::select('categories.*')
                              ->join('products as p', 'p.category_id', 'categories.id')
                              ->where('categories.status', '1')
                              ->where('p.featured', '1')
                              ->where('p.status', '1')
                              ->groupBy('categories.id')
                              ->orderBy('categories.created_at', 'desc')
                              ->get();

        $new_categories = Category::select('categories.*')
                              ->join('products as p', 'p.category_id', 'categories.id')
                              ->where('categories.status', '1')
                              ->groupBy('categories.id')
                              ->orderBy('categories.created_at', 'desc')
                              ->get();


        $categories = Category::select('categories.*', 'i.image')
                              ->join('category_images as i', 'categories.id', 'i.category_id')
                             ->where('categories.status', '1')
                             ->groupBy('categories.id')
                             ->get();

        $promotions = Promotion::where('status', '1')->get();

        // $this->sendMessage('User registration successful!!', '+60174194868');
        // $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");
        $thisweek = Transaction::select('i.image', 'p.*', DB::raw('SUM(d.quantity) AS totalBuy'))
                               ->join('transaction_details AS d', 'd.transaction_id', 'transactions.id')
                               ->join('products AS p', 'p.id', 'd.product_id')
                               ->leftJoin($leftJoin, function($join) {
                                  $join->on('p.id', '=', 'i.product_id');
                               })
                               ->where('transactions.status', '1')
                               ->groupBy('p.id')
                               ->orderBy('transactions.created_at', 'desc')
                               ->take(3)
                               ->get();
        $BalanceQuantity = [];
        foreach($thisweek as $value){
            $BalanceQuantity[$value->id] = $this->BalanceQuantity($value->id);
        }

        $banners = SettingBanner::get();

        $brands = Brand::where('status', '1')->get();

        // Yesterday Topup
        // $yesterday = date('Y-m-d', strtotime("-1 days"));
        // $topups = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalTopup'), 'user_id')
        //                           ->where('status', '1')
        //                           ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), $yesterday)
        //                           ->groupBy('user_id')
        //                           ->get();


        // foreach($topups as $topup){
        //     // $this->cashRebate($topup->user_id, $topup->totalTopup);
        //     // echo "<br>";
        // }

        //     // $this->checkQualification();

        // foreach($topups as $uplevel){
        //     // $this->AgentUpgrade($topup->user_id);
        // }
        $SettingBannerTesting = SettingBannerTesting::get();

        $SettingBannerVideo = SettingBannerVideo::get();

        $SettingPopUpImage = SettingPopUpImage::get();
        
        return view('frontend.home', ['products_top'=>$products_top, 'products_featured'=>$products_featured, 
                                      'promotions'=>$promotions, 'featured_categories'=>$featured_categories,
                                      'thisweek'=>$thisweek, 'categories'=>$categories, 'products_latest'=>$products_latest, 
                                      'new_categories'=>$new_categories, 'banners'=>$banners, 'brands'=>$brands, 'setting_banner_testing'=>$SettingBannerTesting, 'setting_banner_video'=>$SettingBannerVideo,
                                      'SettingPopUpImage'=>$SettingPopUpImage],
                                     compact('favourite', 'BalanceQuantity', 'priceV', 'soldCount'));
    }

    public function cashRebate($user_id, $totalAmount)
    {
        
        $affiliates = Affiliate::select('affiliates.*', 'm.lvl as upline_lvl', 'user_id as m_user_id')
                               ->join('merchants as m', 'm.code', 'affiliates.user_id')
                               ->where('affiliate_id', $user_id)
                               ->where('user_id', '!=', 'AD000001')
                               ->where('m.status', '1')
                               ->groupBy('m.code')
                               ->get();

        $mer = Merchant::select('merchants.*', 'lvl as upline_lvl', 'code as m_user_id')
                       ->where('code', $user_id)
                       ->get();

        $all = $affiliates->concat($mer);
        $all = array_reverse(array_sort($all, function ($value) {
            return $value['created_at'];
        }));

        foreach($all as $affiliate){

            if(!empty($affiliate->upline_lvl)){
              $SettingMerchantRebate = SettingMerchantRebate::where('agent_lvl', $affiliate->upline_lvl)->first();
              $qualified = 0;
              
              if(!empty($SettingMerchantRebate->personal_sale) || !empty($SettingMerchantRebate->line_group_sale)){
                  $oq = OveridingQualification::where('user_id', $affiliate->m_user_id)->first();
                  if(!empty($oq->id)){
                    $qualified = '1';
                  }
              }else{
                  $qualified = '1';
              }

              if($qualified == 1){
                  if(isset($currentM)){
                    if($currentM != $affiliate->m_user_id){
                        if(!empty($current_comm)){
                          $pay_comm = $SettingMerchantRebate->amount - $current_comm;
                          if($pay_comm <= 0){
                            $notsame = $current_comm;
                            $current_comm = $current_comm;
                            continue;
                          }else{
                            $notsame = $pay_comm;
                            $current_comm = $SettingMerchantRebate->amount;
                          }
                        }else{
                          $pay_comm = $SettingMerchantRebate->amount;  
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
                    $currentM = $affiliate->m_user_id;
                    if(!empty($SettingMerchantRebate->amount)){
                      $current_comm = $SettingMerchantRebate->amount;
                      $pay_comm = $SettingMerchantRebate->amount;
                    }
                  }

                  if(isset($pay_comm) && $pay_comm > 0){
                    // echo $pay_comm;
                    AffiliateCommission::create(['type'=>'8',
                                                 'user_id'=>$affiliate->m_user_id,
                                                 'product_amount'=>$totalAmount,
                                                 'comm_pa_type'=>'Percentage',
                                                 'comm_pa'=>$pay_comm,
                                                 'comm_amount'=>($totalAmount * $pay_comm / 100),
                                                 'comm_desc'=>'Cash Rebate From #'.$user_id]);

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

        if($merchant->lvl == 6){
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
                                  ->first();

        $myMemTran = Transaction::select(DB::raw('SUM(grand_total - processing_fee - shipping_fee) as totalPurchase'))
                                  ->whereIn('user_id', $myDownlineMem)
                                  ->where('status', '1')
                                  ->first();

        $myGroupTotal = $myTopup->totalAmount + $myGroupTopup->totalAmount + $DownMemTran->totalPurchase + $myMemTran->totalPurchase;

        $levels = AgentLevel::where('buy_quantity', '<=', $myGroupTotal)
                            ->orderBy('id', 'desc')
                            ->first();

        if(!empty($levels->id) && $merchant->lvl < $levels->id){
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
        $transaction = OveridingQualification::where('due_date', '>', date('Y-m-d'))->delete();
        $lastMonth = date("Y-m");
        $nextMonth = date("Y-m-t", strtotime("+1 month"));

        $merchants = Merchant::where('status', '1')->get();

        foreach($merchants as $merchant)
        {
            $setting_rebates = SettingMerchantRebate::where('agent_lvl', $merchant->lvl)->first();
            if(!empty($setting_rebates->id)){
                if(!empty($setting_rebates->personal_sale) || !empty($setting_rebates->line_group_sale)){
                    // echo 123;
                    $ownTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalAmount'))
                                                ->where('status', '1')
                                                ->where('user_id', $merchant->code)
                                                ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $lastMonth)
                                                ->first();


                    $selectDownlines = Merchant::where('master_id', $merchant->code)->get();
                    $totalCount[$merchant->code] = 0;
                    foreach($selectDownlines as $selectDownline){
                        $downlineAffs = Affiliate::select('affiliates.sort_level', 'affiliates.affiliate_id', 'u.f_name')
                                                 ->join('merchants AS u', 'u.code', 'affiliates.affiliate_id')
                                                 ->where('user_id', $selectDownline->code)
                                                 ->get();

                        $myGroup = [];
                        foreach($downlineAffs as $aff){
                            $myGroup[] = $aff->affiliate_id;
                        }

                        $myGroupTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalAmount'))
                                                        ->where('status', '1')
                                                        ->whereIn('user_id', $myGroup)
                                                        ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), $lastMonth)
                                                        ->first();

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

    private function sendMessage($message, $recipients)
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_number = getenv("TWILIO_NUMBER");
        $client = new Client($account_sid, $auth_token);
        $client->messages->create($recipients, 
                ['from' => $twilio_number, 'body' => $message] );
    }

    public function profile()
    {

      $lvl = "";
      $agentLVL = AgentLevel::find(Auth::user()->lvl);
      if(!empty($agentLVL->id)){
        $lvl = $agentLVL->agent_lvl;
      }

      $totalProductBalance = $this->GetProductWalletBalance();
      $totalCashBalance = $this->GetCashWalletBalance();
      $totalEarn = $this->getTotalWallet();
      $countPending = $this->countPending();
      $countToShip = $this->countToShip();
      $countToReceive = $this->countToReceive();
      $countCompleted = $this->countCompleted();
      $countCancelled = $this->countCancelled();

      return view('frontend.profile', ['lvl'=>$lvl, 
                                       'totalProductBalance'=>$totalProductBalance, 
                                       'totalCashBalance'=>$totalCashBalance, 
                                       'totalEarn'=>$totalEarn,
                                       'countPending'=>$countPending,
                                       'countToShip'=>$countToShip,
                                       'countToReceive'=>$countToReceive,
                                       'countCompleted'=>$countCompleted,
                                       'countCancelled'=>$countCancelled]);
    }

    public function updateProfile(Request $request)
    {
      $validator = Validator::make($request->all(), [
          'f_name' => 'required',
      ]);

      if ($validator->fails()) {
          return Redirect::back()->withInput(Input::all())->withErrors($validator);
      }

      $input = $request->all();
      
      if(Auth::guard('admin')->check()){
        $user = Admin::where('code', Auth::user()->code)->first();
      }elseif(Auth::guard('merchant')->check()){
        $user = Merchant::where('code', Auth::user()->code)->first();
      }else{
        $user = User::where('code', Auth::user()->code)->first();
      }

        if(!empty($request->e_shop_name)){
            // $checkMerch = Merchant::get();
            $checkMerch = Merchant::where('e_shop_name', $request->e_shop_name)
                                  ->where('code', '<>', $user->code)
                                  ->where('status', '!=', '3')
                                  ->exists();
            if($checkMerch == 1){
                return Redirect::back()->withInput(Input::all())->withErrors("E-Shop Name is similar to active users");
            }           
        }

      $input = Input::except('email');
      if(!empty($request->file('profile_logo'))){
          $files = $request->file('profile_logo'); 
          $name = $files->getClientOriginalName();
          $exp = explode(".", $name);
          $file_ext = end($exp);
          $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;

          $files->move("uploads/profile_logo/", $name);
          $input['profile_logo'] = "uploads/profile_logo/".$name;
          
      }

      if(!empty($request->file('bg_image'))){
          $files = $request->file('bg_image'); 
          $name = $files->getClientOriginalName();
          $exp = explode(".", $name);
          $file_ext = end($exp);
          $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;

          $files->move("uploads/bg_image/", $name);
          $input['bg_image'] = "uploads/bg_image/".$name;
      }
      $user = $user->update($input);

      Toastr::success("Profile Updated!");
      return redirect()->route('profile');
    }

    public function my_voucher()
    {
        $applied_promotions = Promotion::select('promotions.*', 'ap.*', 'ap.id AS apid')
                                       ->join('applied_promotions as ap', 'ap.promotion_id', 'promotions.id')
                                       ->where('ap.status', '99')
                                       ->where('start_date', '<=', date('Y-m-d H:i:s'))
                                       ->where('end_date', '>=', date('Y-m-d H:i:s'))
                                       ->where('ap.user_id', Auth::user()->code)
                                       ->get();

        return view('frontend.my_voucher', ['applied_promotions'=>$applied_promotions]);
    }

    public function pending_order()
    {
      $transactions = Transaction::where('user_id', Auth::user()->code)->where('status', '99')->orderBy('created_at', 'desc')->get();

      $lvl = "";
      $agentLVL = AgentLevel::find(Auth::user()->lvl);
      if(!empty($agentLVL->id)){
        $lvl = $agentLVL->agent_lvl;
      }

      $details = [];
      foreach($transactions as $transaction){
         $details[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();
      }

      $totalEarn = $this->getTotalWallet();
      $countPending = $this->countPending();
      $countToShip = $this->countToShip();
      $countToReceive = $this->countToReceive();
      $countCompleted = $this->countCompleted();
      $countCancelled = $this->countCancelled();

      return view('frontend.pending_order', ['transactions'=>$transactions, 'lvl'=>$lvl,
                                             'countPending'=>$countPending,
                                             'countToShip'=>$countToShip,
                                             'countToReceive'=>$countToReceive,
                                             'countCompleted'=>$countCompleted,
                                             'countCancelled'=>$countCancelled], compact('details'));
    }

    public function pending_shipping()
    {
      $transactions = Transaction::where('user_id', Auth::user()->code)
                                 ->whereIn('status', ['98', '1'])
                                 ->whereNull('tracking_no')
                                 ->whereNull('to_receive')
                                 ->orderBy('created_at', 'desc')
                                 ->get();

      $transactions2 = Transaction::where('user_id', Auth::user()->code)
                                  ->whereIn('status', ['98', '1'])
                                  ->orderBy('created_at', 'desc')
                                  ->get();

      $details = [];
      $ship_details = [];
      $CountTotal=0;

      foreach($transactions2 as $transaction){
         $details[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();

         $domain = "http://connect.easyparcel.my/?ac=";

         $action = "EPParcelStatusBulk";
         $postparam = array(
         'api'   => 'EP-58MhvS6xe',
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
          
          foreach($json->result as $value){
              foreach($value->parcel as $value2){
                  $ship_details[$transaction->id] = $value2->ship_status;
                  if($ship_details[$transaction->id] == 'Schedule In Arrangement' ||
                     $ship_details[$transaction->id] == 'Pending for Drop Off'){
                    $CountTotal++;
                  }
              }
          }
      }

      
      $lvl = "";
      $agentLVL = AgentLevel::find(Auth::user()->lvl);
      if(!empty($agentLVL->id)){
        $lvl = $agentLVL->agent_lvl;
      }

      $totalEarn = $this->getTotalWallet();
      $countPending = $this->countPending();
      $countToShip = $this->countToShip();
      $countToReceive = $this->countToReceive();
      $countCompleted = $this->countCompleted();
      $countCancelled = $this->countCancelled();


      if($CountTotal > 0){
        $transactions = $transactions2;
      }


      return view('frontend.pending_shipping', ['transactions'=>$transactions, 'lvl'=>$lvl,
                                                'CountTotal'=>$CountTotal,
                                                'countPending'=>$countPending,
                                                'countToShip'=>$countToShip,
                                                'countToReceive'=>$countToReceive,
                                                'countCompleted'=>$countCompleted,
                                                'countCancelled'=>$countCancelled], compact('details', 'ship_details'));
    }

    public function pending_receive()
    {
      $transactions = Transaction::where('user_id', Auth::user()->code)
                                 ->where('status', '1')
                                 ->where('to_receive', 1)
                                 ->whereNull('completed')
                                 ->orderBy('created_at', 'desc')
                                 ->get();

      $transactions2 = Transaction::where('user_id', Auth::user()->code)
                                   ->where('status', '1')
                                   ->whereNull('completed')
                                   ->orderBy('created_at', 'desc')
                                   ->get();

      $lvl = "";
      $agentLVL = AgentLevel::find(Auth::user()->lvl);
      if(!empty($agentLVL->id)){
        $lvl = $agentLVL->agent_lvl;
      }

      $details = [];
      $ship_details = [];
      $CountTotal=0;

      foreach($transactions2 as $transaction){

         $details[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();

         $domain = "http://connect.easyparcel.my/?ac=";

         $action = "EPParcelStatusBulk";
         $postparam = array(
          'api'   => 'EP-58MhvS6xe',
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
          // echo "<pre>"; print_r($json); echo "</pre>";
          
          foreach($json->result as $value){
              foreach($value->parcel as $value2){
                  $ship_details[$transaction->id] = $value2->ship_status;
                  if($ship_details[$transaction->id] == 'Pending For Collection' || $ship_details[$transaction->id] == 'Collected' || 
                     $ship_details[$transaction->id] == 'Delivering(in transit)' || 
                    $ship_details[$transaction->id] == 'Parcel Drop Off at Point'){
                      $CountTotal++;
                  }
              }
          }
      }

      $totalEarn = $this->getTotalWallet();
      $countPending = $this->countPending();
      $countToShip = $this->countToShip();
      $countToReceive = $this->countToReceive();
      $countCompleted = $this->countCompleted();
      $countCancelled = $this->countCancelled();


      if($CountTotal > 0){
        $transactions = $transactions2;
      }

      return view('frontend.pending_receive', ['transactions'=>$transactions, 'lvl'=>$lvl,
                                               'countPending'=>$countPending,
                                               'countToShip'=>$countToShip,
                                               'countToReceive'=>$countToReceive,
                                               'countCompleted'=>$countCompleted,
                                               'countCancelled'=>$countCancelled, 'CountTotal'=>$CountTotal], compact('details', 'ship_details'));
    }

    public function completed_order_invoice($transaction_no)
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

        return view('frontend.completed_order_invoice', ['transaction'=>$transaction, 'details'=>$details]);
    }

    public function completed_order()
    {
      $transactions = Transaction::where('user_id', Auth::user()->code)
                                 ->where(function($query){
                                    $query->where('status', '1')
                                          ->orWhere('completed', '1');
                                })
                                 ->orderBy('created_at', 'desc')->get();

      $lvl = "";
      $agentLVL = AgentLevel::find(Auth::user()->lvl);
      if(!empty($agentLVL->id)){
        $lvl = $agentLVL->agent_lvl;
      }

      $details = [];
      $ship_details = [];
      $CountTotal = 0;
      foreach($transactions as $transaction){
         $details[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();

         $domain = "http://connect.easyparcel.my/?ac=";

         $action = "EPParcelStatusBulk";
         $postparam = array(
         'api'   => 'EP-58MhvS6xe',
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
          
          foreach($json->result as $value){
              foreach($value->parcel as $value2){
                  $ship_details[$transaction->id] = $value2->ship_status;

                  if($ship_details[$transaction->id] == 'Successfully Delivered'){
                    $CountTotal++;

                  }
              }
          }          
      }

      $totalEarn = $this->getTotalWallet();
      $countPending = $this->countPending();
      $countToShip = $this->countToShip();
      $countToReceive = $this->countToReceive();
      $countCompleted = $this->countCompleted();
      $countCancelled = $this->countCancelled();

      return view('frontend.completed_order', ['transactions'=>$transactions, 'lvl'=>$lvl,
                                               'countPending'=>$countPending,
                                               'countToShip'=>$countToShip,
                                               'countToReceive'=>$countToReceive,
                                               'countCompleted'=>$countCompleted,
                                               'countCancelled'=>$countCancelled, 'CountTotal'=>$CountTotal], compact('details', 'ship_details')); 
    }


    public function cancelled_order()
    {
      $transactions = Transaction::where('user_id', Auth::user()->code)->where('status', '95')->orderBy('created_at', 'desc')->get();

      $lvl = "";
      $agentLVL = AgentLevel::find(Auth::user()->lvl);
      if(!empty($agentLVL->id)){
        $lvl = $agentLVL->agent_lvl;
      }

      $details = [];
      foreach($transactions as $transaction){
         $details[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();
      }

      $totalEarn = $this->getTotalWallet();
      $countPending = $this->countPending();
      $countToShip = $this->countToShip();
      $countToReceive = $this->countToReceive();
      $countCompleted = $this->countCompleted();
      $countCancelled = $this->countCancelled();

      return view('frontend.cancelled_order', ['transactions'=>$transactions, 'lvl'=>$lvl,
                                               'countPending'=>$countPending,
                                               'countToShip'=>$countToShip,
                                               'countToReceive'=>$countToReceive,
                                               'countCompleted'=>$countCompleted,
                                               'countCancelled'=>$countCancelled], compact('details')); 
    }

    public function my_setting()
    {
        $lvl = "";
        $agentLVL = AgentLevel::find(Auth::user()->lvl);
        if(!empty($agentLVL->id)){
          $lvl = $agentLVL->agent_lvl;
        }

        return view('frontend.my_settings', ['lvl'=>$lvl]);
    }

    public function myqrcode(){

      $affiliate_topups = SettingAffiliateTopup::get();

      return view('frontend.qrcode', ['affiliate_topups'=>$affiliate_topups]);
    }

    public function wallet()
    {
        $ProductWallet = $this->GetProductWalletBalance();
        $CashWallet = $this->GetCashWalletBalance();
        $registeWallet = $this->getTotalRegisterWallet();
        $floatingWallet = $this->getTotalFloatingWallet();
        
        $commissions = AffiliateCommission::select('affiliate_commissions.*', 't.shipping_fee', 't.processing_fee', 't.discount', 't.grand_total AS Gtotal')
                                          ->leftJoin('transactions AS t', 't.transaction_no', 'affiliate_commissions.transaction_no')
                                          ->where('affiliate_commissions.user_id', Auth::user()->code)
                                          ->orderBy('affiliate_commissions.created_at', 'desc')
                                          ->get();

        $withdrawlHistorys = WithdrawalTransaction::where('user_id', Auth::user()->code)
                                               ->orderBy('withdrawal_transactions.created_at', 'desc')
                                               ->get();

        $transactions = Transaction::select('transactions.*', 'transactions.id AS Tid')
                                   ->where('user_id', Auth::user()->code)
                                   ->where('status', '1')
                                   ->whereNotNull('mall')
                                   ->orderBy('created_at', 'desc')
                                   ->get();

        $topups = TopupTransaction::where('user_id', Auth::user()->code)
                                  ->where('status', '1')
                                  ->get();

        $totalRegister = RegisterWallet::where('created_by', Auth::user()->code)
                                       ->orWhere('user_id', Auth::user()->code)
                                       ->where('status', '1')
                                       ->get();

        $registerTopup = TopupTransaction::where('created_by', Auth::user()->code)
                                         ->where('status', '1')
                                         ->where('topup_payment_method', '3')
                                         ->get();


        $transferPW = TransferProductWallet::where('user_id', Auth::user()->code)
                                           ->where('status', '1')
                                           ->get();

        $deductWallet = Transaction::select('u.f_name as buyerName', 
                                            DB::raw('SUM(grand_total - shipping_fee - processing_fee) as dd_grand_total'), 
                                            'transactions.created_at','transactions.status', 
                                            'transactions.transaction_no as dd_transaction_no', 
                                            'transactions.user_id')
                                   ->join('users as u', 'u.code', 'transactions.user_id')
                                   ->where('u.master_id', Auth::user()->code)
                                   ->where('deduct_wallet', 1)
                                   ->groupBy('transaction_no')
                                   ->get();

        $AdjustWallet = AdjustProductWallet::select('adjust_product_wallets.*', 'amount as adjust_amount',
                                                    DB::raw('COALESCE(CONCAT(a.f_name, " ", a.l_name), m.f_name) as created_by_name'))
                                           ->leftJoin('admins as a', 'a.code', 'adjust_product_wallets.created_by')
                                           ->leftJoin('merchants as m', 'm.code', 'adjust_product_wallets.created_by')
                                           ->where('adjust_product_wallets.user_id', Auth::user()->code)
                                           ->where('adjust_product_wallets.status', '1')
                                           ->get();


        $purchaseDetail = [];
        foreach($transactions as $transaction){
          $purchaseDetail[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();
        }

        $all = $commissions->concat($withdrawlHistorys);
        $all = $all->concat($topups);
        $all = $all->concat($transactions);
        $all = $all->concat($totalRegister);
        $all = $all->concat($registerTopup);
        $all = $all->concat($transferPW);
        $all = $all->concat($deductWallet);
        $all = $all->concat($AdjustWallet);

        $all = array_reverse(array_sort($all, function ($value) {
            return $value['created_at'];
        }));

        $banksDefault = BankAccount::where('user_id', Auth::user()->code)
                                   ->where('default_banks', '1')
                                   ->first();
                                   
        $banks = BankAccount::where('user_id', Auth::user()->code)
                            ->orderBy('created_at', 'desc')
                            ->get();


        $lvl = "";
        $agentLVL = AgentLevel::find(Auth::user()->lvl);
        if(!empty($agentLVL->id)){
          $lvl = $agentLVL->agent_lvl;
        }

        $tuPackages = SettingTopup::get();

        $downlines = Merchant::where('master_id', Auth::user()->code)->where('status', '1')->get();

        $affiliate_topups = SettingAffiliateTopup::get();

        $setting_charges = SettingCharge::find(1);

        return view('frontend.wallet', ['all'=>$all, 'ProductWallet'=>$ProductWallet, 'CashWallet'=>$CashWallet, 'withdrawlHistorys'=>$withdrawlHistorys,
                                        'banks'=>$banks, 'banksDefault'=>$banksDefault, 'lvl'=>$lvl,
                                        'tuPackages'=>$tuPackages, 'registeWallet'=>$registeWallet,
                                        'downlines'=>$downlines, 'affiliate_topups'=>$affiliate_topups,
                                        'setting_charges'=>$setting_charges, 'floatingWallet'=>$floatingWallet], 
                                        compact('purchaseDetail'));
    }


    public function MyAffiliate($code)
    {
        $merchant = Merchant::where('code', $code)->first();
        $admin = Admin::where('code', $code)->first();
        $user = User::where('code', $code)->first();
        
        
        
        if(!empty($merchant->id)){
            $id = $merchant->code;
            $name = $merchant->f_name.' '.$merchant->l_name;
            $phone = $merchant->phone;
            $lvl = $merchant->lvl;
            $permission_lvl = $merchant->permission_lvl;
            $profile_logo = $merchant->profile_logo;
            $upline = $merchant->master_id;
        }elseif(!empty($user->id)){
            $id = $user->code;
            $name = $user->f_name.' '.$user->l_name;
            $phone = $user->phone;
            $lvl = $user->lvl;
            $permission_lvl = $user->permission_lvl;
            $profile_logo = $user->profile_logo;
            $upline = $user->master_id;
        }else{
            $id = $admin->code;
            $name = $admin->f_name.' '.$admin->l_name;
            $phone = $admin->phone;
            $profile_logo = $admin->profile_logo;
            $lvl = 2;
            $permission_lvl = $admin->permission_lvl;
            $upline = "";
        }
        
        $affiliates = Merchant::where('master_id', $code);

        if(!empty(request('name'))){
            $affiliates = $affiliates->where(DB::raw("CONCAT(f_name, l_name)"), 'like', '%'.request('name').'%');
        }

        $affiliates = $affiliates->get();

        $OwnAffiliate = $this->GetOwnTotalAffiliates($code);
        $OwnTotalAffiliate = $this->GetSelectedUserTotalAffiliates($code);
        $OwnMonthlyTotalAffiliate = $this->GetSelectedUserMonthlyTotalAffiliates($code);
        $GetSelectedUserDailyTotalAffiliates = $this->GetSelectedUserDailyTotalAffiliates($code);
        $TotalAffiliates = [];
        $TodayTotalAffiliates = [];


        
        foreach($affiliates as $affiliate){
            $TotalAffiliates[$affiliate->code] = $this->GetTotalAffiliates($affiliate->code);
            $TodayTotalAffiliates[$affiliate->code] = $this->GetTodayTotalAffiliates($affiliate->code);
        }

        return view('frontend.my_affiliates', ['affiliates'=>$affiliates, 'OwnTotalAffiliate'=>$OwnTotalAffiliate, 
                                                 'OwnMonthlyTotalAffiliate'=>$OwnMonthlyTotalAffiliate, 
                                                 'GetSelectedUserDailyTotalAffiliates'=>$GetSelectedUserDailyTotalAffiliates,
                                                 'name'=>$name,
                                                 'code'=>$code,
                                                 'lvl'=>$lvl,
                                                 'upline'=>$upline,
                                                 'phone'=>$phone,
                                                 'profile_logo'=>$profile_logo,
                                                 'OwnAffiliate'=>$OwnAffiliate,
                                                 'permission_lvl'=>$permission_lvl],
                                                 compact('TotalAffiliates', 'TodayTotalAffiliates'));
    }

    public function MyCustomer($code)
    {
        $merchant = Merchant::where('code', $code)->first();
        $admin = Admin::where('code', $code)->first();
        $user = User::where('code', $code)->first();
        
        
        
        if(!empty($merchant->id)){
            $id = $merchant->code;
            $name = $merchant->f_name.' '.$merchant->l_name;
            $phone = $merchant->phone;
            $lvl = $merchant->lvl;
            $permission_lvl = $merchant->permission_lvl;
            $profile_logo = $merchant->profile_logo;
            $upline = $merchant->master_id;
        }elseif(!empty($user->id)){
            $id = $user->code;
            $name = $user->f_name.' '.$user->l_name;
            $phone = $user->phone;
            $lvl = $user->lvl;
            $permission_lvl = $user->permission_lvl;
            $profile_logo = $user->profile_logo;
            $upline = $user->master_id;
        }else{
            $id = $admin->code;
            $name = $admin->f_name.' '.$admin->l_name;
            $phone = $admin->phone;
            $profile_logo = $admin->profile_logo;
            $lvl = 2;
            $permission_lvl = $admin->permission_lvl;
            $upline = "";
        }
        
        $affiliates = User::where('master_id', $code);

        if(!empty(request('name'))){
            $affiliates = $affiliates->where(DB::raw("CONCAT(f_name, l_name)"), 'like', '%'.request('name').'%');
        }

        $affiliates = $affiliates->get();

        $totalCustomer = $this->totalCustomer($code);
        $TodayNewCustomer = $this->TodayNewCustomer($code);
        $TotalSales = $this->TotalSales($code);

        $TotalAffiliates = [];
        $TodayTotalAffiliates = [];


        
        foreach($affiliates as $affiliate){
            $customerTotalTodaySales[$affiliate->code] = $this->customerTotalTodaySales($affiliate->code);
        }

        return view('frontend.my_customers', ['affiliates'=>$affiliates, 
                                               'totalCustomer'=>$totalCustomer, 
                                               'TodayNewCustomer'=>$TodayNewCustomer, 
                                               'TotalSales'=>$TotalSales,
                                               'name'=>$name,
                                               'code'=>$code,
                                               'lvl'=>$lvl,
                                               'upline'=>$upline,
                                               'phone'=>$phone,
                                               'profile_logo'=>$profile_logo,
                                               'permission_lvl'=>$permission_lvl],
                                               compact('customerTotalTodaySales'));
    }

    public function totalCustomer($code)
    {
      $affiliate = User::select(DB::raw('COUNT(id) AS TotalCustomer'))
                              ->where('master_id', $code)
                              ->first();

      return  $affiliate->TotalCustomer;
    }

    public function TodayNewCustomer($code)
    {
      $affiliate = User::select(DB::raw('COUNT(id) AS TotalCustomer'))
                              ->where('master_id', $code)
                              ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), date('Y-m-d'))
                              ->first();

      return  $affiliate->TotalCustomer;
    }

    public function TotalSales($code)
    {
      $transaction = Transaction::select(DB::raw('SUM(grand_total - processing_fee - shipping_fee) as totalPurchase'))
                                ->join('users as u', 'u.code', 'transactions.user_id')
                                ->where('u.master_id', $code)
                                ->first();

      return  !empty($transaction->totalPurchase) ? number_format($transaction->totalPurchase, 2) : '0.00';
    }

    public function customerTotalTodaySales($code)
    {
        $transaction = Transaction::select(DB::raw('SUM(grand_total - processing_fee - shipping_fee) as totalPurchase'))
                                ->where('user_id', $code)
                                ->first();

        return  !empty($transaction->totalPurchase) ? number_format($transaction->totalPurchase, 2) : '0.00';
    }

    public function GetOwnTotalAffiliates($code)
    {
      $affiliate = Merchant::select(DB::raw('COUNT(id) AS TotalAffiliates'))
                              ->where('master_id', $code)
                              ->first();

      return  $affiliate->TotalAffiliates;
    }

    public function GetTotalAffiliates($code)
    {
        $affiliate = Merchant::select(DB::raw('COUNT(id) AS TotalAffiliates'))
                              ->where('master_id', $code)
                              ->first();

        $affiliate2 = Merchant::select(DB::raw('COUNT(d.id) AS TotalAffiliates2'))
                              ->join('merchants AS d', 'd.master_id', 'merchants.code')
                              ->where('merchants.master_id', $code)
                              ->first();

        return  $affiliate->TotalAffiliates + $affiliate2->TotalAffiliates2;
    }

    public function GetTodayTotalAffiliates($code)
    {
        $affiliate = Merchant::select(DB::raw('COUNT(id) AS TotalAffiliates'))
                              ->where('master_id', $code)
                              ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), date('Y-m-d'))
                              ->first();

        $affiliate2 = Merchant::select(DB::raw('COUNT(d.id) AS TotalAffiliates2'))
                              ->join('merchants AS d', 'd.master_id', 'merchants.code')
                              ->where('merchants.master_id', $code)
                              ->where(DB::raw('DATE_FORMAT(merchants.created_at, "%Y-%m-%d")'), date('Y-m-d'))
                              ->first();

        return  $affiliate->TotalAffiliates + $affiliate2->TotalAffiliates2;
    }

    public function GetSelectedUserTotalAffiliates($code)
    {
        $affiliate = Merchant::select(DB::raw('COUNT(id) AS TotalAffiliates'))
                              ->where('master_id', $code)
                              ->first();


        $affiliate2 = Merchant::select(DB::raw('COUNT(d.id) AS TotalAffiliates2'))
                              ->join('merchants AS d', 'd.master_id', 'merchants.code')
                              ->where('merchants.master_id', $code)
                              ->first();

        return  $affiliate->TotalAffiliates + $affiliate2->TotalAffiliates2;
    }

    public function GetSelectedUserMonthlyTotalAffiliates($code)
    {
        $affiliate = Merchant::select(DB::raw('COUNT(id) AS TotalAffiliates'))
                              ->where('master_id', $code)
                              ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'), date('Y-m'))
                              ->first();

        $affiliate2 = Merchant::select(DB::raw('COUNT(d.id) AS TotalAffiliates2'))
                              ->join('merchants AS d', 'd.master_id', 'merchants.code')
                              ->where('merchants.master_id', $code)
                              ->where(DB::raw('DATE_FORMAT(merchants.created_at, "%Y-%m")'), date('Y-m'))
                              ->first();

        return  $affiliate->TotalAffiliates + $affiliate2->TotalAffiliates2;
    }

    public function GetSelectedUserDailyTotalAffiliates($code)
    {
        $affiliate = Merchant::select(DB::raw('COUNT(id) AS TotalAffiliates'))
                              ->where('master_id', $code)
                              ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), date('Y-m-d'))
                              ->first();

        $affiliate2 = Merchant::select(DB::raw('COUNT(d.id) AS TotalAffiliates2'))
                              ->join('merchants AS d', 'd.master_id', 'merchants.code')
                              ->where('merchants.master_id', $code)
                              ->where(DB::raw('DATE_FORMAT(merchants.created_at, "%Y-%m-%d")'), date('Y-m-d'))
                              ->first();

        return  $affiliate->TotalAffiliates + $affiliate2->TotalAffiliates2;
    }

    public function bank_account()
    {
        $lvl = "";
        $agentLVL = AgentLevel::find(Auth::user()->lvl);
        if(!empty($agentLVL->id)){
          $lvl = $agentLVL->agent_lvl;
        }

        $banks = PaymentBank::where('status', '1')->get();
        return view('frontend.bank_account', ['lvl'=>$lvl, 'banks'=>$banks]);
    }

    public function bank_account_edit($id)
    {
      $bank = BankAccount::find($id);
      if(empty($bank->id) || $bank->user_id != Auth::user()->code){
        abort(404);
      }

      $agentLVL = AgentLevel::find(Auth::user()->lvl);
      if(!empty($agentLVL->id)){
        $lvl = $agentLVL->agent_lvl;
      }
      $banks = PaymentBank::where('status', '1')->get();
      
      return view('frontend.bank_account', ['bank'=>$bank, 'lvl'=>$lvl, 'banks'=>$banks]);
    }

    public function bank_account_save(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->code;
        $count = BankAccount::select(DB::raw('COUNT(id) AS totalBanks'))
                            ->where('user_id', Auth::user()->code)
                            ->first();
        if(empty($count->totalBanks)){
          $input['default_banks'] = '1';
        }

        if(!empty($request->bid)){
          $bank_acc = BankAccount::find($request->bid);
          $bank_acc = $bank_acc->update($input);
        }else{
          $bank_acc = BankAccount::create($input);          
        }


        Toastr::success("Bank Account Updated");
        return redirect()->route('wallet');  
    }

    public function save_wallet(Request $request)
    {
      $validator = Validator::make($request->all(), [
          
      ]);

      if ($validator->fails()) {
          return Redirect::back()->withInput(Input::all())->withErrors($validator);
      }

      $amount = preg_replace("/[^0-9\.]/", '', $request->amount);
        
      if(floatval($amount) <= 0){
          return Redirect::back()->withInput(Input::all())->withErrors('Please key in correct amount');
      }
      // return (float)$amount.' - '.(float)$request->wallet_balance;
      if(floatval($this->GetCashWalletBalance()) < floatval($amount)){
          // return 123;
          return Redirect::back()->withInput(Input::all())->withErrors('Insufficient balance');
      }

      $check = WithdrawalTransaction::where('user_id', Auth::user()->code)
                                      ->where('status', '99')
                                      ->first();
     

      $setting_charges = SettingCharge::find(1);

      $input = $request->all();
      $input['status'] = '99';
      $defaultBank = BankAccount::where('default_banks', '1')
                                  ->where('user_id', Auth::user()->code)
                                  ->first();
      if(!empty($defaultBank->id)){
        $input['bank_name'] = $defaultBank->bank_name;
        $input['bank_holder_name'] = $defaultBank->bank_holder_name;
        $input['bank_account'] = $defaultBank->bank_account;
      }
      $input['user_id'] = Auth::user()->code;
      $input['amount'] = $amount;

      $charges = 0;
      $charges_type = "";
      $charges_amount = 0;
      if(!empty($setting_charges->id) && !empty($setting_charges->withdrawal_charges_amount)){
          if($setting_charges->withdrawal_charges_type == 'Percentage'){
              $charges = $amount * $setting_charges->withdrawal_charges_amount / 100;
          }else{
              $charges = $amount - $setting_charges->withdrawal_charges_amount;
          }
          $charges_type = $setting_charges->withdrawal_charges_type;
          $charges_amount = $setting_charges->withdrawal_charges_amount;
      }

      $input['actual_amount'] = $amount - $charges;
      $input['charges_type'] = $charges_type;
      $input['charges_amount'] = $charges_amount;
      $input['withdrawal_no'] = $this->GenerateWithdrawalTransactionNo();

      $withdrawal = WithdrawalTransaction::create($input);
      
      Toastr::success("Withdrawal Submited, Waiting Admin For Approval");
      return redirect()->route('wallet');
    }

    public function GetProductWalletBalance()
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
                                             ->whereIn('status', ['99', '1'])
                                             ->first();

        $totalIn = RegisterWallet::select(DB::raw('SUM(amount) as totalBalance'))
                                      ->where('created_by', Auth::user()->code)
                                      ->where('transfer_type', '1')
                                      ->where('status', '1')
                                      ->first();

        $transferPW = TransferProductWallet::select(DB::raw('SUM(amount) as TotaltransferPW'))
                                           ->where('user_id', $buyerCode)
                                           ->where('status', '1')
                                           ->first();

        $topup = TopupTransaction::select(DB::raw('SUM(actual_amount) as TotalTopup'))
                                 ->where('user_id', $buyerCode)
                                 ->where('status', '1')
                                 ->where('topup_payment_method', '4')
                                 ->first();

        $totalBalance = 0;
        
        $totalBalance = $balance->totalBalance - $withdrawal->totalWithdrawal - $totalIn->totalBalance - $transferPW->TotaltransferPW - $topup->TotalTopup;
        

        return $totalBalance;
    }

    public function getTotalWallet()
    {
        $total = AffiliateCommission::select(DB::raw('SUM(comm_amount) as totalBalance'))
                                      ->where('user_id', Auth::user()->code)
                                      ->where('status', '1')
                                      ->first();
                                      
        $topup = TopupTransaction::select(DB::raw('SUM(amount) as TotalTopup'))
                                 ->where('user_id', Auth::user()->code)
                                 ->where('status', '1')
                                 ->first();

        return  $total->totalBalance + $topup->TotalTopup;
    }

    public function getTotalRegisterWallet()
    {
        $totalIn = RegisterWallet::select(DB::raw('SUM(amount) as totalBalance'))
                                      ->where('user_id', Auth::user()->code)
                                      ->where('transfer_type', '1')
                                      ->where('status', '1')
                                      ->first();
                                      
        $totalOut = RegisterWallet::select(DB::raw('SUM(amount) as totalBalance'))
                                      ->where('user_id', Auth::user()->code)
                                      ->where('transfer_type', '2')
                                      ->where('status', '1')
                                      ->first();

        $registerTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalBalance'))
                                         ->where('created_by', Auth::user()->code)
                                         ->where('status', '1')
                                         ->where('topup_payment_method', '3')
                                         ->first();

        return  $totalIn->totalBalance + $totalOut->totalBalance - $registerTopup->totalBalance;
    }

    public function getTotalFloatingWallet()
    {
        $balance = AffiliateCommission::select(DB::raw('SUM(comm_amount) as totalBalance'))
                                      ->where('user_id', Auth::user()->code)
                                      ->where('status', '99')
                                      ->first();

        return $balance->totalBalance;
    }

    public function GetUplineProductWalletBalance($user)
    {
        $balance = AffiliateCommission::select(DB::raw('SUM(comm_amount) as totalBalance'))
                                      ->where('user_id', $user)
                                      ->where('status', '1')
                                      ->first();

        $withdrawal = WithdrawalTransaction::select(DB::raw('SUM(amount) as totalWithdrawal'))
                                             ->where('user_id', $user)
                                             ->where('status', '1')
                                             ->first();

        $transaction = Transaction::select(DB::raw('SUM(grand_total) AS totalUsedPoint'))
                                  ->where('user_id', $user)
                                  ->where('mall', '1')
                                  ->where('status', '1')
                                  ->first();
        
        $topup = TopupTransaction::select(DB::raw('SUM(amount) as TotalTopup'))
                                 ->where('user_id', $user)
                                 ->where('status', '1')
                                 ->first();
        
        $transferPW = TransferProductWallet::select(DB::raw('SUM(amount) as TotaltransferPW'))
                                           ->where('user_id', $user)
                                           ->where('status', '1')
                                           ->first();


        $totalBalance = 0;
        
        $totalBalance = $topup->TotalTopup - $transaction->totalUsedPoint + $transferPW->TotaltransferPW;
        

        return $totalBalance;
    }

    public function order_list()
    {
        $lvl = "";
        $agentLVL = AgentLevel::find(Auth::user()->lvl);
        if(!empty($agentLVL->id)){
          $lvl = $agentLVL->agent_lvl;
        }

        $transactions = Transaction::where('user_id', Auth::user()->code)->orderBy('created_at', 'desc')->get();
        $details = [];
        foreach($transactions as $transaction){
           $details[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();
        }

        return view('frontend.order', ['transactions'=>$transactions, 'lvl'=>$lvl], compact('details'));
    }

    public function order_detail($no)
    {

        $lvl = "";
        $agentLVL = AgentLevel::find(Auth::user()->lvl);
        if(!empty($agentLVL->id)){
          $lvl = $agentLVL->agent_lvl;
        }
        
        $transaction = Transaction::select('transactions.*', 'p.amount_type', 'p.amount AS discount_amount')
                                  ->leftJoin('promotions AS p', 'p.id', 'transactions.discount_code')
                                  ->where('transaction_no', $no)
                                  ->first();
        if(empty($transaction->id)){
          abort(404);
        }

        $details = TransactionDetail::where('transaction_id', $transaction->id)->get();

        return view('frontend.order_detail', ['transaction'=>$transaction, 'details'=>$details, 'lvl'=>$lvl]);
    }

    public function wish_list()
    {
        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");
  
        $favourites = Favourite::select('p.*', 'i.image', DB::raw('COALESCE(special_price, price) AS actual_price'))
                               ->join('products AS p', 'p.id', 'favourites.product_id')
                               ->leftJoin($leftJoin, function($join) {
                                  $join->on('p.id', '=', 'i.product_id');
                               })
                               ->where('user_id', Auth::user()->code)
                               ->groupBy('p.id')
                               ->get();
        $stockBalance = [];
        foreach($favourites as $favourite){
            $stockBalance[$favourite->id] = $this->BalanceQuantity($favourite->id);
        }

        $lvl = "";
        $agentLVL = AgentLevel::find(Auth::user()->lvl);
        if(!empty($agentLVL->id)){
          $lvl = $agentLVL->agent_lvl;
        }

        return view('frontend.wish_list', ['favourites'=>$favourites, 'lvl'=>$lvl], compact('stockBalance'));
    }

    public function changePassword()
    {
        return view('frontend.change_password');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return Redirect::back()->withInput(Input::all())->withErrors(['Current Password Not Match']);
        }

        if($request->new_password != $request->password_confirmation){
            return Redirect::back()->withInput(Input::all())->withErrors(['The new password confirmation does not match.']);
        }
        
        if(Auth::guard('admin')->check()){
          $update = Admin::where('code', Auth::user()->code)->first();
        }elseif(Auth::guard('merchant')->check()){
          $update = Merchant::where('code', Auth::user()->code)->first();
        }else{
          $update = User::where('code', Auth::user()->code)->first();
        }
        $update = $update->update(['password'=>Hash::make($request->new_password)]);

        Toastr::success("Password Changed Successfully!");
        return redirect()->route('changePassword');
    }

   public function listing()
    {

        if(Auth::guard('web')->check()){
          $user = Auth::guard('web')->check();
          $userCode = Auth::guard('web')->user()->code;
        }elseif (Auth::guard('merchant')->check()) {
          $user = Auth::guard('merchant')->check();
          $userCode = Auth::guard('merchant')->user()->code;
        }elseif (Auth::guard('admin')->check()) {
          $user = Auth::guard('admin')->check();
          $userCode = Auth::guard('admin')->user()->code;
        }else{
          $user = "";
          $userCode = "";
        }

        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY sort_level ASC) AS i");
        $products = Product::select('products.*', 'c.category_name', 'b.brand_name',
                                    DB::raw('(CASE WHEN agent_special_price != 0  THEN agent_special_price ELSE agent_price END) AS agent_actual_price'),
                                    DB::raw('(CASE WHEN special_price != 0  THEN special_price ELSE price END) AS retail_price'))
                           ->leftJoin('categories AS c', 'c.id', 'products.category_id')
                           ->leftJoin('sub_categories AS sc', 'sc.id', 'products.sub_category_id')
                           ->leftJoin('brands AS b', 'b.id', 'products.brand_id')
                           ->where('products.status', '1')
                           ->whereNull('mall')
                           ->groupBy('products.id')
                           ->orderBy('products.product_name', 'asc');

        $queries = [];
        $columns = [
           'result', 'brand', 'category', 'subcategory', 'from', 'to'
        ];
        // return htmlspecialchars(request('category'));
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                
                if($column == 'category'){
                  $products = $products->where('c.category_name', request($column));
                }elseif($column == 'subcategory'){
                  $products = $products->where('sc.sub_category_name', request($column));
                }elseif($column == 'brand'){
                  $products = $products->where('b.brand_name', request($column));
                }elseif($column == 'from' || $column == 'to'){
                  $from = preg_replace("/[^0-9\.]/", '', request('from'));
                  $to = preg_replace("/[^0-9\.]/", '', request('to'));
                  if(Auth::guard('merchant')->check() || Auth::guard('admin')->check()){
                      if(!empty(request('from')) && empty(request('to'))){

                          $products = $products->where(DB::raw('COALESCE(agent_special_price, agent_price)'), '>=', $from);
                      }elseif(empty(request('from')) && !empty(request('to'))){
                          $products = $products->where(DB::raw('COALESCE(agent_special_price, agent_price)'), '<=', $to);
                      }else{
                          $products = $products->where(DB::raw('COALESCE(agent_special_price, agent_price)'), '>=', $from)
                                               ->where(DB::raw('COALESCE(agent_special_price, agent_price)'), '<=', $to);
                      }
                  }else{
                      if(!empty(request('from')) && empty(request('to'))){
                          $products = $products->where(DB::raw('COALESCE(special_price, price)'), '>=', $from);
                      }elseif(empty(request('from')) && !empty(request('to'))){
                          $products = $products->where(DB::raw('COALESCE(special_price, price)'), '<=', $to);
                      }else{
                          $products = $products->where(DB::raw('COALESCE(special_price, price)'), '>=', $from)
                                               ->where(DB::raw('COALESCE(special_price, price)'), '<=', $to);
                      }                    
                  }

                }else{
                  // $products = $products->WhereRaw("MATCH(products.product_name) AGAINST('".request($column)."*' IN BOOLEAN MODE)")
                  //                      ->orWhereRaw("MATCH(b.brand_name) AGAINST('".request($column)."*' IN BOOLEAN MODE)")
                  //                      ->orWhereRaw("MATCH(c.category_name) AGAINST('".request($column)."*' IN BOOLEAN MODE)");
                  $products = $products->where('products.product_name', 'like', '%'.request($column).'%');
                }
                
                $queries[$column] = request($column);

            }
        }
        // echo $products = $products->toSql();

        // exit();

        $p = $products->get();
        $count_p = count($p);
        $products = $products->paginate(24)->appends($queries);
        $priceV = [];
        $soldCount = [];
        foreach($products as $product){
            $variations = ProductVariation::select(DB::raw("max(IF(variation_special_price != '0', variation_special_price, variation_price)) AS maxVPrice"),
                                                   DB::raw("max(IF(variation_agent_special_price != '0', variation_agent_special_price, variation_agent_price)) AS maxVAPrice"),
                                                   DB::raw("min(IF(variation_special_price != '0', variation_special_price, variation_price)) AS minVPrice"),
                                                   DB::raw("min(IF(variation_agent_special_price != '0', variation_agent_special_price, variation_agent_price)) AS minVAPrice"),
                                                   
                                                   DB::raw('min(variation_agent_special_price) as MinVASPrice'), 
                                                   DB::raw('min(variation_agent_price) as MinVAPrice'),
                                                   DB::raw('max(variation_agent_special_price) as MaxVASPrice'),
                                                   DB::raw('max(variation_agent_price) as MaxVAPrice'),

                                                   DB::raw('min(variation_special_price) as MinVSPrice'), 
                                                   DB::raw('min(variation_price) as MinVPrice'),
                                                   DB::raw('max(variation_special_price) as MaxVSPrice'),
                                                   DB::raw('max(variation_price) as MaxVPrice'))
                                          ->where('product_id', $product->id)
                                          ->where('variation_name', '!=', '')
                                          ->first();
            $priceV[$product->id] = [$variations->maxVPrice, $variations->minVPrice, $variations->maxVAPrice, $variations->minVAPrice,
                                     $variations->MinVASPrice, $variations->MinVAPrice, $variations->MaxVASPrice, $variations->MaxVAPrice, 
                                     $variations->MinVSPrice, $variations->MinVPrice, $variations->MaxVSPrice, $variations->MaxVPrice];

            $soldCount[$product->id] = $this->getProductSold($product->id);
        }
        
        // $categories = [];
        // $brands = [];
        // foreach($products as $product){
        //   $categories[] = $product->category_name;
        //   $brands[] = $product->brand_name;
        // }

        $categories = Category::where('status', '1')->get();
        $sub_categories = [];
        foreach($categories as $category){
            $sub_categories[$category->id] = SubCategory::where('category_id', $category->id)->where('status', '1')->get();
        }

        $brands = Brand::where('status', '1')->get();

        $favourite = [];
        $listingImages = [];
        foreach ($products as $key => $value) {
            if(!empty($userCode)){
              $favourite[$value->id] = Favourite::where('product_id', $value->id)->where('user_id', $userCode)->exists();
            }

            $listingImages[$value->id] = ProductImage::where('product_id', $value->id)->orderBy('sort_level', 'asc')->first();
        }

        $sp_products = Product::select('products.*', 'i.image',
                                       DB::raw('(CASE WHEN agent_special_price != 0  THEN agent_special_price ELSE agent_price END) AS agent_actual_price'),
                                       DB::raw('(CASE WHEN special_price != 0  THEN special_price ELSE price END) AS retail_price'))
                              ->leftJoin($leftJoin, function($join) {
                                  $join->on('products.id', '=', 'i.product_id');
                              })
                              ->where(function($query){
                                  $query->where('agent_special_price', '!=', '0')
                                        ->orWhere('special_price', '!=', '0');
                              })
                              ->where('products.status', '1')
                              ->get();

        $MaxMinPrice = Product::select(DB::raw('max(COALESCE(special_price, price)) AS max_price'),
                                       DB::raw('min(COALESCE(special_price, price)) AS min_price'))
                              ->where('status', '1')
                              ->first();

        return view('frontend.listing', ['products'=>$products, 'categories'=>$categories, 'brands'=>$brands, 'count_p'=>$count_p, 'sp_products'=>$sp_products, 'MaxMinPrice'=>$MaxMinPrice], 
                                        compact('favourite', 'priceV', 'sub_categories', 'listingImages', 'soldCount'));
    }

    public function details($name, $id)
    {
        if(Auth::guard('web')->check()){
          $user = Auth::guard('web')->check();
          $userCode = Auth::guard('web')->user()->code;
        }elseif (Auth::guard('merchant')->check()) {
          $user = Auth::guard('merchant')->check();
          $userCode = Auth::guard('merchant')->user()->code;
        }elseif (Auth::guard('admin')->check()) {
          $user = Auth::guard('admin')->check();
          $userCode = Auth::guard('admin')->user()->code;
        }else{
          $user = "";
          $userCode = "";
        }
        
        $product = Product::select('products.*', 'u.uom_name', 'b.brand_name')
                          ->leftJoin('setting_uoms AS u', 'u.id', 'products.product_type')
                          ->leftJoin('brands AS b', 'b.id', 'products.brand_id')
                          ->where(DB::raw('md5(products.id)'), $id)
                          ->first();
        if(empty($product)){
            return redirect()->route('home');
        }

        if($product->packages == 1 || $product->variation_enable == 1){
          $stockBalance = 1000000000;
        }else{
          $stockBalance = $this->BalanceQuantity($product->id);          
        }
        $images = ProductImage::where('product_id', $product->id)
                              ->where('status', '1')
                              ->orderBy('sort_level', 'asc')
                              ->get();

        $favourite = [];
        if($user){
          $favourite = Favourite::where('user_id', $userCode)
                                ->where('product_id', $product->id)
                                ->first();
        }

        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");
        $products = Product::select('products.*', 'i.image')
                           ->join('product_images as i', 'products.id', 'i.product_id')
                           ->where(DB::raw('md5(products.id)'), '<>', $id)
                           ->where('products.status', '1')
                           ->groupBy('products.id')
                           ->take(8)
                           ->get();
        $priceV = [];
        foreach($products as $related_product){
          $variations = ProductVariation::select(DB::raw("max(IF(variation_special_price != '0', variation_special_price, variation_price)) AS maxVPrice"),
                                                   DB::raw("max(IF(variation_agent_special_price != '0', variation_agent_special_price, variation_agent_price)) AS maxVAPrice"),
                                                   DB::raw("min(IF(variation_special_price != '0', variation_special_price, variation_price)) AS minVPrice"),
                                                   DB::raw("min(IF(variation_agent_special_price != '0', variation_agent_special_price, variation_agent_price)) AS minVAPrice"))
                                          ->where('product_id', $related_product->id)
                                          ->where('variation_name', '!=', '')
                                          ->first();

          $priceV[$related_product->id] = [$variations->maxVPrice, $variations->minVPrice, $variations->maxVAPrice, $variations->minVAPrice];
        }
        $sub_category_id = [];
        if(!empty($product->sub_category_id)){
           $sub_category_id = SubCategory::whereIn('id', explode(",", $product->sub_category_id))->get();
        }

        $Pimage = ProductImage::where(DB::raw('md5(product_id)'), $id)->orderBy('sort_level', 'asc')->first();

        $Ppackages = PackageItem::select('p.product_name', 'package_items.*', 'i.image')
                                ->join('products AS p', 'p.id', 'package_items.products')
                                ->leftJoin($leftJoin, function($join) {
                                    $join->on('p.id', '=', 'i.product_id');
                                })
                                ->where(DB::raw('md5(package_items.product_id)'), $id)
                                ->groupBy('package_items.products')
                                ->get();
        $comments = BlogComment::select('blog_comments.comment', 'blog_comments.created_at',
                                        DB::raw('CONCAT(u.f_name, " ", u.l_name) AS u_name'),
                                        DB::raw('CONCAT(a.f_name, " ", a.l_name) AS a_name'),
                                        DB::raw('CONCAT(m.f_name, " ", m.l_name) AS m_name'))
                               ->leftJoin('users as u', 'u.code', 'blog_comments.user_id')
                               ->leftJoin('admins as a', 'a.code', 'blog_comments.user_id')
                               ->leftJoin('merchants as m', 'm.code', 'blog_comments.user_id')
                               ->where('blog_comments.blog_id', $id)
                               ->where('blog_comments.status', '1')
                               ->orderBy('blog_comments.created_at', 'desc')
                               ->get();
        $variations = ProductVariation::where(DB::raw('md5(product_id)'), $id)->where('variation_name', '!=', '')->get();

        $vStock = [];
        foreach($variations as $variation){
            $vStock[$variation->id] = $this->VariationBalanceQuantity($variation->id);
        }

        return view('frontend.details', ['product'=>$product, 'stockBalance'=>$stockBalance, 'images'=>$images, 'favourite'=>$favourite, 
                                         'products'=>$products, 'Pimage'=>$Pimage, 'Ppackages'=>$Ppackages,
                                         'sub_category_id'=>$sub_category_id, 'variations'=>$variations, 'comments'=>$comments], compact('vStock','priceV'));
    }
    



    
    public function cart()
    {
        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");

        $carts = Cart::select('carts.id AS cid', 'p.*', 'i.image', 'carts.qty', 'p.weight', 
                              DB::raw('COALESCE(special_price, price) AS actual_price'), 
                              DB::raw('COALESCE(agent_special_price, agent_price) AS agent_actual_price'), 
                              'scl.sub_category_name AS l_sub_name', 'scr.sub_category_name AS r_sub_name')
                     ->join('products AS p', 'p.id', 'carts.product_id')
                     ->leftJoin('sub_categories AS scl', 'scl.id', 'carts.sub_category_id')
                     ->leftJoin('sub_categories AS scr', 'scr.id', 'carts.second_sub_category_id')
                     ->leftJoin($leftJoin, function($join) {
                        $join->on('p.id', '=', 'i.product_id');
                     })
                     ->where('carts.status', '1')
                     ->where('carts.user_id', Auth::user()->code)
                     ->groupBy('carts.id');
        if(!empty(request('m')) && request('m') == '1'){
          $carts = $carts->where('p.mall', '1');
        }else{
          $carts = $carts->whereNULL('p.mall');
        }

        $carts = $carts->get();
        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");
        $products = Product::select('products.*', 'i.image')
                           ->leftJoin($leftJoin, function($join) {
                                $join->on('products.id', '=', 'i.product_id');
                           })
                           ->where('products.status', '1')
                           ->groupBy('products.id')
                           ->take(16)
                           ->get();

        if(!$carts->isEmpty()){
            foreach($carts as $key => $cart){
                $stockBalance[$cart->cid] = $this->BalanceQuantity($cart->id);
            }

            return view('frontend.cart', ['carts'=>$carts, 'products'=>$products], compact('stockBalance'));
        }else{
            $stockBalance = 0;
            return view('frontend.cart', ['carts'=>$carts, 'products'=>$products], compact('stockBalance'));
        }
    }

    public function checkout()
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

        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");
        $carts = Cart::select('carts.id AS cid', 'p.*', 'i.image', 'carts.qty', DB::raw('COALESCE(special_price, price) AS actual_price'),
                              DB::raw('COALESCE(agent_special_price, agent_price) AS agent_actual_price'),
                              'scl.variation_name', 'scl.variation_price', 'scl.variation_special_price', 'scl.variation_agent_price', 'scl.variation_agent_special_price', 'scl.variation_weight',
                              'p.weight', 'p.special_price', 'p.price', 'p.agent_special_price', 'p.agent_price', 'variation_enable')
                     ->join('products AS p', 'p.id', 'carts.product_id')
                     ->leftJoin('product_variations AS scl', 'scl.id', 'carts.sub_category_id')
                     ->leftJoin($leftJoin, function($join) {
                        $join->on('p.id', '=', 'i.product_id');
                     })
                     ->where('carts.status', '1')
                     ->where('carts.user_id', $buyerCode)
                     ->groupBy('carts.id');
                     
        if(!empty(request('m')) && request('m') == '1'){
          $carts = $carts->where('mall', '1');
        }else{
          $carts = $carts->whereNull('mall');
        }
        $carts = $carts->get();
        $states = State::get();

        if($carts->isEmpty()){
          Toastr::info("Cart is empty");
          return redirect()->route('home');
        }

        $weight = 0;
        foreach($carts as $cart){
            if($cart->variation_enable == '1'){
              if(!empty($cart->variation_weight)){
                  $weight += $cart->variation_weight * $cart->qty;
              }
            }else{
              $weight += $cart->weight * $cart->qty;
            }
        }

        $shipping_address = UserShippingAddress::select('user_shipping_addresses.*', 'name')
                                               ->join('states AS s', 's.id', 'user_shipping_addresses.state')
                                               ->where('user_id', $buyerCode)
                                               ->where('default', '1')
                                               ->first();
        $totalshipping_fees = 0;

        if(!empty($shipping_address)){
            if($shipping_address->state > 16){
              $shipping_fees = SettingShippingFee::where('weight', '<=', ceil($weight))
                                                 ->where('area', 'sg')
                                                 ->orderBy('weight', 'desc')
                                                 ->first();
              if(!empty($shipping_fees->id)){
                $totalshipping_fees = $shipping_fees->shipping_fee;                
              }
            }elseif($shipping_address->state != '11' && $shipping_address->state != '12' && $shipping_address->state != '15'){
              $shipping_fees = SettingShippingFee::where('weight', '<=', ceil($weight))
                                                 ->where('area', 'west')
                                                 ->orderBy('weight', 'desc')
                                                 ->first();
              if(!empty($shipping_fees->id)){
                $totalshipping_fees = $shipping_fees->shipping_fee;                
              }

            }else{
              $shipping_fees = SettingShippingFee::where('weight', '<=', ceil($weight))
                                                 ->where('area', 'east')
                                                 ->orderBy('weight', 'desc')
                                                 ->first();
              if(!empty($shipping_fees->id)){
                $totalshipping_fees = $shipping_fees->shipping_fee;                
              }
            }
        }

        $totalBalance = $this->GetProductWalletBalance();

        $banks = Bank::orderBy('id', 'asc')->get();

        $checkAppliedPromo = AppliedPromotion::select('applied_promotions.*', 'p.start_date', 'p.end_date', 'p.discount_code', 'p.amount_type', 'p.amount')
                                             ->join('promotions AS p', 'p.id', 'applied_promotions.promotion_id')
                                             ->where('applied_promotions.user_id', $buyerCode)
                                             ->where('applied_promotions.status', '1')
                                             ->where('p.status', '1')
                                             ->first();
        // return 123;
        if(!empty($checkAppliedPromo->id)){
            if(date('Y-m-d H:i:s') > $checkAppliedPromo->end_date){
                $checkAppliedPromo = "";
            }
        }

        $getClaimedPromos = AppliedPromotion::select('applied_promotions.*', 'p.start_date', 'p.end_date', 'p.discount_code', 'p.amount_type', 'p.amount', 'p.image', 'p.promotion_title', 
                                                     'applied_promotions.id as apid')
                                            ->join('promotions AS p', 'p.id', 'applied_promotions.promotion_id')
                                            ->where('applied_promotions.user_id', $buyerCode)
                                            ->where('applied_promotions.status', '99')
                                            ->where('p.status', '1')
                                            ->get();
        $agentDiscount = 0;
        $agentDiscountType = "";
        if(Auth::guard('merchant')->check()){
            $settings = SettingAgentDiscount::find(1);
            if(!empty($settings->id)){
                $agentDiscount = $settings->amount;
                $agentDiscountType = $settings->type;
            }
        }

        return view('frontend.checkout', ['carts'=>$carts, 'states'=>$states, 'shipping_address'=>$shipping_address, 
                                          'totalBalance'=>$totalBalance, 'banks'=>$banks, 'totalshipping_fees'=>$totalshipping_fees,
                                          'checkAppliedPromo'=>$checkAppliedPromo, 'agentDiscount'=>$agentDiscount, 
                                          'agentDiscountType'=>$agentDiscountType,'getClaimedPromos'=>$getClaimedPromos]);
    }

    public function checkout_link()
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

        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");
        $carts = Cart::select('carts.id AS cid', 'p.*', 'i.image', 'carts.qty', DB::raw('COALESCE(special_price, price) AS actual_price'),
                              DB::raw('COALESCE(agent_special_price, agent_price) AS agent_actual_price'),
                              'scl.variation_name', 'scl.variation_price', 'scl.variation_special_price', 'scl.variation_agent_price', 'scl.variation_agent_special_price', 'scl.variation_weight',
                              'p.weight', 'p.special_price', 'p.price', 'p.agent_special_price', 'p.agent_price', 'variation_enable')
                     ->join('products AS p', 'p.id', 'carts.product_id')
                     ->leftJoin('product_variations AS scl', 'scl.id', 'carts.sub_category_id')
                     ->leftJoin($leftJoin, function($join) {
                        $join->on('p.id', '=', 'i.product_id');
                     })
                     ->where('carts.status', '1')
                     ->where('carts.user_id', $buyerCode)
                     ->groupBy('carts.id');
                     
        if(!empty(request('m')) && request('m') == '1'){
          $carts = $carts->where('mall', '1');
        }else{
          $carts = $carts->whereNull('mall');
        }
        $carts = $carts->get();
        $states = State::get();

        if($carts->isEmpty()){
          Toastr::info("Cart is empty");
          return redirect()->route('home');
        }

        $weight = 0;
        foreach($carts as $cart){
            if($cart->variation_enable == '1'){
              if(!empty($cart->variation_weight)){
                  $weight += $cart->variation_weight * $cart->qty;
              }
            }else{
              $weight += $cart->weight * $cart->qty;
            }
        }

        $shipping_address = UserShippingAddress::select('user_shipping_addresses.*', 'name')
                                               ->join('states AS s', 's.id', 'user_shipping_addresses.state')
                                               ->where('user_id', $buyerCode)
                                               ->where('default', '1')
                                               ->first();
        $totalshipping_fees = 0;

        if(!empty($shipping_address)){
            if($shipping_address->state > 16){
              $shipping_fees = SettingShippingFee::where('weight', '<=', ceil($weight))
                                                 ->where('area', 'sg')
                                                 ->orderBy('weight', 'desc')
                                                 ->first();
              if(!empty($shipping_fees->id)){
                $totalshipping_fees = $shipping_fees->shipping_fee;                
              }
            }elseif($shipping_address->state != '11' && $shipping_address->state != '12' && $shipping_address->state != '15'){
              $shipping_fees = SettingShippingFee::where('weight', '<=', ceil($weight))
                                                 ->where('area', 'west')
                                                 ->orderBy('weight', 'desc')
                                                 ->first();
              if(!empty($shipping_fees->id)){
                $totalshipping_fees = $shipping_fees->shipping_fee;                
              }

            }else{
              $shipping_fees = SettingShippingFee::where('weight', '<=', ceil($weight))
                                                 ->where('area', 'east')
                                                 ->orderBy('weight', 'desc')
                                                 ->first();
              if(!empty($shipping_fees->id)){
                $totalshipping_fees = $shipping_fees->shipping_fee;                
              }
            }
        }

        $totalBalance = $this->GetProductWalletBalance();

        $banks = Bank::orderBy('id', 'asc')->get();

        $checkAppliedPromo = AppliedPromotion::select('applied_promotions.*', 'p.start_date', 'p.end_date', 'p.discount_code', 'p.amount_type', 'p.amount')
                                             ->join('promotions AS p', 'p.id', 'applied_promotions.promotion_id')
                                             ->where('applied_promotions.user_id', $buyerCode)
                                             ->where('applied_promotions.status', '1')
                                             ->where('p.status', '1')
                                             ->first();
        // return 123;
        if(!empty($checkAppliedPromo->id)){
            if(date('Y-m-d H:i:s') > $checkAppliedPromo->end_date){
                $checkAppliedPromo = "";
            }
        }

        $getClaimedPromos = AppliedPromotion::select('applied_promotions.*', 'p.start_date', 'p.end_date', 'p.discount_code', 'p.amount_type', 'p.amount', 'p.image', 'p.promotion_title', 
                                                     'applied_promotions.id as apid')
                                            ->join('promotions AS p', 'p.id', 'applied_promotions.promotion_id')
                                            ->where('applied_promotions.user_id', $buyerCode)
                                            ->where('applied_promotions.status', '99')
                                            ->where('p.status', '1')
                                            ->get();
        $agentDiscount = 0;
        $agentDiscountType = "";
        if(Auth::guard('merchant')->check()){
            $settings = SettingAgentDiscount::find(1);
            if(!empty($settings->id)){
                $agentDiscount = $settings->amount;
                $agentDiscountType = $settings->type;
            }
        }

        return view('frontend.checkout', ['carts'=>$carts, 'states'=>$states, 'shipping_address'=>$shipping_address, 
                                          'totalBalance'=>$totalBalance, 'banks'=>$banks, 'totalshipping_fees'=>$totalshipping_fees,
                                          'checkAppliedPromo'=>$checkAppliedPromo, 'agentDiscount'=>$agentDiscount, 
                                          'agentDiscountType'=>$agentDiscountType,'getClaimedPromos'=>$getClaimedPromos]);
    }

    public function postCheckout(Request $request)
    {

        // $selected_cart = [];
        // foreach($request->input('selected_cart') as $key => $value){
        //     $selected_cart[] = [$value];
        // }
        // $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");
        // $carts = Cart::select('carts.id AS cid', 'p.*', 'i.image', 'carts.qty', DB::raw('COALESCE(special_price, price) AS actual_price'),
        //                       DB::raw('COALESCE(agent_special_price, agent_price) AS agent_actual_price'),
        //                       'scl.sub_category_name AS l_sub_name', 'scr.sub_category_name AS r_sub_name', 'p.weight')
        //              ->join('products AS p', 'p.id', 'carts.product_id')
        //              ->leftJoin('sub_categories AS scl', 'scl.id', 'carts.sub_category_id')
        //              ->leftJoin('sub_categories AS scr', 'scr.id', 'carts.second_sub_category_id')
        //              ->leftJoin($leftJoin, function($join) {
        //                 $join->on('p.id', '=', 'i.product_id');
        //              })
        //              ->where('carts.status', '1')
        //              ->where('carts.user_id', Auth::user()->code)
        //              ->whereIn(DB::raw("md5(carts.id)"), $selected_cart)
        //              ->groupBy('carts.id');
        // if(!empty(request('m')) && request('m') == '1'){
        //   $carts = $carts->where('mall', '1');
        // }else{
        //   $carts = $carts->whereNull('mall');
        // }
        // $carts = $carts->get();
        // $states = State::get();

        // $shipping_address = UserShippingAddress::where('user_id', Auth::user()->code)
        //                                        ->where('default', '1')
        //                                        ->first();

        // $shipping_fee = SettingShippingFee::first();

        // $totalBalance = $this->GetWalletBalance();

        // $banks = Bank::orderBy('id', 'asc')->get();

        // $checkAppliedPromo = AppliedPromotion::select('applied_promotions.*', 'p.start_date', 'p.end_date', 'p.discount_code', 'p.amount_type', 'p.amount')
        //                                      ->join('promotions AS p', 'p.id', 'applied_promotions.promotion_id')
        //                                      ->where('applied_promotions.user_id', Auth::user()->code)
        //                                      ->where('applied_promotions.status', '99')
        //                                      ->where('p.status', '1')
        //                                      ->first();
        // // return 123;
        // if(!empty($checkAppliedPromo->id)){
        //     if(date('Y-m-d H:i:s') > $checkAppliedPromo->end_date){
        //         $checkAppliedPromo = "";
        //     }
        // }

        // return view('frontend.checkout', ['carts'=>$carts, 'states'=>$states, 'shipping_address'=>$shipping_address, 
        //                                   'shipping_fee'=>$shipping_fee, 'totalBalance'=>$totalBalance, 'banks'=>$banks, 'checkAppliedPromo'=>$checkAppliedPromo]);
    }


    public function placeOrder(Request $request){
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

        if(!empty(Session::get('agent_code'))){
          // create member account with session agent code as upline
          // $member = User::create($value);
          //send email with generated password (without hash)
          
          //update carts, user shipping address user_id

          // $buyerCode = $member->code;
        }

        if(!isset($request->customer_address)){
          if(empty($request->billing_details_im)){
              $validator = Validator::make($request->all(), [
                  'f_name' => 'required',
                  'l_name' => 'required',
                  'email' => 'required',
                  'phone' => 'required',
                  'address' => 'required',
                  'city' => 'required',
                  'postcode' => 'required',
              ]);

              if ($validator->fails()) {
                  return Redirect::back()->withInput(Input::all())->withErrors($validator);
              }

              $input = $request->all();
              $input['user_id'] = $buyerCode;
              $input['default'] = '1';
              $input['state'] = $request->state;
              $create_shipping_address = UserShippingAddress::create($input);
          }

          $shipping_address = UserShippingAddress::where('user_id', $buyerCode)
                                                 ->where('default', '1')
                                                 ->first();          
        }else{
          $validator = Validator::make($request->all(), [
                  'c_f_name' => 'required',
                  'c_l_name' => 'required',
                  'c_address' => 'required',
                  'c_postcode' => 'required',
                  'c_city' => 'required',
                  'c_state' => 'required',
                  'c_phone' => 'required',
              ]);

              if ($validator->fails()) {
                  return Redirect::back()->withInput(Input::all())->withErrors('Please fill in customer shipping address');
              }
        }

        $selected_cart = [];
        foreach($request->selected_cart as $key => $value){
            $selected_cart[] = [$value];
        }

        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");
        $carts = Cart::select('carts.*', 'p.product_name', 'agent_price', 'agent_special_price', 'price', 'special_price', 'weight',
                              DB::raw('SUM(IF(special_price != "0", special_price * qty, price * qty)) AS totalSum'), 
                              DB::raw('SUM(IF(agent_special_price != "0", agent_price * qty, price * qty)) AS totalAgentSum'), 
                              'i.image', 'p.item_code', 'p.product_code', 
                              'scl.variation_name', 'scl.variation_price', 'scl.variation_special_price', 'scl.variation_agent_price', 
                              'scl.variation_agent_special_price', 'scl.variation_weight', 
                              'p.product_comm_type', 'p.product_comm_amount', 'own_product_comm_type', 'own_product_comm_amount', 
                              'in_product_comm_type', 'in_product_comm_amount', 'p.variation_enable', 'scl.id as vid')
                     ->join('products AS p', 'p.id', 'carts.product_id')
                     ->leftJoin('product_variations AS scl', 'scl.id', 'carts.sub_category_id')
                     ->leftJoin($leftJoin, function($join) {
                        $join->on('p.id', '=', 'i.product_id');
                     })
                     ->where('carts.status', '1')
                     ->where('carts.user_id', $buyerCode)
                     ->whereIn(DB::raw("md5(carts.id)"), $selected_cart)
                     ->groupBy('carts.id')
                     ->get();
        $totalAmount = 0;
        $totalWeight = 0;
        $totalPFee = 0;
        foreach($carts as $cart){
          
          if(Auth::guard('merchant')->check() || Auth::guard('admin')->check()){
            if($cart->variation_enable == '1'){
              if(!empty($cart->variation_agent_special_price)){
                $totalAmount += $cart->variation_agent_special_price * $cart->qty;
              }else{
                $totalAmount += $cart->variation_agent_price * $cart->qty;             
              }
            }else{
              if(!empty($cart->agent_special_price)){
                $totalAmount += $cart->agent_special_price * $cart->qty;
              }else{
                $totalAmount += $cart->agent_price * $cart->qty;             
              }              
            }
          }else{
            if($cart->variation_enable == '1'){
              if(!empty($cart->variation_special_price)){
                $totalAmount += $cart->variation_special_price * $cart->qty;
              }else{
                $totalAmount += $cart->variation_price * $cart->qty;             
              }
            }else{
              if(!empty($cart->special_price)){
                $totalAmount += $cart->special_price * $cart->qty;
              }else{
                $totalAmount += $cart->price * $cart->qty;             
              }
            }
          }
          if($cart->variation_enable == '1'){
            $totalWeight += $cart->variation_weight * $cart->qty;
          }else{
            $totalWeight += $cart->weight * $cart->qty;
          }
          // $totalAmount += $cart->totalSum;
        }
        // echo $totalAmount;
        // exit();
        if($carts->isEmpty()){
          Toastr::info("Cart is empty, please re-order/re-payment.");
          return redirect()->route('home');
        }
        $totalAmount = $totalAmount + $request->hidden_shipping_amount;
        $input = $request->all();
        if(!empty($request->hidden_discount) && $request->hidden_discount != '0'){
          $totalAmount = $totalAmount - $request->hidden_discount;
          $updateAppliedDiscount = AppliedPromotion::where('status', '1')
                                                   ->where('promotion_id', $request->discount_code)
                                                   ->where('user_id', $buyerCode)
                                                   ->update(['status'=>'2']);

          $input['discount'] = $request->hidden_discount;
          $input['discount_code'] = $request->discount_code;
        }

        
        if(Auth::guard('merchant')->check() && !empty($request->hidden_ad_discount) && $request->hidden_ad_discount != '0'){
          
          $totalAmount = $totalAmount - $request->hidden_ad_discount;
          $input['ad_discount'] = $request->hidden_ad_discount;
        }

        // if(empty($request->mall) && $request->mall != '1' && $request->cdm != '1' && $request->wallet != '1'){
        //   $totalPFee = $totalAmount * 1.6 / 100;
        //   $totalAmount = $totalAmount + ($totalAmount * 1.6 / 100);          
        // }

        if($totalAmount <= 0){
            if($request->cdm == 1){
                $totalAmount = $request->hidden_shipping_amount;
            }else{
                $totalAmount = $request->hidden_shipping_amount + ($request->hidden_shipping_amount * 1.6 /100);
            }
        }
        

        $guest_agent = "";
        $guest_agent_type = "";
        
        if(!empty(Session::get('guest_agent'))){
          $m = Merchant::where('code', Session::get('guest_agent'))->first();
          if(!empty($m->id)){
            $guest_agent = $m->code;
            $guest_agent_type = $m->agent_type;
          }
          $input['guest_agent'] = $guest_agent;
        }
        $input['weight'] = $totalWeight;
        $input['transaction_no'] = $this->GenerateTransactionNo();
        $input['sub_total'] = $request->sub_total;
        $input['shipping_fee'] = !empty($request->hidden_shipping_amount) ? $request->hidden_shipping_amount : 0;
        $input['grand_total'] = number_format($totalAmount, 2, '.', '');
        $input['user_id'] = $buyerCode;
        $input['address_name'] = $shipping_address->f_name.' '.$shipping_address->l_name;
        $input['address'] = $shipping_address->address;
        $input['postcode'] = $shipping_address->postcode;
        $input['city'] = $shipping_address->city;
        $input['state'] = $shipping_address->state;
        $input['phone'] = $shipping_address->phone;
        $input['email'] = $shipping_address->email;
        
        if(empty($request->mall) && $request->mall != '1'){
          if($request->cdm == 1){
              $files = $request->file('bank_slip'); 
              $name = $files->getClientOriginalName();
              $exp = explode(".", $name);
              $file_ext = end($exp);
              $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
              $files->move("uploads/bank_slip/".$buyerCode."/", $name);

              $input['cdm_bank_id'] = $request->cdm_bank_id;
              $input['bank_slip'] = "uploads/bank_slip/".$buyerCode."/".$name;
              $input['status'] = '98';
          }elseif($request->wallet == 1){
              $input['mall'] = '1';
              $input['status'] = '1';
          }else{
              // $input['processing_fee'] = !empty($totalPFee) ? number_format($totalPFee, 2) : 0;
              $input['bank_id'] = $request->bank_id;
              $input['status'] = '99';
          }
        }else{
          $input['status'] = '1';
        }

        $buyerupline = User::where('code', $buyerCode)->first();

        if(!empty($buyerupline->id)){
            $uplineWallet = $this->GetUplineProductWalletBalance($buyerupline->master_id);
            if($uplineWallet >= floatval($totalAmount)){
                $setting_charges = SettingCharge::find(1);
                $charges = 0;
                $charges_type = "";
                $charges_amount = 0;
                if(!empty($setting_charges->id) && !empty($setting_charges->transfer_wallet_charges_amount)){
                    $charges_type = $setting_charges->transfer_wallet_charges_type;
                    $charges_amount = $setting_charges->transfer_wallet_charges_amount;
                }

                $input['deduct_wallet'] = 1;
                $input['transaction_charges_type'] = $charges_type;
                $input['transaction_charges_amount'] = $charges_amount;
            }
        }

        $transaction = Transaction::create($input);
        $items = [];
        $own_product_comm_type = "";
        $own_product_comm_amount = 0;
        foreach($carts as $cart){
            if(Auth::guard('merchant')->check() || Auth::guard('admin')->check()){
              if($cart->variation_enable == '1'){
                $actual_price = (!empty($cart->variation_agent_special_price) && $cart->variation_agent_special_price != 0) ? $cart->variation_agent_special_price : $cart->variation_agent_price;
              }else{
                $actual_price = (!empty($cart->agent_special_price) && $cart->agent_special_price != 0) ? $cart->agent_special_price : $cart->agent_price;
              }
            }else{
              if($cart->variation_enable == '1'){
                $actual_price = (!empty($cart->variation_special_price) && $cart->variation_special_price != 0) ? $cart->variation_special_price : $cart->variation_price;
              }else{
                $actual_price = (!empty($cart->special_price) && $cart->special_price != 0) ? $cart->special_price : $cart->price;
              }
            }
            if(Auth::guard('merchant')->check()){
              if(Auth::guard('merchant')->user()->agent_type == '1'){
                  $own_product_comm_type = $cart->in_product_comm_type;
                  $own_product_comm_amount = $cart->in_product_comm_amount;
              }else{
                  $own_product_comm_type = $cart->own_product_comm_type;
                  $own_product_comm_amount = $cart->own_product_comm_amount;
              }              
            }

            if($guest_agent_type == '2'){
              $product_comm_type = $cart->in_product_comm_type;
              $product_comm_amount = $cart->in_product_comm_amount;
            }else{
              $product_comm_type = $cart->product_comm_type;
              $product_comm_amount = $cart->product_comm_amount;
            }

            $items[] = ['transaction_id'=>$transaction->id,
                        'product_id'=>$cart->product_id,
                        'item_code'=>$cart->item_code,
                        'product_code'=>$cart->product_code,
                        'unit_weight'=>$cart->weight,
                        'product_image'=>$cart->image,
                        'product_name'=>$cart->product_name,
                        'unit_price'=>$actual_price,
                        'product_comm_type'=>$product_comm_type,
                        'product_comm_amount'=>$product_comm_amount,
                        'own_product_comm_type'=>$own_product_comm_type,
                        'own_product_comm_amount'=>$own_product_comm_amount,
                        'quantity'=>$cart->qty,
                        'sub_category'=>$cart->variation_name,
                        'variation_id'=>$cart->vid,
                        'second_sub_category'=>$cart->r_sub_name,
                        'total_amount'=>$cart->totalSum,
                        'status'=>'1',
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s')];
        }

        $t_detail = TransactionDetail::insert($items);

        $bank = Bank::find($request->bank_id);

        $delete_cart = Cart::whereIn(DB::raw("md5(carts.id)"), $selected_cart)->delete();
        
        // Toastr::success("Order Successfully!");
        // return redirect()->route('order_list');
        if((!empty($request->mall) && $request->mall == '1') || !empty($request->cdm) && $request->cdm == '1'){
          $this->sendEmailNotification("sonezack5577@gmail.com", "noreply@vesson.my", "Zack", "New Order", $transaction->transaction_no);
          if(Auth::guard('web')->check() || Auth::guard('admin')->check() || Auth::guard('merchant')->check()){
            Toastr::success('Order Successfully');
            return \Redirect::route('faqs');
          }
        }elseif($request->wallet == 1){
          $totalBalance = $this->GetProductWalletBalance();
          $merchant = Merchant::where('code', $buyerCode)->first();
          if($totalBalance <= 100){
            $this->ProductPointNotication($merchant->email, "noreply@vesson.my", "Zack", "Product Wallet Notification", $merchant);
          }
          Toastr::success('Your order has been placed successfully');
            return \Redirect::route('pending_shipping');
        }else{
          // $this->guestPlacedOrderMessage($shipping_address->phone, $transaction->transaction_no, $transaction->grand_total);
          return \Redirect::route('PaymentProcess', array('transactions'=>md5($transaction->id), 'bank_code'=>$bank->bank_code));
        }


    }

    public function guestPlacedOrderMessage($phone, $transaction_no, $grand_total)
    {
        $destination = urlencode($phone);
        $message = "Hwajing: Thanks for purchasing on our website. \nYour order has been placed. \nOrder No: #".$transaction_no."\nRM ".$grand_total;
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
    }

    public function PaymentProcess($transaction, $bank_code)
    {
        $transactions = Transaction::where(DB::raw('md5(id)'), $transaction)->first();

        return view('frontend.payment_processing', ['transactions'=>$transactions, 'bank_code'=>$bank_code]);
    }

    public function TopupPaymentProcess($user_id, $amount)
    {
        return view('frontend.topup_payment_processing', ['user_id'=>$user_id, 'amount'=>$amount]);
    }

    public function UpgradeTopupPaymentProcess($user_id, $amount)
    {
        return view('frontend.upgrade_topup_payment_successfully', ['user_id'=>$user_id, 'amount'=>$amount]);
    }

    public function Payment_Error()
    {
        return view('frontend.payment_error');
    }

    public function payment_successfully(Request $request)
    {

        if($request->status == '1'){
            $select = Transaction::where('transaction_no', $request->refid)->first();
            $transaction = Transaction::where('transaction_no', $request->refid);
            $amount = $select->grand_total - $select->shipping_fee - $select->processing_fee;
            
            $SettingDualMain = SettingDualMain::find(1);

            if(!empty($SettingDualMain->comm_amount)){
              if($SettingDualMain->comm_type == '1'){
                  $dualComm = $amount * $SettingDualMain->comm_amount / 100;
              }else{
                  $dualComm = $SettingDualMain->comm_amount;
              }

              $dualaffs = AffiliateDual::where('affiliate_id', $select->user_id)
                                       ->where('user_id', '!=', 'AD000001')
                                       ->orderBy('id', 'asc')
                                       ->take(10)
                                       ->get();

              $b = 0;
              $insert_dual = [];
              foreach($dualaffs as $dualaff){
                  $uplineLvl = User::where('code', $dualaff->user_id)->first();
                  
                  
                  if(!empty($uplineLvl->id)){
                      $SettingDualCommission = SettingDualCommission::where('agent_lvl', $uplineLvl->lvl)->first();
                      if(!empty($SettingDualCommission->comm_amount)){
                          if($SettingDualCommission->comm_type == '1'){
                              $b = $dualComm * $SettingDualCommission->comm_amount / 100;
                              $bt = 'Percentage';
                          }else{
                              $b = $SettingDualCommission->comm_amount;
                              $bt = 'Amount';
                          }
                          if($b > 0){
                            $insert_dual[] = [
                                                "user_id"=>$dualaff->user_id,
                                                "type"=>"3",
                                                "transaction_no"=>$select->transaction_no,
                                                "comm_pa_type"=>$bt,
                                                "comm_pa"=>$SettingDualCommission->comm_amount,
                                                "comm_amount"=>$b,
                                                "comm_desc"=>"Dual Affiliate Commission: From Transaction #".$select->transaction_no.". Purchased By ".$select->user_id,
                                             ];                            
                          }
                      }
                  }
              }
              AffiliateCommission::insert($insert_dual);
            }


            $affs = Affiliate::where('affiliate_id', $select->user_id)
                                     ->where('user_id', '!=', 'AD000001')
                             ->orderBy('id', 'asc')
                             ->take(3)
                             ->get();
            $a=0;
            $insert = [];
            foreach($affs as $aff){
              $a++;
              $uplineLvl = User::where('code', $aff->user_id)->first();
              
              if(!empty($uplineLvl->id)){
                $mrb = SettingMerchantCommission::where('agent_lvl', $uplineLvl->lvl)->where('level', $a)->first();
                
                if(!empty($mrb->id)){

                    $comm_pa_type = $mrb->comm_type;
                    $comm_pa = $mrb->comm_amount;

                    if(!empty($comm_pa)){
                        if($comm_pa_type == 'Percentage'){
                            $comm_amount = $amount * $comm_pa / 100;
                        }else{
                            $comm_amount = $comm_pa;
                        }
                    }else{
                        $comm_amount = 0;
                    }

                    if($comm_amount > 0){
                        $insert[] = [
                            "type"=>'3',
                            "user_id"=>$aff->user_id,
                            "transaction_no"=>$select->transaction_no,
                            "comm_pa_type"=>$comm_pa_type,
                            "comm_pa"=>$comm_pa,
                            "comm_amount"=>$comm_amount,
                            "comm_desc"=>"Affiliate Commission: From Transaction #".$select->transaction_no.". Purchased By ".$select->user_id
                        ];                            
                    }
                }
              }
            }
            AffiliateCommission::insert($insert);


            $transaction = $transaction->update(['status'=>'1']);
            
            $this->AgentUpgrade($select->user_id);
        }
    }

    public function topup_payment_successfully(Request $request)
    {
        if($request->status == '1'){
            $agent = Merchant::where('code', $request->customer)->first();


            if(!empty($agent->id)){
                $input_topup = [];
                $input_topup['topup_no'] = $this->GenerateTopupNo();
                $input_topup['user_id'] = $agent->code;
                $input_topup['amount'] = $request->amount;
                $input_topup['actual_amount'] = $pcs->topup_amount;
                $input_topup['amount_desc'] = "RM ".$pcs->topup_amount.$profit_display;
                $input_topup['package_id'] = $pcs->id;
                $input_topup['topup_payment_method'] = '1';
                if($agent->status == '99'){
                  $input_topup['new_agent'] = '1';              
                  $input_topup['topup_type'] = '2';
                }else{
                  $input_topup['topup_type'] = '1';
                }
                $input_topup['status'] = '1';

                $createTopup = TopupTransaction::create($input_topup);
            }
        }
    }

    public function upgrade_topup_payment_successfully(Request $request)
    {
        if($request->status == '1'){
            $user = User::where('code', $request->customer)->first();
            if(!empty($user->id)){
              $removeUser = User::find($user->id)->update(['email'=>$user->email.'-upgraded',
                                                           'phone'=>$user->phone.'-upgraded',
                                                           'status'=>'3']);

              $input_customer = [];
              $input_customer['master_id'] = $user->master_id;
              $input_customer['code'] = $this->MerchantCode();
              $input_customer['country_code'] = $user->country_code;
              $input_customer['email'] = $user->email;
              $input_customer['password'] = $user->password;
              $input_customer['f_name'] = $user->f_name;
              $input_customer['l_name'] = $user->l_name;
              $input_customer['gender'] = $user->gender;
              $input_customer['dob'] = $user->dob;
              $input_customer['phone'] = $user->phone;
              $input_customer['point'] = $user->point;
              $input_customer['profile_logo'] = $user->profile_logo;
              $input_customer['status'] = $user->status;
              $upgrade = Merchant::create($input_customer);

              $upgrade_topup = SettingAffiliateTopup::where('topup_amount')->first();
              $profit_bonus = 0;
              if(!empty($upgrade_topup->profit_amount)){
                if($upgrade_topup->profit_type == 'Percentage'){
                  $profit_bonus = $upgrade_topup->topup_amount * $upgrade_topup->profit_amount / 100;
                }else{
                  $profit_bonus = $upgrade_topup->profit_amount;
                }
              }

              $profit_display = "";

              if($profit_bonus > 0){
                  $profit_display = " + (RM ".$profit_bonus.")";
              }

              $input_topup = [];

              $input_topup['topup_payment_method'] = 1;
              $input_topup['topup_no'] = $this->GenerateTopupNo();
              $input_topup['user_id'] = $upgrade->code;
              $input_topup['amount'] = $upgrade_topup->topup_amount + $profit_bonus;
              $input_topup['actual_amount'] = $upgrade_topup->topup_amount;
              $input_topup['amount_desc'] = "RM ".$upgrade_topup->topup_amount.$profit_display;
              $input_topup['package_id'] = $upgrade_topup->id;
              $input_topup['created_by'] = $upgrade->code;
              $input_topup['topup_type'] = 2;
              $input_topup['status'] = 1;
              $input_topup['upgrade_agent'] = 1;

              $createTopup = TopupTransaction::create($input_topup);

              if($upgrade->master_id == 'AD000001'){
                $affiliate = Affiliate::create(['affiliate_id' => $upgrade->code,
                                                'user_id' => 'AD000001',
                                                'sort_level' => '1']);
              }else{
                  //downline
                  $create = Affiliate::create(['affiliate_id'=>$upgrade->code,
                                               'user_id'=>$upgrade->master_id,
                                               'sort_level' => '1']);

                  $getAff = Affiliate::where('affiliate_id', $upgrade->master_id)->orderBy('id', 'asc')->get();
                  $affiliate = [];
                  $sort_level = 2;
                  foreach($getAff as $aff){

                      $affiliate[] = [
                                      'affiliate_id' => $upgrade->code,
                                      'user_id' => $aff->user_id,
                                      'sort_level' => $sort_level++,
                                      'status' => '1',
                                      'created_at' => date('Y-m-d H:i:s'),
                                      'updated_at' => date('Y-m-d H:i:s'),
                                     ];
                  }
                  $insert = Affiliate::insert($affiliate);                  
              }

              $cart = Cart::where('user_id', $user->code)->update(['user_id'=>$upgrade->code]);
              $transaction = Transaction::where('user_id', $user->code)->update(['user_id'=>$upgrade->code]);
              $address = UserShippingAddress::where('user_id', $user->code)->update(['user_id'=>$upgrade->code]);
              $favourite = Favourite::where('user_id', $user->code)->update(['user_id'=>$upgrade->code]);
              $bank_acc = BankAccount::where('user_id', $user->code)->update(['user_id'=>$upgrade->code]);
              $withdrawal = WithdrawalTransaction::where('user_id', $user->code)->update(['user_id'=>$upgrade->code]);
              $topup = TopupTransaction::where('user_id', $user->code)->update(['user_id'=>$upgrade->code]);

            }
        }
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

    public function GetGenerationCommision($level, $agent_lvl)
    {
        $comm = SettingMerchantCommission::where('level', $level)
                                         ->where('agent_lvl', $agent_lvl)
                                         ->first();
        if(!empty($comm->comm_amount)){
            return array($comm->comm_type, $comm->comm_amount);          
        }else{
          return array(0, 0);
        }
        
    }

    public function mall()
    {
        $leftJoin = DB::raw("(SELECT * FROM product_images ORDER BY created_at ASC) AS i");
        $products = Product::select('products.*', 'i.image', 'c.category_name', 'b.brand_name')
                                                   ->join('categories AS c', 'c.id', 'products.category_id')
                                                   ->leftJoin('brands AS b', 'b.id', 'products.brand_id')
                                                   ->leftJoin($leftJoin, function($join) {
                                                      $join->on('products.id', '=', 'i.product_id');
                                                   })
                                                   ->where('mall', '1')
                                                   ->groupBy('products.id')
                                                   ->orderBy('created_at', 'desc');
        $queries = [];
        $columns = [
           'result', 'brand', 'category', 'from', 'to'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                
                if($column == 'category'){
                  $products = $products->where('c.category_name', request($column));
                }elseif($column == 'brand'){
                  $products = $products->where('b.brand_name', request($column));
                }elseif($column == 'from' || $column == 'to'){
                  if(Auth::guard('merchant')->check()){
                      if(!empty(request('from')) && empty(request('to'))){
                          $products = $products->where(DB::raw('COALESCE(agent_special_price, agent_price)'), '>=', request('from'));
                      }elseif(empty(request('from')) && !empty(request('to'))){
                          $products = $products->where(DB::raw('COALESCE(agent_special_price, agent_price)'), '<=', request('to'));
                      }else{
                          $products = $products->where(DB::raw('COALESCE(agent_special_price, agent_price)'), '>=', request('from'))
                                               ->where(DB::raw('COALESCE(agent_special_price, agent_price)'), '<=', request('to'));
                      }
                  }else{
                      if(!empty(request('from')) && empty(request('to'))){
                          $products = $products->where(DB::raw('COALESCE(special_price, price)'), '>=', (int)request('from'));
                      }elseif(empty(request('from')) && !empty(request('to'))){
                          $products = $products->where(DB::raw('COALESCE(special_price, price)'), '<=', (int)request('to'));
                      }else{
                          $products = $products->where(DB::raw('COALESCE(special_price, price)'), '>=', (int)request('from'))
                                               ->where(DB::raw('COALESCE(special_price, price)'), '<=', (int)request('to'));
                      }                    
                  }

                }else{
                  // $products = $products->WhereRaw("MATCH(products.product_name) AGAINST('".request($column)."*' IN BOOLEAN MODE)")
                  //                      ->orWhereRaw("MATCH(b.brand_name) AGAINST('".request($column)."*' IN BOOLEAN MODE)")
                  //                      ->orWhereRaw("MATCH(c.category_name) AGAINST('".request($column)."*' IN BOOLEAN MODE)");
                  $products = $products->where('products.product_name', 'like', '%'.request($column).'%');
                }
                
                $queries[$column] = request($column);

            }
        }

        


        $products = $products->paginate(10)->appends($queries);
        

        // $categories = [];
        // $brands = [];
        // foreach($products as $product){
        //   $categories[] = $product->category_name;
        //   $brands[] = $product->brand_name;
        // }

        $categories = Category::where('status', '1')->get();
        $brands = Brand::where('status', '1')->get();

        return view('frontend.mall', ['products'=>$products, 'categories'=>$categories, 'brands'=>$brands]);
    }

    public static function BalanceQuantity($id)
    {
        $stockBalance = Stock::select(DB::raw('SUM(IF(type = "Increase", quantity, NULL)) AS totalStockIn'),
                                      DB::raw('SUM(IF(type = "Decrease", quantity, NULL)) AS totalStockOut'))
                                ->where('product_id', $id)
                                ->first();

        $cart = Cart::select(DB::raw('SUM(qty) AS InCart'))
                    ->where('status', '1')
                    ->where('product_id', $id);
                    

        if(Auth::check()){
          $cart = $cart->where('user_id', '<>', Auth::user()->code);
        }

        $cart = $cart->first();

        $transaction = TransactionDetail::select(DB::raw('SUM(quantity) AS TransCart'))
                                        ->join('transactions AS t', 't.id', 'transaction_details.transaction_id')
                                        ->whereIn('t.status', ['1', '98', '99', '97'])
                                        ->where('product_id', $id)
                                        ->first();


        return $stockBalance->totalStockIn - $stockBalance->totalStockOut - $cart->InCart - $transaction->TransCart;
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

    public static function getState($id)
    {
        $state = State::find($id);
        return $state->name;
    }

    public static function GenerateWithdrawalTransactionNo()
    {
      $transaction = WithdrawalTransaction::select(DB::raw('COUNT(id) AS TotalTransaction'))
                                          ->first();
      $TotalTransaction = $transaction->TotalTransaction + 1;

      if(strlen($TotalTransaction) == 1){
          $wtNo = 'W'.strtotime(date('Y-m-d H:i:s'))."0000".$TotalTransaction;
      }elseif(strlen($TotalTransaction) == 2){
          $wtNo = 'W'.strtotime(date('Y-m-d H:i:s'))."000".$TotalTransaction;
      }elseif(strlen($TotalTransaction) == 3){
          $wtNo = 'W'.strtotime(date('Y-m-d H:i:s'))."00".$TotalTransaction;
      }elseif(strlen($TotalTransaction) == 4){
          $wtNo = 'W'.strtotime(date('Y-m-d H:i:s'))."0".$TotalTransaction;
      }else{
          $wtNo = 'W'.strtotime(date('Y-m-d H:i:s')).$TotalTransaction;
      }
      return $wtNo;
    }

    public function countPending()
    {
      $transactions = Transaction::where('status', '99')->where('user_id', Auth::user()->code)->get();

      return count($transactions);
    }


    public function countToShip()
    {
      $transaction2 = Transaction::where('user_id', Auth::user()->code)
                                  ->whereIn('status', ['98', '1'])
                                  ->whereNull('tracking_no')
                                  ->whereNull('to_receive')
                                  ->orderBy('created_at', 'desc')
                                  ->get();

      $transactions = Transaction::whereIn('status', ['98', '1'])->where('user_id', Auth::user()->code)->get();

      $details = [];
      $ship_details = [];
      $CountTotal=0;

      foreach($transactions as $transaction){
        if(!empty($transaction->order_number)){
           $details[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();

           $domain = "http://connect.easyparcel.my/?ac=";

           $action = "EPParcelStatusBulk";
           $postparam = array(
           'api'   => 'EP-58MhvS6xe',
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
            
            foreach($json->result as $value){
                foreach($value->parcel as $value2){
                    $ship_details[$transaction->id] = $value2->ship_status;
                    if($ship_details[$transaction->id] == 'Schedule In Arrangement' || 
                       $ship_details[$transaction->id] == 'Pending for Drop Off'){
                      $CountTotal++;
                    }
                }
            }
         }
      }

      $total = count($transaction2) + $CountTotal;
      return $total;
    }

    public function countToReceive()
    {
      $transactions = Transaction::where('status', '1')
                                 ->whereNull('completed')
                                 ->where('user_id', Auth::user()->code)
                                 ->get();


      $transactions2 = Transaction::where('status', '1')
                                 ->where('to_receive', '1')
                                 ->whereNull('completed')
                                 ->where('user_id', Auth::user()->code)
                                 ->get();

      $details = [];
      $ship_details = [];
      $CountTotal=0;
      foreach($transactions as $transaction){
         $details[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();

         $domain = "http://connect.easyparcel.my/?ac=";

         $action = "EPParcelStatusBulk";
         $postparam = array(
         'api'   => 'EP-58MhvS6xe',
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
          
          foreach($json->result as $value){
              foreach($value->parcel as $value2){
                  $ship_details[$transaction->id] = $value2->ship_status;
                  if($ship_details[$transaction->id] == 'Pending For Collection' || $ship_details[$transaction->id] == 'Collected' || $ship_details[$transaction->id] == 'Delivering(in transit)' || 
                    $ship_details[$transaction->id] == 'Parcel Drop Off at Point'){
                      $CountTotal++;
                  }
              }
          }
      }

      return $CountTotal + count($transactions2);
    }

    public function countCompleted()
    {
      $transactions = Transaction::where('user_id', Auth::user()->code)
                                 ->where('status', '1')
                                 ->get();

      $transactions2 = Transaction::where('user_id', Auth::user()->code)
                                 ->where('status', '1')
                                 ->Where('to_receive', '1')
                                 ->Where('completed', '1')
                                 ->get();

      $CountTotal = 0;
      foreach($transactions as $transaction){
         $details[$transaction->id] = TransactionDetail::where('transaction_id', $transaction->id)->get();

         $domain = "http://connect.easyparcel.my/?ac=";

         $action = "EPParcelStatusBulk";
         $postparam = array(
         'api'   => 'EP-58MhvS6xe',
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
          
          foreach($json->result as $value){
              foreach($value->parcel as $value2){
                  $ship_details[$transaction->id] = $value2->ship_status;

                  if($ship_details[$transaction->id] == 'Successfully Delivered'){
                    $CountTotal++;

                  }
              }
          }
      }

      return $CountTotal + count($transactions2);
    }

    public function countCancelled()
    {
      $transactions = Transaction::where('status', '95')->where('user_id', Auth::user()->code)->get();

      return count($transactions);
    }

    public function VerifyAccount($user_id)
    {
        $update = User::where(DB::raw('md5(code)'), $user_id)->first();
        if($update->status != 1){
          $this->WelcomeMessage($update->email, 'noreply@vesson.my', '', 'WELCOME TO WESHARE2YOU!', $update);

          $upline = Merchant::where('code', $update->master_id)->first();
          if(!empty($upline->id)){
            $this->NewDownlineMessage($upline->email, 'noreply@vesson.my', $upline->f_name, 'New Downline', $update);
          }

          $update = $update->update(['status' => '1']);
          return redirect()->route('verify_success');
        }else{
          return redirect()->route('home');
        }

    }


    public function verify_success()
    {
      return view('frontend.verify_success');   
    }

    public function WelcomeMessage($to, $from, $name, $subject, $user)
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
        $body .= "<tr><td>Congratulations！You have successfully registered as a member of WeShare2you.</td></tr>
                  <tr><td>恭喜您！您已成功注册成为WeShare2you会员.</td></tr>";
        $body .= "<tr><td>Kindly use the new login details to access the new BACKOFFICE via ".route('home')."</td></tr>";
        $body .= "<tr><td>Login : Member Area | ".route('login')."</td></tr>";
        $body .= "<tr><td>Kindly login using the information below :</td></tr>";
        $body .= "<tr><td>USER ID: ".$user->email."</td></tr>";
        $body .= "<tr><td>Dealer ID: ".$user->code."</td></tr>";
        $body .= "<tr><td>Email : ".$user->email."</td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td>Regards,</td></tr>";
        $body .= "<tr><td>WeShare2you</td></tr>";
        $body .= "<tr><td></td></tr>";
        // $body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
        $body .= "</tbody></table>";
        $body .= "</body></html>";

        
    }

    public function NewDownlineMessage($to, $from, $name, $subject, $user)
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
                      <strong>Dear ".$name."</strong>
                    </td>
                  </tr>";
        $body .= "<tr><td>Congratulations！There is a new member added to your team！</td></tr>
                  <tr><td>恭喜您的团队又增加了一位新成员!</td></tr>";
        $body .= "<tr><td>New member information below :</td></tr>";
        $body .= "<tr><td>USER ID: ".$user->email."</td></tr>";
        $body .= "<tr><td>Dealer ID: ".$user->code."</td></tr>";
        $body .= "<tr><td>Contact: ".$user->phone."</td></tr>";
        $body .= "<tr><td>Email : ".$user->email."</td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td></td></tr>";
        $body .= "<tr><td>Regards,</td></tr>";
        $body .= "<tr><td>WeShare2you</td></tr>";
        $body .= "<tr><td></td></tr>";
        // $body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
        $body .= "</tbody></table>";
        $body .= "</body></html>";

        
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

    public function submit_topup(Request $request)
    {
      $topupPackage = SettingTopup::find($request->topup_packages);
      if(empty($topupPackage->id)){
          Toastr::success("Topup Error");
          return redirect()->route('wallet');
      }
      $GetCashWalletBalance = $this->GetCashWalletBalance();

      if($request->selected_payment_method == '4' && $GetCashWalletBalance < $topupPackage->topup_amount){
          Toastr::error('Insufficient Balance');
          
          return redirect()->route('wallet');
      }

      $profit_bonus = 0;
      if(!empty($topupPackage->profit_amount)){
        if($topupPackage->profit_type == 'Percentage'){
          $profit_bonus = $topupPackage->topup_amount * $topupPackage->profit_amount / 100;
        }else{
          $profit_bonus = $topupPackage->profit_amount;
        }
      }

      $profit_display = "";

      if($profit_bonus > 0){
          $profit_display = " + (RM ".$profit_bonus.")";
      }

      $setting_charges = SettingCharge::find(1);

      $input_topup = [];
      if($request->selected_payment_method == '2' || $request->selected_payment_method == '4'){
          if($request->selected_payment_method == '2'){
            $files = $request->file('bank_slip'); 
            $name = $files->getClientOriginalName();
            $exp = explode(".", $name);
            $file_ext = end($exp);
            $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
            $files->move("uploads/bank_slip/".Auth::guard('merchant')->user()->code."/", $name);
          }
          $charges = 0;
          $charges_type = "";
          $charges_amount = "";

          if($request->selected_payment_method == '2'){
            $input_topup['topup_payment_method'] = $request->selected_payment_method;
          }else{
            if(!empty($setting_charges->id) && !empty($setting_charges->transfer_wallet_charges_amount)){
                if($setting_charges->transfer_wallet_charges_type == 'Percentage'){
                    $charges = $topupPackage->topup_amount * $setting_charges->transfer_wallet_charges_amount / 100;
                }else{
                    $charges = $topupPackage->topup_amount - $setting_charges->transfer_wallet_charges_amount;
                }
                $charges_type = $setting_charges->transfer_wallet_charges_type;
                $charges_amount = $setting_charges->transfer_wallet_charges_amount;
            }
            $input_topup['topup_payment_method'] = 4;
            $input_topup['charges_type'] = $charges_type;
            $input_topup['charges_amount'] = $charges_amount;
          }
          $input_topup['topup_no'] = $this->GenerateTopupNo();
          $input_topup['user_id'] = Auth::guard('merchant')->user()->code;
          $input_topup['amount'] = $topupPackage->topup_amount + $profit_bonus - $charges;
          $input_topup['actual_amount'] = $topupPackage->topup_amount;
          $input_topup['amount_desc'] = "RM ".$topupPackage->topup_amount.$profit_display;
          $input_topup['package_id'] = $topupPackage->id;

          $input_topup['topup_type'] = '1';
          $input_topup['created_by'] = Auth::guard('merchant')->user()->code;
          if($request->selected_payment_method == '2'){
              $input_topup['bank_slip'] = "uploads/bank_slip/".Auth::guard('merchant')->user()->code."/".$name;
              $input_topup['status'] = "99";
          }else{
              $input_topup['status'] = "1";
          }
          $createTopup = TopupTransaction::create($input_topup);

          Toastr::success("Topup submitted! Please wait Admin for Verify");
          return redirect()->route('wallet');

      }else{
          return \Redirect::route('TopupPaymentProcess', array('user_id'=>Auth::guard('merchant')->user()->code, 'amount'=>$request->topup_amount));
      }
    }

    public function logistic_tracking($transaction_no)
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

        return view('frontend.logistic_tracking_details', ['transaction'=>$transaction, 'results'=>$json]);
    }

     public function add_new_address(Request $request)
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
        
        $validator = Validator::make($request->all(), [
            'f_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postcode' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }
        
        $input = $request->all();
        $input['default'] = 1;
        $input['user_id'] = $buyerCode;

        $create = UserShippingAddress::create($input);

        return redirect()->back();
    }

    public function sendEmailNotification($to, $from, $name, $subject, $transaction_no)
    {
      $transaction = Transaction::where('transaction_no', $transaction_no)->first();
      $details = TransactionDetail::where('transaction_id', $transaction->id)->get();

      $headers = "From: $from";
      $headers = "From: " . $from . "\r\n";
      $headers .= "Reply-To: ". $from . "\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8";
      $headers .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';

      // $subject = "Testing.";


      $link = 'www.zstore.com';

      $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
      $body .= "<table style='width: 100%;'>";
      $body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";

      $body .= "</td></tr></thead><tbody><tr>";
      $body .= "<td style='border:none;'><strong>Thank you for your order!</strong></td></tr>";
      $body .= "<tr>
                  <td style='border:none;'>
                    <strong>Order Confirmation</strong>
                  </td>
                </tr>";
      $body .= "<tr><td></td></tr>
                <tr><td></td></tr>
                <tr>
                  <td>
                    <td colspan='2'>Product Details</td>
                    <td>Unit Price</td>
                    <td>Quantity</td>
                  </td>
                </tr>";
      foreach($details as $detail){
      $sub_category = (!empty($detail->sub_category)) ? '<br> Variation: '.$detail->sub_category : '';
      $body .= "<tr>
                  <td><img src='".url($detail->product_image)."' width='100px'></td>
                  <td>".$detail->product_name.$sub_category."</td>
                  <td>".$detail->unit_price."</td>
                  <td>x".$detail->quantity."</td>
                </tr>";  
      }
      $body .= "<tr><td></td></tr>";
      $body .= "<tr><td></td></tr>";
      $body .= "<tr><td>Regards,</td></tr>";
      $body .= "<tr><td>WeShare2you</td></tr>";
      $body .= "<tr><td></td></tr>";
      // $body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
      $body .= "</tbody></table>";
      $body .= "</body></html>";

     
    }

    public function WalletRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => ['required'],
            'phone' => ['required', 'unique:users', 'unique:merchants'],
            'f_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:merchants'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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

        $ownRegisterWalletBalance = $this->getTotalRegisterWallet();

        $topup_amount = 0;
        if(!empty($request->topup_packages)){
          $selectTPKG = SettingAffiliateTopup::find($request->topup_packages);

          $topup_amount = $selectTPKG->topup_amount;
        }

        if(floatval($ownRegisterWalletBalance) < floatval($topup_amount)){
            Toastr::error('Insufficient register balance to register');
            return redirect()->back();
        }

        if(!empty($request->master_id)){
            $master_id = $request->master_id;
        }else{
            $master_id = Auth::user()->code;
        }

        $input = $request->all();
        $input['master_id'] = $master_id;
        $input['code'] = $this->MerchantCode();
        $input['country_code'] = $request->country_code;
        $input['phone'] = preg_replace("/^\+?{$request->country_code}/", '', $request->phone);
        $input['f_name'] = $request->f_name;
        $input['email'] = $request->email;
        $input['password'] = Hash::make($request->f_name);

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

        if(!empty($selectTPKG->id)){
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
            $input_topup['topup_payment_method'] = '3';
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

        Toastr::success('Register Successfully');
        return redirect()->route('wallet');
    }

    public function MerchantCode()
    {
        $user = Merchant::select(DB::raw("COUNT(id) AS totalUser"))->first();
        $totalCount = $user->totalUser + 1;

        if(strlen($totalCount) == '1'){
            $member_id = "M00000".$totalCount;
        }elseif(strlen($totalCount) == '2'){
            $member_id = "M0000".$totalCount;
        }elseif(strlen($totalCount) == '3'){
            $member_id = "M000".$totalCount;
        }elseif(strlen($totalCount) == '4'){
            $member_id = "M00".$totalCount;
        }elseif(strlen($totalCount) == '5'){
            $member_id = "M0".$totalCount;
        }else{
            $member_id = "M".$totalCount;
        }

        return $member_id;
    }

    public function upgrade_agent_form(Request $request)
    {
      $topupPackage = SettingAffiliateTopup::find($request->selected_packages);
      if(empty($topupPackage->id)){
          Toastr::success("Topup Error");
          return redirect()->route('wallet');
      }

      $profit_bonus = 0;
      if(!empty($topupPackage->profit_amount)){
        if($topupPackage->profit_type == 'Percentage'){
          $profit_bonus = $topupPackage->topup_amount * $topupPackage->profit_amount / 100;
        }else{
          $profit_bonus = $topupPackage->profit_amount;
        }
      }

      $profit_display = "";

      if($profit_bonus > 0){
          $profit_display = " + (RM ".$profit_bonus.")";
      }

      $input_topup = [];
      if($request->selected_payment_method == '2'){
          $files = $request->file('bank_slip'); 
          $name = $files->getClientOriginalName();
          $exp = explode(".", $name);
          $file_ext = end($exp);
          $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
          $files->move("uploads/bank_slip/", $name);
          
          $input_topup['topup_payment_method'] = $request->selected_payment_method;
          $input_topup['topup_no'] = $this->GenerateTopupNo();
          $input_topup['user_id'] = Auth::user()->code;
          $input_topup['amount'] = $topupPackage->topup_amount + $profit_bonus;
          $input_topup['actual_amount'] = $topupPackage->topup_amount;
          $input_topup['amount_desc'] = "RM ".$topupPackage->topup_amount.$profit_display;
          $input_topup['package_id'] = $topupPackage->id;
          $input_topup['bank_slip'] = "uploads/bank_slip/".$name;
          $input_topup['status'] = "99";
          $input_topup['topup_type'] = '2';
          $input_topup['upgrade_agent'] = '1';
          $input_topup['created_by'] =  Auth::user()->code;

          $createTopup = TopupTransaction::create($input_topup);

          Toastr::success("Topup submitted! Please wait Admin for Verify. Your account will upgrade to agent once approve by admin");
          return redirect()->route('home');

      }else{
          return \Redirect::route('UpgradeTopupPaymentProcess', array('user_id'=>Auth::user()->code, 
                                                               'amount'=>$topupPackage->topup_amount));
      }
    }

    public function getProductSold($product_id)
    {
        $transaction = Transaction::select('transactions.*')
                                  ->join('transaction_details as d', 'd.transaction_id', 'transactions.id')
                                  ->where('transactions.status', '1')
                                  ->where('d.product_id', $product_id)
                                  ->get();

        return count($transaction);
    }

    public function getDownlineTotalGroupTopup($user_id, $start, $end)
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
                                           ->whereIn('user_id', $myGroup);
        if(!empty($start) && !empty($end)){
        $myGroupTopup = $myGroupTopup->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), array($start, $end));
        }
        $myGroupTopup = $myGroupTopup->first();

        $myTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalAmount'))
                                           ->where('status', '1')
                                           ->where('user_id', $user_id);
        if(!empty($start) && !empty($end)){
        $myTopup = $myTopup->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), array($start, $end));
        }
        $myTopup = $myTopup->first();

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
                                  ->whereNull('deduct_wallet');
        if(!empty($start) && !empty($end)){
        $DownMemTran = $DownMemTran->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), array($start, $end));
        }
        $DownMemTran = $DownMemTran->first();

        $myMemTran = Transaction::select(DB::raw('SUM(grand_total - processing_fee - shipping_fee) as totalPurchase'))
                                  ->whereIn('user_id', $myDownlineMem)
                                  ->where('status', '1')
                                  ->whereNull('deduct_wallet');
        if(!empty($start) && !empty($end)){
        $myMemTran = $myMemTran->whereBetween(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), array($start, $end));
        }
        $myMemTran = $myMemTran->first();

        $myGroupTotal = $myTopup->totalAmount + $myGroupTopup->totalAmount + $DownMemTran->totalPurchase + $myMemTran->totalPurchase;
        return $myGroupTotal;
    }

    public function getOwnSales($user_id)
    {
        $myTopup = TopupTransaction::select(DB::raw('SUM(actual_amount) as totalAmount'))
                                           ->where('status', '1')
                                           ->where('user_id', $user_id)
                                           ->first();

        $mydownlineMems = User::where('master_id', $user_id)->get();

        $myDownlineMem = [];
        foreach($mydownlineMems as $mydownlineMem){
            $myDownlineMem[] = $mydownlineMem->code;
        }

        $myMemTran = Transaction::select(DB::raw('SUM(grand_total - processing_fee - shipping_fee) as totalPurchase'))
                                  ->whereIn('user_id', $myDownlineMem)
                                  ->where('status', '1')
                                  ->whereNull('deduct_wallet')
                                  ->first();

        $myTotal = $myTopup->totalAmount + $myMemTran->totalPurchase;
        return $myTotal;
    }
}
