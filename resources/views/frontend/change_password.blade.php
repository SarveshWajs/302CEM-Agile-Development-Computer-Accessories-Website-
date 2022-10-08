@extends('layouts.app')

@section('content')
<div class="container">
	<div class="form-group">
		<div class="row">
			<div class="col-md-12">
				<ol class="breadcrumb">
				  	<li><a href="{{ route('home') }}">Home</a></li>
				  	<li>Change Password</li>
				</ol>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-2">
				<div class="form-group">
					<h4>Hello, {{ Auth::guard($data['userGuardRole'])->user()->f_name }} {{ Auth::guard($data['userGuardRole'])->user()->l_name }}</h4>
				</div>

				<div class="form-group">
					<ul id="menu">
						<li>
							<a href="{{ route('profile') }}">
								My Profile
							</a>
						</li>
						@if(Auth::guard('merchant')->check())
						<li>
							<a href="{{ route('wallet') }}">
								My Wallet
							</a>
						</li>
						@endif
						<li>
							<a href="{{ route('AddressBook.AddressBook.index') }}">
								Address Book
							</a>
						</li>
						<li>
							<a href="{{ route('order_list') }}">
								Order  List
							</a>
						</li>
						<li>
							<a href="{{ route('wish_list') }}">
								Wish List
							</a>
						</li>
						<li class="active">
							<a href="{{ route('changePassword') }}">
								Change Password
							</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-sm-10">
				<div class="form-group">
					<h4>Change Password</h4>
				</div>
				<form method="POST" action="{{ route('updatePassword') }}">
					@csrf
					<div class="form-group">
						@if($errors->any())
						  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
						@endif
					</div>
					<div class="form-group container-box">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-5">
									<label>Current Password</label>
									<input type="password" class="form-control" name="old_password" value="{{ old('old_password') }}">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-5">
									<label>New password</label>
									<input type="password" class="form-control" name="new_password" value="{{ old('new_password') }}">
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-5">
									<label>Confirm New Password</label>
									<input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
								</div>
							</div>
						</div>

						<div class="form-group">
							<button class="btn btn-primary">
								<i class="fa fa-check"></i> SAVE CHANGES
							</button>
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
	
</script>
@endsection