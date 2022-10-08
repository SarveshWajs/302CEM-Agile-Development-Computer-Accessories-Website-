<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductImage;
use App\SettingRefferalReward;
use App\Cart;
use App\Merchant;
use App\Admin;
use App\Affiliate;
use App\AgentLevel;
use App\SettingMerchantBonus;
use App\AgentRebateHistory;
use App\AffiliateCommission;
use App\Permission;
use App\Transaction;
use App\WithdrawalTransaction;
use App\Category;
use App\Brand;
use App\Product;
use App\Promotion;
use App\SettingMerchantCommission;
use App\SettingMerchantRebate;
use App\CategoryImage;
use App\TransactionDetail;
use App\User;
use App\SettingBanner;
use App\SubCategory;
use App\SettingDualMain;
use App\SettingDualCommission;
use App\AffiliateDual;
use App\TopupTransaction;
use App\Blog;
use App\SettingShippingFee;
use App\SettingPickUpAddress;


use Validator, Redirect, Toastr, DB, File, Auth, Mail;

class AjaxController extends Controller
{
    public function uploadImage(Request $request, $id)
    {	

        $files = $request->file('file'); 
        $name = $files->getClientOriginalName();
        $exp = explode(".", $name);
        $file_ext = end($exp);
        $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
        
        $input = $request->all();
        if($id == 0){
          $input['product_id'] = $id;
          $input['status'] = '99';
          $input['image'] = "uploads/".$name;

          $files->move("uploads/", $name);
        }else{
          $input['product_id'] = $id; 
          $input['status'] = '1';
          $input['image'] = "uploads/".$id."/".$name;

          $files->move("uploads/".$id."/", $name);
        }
        $product_image = ProductImage::create($input);
      
        
    if($id == 0){
      $select = ProductImage::where('status', '99')->get();
    }else{
      $select = ProductImage::where('status', '1')
                   ->where('product_id', $id)
                   ->get();
    }
        // return 123;

		$image_list = "";
		if (!$select->isEmpty()) { 
			foreach($select as $key => $value){

        $exp = explode(".", $value->image);
        $file_ext = end($exp);

				$image_list .= '<div class="product-image-thumbnail" data-id="'.$value->id.'">
        									<div class="form-group" style="width: 100%;">
        										<div class="delete-image-box">
        											<a href="#" class="delete-image" data-id="'.$value->id.'">
        												<i class="fa fa-trash"></i>
        											</a>
        										</div>';
        if($file_ext == 'mp4'){
          $image_list .= '<video id="myVideo" style="width: 100%;" >
                            <source src="'.url($value->image).'" type="video/mp4">
                          </video>';
        }else{
          $image_list .= '<div class="product-image-thumbnail-img" style="background-image: url('.url($value->image).')"></div>';
        }
        $image_list .= '</div>
        								</div>';
			}
		}

		return json_encode($image_list);
    }

    public function LoadImage($id)
    {
    	if($id == 0){
			$select = ProductImage::where('status', '99')->orderBy('sort_level', 'asc')->get();
		}else{
			$select = ProductImage::where('status', '1')
                            ->where('product_id', $id)
          								  ->orderBy('sort_level', 'asc')
          								  ->get();
		}

		$image_list = "";
		if (!$select->isEmpty()) {
			foreach($select as $key => $value){
        $exp = explode(".", $value->image);
        $file_ext = end($exp);

				$image_list .= '<div class="product-image-thumbnail" data-id="'.$value->id.'">
                          <div class="form-group" style="width: 100%;">
                            <div class="delete-image-box">
                              <a href="#" class="delete-image" data-id="'.$value->id.'">
                                <i class="fa fa-trash"></i>
                              </a>
                            </div>';
        if($file_ext == 'mp4'){
          $image_list .= '<video id="myVideo" style="width: 100%;" autoplay="autoplay" loop="1">
                            <source src="'.url($value->image).'" type="video/mp4">
                          </video>';
        }else{
          $image_list .= '<div class="product-image-thumbnail-img" style="background-image: url('.url($value->image).')"></div>';          
        }
        $image_list .= '</div>
                        </div>';
			}
		}

		return $image_list;
    }

    public function DeleteImage($id)
    {
    	$delete = ProductImage::find($id);
    	File::delete($delete->image);
    	$delete = $delete->delete();
    }

