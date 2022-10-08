@extends('layouts.app')
<style type="text/css">
	/*.nav-link.active{
	    color: #fff;
	    background-color: #007bff;
	}*/
	.footer__widget__social a .fa{
		margin-top: 10px;
	}
</style>
@section('content')
<section class="bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Checkout</h1>
            </div>
            <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                   <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Checkout
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<div class="cart_section py-5">
	<div class="container p-t-65 p-b-60">
		<form method="POST" action="{{ route('placeOrder') }}" id="placeorder-form" enctype="multipart/form-data">
		@csrf
			<div class="form-group">
				<div class="row">
					<div class="col-md-6">
						<div class="container-box f-15">
							<div class="form-group">
								<div class="row">
									<div class="col-6">
										<b>Item(s) Details</b>
										<input type="text" class="create_link_id" id="create_link_id" value="{{ route('checkout') }}" style="height: 0; position: absolute; z-index: -1; padding: 0; border: none;">
									</div>
									@if(Auth::guard('merchant')->check())
									<div class="col-6" align="right">
										<a class="btn btn-primary btn-sm create-cart-link">
											Create cart link
										</a>
									</div>
									@endif
								</div>
							</div>
							<hr>
							@php
							$totalPrice = 0;
							$totalWeight = 0;
							@endphp
							@foreach($carts as $key => $cart)
							@php
		                        if(isset($cart->image) && !empty($cart->image)){
		                            $image = file_exists($cart->image) ? $cart->image : url('images/no-image-available-icon-6.jpg');
		                        }else{
		                            $image = url('images/no-image-available-icon-6.jpg');
		                        }
		                    @endphp
							<div class="form-group cart-detail">
								<div class="row">
									<div class="col-2 order-images">
										<input type="hidden" name="selected_cart[]" class="form-control required-feild" value="{{ md5($cart->cid) }}">
										<a href="{{ route('details', [$cart->product_name, md5($cart->id)]) }}">
											<img src="{{ url($image) }}" style="width: 100%;">
										</a>
									</div>
									<div class="col-10 order-details">
										<div class="row">
											<div class="col-sm-4">
												<div class="form-group product-name">
													<a href="{{ route('details', [$cart->product_name, md5($cart->id)]) }}">
														{{ $cart->product_name }}
														@if($cart->variation_enable == '1')
															<br>
															Variation: {{ $cart->variation_name }}
														@endif
														
													</a>
													<br>
													@if($cart->variation_enable == '1')
														{{ !empty($cart->variation_weight) ? 'Weight: '.$cart->variation_weight.'KG' : '' }}
													@else
														{{ !empty($cart->weight) ? 'Weight: '.$cart->weight.'KG' : '' }}
													@endif
													<br>
													<a href="#" class="important-text non-load delete-cart-btn" data-id="{{ md5($cart->cid) }}">
														<i class="fa fa-trash"></i>
													</a>
												</div>
											</div>


											<div class="col-sm-3" align="right">
												<div class="form-group">
													@if(!empty(request('m')) && request('m') == '1')
														@if(Auth::guard('merchant')->check() || Auth::guard('admin')->check())
															{{ $cart->agent_actual_price }}	point
														@else
															{{ $cart->actual_price }}	point
														@endif
													@else
														@if(Auth::guard('merchant')->check() || Auth::guard('admin')->check())
															@if($cart->variation_enable == '1')
																@if(!empty($cart->variation_agent_special_price))
																	RM {{ number_format($cart->variation_agent_special_price, 2) }}	
																@else
																	RM {{ number_format($cart->variation_agent_price, 2) }}	
																@endif
															@else
																@if(!empty($cart->agent_special_price))
																	RM {{ number_format($cart->agent_special_price, 2) }}	
																@else
																	RM {{ number_format($cart->agent_price, 2) }}	
																@endif
															@endif
														@else
															@if($cart->variation_enable == '1')
																@if(!empty($cart->variation_special_price))
																	RM {{ number_format($cart->variation_special_price, 2) }}	
																@else
																	RM {{ number_format($cart->variation_price, 2) }}	
																@endif
															@else
																@if(!empty($cart->special_price))
																	RM {{ number_format($cart->special_price, 2) }}	
																@else
																	RM {{ number_format($cart->price, 2) }}	
																@endif
															@endif
														@endif
													@endif
													<!-- RM {{ number_format($cart->actual_price, 2) }} -->
													<!-- @if(!empty($cart->special_price))
														RM {{ number_format($cart->special_price, 2) }}
													@else
														RM {{ number_format($cart->price, 2) }}
													@endif -->
												</div>
											</div>
											<div class="col-sm-2" align="right">
												<div class="form-group">
													x{{ $cart->qty }}
												</div>
											</div>
											<div class="col-sm-3" align="right">
												<div class="form-group">
													@if(Auth::guard('merchant')->check() || Auth::guard('admin')->check())
														@if($cart->variation_enable == '1')
															@if(!empty($cart->variation_agent_special_price))
																RM {{ number_format($cart->variation_agent_special_price * $cart->qty, 2) }}	
															@else
																RM {{ number_format($cart->variation_agent_price * $cart->qty, 2) }}	
															@endif
														@else
															@if(!empty($cart->agent_special_price))
																RM {{ number_format($cart->agent_special_price * $cart->qty, 2) }}	
															@else
																RM {{ number_format($cart->agent_price * $cart->qty, 2) }}	
															@endif
														@endif
													@else
														@if($cart->variation_enable == '1')
															@if(!empty($cart->variation_special_price))
																RM {{ number_format($cart->variation_special_price * $cart->qty, 2) }}	
															@else
																RM {{ number_format($cart->variation_price * $cart->qty, 2) }}	
															@endif
														@else
															@if(!empty($cart->special_price))
																RM {{ number_format($cart->special_price * $cart->qty, 2) }}	
															@else
																RM {{ number_format($cart->price * $cart->qty, 2) }}	
															@endif
														@endif
													@endif
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr>
							</div>
							@php
							if(Auth::guard('merchant')->check() || Auth::guard('admin')->check()){
								if($cart->variation_enable == '1'){
									if(!empty($cart->variation_agent_special_price)){
										$totalPrice += $cart->variation_agent_special_price * $cart->qty;
									}else{
										$totalPrice += $cart->variation_agent_price * $cart->qty;
									}
								}else{
									if(!empty($cart->agent_special_price)){
										$totalPrice += $cart->agent_special_price * $cart->qty;
									}else{
										$totalPrice += $cart->agent_price * $cart->qty;
									}
								}
							}else{
								if($cart->variation_enable == '1'){
									if(!empty($cart->variation_special_price)){
										$totalPrice += $cart->variation_special_price * $cart->qty;
									}else{
										$totalPrice += $cart->variation_price * $cart->qty;
									}
								}else{
									if(!empty($cart->special_price)){
										$totalPrice += $cart->special_price * $cart->qty;
									}else{
										$totalPrice += $cart->price * $cart->qty;
									}
								}
							}
							

							
							if($cart->variation_enable == '1'){
								$totalWeight += $cart->variation_weight * $cart->qty;
							}else{
								$totalWeight += $cart->weight * $cart->qty;
							}
							@endphp
							@endforeach
							@if(empty($checkAppliedPromo))
							<div class="form-group promotion-field">
	                            <div class="row">
	                            	<div class="col-6">
	                            		Do you have a voucher?
	                            	</div>
	                            	<div class="col-6" align="right">
			                            <a href="#" data-toggle="modal" data-target="#applyPromotion">
										  	Apply
										</a>

										<div class="modal fade" id="applyPromotion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										  	<div class="modal-dialog">
										    	<div class="modal-content">
										      		<div class="modal-header">
										        		<h5 class="modal-title" id="exampleModalLabel" align="center">
										        			Apply a voucher
										        		</h5>
										        		<button type="button" class="close close-promo-list" data-dismiss="modal" aria-label="Close">
										          			<span aria-hidden="true">&times;</span>
										        		</button>
										      		</div>
										      		<div class="modal-body">
										        		<div class="input-group">
							                                <input type="text" name="result" class="form-control discount-code" placeholder="Promotion Code / Discount Code / Voucher Code"
							                                       value="">
							                                <span class="input-group-btn">
							                                    <button type="submit" class="btn btn-primary btn-white apply-discount">
							                                        <span class="ace-icon fa fa-check icon-on-right bigger-110"></span>
							                                        Apply
							                                    </button>
							                                </span>
							                            </div>
							                            <div class="error-message-promo important-text"></div>
							                            <hr>
							                            @foreach($getClaimedPromos as $getClaimedPromo)
							                            <div class="form-group" align="left">
							                            	<input type="hidden" name="apid" class="apid" value="{{ $getClaimedPromo->apid }}">
							                            	<a href="#" class="claim-voucher" style="display: block; width: 100%;" data-id="{{ $getClaimedPromo->discount_code }}">
							                            		<div class="row">
							                            			<div class="col-3">
							                            				<img src="{{ url($getClaimedPromo->image) }}" style="width: 70px;">
							                            			</div>
							                            			<div class="col-9">
							                            				<b>{{ $getClaimedPromo->promotion_title }}</b><br>
							                            				Offer: {{ ($getClaimedPromo->amount_type == 'Percentage') ? $getClaimedPromo->amount."%" : 'RM '.$getClaimedPromo->amount }} OFF<br>
							                            				Expiry: {{ $getClaimedPromo->end_date }}<br>
							                            				Code: {{ $getClaimedPromo->discount_code }}
							                            			</div>
							                            		</div>
							                            	</a>
							                            </div>
							                            <hr>
							                            @endforeach
										      		</div>
										      		<!-- <div class="modal-footer"> -->
										        	<button type="button" class="btn btn-secondary close-modal" data-dismiss="modal" style="display: none;">Close</button>
										        		<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
										      		<!-- </div> -->
										    	</div>
										  	</div>
										</div>
									</div>
	                            </div>
							</div>
							@endif
							@php
								$applied_discount_type = "";
								if(!empty($checkAppliedPromo->id)){
									if($checkAppliedPromo->amount_type == 'Percentage'){
										$applied_discount_type = $checkAppliedPromo->amount."%";
									}else{
										$applied_discount_type = "RM ".$checkAppliedPromo->amount;
									}
								}
							@endphp
							<div class="form-group">
	                        	<div class="success-message-promo green">
	                        		{{ (!empty($checkAppliedPromo->id)) ? "Applied Successfully - ".$checkAppliedPromo->discount_code."(".$applied_discount_type.")" : '' }}
	                        		@if(!empty($checkAppliedPromo->id))
	                        			<a href="#" class="remove-applied-promo pull-right" data-id="{{ $checkAppliedPromo->id }}">
	                        				Remove
	                        			</a>
	                        		@endif
	                        	</div>
	                        	
	                        </div>
							<hr>
							<div class="form-group">
								<div class="row">
									<div class="col-6">
										<b>Subtotal: </b>
									</div>
									<div class="col-6" align="right">

										@if(!empty(request('m')) && request('m') == '1')
											<b>{{ number_format($totalPrice, 2) }} point </b>
										@else
											<b>RM {{ number_format($totalPrice, 2) }} </b>
										@endif
										<input type="hidden" name="sub_total" id="subtotal" value="{{ $totalPrice }}">
									</div>
								</div>
							</div>
							<hr>

						
							<input type="hidden" name="hidden_shipping_amount" class="hidden_shipping_amount" value="{{ $totalshipping_fees }}">
							@if($totalshipping_fees != 0)
							
							<div class="form-group">
								<div class="row">
									<div class="col-6">
										<b class="shipping_word">{{ isset($data['lang']['lang']['shipping_fee']) ? $data['lang']['lang']['shipping_fee'] : ' Shipping Fees' }}: </b>
									</div>
									<div class="col-6" align="right">
										@if(!empty(request('m')) && request('m') == '1')
											<b class="shipping_amount">{{ number_format($totalshipping_fees, 2) }} point</b>
										@else
											<b class="shipping_amount">RM {{ number_format($totalshipping_fees, 2) }}</b>
										@endif
									</div>
								</div>
							</div>
							<hr>
							@endif

							@php
								$applied_discount_amount = 0;
								if(!empty($checkAppliedPromo->id)){
									if($checkAppliedPromo->amount_type == 'Percentage'){
										$applied_discount_amount = (float) $totalPrice * $checkAppliedPromo->amount / 100;
									}else{
										$applied_discount_amount = $checkAppliedPromo->amount;
									}
								}
							@endphp

							<div class="form-group">
								<input type="hidden" name="discount_code" id="code" value="{{ (!empty($checkAppliedPromo->id)) ? $checkAppliedPromo->promotion_id : '' }}">
	                        	<input type="hidden" name="discount" id="totalDiscount" value="{{ $applied_discount_amount }}">
								<div class="row">
									<div class="col-6">
										<b class="discount_word">Discount{{ !empty($applied_discount_type) ? "(".$applied_discount_type.")" : '' }}: </b>
									</div>
									<div class="col-6" align="right">
										@if(!empty(request('m')) && request('m') == '1')
											<b class="discount_amount">0.00 point</b>
										@else
											@if(!empty($applied_discount_amount))
												<b class="discount_amount">RM {{ number_format($applied_discount_amount, '2') }}</b>
											@else
												<b class="discount_amount">RM 0.00</b>
											@endif
										@endif
										<input type="hidden" name="hidden_discount" class="hidden_discount" value="{{ !empty($applied_discount_amount) ? $applied_discount_amount : '' }}">
									</div>
								</div>
							</div>
							<hr>
							<!-- 
							<div class="form-group">
								<div class="row">
									<div class="col-6">
										<b>Processing Fee (1.6%): </b>
									</div>
									<div class="col-6" align="right">
										<b class="processing_amount">RM {{ number_format(($totalPrice - $applied_discount_amount + $totalshipping_fees) * 1.6 / 100, 2) }}</b>
										<input type="hidden" name="hidden_processing_amount" class="hidden_processing_amount" value="{{ number_format(($totalPrice + $totalshipping_fees) * 1.6 / 100, 2) }}">
									</div>
								</div>
							</div>
							<hr> -->
							<!-- @php
							$processing_fee = ($totalPrice - $applied_discount_amount + $totalshipping_fees) * 1.6 / 100;
							@endphp -->
							<div class="form-group">
								<div class="row">
									<div class="col-6">
										<b style="font-size: 20px;">Grand total: </b>
									</div>
									<div class="col-6" align="right" style="font-size: 20px;">
										
										<b class="grand-total">RM {{ number_format(($totalPrice - $applied_discount_amount + $totalshipping_fees), 2) }}</b>
										@php
											$totalGrand = ($totalPrice - $applied_discount_amount + $totalshipping_fees);
										@endphp

										<input type="hidden" id="hidden_grand_total" value="{{ $totalGrand }}">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="container-box form-group">
							<div class="form-group">
								<h4>Shipping Address </h4>
							</div>
						<div class="form-group">
                        				@if($errors->any())
				                          <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
				                        @endif
			                        </div>
							@if(!empty($shipping_address->id))
								<input type="hidden" name="billing_details_im" value="{{ md5($shipping_address->id) }}">
								<div class="form-group">
									<div class="form-group">
										<i class="fa fa-user" aria-hidden="true"></i> &nbsp;&nbsp;
										<b>{{ $shipping_address->f_name }} {{ $shipping_address->l_name }}</b>
									</div>
									<div class="form-group">
										<i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp;&nbsp;
										<span>{{ $shipping_address->address }},</span> <br> 
										<span class="ml-22">{{ $shipping_address->postcode }} {{ $shipping_address->city }},</span> <br>
										<span class="ml-22">{{ $shipping_address->name }}</span>
									</div>
									<div class="form-group">
										<i class="fa fa-phone" aria-hidden="true"></i> &nbsp;&nbsp;
										{{ $shipping_address->phone }}
									</div>
									<div class="form-group">
										<i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;&nbsp;
										{{ $shipping_address->email }}
									</div>
								</div>
							@else
								<input type="hidden" name="billing_details_im" value="">
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6">
											<input type="text" class="form-control required-feild" placeholder="First Name *" name="f_name" value="">
										</div>
										<div class="col-sm-6">
											<input type="text" class="form-control required-feild" placeholder="Last Name *" name="l_name" value="">
										</div>
									</div>
								</div>
								<div class="form-group">
									<input type="text" class="form-control required-feild" placeholder="Email Address *" name="email" value="">
								</div>
								<div class="form-group">
									<input type="text" class="form-control required-feild" placeholder="Phone *" name="phone" value="" onkeypress="return isNumberKey(event)">
								</div>
								<div class="form-group">
									<textarea class="form-control required-feild" placeholder="Address *" name="address"></textarea>
								</div>
								<div class="form-group">
									<input type="text" name="state" class="form-control" placeholder="State *">
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-sm-6">
											<input type='text' class="form-control required-feild" placeholder="City *" name="city" value="">
										</div>
										<div class="col-sm-6">
											<input type='text' class="form-control required-feild" placeholder="Post Code*" name="postcode" value="" onkeypress="return isNumberKey(event)">
										</div>
									</div>
								</div>
								<!-- <div class="form-group">
									<textarea class="form-control" name="" placeholder="Remark"></textarea>
								</div> -->
								<div class="form-group">
									<b id="error-message" class="important-text error-message"></b>
								</div>

							@endif
							
							<hr>
							@if(!empty(request('m')) && request('m') == '1')
								<input type="hidden" name="mall" value="1">
								<div class="form-group">
									<b id="error-balance" class="important-text"></b>
								</div>
								<div class="form-group">
									<h4>
										<b>
											Your wallet balance: {{ number_format($totalBalance, 2) }}
										</b>
									</h4>
								</div>


								<div class="form-group">
									<button class="btn btn-primary btn-block placeorder-btn">
										Buy Now
									</button>
								</div>
							@else
								<div class="widget-box transparent" id="recent-box">
									<div class="widget-header">
										<h4 class="widget-title lighter smaller">
											<i class="fa fa-credit-card" aria-hidden="true"></i> Payment Method
										</h4>

										<div class="widget-toolbar no-border">
											<ul class="nav nav-tabs" id="recent-tab">
												@if(!Auth::guard('merchant')->check())
												
												<li class="parent_payment_method">
													<a data-toggle="tab" class="payment_method f-15" data-id="2" href="#cdm-tab">Bank Transfer</a>
												</li>
												@else
												<li class="parent_payment_method active">
													<a data-toggle="tab" class="payment_method f-15" data-id="3" href="#wallet-tab">Wallet</a>
												</li>
												@endif
											</ul>
										</div>
									</div>

									<div class="widget-body">
										<div class="widget-main padding-4">
											<div class="tab-content padding-8">
												@if(!Auth::guard('merchant')->check())
												<div id="online-tab" class="tab-pane active">
													
													

												<div id="cdm-tab" class="tab-pane" align="center">
													<div class="form-group">
														<!-- <select class="form-control cdm_bank_id" name="cdm_bank_id" style="width: 100%;">
															<option value="">Select Bank</option>
															@foreach($banks as $bank)
																<option value="{{ $bank->bank_code }}">
																	Bank Name: {{ $bank->bank_name }} - {{ $bank->bank_account }}
																</option>
															@endforeach
														</select> -->
														<input type="hidden" name="cdm_bank_id" value="10000743">
														<div class="card border-danger mb-3" style="max-width: 18rem;" align="center">
															<div class="card-body text-danger">
															    <h5 class="card-title">Bank holder name</h5>
															    <h5 class="card-title">Bank name</h5>
															    <p class="card-text">Bank Account</p>
															</div>
														</div>
													</div>
													<div class="form-group bank_details">

													</div>

													<input type="hidden" name="cdm">
													<div class="form-group">
														<input type="file" name="bank_slip" class="form-control" accept="image/*">
													</div>

													<div class="form-group">
														<b id="error-message-cdm-banks" class="important-text"></b>
													</div>
													
													<div class="form-group">
														<button class="btn btn-primary btn-block cdm-placeorder-btn bg-color"> Place order now </button>
													</div>

													<div class="form-group">
														<a href="{{ route('listing') }}" class="btn btn-primary btn-block bg-color"> Continue Shopping </a>
													</div>
												</div><!-- /.#member-tab -->
												@else
												<div id="wallet-tab" class="tab-pane active" align="center">
													<div class="form-group">
														<b id="error-balance" class="important-text"></b>
													</div>
													<div class="form-group">
														<h4>
															<b>
																Your wallet balance: {{ number_format($totalBalance, 2) }}
															</b>
														</h4>
													</div>
													<input type="hidden" name="wallet" value="1">
													<div class="form-group">
														<button class="btn btn-primary btn-block wallet-placeorder-btn bg-color"> Place order now </button>
													</div>
													<div class="form-group">
														<a href="{{ route('listing') }}" class="btn btn-primary btn-block bg-color"> Continue Shopping </a>
													</div>
												</div>
												@endif
											</div>
										</div><!-- /.widget-main -->
									</div><!-- /.widget-body -->
								</div><!-- /.widget-box -->
							@endif
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<button type="button" class="btn btn-primary btn-block bg-color start-modal" data-toggle="modal" data-target="#staticBackdrop" style="display: none;">
  Place order now
