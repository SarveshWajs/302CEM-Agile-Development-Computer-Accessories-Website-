<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('frontend.welcome');
// })->name('home-page');



Auth::routes();
Route::get('/maintain', function () {
    return view('maintain');
})->name('maintain');

Route::get('/ReturnPolicy', function () {
    return view('frontend.return_policy');
})->name('return_policy');

Route::get('/TnC', function () {
    return view('frontend.tnc');
})->name('tnc');

Route::get('/PrivacyPolicy', function () {
    return view('frontend.privacy_policy');
})->name('privacy_policy');

Route::get('/JoinUs', function () {
    return view('frontend.join');
})->name('JoinUs');

Route::get('/merchant_register', 'HomeController@merchant_register')->name('merchant_register');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/Listing', 'HomeController@listing')->name('listing');
Route::get('/Mall', 'HomeController@mall')->name('mall');
Route::get('/Details/{name}/{id}', 'HomeController@details')->name('details');


Route::post('/getVerifyCode', 'AjaxController@getVerifyCode')->name('getVerifyCode');
Route::post('/resetVerifyCode', 'AjaxController@resetVerifyCode')->name('resetVerifyCode');
Route::post('/CheckLogin', 'AjaxController@CheckLogin')->name('CheckLogin');
Route::post('/updateEShopName', 'AjaxController@updateEShopName')->name('updateEShopName');
Route::post('/checkRefferalCode', 'AjaxController@checkRefferalCode')->name('checkRefferalCode');

Route::get('/auth/redirect/{provider}', 'GoogleSocialController@redirect');
Route::get('/callback/{provider}', 'GoogleSocialController@callback');
Route::get('/About', 'HomeController@about')->name('about');
Route::get('/faqs', 'HomeController@faqs')->name('faqs');
Route::get('/Contact', 'HomeController@Contact')->name('Contact');
Route::get('/VerifyAccount/{user_id}', 'HomeController@VerifyAccount')->name('VerifyAccount');
Route::get('/verify_success', 'HomeController@verify_success')->name('verify_success');
Route::get('/Blog', 'HomeController@blogs')->name('blogs');
Route::get('/BlogDetail/{id}', 'HomeController@blog_details')->name('blog_details');
Route::get('/nc/{name}/{id}', 'HomeController@name_card')->name('name_card');
Route::get('/Gallery', 'HomeController@gallery')->name('gallery');

