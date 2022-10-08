@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Agent About List
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form action="{{ route('agent_about') }}" method="GET">
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
	<a href="{{ route('agent_about') }}" class="btn btn-warning btn-sm">
		<i class="fa fa-refresh"></i> Clear Search
	</a>

	<a href="{{ route('print_agent_list') }}" class="btn btn-warning btn-sm" target="_blank">
		<i class="fa fa-print"></i> Print
	</a>

	<a href="{{ route('exportAgentAbout') }}" target="_blank" class="btn btn-sm btn-warning">
		<i class="fa fa-download"></i> Export
	</a>
</div>
</form>
<div class="row" style="overflow: auto;">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Agent</th>
					<th>About</th>
				</tr>
			</thead>
			<tbody>
				@if (!$merchants->isEmpty())
				@foreach($merchants as $key => $merchant)
				<tr>
					<td width="5%">
						{{ $key+1 }}
						<input type="hidden" class="row_id" value="{{ $merchant->id }}">
					</td>
					<td width="10%">{{ $merchant->f_name }} {{ $merchant->l_name }}<br>({{ $merchant->code }})</td>
					<td>{{ $merchant->about_us }}</td>
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
</script>
@endsection