</button>

<div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="box-shadow: 0 2px 10px #c59868;">
      <div class="modal-header">
        <h4>
        	Add shipping address
        </h4>
     </div>
      <div class="modal-body" style="overflow: auto;">
        <form method="POST" action="{{ route('add_new_address') }}" id="add-new-address-form">
  			@csrf
  			<div class="form-group">
                @if($errors->any())
                  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
                @endif
            </div>
      		<div class="form-group">
            	<input type="text" class="form-control required-feild" placeholder="Name *" name="f_name">
            </div>
      		<div class="form-group">
				<input type="text" class="form-control required-feild" placeholder="Email *" name="email">
			</div>
			<div class="form-group">
				<input type="text" class="form-control required-feild" placeholder="Phone *" name="phone" 
					   onkeypress="return isNumberKey(event)">
			</div>
			<div class="form-group">
				<textarea class="form-control required-feild" placeholder="Address *" name="address"></textarea>
			</div>
			<div class="form-group">
				<select class="form-control" name="state">
					<option>Select State</option>
					@foreach($states as $state)
					<option value="{{ $state->id }}">{{ $state->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-6">
						<input type='text' class="form-control required-feild" placeholder="City *" name="city" value="">
					</div>
					<div class="col-6">
						<input type='text' class="form-control required-feild" placeholder="Postcode *" name="postcode" value="" onkeypress="return isNumberKey(event)">
					</div>
				</div>
			</div>
      		
            <div class="form-group">
                <div id="action-return-message"></div>
            </div>
      		
      		<div class="form-group">
	      		<button class="btn btn-primary btn-block btn-sm default_btn add-new-address-btn">
	        		Submit
	        	</button>
      		</div>
  		</form>
      </div>
     
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="popupImage">
					    <div class="modal-dialog" role="document">
						    <div class="modal-content">
							    <div class="modal-header">
							        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          		<span aria-hidden="true">&times;</span>
							        	</button>
							    </div>
							    <div class="modal-body">
							      	Error: Find our nearest agent to seek help in purchasing our products.
							    </div>
						      	<div class="modal-footer">
						      	</div>
						    </div>
						</div>
					</div>
@endsection
@section('js')
<script type="text/javascript">
	// $('.delete-cart-btn').click( function(e){
	// 	e.preventDefault();
	// 	var ele = $(this);
	// 	var cart_id = $(this).data('id');
	// 	var fd = new FormData();
	// 	fd.append('cart_id', cart_id);

	// 	if(confirm("Item(s) will be removed from Cart") == true){
	// 		$('.loading-gif').show();
			
	// 		$.ajax({
	// 	       url: '{{ route("deleteCart") }}',
	// 	       type: 'post',
	// 	       data: fd,
	// 	       contentType: false,
	// 	       processData: false,
	// 	       success: function(response){
		       		
	// 	       		$('.loading-gif').hide();
		       		
	// 	       		$.ajax({
	// 			        url: '{{ route("CountCart") }}',
	// 			        type: 'get',
	// 			        success: function(response){
	// 			        	$('.badge-cart').html(response);
	// 			        }
	// 			    });
	// 			    ele.closest('.cart-detail').remove();
		       		
	// 	       		// calc();
	// 	       },
	// 	    });			
	// 	}else{
	// 		return false;
	// 	}

	// });

	$(document).ready( function(){
            
        if($(window).width() < 480) {
            $('.order-images').removeClass('col-2');
            $('.order-images').addClass('col-3');

            $('.order-details').removeClass('col-10');
            $('.order-details').addClass('col-9');
        }else{

        }
    });
    $('#placeorder-form .required-feild').change( function(){
    	if($(this).val()){
    		$(this).removeClass('required-feild-error');
    	}
    });
	$('.placeorder-btn').click( function(e){
		e.preventDefault();
		$('.loading-gif').show();
		var empty_fill;
		var wallet_balance = '{{ $totalBalance }}';
		var grand_total = $('#hidden_grand_total').val();
		var m = '{{ request("m") }}';

		if(m == 1){
			if(wallet_balance < grand_total){
				$('#error-balance').html('Your wallet balance not enough.');
				$('.loading-gif').hide();
	    		return false;
			}
		}
		
	    $('#placeorder-form .required-feild').each( function(){
	    	if(!$(this).val()){
	    		$(this).addClass('required-feild-error');
	    		empty_fill = 1;
	    	}
	    });
	    if(empty_fill == 1){
	    	$('.error-message').html('Please Fill In All Required Field.');
	    	$('.loading-gif').hide();
	    	return false;
	    }

	    if(!m && m != 1){
		    if(!$("input[name='bank_id']:checked").val()){
		    	$('#error-message-banks').html('Please Select Bank To Continue Payment.');
		    	$('.loading-gif').hide();
		    	return false;
		    }	    	
	    }
	    

	    $('#placeorder-form').submit();
	});


	$('.cdm-placeorder-btn').click( function(e){
		e.preventDefault();
		$('.loading-gif').show();
		var empty_fill;
		var MphoneCheck;
		var phoneCheck;
	    var merchant = $('.merchant_select').val();		
		var md_state = $('input[name="merchant_billing_details_im"]').val();
		var state = $('input[name="billing_details_im"]').val();
		//if selected Merchant, get another column


		if(merchant){
			if(!md_state){
				if($.isNumeric($('input[name="m_phone"]').val()) == false){
		    		MphoneCheck = 1;
		    	}else{
		    		MphoneCheck = 0;
		    	}
				$('#placeorder-form .merchantShippingAddress .required-feild').each( function(){
					if(!$(this).val()){
			    		$(this).addClass('required-feild-error');
			    		empty_fill = 1;
			    	}
			    });	
			}
		}else{
			if(!state){
		    	if($.isNumeric($('input[name="phone"]').val()) == false){
		    		phoneCheck = 1;
		    	}else{
		    		phoneCheck = 0;
		    	}

			    $('#placeorder-form .ownShippingAddress .required-feild').each( function(){
			    	if(!$(this).val()){
			    		$(this).addClass('required-feild-error');
			    		empty_fill = 1;
			    	}

			    });
			}
		}

	    if(empty_fill == 1){
	    	$('.error-message').html('Please fill in all required field.');
	    	$('.loading-gif').hide();
	    	return false;
	    }

	    if(phoneCheck == 1){
	    	$('.error-message').html('Please field in valid phone number.');
	    	$('.phone').attr('style', 'border-color: red !important');;
	    	$('.loading-gif').hide();
	    	return false;
	    }else{
	    	$('.error-message').html('');
	    	$('.phone').attr('style', 'border-color: #c59868 !important');
	    }
	    
	    if(MphoneCheck == 1){

	    	$('.error-message').html('Please field in valid phone number.');
	    	$('.phone').attr('style', 'border-color: red !important');
	    	$('.loading-gif').hide();
	    	return false;

	    }else{
	    	$('.error-message').html('');
	    	$('.phone').attr('style', 'border-color: #c59868 !important');
	    }

	    var cdm_bank_id = $('select[name="cdm_bank_id"]').val();
		var bank_slip = $('input[name="bank_slip"]').val();
		
		if(!bank_slip){
			$('#error-message-cdm-banks').html('Please select bank & upload your bank slip to continue.');
			$('.loading-gif').hide();
			return false;
		}
		

	    $('input[name="cdm"]').val(1);

	    $('#placeorder-form').submit();
	});

	$('.wallet-placeorder-btn').click( function(e){
		e.preventDefault();
		$('.loading-gif').show();
		var empty_fill;
		var MphoneCheck;
		var phoneCheck;
	    var merchant = $('.merchant_select').val();
		var md_state = $('input[name="merchant_billing_details_im"]').val();
		var state = $('input[name="billing_details_im"]').val();

	    var customer_address = $('.customer_address').prop('checked');
		//if selected Merchant, get another column


		if(customer_address == true){
			
		}else{
			if(!state){
		    	if($.isNumeric($('input[name="phone"]').val()) == false){
		    		phoneCheck = 1;
		    	}else{
		    		phoneCheck = 0;
		    	}

			    $('#placeorder-form .ownShippingAddress .required-feild').each( function(){
			    	if(!$(this).val()){
			    		$(this).addClass('required-feild-error');
			    		empty_fill = 1;
			    	}

			    });
			}
		}

	    if(empty_fill == 1){
	    	$('.error-message').html('Please fill in all required field.');
	    	$('.loading-gif').hide();
	    	return false;
	    }

	    if(phoneCheck == 1){
	    	$('.error-message').html('Please field in valid phone number.');
	    	$('.phone').attr('style', 'border-color: red !important');;
	    	$('.loading-gif').hide();
	    	return false;
	    }else{
	    	$('.error-message').html('');
	    	$('.phone').attr('style', 'border-color: #c59868 !important');
	    }
	    
	    if(MphoneCheck == 1){

	    	$('.error-message').html('Please field in valid phone number.');
	    	$('.phone').attr('style', 'border-color: red !important');
	    	$('.loading-gif').hide();
	    	return false;

	    }else{
	    	$('.error-message').html('');
	    	$('.phone').attr('style', 'border-color: #c59868 !important');
	    }

	    var GrandTotal = $('#hidden_grand_total').val();
	    var Balance = '{{ $totalBalance }}';
		
		if(parseFloat(Balance) < parseFloat(GrandTotal)){
			$('.loading-gif').hide();
			$('#error-balance').html('Insufficient balance');
			return false;
		}

	    $('input[name="wallet"]').val(1);
	    if(confirm('Confirm payment for using wallet balance of '+GrandTotal+'?') == true){
	    	$('#placeorder-form').submit();
	    }else{
	    	$('.loading-gif').hide();
	    }
	});

	$('.apply-discount').click( function(e){
		e.preventDefault();
		
		var discount_code = $('.discount-code').val();
		if(discount_code){
			$('.loading-gif').show();
			var fd = new FormData();
			fd.append('discount_code', discount_code);
			fd.append('checkout_apply', '1');

			$.ajax({
		       url: '{{ route("ApplyPromo") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){
		       		$('.loading-gif').hide();
		       		
		       		// alert(response);
		       		// return false;
		       		if(response == 0){
		    			$('.error-message-promo').html('Invalid promotion code');
		    			return false;
		       		}else if(response == 1){
						$('.error-message-promo').html('This promotion code has run out of limit');
		    			return false;
		       		}else if(response == 2){
						$('.error-message-promo').html('This Code Not In Promotion Date Range');
		    			return false;
		       		}else if(response == 3){
						$('.error-message-promo').html('Your cart does not meet the requirements Promotion Code: '+discount_code+'.');
		    			return false;		       			
		       		}else if(response == 4){
						$('.error-message-promo').html('Opps! Today You run out of yours promotion code limit.');
		    			return false;		       			
		       		}else if(response == 5){
						$('.error-message-promo').html('Opps! You run out of yours promotion code limit.');
		    			return false;		       			
		       		}else{
		       			location.reload();
		       			if(response[1] == 'Percentage'){
		       				var total = $('#subtotal').val() * response[0] / 100;
		       				var grand_total = $('#subtotal').val() - total;
		       				var shipping_fee = $('.hidden_shipping_amount').val();

		       				$('.discount_word').html('Discount ('+response[0]+'%)');
		       				$('.discount_amount').html('- RM '+parseFloat(total).toFixed(2));
		       				$('.hidden_discount').val(parseFloat(total).toFixed(2));

		       				if($('.payment_method.active').data('id') == '2'){
		       					// $('.processing_amount').html('RM 0.00');
			       				$('.grand-total').html('RM '+parseFloat((parseFloat(grand_total) + parseFloat(shipping_fee))).toFixed(2));
			       				$('#hidden_grand_total').val(parseFloat((parseFloat(grand_total) + parseFloat(shipping_fee))).toFixed(2));
		       				}else{
			       				// $('.processing_amount').html('RM '+parseFloat((parseFloat(grand_total) + parseFloat(shipping_fee)) * 1.6 / 100).toFixed(2));
			       				$('.grand-total').html('RM '+parseFloat((parseFloat(grand_total) + parseFloat(shipping_fee))).toFixed(2));
			       				$('#hidden_grand_total').val(parseFloat((parseFloat(grand_total) + parseFloat(shipping_fee))).toFixed(2));
		       					
		       				}

		       				$('#code').val(response[2]);
		       				$('#totalDiscount').val(total);
		       			}else{
		       				var total = response[0];
		       				var shipping_fee = $('.hidden_shipping_amount').val();
		       				var grand_total = parseFloat($('#subtotal').val()) + parseFloat(shipping_fee) - total;
		       				
		       				$('.discount_word').html('Discount: ');
		       				if(grand_total <= 0){

			       				$('.discount_amount').html('RM '+parseFloat(total).toFixed(2));
			       				$('.hidden_discount').val(parseFloat(total).toFixed(2));

			       				if($('.payment_method.active').data('id') == '2'){

			       					$('.grand-total').html('RM '+parseFloat(shipping_fee).toFixed(2));
			       					$('.processing_amount').html('RM 0.00');
				       				$('.hidden_processing_amount').val(0);
			       					$('#hidden_grand_total').val(shipping_fee);

			       				}else{

			       					// $('.processing_amount').html('RM '+parseFloat(parseFloat(shipping_fee) * 1.6 / 100).toFixed(2));
				       				// $('.hidden_processing_amount').val(parseFloat(parseFloat(shipping_fee) * 1.6 / 100).toFixed(2));

			       					$('.grand-total').html('RM '+parseFloat(parseFloat(shipping_fee)).toFixed(2));
			       					$('#hidden_grand_total').val(parseFloat(parseFloat(shipping_fee)).toFixed(2));

			       				}
		       				}else{
		       					if($('.payment_method.active').data('id') == '2'){
				       				$('.discount_amount').html('- RM '+parseFloat(total).toFixed(2));
				       				$('.hidden_discount').val(parseFloat(total).toFixed(2));
				       				$('.processing_amount').html('RM 0.00');
				       				$('.hidden_processing_amount').val(0);
				       				$('.grand-total').html('RM '+parseFloat(grand_total).toFixed(2));
				       				$('#hidden_grand_total').val(parseFloat(grand_total).toFixed(2));

		       					}else{
									$('.discount_amount').html('- RM '+parseFloat(total).toFixed(2));
				       				$('.hidden_discount').val(parseFloat(total).toFixed(2));
				       				// $('.processing_amount').html('RM '+parseFloat(parseFloat(grand_total) * 1.6 / 100).toFixed(2));
				       				// $('.hidden_processing_amount').val(parseFloat(parseFloat(grand_total) * 1.6 / 100).toFixed(2));
				       				$('.grand-total').html('RM '+parseFloat(parseFloat(grand_total)).toFixed(2));
				       				$('#hidden_grand_total').val(parseFloat(parseFloat(grand_total)).toFixed(2));
		       					}
		       				}

		       				$('#code').val(response[2]);
		       				$('#totalDiscount').val(total);

		       			}
		       			$('.close-modal').click();
		       			$('.modal-backdrop').remove();
		       			$('.modal-open').css('overflow', 'auto');
		    //    			$(function () {
						//    $('#applyPromotion').modal('hide');
						// });
		       			$('.success-message-promo').html('Applied Successfully - '+response[5]+'('+response[4]+') <a href="#" class="remove-applied-promo pull-right" data-id="'+response[3]+'">Remove</a>');
		       			$('.promotion-field').remove();
		       		}
		       },
		    });
		}else{
			$('.error-message-promo').html('Please fill in Promotion Code / Discount Code / Voucher Code.');
			return false;
		}
	});


	$('.cdm_bank_id').change( function(){
		var ele = $(this);

		var fd = new FormData();
			fd.append('bank_id', ele.val());
			
		$.ajax({
		       url: '{{ route("getBankDetails") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){
		       		if(response == 0){
		       			$('.bank_details').html('');
		       		}else{
		       			$('.bank_details').html('Bank name: '+response[0]+'<br>'+'Bank account: '+response[1]+'<br> Bank holder name: '+response[2]);
		       		}
		       }
		});
	});

	$('.payment_method').click( function(e){
		e.preventDefault();

		var ele = $(this);
		var total = $('#hidden_grand_total').val();
		var sub = $('#subtotal').val();
		var shipping_fee = $('.hidden_shipping_amount').val();
		var discount = $('.hidden_discount').val();

		$('.parent_payment_method').removeClass('active');
		ele.parent().addClass('active');

		discount = (discount) ? discount : 0;
		total = parseFloat(sub) + parseFloat(shipping_fee) - parseFloat(discount);

		if(ele.data('id') == 1){
			$("input[name='online']").val(1);
			$("input[name='cdm']").val(0);

			if(total <= 0){
				// $('.processing_amount').html('RM '+parseFloat(shipping_fee * 1.6 / 100).toFixed(2));
				// $('.hidden_processing_amount').val(parseFloat(shipping_fee * 1.6 / 100).toFixed(2));

				$('#hidden_grand_total').val((parseFloat(shipping_fee)));
				$('.grand-total').html('RM '+(parseFloat(shipping_fee)).toFixed(2));
			}else{
				// $('.processing_amount').html('RM '+parseFloat(total * 1.6 / 100).toFixed(2));
				// $('.hidden_processing_amount').val(parseFloat(total * 1.6 / 100).toFixed(2));

				$('#hidden_grand_total').val((parseFloat(total)).toFixed(2));
				$('.grand-total').html('RM '+(parseFloat(total)).toFixed(2));
				
			}

		}else{

			$('.processing_amount').html('RM 0.00');
			$('.hidden_processing_amount').val('0.00');
			if(total <= 0){
				$('#hidden_grand_total').val(shipping_fee);
				$('.grand-total').html('RM '+parseFloat(shipping_fee).toFixed(2));
			}else{
				$('#hidden_grand_total').val((parseFloat(sub) - parseFloat(discount) + parseFloat(shipping_fee)).toFixed(2));
				$('.grand-total').html('RM '+(parseFloat(sub) - parseFloat(discount) + parseFloat(shipping_fee)).toFixed(2));				
			}



			$("input[name='online']").val(0);
			if(ele.data('id') == 3){
				$("input[name='wallet']").val(1);
				$("input[name='cdm']").val(0);
			}else{
				$("input[name='wallet']").val(0);
				$("input[name='cdm']").val(1);
			}
		}
		
	});

	$('.success-message-promo').on('click', '.remove-applied-promo', function(e){
		e.preventDefault();

		var ele = $(this);

		var fd = new FormData();
			fd.append('id', ele.data('id'));
		if(confirm("Confirm remove this promotion code?") == true){
			$.ajax({
			       url: '{{ route("removePromotion") }}',
			       type: 'post',
			       data: fd,
			       contentType: false,
			       processData: false,
			       success: function(response){
			       		location.reload();
			       }
			});			
		}
	});

	$('.delete-cart-btn').click( function(e){
		e.preventDefault();
		var ele = $(this);
		var cart_id = $(this).data('id');
		var fd = new FormData();
		fd.append('cart_id', cart_id);
		
		if(confirm("Item(s) will be removed from Cart") == true){
			$('.loading-gif').show();
			$.ajax({
		       url: '{{ route("deleteCart") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){
		       		$('.loading-gif').hide();
		       		$.ajax({
				        url: '{{ route("CountCart") }}',
				        type: 'get',
				        success: function(response){
				        	
				        	$('.cart_count span').html(response[0]);
				        	$('.cart_price').html('RM '+parseFloat(response[1]).toFixed(2));
				        }
				    });
			        ele.closest('.cart-detail').remove();
			        var check = $('.container-box .cart-detail').length;
		       		
			        if(check == 0){
			        	window.location.href = "{{ route('listing') }}";
			        }else{
			        	location.reload();
			        }
		       },
		    });			
		}
		
	});

	$('.change-login-register-tab').click( function(e){
		e.preventDefault();
		var ele = $(this);
		$('.rl-tab').removeClass('show active');
		$(ele.attr('href')).addClass('show active');
		// alert(ele.parent().parent().('class'));
	});

	$('.continue-as-guess').click( function(e){
		$('.loading-gif').show();
		$.ajax({
	        url: '{{ route("setNewGuest") }}',
	        type: 'get',
	        success: function(response){
	        	$('.loading-gif').hide();
	        	location.reload();
	        }
	    });
	});

	$('#login-form .button-inside').on('click', '.get-verify-code-btn', function(e){
        e.preventDefault();
        var ele = $(this);
        var phone = $('#login-form input[name="phone"]').val();
        if(phone.length < 10){
            alert("Please enter a valid mobile phone number");
            return false;
        }

        var fd = new FormData();
        fd.append('phone', phone);

        $.ajax({
            url: '{{ route("getVerifyCode") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response == '1'){
                    alert('Phone number does not exist');
                    return false;
                }else{
                    ele.prop('disabled', true);
                    
                    $('#login-form #action-return-message').html('The verification code has been sent to your mobile phone, the input is valid within 10 minutes, please do not leak');

                    $('#login-form #action-return-message').addClass('important-text');

                    var timer2 = response[1];
                    // var timer2 = "0:03";
                    var interval = setInterval(function() {


                    var timer = timer2.split(':');
                    //by parsing integer, I avoid all extra string processing
                    var minutes = parseInt(timer[0], 10);
                    var seconds = parseInt(timer[1], 10);
                    --seconds;
                    minutes = (seconds < 0) ? --minutes : minutes;
                    seconds = (seconds < 0) ? 59 : seconds;
                    seconds = (seconds < 10) ? '0' + seconds : seconds;
                    //minutes = (minutes < 10) ?  minutes : minutes;
                    if (minutes == '0' && seconds == '00'){
                        clearInterval(interval);
                        var fd = new FormData();
                        fd.append('phone', phone);
                        $.ajax({
                            url: '{{ route("resetVerifyCode") }}',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            success: function(response){
                                ele.html("Get Verify Code");
                                ele.prop('disabled', false);
                                $('#login-form #action-return-message').html('The verification code has been refreshed! Please click "Get Verification Code" to get the latest verification code!');
                            }
                        });
                    }

                    ele.html(minutes + ':' + seconds);

                    timer2 = minutes + ':' + seconds;
                    }, 1000);                            
                }
            },
        });
    });

    $('.login-btn').click( function(e){
       e.preventDefault();
       $('.loading-gif').show();
       // $('input[name="password"]').val(phone);
       $('#login-form').submit();
       // var phone = $('#login-form input[name="phone"]').val();
       // var code = $('#login-form input[name="code"]').val();
       // var country_code = $('#login-form .country_code').val();

       // if(!phone){
       //      $('#action-return-message').addClass('important-text');
       //      $('#action-return-message').html("Please enter phone number");
       //      $('.loading-gif').hide();
       //      return false;
       // }else{
       //    if(phone.length < 10){
       //          $('#action-return-message').addClass('important-text');
       //          $('#action-return-message').html("Please enter a valid mobile phone number");
       //          $('.loading-gif').hide();
       //          return false;
       //    }
       // }

       // if(!code){
       //      $('#action-return-message').addClass('important-text');
       //      $('#action-return-message').html("Please enter a valid verification code");
       //      $('.loading-gif').hide();
       //      return false;
       // }



       // var fd = new FormData();
       // fd.append('phone', phone);
       // fd.append('code', code);
       // fd.append('country_code', country_code);

       // $.ajax({
       //      url: '{{ route("CheckLogin") }}',
       //      type: 'post',
       //      data: fd,
       //      contentType: false,
       //      processData: false,
       //      success: function(response){
       //          // alert(response);
       //          if(response == 1){
       //              $('#action-return-message').html("Verification code error");
       //              $('#action-return-message').addClass('important-text');
       //              $('.loading-gif').hide();
       //              return false;
       //          }else if(response == 2){
       //              $('#action-return-message').html("Phone number does not exist");
       //              $('#action-return-message').addClass('important-text');
       //              $('.loading-gif').hide();
       //          }else{
       //              // $('input[name="password"]').val(phone);
       //              $('#login-form').submit();
       //          }
       //      },
       //  }); 
    });


    $('#register-form .button-inside').on('click', '.get-verify-code-btn', function(e){
        e.preventDefault();
        var ele = $(this);
        var phone = $('#register-form input[name="phone"]').val();
        if(phone.length < 10){
            alert("Please enter a valid mobile phone number");
            return false;
        }

        var fd = new FormData();
        fd.append('phone', phone);
        fd.append('register', '1');

        $.ajax({
            url: '{{ route("getVerifyCode") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response == '1'){
                    alert('Phone number does not exist');
                    return false;
                }else{
                    ele.prop('disabled', true);
                    
                    $('#register-form #action-return-message').html('The verification code has been sent to your mobile phone, the input is valid within 10 minutes, please do not leak');

                    $('#register-form #action-return-message').addClass('important-text');

                    var timer2 = response[1];
                    // var timer2 = "0:03";
                    var interval = setInterval(function() {


                    var timer = timer2.split(':');
                    //by parsing integer, I avoid all extra string processing
                    var minutes = parseInt(timer[0], 10);
                    var seconds = parseInt(timer[1], 10);
                    --seconds;
                    minutes = (seconds < 0) ? --minutes : minutes;
                    seconds = (seconds < 0) ? 59 : seconds;
                    seconds = (seconds < 10) ? '0' + seconds : seconds;
                    //minutes = (minutes < 10) ?  minutes : minutes;
                    if (minutes == '0' && seconds == '00'){
                        clearInterval(interval);
                        var fd = new FormData();
                        fd.append('phone', phone);
                        $.ajax({
                            url: '{{ route("resetVerifyCode") }}',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            success: function(response){
                                ele.html("Get Verify Code");
                                ele.prop('disabled', false);
                                $('#register-form #action-return-message').html('The verification code has been refreshed! Please click "Get Verification Code" to get the latest verification code!');
                            }
                        });
                    }

                    ele.html(minutes + ':' + seconds);

                    timer2 = minutes + ':' + seconds;
                    }, 1000);                            
                }
            },
        });
    });


    $('.register-btn').click( function(e){
       e.preventDefault();

       // $('input[name="password"]').val(phone);
       // $('#register-form').submit();
       var empty_fill;
       var phone = $('#register-form input[name="phone"]').val();
       var code = $('#register-form input[name="code"]').val();
       var country_code = $('#register-form .country_code').val();
       // var refferal_code = $('input[name="refferal_code"]').val();

       $('#register-form .required-feild').each( function(){
            if(!$(this).val()){
                $(this).addClass('required-feild-error');
                empty_fill = 1;
            }
        });
        if(empty_fill == 1){
            $('.error-message').html('Please Fill In All Required Field.');
            $('.loading-gif').hide();
            return false;
        }

       if(!phone){
            $('#action-return-message').addClass('important-text');
            $('#action-return-message').html("Please enter phone number");
            return false;
       }else{
          if(phone.length < 10){
                $('#action-return-message').addClass('important-text');
                $('#action-return-message').html("Please enter a valid mobile phone number");
                return false;
          }
       }

       if(!code){
            $('#action-return-message').addClass('important-text');
            $('#action-return-message').html("Please enter a valid verification code");

            return false;
       }



       var fd = new FormData();
       fd.append('phone', phone);
       fd.append('code', code);
       fd.append('country_code', country_code);
       // fd.append('refferal_code', refferal_code);

       $.ajax({
            url: '{{ route("CheckLogin") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response == 1){
                    $('#register-form #action-return-message').html("Verification code error");
                    $('#register-form #action-return-message').addClass('important-text');
                    return false;
                }else if(response == 2){
                    // $('input[name="password"]').val(phone);
                    $('#register-form').submit();
                }else if(response == 3){
                    $('#register-form #action-return-message').html("Account exists");
                    $('#register-form #action-return-message').addClass('important-text');
                }else if(response == 4){
                    $('#register-form #action-return-message').html("Referrer's mobile phone number does not exist");
                    $('#register-form #action-return-message').addClass('important-text');
                }else{
                    $('#register-form #action-return-message').html("System error");
                    $('#register-form #action-return-message').addClass('important-text');
                }
            },
        }); 
    });

    $('.claim-voucher').click( function(e){
        e.preventDefault();
        var ele = $(this);
		$('.discount-code').val(ele.data('id'));
        $('.apply-discount').click();
        
    });

    $('.create-cart-link').click(function(e){
    	e.preventDefault();

    	$.ajax({
            url: '{{ route("CreateCartLink") }}',
            type: 'get',
            success: function(response){
            	var url = "{{ route('home', 'l=:id') }}";
            		url = url.replace(':id', response);
            	// alert(url);
            	$('.create_link_id').val(url);
                var copyText = document.getElementById("create_link_id");
				    copyText.select();
				    copyText.setSelectionRange(0, 99999)
				    document.execCommand("copy");

				toastr.success('Link Copied');
				window.location.href = "{{ route('home') }}";
            },
        });
    	
    });
</script>

@if(empty($shipping_address->id))
<script type="text/javascript">
	$('.start-modal').click();
</script>
@endif

@if(!empty(Session::get('cart_link_id')))
<script type="text/javascript">
    function ProceedCartLink()
    {
    	$.ajaxSetup({
	          headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });

        var checkLogin = "{{ Auth::guard($data['userGuardRole'])->check() }}";
        var fd = new FormData();
            fd.append('link_id', '{{ request("l") }}');

        $.ajax({
            url: '{{ route("ProceedCartLink") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
            	
            },
        });
    }
    ProceedCartLink();
</script>
@endif
@endsection