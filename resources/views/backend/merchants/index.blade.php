@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Agent List
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form action="{{ route('merchant.merchants.index') }}" method="GET">
<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="code" value="{{ !empty('code') && request('code') ? request('code') : '' }}" placeholder="Search Agent Code">
		</div>
	</div>
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="merchant_name" value="{{ !empty('merchant_name') && request('merchant_name') ? request('merchant_name') : '' }}" placeholder="Search Agent Name">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" name="lvl">
				<option value="">Select Level</option>
				@foreach($agent_lvls as $agent_lvl)
				<option {{ (!empty(request('lvl')) && request('lvl') == $agent_lvl->id) ? 'selected' : '' }} value="{{ $agent_lvl->id }}">{{ $agent_lvl->agent_lvl }}</option>
				@endforeach
			</select>
		</div>
	</div>



	<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" name="status">
				<option value="">Search Status</option>
				<option {{ (!empty(request('status')) && request('status') == '1') ? 'selected' : '' }} value="1">Active</option>
				<option {{ (!empty(request('status')) && request('status') == '2') ? 'selected' : '' }} value="2">Inactive</option>
			</select>
		</div>
	</div>
</div>

<div class="form-group">
	<div class="row">
		<div class="col-sm-2">
			<div class="form-group">
				Row Per Page: <br>
				<select class="input-small" name="per_page">
					<option value="10">10</option>
					<option value="20">20</option>
					<option value="50">50</option>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<button class="btn btn-primary btn-sm">
		<i class="fa fa-search"></i> Search
	</button>
	<a href="{{ route('merchant.merchants.index') }}" class="btn btn-warning btn-sm">
		<i class="fa fa-refresh"></i> Clear Search
	</a>
