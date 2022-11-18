@extends('layouts.app')

@section('content')
<div class="profile-own-bg">
	<div class="personal-header-info">
			<div class="container">
				<div class="row">
					<div class="col-4" align="left">
						<a href="{{ route('profile') }}">
							<p style="color: white;"><i class="fa fa-chevron-left"></i> Back</p>
						</a>
					</div>
					<div class="col-4" align="left">
						<p align="center" class="header-title">My orders</p>
					</div>
					<div class="col-4" align="right">
						<a href="{{ route('my_setting') }}" class="setting-btn">
							<i class="fa fa-cog" style="font-size: 20px;"></i>
						</a>
					</div>
				</div>
			</div>

		<div class="container">
			<div class="form-group">
				<div class="row">
					<div class="col-2">
						@if(!empty(Auth::user()->profile_logo))
							<!-- <img src="{{ url(Auth::user()->profile_logo) }}" width="50" class="profile-logo"> -->
							<div style="background-image: url({{ url(Auth::user()->profile_logo) }}); width: 50px; height: 50px; border-radius: 100%; background-size: 100%; background-position: center; background-repeat: no-repeat;"></div>
						@else
							<img src="{{ url('images/images.png') }}" width="50" class="profile-logo">
						@endif
					</div>
					<div class="col-6">
						&nbsp;
						<b class="profile-name">{{ Auth::user()->f_name }} {{ Auth::user()->l_name }}</b>
						<br>
						&nbsp;
						<small class="profile-code">Code: {{ Auth::user()->code }}</small>
						<br>
						&nbsp;
						<small class="profile-level">Level: {{ !empty($lvl) ? $lvl : ' - ' }}</small>
					</div>
					<!-- <div class="col-4" align="right">
						<a href="#">
							<i class="fa fa-pencil"></i> Edit Profile
						</a>

					</div> -->
				</div>
			</div>
			@if(Auth::guard('merchant')->check())
				<div class="form-group container-box sl-personal-header">
					<div class="row">
						<div class="col-6" align="center">
							<a href="{{ route('myqrcode') }}">
								<img src="{{ url('images/qrcode.png') }}" width="30">
								<br>
								<span class="profile-word">My QRcode</span>
							</a>
						</div>

						<!-- <div class="col-4" align="center">
							<a href="{{ route('MyAffiliate', Auth::user()->code) }}">
								<img src="{{ url('images/profile/585e4d1ccb11b227491c339b.png') }}" width="30">
								<br>
								<span class="profile-word">My Team</span>
							</a>
						</div> -->

						<div class="col-6" align="center">
							<a href="{{ route('wallet') }}">
								<img src="{{ url('images/profile/c3286d4d32fa90ebcf09b488654612b9-wallet-icon-by-vexels.png') }}" width="30">
								<br>
								<span class="profile-word">My Wallet</span>
							</a>
						</div>
					</div>
				</div>
			@else
				<div class="form-group container-box sl-personal-header">
					<div class="row">
						<div class="col-4" align="center">
							<a href="{{ route('myqrcode') }}">
								<img src="{{ url('images/qrcode.png') }}" width="30">
								<br>
								<span class="profile-word">My QRcode</span>
							</a>
						</div>

						<div class="col-4" align="center">
							<a href="{{ route('MyAffiliate', Auth::user()->code) }}">
								<img src="{{ url('images/profile/585e4d1ccb11b227491c339b.png') }}" width="30">
								<br>
								<span class="profile-word">My Team</span>
							</a>
						</div>

						<div class="col-4" align="center">
							<a href="{{ route('wallet') }}">
								<img src="{{ url('images/profile/c3286d4d32fa90ebcf09b488654612b9-wallet-icon-by-vexels.png') }}" width="30">
								<br>
								<span class="profile-word">My Wallet</span>
							</a>
						</div>
					</div>
				</div>
			@endif
		</div>
	</div>