Route::group(['middleware' => 'auth:web,merchant,admin'], function () {
	// Route::get('/Cart', 'HomeController@cart')->name('cart');
	
	Route::get('/Profile', 'HomeController@profile')->name('profile');
	Route::get('/MyVoucher', 'HomeController@my_voucher')->name('my_voucher');
	Route::get('/MyWallet', 'HomeController@wallet')->name('wallet');
	Route::get('/MyOrder', 'HomeController@order_list')->name('order_list');
	Route::get('/MyWishList', 'HomeController@wish_list')->name('wish_list');
	Route::get('/OrderDetails/{no}', 'HomeController@order_detail')->name('order_detail');
	Route::get('/ChangePassword', 'HomeController@changePassword')->name('changePassword');
	

	Route::get('/BankAccount', 'HomeController@bank_account')->name('bank_account');
	Route::get('/BankAccount/{id}', 'HomeController@bank_account_edit')->name('bank_account_edit');
	Route::get('/PendingOrder', 'HomeController@pending_order')->name('pending_order');
	Route::get('/PendingShipping', 'HomeController@pending_shipping')->name('pending_shipping');
	Route::get('/PendingReceive', 'HomeController@pending_receive')->name('pending_receive');
	Route::get('/CompletedOrder', 'HomeController@completed_order')->name('completed_order');
	Route::get('/CancelledOrder', 'HomeController@cancelled_order')->name('cancelled_order');

	Route::post('/BankAccount', 'HomeController@bank_account_save')->name('bank_account_save');
	Route::get('/LogisticTracking/{transaction_no}', 'HomeController@logistic_tracking')->name('logistic_tracking');
	
	Route::post('/save_wallet', 'HomeController@save_wallet')->name('save_wallet');
	Route::post('/Checkout', 'HomeController@postCheckout')->name('checkout');
	Route::post('/Profile', 'HomeController@updateProfile')->name('profile');
	Route::post('/updatePassword', 'HomeController@updatePassword')->name('updatePassword');
	Route::resource('AddressBook', 'UserShippingAddressController', ['as'=> 'AddressBook']);

	Route::get('/MyQRcode', 'HomeController@myqrcode')->name('myqrcode');

	Route::get('MyAffiliate/{code}', 'HomeController@MyAffiliate')->name('MyAffiliate');
	Route::get('MyCustomer/{code}', 'HomeController@MyCustomer')->name('MyCustomer');
	Route::get('MyGroupSales', 'HomeController@MyGroupSales')->name('MyGroupSales');
	Route::get('PrintMyGroupSales', 'HomeController@PrintMyGroupSales')->name('PrintMyGroupSales');
	//Frontend
	
	Route::post('/SelectCart', 'AjaxController@SelectCart')->name('SelectCart');
	Route::post('/changeDefaultAddress', 'AjaxController@changeDefaultAddress')->name('changeDefaultAddress');
	Route::post('/deleteAddress', 'AjaxController@deleteAddress')->name('deleteAddress');
	Route::post('/Favourite', 'AjaxController@add_wish')->name('Favourite');
	Route::post('/add_to_wish', 'AjaxController@add_to_wish')->name('add_to_wish');
	Route::post('/remove_wish', 'AjaxController@remove_wish')->name('remove_wish');
	Route::post('/Repayment', 'AjaxController@Repayment')->name('Repayment');
	Route::post('/setBankDefault', 'AjaxController@setBankDefault')->name('setBankDefault');

	Route::get('/MySetting', 'HomeController@my_setting')->name('my_setting');
	Route::post('/blog_comment/{id}', 'HomeController@blog_comment')->name('blog_comment');

	
	Route::post('/submit_topup', 'HomeController@submit_topup')->name('submit_topup');
	
	Route::get('/CreateCartLink', 'AjaxController@CreateCartLink')->name('CreateCartLink');
	

	Route::post('/TransferRegisterWallet', 'AjaxController@TransferRegisterWallet')->name('TransferRegisterWallet');
	Route::post('/TransferRegisterWalletMember', 'AjaxController@TransferRegisterWalletMember')->name('TransferRegisterWalletMember');
	Route::post('/TransferProductWallet', 'AjaxController@TransferProductWallet')->name('TransferProductWallet');

	Route::post('/WalletRegister', 'HomeController@WalletRegister')->name('WalletRegister');
	
	Route::post('/upgrade_agent_form', 'HomeController@upgrade_agent_form')->name('upgrade_agent_form');

	Route::post('/ConfirmPassword', 'AjaxController@ConfirmPassword')->name('ConfirmPassword');
	Route::post('/UpdateAboutUs', 'AjaxController@UpdateAboutUs')->name('UpdateAboutUs');
	Route::post('/placeOrder', 'HomeController@placeOrder')->name('placeOrder');
	Route::get('completed_order_invoice/{transaction_no}', 'HomeController@completed_order_invoice')->name('completed_order_invoice');
});

Route::get('/Checkout', 'HomeController@checkout')->name('checkout');
Route::get('/Checkout_Link', 'HomeController@checkout_link')->name('checkout_link');

Route::get('/checkUserActive', 'AjaxController@checkUserActive')->name('checkUserActive');
Route::get('/forceLogout', 'AjaxController@forceLogout')->name('forceLogout');

Route::post('/getTopupPackages', 'AjaxController@getTopupPackages')->name('getTopupPackages');
Route::post('/getAffPackages', 'AjaxController@getAffPackages')->name('getAffPackages');
Route::post('/add_new_address', 'HomeController@add_new_address')->name('add_new_address');

Route::post('/ProceedCartLink', 'AjaxController@ProceedCartLink')->name('ProceedCartLink');


