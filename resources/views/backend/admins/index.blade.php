@extends('layouts.admin_app')
@section('css')
<style type="text/css">
	span.input-icon{
		display: block !important;
	}
</style>
@endsection
@section('content')
<div class="page-header">
    <h1>
        Profile
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            	@if(!empty(Auth::user()->f_name) && !empty(Auth::user()->l_name))
            		{{ Auth::user()->f_name }} {{ Auth::user()->l_name }} 
            	@else
            		{{ Auth::user()->email }}
            	@endif
            @endif
        </small>
    </h1>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="">
			<div id="user-profile-3" class="user-profile row">
				<div class="col-sm-12">
					<!-- <div class="well well-sm">
						
						<div class="inline middle blue bigger-110"> Your profile is 70% complete </div>

						&nbsp; &nbsp; &nbsp;
						<div style="width:200px;" data-percent="70%" class="inline middle no-margin progress progress-striped active pos-rel">
							<div class="progress-bar progress-bar-success" style="width:70%"></div>
						</div>
					</div> --><!-- /.well -->
					@if($errors->any())
                      <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
                    @endif
					<div class="space"></div>

					<form class="form-horizontal" method="POST" action="{{ route('admin.admins.update', Auth::user()->id) }}" enctype="multipart/form-data">
						@csrf
						@method('PUT')
						<div class="tabbable">
							<ul class="nav nav-tabs padding-16">
								<li class="active">
									<a data-toggle="tab" href="#edit-basic">
										<i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
										@if(Auth::guard('admin')->check())
											Company Info
										@else
											Personal Info
										@endif
									</a>
								</li>

								<li>
									<a data-toggle="tab" href="#edit-password">
										<i class="blue ace-icon fa fa-key bigger-125"></i>
										Password
									</a>
								</li>

								<li>
									<a data-toggle="tab" href="#website-setting">
										<i class="blue ace-icon fa fa-cogs bigger-125"></i>
										Website Setting Logo
									</a>
								</li>
							</ul>

							<div class="tab-content profile-edit-tab-content">
								<div id="edit-basic" class="tab-pane in active">
									<h4 class="header blue bolder smaller">General</h4>
									<div class="row">
										<div class="col-sm-6">
											<input type="text" class="form-control" placeholder="First Name" name="f_name" value="{{ Auth::user()->f_name }}">
										</div>
										<div class="col-sm-6">
											<input type="text" class="form-control" placeholder="Last Name" name="l_name" value="{{ Auth::user()->l_name }}">
										</div>
									</div>
									<div class="space-12"></div>
									<div class="row">
										<div class="col-sm-6">
											<div class="input-group">
												<input class="form-control date-picker" id="form-field-date" type="text" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" name="dob" value="{{ Auth::user()->dob }}" />
												<span class="input-group-addon">
													<i class="ace-icon fa fa-calendar"></i>
												</span>
											</div>
										</div>
										<div class="col-sm-6">
											<label class="inline">
												<input name="gender" type="radio" value="Male" class="ace" 
												 {{ Auth::user()->gender == 'Male' ? 'checked' : '' }} />
												<span class="lbl middle"> Male</span>
											</label>

											&nbsp; &nbsp; &nbsp;
											<label class="inline">
												<input name="gender" type="radio" value="Female" class="ace" 
												 {{ Auth::user()->gender == 'Female' ? 'checked' : '' }} />
												<span class="lbl middle"> Female</span>
											</label>
										</div>
									</div>

									

									<h4 class="header blue bolder smaller">Contact</h4>
									<p class="important-text">* Email & Phone for  display on frontend</p>
									<div class="row">
										<div class="col-sm-6">
											<span class="input-icon input-icon-right">
												<input type="email" id="form-field-email" class="form-control" name="contact_email" value="{{ Auth::user()->contact_email }}" placeholder="Email address" />
												<i class="ace-icon fa fa-envelope"></i>
											</span>
										</div>
										<div class="col-sm-6">
											<span class="input-icon input-icon-right">
												<input class="form-control input-mask-phone" type="text" name="phone" id="form-field-phone" value="{{ Auth::user()->phone }}" placeholder="Phone" onkeypress="return isNumberKey(event)" />
												<i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
											</span>		
										</div>
									</div>
									<div class="space-12"></div>

									<div class="row">
										<div class="col-sm-6">
											<textarea class="form-control" name="address" placeholder="Address">{{ (!empty($setting)) ? $setting->address : '' }}</textarea>
										</div>
										<div class="col-sm-6">
											<span class="input-icon input-icon-right">
												<input class="form-control input-mask-whatsapp" type="text" name="contact_whatsapp" id="form-field-whatsapp" value="{{ (!empty($setting)) ? $setting->contact_whatsapp : '' }}" placeholder="Company Whatsapp" onkeypress="return isNumberKey(event)" />
												<i class="ace-icon fa fa-whatsapp fa-flip-horizontal"></i>
											</span>		
										</div>
									</div>

									<h4 class="header blue bolder smaller">Social (Please add in "https://" at front of the url)</h4>

									<div class="row">
										<div class="col-sm-6">
											<span class="input-icon input-icon-right">
												<input type="text" id="form-field-email" class="form-control" name="facebook" value="{{ Auth::user()->facebook }}" placeholder="https://" />
												<i class="ace-icon fa fa-facebook"></i>
											</span>
										</div>
										<div class="col-sm-6">
											<span class="input-icon input-icon-right">
												<input class="form-control input-mask-phone" type="text" name="twitter" id="form-field-phone" value="{{ Auth::user()->twitter }}" placeholder="https://" />
												<i class="ace-icon fa fa-twitter"></i>
											</span>
										</div>
									</div>
									<div class="space-12"></div>

									<div class="row">
										<div class="col-sm-6">
											<span class="input-icon input-icon-right">
												<input class="form-control input-mask-phone" type="text" name="youtube" id="form-field-phone" value="{{ Auth::user()->youtube }}" placeholder="https://" />
												<i class="ace-icon fa fa-youtube"></i>
											</span>
										</div>

										<div class="col-sm-6">
											<span class="input-icon input-icon-right">
												<input class="form-control input-mask-phone" type="text" name="google" id="form-field-phone" value="{{ Auth::user()->google }}" placeholder="https://" />
												<i class="ace-icon fa fa-google"></i>
											</span>
										</div>
									</div>
									<div class="space-12"></div>
									<div class="row">
										<div class="col-sm-6">
											<span class="input-icon input-icon-right">
												<input class="form-control input-mask-phone" type="text" name="instagram" id="form-field-phone" value="{{ Auth::user()->instagram }}" placeholder="https://" />
												<i class="ace-icon fa fa-instagram"></i>
											</span>
										</div>
									</div>

								</div>

								<div id="edit-password" class="tab-pane">
									<h4 class="header blue bolder smaller">
										Change New Password
									</h4>

									
									<input type="password" name="password" class="form-control" id="form-field-pass1" placeholder="New Password" />
									

									<div class="space-12"></div>

									<input type="password" name="password_confirmation" class="form-control" id="form-field-pass2" placeholder="Confirm New Password" />

								</div>

								<div id="website-setting" class="tab-pane">
									
									@if(Auth::guard('admin')->check())
									<h4 class="header blue bolder smaller">
										Website Logo
										<label>
				                            <input name="logo_hidden" type="checkbox" class="ace" value="1" {{ Auth::user()->logo_hidden == '1' ? 'checked' : '' }} />
				                            <span class="lbl"> </span>
				                        </label>
										<p class="important-text" style="font-size: 12px;">Click the checkbox if you would like to display it in your website</p>
									</h4>

									<div class="row">
										<div class="col-sm-12">
											<input type="file" name="website_logo" class="form-control">
											@if(!empty(Auth::user()->website_logo))
												<img src="{{ url(Auth::user()->website_logo) }}" style="width: 100px;">
											@endif
										</div>
									</div>

									<h4 class="header blue bolder smaller">
										Website Name
										<label>
				                            <input name="name_hidden" type="checkbox" class="ace" value="1" {{ Auth::user()->name_hidden == '1' ? 'checked' : '' }} />
				                            <span class="lbl"> </span>
				                        </label>
									<p class="important-text" style="font-size: 12px;">Click the checkbox if you would like to display it in your website</p>
									</h4>
									<div class="row">
										<div class="col-sm-12">
											<input type="text" class="form-control" name="website_name" value="{{ Auth::user()->website_name }}">
										</div>
									</div>
									@endif
									<br>
									<h4 class="header blue bolder smaller">
										Profile Logo
									</h4>
									<div class="row">
										<div class="col-sm-12">
											<input type="file" name="profile_logo" class="form-control">
											@if(!empty(Auth::user()->profile_logo))
											<img src="{{ url(Auth::user()->profile_logo) }}" style="width: 70px;">
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="clearfix form-actions">
							<div class="col-md-12">
								<button class="btn btn-info" type="submit">
									<i class="ace-icon fa fa-check bigger-110"></i>
									Save
								</button>

								&nbsp; &nbsp;
								<button class="btn" type="reset">
									<i class="ace-icon fa fa-long-arrow-left bigger-110"></i>
									Back To List
								</button>
							</div>
						</div>
					</form>
				</div><!-- /.span -->
			</div><!-- /.user-profile -->
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('.date-picker').datepicker().next().on(ace.click_event, function(){
		$(this).prev().focus();
	})

	var about_usUrl = '{{ route("CKEditorUploadImage", ["_token" => csrf_token()]) }}';

	var about_us = CKEDITOR.instances["about_us"];

    if(!about_us){
      	CKEDITOR.replace( 'about_us',{
          	filebrowserUploadUrl: about_usUrl,
          	filebrowserUploadMethod: 'form'
      	});
  	}

  	var setting_faqs_descriptionUrl = '{{ route("CKEditorUploadImage", ["_token" => csrf_token()]) }}';

	var setting_faqs_description = CKEDITOR.instances["setting_faqs_description"];

    if(!setting_faqs_description){
      	CKEDITOR.replace( 'setting_faqs_description',{
          	filebrowserUploadUrl: setting_faqs_descriptionUrl,
          	filebrowserUploadMethod: 'form'
      	});
  	}

  	var privacy_policy_description = CKEDITOR.instances["privacy_policy_description"];

	if(!privacy_policy_description){
	    CKEDITOR.replace( 'privacy_policy_description',{
	        filebrowserUploadUrl: about_usUrl,
	        filebrowserUploadMethod: 'form'
	    });
	}

	var mission_description = CKEDITOR.instances["mission_description"];

	if(!mission_description){
	    CKEDITOR.replace( 'mission_description',{
	        filebrowserUploadUrl: about_usUrl,
	        filebrowserUploadMethod: 'form'
	    });
	}

	var vision_description = CKEDITOR.instances["vision_description"];

	if(!vision_description){
	    CKEDITOR.replace( 'vision_description',{
	        filebrowserUploadUrl: about_usUrl,
	        filebrowserUploadMethod: 'form'
	    });
	}

	var return_policy_description = CKEDITOR.instances["return_policy_description"];

	if(!return_policy_description){
	    CKEDITOR.replace( 'return_policy_description',{
	        filebrowserUploadUrl: about_usUrl,
	        filebrowserUploadMethod: 'form'
	    });
	}

	var shipping_policy_description = CKEDITOR.instances["shipping_policy_description"];

	if(!shipping_policy_description){
	    CKEDITOR.replace( 'shipping_policy_description',{
	        filebrowserUploadUrl: about_usUrl,
	        filebrowserUploadMethod: 'form'
	    });
	}

	var join_us_description = CKEDITOR.instances["join_us_description"];

	if(!join_us_description){
	    CKEDITOR.replace( 'join_us_description',{
	        filebrowserUploadUrl: about_usUrl,
	        filebrowserUploadMethod: 'form'
	    });
	}
</script>
@endsection