</div>
<div class="profile-content">
	<div class="container">
		<div class="form-group">
			<div class="row">
				<div class="col-sm-12 myOrder-list">
					<div class="form-group container-box">
						<div class="row">
							<div class="col-6">
								<b>Order: #{{ $transaction->transaction_no }}</b><br>
								Place On: {{ $transaction->created_at }}<br>
								@if($transaction->mall == 1)
									Payment Method: Wallet
								@else
									Payment Method: {{ (!empty($transaction->cdm_bank_id)) ? 'Bank Transfer' : 'Online Banking' }}
								@endif
							</div>
							<div class="col-6" align="right">
								<h4>Total: RM {{ number_format($transaction->grand_total, 2) }}</h4>
							</div>
						</div>
					</div>
					<div class="form-group container-box">
						@if($transaction->customer_address == 1)
							<div class="form-group">
								<h4>
									<b>Customer Shipping Address</b>
								</h4>
							</div>
							<div class="form-group">
								{{ $transaction->c_address_name }} <br><br>
								{{ $transaction->c_address }}, <br>
								{{ $transaction->c_postcode }} {{ $transaction->c_city }}, <br>
								{{ $transaction->c_state }}<br><br>
								{{ $transaction->c_phone }}
							</div>
						@else
							<div class="form-group">
								<h4>
									<b>Shipping Address</b>
								</h4>
							</div>
							<div class="form-group">
								{{ $transaction->address_name }} <br><br>
								{{ $transaction->address }}, <br>
								{{ $transaction->postcode }} {{ $transaction->city }}, <br>
								{{ $transaction->state }}<br><br>
								{{ $transaction->phone }}
							</div>
						@endif
					</div>
					<div class="form-group container-box">
						@foreach($details as $detail)
						@php
						$image = (!empty($detail->product_image)) ? $detail->product_image : 'images/no-image-available-icon-6.jpg';
						@endphp
						<div class="form-group">
							<div class="row">
								<div class="col-sm-1" align="">
									<div class="from-group">
										<img src="{{ url($image) }}" style="width: 70px;">
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-group product-details">
										<b>{{ $detail->product_name }}</b> <br>
										{!! ($detail->sub_category != '') ? "Variation: ".$detail->sub_category."<br>" : '' !!}
										{!! ($detail->second_sub_category != '') ? "R: ".$detail->second_sub_category."<br>" : '' !!}
										Qty: {{ $detail->quantity }}<br>
										Price: RM {{ number_format($detail->unit_price, 2) }}
									</div>
								</div>
								<div class="col-sm-4">
									@if($transaction->status == 99)
										<span class="badge badge-pill badge-warning">Unpaid</span>
									@elseif($transaction->status == 98)
										<span class="badge badge-pill badge-info">Waiting for verify</span>
									@elseif($transaction->status == 97)
										<span class="badge badge-pill badge-info">In-progress</span>
									@elseif($transaction->status == '96')
										<span class="badge badge-danger">Rejected</span>
									@elseif($transaction->status == 1)
										<span class="badge badge-success">Paid</span>
									@else
										<span class="badge badge-pill badge-danger">Cancelled</span>
									@endif
								</div>
							</div>
						</div>
						<hr>
						@endforeach
					</div>
					<div class="form-group">
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group container-box" style="height: 260px;">
								<div class="form-group">
									<h4>
										<b>Bank Slip</b>
									</h4>
								</div>

								@if(!empty($transaction->bank_slip))
									<a href="#" data-toggle="modal" data-target="#exampleModal">
										<img src="{{ url($transaction->bank_slip) }}" width="150px" height="150px">
									</a>

									<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
									  	<div class="modal-dialog">
									    	<div class="modal-content">
									      		<div class="modal-header">
									        		<!-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> -->
									        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									          			<span aria-hidden="true">&times;</span>
									        		</button>
									      		</div>
										      	<div class="modal-body">
										        	<img src="{{ url($transaction->bank_slip) }}" width="100%">
										      	</div>
										      	<!-- <div class="modal-footer">
										        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										      	</div> -->
									    	</div>
									  	</div>
									</div>
								@else
									<h5>No Bank Slip</h5>
								@endif
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group container-box">
								<div class="form-group">
									<h4>
										<b>Total Summary</b>
									</h4>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-6">
											Subtotal: 
										</div>
										<div class="col-6" align="right">
											RM {{ number_format(str_replace(',', '', $transaction->grand_total) - $transaction->shipping_fee - $transaction->processing_fee + $transaction->discount, 2) }}
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col-6">
											Shipping Fee: 
										</div>
										<div class="col-6" align="right">
											RM {{ number_format($transaction->shipping_fee, 2) }}
										</div>
									</div>
								</div>
								@if(!empty($transaction->ad_discount))
								<div class="form-group">
				                    <div class="row">
				                        <div class="col-6">
				                            Additional Discount: 
				                        </div>
				                        <div class="col-6" align="right">
				                            - RM {{ number_format($transaction->ad_discount, 2) }}
				                        </div>
				                    </div>
				                </div>
				                @endif

								<div class="form-group">
				                    <div class="row">
				                        <div class="col-6">
				                            Discount({{ ($transaction->amount_type == 'Percentage') ? $transaction->discount_amount."%" : 'RM '.$transaction->discount_amount }}): 
				                        </div>
				                        <div class="col-6" align="right">
				                            - RM {{ number_format($transaction->discount, 2) }}
				                        </div>
				                    </div>
				                </div>

								<!-- <div class="form-group">
				                    <div class="row">
				                        <div class="col-6">
				                            Processing Fee: 
				                        </div>
				                        <div class="col-6" align="right">
				                            RM {{ number_format($transaction->processing_fee, 2) }}
				                        </div>
				                    </div>
				                </div> -->
								<hr>
								<div class="form-group">
									<div class="row">
										<div class="col-6">
											Grand Total: 
										</div>
										<div class="col-6" align="right">
											RM {{ number_format($transaction->grand_total, 2) }}
										</div>
									</div>
								</div>
							</div>					
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection