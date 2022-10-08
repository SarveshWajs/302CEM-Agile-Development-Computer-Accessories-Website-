@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting UOM
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>

<div class="form-group">
	<form method="POST" action="{{ route('setting_uom_save') }}" id="setting-merchant-form">
		@csrf
		<div class="big-parent">
			<div class="form-group">
				<div class="row">
					<div class="col-xs-4">
						<div class="form-group">
							<h5><b>UOM name</b></h5>
						</div>
					</div>
				</div>
				<div class="child-div">
					@foreach($setting_uoms as $setting_uom)
						<div class="form-group child-row">
							<div class="row">
								<div class="col-xs-4">
									<input type="hidden" name="uid[]" value="{{ $setting_uom->id }}">
									<input type="text" name="uom_name[]" class="form-control" placeholder="Pcs" value="{{ $setting_uom->uom_name }}">
								</div>
							</div>
						</div>
					@endforeach
					<div class="form-group child-row">
						<div class="row">
							<div class="col-xs-4">
								<input type="hidden" name="uid[]" value="">
								<input type="text" name="uom_name[]" class="form-control" placeholder="Pcs">
							</div>
						</div>
					</div>
				</div>					
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-md-4" align="center">
						<button class="add-row-btn">
							<i class="fa fa-plus"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="submit-form-btn">
		<div class="form-group wizard-actions" align="right">
			<button class="btn btn-primary">
				<i class="fa fa-check"> SAVE CHANGES</i>
			</button>

		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('#setting-merchant-form').on('change', 'input', function(){
		var ele = $(this);
		
		if(ele.val()){
			ele.removeClass('input-required-field');
		}
	});

	$('#setting-merchant-form').on('change', '.products', function(){
		var ele = $(this);
		var productdiv = $(this).closest('.child-row').find('.select2-container--default .select2-selection--single');

		if(ele.val()){
			productdiv.removeClass('input-required-field');
		}
	});

	$('.submit-form-btn .btn-primary').click( function(e){
    	e.preventDefault();

		
    	$('#setting-merchant-form').submit();
    });

	var add_new_row = '<div class="form-group child-row">\
							<div class="row">\
								<div class="col-xs-4">\
									<input type="hidden" name="uid[]" value="">\
									<input type="text" name="uom_name[]" class="form-control" placeholder="Pcs">\
								</div>\
							</div>\
						</div>';
    $('.add-row-btn').click(function(e){
    	e.preventDefault();
    	var ele = $(this);

    	ele.closest('.big-parent').find('.child-div').append(add_new_row);
    	$('.big-parent .products').select2();
    });

    
</script>
@endsection