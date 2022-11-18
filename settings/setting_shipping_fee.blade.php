@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Shipping Fee
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
<form method="POST" action="{{ route('save_setting_shipping_fee') }}" id="setting-merchant-form">
@csrf

<div class="row">
	<div class="col-sm-6">
		<h3>West Malaysia (Freight)</h3>
		<hr>
		<div class="form-group">
			<div class="row">
				<div class="col-md-5">
					Weight (KG)
				</div>

				<div class="col-md-5">
					Shipping amount (MYR)
				</div>
			</div>
		</div>
		<hr>
		<div class="west row-parent">
			@if(!$settingShippingFees->isEmpty())
			@foreach($settingShippingFees as $settingShippingFee)
				@if($settingShippingFee->area == 'west')

					<div class="form-group">
						<input type="hidden" class="sid" name="sid[]" value="{{ $settingShippingFee->id }}">
						<input type="hidden" name="type[]" value="west">
						<div class="row">
							<div class="col-xs-5">
								<input type="text" name="weight[]" class="form-control" placeholder='Weight (KG)' value="{{ $settingShippingFee->weight }}">
							</div>
							<div class="col-xs-5">
								<input type="text" name="shipping_fee[]" class="form-control" placeholder="Shipping amount" value="{{ $settingShippingFee->shipping_fee }}">
							</div>
							<div class="col-xs-2" align="center">
								<a href="#"  class="important-text del">
									<i class="fa fa-trash fa-2x"></i>
								</a>
							</div>
						</div>
					</div>
				@endif
			@endforeach
			@endif
			<div class="form-group">
				<input type="hidden" name="sid[]" value="">
				<input type="hidden" name="type[]" value="west">
				<div class="row">
					<div class="col-xs-5">
						<input type="text" name="weight[]" class="form-control" placeholder='Weight (KG)'>
					</div>
					<div class="col-xs-5">
						<input type="text" name="shipping_fee[]" class="form-control" placeholder="Shipping amount">
					</div>
					<div class="col-xs-2" align="center">
						<a href="#"  class="important-text del">
							<i class="fa fa-trash fa-2x"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6 col-md-offset-3" align="center">
					<a href="#" class="add-shipping-btn" id="add-west">
						<i class="fa fa-plus"></i>
					</a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-6">
		<h3>East Malaysia (Freight)</h3>
		<hr>
		<div class="form-group">
			<div class="row">
				<div class="col-md-5">
					Weight (KG)
				</div>

				<div class="col-md-5">
					Shipping amount (MYR)
				</div>
			</div>
		</div>
		<hr>
		<div class="east row-parent">
			@if(!$settingShippingFees->isEmpty())
			@foreach($settingShippingFees as $settingShippingFee)
				@if($settingShippingFee->area == 'east')
					<div class="form-group">
						<input type="hidden" name="sid[]" value="{{ $settingShippingFee->id }}">
						<input type="hidden" name="type[]" value="east">
						<div class="row">
							<div class="col-xs-5">
								<input type="text" name="weight[]" class="form-control" placeholder='Weight (KG)' value="{{ $settingShippingFee->weight }}">
							</div>
							<div class="col-xs-5">
								<input type="text" name="shipping_fee[]" class="form-control" placeholder="Shipping amount" value="{{ $settingShippingFee->shipping_fee }}">
							</div>
							<div class="col-xs-2" align="center">
								<a href="#" class="important-text del">
									<i class="fa fa-trash fa-2x"></i>
								</a>
							</div>
						</div>
					</div>
				@endif
			@endforeach
			@endif
			<div class="form-group">
				<div class="row">
					<input type="hidden" name="sid[]" value="">
					<input type="hidden" name="type[]" value="east">
					<div class="col-xs-5">
						<input type="text" name="weight[]" class="form-control" placeholder='Weight (KG)'>
					</div>
					<div class="col-xs-5">
						<input type="text" name="shipping_fee[]" class="form-control" placeholder="Shipping amount">
					</div>
					<div class="col-xs-2" align="center">
						<a href="#" class="important-text del">
							<i class="fa fa-trash fa-2x"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<br>
		<div class="form-group">
			<div class="row">
				<div class="col-md-6 col-md-offset-3" align="center">
					<a href="#" class="add-shipping-btn" id="add-east">
						<i class="fa fa-plus"></i>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
</form>

<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<button class="btn btn-primary">
			<i class="fa fa-check"> Save</i>
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
	var west_item = '<div class="form-group">\
						<input type="hidden" name="sid[]" value="">\
						<input type="hidden" name="type[]" value="west">\
						<div class="row">\
							<div class="col-xs-5">\
								<input type="text" name="weight[]" class="form-control" placeholder="Weight (KG)">\
							</div>\
							<div class="col-xs-5">\
								<input type="text" name="shipping_fee[]" class="form-control" placeholder="Shipping amount">\
							</div>\
							<div class="col-xs-2" align="center">\
								<a href="#"  class="important-text del">\
									<i class="fa fa-trash fa-2x"></i>\
								</a>\
							</div>\
						</div>\
					</div>';
    $('#add-west').click(function (e){
    	e.preventDefault();
    	$('.west').append(west_item);
    });

    var east_item = '<div class="form-group">\
    					<input type="hidden" name="sid[]" value="">\
    					<input type="hidden" name="type[]" value="east">\
						<div class="row">\
							<div class="col-xs-5">\
								<input type="text" name="weight[]" class="form-control" placeholder="Weight (KG)">\
							</div>\
							<div class="col-xs-5">\
								<input type="text" name="shipping_fee[]" class="form-control" placeholder="Shipping amount">\
							</div>\
							<div class="col-xs-2" align="center">\
								<a href="#" class="important-text del">\
									<i class="fa fa-trash fa-2x"></i>\
								</a>\
							</div>\
						</div>\
					</div>';
    $('#add-east').click(function (e){
    	e.preventDefault();
    	$('.east').append(east_item);
    });

    $('.row-parent').on('click', '.del', function (e){
    	e.preventDefault();

    	var ele = $(this);
    	var sid = ele.closest('.row-parent .form-group').find('.sid').val();

    	if(confirm('Delete this shipping fee?') == true){
	    	var fd = new FormData();
	        	fd.append('sid', sid);

	    	$.ajax({
		         url: '{{ route("DeleteShipping") }}',
		         type: 'post',
		         data: fd,
		         contentType: false,
		         processData: false,
		         success: function(response){
		              $('.loading-gif').hide();
		              ele.closest('.row-parent .form-group').remove();

		         },
		      });
	    	
    		
    	}
    });
</script>
@endsection