Route::get('/CountCart', 'AjaxController@CountCart')->name('CountCart');
Route::post('/AddToCart', 'AjaxController@AddToCart')->name('AddToCart');
Route::post('/ApplyPromo', 'AjaxController@ApplyPromo')->name('ApplyPromo');
Route::post('/removePromotion', 'AjaxController@removePromotion')->name('removePromotion');
Route::get('/setNewGuest', 'AjaxController@setNewGuest')->name('setNewGuest');

Route::post('/getVariation', 'AjaxController@getVariation')->name('getVariation');
Route::post('/deleteCart', 'AjaxController@deleteCart')->name('deleteCart');
Route::post('/updateQuantity', 'AjaxController@updateQuantity')->name('updateQuantity');
Route::get('/PaymentProcess/{transactions}/{bank_code}', 'HomeController@PaymentProcess')->name('PaymentProcess');

Route::get('/TopupPaymentProcess/{user_id}/{amount}', 'HomeController@TopupPaymentProcess')->name('TopupPaymentProcess');
Route::get('/UpgradeTopupPaymentProcess/{user_id}/{amount}', 'HomeController@UpgradeTopupPaymentProcess')->name('UpgradeTopupPaymentProcess');

Route::get('/Payment_Error/', 'HomeController@Payment_Error')->name('Payment_Error');
Route::post('/guestAgent/', 'AjaxController@guestAgent')->name('guestAgent');

Route::get('/Confirmation_message/', 'AjaxController@Confirmation_message')->name('Confirmation_message');


Route::get('/admin_login', 'Auth\AdminLoginController@ShowAdminLogin')->name('admin_login');

Route::post('/admin_login', 'Auth\AdminLoginController@login')->name('admin_login');
Route::post('/admin_logout', 'Auth\AdminLoginController@admin_logout')->name('admin_logout');

