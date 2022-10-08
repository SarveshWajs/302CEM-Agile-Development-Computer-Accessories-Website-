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
						<h3><b>Commission Report</b></h3>
					</div>
					<div class="form-group">
						<p>Report Dates: {{ !empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate }}</p>
					</div>
				</td>
			</tr>
		</table>
	</div>
	<div class="row" style="overflow: auto;">
		<div class="col-xs-12">
			<table class="table table-bordered">
				<thead>
					<tr class="success">
						<th><b>Bonus Type</b></th>
						<th><b>Agent Bonus</b></th>
						<th><b>Agent Order Rebate</b></th>
						<th><b>Affiliate Bonus</b></th>
						<th><b>Performance Reward</b></th>
						<th><b>Team Reward</b></th>
						<th><b>Refferal Reward</b></th>
						<th><b>Product Commission</b></th>
					</tr>

					<tr>
						<td><b>Total</b></td>
						<td>{{ number_format($totalCommission->totalAgentBonus, 2) }}</td>
						<td>{{ number_format($totalCommission->totalAgentRebateBonus, 2) }}</td>
						<td>{{ number_format($totalCommission->totalAffiliateBonus, 2) }}</td>
						<td>{{ number_format($totalCommission->totalPerformance, 2) }}</td>
						<td>{{ number_format($totalCommission->totalTeam, 2) }}</td>
						<td>{{ number_format($totalCommission->totalRefferal, 2) }}</td>
						<td>{{ number_format($totalCommission->totalProduct, 2) }}</td>
					</tr>
				</thead>
			</table>
			
		</div>
	</div>
	<table class="table table-bordered">
			<thead>
				<tr class="success">
					<th>#</th>
					<th>Date</th>
					<th>Bonus Type</th>
					<th>Agent</th>
					<th>Transaction Amount</th>
					<th>Commission Amount</th>
					<th>Total Commission (RM)</th>
				</tr>
			</thead>
			<tbody>
				@php
					$totalCommission = 0;
					$a=0;
				@endphp
				@foreach($commissions as $commission)
				<tr>
					<td>{{ $a+1 }}</td>
					<td>{{ $commission->created_at }}</td>
					<td>
						@if($commission->type == 1)
							{{ $commission->comm_desc }}
						@elseif($commission->type == 2)
							Rebate on order
							From # {{ $commission->transaction_no }}
						@elseif($commission->type == 3)
							Affiliate bonus 
							From # {{ $commission->transaction_no }}
						@elseif($commission->type == 4)
							Perfomance Reward
						@elseif($commission->type == 5)
							Team Reward
						@elseif($commission->type == 6)
							{{ $commission->comm_desc }}
						@elseif($commission->type == 7)
							Product Commission 
							From # {{ $commission->transaction_no }} ({{ $commission->product_name }})
						@endif
					</td>
					<td>{{ $commission->agentName }}</td>
					<td>
						@if($commission->type == 7)
							{{ number_format($commission->product_amount, 2) }}
						@else
							{{ number_format($commission->grand_total - $commission->shipping_fee - $commission->processing_fee, 2) }} 
							
							@if(!empty($z[$commission->id]) && $commission->type == 2)
								<br>
								@foreach($z[$commission->id] as $value)
									({{ number_format($value[0], 2) }})({{ $value[1] }})
									<br>
								@endforeach
							@endif
						@endif
					</td>
					<td>
						@if($commission->comm_pa_type != 'Percentage')
							RM {{ number_format($commission->comm_pa, 2) }}
						@else
							{{ number_format($commission->comm_pa, 2) }}%
						@endif
					</td>
					<td>{{ number_format($commission->comm_amount, 2) }}</td>
				</tr>
				@php
					$a++;
					$totalCommission += $commission->comm_amount;
				@endphp
				@endforeach
				<tr>
					<td colspan="6">Summary</td>
					<td>{{ number_format($totalCommission, 2) }}</td>
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