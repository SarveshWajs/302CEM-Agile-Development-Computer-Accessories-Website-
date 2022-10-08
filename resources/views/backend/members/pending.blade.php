@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Member Pending List
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form action="{{ route('pending_merchant') }}" method="GET">
<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="code" value="{{ !empty('code') && request('code') ? request('code') : '' }}" placeholder="Search Member Code">
		</div>
	</div>
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="member_name" value="{{ !empty('member_name') && request('member_name') ? request('member_name') : '' }}" placeholder="Search Member Name">
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
	<a href="{{ route('pending_merchant') }}" class="btn btn-warning btn-sm">
		<i class="fa fa-refresh"></i> Clear Search
	</a>
</div>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Code</th>
					<th>Upline</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if (!$users->isEmpty())
				@foreach($users as $key => $user)
				<tr>
					<td>{{ $key+1 }}
						<input type="hidden" name='mid' value="{{ $user->id }}">
					</td>
					<td>{{ $user->code }}</td>
					<td>{{ $user->master_id }}</td>
					<td>{{ $user->f_name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->phone }}</td>
					<td><span class="badge badge-warning">Pending</span></td>
					<td>
						<a href="{{ route('member.members.edit', $user->id) }}">
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
					<td colspan="9">No Result Found</td>
				</tr>
				@endif
			</tbody>
		</table>
		{{ $users->links() }}
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
			var action_confirm = confirm('Approve this member?');
		}else{
			var action_confirm = confirm('Reject this member?');
		}
		if(action_confirm == true){
			$.ajax({
		       url: '{{ route("ApproveRejectMember") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){
		       		// alert(response);
		       		$('.loading-gif').hide();
		       		toastr.success('Update Successful');
		       		window.location.href = "{{ route('member.members.index') }}";
		       },
		    });			
		}else{
			$('.loading-gif').hide();
		}
	});
</script>
@endsection