    public function SortImage(Request $request)
    {
        $images = ProductImage::find($request->mid);
        $images = $images->update(['sort_level'=>$request->number]);
    }

    public function uploadBannerImage(Request $request)
    {
        $files = $request->file('file'); 
        $name = $files->getClientOriginalName();
        $exp = explode(".", $name);
        $file_ext = end($exp);
        $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
          
        $input = $request->all();
          
        $input['status'] = '1';
        $input['image'] = "uploads/banner/".$name;

        $files->move("uploads/banner/", $name);
          
        $product_image = SettingBanner::create($input);
        
        
        $select = SettingBanner::where('status', '1')->get();
        

      $image_list = "";
      if (!$select->isEmpty()) { 
        foreach($select as $key => $value){
          $image_list .= '<div class="product-image-thumbnail">
                            <div class="form-group">
                              <div class="delete-image-box">
                                <a href="#" class="delete-image" data-id="'.$value->id.'">
                                  <i class="fa fa-trash"></i>
                                </a>
                              </div>
                              <div class="product-image-thumbnail-img" style="background-image: url('.url($value->image).')"></div>
                            </div>
                          </div>';
        }
      }

      return json_encode($image_list);
    }

    public function LoadBannerImage()
    {
      $select = SettingBanner::where('status', '1')->get();

    $image_list = "";
    if (!$select->isEmpty()) {
      foreach($select as $key => $value){
        $image_list .= '<div class="product-image-thumbnail">
                  <div class="form-group">
                    <div class="delete-image-box">
                      <a href="#" class="delete-image" data-id="'.$value->id.'">
                        <i class="fa fa-trash"></i>
                      </a>
                    </div>
                    <div class="product-image-thumbnail-img" style="background-image: url('.url($value->image).')"></div>
                  </div>
                </div>';
      }
    }

    return $image_list;
    }

    public function DeleteBannerImage($id)
    {
      $delete = SettingBanner::find($id);
      File::delete($delete->image);
      $delete = $delete->delete();
    }

    public function uploadCategoryImage(Request $request, $id)
    { 
        $image = $request->image;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = str_random(10).'.'.'png';
        
        $input = $request->all();
        if($id == 0){
          
          $input['status'] = '99';
          $input['image'] = "uploads/".$imageName;

          \File::put('uploads/'. '/' . $imageName, base64_decode($image));

          $cat_image = CategoryImage::create($input);
        }else{

          $input['status'] = '1';
          $input['image'] = "uploads/".$imageName;

          \File::put('uploads/' . $imageName, base64_decode($image));

          $category = CategoryImage::where('category_id', $id)->first();
          if(!empty($category)){
            $category = CategoryImage::where('category_id', $id)->update($input);
          }else{
            $input['category_id'] = $id;
            $cat_image = CategoryImage::create($input);
          }
        }

        // 
      
        
        if($id == 0){
          $select = CategoryImage::where('status', '99')->get();
        }else{
          $select = CategoryImage::where('status', '1')
                       ->where('category_id', $id)
                       ->get();
        }

        $image_list = "";
        if (!$select->isEmpty()) { 
          foreach($select as $key => $value){
            $image_list .= '<div class="product-image-thumbnail">
                              <div class="form-group">
                                <div class="delete-image-box">
                                  <a href="#" class="delete-image" data-id="'.$value->id.'">
                                    <i class="fa fa-trash"></i>
                                  </a>
                                </div>
                                <div class="product-image-thumbnail-img" style="background-image: url('.url($value->image).')"></div>
                              </div>
                            </div>';
          }
      }
      return $image_list;
    }


    public function LoadCategoryImage($id)
    {
      if($id == 0){
        $select = CategoryImage::where('status', '99')->get();
      }else{
        $select = CategoryImage::where('status', '1')
                     ->where('category_id', $id)
                     ->get();
      }


      $image_list = "";
      if (!$select->isEmpty()) {
        foreach($select as $key => $value){
          $image_list .= '<div class="product-image-thumbnail">
                    <div class="form-group">
                      
                      <div class="product-image-thumbnail-img" style="background-image: url('.url($value->image).')"></div>
                    </div>
                  </div>';
        }
      }
      return $image_list;
    }
    public function DeleteCategoryImage($id)
    {
      $delete = CategoryImage::find($id);
      File::delete($delete->image);
      $delete = $delete->delete();
    }

