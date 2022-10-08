@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Performance Reward
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
@if(!$levels->isEmpty())
<h2 class="important-text">
	Set the monthly percentage of total performance (Personal sales)
</h2>
<form method="POST" action="{{ route('save_setting_performance_dividend') }}" id="setting-merchant-form">
@csrf
<div class="row">
	<div class="col-md-3">
		<div class="form-group container-box">
			<label>Set Date </label>
			<input type="number" class="form-control" name="date_update" placeholder="1-28" min="1" max="28" value="{{ isset($setting) ? $setting->date_update : '' }}">
		</div>
	</div>
</div>
<hr>
<div class="row">
	@foreach($levels as $level)
		<div class="col-sm-3">
			<h3>{{ $level->agent_lvl }}</h3>
			<div class="form-group container-box">
				<input type="hidden" name="sid[]" value="{{ (!empty($selectDetails[$level->id][0])) ? $selectDetails[$level->id][0] : '' }}">
				<input type="hidden" name="lvl[]" value="{{ $level->id }}">
				<div class="form-group">
					<label>Target (RM)</label>
					<input type="text" class="form-control" name="target[]" placeholder="Target Sales" 
						   value="{{ (!empty($selectDetails[$level->id][3])) ? $selectDetails[$level->id][3] : '' }}" onkeypress="return isNumberKey(event)">
				</div>
				<div class="form-group">
					<label>Percentage (%)</label>
					<input type="text" class="form-control" name="amount[]" placeholder="Amount" 
						   value="{{ (!empty($selectDetails[$level->id][2])) ? $selectDetails[$level->id][2] : '' }}" onkeypress="return isNumberKey(event)">
				</div>
			</div>
				<!-- <h2>SYSTEM UPDATE</h2>
				<hr>
				<h4>
					This page and functions are temporary unavailable. System update will be complete in soon..<br>
				</h4>
				<span style="font-size: 12px">(If any inquiries please contact your IT consultance.)</span> -->
		</div>
	@endforeach
</div>
</form>
<div class="form-group container-box">
	<h3>How to setting</h3>
	<p><b>Each agent level can take a different percentage of total performance</b></p>
	<hr>
	<h3>Set Date</h3>

	<h4>If "Set Date" is <b>25</b>, Rewards will auto update to agent's wallet on the 25th of every month</h4>

	<h4>If "Set Date" is <b>empty</b>, Rewards will auto update to agent's wallet on every month end</h4>

	<hr>

	<h3>Target Sales</h3>
	<h4>If "Target Sales" is <b>10000</b>, Rewards will auto update to agent's wallet if total sales more equal than 10000</h4>

	<h4>If "Target Sales" is <b>empty</b>, Rewards will auto update to agent's wallet based on total sales</h4>

	<p>Example: </p>
	<p>This month total sales is <b>$10000</b> </p>
	<h3>Rewards</h3>
	<ul>
		<li>Agent (1%) - "Agent" level which hit the target can get RM 100</li>
		<li>VIP (2%) - "VIP" level which hit the target can get RM 200</li>
		<li>Manager (3%)  - "Manager" level which hit the target can get RM 300</li>
		<li>CEO (4%) - "CEO" level which hit the target can get RM 400</li>
	</ul>

</div>

<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<button class="btn btn-primary">
			<i class="fa fa-check"> Save Changes</i>
		</button>

	</div>
</div>
@else
	<h3>Agent Level Needed</h3>
	<p class="important-text">
		Please go to <b>Settings <i class="fa fa-long-arrow-right" aria-hidden="true"></i> Agent Level</b> for add Agent Level first. </p>
@endif
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