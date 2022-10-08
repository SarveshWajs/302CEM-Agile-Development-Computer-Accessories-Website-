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
	<div class="form-group">
		<table class="table">
			<tr>
				<td>
					<div class="form-group">
						<h3><b>Weshare2you</b></h3>
					</div>
					<div class="form-group">
						<p>Print Dates: {{ date('m/d/Y H:i:s') }}</p>
					</div>
				</td>
				<td align="right">
					<div class="form-group">
						<h3><b>Agent Stock Report</b></h3>
					</div>
					<div class="form-group">
						<p>Report Dates: {{ !empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate }}</p>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr class="info">
				<th>#</th>
				<th>Item Code</th>
				<th>Product Code</th>
				<th>Buyer</th>
				<th style="text-align: right;">Net Quantity</th>
				<th style="text-align: right;">Discounts</th>
				<th style="text-align: right;">Shipping Fee</th>
				<th style="text-align: right;">Net Sales</th>
				<th style="text-align: right;">Tax</th>
				<th style="text-align: right;">Total Sales</th>
			</tr>
		</thead>
		<tbody>
			@php
				$totalQty = 0;
				$totalsfee = 0;
				$totalDiscount = 0;
				$totalTax = 0;
				$totalgrand = 0;
			@endphp
			@if(!$transactions->isEmpty())
			@foreach($transactions as $key => $transaction)
			<tr>
				<td>
					{{ $key+1 }}
					<input type="hidden" name="tid" value="{{ $transaction->Tid }}">
				</td>
				<td>{{ $transaction->item_code }}</td>
				<td>{{ $transaction->product_code }}</td>
				<td>{{ $transaction->buyer_name }}</td>
				<td align="right">{{ $transaction->totalQty }}</td>
				<td align="right">{{ number_format($transaction->totalDiscount, 2) }}</td>
				<td align="right">{{ number_format($transaction->totalShippingFee, 2) }}</td>
				<td align="right">{{ number_format($transaction->totalGrand, 2) }}</td>
				<td align="right">{{ number_format($transaction->tax, 2) }}</td>
				<td align="right">{{ number_format(($transaction->totalGrand + $transaction->tax), 2) }}</td>
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
				$totalQty += $transaction->totalQty;
				$totalsfee += $transaction->totalShippingFee;
				$totalDiscount += $transaction->totalDiscount;
				$totalTax += $transaction->tax;
				$totalgrand += $transaction->totalGrand;
			@endphp
			@endforeach
			@else
			<tr>
				<td colspan="11">No Result Found</td>
			</tr>
			@endif
			<tr class="warning">
				<td colspan="4">
					<b>Summary</b>
				</td>
				<td align="right">
					<b>{{ $totalQty }}</b>
				</td>
				<td align="right">
					<b>{{ number_format($totalDiscount, 2) }}</b>
				</td>
				<td align="right">
					<b>{{ number_format($totalsfee, 2) }}</b>
				</td>
				<td align="right">
					<b>{{ number_format($totalgrand, 2) }}</b>
				</td>
				<td align="right">
					<b>{{ number_format($totalTax, 2) }}</b>
				</td>
				<td align="right">
					<b>{{ number_format($totalgrand, 2) }}</b>
				</td>
			</tr>
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