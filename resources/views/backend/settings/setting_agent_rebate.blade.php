@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Agent Order Rebate
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
<div class="row">
	<div class="col-sm-12">
		<form method="POST" action="{{ route('save_setting_agent_rebate') }}" id="setting-merchant-form">
			@csrf
			@if(!$levels->isEmpty())
				<div class="row">
					@foreach($levels as $level)
						<div class="col-md-12">
							<h3>{{ $level->agent_lvl }}</h3>
							<input type="hidden" name="agent_lvl[]" value="{{ $level->id }}">
							<div class="form-group container-box">
								<input type="hidden" name="sid[]" value="{{ isset($selectDetails[$level->id]) ? $selectDetails[$level->id][0] : '' }}">
								<div class="form-group">
									<div class="row" style="display: flex; justify-content: center;">
										<div class="col-md-6" align="center">
											Performance Bonus
										</div>
										<div class="col-md-6" align="center">
											Overriding Qualification
										</div>
									</div>
									<hr>
									<div class="row" style="display: flex; justify-content: center;">
										<div class="col-md-3">
											<select class="form-control" name="type[]">
												<option {{ (isset($selectDetails[$level->id]) && $selectDetails[$level->id][1] == 'Percentage') ? 'selected' : '' }} value="Percentage">Percentage</option>
												<option {{ (isset($selectDetails[$level->id]) && $selectDetails[$level->id][1] == 'Amount') ? 'selected' : '' }} value="Amount">Amount</option>
											</select>
										</div>
										<div class="col-md-3">
											<input type="text" name="amount[]" class="form-control" placeholder="Amount" 
												   value="{{ isset($selectDetails[$level->id]) ? $selectDetails[$level->id][2] : '' }}">
										</div>
										<div class="col-md-3">
											<input type="text" name="personal_amount[]" class="form-control" 
												   placeholder="Personal Sale" 
												   value="{{ isset($selectDetails[$level->id]) ? $selectDetails[$level->id][3] : '' }}">
										</div>
										<div class="col-md-1" align="center">
											OR
										</div>
										<div class="col-md-3">
											<input type="text" name="line_group[]" class="form-control" 
												   placeholder="Line Group Sale" 
												   value="{{ isset($selectDetails[$level->id]) ? $selectDetails[$level->id][4] : '' }}">
										</div>
									</div>
								</div>
							</div>
						</div>
					@endforeach					
				</div>
			@else
				<h3>Agent Level Needed</h3>
				<p class="important-text">
					Please go to <b>Settings <i class="fa fa-long-arrow-right" aria-hidden="true"></i> Agent Level</b> for add Agent Level first. </p>
			@endif
		</form>
	</div>
</div>

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