@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Topup List 
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form action="{{ route('topup_list') }}" method="GET">
<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="topup_no" value="{{ !empty(request('topup_no')) ? request('topup_no') : '' }}" placeholder="Search Topup No..">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="agent_name" value="{{ !empty(request('agent_name')) ? request('agent_name') : '' }}" placeholder="Search Agent Name..">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" name="status">
				<option value="">Search By Status</option>
				<option {{ (!empty(request('status')) && request('status') == '1') ? 'selected' : '' }} value="1">Approved</option>
				<option {{ (!empty(request('status')) && request('status') == '98') ? 'selected' : '' }} value="98">Rejected</option>
				<option {{ (!empty(request('status')) && request('status') == '99') ? 'selected' : '' }} value="99">Pending</option>
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
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<button class="btn btn-primary btn-sm">
					<i class="fa fa-search"></i> Search
				</button>
				<a href="{{ route('topup_list') }}" class="btn btn-warning btn-sm">
					<i class="fa fa-refresh"></i> Clear Search
				</a>
			</div>
		</div>
	</div>
</div>
</form>
<div class="row" style="overflow: auto; padding-bottom: 50px;">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Topup No</th>
					<th>Method</th>
					<th>Agent</th>
					<th>Amount (RM)</th>
					<th>Description</th>
					<th>Bank Slip</th>
					<th>Status</th>
					<th>Created At</th>
					<th>Updated At</th>
					<th></th>
					<!-- <th>Action</th> -->
				</tr>
			</thead>
			<tbody>
				
				@if(!$topups->isEmpty())
				@foreach($topups as $key => $transaction)
				<tr>
					<td>
						{{ $key+1 }}
						<input type="hidden" name="tid" value="{{ $transaction->id }}">
					</td>
					<td>{{ $transaction->topup_no }}</td>
					<td>{{ ($transaction->topup_payment_method == '1') ? 'Online Banking' : 'Bank Transfer' }}</td>
					<td>{{ $transaction->agent_name }}</td>
					<td>{{ number_format($transaction->actual_amount, 2) }}</td>
					<td>{{ $transaction->amount_desc }}</td>
					<td>
						@if($transaction->bank_slip)
							<a href="#" data-toggle="modal" data-target="#{{ $transaction->id }}">
								<div style="background-image: url({{ url($transaction->bank_slip) }});
											background-size: cover;
											background-position: center;
											background-repeat: no-repeat;
											width: 100px;
											height: 100px;">
								</div>
							</a>

							<div class="modal fade" id="{{ $transaction->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
							    <div class="modal-content">
							        <div class="modal-body">
							        	<img src="{{ url($transaction->bank_slip) }}" width="100%">
							        </div>
							    </div>
							  </div>
							</div>
						@endif
					</td>
					<td class="status_id">
						@if($transaction->status == '1')
							<span class="badge badge-success">Approved</span>
						@elseif($transaction->status == '99')
							<span class="badge badge-warning">Pending</span>
						@elseif($transaction->status == '98')
							<span class="badge badge-danger">Rejected</span>
						@else
							<span class="badge badge-danger">Cancelled</span>
						@endif
					</td>
					<td>{{ $transaction->created_at }}</td>
					<td>{{ $transaction->updated_at }}</td>
					<td>
						
						@if($transaction->status != '97')
						<div class="btn-group">
						  	<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						    	Action <span class="caret"></span>
						  	</button>
						  	<ul class="dropdown-menu" role="menu">
							  	@if($transaction->status == '1')
							  		<li><a href="#" data-id="95" class="change_action">Cancel This Topup</a></li>
							  	@else
								    <li><a href="#" data-id="1" class="change_action">Approve</a></li>								    
								    <li><a href="#" data-id="98" class="change_action">Reject</a></li>
								@endif
						  	</ul>
						</div>
						@endif

						&nbsp;&nbsp;
						@if($transaction->status == '1')
						<a href="{{ route('topup_invoice', $transaction->topup_no) }}" target="_blank">
							<i class='fa fa-print'></i> Print Invoice
						</a>
						@endif
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="12">No Result Found</td>
				</tr>
				@endif
			</tbody>
		</table>
		
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
        	Upload Bank Slip
        </h4>
      </div>
      	<form method="POST" action="{{ route('uploadBankSlip') }}" enctype="multipart/form-data">
        @csrf
	      <div class="modal-body">
	        	<input type="hidden" name="withAction" class="withAction">
	        	<input type="hidden" name="wid" class="wid">
	        	<input type="file" name="uploadSlip" required>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        <button type="submit" class="btn btn-primary">Submit</button>
	      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
	$('.change_action').click( function(e){
		e.preventDefault();
				
		var ele = $(this);
		var action_id = $(this).data('id');
		var tid = $(this).closest('tr').find('input[name="tid"]').val();
		var fd = new FormData();
		fd.append('action_id', action_id);
		fd.append('tid', tid);


		if(action_id == '1'){
			var confirmMessage = confirm('Approve this Topup?');
		}else if(action_id == '95'){
			var confirmMessage = confirm('Cancel this Topup? ');
		}else if(action_id == '98'){
			var confirmMessage = confirm('Reject this Topup?');
		}

		if(confirmMessage == true){
			$.ajax({
		       url: '{{ route("change_topup_action") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){
		       		// alert(response);
		       		// return false;
		       		toastr.success('Update Successful');
		       		if(action_id == '1'){
		       			location.reload();
		       		}else if(action_id == '97'){
		       			location.reload();
		       		}else{
		       			location.reload();
		       		}
			       	
		    	},
			});			
		}else{
			
		}
	});

	$('.upload-slip').click( function(e){
		e.preventDefault();
		var ele = $(this);
		$('.wid').val(ele.data('id'));
		
		if(ele.hasClass('WAction')){
			$('.withAction').val(1);
		}else{
			$('.withAction').val(0);
		}
	});
</script>
@endsection