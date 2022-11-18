@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Website
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
<h3 class="important-text">Upload Your Images / Description will display at Home Page</h3>
<hr>
<form method="POST" action="{{ route('save_setting_website_images') }}" id="setting-merchant-form" enctype="multipart/form-data">
<div class="row">
	<div class="col-sm-6 col-xs-12">
			@csrf
			<!-- <div class="form-group">
				<input type="text" class="form-control" name="amount" placeholder="Amount" value="{{ isset($select) ? $select->amount : '' }}">
			</div> -->
			
			<label>First Images</label>
			<div class="form-group">
				@if(isset($select) && !empty($select->f_image))
				<img src="{{ $select->f_image }}" style="width: 100px;">
				@endif
				<input type="file" name="first_images" class="form-control"  accept="image/x-png,image/gif,image/jpeg">
			</div>

			<label>Second Images</label>
			<div class="form-group">
				@if(isset($select) && !empty($select->s_image))
				<img src="{{ $select->s_image }}" style="width: 100px;">
				@endif
				<input type="file" name="second_images" class="form-control"  accept="image/x-png,image/gif,image/jpeg">
			</div>

			<label>Third Images</label>
			<div class="form-group">
				@if(isset($select) && !empty($select->t_image))
				<img src="{{ $select->t_image }}" style="width: 100px;">
				@endif
				<input type="file" name="third_images" class="form-control"  accept="image/x-png,image/gif,image/jpeg">
			</div>
			
	</div>

	<div class="col-sm-6 col-xs-12">
		<label>Fourth Images</label>
		<div class="form-group">
			@if(isset($select) && !empty($select->fo_image))
			<img src="{{ $select->fo_image }}" style="width: 100px;">
			@endif
			<input type="file" name="fourth_images" class="form-control"  accept="image/x-png,image/gif,image/jpeg">
		</div>
	</div>

	<div class="col-sm-6 col-xs-12">
		<label>Fifth Images</label>
		<div class="form-group">
			@if(isset($select) && !empty($select->fif_image))
			<img src="{{ $select->fif_image }}" style="width: 100px;">
			@endif
			<input type="file" name="fifth_images" class="form-control"  accept="image/x-png,image/gif,image/jpeg">
		</div>
	</div>
</div>
<hr>
<div class="row">
	<h3>Setting Retail price</h3>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label>Title</label>
				<input type="text" name="op_title" class="form-control" value="{{ isset($select) ? $select->op_title : '' }}">
			</div>
		</div>
	</div>

	<!-- <div class="form-group">
		<label>Background Image</label>
		<input type="file" name="op_background_img" class='form-control'  accept="image/x-png,image/gif,image/jpeg">
	</div> -->

	<div class="form-group">
		<label>First Image</label>
		<div class="form-group">
			@if(isset($select) && !empty($select->fo_image))
			<img src="{{ $select->op_f_img }}" style="width: 100px;">
			@endif
			<input type="file" name="op_f_img" class='form-control' accept="image/x-png,image/gif,image/jpeg">
		</div>
	</div>

	<div class="form-group">
		<label>Second Image</label>
		<div class="form-group">
			@if(isset($select) && !empty($select->op_s_img))
			<img src="{{ $select->op_s_img }}" style="width: 100px;">
			@endif
			<input type="file" name="op_s_img" class='form-control' accept="image/x-png,image/gif,image/jpeg">
		</div>
	</div>

	<div class="form-group">
		<label>Third Image</label>
		<div class="form-group">
			@if(isset($select) && !empty($select->op_t_img))
			<img src="{{ $select->op_t_img }}" style="width: 100px;">
			@endif
			<input type="file" name="op_t_img" class='form-control' accept="image/x-png,image/gif,image/jpeg">
		</div>
	</div>
</div>
</form>

<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<button class="btn btn-primary">
			<i class="fa fa-check"> Save Changes</i>
		</button>

	</div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$('.submit-form-btn .btn-primary').click( function(e){
    	e.preventDefault();
    	
    	$('#setting-merchant-form').submit();
    });

    CKEDITOR.replace( 'first_images_description');
    CKEDITOR.replace( 'second_images_description');
    CKEDITOR.replace( 'third_images_description');
    CKEDITOR.replace( 'fourth_images_description');
    CKEDITOR.replace( 'fifth_images_description');
</script>
@endsection