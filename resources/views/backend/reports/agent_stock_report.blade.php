@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Stock Report List
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form action="{{ route('agent_stock_report') }}" method="GET">
<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="dates" value="{{ !empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate }}">
		</div>
	</div>
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="item_code" value="{{ !empty(request('item_code')) ? request('item_code') : '' }}" placeholder="Search Item Code..">
		</div>
	</div>
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="buyer" value="{{ !empty(request('buyer')) ? request('buyer') : '' }}" placeholder="Search Buyer..">
		</div>
	</div>
<!-- 	<div class="col-sm-2">
		<div class="form-group">
			<select class="form-control" name="status">
				<option value="">Select Status</option>
				<option {{ (!empty(request('status')) && request('status') == '1') ? 'selected' : '' }} value="1">Paid</option>
				<option {{ (!empty(request('status')) && request('status') == '99') ? 'selected' : '' }} value="99">Unpaid</option>
			</select>
		</div>
	</div> -->

	
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
				<a href="{{ route('agent_stock_report') }}" class="btn btn-warning btn-sm">
					<i class="fa fa-refresh"></i> Clear Search
				</a>
			</div>
		</div>
	</div>
</div>
</form>
<div class="form-group">
	<span class="badge label-info" style="font-size: 1.5rem; padding: 10px;">
		Dates: {{ !empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate }}
	</span>
	|
	<span class="badge label-success" style="font-size: 1.5rem; padding: 10px;">
		Grand total: <span class="grandTotal"></span>
	</span>
</div>
<hr>
<!-- <div class="form-group" align="right">
	<a href="{{ route('print_agent_stock_report', ['dates='.(!empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate), 
												   'buyer='.(!empty(request('buyer')) ? request('buyer') : '')]) }}" class="print-window btn btn-primary" target="_blank">
		<i class="fa fa-print"></i> Print
	</a>
	
	<a href="{{ route('exportAgentStockReport', ['dates='.(!empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate), 
												 'buyer='.(!empty(request('buyer')) ? request('buyer') : '')]) }}"])}}" target="_blank" class="btn btn-warning">
		<i class="fa fa-download"></i> Export
	</a>
</div> -->

<div class="row" style="overflow: auto;">
	<div class="col-xs-12">
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
					<td align="right" >
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
		{{ $transactions->links() }}
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('input[name=dates]').daterangepicker({
		'applyClass' : 'btn-sm btn-success',
		'cancelClass' : 'btn-sm btn-default',
		locale: {
			applyLabel: 'Apply',
			cancelLabel: 'Cancel',
		}
	})
	.prev().on(ace.click_event, function(){
		$(this).next().focus();
	});

	$('.grandTotal').html('{{ number_format($totalgrand, 2) }}');
</script>
@endsection