@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Promotion Details
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
@if($errors->any())
  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
@endif
<form method="POST" action="{{ route('promotion.promotions.update', $promotion->id) }}" id="promotions-form" enctype="multipart/form-data">
@csrf
@method('PUT')
@include('backend.promotions.form')
</form>

<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<a href="{{ route('promotion.promotions.index') }}" class="btn btn-default">
			<i class="fa fa-ban"> CANCEL</i>
		</a>

		<button class="btn btn-primary">
			<i class="fa fa-check"> SAVE CHANGES</i>
		</button>

	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	// CKEDITOR.replace( 'description');

	$('.submit-form-btn .btn-primary').click( function(e){
    	e.preventDefault();
    	
    	$('#promotions-form').submit();
    });


    $(function(){
        $('.limit_type').click( function(){
            var ele = $(this);
            if(ele.val() == '2'){
                $('.times-limit').html('User Able To Use <input type="text" name="usage_limit" value="{{ isset($promotion) ? $promotion->usage_limit : old("usage_limit") }}"> Time(s) Per Day');
            }else if(ele.val() == '3'){
                $('.times-limit').html('User Able To Use Total <input type="text" name="usage_limit" value="{{ isset($promotion) ? $promotion->usage_limit : old("usage_limit") }}"> Time(s)');
            }else{
                $('input[name="usage_limit"]').hide();
            }
        });

    });
</script>
@endsection