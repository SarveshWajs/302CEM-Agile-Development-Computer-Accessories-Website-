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
		<th></th>
		<th></th>
		<th></th>
		<th align="right">
			<b>Order Report</b>
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
					<b>{{ $totalQty }}</b>
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
			</tbody>
		</table>