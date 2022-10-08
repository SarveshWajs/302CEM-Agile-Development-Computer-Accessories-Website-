@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Agent Bonus
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
@if(!$levels->isEmpty())
<form method="POST" action="{{ route('setting_merchant_bonus') }}" id="setting-merchant-form">
@csrf
	<h3>Set the cumulative number of agents recommended</h3>
	<h3 class="important-text">Attachment: Set the number of downline agents and rebates (recommended agents to the designated number of new agents, get extra rebates)</h3>
	<div class="row">
		<div class="col-sm-6">
			@foreach($levels as $level)
			<div class="row">
				<div class="col-sm-12">
					<h3>{{ $level->agent_lvl }}</h3>
					
					<div class="container-box">
						
						<div class="form-group">
							<div class="row">
								<div class="col-xs-4">
									Cumulative setting
								</div>
								<div class="col-xs-4">
									Number of agents (More than equal)
								</div>
								<div class="col-xs-4">
									Amount
								</div>
							</div>
						</div>
						<hr>
						<div class="parent-box">
							@foreach($selects as $select)
								@if($select->agent_lvl == $level->id)
								<input type="hidden" name="lvl[]" class="agent_lvl" value="{{ $level->id }}">			
								<div class="form-group child-box">
									<div class="row">
										<div class="col-xs-3">
											<select class="form-control" name="type[]">
												<option {{ $select->type == '1' ? 'selected' : '' }} value="1">Cumulative number</option>
												<option {{ $select->type == '2' ? 'selected' : '' }} value="2">Monthly</option>
												<option {{ $select->type == '3' ? 'selected' : '' }} value="3">Weekly</option>
												<option {{ $select->type == '4' ? 'selected' : '' }} value="4">Yearly</option>
											</select>
										</div>
										<div class="col-xs-3">
											<input type="hidden" name="sid[]" value="{{ $select->id }}">
											<input type="text" class="form-control" name="qty[]" placeholder="Number of agents" value="{{ isset($select) ? $select->qty : '' }}" onkeypress="return isNumberKey(event)">
										</div>
										<div class="col-xs-5">
											<input type="text" class="form-control" name="amount[]" placeholder="Amount" value="{{ isset($select) ? $select->amount : '' }}" onkeypress="return isNumberKey(event)">
										</div>
										<div class="col-xs-1">
											<a href="#"  class="important-text del" data-id="{{ $select->id }}">
												<i class="fa fa-trash fa-2x"></i>
											</a>
										</div>
									</div>
								<hr>
								</div>
								@endif
							@endforeach
							<input type="hidden" name="lvl[]" class="agent_lvl" value="{{ $level->id }}">
							<div class="form-group child-box">
								<div class="row">
									<div class="col-xs-3">
										<select class="form-control" name="type[]">
											<option value="1">Cumulative number</option>
											<option value="2">Monthly</option>
											<option value="3">Weekly</option>
											<option value="4">Yearly</option>
										</select>
									</div>
									<div class="col-xs-3">
										<input type="hidden" name="sid[]" value="">
										<input type="text" class="form-control" name="qty[]" placeholder="Number of agents" onkeypress="return isNumberKey(event)">
									</div>
									<div class="col-xs-5">
										<input type="text" class="form-control" name="amount[]" placeholder="Amount" value="" onkeypress="return isNumberKey(event)">
									</div>
									<div class="col-xs-1">
										<a href="#"  class="important-text del">
											<i class="fa fa-trash fa-2x"></i>
										</a>
									</div>
								</div>
							<hr>
							</div>
						</div>

						<div class="form-group ">
							<div class="row justify-content_center">
								<div class="col-md-11" align="center">
									<button class="add-row-btn" id="add-row-btn">
										<i class="fa fa-plus"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		</div>

		<div class="col-sm-6">
			<div class="container-box">
				<h4>Set the cumulative number of agents recommended <i class="fa fa-long-arrow-right" aria-hidden="true"></i> How to set?</h4>
				<hr>
				<h5>
					<b>Cumulative setting</b>
				</h5>
				<hr>
				<ul>
					<li style="margin: 10px 0px; font-size: 14px;">
						<b>Cumulative number</b> - Calculate the total cumulative number of agents <br>
						(Example: This month or this week <b>Agent A</b> has recruited 10 agents Next week or next month, the cumulative number of <b>Agent A</b> will not be reset, it will continue to accumulate)
					</li>

					<li style="margin: 10px 0px; font-size: 14px;">
						<b>Monthly</b> / 
						<b>weekly</b> / 
						<b>yearly</b> 
						agents only Monthly / weekly / yearly total headcount <br>
						(Example: <b>Agent A</b> has recruited <b>10 agents</b> this month / this week / this year. <br>
								  <b>Monthly</b> / 
								  <b>weekly</b> / 
								  <b>yearly</b>, the cumulative number of agents A will be reset and re-accumulated until the following month / next week / year)
					</li>
				</ul>
				<hr>
				<h5>
					<b>Number of agents</b>
				<hr>
				<ul>
					<li style="margin: 10px 0px; font-size: 14px;">
						The agent needs to reach the designated number set by the administrator to get the rebate. <br>
						(Column: the administrator has set a number of 10 to get rebates, when the number of offline agents A reaches 10, you can get the "amount" set by the administrator)
					</li>
				</ul>
				<hr>
				<h5>
					<b>Amount</b>
				<hr>
				<ul>
					<li style="margin: 10px 0px; font-size: 14px;">
						When the agent reaches the designated "Agent Number", agent can get a one-time rebate set by the administrator.
					</li>
				</ul>
			</div>
		</div>
	</div>
	@else
		<h3>Agent Level Needed</h3>
		<p class="important-text">
			Please go to <b>Settings <i class="fa fa-long-arrow-right" aria-hidden="true"></i> Agent Level</b> for add Agent Level first. </p>
	@endif
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

    
    $('.add-row-btn').click(function (e){
    	e.preventDefault();
    	var lvl = $(this).closest('.col-sm-12').find('.agent_lvl').val();
    	$(this).closest('.col-sm-12').find('.container-box .parent-box').append('<input type="hidden" name="lvl[]" class="agent_lvl" value="'+lvl+'">\
															    					<div class="form-group child-box">\
																						<div class="row">\
																							<div class="col-xs-3">\
																								<select class="form-control" name="type[]">\
																									<option value="1">Cumulative number</option>\
																									<option value="2">Monthly</option>\
																									<option value="3">Weekly</option>\
																									<option value="4">Yearly</option>\
																								</select>\
																							</div>\
																							<div class="col-xs-3">\
																								<input type="hidden" name="sid[]" value="">\
																								<input type="text" class="form-control" name="qty[]" placeholder="Number of agents" onkeypress="return isNumberKey(event)">\
																							</div>\
																							<div class="col-xs-5">\
																								<input type="text" class="form-control" name="amount[]" placeholder="Amount" value="" onkeypress="return isNumberKey(event)">\
																							</div>\
																							<div class="col-xs-1">\
																								<a href="#"  class="important-text del">\
																									<i class="fa fa-trash fa-2x"></i>\
																								</a>\
																							</div>\
																						</div>\
																						<hr>\
																					</div>');
    });

    $('.parent-box').on('click', '.del', function (e){
    	e.preventDefault();
    	
    	if($(this).data('id')){
	    	var fd = new FormData();
	        fd.append('id', $(this).data('id'));
	        if(confirm('Confirm delete this row?') == true){
	    		$.ajax({
		            url: '{{ route("deleteAgentBonus") }}',
		            type: 'post',
		            data: fd,
		            contentType: false,
		            processData: false,
		            success: function(response){
		                toastr.error('Row Deleted');
		            },
		        });	        	
	        }else{
	        	return false;
	        }
    	}

    	$(this).closest('.child-box.form-group').remove();
    });
</script>
@endsection