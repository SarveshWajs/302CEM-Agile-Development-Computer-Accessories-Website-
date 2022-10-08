@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Order Report List
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form action="{{ route('order_report') }}" method="GET">
<div class="row">
	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="dates" value="{{ !empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate }}">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="transaction_no" value="{{ !empty(request('transaction_no')) ? request('transaction_no') : '' }}" placeholder="Search Transaction No..">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="buyer" value="{{ !empty(request('buyer')) ? request('buyer') : '' }}" placeholder="Search Buyer..">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="item_code" value="{{ !empty(request('item_code')) ? request('item_code') : '' }}" placeholder="Search Item Code..">
		</div>
	</div>

	<div class="col-sm-2">
		<div class="form-group">
			<input type="text" class="form-control" name="product_code" value="{{ !empty(request('product_code')) ? request('product_code') : '' }}" placeholder="Search Product Code..">
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
					<option {{ (!empty(request('per_page')) && request('per_page') == '10') ? 'selected' : '' }} value="10">10</option>
					<option {{ (!empty(request('per_page')) && request('per_page') == '20') ? 'selected' : '' }} value="20">20</option>
					<option {{ (!empty(request('per_page')) && request('per_page') == '50') ? 'selected' : '' }} value="50">50</option>
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
				<a href="{{ route('order_report') }}" class="btn btn-warning btn-sm">
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
<div class="form-group" align="right">
	<a href="{{ route('print_order_report', ['dates='.(!empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate),
											 'transaction_no='.(!empty(request('transaction_no')) ? request('transaction_no') : ''),
											 'buyer='.(!empty(request('buyer')) ? request('buyer') : '' ),
											 'item_code='.(!empty(request('item_code')) ? request('item_code') : '' ),
											 'product_code='.(!empty(request('product_code')) ? request('product_code') : '' )]) }}" class="print-window btn btn-primary" target="_blank">
		<i class="fa fa-print"></i> Print
	</a>
	<a href="{{ route('exportOrder', ['dates='.(!empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate),
											 'transaction_no='.(!empty(request('transaction_no')) ? request('transaction_no') : ''),
											 'buyer='.(!empty(request('buyer')) ? request('buyer') : '' ),
											 'item_code='.(!empty(request('item_code')) ? request('item_code') : '' ),
											 'product_code='.(!empty(request('product_code')) ? request('product_code') : '' ) ]) }}" target="_blank" class="btn btn-warning">
		<i class="fa fa-download"></i> Export
	</a>
</div>