Route::group(['middleware' => 'auth:admin,merchant'], function () {

	Route::get('/tree_view', 'HomeController@tree_view')->name('tree_view');
	
	Route::get('products/{id}/stock', 'Backend\ProductController@stock')->name('stock');
	Route::post('products/{id}/stock', 'Backend\ProductController@Submitstock')->name('stock');

	Route::get('merchants/{id}/adjust', 'Backend\MerchantController@Adjust')->name('adjust');
	Route::post('merchants/{id}/adjust', 'Backend\MerchantController@SubmitAdjust')->name('adjust');

	Route::get('products/packages/add', 'Backend\ProductController@packages_add')->name('packages_add');
	Route::post('products/packages/add', 'Backend\ProductController@packages_add_save')->name('packages_add_save');

	Route::get('products/packages/{id}/edit', 'Backend\ProductController@packages_edit')->name('packages_edit');
	Route::post('products/packages/{id}/edit', 'Backend\ProductController@packages_edit_save')->name('packages_edit_save');

	Route::get('products/packages_list/', 'Backend\ProductController@packages_list')->name('packages_list');

	Route::resource('dashboards', 'Backend\DashboardController', ['as'=> 'dashboard']);
	Route::resource('admins', 'Backend\AdminController', ['as'=> 'admin']);
	Route::resource('merchants', 'Backend\MerchantController', ['as'=> 'merchant']);
	Route::get('print_agent_list', 'Backend\MerchantController@print_agent_list')->name('print_agent_list');

	Route::resource('products', 'Backend\ProductController', ['as'=> 'product']);
	Route::resource('diets', 'Backend\DietsController', ['as'=> 'diet']);
	Route::resource('point_malls', 'Backend\PointMallController', ['as'=> 'point_mall']);

	Route::resource('categories', 'Backend\CategoryController', ['as'=> 'category']);
	Route::resource('brands', 'Backend\BrandController', ['as'=> 'brand']);
	Route::resource('promotions', 'Backend\PromotionController', ['as'=> 'promotion']);
	Route::resource('transactions', 'Backend\TransactionController', ['as'=> 'transaction']);
	Route::resource('sub_categories', 'Backend\SubCategoryController', ['as'=> 'sub_category']);
	Route::resource('user_permissions', 'Backend\UserPermissionController', ['as'=> 'user_permission']);
	Route::resource('members', 'Backend\MemberController', ['as'=> 'member']);
	Route::resource('blogs', 'Backend\BlogController', ['as'=> 'blog']);
	Route::resource('payment_banks', 'Backend\PaymentBankController', ['as'=> 'payment_bank']);

	

	Route::post('getProducts', 'Backend\AjaxController@getProducts')->name('getProducts');
	Route::post('/actionProduct/', 'Backend\AjaxController@actionProduct')->name('actionProduct');
	Route::post('sortingPackagesProduct/', 'Backend\AjaxController@sortingPackagesProduct')->name('sortingPackagesProduct');

	Route::post('add_permission_level', 'Backend\UserPermissionController@add_permission_level')->name('add_permission_level');
	// Route::resource('affiliates', 'Backend\AffiliateController', ['as'=> 'affiliate']);

	Route::get('setting_faqs', 'Backend\AdminController@setting_faqs')->name('setting_faqs');
	Route::post('setting_faqs', 'Backend\AdminController@save_setting_faqs')->name('setting_faqs');

	Route::get('setting_topup_amount', 'Backend\SettingController@setting_topup_amount')->name('setting_topup_amount');
	Route::post('setting_topup_amount', 'Backend\SettingController@save_setting_topup_amount')->name('setting_topup_amount');

	Route::get('setting_affiliate_topups', 'Backend\SettingController@setting_affiliate_topups')->name('setting_affiliate_topups');
	Route::post('setting_affiliate_topups', 'Backend\SettingController@save_setting_affiliate_topups')->name('setting_affiliate_topups');

	Route::get('pending_merchant', 'Backend\MerchantController@pending_merchant')->name('pending_merchant');
	Route::get('pending_member', 'Backend\MemberController@pending_member')->name('pending_member');

	Route::get('affiliates/{code}', 'Backend\AffiliateController@affiliates')->name('affiliates');
	Route::get('withdrawal_list', 'Backend\TransactionController@withdrawal_list')->name('withdrawal_list');
	Route::get('topup_list', 'Backend\TransactionController@topup_list')->name('topup_list');

	Route::get('setting_agent_level', 'Backend\SettingController@setting_agent_level')->name('setting_agent_level');
	Route::post('setting_agent_level_save', 'Backend\SettingController@setting_agent_level_save')->name('setting_agent_level_save');

	Route::get('setting_merchant_bonus', 'Backend\SettingController@setting_merchant_bonus')->name('setting_merchant_bonus');
	Route::post('setting_merchant_bonus', 'Backend\SettingController@save_setting_merchant_bonus')->name('setting_merchant_bonus');

	Route::get('setting_merchant_commission', 'Backend\SettingController@setting_merchant_commission')->name('setting_merchant_commission');
	Route::post('save_setting_merchant_commission', 'Backend\SettingController@save_setting_merchant_commission')->name('save_setting_merchant_commission');

	Route::get('setting_performance_dividend', 'Backend\SettingController@setting_performance_dividend')->name('setting_performance_dividend');
	Route::post('save_setting_performance_dividend', 'Backend\SettingController@save_setting_performance_dividend')->name('save_setting_performance_dividend');

	Route::get('setting_team_dividend', 'Backend\SettingController@setting_team_dividend')->name('setting_team_dividend');
	Route::post('save_setting_team_dividend', 'Backend\SettingController@save_setting_team_dividend')->name('save_setting_team_dividend');

	Route::get('setting_agent_rebate', 'Backend\SettingController@setting_agent_rebate')->name('setting_agent_rebate');
	Route::post('save_setting_agent_rebate', 'Backend\SettingController@save_setting_agent_rebate')->name('save_setting_agent_rebate');

	Route::get('setting_recommend_bonus', 'Backend\SettingController@setting_recommend_bonus')->name('setting_recommend_bonus');
	Route::post('save_setting_recommend_bonus', 'Backend\SettingController@save_setting_recommend_bonus')->name('save_setting_recommend_bonus');

	Route::get('setting_dual_commission', 'Backend\SettingController@setting_dual_commission')->name('setting_dual_commission');
	Route::post('save_setting_dual_commission', 'Backend\SettingController@save_setting_dual_commission')->name('save_setting_dual_commission');

	Route::get('setting_shipping_fee', 'Backend\SettingController@setting_shipping_fee')->name('setting_shipping_fee');
	Route::post('save_setting_shipping_fee', 'Backend\SettingController@save_setting_shipping_fee')->name('save_setting_shipping_fee');

	Route::get('setting_agent_package', 'Backend\SettingController@setting_agent_package')->name('setting_agent_package');
	Route::post('save_setting_agent_package', 'Backend\SettingController@save_setting_agent_package')->name('save_setting_agent_package');

	Route::get('setting_customer_package', 'Backend\SettingController@setting_customer_package')->name('setting_customer_package');
	Route::post('save_setting_customer_package', 'Backend\SettingController@save_setting_customer_package')->name('save_setting_customer_package');

	Route::get('setting_website_images', 'Backend\SettingController@setting_website_images')->name('setting_website_images');
	Route::post('save_setting_website_images', 'Backend\SettingController@save_setting_website_images')->name('save_setting_website_images');

	Route::get('setting_charges', 'Backend\SettingController@setting_charges')->name('setting_charges');
	Route::post('save_setting_charges', 'Backend\SettingController@save_setting_charges')->name('save_setting_charges');

	Route::get('setting_agent_monthly_sales_bonus', 'Backend\SettingController@setting_agent_monthly_sales_bonus')->name('setting_agent_monthly_sales_bonus');
	Route::post('save_setting_agent_monthly_sales_bonus', 'Backend\SettingController@save_setting_agent_monthly_sales_bonus')->name('save_setting_agent_monthly_sales_bonus');

	Route::get('setting_downline_bonus', 'Backend\SettingController@setting_downline_bonus')->name('setting_downline_bonus');
	Route::post('save_setting_downline_bonus', 'Backend\SettingController@save_setting_downline_bonus')->name('save_setting_downline_bonus');

	Route::get('setting_extra_cash_rebate', 'Backend\SettingController@setting_extra_cash_rebate')->name('setting_extra_cash_rebate');
	Route::post('save_setting_extra_cash_rebate', 'Backend\SettingController@save_setting_extra_cash_rebate')->name('save_setting_extra_cash_rebate');

	Route::post('saveNewPassword/{id}', 'Backend\MerchantController@saveNewPassword')->name('saveNewPassword');
	Route::post('saveMemberNewPassword/{id}', 'Backend\MemberController@saveMemberNewPassword')->name('saveMemberNewPassword');

	Route::post('/uploadBankSlip', 'Backend\TransactionController@uploadBankSlip')->name('uploadBankSlip');

	Route::get('agent_stock_report', 'Backend\ReportController@agent_stock_report')->name('agent_stock_report');
	Route::get('print_agent_stock_report', 'Backend\ReportController@print_agent_stock_report')->name('print_agent_stock_report');
	Route::get('sales_report', 'Backend\ReportController@sales_report')->name('sales_report');
	Route::get('print_sales_report', 'Backend\ReportController@print_sales_report')->name('print_sales_report');
	Route::get('order_report', 'Backend\ReportController@order_report')->name('order_report');
	Route::get('print_order_report', 'Backend\ReportController@print_order_report')->name('print_order_report');
	Route::get('commission_report', 'Backend\ReportController@commission_report')->name('commission_report');
	Route::get('print_commission_report', 'Backend\ReportController@print_commission_report')->name('print_commission_report');
	
	Route::get('redemption_report', 'Backend\ReportController@redemption_report')->name('redemption_report');
	Route::get('print_redemption_report', 'Backend\ReportController@print_redemption_report')->name('print_redemption_report');


	//export
	Route::get('ExportRedemtion', 'Backend\ReportController@ExportRedemtion')->name('ExportRedemtion');
	Route::get('exportOrder', 'Backend\ReportController@exportOrder')->name('exportOrder');
	Route::get('exportSales', 'Backend\ReportController@exportSales')->name('exportSales');
	Route::get('exportAgentStockReport', 'Backend\ReportController@exportAgentStockReport')->name('exportAgentStockReport');
	Route::get('exportCommissionReport', 'Backend\ReportController@exportCommissionReport')->name('exportCommissionReport');
	Route::get('exportAgentAbout', 'Backend\MerchantController@exportAgentAbout')->name('exportAgentAbout');

	Route::get('tree/{agent_code}', 'Backend\MerchantController@tree')->name('tree');
	Route::get('tree_details/{agent_code}/{g}', 'Backend\MerchantController@tree_details')->name('tree_details');

	Route::post('/getBankDetails', 'AjaxController@getBankDetails')->name('getBankDetails');

	Route::get('setting_uom', 'Backend\SettingController@setting_uom')->name('setting_uom');
	Route::post('setting_uom_save', 'Backend\SettingController@setting_uom_save')->name('setting_uom_save');

	Route::post('CKEditorUploadImage', 'Backend\AjaxController@CKEditorUploadImage')->name('CKEditorUploadImage');

	Route::get('transaction_invoice/{transaction_no}', 'Backend\TransactionController@transaction_invoice')->name('transaction_invoice');


	Route::get('topup_invoice/{topup_no}', 'Backend\TransactionController@topup_invoice')->name('topup_invoice');

	Route::get('setting_banner', 'Backend\SettingController@setting_banner')->name('setting_banner');
	Route::get('setting_banner_testing', 'Backend\SettingController@setting_banner_testing')->name('setting_banner_testing');
	Route::get('setting_banner_video', 'Backend\SettingController@setting_banner_video')->name('setting_banner_video');
	Route::get('setting_pop_up_image', 'Backend\SettingController@setting_pop_up_image')->name('setting_pop_up_image');

	Route::get('setting_pick_up_address', 'Backend\SettingController@setting_pick_up_address')->name('setting_pick_up_address');
	Route::post('save_setting_pick_up_address', 'Backend\SettingController@save_setting_pick_up_address')->name('save_setting_pick_up_address');

	Route::get('setting_gallery_image', 'Backend\SettingController@setting_gallery_image')->name('setting_gallery_image');

	Route::post('add_awb_no', 'Backend\TransactionController@add_awb_no')->name('add_awb_no');
	Route::get('agent_about', 'Backend\MerchantController@agent_about')->name('agent_about');

	Route::post('/AdjustProductWallet', 'Backend\AjaxController@AdjustProductWallet')->name('AdjustProductWallet');

	Route::get('shipping_details/{transaction_no}', 'Backend\TransactionController@shipping_details')->name('shipping_details');

	Route::post('/uploadBannerVideo/', 'Backend\SettingController@uploadBannerVideo')->name('uploadBannerVideo');
});


