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
		Page total: <span class="grandTotal"></span>
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
					<th>Net Amount (RM)</th>
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
						<input type="hidden" name="tid" class="tid" value="{{ $transaction->Tid }}">
					</td>
					<td>{{ $transaction->transaction_no }}</td>
					<td>{{ !empty($transaction->customer_name) ? $transaction->customer_name : $transaction->address_name }}</td>
					<td>{{ number_format($transaction->grand_total - $transaction->shipping_fee - $transaction->processing_fee, 2) }}</td>
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
							@if($transaction->completed == 1)
								<span class="badge badge-success">Delivered</span>
							@elseif($transaction->completed != 1 && $transaction->to_receive)
								<span class="badge badge-success">To Reveice</span>
							@else
								<span class="badge badge-success">Paid</span>
							@endif
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
						@if($transaction->status == '1' && $transaction->completed != '1')
						<div class="btn-group">
						  	<button type="button" class="btn btn-default btn-sm  dropdown-toggle" data-toggle="dropdown"
						  			aria-expanded="false">
						    Action <span class="caret"></span>
						  	</button>
						  	@if($transaction->completed != '1' && $transaction->to_receive != '1')
						  		<ul class="dropdown-menu" role="menu">
								  	<li><a href="#" class="change_action" data-id="12">To Receive</a></li>
								</ul>
						  	@else
								<ul class="dropdown-menu" role="menu">
								  	<li><a href="#" class="change_action" data-id="11">Completed</a></li>
								</ul>
						  	@endif
						</div>
						@endif
						@if($transaction->status == '98')
						<div class="btn-group">
						  <button type="button" class="btn btn-default btn-sm  dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						    Action <span class="caret"></span>
						  </button>

						  <ul class="dropdown-menu" role="menu">
								    <li><a href="#" class="change_action" data-id="1">Approve</a></li>
								    <li><a href="#" class="change_action" data-id="96">Reject</a></li>
							</ul>
						</div>
						  	
						@endif
						&nbsp;&nbsp;
						<a href="#" class="change_action important-text" data-id="95">
							<i class='fa fa-trash-o'></i> Cancel
						</a>
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
		{{ $transactions->links() }}
	</div>
</div>
</form>
<div class="modal fade" id="courier_service" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modaltracking_no" style="background: #fff;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">We are looking for a courier service for you...</h4>
      </div>
      <div class="modal-body">
      		<form method="POST" action="" class="courier_service_form">
      			@csrf
        		<div class="courier_service_list" style="overflow: auto;"></div>      			
      		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary submit-service-id">Submit</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog bs-example-modal-sm" role="document">
    <div class="modal-content">
      <form method="POST" action="{{ route('add_awb_no') }}">
      @csrf
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title awb-title" id="myModalLabel">Add Awb No</h4>
	      </div>
	      <div class="modal-body">
	      	<input type="hidden" class="transaction_id" name="transaction_id">
	      		<div class="form-group">
	        		<input type="text" class="form-control" name="courier" placeholder="Courier Company Name">
	      		</div>
	      		<div class="form-group">
	        		<input type="text" class="form-control" name="awb_no" placeholder="Awb No">
	      		</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('.change_action').click( function(){

		// $('.loading-gif').show();

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
		}else if(action_id == '12'){
			var confirmMessage = confirm('To Receive?');
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
		       		// alert(response);
		       		// return false;
		       		toastr.success('Update Successful');
		       		window.location.href = "{{ route('transaction.transactions.index') }}";
		       		if(action_id == '1'){
		       			ele.closest('tr').find('.status_id').html('<span class="badge badge-success">Approved</span>');
		       		}else if(action_id == '98'){
		       			ele.closest('tr').find('.status_id').html('<span class="badge badge-danger">Rejected</span>');
		       		}else{
		       			ele.closest('tr').find('.status_id').html('<span class="badge badge-danger">Cancelled</span>');
		       		}
		       },
		    });			
		}else{
			$('.loading-gif').hide();
		}
	});

	$('.courier_service_selection').click( function(e){
		$('.loading-gif').show();
		$('.courier_service_list').html(" ");
		var ele = $(this);

		var action_id = ele.data('id');
		var tid = $(this).closest('tr').find('input[name="tid"]').val();
		var fd = new FormData();
		fd.append('action_id', action_id);
		fd.append('tid', tid);

		$.ajax({
		       url: '{{ route("courier_service_list") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){

		       		if(response == 'pick uptracking_no error'){
		       			$('.courier_service_list').html("You need to fill in the pickup address first. Please go to <b>Setting -> Setting Pickup address</b> Fill in your information");
		       		}else{
		       			$('.modal-title').html('Courier service found for you');
		       			$('.courier_service_list').html(response);
		       		}

		       		$('select[name="drop_off_point"]').change( function(){
		       			var ele_select = $(this);

		       			if(ele_select.val()){
			       			var detail = ele_select.val().split(',');
			       			ele_select.closest('tr').find('.dropoff_details').html('<i class="fa fa-home"></i> '+detail[1]);
		       			}else{
		       				ele_select.closest('tr').find('.dropoff_details').html(' ');
		       			}
		       		});

		       		$('.loading-gif').hide();
		       },
		});
	});

	$('.submit-service-id').click( function(e){
		$('.loading-gif').show();
		var tid = $('input[name="service_id"]:checked').closest('tr').find('input[name="tid"]').val();
		// var collect_date = $('.courier_service_list').find('input[name="collect_date"]').val();
		var collect_date = $('input[name="service_id"]:checked').closest('tr').find('input[name="collect_date"]').val();
		var courier_logo = $('input[name="service_id"]:checked').closest('tr').find('input[name="courier_logo"]').val();
		var sid = $('.courier_service_list').find('input[name="service_id"]:checked').val();
		var bid = $('input[name="service_id"]:checked').closest('tr').next('tr').find('select[name="drop_off_point"]').val();
		var type = $('input[name="service_id"]:checked').closest('tr').find('.service_detail').html();
		
		if(tid && sid){
			if(type == 'dropoff' && !bid){
				alert('您需要选择下车地点');
				$('.loading-gif').hide();
			}

			var fd = new FormData();
				fd.append('tid', tid);
				fd.append('sid', sid);
				fd.append('collect_date', collect_date);
				fd.append('courier_logo', courier_logo);

			$.ajax({
		       url: '{{ route("courier_make_order") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){
		       		if(response == 1){
		       			alert('成功');
		       			window.location.href = "{{ route('transaction.transactions.index') }}";
		       		}else if(response == 2){
		       			alert('信用不足');
		       		}else{
		       			alert('错误! 请联络制作团队');
		       		}
		       		$('.loading-gif').hide();
		       		
		       },
			});

		}else{
			alert('请选择您要的快递服务');
			$('.loading-gif').hide();
		}
	});

	$('.add-new-awb-no').click( function(e){
		var ele = $(this);

		var tid = ele.closest('tr').find('.tid').val();
		var awb_no = ele.data('id');
		var courier = ele.data('name');

		$('.transaction_id').val(tid);
		$('input[name="awb_no"]').val(awb_no);
		$('input[name="courier"]').val(courier);
		
		if(awb_no != ''){
			$('.awb-title').html('Edit Awb No');
		}else{
			$('.awb-title').html('Add Awb No');
		}
	});
</script>

<script type="text/javascript">


	$('.grandTotal').html('{{ number_format($totalTransaction, 2) }}');
	$('.netTotal').html('{{ number_format($netTransaction->netTotal, 2) }}');
</script>
@endsection