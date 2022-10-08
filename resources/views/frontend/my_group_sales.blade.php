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
						<p align="center" class="header-title">My Account</p>
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
							<br>
							@if(Auth::guard('admin')->check() || Auth::guard('merchant')->check())
							&nbsp;
							<small class="profile-level">Level: {{ !empty($lvl) ? $lvl : ' - ' }}</small>
							<br>
							@endif
							&nbsp;
							<small class="profile-level">Upline: {{ Auth::user()->master_id }}</small>
							
						</a>
					</div>
					<!-- <div class="col-xs-4" align="right">
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
						<div class="col" align="center">
							<a href="{{ route('myqrcode') }}">
								<img src="{{ url('images/qrcode.png') }}" width="30">
								<br>
								<span class="profile-word">My QRcode</span>
							</a>
						</div>

						<div class="col" align="center">
							<a href="{{ route('MyAffiliate', Auth::user()->code) }}">
								<img src="{{ url('images/profile/585e4d1ccb11b227491c339b.png') }}" width="30">
								<br>
								<span class="profile-word">My Team</span>
							</a>
						</div>

						<div class="col" align="center">
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
		<div class="form-group container-box">
			<form method="GET" action="{{ route('MyGroupSales') }}">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label>Dates</label>
							<input type="text" class="form-control" name="dates" value="{{ !empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate }}">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Downline Name / Code</label>
							<input type="text" class="form-control" name="downline" placeholder="Downline Name / Code" 
								   value="{{ !empty(request('downline')) ? request('downline') : ''  }}">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Upline Name / Code</label>
							<input type="text" class="form-control" name="upline" placeholder="Upline Name / Code"
								   value="{{ !empty(request('upline')) ? request('upline') : ''  }}">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Row Per Page</label>
							<select class="form-control" name="per_page">
								<option value="10" {{ !empty(request('per_page')) && request('per_page') == '10' ? 'selected' : '' }}>
									10
								</option>
								<option value="20" {{ !empty(request('per_page')) && request('per_page') == '20' ? 'selected' : '' }}>
									20
								</option>
								<option value="50" {{ !empty(request('per_page')) && request('per_page') == '50' ? 'selected' : '' }}>
									50
								</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<button class="btn btn-primary">
								<i class="fa fa-search"></i> Search
							</button>
							<a href="{{ route('MyGroupSales') }}" class="btn btn-primary">
								<i class="fa fa-sync"></i> Clear Search
							</a>
						</div>
						<a href="{{ route('tree_view') }}" class="btn btn-primary">
								<i class="fa fa-users" aria-hidden="true"></i>Tab view
							</a>
					</div>
				</div>
			</form>
		</div>
		<div class="form-group" align="right">
			<a href="{{ route('PrintMyGroupSales', ['dates='.(!empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate),
													'downline='.(!empty(request('downline')) ? request('downline') : ''),
													'upline='.(!empty(request('upline')) ? request('upline') : '')]) }}" 
													target="_blank" class="btn btn-primary">
				Download as PDF
			</a>
		</div>
		<div class="form-group container-box">
			<div class="row">
				<div class="col-1">
					#
				</div>
				<div class="col">
					Downline
				</div>
				<div class="col">
					Personal Sales
				</div>
				<div class="col">
					Total Group Sales
				</div>
			</div>
			<hr>
			@if(!$groups->isEmpty())
				@foreach($groups as $key => $group)
				<div class="row">
					<div class="col-1">
						{{ $key+1 }}
					</div>
					<div class="col">
						{{ $group->f_name }} ({{ $group->code }})<br>
						Level: {{ !empty($group->agent_lvl) ? $group->agent_lvl : ' - ' }}<br>
						Generation: {{ $group->sort_level }}<br>
						Upline: {{ $group->upline_name }} ({{ $group->master_id }})
					</div>
					<div class="col">
						{{ !empty($getOwnSales[$group->code]) ? number_format($getOwnSales[$group->code], 2) : '0.00' }}
					</div>
					<div class="col">
						{{ !empty($getTotalGroupTopup[$group->code]) ? number_format($getTotalGroupTopup[$group->code], 2) : '0.00' }}
					</div>
				</div>
				<hr>
				@endforeach
			@else
				<div class="row">
					<div class="col">
						No Result Found
					</div>
				</div>
			@endif
			{{ $groups->links() }}
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('input[name=dates]').daterangepicker({
		'applyClass' : 'btn-sm btn-success',
		'cancelClass' : 'btn-sm btn-default',
		locale: {
			applyLabel: 'Apply',
			cancelLabel: 'Cancel',
		}
	})
	.prev().on(ace.click_event, function(){
		$(this).next().focus();
	});
</script>
@endsection