<div class="row" style="overflow: auto;">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="info">
					<th>#</th>
					<th>Date</th>
					<th>Transaction no</th>
					<th>Buyer</th>
					<th style="text-align: center;">Item Code</th>
					<th style="text-align: center;">Product SKU</th>
					<th>Product Description</th>
					<!-- <th>Unit Price</th> -->
					<th style="text-align: center;">Quantity</th>
					<th style="text-align: right;">Sales (RM)</th>
					<th style="text-align: right;">Net sales (RM)</th>
					<th style="text-align: right;">Total net sales (RM)</th>
					<th style="text-align: right;">Processing fee (RM)</th>
					<th style="text-align: right;">Shipping fee (RM)</th>
					<th style="text-align: right;">Discount (RM)</th>
					<th style="text-align: right;">Agent Discount (RM)</th>
					<th style="text-align: right;">Tax (RM)</th>
					<th style="text-align: right;">Total sales (RM)</th>
					<!-- <th>Action</th> -->
				</tr>
			</thead>
			<tbody>
				@php
				$totalQty = 0;
				$totaluPrice = 0;
				$totalpfee = 0;
				$totalsfee = 0;
				$totalnet = 0;
				$totalTax = 0;
				$totalgrand = 0;
				$totalGrandNet = 0;
				$totalDis = 0;
				$totalAdDis = 0;
				$b = 0;
				@endphp
				@if(!$transactions->isEmpty())
				@foreach($transactions as $key => $transaction)
				<tr>
					
					<td align="left" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid])+1 }}" @else rowspan="2"  @endif>
						{{ $key+1 }}

					</td>
					<td align="left" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid])+1 }}" @else rowspan="2"  @endif>
						{{ ($transaction->created_at) }}
					</td>
					<td align="left" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid])+1 }}" @else rowspan="2"  @endif>
						<a href="{{ route('transaction.transactions.edit', $transaction->Tid) }}">
							{{ $transaction->transaction_no }}
						</a>
					</td>
					<td align="left" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid])+1 }}" @else rowspan="2"  @endif>
						{{ (!empty($transaction->buyer_name)) ? $transaction->buyer_name : $transaction->address_name }}
					</td>
				</tr>
				@php
					$net = 0;
					$a = 0;
					$uprice = 0;
					
				@endphp
				@foreach($details[$transaction->Tid] as $detail)
				@php
					$totalQty += $detail->quantity;
					
					$uprice += $detail->unit_price;
					$net += ($detail->unit_price) * $detail->quantity;
					
				@endphp
				<tr>
					<td align="center">{{ $detail->item_code }}</td>
					<td align="center">{{ $detail->product_code }}</td>
					<td>
						{{ $detail->product_name }}<br>
						{!! ($detail->sub_category != '') ? "Variation: ".$detail->sub_category."<br>" : '' !!}
					</td>
					<td align="center">{{ $detail->quantity }}</td>
					<td align="right">{{ number_format(($detail->unit_price), 2) }}</td>
					<td align="right">{{ number_format(($detail->unit_price) * $detail->quantity, 2) }}</td>

					

					@if($a == 0)
					<td align="right" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid]) }}" @endif>
						{{ number_format(($details2[$transaction->Tid]->totalPrice), 2) }}
					</td>
					<td align="right" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid]) }}" @endif>
						{{ number_format($transaction->processing_fee, 2) }}
					</td>

					<td align="right" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid]) }}" @endif>
						{{ number_format($transaction->shipping_fee, 2) }}
					</td>
					<td align="right" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid]) }}" @endif>
						{{ number_format($transaction->discount, 2) }}
					</td>
					<td align="right" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid]) }}" @endif>
						{{ number_format($transaction->ad_discount, 2) }}
					</td>
					<td align="right" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid]) }}" @endif>
						{{ number_format($transaction->tax, 2) }}
					</td>
					<td align="right" @if(count($details[$transaction->Tid]) > 1) rowspan="{{ count($details[$transaction->Tid]) }}" @endif>
						{{ number_format($details2[$transaction->Tid]->totalPrice - $transaction->discount - $transaction->ad_discount + $transaction->processing_fee + $transaction->shipping_fee + $transaction->tax, 2) }}
					</td>
					@endif

				</tr>
				@php
					$a++;
				@endphp
				@endforeach

					@php
					
					
					$totaluPrice += $uprice;
					$totalnet += $net;
					$totalpfee += $transaction->processing_fee;
					$totalsfee += $transaction->shipping_fee;
					$totalTax += $transaction->tax;
					$totalGrandNet += ($details2[$transaction->Tid]->totalPrice);
					$totalDis += $transaction->discount;
					$totalAdDis += $transaction->ad_discount;
					
					@endphp
					@endforeach
					@else
					<tr>
						<td colspan="12">No Result Found</td>
					</tr>
					@endif

					<tr class="warning">
						<td style=""  colspan="7">
							<b>Page Summary</b>
						</td>
						<td style=" text-align: right;" >
							<b>{{ $totalQty }}
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totaluPrice, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalnet, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalGrandNet, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalpfee, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalsfee, 2) }}</b>
							</td>
							
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalDis, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalAdDis, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalTax, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format(($totalnet) - $totalDis - $totalAdDis + $totalpfee + $totalsfee + $totalTax, 2) }}</b>
							</td>
						</tr>
						<tr class="warning">
							<td style=""  colspan="7">
								<b>Total Summary</b>
							</td>
							<td style=" text-align: right;" >
								<b>{{ $totalT->totalQty }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalT->totalUnitPrice, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalT->totalNet, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format(($totalT->totalNet), 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalT2->totalProcessingFee, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalT2->totalShippingFee, 2) }}</b>
							</td>
							
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalT2->totalDiscount, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalT2->totalAdDiscount, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalT2->totalTax, 2) }}</b>
							</td>
							<td style=" text-align: right;" class="">
								<b>{{ number_format($totalT->totalNet - $totalT2->totalDiscount - $totalT2->totalAdDiscount + $totalT2->totalProcessingFee + $totalT2->totalShippingFee + $totalT2->totalTax, 2) }}</b>
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


	$('.grandTotal').html('{{ number_format($totalT->totalNet - $totalT2->totalDiscount - $totalT2->totalAdDiscount + $totalT2->totalProcessingFee + $totalT2->totalShippingFee + $totalT2->totalTax, 2) }}');

	
</script>
@endsection