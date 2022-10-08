@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Promotion List
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form action="{{ route('promotion.promotions.index') }}" method="GET">
<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="promotion_title" value="{{ !empty(request('promotion_title')) ? request('promotion_title') : '' }}" placeholder="Search Promotion Name..">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" name="status">
				<option value="">Select Status</option>
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
				Item Per Page: <br>
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
				<a href="{{ route('promotion.promotions.index') }}" class="btn btn-warning btn-sm">
					<i class="fa fa-refresh"></i> Clear Search
				</a>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Promotion Title</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Available Voucher</th>
					<th>Redeemed Voucher</th>
					<th>Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				@if(!$promotions->isEmpty())
				@foreach($promotions as $key => $promotion)
				<tr>
					<td>{{ $key+1 }}
						<input type="hidden" class="row_id" value="{{ $promotion->id }}">
					</td>
					<td>{{ $promotion->promotion_title }}</td>
					<td>{{ $promotion->start_date }}</td>
					<td>{{ $promotion->end_date }}</td>
					<td>{{ $available[$promotion->id] }}</td>
					<td>{{ $redeemed[$promotion->id] }}</td>
					<td>{!! ($promotion->status == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>' !!}</td>
					<td>
						<a href="{{ route('promotion.promotions.edit', $promotion->id) }}">
							<i class="ace-icon fa fa-pencil bigger-130"></i> Edit
						</a>
						&nbsp;&nbsp;
						@if($promotion->status == 1)
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
					</td>
				</tr>
				@endforeach
				@else
				<tr>
					<td colspan="6">No Result Found</td>
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
		$('.change-status').click(function(){
	        $('.loading-gif').show();
	        var ele = $(this);
	        var row_id = ele.closest('tr').find('.row_id').val();

	        var fd = new FormData();
	        fd.append('row_id', row_id);
	        fd.append('status', ele.data('id'));

	        $.ajax({
	           url: '{{ route("PromotionStatus") }}',
	           type: 'post',
	           data: fd,
	           contentType: false,
	           processData: false,
	           success: function(response){
	                $('.loading-gif').hide();
	                toastr.success('Status Changed');
	                window.location.href="{{ route('promotion.promotions.index') }}";
	           },
	        });
	    });
	</script>
@endsection