</div>
</form>
<div class="row" style="overflow: auto;">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Code</th>
					<th>Name</th>
					<th>Level</th>
					<th>Upline</th>
					<th>Product Balance</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if (!$merchants->isEmpty())
				@foreach($merchants as $key => $merchant)
				<tr>
					<td>
						{{ $key+1 }}
						<input type="hidden" class="row_id" value="{{ $merchant->id }}">
					</td>
					<td>{{ $merchant->code }}</td>
					<td>{{ $merchant->f_name }} {{ $merchant->l_name }}</td>
					<td>{{ !empty($merchant->lvl) ? $merchant->l_agent_lvl : ' - ' }}</td>
					<td>{{ $merchant->master_id }}</td>
					<td>{{ $agentProductBalance[$merchant->code] }}</td>
					<td>{{ $merchant->email }}</td>
					<td>{{ $merchant->phone }}</td>
					<td>{!! ($merchant->status == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
					<td>
						<a href="{{ route('merchant.merchants.edit', $merchant->id) }}">
							<i class="ace-icon fa fa-pencil bigger-130"></i> Edit
						</a>

						&nbsp;&nbsp;
						@if($merchant->status == 1)
						<a href="#" class="red change-status" data-id="2">
							<i class="ace-icon fa fa-ban bigger-130"></i> Inactive
						</a>
						@else
						<a href="#" class="green change-status" data-id="1">
							<i class="ace-icon fa fa-check bigger-130"></i> Reactive
						</a>
						@endif

						&nbsp;&nbsp;
						<a href="#" class="red change-status" data-id="3">
							<i class="ace-icon fa fa-trash-o bigger-130"></i> Delete
						</a>

						&nbsp;&nbsp;
						<a href="#" class="blue" data-toggle="modal" data-target="#topup{{ $key }}">
							<i class="ace-icon fa fa-plus bigger-130"></i> Topup
						</a>
						<br>
						<a href="{{ route('adjust', $merchant->id) }}" class="blue">
							<i class="ace-icon fa fa-plus bigger-130"></i> Adjust Product Wallet
						</a>

						<div class="modal fade" id="topup{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Topup for {{ $merchant->f_name }} ({{ $merchant->code }})</h5>
						      </div>
						      <div class="modal-body">
						      		<label>Select Packages</label>
						        	<select class="form-control packages" name="packages">
						        		@foreach($packages as $package)
						        		@php
											$profit_bonus = 0;
											if(!empty($package->profit_amount)){
												if($package->profit_type == 'Percentage'){
													$profit_bonus = $package->topup_amount * $package->profit_amount / 100;
												}else{
													$profit_bonus = $package->profit_amount;
												}
											}
										@endphp
						        		<option value="{{ $package->id }}">
						        			{{ $package->topup_amount }}
						        			@if($profit_bonus > 0)
											+ (RM {{ number_format($profit_bonus, 2) }})
											@endif
						        		</option>
						        		@endforeach
						        	</select>
						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="button" class="btn btn-primary topup-btn">Topup Now</button>
						      </div>
						    </div>
						  </div>
						</div>

						<div class="modal fade" id="adjust{{ $key }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <h5 class="modal-title" id="exampleModalLabel">Topup for {{ $merchant->f_name }} ({{ $merchant->code }})</h5>
						      </div>
						      <div class="modal-body">
						      		<div class="row">
						      			<div class="col-xs-6">
								        	<select class="form-control adjust_type" name="adjust_type">
								        		<option value="1">Increase</option>
								        		<option value="2">Decrease</option>
								        	</select>
						      			</div>
						      			<div class="col-xs-6">
						      				<input type="text" name="adjust_amount" class="form-control adjust_amount" placeholder="Amount">
						      			</div>
						      		</div>
						      		<hr>

						      </div>
						      <div class="modal-footer">
						        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						        <button type="button" class="btn btn-primary adjust-btn">Save Changes</button>
						      </div>
						    </div>
						  </div>
						</div>

						&nbsp;&nbsp;
						<a href="{{ route('tree', [$merchant->code]) }}" class="green">
							<i class="ace-icon fa fa-users bigger-130"></i> Affiliate
						</a>
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="9">No Result Found</td>
				</tr>
				@endif
			</tbody>
		</table>
		{{ $merchants->links() }}
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('.change-status').click(function(){
        $('.loading-gif').show();
        var ele = $(this);
        var row_id = ele.closest('tr').find('.row_id').val();

        var fd = new FormData();
        fd.append('row_id', row_id);
        fd.append('status', ele.data('id'));

        var message;
        if(ele.data('id') == 1){
        	message = confirm("Reactive this row?");
        }else if(ele.data('id') == 2){
        	message = confirm("Inactive this row?");
        }else{
        	message = confirm("Delete this row?");
        }

        if(message == true){
	        $.ajax({
	           url: '{{ route("MerchantStatus") }}',
	           type: 'post',
	           data: fd,
	           contentType: false,
	           processData: false,
	           success: function(response){
	                $('.loading-gif').hide();
	                toastr.success('Status Changed');
	                window.location.href="{{ route('merchant.merchants.index') }}";
	           },
	        });
	    }else{
        	$('.loading-gif').hide();
        }
    });

    $('.topup-btn').click(function (e){
    	e.preventDefault();

    	var ele = $(this);
    	var agent_id = ele.closest('tr').find('.row_id').val();
    	var packages = ele.closest('tr').find('.packages').val();

    	var fd = new FormData();
	        fd.append('pid', packages);
	        fd.append('mid', agent_id);
    	$.ajax({
           url: '{{ route("TopupAgent") }}',
           type: 'post',
           data: fd,
           contentType: false,
           processData: false,
           success: function(response){
                $('.loading-gif').hide();
                toastr.success('Topup Successfully');
                window.location.href="{{ route('merchant.merchants.index') }}";
           },
        });
    });

    $('.adjust-btn').click(function(e){
    	e.preventDefault();

    	var ele = $(this);
    	var agent_id = ele.closest('tr').find('.row_id').val();
    	var adjust_type = ele.closest('tr').find('.adjust_type').val();
    	var adjust_amount = ele.closest('tr').find('.adjust_amount').val();

    	var fd = new FormData();
	        fd.append('adjust_type', adjust_type);
	        fd.append('adjust_amount', adjust_amount);
	        fd.append('mid', agent_id);
    	$.ajax({
           url: '{{ route("AdjustProductWallet") }}',
           type: 'post',
           data: fd,
           contentType: false,
           processData: false,
           success: function(response){
                $('.loading-gif').hide();
                toastr.success('Adjust Successfully');
                window.location.href="{{ route('merchant.merchants.index') }}";
           },
        });
    })
</script>
@endsection