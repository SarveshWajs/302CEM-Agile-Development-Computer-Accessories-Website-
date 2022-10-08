@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Agent Pending List
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
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Upline</th>
					<th>Code</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Bank Slip</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if (!$merchants->isEmpty())
				@foreach($merchants as $key => $merchant)
				<tr>
					<td>{{ $key+1 }}
						<input type="hidden" name='mid' value="{{ $merchant->id }}">
					</td>
					<td>{{ $merchant->master_id }}</td>
					<td>{{ $merchant->code }}</td>
					<td>{{ $merchant->f_name }} {{ $merchant->l_name }}</td>
					<td>{{ $merchant->email }}</td>
					<td>{{ $merchant->phone }}</td>
					<td>
						@if(!empty($topup_bank_slip[$merchant->code]->bank_slip))
							<a href="#" data-toggle="modal" data-target="#myModal">
								<img src="{{ url($topup_bank_slip[$merchant->code]->bank_slip) }}" width="100px">						
							</a>

							<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-body">
							        <img src="{{ url($topup_bank_slip[$merchant->code]->bank_slip) }}" width="100%">
							      </div>
							    </div>
							  </div>
							</div>
						@endif
					</td>
					<td><span class="badge badge-warning">Pending</span></td>
					<td>
						<a href="{{ route('merchant.merchants.edit', $merchant->id) }}">
							<i class="ace-icon fa fa-pencil bigger-130"></i> Edit
						</a>
						|
						<a href="#" class=" change_action green" data-id="1">
							<i class="ace-icon fa fa-check bigger-130"></i> Approve
						</a>
						|
						<a href="#" class=" change_action red" data-id="98">
							<i class="ace-icon fa fa-ban bigger-130"></i> Reject
						</a>
						<!-- &nbsp;&nbsp;
						<a href="#" class="red">
							<i class="ace-icon fa fa-trash-o bigger-130"></i>
						</a> -->
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="7">No Result Found</td>
				</tr>
				@endif
			</tbody>
		</table>
		{{ $merchants->links() }}
	</div>
</div>
</form>
@endsection

@section('js')
<script type="text/javascript">
	$('.change_action').click( function(e){
		e.preventDefault();

		$('.loading-gif').show();
		var ele = $(this);
		var action_id = $(this).data('id');
		var mid = $(this).closest('tr').find('input[name="mid"]').val();
		var fd = new FormData();
		fd.append('action_id', action_id);
		fd.append('mid', mid);

		if(action_id == '1'){
			var action_confirm = confirm('Approve this agent?');
		}else{
			var action_confirm = confirm('Reject this agent?');
		}
		if(action_confirm == true){
			$.ajax({
		       url: '{{ route("ApproveRejectMerchant") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){
		       		// alert(response);
		       		$('.loading-gif').hide();
		       		toastr.success('Update Successful');
		       		window.location.href = "{{ route('merchant.merchants.index') }}";
		       },
		    });			
		}else{
			$('.loading-gif').hide();
		}
	});
</script>
@endsection