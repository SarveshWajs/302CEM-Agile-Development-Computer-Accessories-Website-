@extends('layouts.app')

@section('content')
	<a href="#" class="print-window" style="display: none;">
		<i class="fa fa-print"></i> Print
	</a>
	<table width="100%">
		<tr>
			<td><h3>Weshare</h3></td>
			<td align="right"><h2>Group Sales Report</h2></td>
		</tr>
		<tr>
			<td>{{ Auth::guard('merchant')->user()->f_name }} ({{ Auth::guard('merchant')->user()->code }})'s Group</td>
			<td align="right"></td>
		</tr>
	</table>
	<hr>
	<table class="table table-bordered">
		<tr>
			<th>#</th>
			<th>Downline</th>
			<th>Personal Sales</th>
			<th>Total Group Sales</th>
		</tr>
		@if(!$groups->isEmpty())
			@foreach($groups as $key => $group)
				<tr>
					<td>{{ $key+1 }}</td>
					<td>
						{{ $group->f_name }} ({{ $group->code }})<br>
						Level: {{ !empty($group->agent_lvl) ? $group->agent_lvl : ' - ' }}<br>
						Generation: {{ $group->sort_level }}<br>
						Upline: {{ $group->upline_name }} ({{ $group->master_id }})
					</td>
					<td>
						{{ !empty($getOwnSales[$group->code]) ? number_format($getOwnSales[$group->code], 2) : '0.00' }}
					</td>
					<td>
						{{ !empty($getTotalGroupTopup[$group->code]) ? number_format($getTotalGroupTopup[$group->code], 2) : '0.00' }}
					</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="4">No Result Found</td>
			</tr>
		@endif
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