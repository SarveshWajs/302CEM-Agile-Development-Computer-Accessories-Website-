@extends('layouts.admin_app')

@section('content')



		



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
                window.location.href="{{ route('merchant.merchants.index') }}";
           },
        });
    });
</script>
@endsection