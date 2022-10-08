<table>
	<tr>
		<th><b>Weshare2you</b></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th align="right">
			<b>Item Profit Report</b>
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
		<th align="right">
			Report Date: {{ $start }} - {{ $end }}
		</th> 
	</tr>
</table>
<table class="table table-bordered">
		<thead>
			<tr class="info">
				<th>Product Description</th>
				<th>Item Code</th>
				<th>Product SKU</th>
				<th>Unit Price</th>
				<th>Net Quantity</th>
				<th>Total Sales (RM)</th>
				<!-- <th>Action</th> -->
			</tr>
		</thead>
		<tbody>
			@php
				$totalQty = 0;
				$totalsfee = 0;
				$totalDiscount = 0;
				$totalgrand = 0;
				$totalUnit = 0;
				$totalNet = 0;
			@endphp
			@if(!$transactions->isEmpty())
			@foreach($transactions as $key => $transaction)
			<tr>
				<td>{{ $transaction->product_name }}</td>
				<td>{{ $transaction->item_code }}</td>
				<td>{{ $transaction->product_code }}</td>
				<td>{{ number_format($transaction->unit_price, 2) }}</td>
				<td>{{ $transaction->totalQty }}</td>
				<td>{{ number_format($transaction->totalNet,2) }}</td>
			</tr>
			@php
				$totalQty += $transaction->totalQty;
				$totalsfee += $transaction->totalShippingFee;
				$totalDiscount += $transaction->totalDiscount;
				$totalDiscount += $transaction->tax;
				$totalgrand += $transaction->totalGrand;
				$totalUnit += $transaction->unit_price;
				$totalNet += $transaction->totalNet;
			@endphp
			@endforeach
			@endif

			<tr class="warning">
				<td>
					<b>Summary</b>
				</td>
				<td></td>
				<td></td>
				<td class="">
					<b>{{ number_format($totalUnit, 2) }}</b>
				</td>
				<td >
					<b>{{ $totalQty }}</b>
				</td>
				<td>
					<b>{{ number_format($totalNet, 2) }}</b>
				</td>
			</tr>
		</tbody>
	</table>