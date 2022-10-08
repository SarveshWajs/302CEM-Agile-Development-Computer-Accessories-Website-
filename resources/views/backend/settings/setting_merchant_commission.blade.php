@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Affiliate Bonus
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
<form method="POST" action="{{ route('save_setting_merchant_commission') }}" id="setting-merchant-form">
@csrf
<div class="row">
	@if(!$levels->isEmpty())
	@foreach($levels as $level)
	<div class="col-sm-6 col-xs-12">
				<h3>{{ $level->agent_lvl }}</h3>

				<div class="container-box">
					<div class="form-group">
						<div class="">
							
							@for($a=1; $a<=3; $a++)
							<div class="form-group">
								<label>
									@php
										if($a == 1){
											$b = 'st';
										}elseif($a == 2){
											$b = 'nd';
										}else{
											$b = 'th';
										}
									@endphp
									{{ $a.$b }} Generation
								</label>

								<input type="hidden" name="agent_lvl[]" value="{{ $level->id }}">
								<input type="hidden" name="ids[]" value="{{ !empty($value[$a][$level->id][2]) ? $value[$a][$level->id][2] : '' }}">
								<input type="hidden" name="level[]" value="{{ $a }}">
								<div class="row">
									<div class="col-xs-4">
										<select class="form-control" name="comm_type[]">
											<option {{ (!empty($value[$a][$level->id][0]) && $value[$a][$level->id][0] == 'Percentage') ? 'selected' : '' }} value="Percentage">Percentage</option>
											<option {{ (!empty($value[$a][$level->id][0]) && $value[$a][$level->id][0] == 'Amount') ? 'selected' : '' }} value="Amount">Amount</option>
										</select>
									</div>
									<div class="col-xs-8">
										<input type="text" class="form-control" name="comm_amount[]" placeholder="Commission" 
											   value="{{ !empty($value[$a][$level->id][1]) ? $value[$a][$level->id][1] : '' }}" 
											   onkeypress="return isNumberKey(event)">
									</div>
								</div>
								<hr>
							</div>
							@endfor
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

<!-- <div class="row">
	<div class="col-sm-6 col-xs-12">
		<div class="form-group">
			<h3>经销商 <i class="fa fa-long-arrow-right" aria-hidden="true"></i> 服务商</h3>
			<div class="container-box">
				<div class="form-group">
					<label>所需人数</label>
					<input type="text" name="" class="form-control" placeholder="人数">
				</div>
			</div>
		</div>
	</div>
</div> -->

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
</script>
@endsection