@extends('layouts.app')

@section('content')
<div class="profile-own-bg">
	<div class="personal-header-info">
			<div class="container">
				<div class="row">
					<div class="col-4" align="left">
						<a href="{{ route('profile') }}">
							<p style="color:white;"><i class="fa fa-chevron-left"></i> Back</p>
						</a>
					</div>
					<div class="col-4" align="left">
						<p align="center" class="header-title">Account Setting</p>
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
								<div style="background-image: url({{ url(Auth::user()->profile_logo) }}); width: 50px; height: 50px; border-radius: 100%; background-size: 100%; background-position: center; background-repeat: no-repeat;">
								</div>
							@else
								<img src="{{ url('images/images.png') }}" width="50" class="profile-logo">
							@endif							
						</a>
					</div>
					<div class="col-6">
						&nbsp;
						<b class="profile-name">{{ Auth::user()->f_name }} {{ Auth::user()->l_name }}</b>
					</div>
					<!-- <div class="col-xs-4" align="right">
						<a href="#">
							<i class="fa fa-pencil"></i> Edit Profile
						</a>

					</div> -->
				</div>
			</div>
			<!-- <div class="form-group container-box sl-personal-header">
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
			</div> -->
		</div>
	</div>
</div>

<form method="POST" action="{{ route('profile') }}" enctype="multipart/form-data">
	@csrf
	<div class="profile-content">
		<div class="container">
			<div class="container-box">
				<div class="form-group">
                    @if($errors->any())
                      <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
                    @endif
                </div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
							<label>Full Name</label>
							<input type="text" name="f_name" value="{{ Auth::user()->f_name }}" class="form-control">
							
						</div>
					</div>

					

					<div class="col-md-4">
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" value="{{ Auth::user()->phone }}" class="form-control">
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label>Gender</label>
							<select class="form-control" name="gender">
								<option {{ Auth::user()->gender == 'Male' ? 'selected' : '' }} value="Male">Male</option>
								<option {{ Auth::user()->gender == 'Female' ? 'selected' : '' }} value="Female">Female</option>
							</select>
						</div>
					</div>

					<div class="col-md-4">
						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control" readonly>
						</div>
					</div>

					

				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-md-4">
							<label>Profile logo</label>
							<input type="file" class="form-control" name="profile_logo">
							@if(!empty(Auth::user()->profile_logo))
							<img src="{{ url(Auth::user()->profile_logo) }}" width="100px">
							@endif
						</div>
						
					</div>
				</div>

				@if(Auth::guard('merchant')->check())
				<hr>
				<h4>About Us</h4>
				<textarea class="form-control about_us" name="about_us" id="about_us">{!! Auth::user()->about_us !!}</textarea>
				<br>
				@endif

				<div class="form-group">
					<button class="btn btn-primary btn-sm">
						<i class="fa fa-check"></i> Save changes
					</button>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection

@section('js')
<script type="text/javascript">
	var about_usUrl = '{{ route("CKEditorUploadImage", ["_token" => csrf_token()]) }}';

	var about_us = CKEDITOR.instances["about_us"];

	if(!about_us){
	    CKEDITOR.replace( 'about_us',{
	        filebrowserUploadUrl: about_usUrl,
	        filebrowserUploadMethod: 'form'
	    });
	}

	$('.save-about-us').click(function(e){
      e.preventDefault();

      var ele = $(this);
      var fd = new FormData();
          fd.append('about_us', CKEDITOR.instances['about_us'].getData());

      $.ajax({
          url: '{{ route("UpdateAboutUs") }}',
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(response){
            alert(response);
            $('.loading-gif').hide();
            toastr.success('Update Successful');
          }
      });


  });
</script>
@endsection