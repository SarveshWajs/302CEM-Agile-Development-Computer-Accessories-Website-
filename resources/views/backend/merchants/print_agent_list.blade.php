@extends('layouts.admin_app')
<style type="text/css">
	@media print{
		@page {
			size: landscape;
			margin: 4mm 0mm;
		}
	}

	
</style>
@section('content')
	<a href="#" class="print-window" style="display: none;">
		<i class="fa fa-print"></i> Print
	</a>
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
@endsection

@section('js')
<script type="text/javascript">
	$('.print-window').click(function() {
	    window.print();
	});
	$(document).ready(function(){
		$('.print-window').click();
	});
</script>
@endsection