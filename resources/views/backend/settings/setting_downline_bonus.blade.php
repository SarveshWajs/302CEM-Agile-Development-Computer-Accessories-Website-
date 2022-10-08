@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Downline Purchase Bonus
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
<form method="POST" action="{{ route('save_setting_downline_bonus') }}" id="setting-merchant-form">
@csrf
<div class="row">
	@if(!$levels->isEmpty())
	@foreach($levels as $level)
	<div class="col-sm-6 col-xs-12">
				<h3>{{ $level->agent_lvl }}</h3>

				<div class="container-box">
					<div class="form-group">
						<div class="parent-box">
							<input type="hidden" name="level_id[]" class="level_id" value="{{ $level->id }}">
							<div class="form-group child-box">
								@foreach($settings as $setting)
									@if($setting->level_id == $level->id)
									<input type="hidden" name="lid{{ $level->id }}[]" value="{{ $setting->id }}">
									<div class="row">
										<div class="col-xs-4">
											<input type="text" class="form-control" name="target{{ $level->id }}[]" placeholder="Target" value="{{ $setting->target }}">
										</div>
										<div class="col-xs-4">
											<select class="form-control" name="comm_type{{ $level->id }}[]">
												<option {{ $setting->comm_type == 'Percentage' ? 'selected' : '' }} value="Percentage">Percentage</option>
												<option {{ $setting->comm_type == 'Amount' ? 'selected' : '' }} value="Amount">Amount</option>
											</select>
										</div>
										<div class="col-xs-4">
											<input type="text" class="form-control" name="comm_amount{{ $level->id }}[]" placeholder="Commission" value="{{ $setting->comm_amount }}" onkeypress="return isNumberKey(event)">
										</div>
									</div>
									<hr>
									@endif
								@endforeach
								<div class="row">
									<div class="col-xs-4">
										<input type="text" class="form-control" name="target{{ $level->id }}[]" placeholder="Target">
									</div>
									<div class="col-xs-4">
										<select class="form-control" name="comm_type{{ $level->id }}[]">
											<option value="Percentage">Percentage</option>
											<option value="Amount">Amount</option>
										</select>
									</div>
									<div class="col-xs-4">
										<input type="text" class="form-control" name="comm_amount{{ $level->id }}[]" placeholder="Commission" value="" onkeypress="return isNumberKey(event)">
									</div>
								</div>
								<hr>
							</div>
							<div class="form-group">
								<div class="row justify-content_center">
									<div class="col-md-12" align="center">
										<button type="button" class="add-row-btn" id="add-row-btn">
											<i class="fa fa-plus"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				</div>
		@endforeach
	@else
		<h3>Agent Level Needed</h3>
		<p class="important-text">
			Please go to <b>Settings <i class="fa fa-long-arrow-right" aria-hidden="true"></i> Agent Level</b> for add Agent Level first. </p>
	@endif
	
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
    	$('.loading-gif').show();
    	$('#setting-merchant-form').submit();
    });

    $('.add-row-btn').click(function(e){
    	e.preventDefault();
    	var ele = $(this);
    	var lvl_id = ele.closest('.parent-box').find('.level_id').val();

    	var add_new_row = '<div class="row">\
							<div class="col-xs-4">\
								<input type="text" class="form-control" name="target'+lvl_id+'[]" placeholder="Target">\
							</div>\
							<div class="col-xs-4">\
								<select class="form-control" name="comm_type'+lvl_id+'[]">\
									<option value="Percentage">Percentage</option>\
									<option value="Amount">Amount</option>\
								</select>\
							</div>\
							<div class="col-xs-4">\
								<input type="text" class="form-control" name="comm_amount'+lvl_id+'[]" placeholder="Commission" value="" onkeypress="return isNumberKey(event)">\
							</div>\
						</div>\
						<hr>';


    	ele.closest('.parent-box').find('.child-box').append(add_new_row);
    });
</script>
@endsection