@extends('layouts.app')

@section('content')
<div class="profile-own-bg">
	<div class="personal-header-info">
			<div class="container">
				<div class="row">
					<div class="col-4" align="left">
						<a href="{{ route('wallet') }}">
							<p style="color: white;"><i class="fa fa-chevron-left"></i> Back</p>
						</a>
					</div>
					<div class="col-4" align="left">
						<p align="center" class="header-title">New Bank Account</p>
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
								<img src="{{ url(Auth::user()->profile_logo) }}" width="50" class="profile-logo">
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
			@if(Auth::guard('web')->check())
				<!-- <div class="form-group container-box sl-personal-header">
					<div class="row">
						<div class="col-6" align="center">
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

						<div class="col-6" align="center">
							<a href="{{ route('wallet') }}">
								<img src="{{ url('images/profile/c3286d4d32fa90ebcf09b488654612b9-wallet-icon-by-vexels.png') }}" width="30">
								<br>
								<span class="profile-word">My Wallet</span>
							</a>
						</div>
					</div>
				</div> -->
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
<br>
<div class="profile-content">
	<div class="container">
		<div class="row">
			
			<div class="col-md-6">
				<form method="POST" action="{{ route('bank_account_save') }}" id="bank-form">
					@csrf
					<div class="container-box">
						@if(isset($bank))
							<input type="hidden" name="bid" value="{{ $bank->id }}">
						@endif
						@php
							$bank_name = isset($bank) ? $bank->bank_name : old('bank_name');
						@endphp
						<div class="form-group">
							<label>Bank Name <span class="important-text">*</span></label>
							<select class="form-control" name="bank_name">
								@foreach($banks as $bank_d)
								<option {{ ($bank_name == $bank_d->bank_name) ? 'selected' : '' }} value="{{ $bank_d->bank_name }}">
									{{ $bank_d->bank_name }}
								</option>
								@endforeach
							</select>
						</div>

						<div class="form-group">
							<label>Bank Holder Name <span class="important-text">*</span></label>
							<input type="text" class="form-control required-feild" name="bank_holder_name" value="{{ isset($bank) ? $bank->bank_holder_name : old('bank_holder_name') }}" placeholder="Bank Holder Name">
						</div>

						<div class="form-group">
							<label>Bank Account <span class="important-text">*</span></label>
							<input type="text" class="form-control required-feild" name="bank_account" value="{{ isset($bank) ? $bank->bank_account : old('bank_account') }}" placeholder="Bank Account" onkeypress="return isNumberKey(event)">
						</div>
						<div class="form-group">
							<b id="error-message" class="important-text"></b>
						</div>
						<div class="form-group">
							<button class='btn btn-primary btn-sm submit-bank'><i class="fa fa-check"></i> Save Changes</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('#bank-form .required-feild').change( function(){
    	if($(this).val()){
    		$(this).removeClass('required-feild-error');
    	}
    });

	$('.submit-bank').click( function(e){
		e.preventDefault();
		var empty_fill;
	    $('#bank-form .required-feild').each( function(){
	    	if(!$(this).val()){
	    		$(this).addClass('required-feild-error');
	    		empty_fill = 1;
	    	}
	    });
	    if(empty_fill == 1){
	    	$('#error-message').html('请填写所有必填字段.');
	    	return false;
	    }

	    $('#bank-form').submit();
	});
</script>
@endsection