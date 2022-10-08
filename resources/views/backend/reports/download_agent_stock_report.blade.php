<table>
	<tr>
		<th><b>Weshare2you</b></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th align="right">
			<b>Agent Stock Report</b>
		</th>
	</tr>
	<tr>
		<th>
			Print Date: {{ date('Y-m-d H:i:s') }}
		</th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th align="right">
			Report Date: {{ $start }} - {{ $end }}
		</th> 
	</tr>
</table>
<table class="table table-bordered">
	<thead>
		<tr class="info">
			<th><b>Item Code</b></th>
			<th><b>Product Code</b></th>
			<th><b>Buyer</b></th>
			<th style="text-align: right;"><b>Net Quantity</b></th>
			<th style="text-align: right;"><b>Discounts</b></th>
			<th style="text-align: right;"><b>Shipping Fee</b></th>
			<th style="text-align: right;"><b>Net Sales</b></th>
			<th style="text-align: right;"><b>Tax</b></th>
			<th style="text-align: right;"><b>Total Sales</b></th>
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
			<td>
				<b>Summary</b>
			</td>
			<td></td>
			<td></td>
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