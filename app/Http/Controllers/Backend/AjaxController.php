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
use App\SettingBannerTesting;
use App\SettingBannerVideo;
use App\SubCategory;
use App\SettingDualMain;
use App\SettingDualCommission;
use App\AffiliateDual;
use App\TopupTransaction;
use App\Blog;
use App\SettingShippingFee;
use App\SettingPickUpAddress;
use App\Favourite;
use App\BankAccount;
use App\UserShippingAddress;
use App\SettingAffiliateTopup;
use App\PaymentBank;
use App\ProductVariation;
use App\Stock;
use App\AdjustProductWallet;
use App\SettingPopUpImage;
use App\PackageItem;
use App\SettingGalleryImage;


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

    public function uploadBannerImageTesting(Request $request)
    {
        $files = $request->file('file'); 
        $name = $files->getClientOriginalName();
        $exp = explode(".", $name);
        $file_ext = end($exp);
        $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
          
        $input = $request->all();
          
        $input['status'] = '1';
        $input['image'] = "uploads/bannertesting/".$name;

        $files->move("uploads/bannertesting/", $name);
          
        $product_image = SettingBannerTesting::create($input);
        
        
        $select = SettingBannerTesting::where('status', '1')->get();
        

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

    public function LoadBannerImageTesting()
    {
      $select = SettingBannerTesting::where('status', '1')->get();

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

    public function DeleteBannerImageTesting($id)
    {
      $delete = SettingBannerTesting::find($id);
      File::delete($delete->image);
      $delete = $delete->delete();
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

    public function uploadGalleryImage(Request $request)
    {
        $files = $request->file('file'); 
        $name = $files->getClientOriginalName();
        $exp = explode(".", $name);
        $file_ext = end($exp);
        $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
          
        $input = $request->all();
          
        $input['status'] = '1';
        $input['image'] = "uploads/gallery/".$name;

        $files->move("uploads/gallery/", $name);
          
        $product_image = SettingGalleryImage::create($input);
        
        
        $select = SettingGalleryImage::where('status', '1')->get();
        

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

    public function LoadGalleryImage()
    {
      $select = SettingGalleryImage::where('status', '1')->get();

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

    public function DeleteGalleryImage($id)
    {
      $delete = SettingGalleryImage::find($id);
      File::delete($delete->image);
      $delete = $delete->delete();
    }


    public function uploadPopupImage(Request $request)
    {
        $files = $request->file('file'); 
        $name = $files->getClientOriginalName();
        $exp = explode(".", $name);
        $file_ext = end($exp);
        $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;
          
        $input = $request->all();
          
        $input['status'] = '1';
        $input['image'] = "uploads/popup/".$name;

        $files->move("uploads/popup/", $name);
          
        $product_image = SettingPopupImage::create($input);
        
        
        $select = SettingPopupImage::where('status', '1')->get();
        

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

    public function LoadPopupImage()
    {
      $select = SettingPopupImage::where('status', '1')->get();

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

    public function DeletePopupImage($id)
    {
      $delete = SettingPopupImage::find($id);
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

            TopupTransaction::where('user_id', $merchant->code)
                            ->where('status', '99')
                            ->update(['status'=>'1']);

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
            // $this->WelcomeMessage($user->email, 'noreply@vesson.my', '', 'WELCOME TO WESHARE2YOU!', $user);
            $upline = Merchant::where('code', $user->master_id)->first();
            if(!empty($upline->id)){
              // $this->NewDownlineMessage($upline->email, 'noreply@vesson.my', $upline->f_name, 'New Downline', $user);
            }
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
     public function UserStatus(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->status;
        $table = User::find($request->row_id);
        $table = $table->update($input);
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
          if($select->deduct_wallet == 1){
              $upline = User::select('m.code as m_code')
                            ->join('merchants as m', 'm.code', 'users.master_id')
                            ->where('users.code', $select->user_id)
                            ->first();

              if(!empty($select->transaction_charges_amount)){
                  $refundAmount = $amount;
                  if($select->transaction_charges_type == 'Percentage'){
                      $refundAmount = $amount - ($amount * $select->transaction_charges_amount / 100);
                  }else{
                      $refundAmount = $amount - $select->transaction_charges_amount;
                  }

                  if(!empty($upline->m_code)){
                    AffiliateCommission::create(['type'=>'10',
                                                 'user_id'=>$upline->m_code,
                                                 'transaction_no'=>$select->transaction_no,
                                                 'product_amount'=>$amount,
                                                 'comm_pa_type'=>$select->transaction_charges_type,
                                                 'comm_pa'=>$select->transaction_charges_amount,
                                                 'comm_amount'=>$refundAmount,
                                                 'status'=>'99',
                                                 'comm_desc'=>'Payment From Transaction No. #'.$select->transaction_no]);                    
                  }
              }
          }
          $transaction = $transaction->update(['status'=>'1']);
        }
      if($request->action_id == '95'){
          $cancel = AffiliateCommission::where('transaction_no', $select->transaction_no)->update(['status' => '2']);
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

        $merchant = Merchant::where('code', $select->user_id)->where('status', '99')->first();
        if(!empty($merchant->id)){
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

            $updateMerchant = Merchant::find($merchant->id)->update(['status'=>'1']);
        }

        if($select->upgrade_agent == '1'){
            $user = User::where('code', $select->user_id)->first();

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

        // $this->cashRebate($select->user_id, $select->actual_amount);
        // $this->AgentUpgrade($select->user_id);
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
        'api'   => 'EP-qHmHHuRcu',
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
        'api'   => 'EP-qHmHHuRcu',
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
            'api'   => 'EP-qHmHHuRcu',
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
        $user_name = $transaction->user_id;
        $merchant = Merchant::where('code', $transaction->user_id)->first();
        $user = User::where('code', $transaction->user_id)->first();
        $user_name = !empty($merchant->f_name) ? $merchant->f_name : $user_name;
        $user_name = !empty($user->f_name) ? $user->f_name : $user_name;
        if(!empty($transaction->email)){
          $this->ParcelCreatedMessage($transaction->email, 'noreply@vesson.my', $user_name, "Parcel Shipped", $transaction);
        }
    }

    public function TopupAgent(Request $request)
    {

        $topupPackage = SettingAffiliateTopup::find($request->pid);
        $merchant = Merchant::find($request->mid);
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
        $input_topup['topup_no'] = $this->GenerateTopupNo();
        $input_topup['user_id'] = $merchant->code;
        $input_topup['amount'] = $topupPackage->topup_amount + $profit_bonus;
        $input_topup['actual_amount'] = $topupPackage->topup_amount;
        $input_topup['amount_desc'] = "RM ".$topupPackage->topup_amount.$profit_display;
        $input_topup['package_id'] = $topupPackage->id;

        $input_topup['topup_type'] = '2';
        $input_topup['status'] = "1";
        $input_topup['created_by'] = Auth::guard('admin')->user()->code;

        $createTopup = TopupTransaction::create($input_topup);


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

    public function BankStatus(Request $request)
    {
        $input = $request->all();
        $input['status'] = $request->status;
        $table = PaymentBank::find($request->row_id);
        $table = $table->update($input);
    }

    public function getTransactionVariation(Request $request)
    {
        $product = Product::find($request->pid);
        $product_variations = ProductVariation::where('product_id', $request->pid)->get();

        $product_v_list = "";

        if(!$product_variations->isEmpty() && $product->variation_enable == 1){
            $product_v_list .= '<label>Variation</label>
                                <select class="form-control product_variation_option" name="product_variation'.$request->num.'">
                                  <option value="">Select Variation</option>';
            foreach ($product_variations as $value) {
                $variation_price = !empty($value->variation_agent_special_price) ? $value->variation_agent_special_price : $value->variation_agent_price;
                $product_v_list .= '<option value="'.$value->id.'">
                                      '.$value->variation_name.' RM '.number_format($variation_price, 2).'
                                    </option>';
            }
            $product_v_list .= '</select>';

            return array(1, $product_v_list, 0);
        }else{
            if(Auth::guard('merchant')->check()){
                $stockBalance = $this->AgentProductBalance($request->pid);
            }else{
                $stockBalance = $this->BalanceQuantity($request->pid);
            }
            $price = !empty($product->agent_special_price) ? $product->agent_special_price : $product->agent_price;
            return array(2, $stockBalance, $price);
        }
    }

    public function getVariationStock(Request $request)
    {
        if(Auth::guard('merchant')->check()){
          $stockBalance = $this->AgentVariationBalance($request->vid);
          return $stockBalance;
        }else{
          $quantityAmount = ProductVariation::find($request->vid);

          $transaction = TransactionDetail::select(DB::raw('SUM(quantity) AS TransCart'))
                                          ->join('transactions AS t', 't.id', 'transaction_details.transaction_id')
                                          ->whereIn('t.status', ['1', '97', '98', '99'])
                                          ->where('variation_id', $request->vid)
                                          ->whereNull('transaction_type')
                                          ->first();

          return $quantityAmount->variation_stock - $transaction->TransCart;
        }
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

    public function AdjustProductWallet(Request $request)
    {
        $merchant = Merchant::find($request->mid);

        $input = [];
        $input['user_id'] = $merchant->code;
        $input['amount'] = preg_replace("/[^0-9\.]/", '', $request->adjust_amount);
        $input['type'] = $request->adjust_type;
        $input['created_by'] = Auth::user()->code;

        $AdjustProductWallet = AdjustProductWallet::create($input);
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

        $send = mail($to, $subject, $body, $headers);
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

        $send = mail($to, $subject, $body, $headers);
    }

    public function ParcelCreatedMessage($to, $from, $name, $subject, $user)
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
        $body .= "<tr><td>Tracking Number: ".$transaction->tracking_no."</td></tr>";
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

    public function deletePackageItem(Request $request)
    {
        $PackageItem = PackageItem::find($request->pid)->delete();
    }

    
}
