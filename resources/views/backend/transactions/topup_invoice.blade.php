@extends('layouts.admin_app')
<style type="text/css">
	@media print { 
	    table td, table th { 
	        background-color: #ddd !important; 
	    } 
	}

	
</style>
@section('content')
<a href="#" class="print-window" style="display: none;">
	<i class="fa fa-print"></i> Print
</a>
<table width="100%">
	<tr>
		<td>
			@if(!empty($data['admin']->website_logo))
			<img src="{{ url($data['admin']->website_logo) }}" style="width: 100px;">
			@endif
			<h3>{{ $data['admin']->website_name }} Sdn Bhd</h3>
		</td>
		<td align="right">
			<h1>Topup Invoice</h1>
		</td>
	</tr>
	<tr>
		<td>
			<b>Contact number: </b>{{ $data['admin']->phone }}
		</td>
	</tr>
	<tr>
		<td>
			<b>Address: </b>{{ $data['web_setting']->address }}
		</td>
	</tr>
</table>
<br>
<table width="100%">
	<tr>
		<td>
			To:
		</td>
	</tr>
	<tr>
		<td>
			<h4>{{ $transaction->agent_name }} ({{ $transaction->user_id }})</h4>
		</td>
		<td align="right">
			<h4><b>Invoice #{{ $transaction->topup_no }}</b></h4>
		</td>
	</tr>
	<tr>
		<td>
			@if($transaction->mall == 1)
				Payment Method: Wallet
			@else
				Payment Method: {{ ($transaction->topup_payment_method == '1') ? 'Online Transfer' : 'Bank Transfer' }}
			@endif
		</td>
	</tr>
</table>
<hr>
<table class="table table-bordered">
	<tr>
		<td>Particulars</td>
		<td align="right">Unit Price</td>
		<td align="right">Qty</td>
		<td align="right">Amount (MYR)</td>
	</tr>
	<tr>
		<td>
			{{ $transaction->amount_desc }}
		</td>
		<td align="right">
			{{ number_format($transaction->actual_amount, 2) }}
		</td>
		<td align="right">
			x1
		</td>
		<td align="right">
			{{ number_format(($transaction->actual_amount), 2) }}
		</td>
	</tr>
	<tr>
		<td colspan="3" align="right">
			Grand Total:
		</td>
		<td colspan="3" align="right">
			{{ number_format($transaction->actual_amount, 2) }}
		</td>
	</tr>
</table>
@endsection

@section('js')
<script type="text/javascript">
	$('.print-window').click(function() {
	    window.print();
	});
	$(document).ready(function(){
		$('.print-window').click();
		$('.tr-color').css('background-color', '#ddd');
	});
</script>
@endsection