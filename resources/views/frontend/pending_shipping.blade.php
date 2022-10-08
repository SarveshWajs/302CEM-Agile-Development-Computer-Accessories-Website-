@extends('layouts.app')
@section('css')
<style type="text/css">
	.col-2{
		-ms-flex: 0 0 16.666667%;
	    flex: 0 0 20%;
	    max-width: 20%;
	}
</style>
@endsection
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
						<p align="center" class="header-title">My Order</p>
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
						<a href="{{ route('my_setting') }}">
							@if(!empty(Auth::user()->profile_logo))
								<!-- <img src="{{ url(Auth::user()->profile_logo) }}" width="50" class="profile-logo"> -->
								<div style="background-image: url({{ url(Auth::user()->profile_logo) }}); width: 50px; height: 50px; border-radius: 100%; background-size: 100%; background-position: center; background-repeat: no-repeat;"></div>
							@else
								<img src="{{ url('images/images.png') }}" width="50" class="profile-logo">
							@endif							
						</a>
					</div>
					<div class="col-6">
						&nbsp;
						<b class="profile-name">{{ Auth::user()->f_name }} {{ Auth::user()->l_name }}</b>
						<br>
						&nbsp;
						<small class="profile-code">Code: {{ Auth::user()->code }}</small>
						
						
					</div> 
				</div>
			</div>
			<br>
			
			
		</div>
	</div>
</div>

