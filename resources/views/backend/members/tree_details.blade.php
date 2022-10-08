@extends('layouts.admin_app')

@section('content')

<div class="page-header">
    <h1>
        {{ Request::segment(2) }}
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            {{ $generation }} Generation Downline List
        </small>
    </h1>
</div>

<form action="{{ route('member.members.index') }}" method="GET">
	<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="code" value="{{ !empty('code') && request('code') ? request('code') : '' }}" placeholder="Search Member Code">
		</div>
	</div>
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="member_name" value="{{ !empty('company_name') && request('company_name') ? request('company_name') : '' }}" placeholder="Search Member Name">
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
</form>
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
	<a href="{{ route('member.members.index') }}" class="btn btn-warning btn-sm">
		<i class="fa fa-refresh"></i> Clear Search
	</a>
</div>

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
					<td>
						{{ $key+1 }}
						<input type="hidden" class="row_id" value="{{ $user->id }}">
					</td>
					<td>{{ $user->code }}</td>
					<td>{{ $user->f_name }} {{ $user->l_name }}</td>
					<td>{{ !empty($user->lvl) ? $user->l_agent_lvl : ' - ' }}</td>
					<td>{{ $user->master_id }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $user->phone }}</td>
					<td>{!! ($user->status == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
					<td>
						<a href="{{ route('merchant.merchants.edit', $user->id) }}">
							<i class="ace-icon fa fa-pencil bigger-130"></i> Edit
						</a>

						&nbsp;&nbsp;
						@if($user->status == 1)
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
						<a href="{{ route('tree', [$user->code]) }}" class="green">
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

        $.ajax({
           url: '{{ route("MerchantStatus") }}',
           type: 'post',
           data: fd,
           contentType: false,
           processData: false,
           success: function(response){
                $('.loading-gif').hide();
                toastr.success('Status Changed');
                window.location.href="{{ route('member.members.index') }}";
           },
        });
    });
</script>
@endsection