    public function change_withdrawal_transaction_action(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->action_id;

        $withdrawal = WithdrawalTransaction::find($request->tid);
        $withdrawal = $withdrawal->update($input);
    }

    public function ApproveRejectMerchant(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->action_id;
        $merchant = Merchant::find($request->mid);

        if($request->action_id == '98'){
            $merchant = $merchant->delete();
        }else{
            if(!empty($merchant->master_id)){
                $checkmAff = Merchant::where('code', $merchant->master_id)->first();
                $checkaAff = Admin::where('code', $merchant->master_id)->first();
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
            $merchant = $merchant->update(['status'=>'1']);
        }
    }

    public function ApproveRejectMember(Request $request)
    {
	      $input = $request->all();
        $input['status'] = $request->action_id;
        $user = User::find($request->mid);
      	
    		if($request->action_id == '98'){
          	$user = $user->delete();
      	}else{
          if($user->status != 1){
            $user = $user->update(['status'=>'1']);
          }
      	}
    }

    public function AgentUpgrade($user_id)
    {

        $merchant = Merchant::where('code', $user_id)->first();

        if(!empty($merchant->id)){
            $getTotalGroupTopup = $this->getTotalGroupTopup($user_id);

            $uplineAffs = Affiliate::select('affiliates.sort_level', 'affiliates.affiliate_id', 'affiliates.user_id')
                                     ->where('affiliate_id', $user_id)
                                     ->where('user_id', '!=', 'AD000001')
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


        $myGroupTotal = $myTopup->totalAmount + $myGroupTopup->totalAmount;

        $levels = AgentLevel::where('buy_quantity', '<=', $myGroupTotal)
                            ->orderBy('id', 'desc')
                            ->first();

        if(!empty($levels->id) && $merchant->lvl < $levels->id){
          $ownLevel = Merchant::where('code', $user_id);
          $ownLevel = $ownLevel->update(['lvl'=>$levels->id]);          
        }

        return $myGroupTotal;
    }

    public function SetPermission(Request $request)
    {
        $select = Permission::where('permission_lvl', $request->permission_lvl)
                            ->where('page', $request->page)
                            ->first();

        if(!empty($select->id)){
            $update = Permission::find($select->id);
            if($update->status == 1){

                // $update = $update->update(['status' => '0']);
            }else{
                $update = $update->update(['status' => '1']);
            }
        }else{
            $input = $request->all();
            $create = Permission::create($input);            
        }
        
    }

    public function UnsetPermission(Request $request)
    {
        $select = Permission::where('permission_lvl', $request->permission_lvl)
                            ->where('page', $request->page)
                            ->first();

        if(!empty($select->id)){
            $update = Permission::find($select->id);
            if($update->status == 1){
                $update = $update->update(['status' => '0']);
            }else{
                // $update = $update->update(['status' => '1']);
            }
        }else{
            $input = $request->all();
            $create = Permission::create($input);            
        }
        
    }

    public function GetPermission()
    {
        $selects = Permission::get();
        return $selects;
    }

    public function getItemCode(Request $request)
    {

        $category = Category::find($request->cid);
        if(empty($category->id)){
            return "null";
        }
        $pCount = Product::select(DB::raw('COUNT(id) AS TotalCount'))
                          ->where('category_id', $request->cid)
                          ->first();

        $product = Product::where('id', $request->pid)
                          ->where('category_id', $request->cid)
                          ->first();

        if(!empty($product->code)){
            return $category->code.$product->code;
        }else{
            $totalCount = $pCount->TotalCount+1;
        }

        if(strlen($totalCount) == 1){
            $code = $category->code."00".$totalCount;
        }elseif(strlen($totalCount) == 2){
            $code = $category->code."0".$totalCount;
        }else{
            $code = $category->code.$totalCount;
        }

        return $code;
    }

    public function getSubItemCode(Request $request)
    {

        $category = Category::find($request->cid);
        $sub_category = SubCategory::find($request->scid);
        if(empty($category->id)){
            return "null";
        }
        $pCount = Product::select(DB::raw('COUNT(id) AS TotalCount'))
                          ->where('category_id', $request->cid)
                          ->first();

        $product = Product::where('id', $request->pid)
                          ->where('category_id', $request->cid)
                          ->first();

        if(!empty($product->code)){
            return $category->code.$product->code;
        }else{
            $totalCount = $pCount->TotalCount+1;
        }

        if(strlen($totalCount) == 1){
            $code = $category->code.'-'.$sub_category->sub_category_code."00".$totalCount;
        }elseif(strlen($totalCount) == 2){
            $code = $category->code.'-'.$sub_category->sub_category_code."0".$totalCount;
        }else{
            $code = $category->code.'-'.$sub_category->sub_category_code.$totalCount;
        }

        return $code;
    }

    public function MerchantStatus(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->status;
        $table = Merchant::find($request->row_id);
        $table = $table->update($input);
    }

    public function BlogStatus(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->status;
        $table = Blog::find($request->row_id);
        $table = $table->update($input);
    }

    public function ProductStatus(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->status;
        $table = Product::find($request->row_id);
        $table = $table->update($input);
    }

    public function CategoryStatus(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->status;
        $table = Category::find($request->row_id);
        $table = $table->update($input);
    }

    public function SubCategoryStatus(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->status;
        $table = SubCategory::find($request->row_id);
        $table = $table->update($input);
    }

    public function BrandStatus(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->status;
        $table = Brand::find($request->row_id);
        $table = $table->update($input);
    }

    public function PromotionStatus(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->status;
        $table = Promotion::find($request->row_id);
        $table = $table->update($input);
    }


    public function change_transaction_action(Request $request)
    {

        $select = Transaction::find($request->tid);
        $input = $request->all();
        $input['status'] = $request->action_id;
        $transaction = Transaction::find($request->tid);
        
        $amount = $select->grand_total - $select->shipping_fee - $select->processing_fee;
        if($request->action_id == '12'){
          $transaction = $transaction->update(['to_receive'=>'1']);
        }

        if($request->action_id == '11'){
          $transaction = $transaction->update(['completed'=>'1']);
        }
        
        if($request->action_id == '1'){
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
        }
      if($request->action_id == '95'){
          $transaction = $transaction->update($input);
      }

      if($request->action_id == '96'){
          $transaction = $transaction->update($input);
      }
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

    public function setFeatured(Request $request)
    {
        $product = Product::find($request->id);
        
        if($product->featured == '1'){
          $product = $product->update(['featured'=>'0']);
        }else{
          $product = $product->update(['featured'=>'1']);
        }

    }

    public function CKEditorUploadImage(Request $request)
    {
        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $path = "";
            if($request->type == 1){
                $path = "Description";
            }elseif($request->type == 2){
                $path = "Hiring";
            }elseif($request->type == 3){
                $path = "Mission";
            }
            
            $request->file('upload')->move('uploads/Product_description/', $fileName);
   
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('uploads/Product_description/'.$fileName); 
            $msg = 'Image uploaded successfully'; 
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
               
            @header('Content-type: text/html; charset=utf-8'); 
            echo $response;
        }
    }

    public function getProducts(Request $request)
    {
        $product = Product::find($request->product_id);

        if(!empty($product->id)){
            return $product->price;
        }
    }

    public function GetSubCategory(Request $request)
    {
        $subs = SubCategory::where('category_id', $request->cid)->get();

        $select = '<select class="form-control sub_category_id" name="sub_category_id">';
        $select .= "<option>Select Subcategory</option>";
        foreach($subs as $sub){
        $select .= "<option value='".$sub->id."'>".$sub->sub_category_name."</option>";
        }
        $select .="</select>";

        return $select;
    }

    public function change_topup_action(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->action_id;
        $select = TopupTransaction::find($request->tid);

        $topup = TopupTransaction::find($request->tid);
        $topup = $topup->update($input);

        $this->cashRebate($select->user_id, $select->actual_amount);
        $this->AgentUpgrade($select->user_id);
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
                AffiliateCommission::create(['type'=>'8',
                                             'user_id'=>$affiliate->m_user_id,
                                             'product_amount'=>$totalAmount,
                                             'comm_pa_type'=>'Percentage',
                                             'comm_pa'=>$pay_comm,
                                             'comm_amount'=>($totalAmount * $pay_comm / 100),
                                             'comm_desc'=>'Cash Rebate From #'.$user_id]);
              }              
            }
        }
        // exit();

