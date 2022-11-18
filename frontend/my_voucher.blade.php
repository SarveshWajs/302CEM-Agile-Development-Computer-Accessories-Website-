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
						<p align="center" class="header-title">My Voucher</p>
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
						<a href="{{ route('profile') }}">
							@if(!empty(Auth::user()->profile_logo))
								<!-- <img src="{{ url(Auth::user()->profile_logo) }}" width="50" class="profile-logo"> -->
								<div style="background-image: url({{ url(Auth::user()->profile_logo) }}); width: 50px; height: 50px; border-radius: 100%; background-size: 100%; background-position: center; background-repeat: no-repeat;"></div>
							@else
								<img src="{{ url('images/images.png') }}" width="50" class="profile-logo">
							@endif							
						</a>
					</div>
					<div class="col-6">
						<a href="{{ route('profile') }}">
							&nbsp;
							<b class="profile-name">{{ Auth::user()->f_name }} {{ Auth::user()->l_name }}</b>
							<br>
						&nbsp;
						<small class="profile-code">Code: {{ Auth::user()->code }}</small>
						</a>
					</div>
					<!-- <div class="col-xs-4" align="right">
						<a href="#">
							<i class="fa fa-pencil"></i> Edit Profile
						</a>

					</div> -->
				</div>
			</div>
			
		</div>
	</div>
</div>


<div class="profile-content">
	<div class="container">
		<div class="form-group container-box">
			@if(!$applied_promotions->isEmpty())
				@foreach($applied_promotions as $applied_promotion)
					<div class="form-group wish-row">
						<div class="row">
							<div class="col-md-2">
								<img src="{{ url($applied_promotion->image) }}" style="width: 100%;">
							</div>
							<div class="col-md-3">
								<b>{{ $applied_promotion->promotion_title }}</b> <br>
								<b>Offer: </b> {{ ($applied_promotion->amount_type == 'Percentage') ? $applied_promotion->amount."%" : "RM ".$applied_promotion->amount }} OFF <br>
								<b>Expiry: </b> {{ $applied_promotion->end_date }} <br>
								<b>Code: </b> {{ $applied_promotion->discount_code }}
							</div>
							<div class="col-md-7" align="right">
								<input type="hidden" name="apid" class="apid" value="{{ $applied_promotion->apid }}">
								<button class="btn btn-warning btn-sm claim-voucher" data-id="{{ $applied_promotion->discount_code }}">
									Use Now
								</button>
							</div>
						</div>
					</div>
					<hr>
				@endforeach
			@else
			<div class="form-group" align="center">
				you've no claim any voucher yet.
			</div>
			<div class="form-group" align="center">
				<a href="{{ route('home') }}" class="btn btn-primary">
					Continue Shopping
				</a>
			</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('.claim-voucher').click( function(e){
        e.preventDefault();

        var ele = $(this);
        var promo_id = ele.data('id');
        var apid = ele.parent().find('.apid').val();
        
        $('.loading-gif').show();
        var fd = new FormData();
        fd.append('discount_code', promo_id);
        fd.append('use', '1');
        fd.append('apid', apid);

        $.ajax({
           url: '{{ route("ApplyPromo") }}',
           type: 'post',
           data: fd,
           contentType: false,
           processData: false,
           success: function(response){
                $('.loading-gif').hide();
                toastr.success('Successfully');
           }
        });
    });
</script>
@endsection