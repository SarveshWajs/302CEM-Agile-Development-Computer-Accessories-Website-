@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Transaction List
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form action="{{ route('transaction.transactions.index') }}" method="GET">
<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="transaction_no" value="{{ !empty(request('transaction_no')) ? request('transaction_no') : '' }}" placeholder="Search Transaction No..">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" name="status">
				<option value="">Select Status</option>
				<option {{ (!empty(request('status')) && request('status') == '1') ? 'selected' : '' }} value="1">Paid</option>
				<option {{ (!empty(request('status')) && request('status') == '98') ? 'selected' : '' }} value="98">Waiting Verification</option>
				<option {{ (!empty(request('status')) && request('status') == '96') ? 'selected' : '' }} value="96">Rejected</option>
				<option {{ (!empty(request('status')) && request('status') == '99') ? 'selected' : '' }} value="99">Unpaid</option>
			</select>
		</div>
	</div>

	
</div>

<div class="form-group">
	<div class="row">
		<div class="col-sm-2">
			<div class="form-group">
				Item Per Page: <br>
				<select class="input-small" name="per_page">
					<option {{ (!empty(request('per_page')) && request('per_page') == '10') ? 'selected' : '' }} value="10">10</option>
					<option {{ (!empty(request('per_page')) && request('per_page') == '20') ? 'selected' : '' }} value="20">20</option>
					<option {{ (!empty(request('per_page')) && request('per_page') == '50') ? 'selected' : '' }} value="50">50</option>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<button class="btn btn-primary btn-sm">
					<i class="fa fa-search"></i> Search
				</button>
				<a href="{{ route('transaction.transactions.index') }}" class="btn btn-warning btn-sm">
					<i class="fa fa-refresh"></i> Clear Search
				</a>
			</div>
		</div>
	</div>
</div>
<hr>
<div class="form-group">
	<span class="badge label-success" style="font-size: 1.5rem; padding: 10px;">
		Grand total: <span class="grandTotal"></span>
	</span>
	|
	<span class="badge label-warning" style="font-size: 1.5rem; padding: 10px;">
		Net Total: <span class="netTotal"></span>
	</span>
</div>

<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Transaction No</th>
					<th>Customer</th>
					<!-- <th>Product</th>
					<th>Category</th>
					<th>Price (RM)</th> -->
					<th>Quantity</th>
					<th>Shipping Fee (RM)</th>
					<th>Processing Fee (RM)</th>
					<th>Total Amount (RM)</th>
					<th>Status</th>
					<th>Created</th>
					<th></th>
					<!-- <th>Action</th> -->
				</tr>
			</thead>
			<tbody>
				@php
				$totalTransaction = 0;
				@endphp
				@if(!$transactions->isEmpty())
				@foreach($transactions as $key => $transaction)
				<tr>
					<td>{{ $key+1 }}
						<input type="hidden" name="tid" value="{{ $transaction->Tid }}">
					</td>
					<td>{{ $transaction->transaction_no }}</td>
					<td>{{ $transaction->customer_name }}</td>
					<!-- <td>{{ $transaction->product_name }}</td>
					<td>{{ !empty($transaction->sub_category) ? $transaction->sub_category."°" : '-' }}</td>
					<td>{{ $transaction->unit_price }}</td> -->
					<td>{{ $transaction->quantity }}</td>
					<td>{{ number_format($transaction->shipping_fee, 2) }}</td>
					<td>{{ number_format($transaction->processing_fee, 2) }}</td>
					<td>{{ number_format($transaction->grand_total, 2) }}</td>
					<td>
						@if($transaction->status == 99)
							<span class="badge badge-pill badge-warning">Unpaid</span>
						@elseif($transaction->status == 98)
							<span class="badge badge-pill badge-info">Waiting Verification</span>
						@elseif($transaction->status == 97)
							<span class="badge badge-pill badge-info">In-progress</span>
						@elseif($transaction->status == '96')
							<span class="badge badge-danger">Rejected</span>
						@elseif($transaction->status == 1)
							<span class="badge badge-success">Paid</span>
						@else
							<span class="badge badge-pill badge-danger">Cancelled</span>
						@endif
					</td>
					<td>{{ ($transaction->created_at) }}</td>
					<td>
						<a href="{{ route('transaction.transactions.edit', $transaction->Tid) }}">
							<i class="fa fa-eye"></i> View
						</a>
						&nbsp;&nbsp;
						<div class="btn-group">
						  <button type="button" class="btn btn-default btn-sm  dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						    Action <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu" role="menu">
						    <li><a href="#" class="change_action" data-id="1">Approve</a></li>
						    <li><a href="#" class="change_action" data-id="96">Reject</a></li>
						  </ul>
						</div>
					</td>
					<!-- <td>
						<a href="">
							<i class="ace-icon fa fa-pencil bigger-130"></i>
						</a>
						&nbsp;&nbsp;
						<a href="#" class="red">
							<i class="ace-icon fa fa-trash-o bigger-130"></i>
						</a>
					</td> -->
				</tr>
				@php
				if($transaction->status == '1'){
					$totalTransaction += $transaction->grand_total;
				}
				@endphp
				@endforeach
				@else
				<tr>
					<td colspan="10">No Result Found</td>
				</tr>
				@endif
			</tbody>
		</table>
		
	</div>
</div>
</form>
@endsection

@section('js')
<script type="text/javascript">
	$('.change_action').click( function(){

		$('.loading-gif').show();

		var ele = $(this);
		var action_id = $(this).data('id');
		var tid = $(this).closest('tr').find('input[name="tid"]').val();
		var fd = new FormData();
		fd.append('action_id', action_id);
		fd.append('tid', tid);
		if(action_id == '1'){
			var confirmMessage = confirm('Complete This Transaction?');
		}else if(action_id == '95'){
			var confirmMessage = confirm('Cancel This Transaction? ');
		}else if(action_id == '96'){
			var confirmMessage = confirm('Reject This Transaction?');
		}else if(action_id == '11'){
			var confirmMessage = confirm('Delivered?');
		}


		if(confirmMessage == true){
			$.ajax({
		       url: '{{ route("change_transaction_action") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){
		       		$('.loading-gif').hide();
		       		// alert(response);
		       		toastr.success('Update Successful');
		       		window.location.href = "{{ route('transaction.transactions.index') }}";
		       		// if(action_id == '1'){
		       		// 	ele.closest('tr').find('.status_id').html('<span class="badge badge-success">Approved</span>');
		       		// }else if(action_id == '98'){
		       		// 	ele.closest('tr').find('.status_id').html('<span class="badge badge-danger">Rejected</span>');
		       		// }else{
		       		// 	ele.closest('tr').find('.status_id').html('<span class="badge badge-danger">Cancelled</span>');
		       		// }
		       },
		    });			
		}else{
			$('.loading-gif').hide();
		}
	});
</script>

<script type="text/javascript">


	$('.grandTotal').html('{{ number_format($totalTransaction, 2) }}');
	$('.netTotal').html('{{ number_format($netTransaction->netTotal, 2) }}');
</script>
@endsection