        //Extra 5%
        $merchant = Merchant::where('code', $user_id)->first();
        $upline = Merchant::where('code', $merchant->master_id)->first();

        if($merchant->lvl >= 4){
            if($upline->lvl == $merchant->lvl){
                AffiliateCommission::create(['type'=>'99',
                                             'user_id'=>$upline->code,
                                             'product_amount'=>$totalAmount,
                                             'comm_pa_type'=>'Percentage',
                                             'comm_pa'=>5,
                                             'comm_amount'=>($totalAmount * 5 / 100),
                                             'comm_desc'=>'Extra Cash Rebate From #'.$user_id,
                                             'status'=>'99']);
            }
        }
    }

    public function DeleteShipping(Request $request)
    {
        $delete = SettingShippingFee::find($request->sid)->delete();
    }

    public function courier_service_list(Request $request)
    {
        $transaction = Transaction::find($request->tid);

        $pickA = SettingPickUpAddress::where('status', '1')->first();

        if(empty($pickA->id)){
            return "pick up address error";
        }

        $country = 'MY';
        $pick_code = $pickA->postcode;
        $pick_state = $pickA->state;

        $send_code = $transaction->postcode;
        $send_state = $transaction->state;

        $weight = $transaction->weight;

        $domain = "http://connect.easyparcel.my/?ac=";

        $action = "EPRateCheckingBulk";
        $postparam = array(
        'api'   => 'EP-GwSDN6WXv',
        'bulk'  => array(
        array(
        'pick_code' => $pick_code,
        'pick_state'    => $pick_state,
        'pick_country'  => $country,
        'send_code' => $send_code,
        'send_state'    => $send_state,
        'send_country'  => $country,
        'weight'    => $weight,
        'width' => '0',
        'length'    => '0',
        'height'    => '0',
        'date_coll' => date('Y-m-d'),
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

        $displayRates = "<table class='table'>
                            <tr>
                                <td>Select</td>
                                <td colspan='2'>Courier Company & Shipping Fee</td>
                                <td>Scheduled parcel delivery</td>
                                <td>Delivery date</td>
                            </tr>";
        foreach($json->result as $value){
            if($value->status == 'Success'){
                foreach($value->rates as $key => $value2){
                    
                    $checked = ($key == 0) ? 'checked' : '';

                    $displayRates .= "<tr>
                                            <td>
                                                <input type='hidden' name='tid' value='".$request->tid."'>
                                                <input type='hidden' name='collect_date' value='".$value2->pickup_date."'>
                                                <input type='hidden' name='courier_logo' value='".$value2->courier_logo."'>
                                                <div class='radio'>
                                                    <label>
                                                        <input name='service_id' type='radio' class='ace' ".$checked." value='".$value2->service_id."' />
                                                        <span class='lbl'></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <img src='".$value2->courier_logo."' width='100px'>
                                            </td>
                                            <td>
                                                ".$value2->service_id." - ".$value2->courier_name."
                                                <br>
                                                RM ".$value2->price."
                                                <br>
                                                <span class='service_detail'>".$value2->service_detail."</span>";

                    $displayRates .=        "</td>
                                             <td>".$value2->scheduled_start_date."</td>
                                             <td>".$value2->pickup_date."</td>
                                      </tr>";
                    if(strpos($value2->service_detail, 'dropoff') !== false){
                        $displayRates .=        "<tr>
                                                    <td style='border-top: none;'></td>
                                                    <td colspan='4' style='border-top: none;'>
                                                        <div class='form-group'>
                                                        <select class='form-control' name='drop_off_point' style='width: 50%;'>
                                                            <option value=''>选择下车地点</option>";
                        foreach($value2->dropoff_point as $dp){
                        $displayRates .=        "<option value='".$dp->point_id.",".$dp->point_name.' '.$dp->point_addr1.' '.$dp->point_addr2.' '.$dp->point_addr3.' '.$dp->point_addr4.' '.$dp->point_postcode.' '.$dp->point_city.' '.$dp->point_state."'>
                                                ".$dp->point_name."</option>";                        
                        }
                        $displayRates .=        "</select>
                                                </div>";
                        $displayRates .=        "<div class='dropoff_details'>";
                        $displayRates .=        "</div>
                                                 </td>
                                                 </tr>";
                    }
                }
            }else{
                
                    $displayRates .= "<tr>
                                            <td align='center' colspan='5'>
                                                ".$value->remarks."
                                            </td>
                                      </tr>";
            }
        }
        $displayRates .= "</table>";

        return $displayRates;
    }

    public function courier_make_order(Request $request)
    {
        $transaction = Transaction::find($request->tid);
        $transaction2 = Transaction::find($request->tid);
        $pickA = SettingPickUpAddress::where('status', '1')->first();

        $service_id = $request->sid;
        $weight = $transaction->weight;
        $content = "Order: #".$transaction->transaction_no;
        $value = $transaction->grand_total;
        $pick_name = $pick_company = $pickA->company_name;
        $pick_contact = $pick_mobile = $pickA->contact;
        $pick_addr1 = $pickA->address;
        $pick_city = $pickA->city;
        $pick_state = $pickA->state;
        $pick_code = $pickA->postcode;
        $pick_country = $send_country = 'MY';

        $send_name = $transaction->address_name;
        $send_contact = $send_mobile = $transaction->phone;
        $send_addr1 = $transaction->address;
        $send_city = $transaction->city;
        $send_state = $transaction->state;
        $send_code = $transaction->postcode;

        $domain = "http://connect.easyparcel.my/?ac=";

        $action = "EPSubmitOrderBulk";
        $postparam = array(
        'api'   => 'EP-GwSDN6WXv',
        'bulk'  => array(
        array(
        'weight'    => $weight,
        'width' => '0',
        'length'    => '0',
        'height'    => '0',
        'content'   => $content,
        'value' => $value,
        'service_id'    => $service_id,
        'pick_point'    => '',
        'pick_name' => $pick_name,
        'pick_company'  => $pick_company,
        'pick_contact'  => $pick_contact,
        'pick_mobile'   => $pick_mobile,
        'pick_addr1'    => trim($pick_addr1),
        'pick_addr2'    => '',
        'pick_addr3'    => '',
        'pick_addr4'    => '',
        'pick_city' => $pick_city,
        'pick_state'    => $pick_state,
        'pick_code' => $pick_code,
        'pick_country'  => $pick_country,
        'send_point'    => '',
        'send_name' => $send_name,
        'send_company'  => '',
        'send_contact'  => $send_contact,
        'send_mobile'   => $send_mobile,
        'send_addr1'    => trim($send_addr1),
        'send_addr2'    => '',
        'send_addr3'    => '',
        'send_addr4'    => '',
        'send_city' => $send_city,
        'send_state'    => $send_state,
        'send_code' => $send_code,
        'send_country'  => $send_country,
        'collect_date'  => $request->collect_date,
        'sms'   => '0',
        'send_email'    => 'enticement888@gmail.com',
        'hs_code'   => ''
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
        $update_info = [];
        foreach($json->result as $value){
                
            $update_info['parcel_number'] = $value->parcel_number;
            $update_info['order_number'] = $value->order_number;
            $update_info['ep_order_price'] = $value->price;
            $update_info['courier'] = $value->courier;
            $update_info['courier_logo'] = $request->courier_logo;
            $update_info['remarks'] = $value->remarks;

            $transaction = $transaction->update($update_info);

            $domain = "http://connect.easyparcel.my/?ac=";

            $action = "EPPayOrderBulk";
            $postparam = array(
            'api'   => 'EP-GwSDN6WXv',
            'bulk'  => array(
            array(
            'order_no'  => $value->order_number,
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
            $update_info2 = [];
            foreach($json->result as $value2){
                if($value2->messagenow == 'Insufficient Credit'){
                    return 2;
                }

                if($value2->messagenow == 'Payment Done'){
                    foreach($value2->parcel as $value3)
                    $update_info2['parcelno'] = $value3->parcelno;
                    $update_info2['tracking_no'] = $value3->awb;


                    $transaction2 = $transaction2->update($update_info2);
                    return 1;
                }
                // return $value2->messagenow;
            }

            
        }
    }
}
