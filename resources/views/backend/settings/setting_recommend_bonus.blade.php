@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Refferal Reward
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
		<form method="POST" action="{{ route('save_setting_recommend_bonus') }}" id="setting-merchant-form">
			@csrf
			@if(!$levels->isEmpty())
				<div class="row">
					@foreach($levels as $level)
						<div class="col-md-6">
							<div class="form-group">
								<h3>{{ $level->agent_lvl }}</h3>
								<input type="hidden" name="agent_lvl[]" value="{{ $level->id }}">
								<div class="form-group container-box">
									<input type="hidden" name="ids[]" value="{{ !empty($selectDetails[$level->id][0]) ? $selectDetails[$level->id][0] : '' }}">
									<label>Amount (MYR)</label>
									<input type="text" class="form-control" name="amount[]" placeholder="Amount" 
										   value="{{ !empty($selectDetails[$level->id][1]) ? $selectDetails[$level->id][1] : '' }}" onkeypress="return isNumberKey(event)">
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