<div class="profile-content">
	<div class="container">
		<div class="form-group container-box">
			<div class="row justify-content-center">
				<div class="col-2" align="center">
					<a href="{{ route('pending_order') }}" style="position: relative;">
						@if($countPending > 0)
						<span class="badge badge-pill badge-danger" style="position: absolute; right: -10px; top: -10px;">
							{{ $countPending }}
						</span>
						@endif
						<img src="{{ url('images/profile/JD-01-512.png') }}" width="30">
						<br>
						<span class="profile-word">{{ isset($data['lang']['lang']['pending_payment']) ? $data['lang']['lang']['pending_payment'] : 'To Pay' }}</span>
					</a>
				</div>

				<div class="col-2" align="center">
					<a href="{{ route('pending_shipping') }}" style="position: relative;">
						@if($countToShip > 0)
						<span class="badge badge-pill badge-danger" style="position: absolute; right: -10px; top: -10px;">
							{{ $countToShip }}
						</span>
						@endif
						<img src="{{ url('images/profile/shipment_pending_1017207.png') }}" width="30">
						<br>
						<span class="profile-word" style="font-weight: bold; text-decoration: underline;">{{ isset($data['lang']['lang']['to_be_delivered']) ? $data['lang']['lang']['to_be_delivered'] : 'To Ship' }}</span>
					</a>
				</div>

				<div class="col-2" align="center">
					<a href="{{ route('pending_receive') }}" style="position: relative;">
						@if($countToReceive > 0)
						<span class="badge badge-pill badge-danger" style="position: absolute; right: -10px; top: -10px;">
							{{ $countToReceive }}
						</span>
						@endif
						<img src="{{ url('images/profile/Pending-Truck-Delivery-Commerce-Logistic-Transportation-512.png') }}" width="30">
						<br>
						<span class="profile-word">{{ isset($data['lang']['lang']['to_be_received']) ? $data['lang']['lang']['to_be_received'] : 'To Receive' }}</span>
					</a>
				</div>

				<div class="col-2" align="center">
					<a href="{{ route('completed_order') }}" style="position: relative;">
						@if($countCompleted > 0)
						<span class="badge badge-pill badge-danger" style="position: absolute; right: -10px; top: -10px;">
							{{ $countCompleted }}
						</span>
						@endif
						<img src="{{ url('images/profile/Box_Package_Delivery_Shipping_Complete_Check_Done-512.png') }}" width="30">
						<br>
						<span class="profile-word">{{ isset($data['lang']['lang']['completed']) ? $data['lang']['lang']['completed'] : 'Completed' }}</span>
					</a>
				</div>

				<div class="col-2" align="center">
					<a href="{{ route('cancelled_order') }}" style="position: relative;">
						@if($countCancelled > 0)
						<span class="badge badge-pill badge-danger" style="position: absolute; right: -10px; top: -10px;">
							{{ $countCancelled }}
						</span>
						@endif
						<img src="{{ url('images/profile/online_shop_ecommerce_shopping-46-512.png') }}" width="30">
						<br>
						<span class="profile-word">{{ isset($data['lang']['lang']['cancelled']) ? $data['lang']['lang']['cancelled'] : 'Cancelled' }}</span>
					</a>
				</div>
			</div>
		</div>

		<div class="myOrder-list">
			
				@if (!$transactions->isEmpty() || $CountTotal != 0)
				@foreach($transactions as $transaction)
				@if(isset($ship_details[$transaction->id]) && ($ship_details[$transaction->id] == 'Schedule In Arrangement' || 
									$ship_details[$transaction->id] == 'Pending for Drop Off') || empty($transaction->tracking_no))
				<div class="form-group container-box">
					<div class="row">
						<div class="col-6 order-no-details">
							<b>{{ isset($data['lang']['lang']['order_no']) ? $data['lang']['lang']['order_no'] : 'Order no' }}: #{{ $transaction->transaction_no }}</b><br>
							   {{ isset($data['lang']['lang']['order_dates']) ? $data['lang']['lang']['order_dates'] : 'Order date' }}: {{ $transaction->created_at }}
							@if(!empty($transaction->awb_no))
							<br>
							Tracking No: <a onclick="linkTrack('{{ $transaction->awb_no }}')">{{ $transaction->awb_no }}</a>
							<button onclick="linkTrack('{{ $transaction->awb_no }}')">TRACK</button>
							<script src="//www.tracking.my/track-button.js"></script>
							<script>
							  function linkTrack(num) {
							    TrackButton.track({
							      tracking_no: num
							    });
							  }
							</script>
							@endif
						</div>
						<div class="col-6" align="right">
							@if($transaction->status == 99)
								<a href="#" class="btn btn-primary btn-sm pay-now-button" data-id="{{ md5($transaction->id) }}" data-toggle="modal" data-target="#myModal">
									{{ isset($data['lang']['lang']['pay_now']) ? $data['lang']['lang']['pay_now'] : 'Pay now' }}
								</a>
							@else
								<a href="{{ route('order_detail', $transaction->transaction_no) }}" class="btn btn-primary btn-sm pay-now-button">
									{{ isset($data['lang']['lang']['Manage']) ? $data['lang']['lang']['Manage'] : 'Manage' }}
								</a>
							@endif
						</div>
					</div>
					<hr>
					@foreach($details[$transaction->id] as $detail)
					@php
					$image = (!empty($detail->product_image)) ? $detail->product_image : 'images/no-image-available-icon-6.jpg';
					@endphp
					<div class="form-group">
						<div class="row">
							<div class="col-sm-1">
								<div class="from-group">
									<img src="{{ url($image) }}" style="width: 70px;">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group product-details">
									<div class="form-group">
										<b>{{ $detail->product_name }}</b><br>
										{!! ($detail->sub_category != '') ? "Variation: ".$detail->sub_category."<br>" : '' !!}
									</div>
									@if($transaction->status == 99)
										<span class="badge badge-pill badge-warning">Unpaid</span>
									@elseif($transaction->status == '98' && empty($transaction->cod_address))
										<span class="badge badge-pill badge-info">Waiting Verification</span>
									@elseif($transaction->status == '98' && !empty($transaction->cod_address) && empty($transaction->completed))
										<span class="badge badge-pill badge-info">Waiting for pickup</span>
									@elseif($transaction->status == '98' && !empty($transaction->cod_address) && !empty($transaction->completed))
										<span class="badge badge-pill badge-success">Completed</span>
									@elseif($transaction->status == 97)
										<span class="badge badge-pill badge-info">In-progress</span>
									@elseif($transaction->status == '96')
										<span class="badge badge-danger">Rejected</span>
									@elseif($transaction->status == 1)
										@if($transaction->completed == 1)
											<span class="badge badge-success">Delivered</span>
										@else
											<span class="badge badge-success">Paid</span>
										@endif
									@else
										<span class="badge badge-pill badge-danger">Cancelled</span>
									@endif
								</div>
							</div>
							<div class="col-sm-5" align="right">
								{{ isset($data['lang']['lang']['quantity']) ? $data['lang']['lang']['quantity'] : 'Qty' }}: x{{ $detail->quantity }}
								<br>
								<br>
								RM {{ number_format($detail->unit_price, 2) }}
							</div>	
						</div>
					</div>
					<hr>

					@endforeach
					<div class="row">
						<div class="col-6" align="left">
							
						</div>
						<div class="col-6" align="right">
							Shipping Fee: RM {{ number_format($transaction->shipping_fee, 2) }}
						</div>
						<div class="col-6" align="left">
							{{ count($details[$transaction->id]) }} {{ isset($data['lang']['lang']['products']) ? $data['lang']['lang']['products'] : 'Products' }}	
						</div>
						<div class="col-6" align="right">
							{{ isset($data['lang']['lang']['lump_sum']) ? $data['lang']['lang']['lump_sum'] : 'Total' }}: RM {{ number_format($transaction->grand_total, 2) }}
						</div>
					</div>

					@if($transaction->status == '98' && !empty($transaction->tracking_no) && !empty($transaction->order_number) && isset($ship_details[$transaction->id]))
					<hr>
					<div class="form-group">
						<i class="fa fa-truck" aria-hidden="true" style="font-size: 17px;"></i> &nbsp;&nbsp;&nbsp; [{{ $transaction->courier }}] {{ $ship_details[$transaction->id] }}
					</div>
					@endif
				</div>
				@endif
				@endforeach
				@else
				<div class="form-group container-box">
					<div class="form-group" align="center">
						{{ isset($data['lang']['lang']['no_order_yet']) ? $data['lang']['lang']['no_order_yet'] : 'No order yet' }}. <br><br>
						<a href="{{ route('home') }}" class="continue-shopping-btn btn btn-primary"> {{ isset($data['lang']['lang']['continue_shopping']) ? $data['lang']['lang']['continue_shopping'] : 'Continue Shopping' }}</a>
					</div>
				</div>
				@endif
			</div>
	</div>
</div>
@endsection