//Ajax
//Backend
Route::post('/uploadImage/{id}', 'Backend\AjaxController@uploadImage')->name('uploadImage');
Route::get('/LoadImage/{id}', 'Backend\AjaxController@LoadImage')->name('LoadImage');
Route::get('/DeleteImage/{id}', 'Backend\AjaxController@DeleteImage')->name('DeleteImage');
Route::post('/SortImage', 'Backend\AjaxController@SortImage')->name('SortImage');

Route::post('/uploadCategoryImage/{id}', 'Backend\AjaxController@uploadCategoryImage')->name('uploadCategoryImage');
Route::get('/LoadCategoryImage/{id}', 'Backend\AjaxController@LoadCategoryImage')->name('LoadCategoryImage');
Route::get('/DeleteCategoryImage/{id}', 'Backend\AjaxController@DeleteCategoryImage')->name('DeleteCategoryImage');

Route::post('/ApproveRejectMerchant/', 'Backend\AjaxController@ApproveRejectMerchant')->name('ApproveRejectMerchant');
Route::post('/ApproveRejectMember/', 'Backend\AjaxController@ApproveRejectMember')->name('ApproveRejectMember');
Route::post('/deleteAgentBonus/', 'Backend\AjaxController@deleteAgentBonus')->name('deleteAgentBonus');

Route::post('/SetPermission/', 'Backend\AjaxController@SetPermission')->name('SetPermission');
Route::post('/UnsetPermission/', 'Backend\AjaxController@UnsetPermission')->name('UnsetPermission');
Route::get('/GetPermission/', 'Backend\AjaxController@GetPermission')->name('GetPermission');
Route::post('/change_transaction_action/', 'Backend\AjaxController@change_transaction_action')->name('change_transaction_action');
Route::post('/change_withdrawal_transaction_action/', 'Backend\AjaxController@change_withdrawal_transaction_action')->name('change_withdrawal_transaction_action');

Route::post('/getItemCode', 'Backend\AjaxController@getItemCode')->name('getItemCode');
Route::post('/getSubItemCode', 'Backend\AjaxController@getSubItemCode')->name('getSubItemCode');

Route::post('/MerchantStatus', 'Backend\AjaxController@MerchantStatus')->name('MerchantStatus');
Route::post('/UserStatus', 'Backend\AjaxController@UserStatus')->name('UserStatus');
Route::post('/ProductStatus', 'Backend\AjaxController@ProductStatus')->name('ProductStatus');
Route::post('/CategoryStatus', 'Backend\AjaxController@CategoryStatus')->name('CategoryStatus');
Route::post('/SubCategoryStatus', 'Backend\AjaxController@SubCategoryStatus')->name('SubCategoryStatus');
Route::post('/BrandStatus', 'Backend\AjaxController@BrandStatus')->name('BrandStatus');
Route::post('/BlogStatus', 'Backend\AjaxController@BlogStatus')->name('BlogStatus');
Route::post('/PromotionStatus', 'Backend\AjaxController@PromotionStatus')->name('PromotionStatus');
Route::post('/BankStatus', 'Backend\AjaxController@BankStatus')->name('BankStatus');
Route::post('/setFeatured', 'Backend\AjaxController@setFeatured')->name('setFeatured');

