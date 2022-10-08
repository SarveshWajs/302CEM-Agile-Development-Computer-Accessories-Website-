@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Affiliate Topup Packages
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>

<form method="POST" action="{{ route('setting_affiliate_topups') }}" id="setting-merchant-form">
	@csrf
	<div class="big-parent">
		<div class="form-group">
			<div class="row">
				<div class="col-xs-6">
					<div class="form-group">
						<h5><b>Topup Amount (RM)</b></h5>
					</div>
				</div>
			</div>
			<div class="child-div">
				@foreach($selects as $select)
				<div class="form-group child-row">
					<div class="row">
						<div class="col-xs-6">
							<input type="text" name="topup_amount[]" class="form-control" placeholder="e.g. 5" value="{{ $select->topup_amount }}">
						</div>
						<div class="col-xs-3">
							<select class="form-control" name="profit_type[]">
								<option {{ $select->profit_type == 'Percentage' ? 'selected' : '' }} value="Percentage">
									Percentage
								</option>
								<option {{ $select->profit_type == 'Amount' ? 'selected' : '' }} value="Amount">
									Amount
								</option>
							</select>
						</div>
						<div class="col-xs-3">
							<input type="text"  name="profit_amount[]" class="form-control" placeholder="e.g. 5" value="{{ $select->profit_amount }}">
						</div>
						<input type="hidden" name="tid[]" value="{{ $select->id }}">
					</div>
				</div>
				@endforeach
				<div class="form-group child-row">
					<div class="row">
						<div class="col-xs-6">
							<input type="text" name="topup_amount[]" class="form-control" placeholder="e.g. 5">
							<input type="hidden" name="tid[]" value="">
						</div>
						<div class="col-xs-3">
							<select class="form-control" name="profit_type[]">
								<option value="Percentage">
									Percentage
								</option>
								<option value="Amount">
									Amount
								</option>
							</select>
						</div>
						<div class="col-xs-3">
							<input type="text"  name="profit_amount[]" class="form-control" placeholder="e.g. 5">
						</div>
					</div>
				</div>
			</div>					
		</div>
		<hr>
		<div class="form-group">
			<div class="row">
				<div class="col-md-12" align="center">
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
@endsection

@section('js')
<script type="text/javascript">
	var add_new_row = '<div class="form-group child-row">\
							<div class="row">\
								<div class="col-xs-6">\
									<input type="text" name="topup_amount[]" class="form-control" placeholder="e.g. 5">\
									<input type="hidden" name="tid[]" value="">\
								</div>\
								<div class="col-xs-3">\
									<select class="form-control" name="profit_type[]">\
										<option value="Percentage">\
											Percentage\
										</option>\
										<option value="Amount">\
											Amount\
										</option>\
									</select>\
								</div>\
								<div class="col-xs-3">\
									<input type="text"  name="profit_amount[]" class="form-control" placeholder="e.g. 5">\
								</div>\
							</div>\
						</div>';
    $('.add-row-btn').click(function(e){
    	e.preventDefault();
    	var ele = $(this);

    	ele.closest('.big-parent').find('.child-div').append(add_new_row);
    	
    });

    $('.submit-form-btn .btn-primary').click( function(e){
    	e.preventDefault();
		
    	$('#setting-merchant-form').submit();
    });
</script>
@endsection