Route::post('/uploadBannerImageTesting/', 'Backend\AjaxController@uploadBannerImageTesting')->name('uploadBannerImageTesting');
Route::get('/LoadBannerImageTesting', 'Backend\AjaxController@LoadBannerImageTesting')->name('LoadBannerImageTesting');
Route::get('/DeleteBannerImageTesting/{id}', 'Backend\AjaxController@DeleteBannerImageTesting')->name('DeleteBannerImageTesting');

Route::post('/uploadGalleryImage/', 'Backend\AjaxController@uploadGalleryImage')->name('uploadGalleryImage');
Route::get('/LoadGalleryImage', 'Backend\AjaxController@LoadGalleryImage')->name('LoadGalleryImage');
Route::get('/DeleteGalleryImage/{id}', 'Backend\AjaxController@DeleteGalleryImage')->name('DeleteGalleryImage');

Route::post('/uploadBannerImage/', 'Backend\AjaxController@uploadBannerImage')->name('uploadBannerImage');
Route::get('/LoadBannerImage', 'Backend\AjaxController@LoadBannerImage')->name('LoadBannerImage');
Route::get('/DeleteBannerImage/{id}', 'Backend\AjaxController@DeleteBannerImage')->name('DeleteBannerImage');

Route::post('/uploadPopupImage/', 'Backend\AjaxController@uploadPopupImage')->name('uploadPopupImage');
Route::get('/LoadPopupImage', 'Backend\AjaxController@LoadPopupImage')->name('LoadPopupImage');
Route::get('/DeletePopupImage/{id}', 'Backend\AjaxController@DeletePopupImage')->name('DeletePopupImage');

Route::post('/GetSubCategory', 'Backend\AjaxController@GetSubCategory')->name('GetSubCategory');
Route::post('/change_topup_action', 'Backend\AjaxController@change_topup_action')->name('change_topup_action');

Route::post('DeleteShipping', 'Backend\AjaxController@DeleteShipping')->name('DeleteShipping');


Route::post('/courier_service_list', 'Backend\AjaxController@courier_service_list')->name('courier_service_list');
Route::post('/courier_make_order', 'Backend\AjaxController@courier_make_order')->name('courier_make_order');
Route::post('/TopupAgent', 'Backend\AjaxController@TopupAgent')->name('TopupAgent');

Route::post('/getTransactionVariation', 'Backend\AjaxController@getTransactionVariation')->name('getTransactionVariation');
Route::post('/getVariationStock', 'Backend\AjaxController@getVariationStock')->name('getVariationStock');

Route::post('/deletePackageItem', 'Backend\AjaxController@deletePackageItem')->name('deletePackageItem');

