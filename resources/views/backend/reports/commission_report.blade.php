@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Commision Report
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form action="{{ route('commission_report') }}" method="GET">
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
			<input type="text" class="form-control" name="agent" value="{{ !empty(request('agent')) ? request('agent') : '' }}" placeholder="Search Agent..">
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
				<a href="{{ route('commission_report') }}" class="btn btn-warning btn-sm">
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
	|
	<span class="badge label-warning" style="font-size: 1.5rem; padding: 10px;">
		Net Total: <span class="netTotal"></span>
	</span>
</div>
<hr>
<div class="form-group" align="right">
	<a href="{{ route('print_commission_report', ['dates='.(!empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate)]) }}" class="print-window btn btn-primary" target="_blank">
		<i class="fa fa-print"></i> Print
	</a>
	<a href="{{ route('exportCommissionReport', ['dates='.(!empty(request('dates')) ? request('dates') : $startDate.' - '.$endDate)])}}" target="_blank" class="btn btn-warning">
		<i class="fa fa-download"></i> Export
	</a>
</div>

<div class="row" style="overflow: auto;">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="success">
					<th><b>Bonus Type</b></th>
					<th>Agent Bonus</th>
					<th>Agent Order Rebate</th>
					<th>Affiliate Bonus</th>
					<th>Performance Reward</th>
					<th>Team Reward</th>
					<th>Refferal Reward</th>
					<th>Product Commission</th>
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

<div class="row" style="overflow: auto;">
	<div class="col-xs-12">
		<table class="table table-bordered">
			<thead>
				<tr class="success">
					<th>#</th>
					<th>Date</th>
					<th>Bonus Type</th>
					<th>Agent</th>
					<th>Transaction Amount(RM)</th>
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
							From # <a href="{{ route('transaction.transactions.edit', $commission->tID) }}" target="_blank">
										{{ $commission->transaction_no }}
								   </a>
						@elseif($commission->type == 3)
							@php
								$explode = explode('#', $commission->comm_desc);
							@endphp
							{{ $explode[0] }}
							<a href="{{ route('transaction.transactions.edit', $commission->tID) }}" target="_blank">
								{{ $commission->transaction_no }}
							</a>
						@elseif($commission->type == 4)
							Perfomance Reward
						@elseif($commission->type == 5)
							Team Reward
						@elseif($commission->type == 6)
							{{ $commission->comm_desc }}
						@elseif($commission->type == 7)
							Product Commission 
							From #<a href="{{ route('transaction.transactions.edit', $commission->tID) }}" target="_blank">
									{{ $commission->transaction_no }}
							   	 </a>
							({{ $commission->product_name }})
						@else
							{{ $commission->comm_desc }}
						@endif
					</td>
					<td>{{ $commission->agentName }}</td>
					<td>
						{{ number_format($commission->product_amount, 2) }}
						<!-- @if($commission->type == 7) -->
						<!-- @else
							{{ number_format($commission->grand_total - $commission->shipping_fee - $commission->processing_fee, 2) }} 
							
							@if(!empty($z[$commission->id]) && $commission->type == 2)
								<br>
								@foreach($z[$commission->id] as $value)
									({{ number_format($value[0], 2) }})({{ $value[1] }})
									<br>
								@endforeach
							@endif
						@endif -->
					</td>
					<td>
						@if($commission->comm_pa_type != 'Percentage')
							RM {{ number_format($commission->comm_pa, 2) }}
						@else
							{{ number_format($commission->comm_pa, 2) }}%
						@endif
					</td>
					<td>{{ $commission->comm_amount }}</td>
				</tr>
				@php
					$a++;
					$totalCommission += $commission->comm_amount;
				@endphp
				@endforeach
				<tr class="warning">
					<td colspan="6">Summary</td>
					<td>{{ $totalCommission }}</td>
				</tr>
			</tbody>
		</table>
		{{ $commissions->links() }}
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

	$('.grandTotal').html('{{ number_format($totalCommission, 2) }}');
	$('.netTotal').html('{{ number_format($netTotal->netTotalCommission, 2) }}');
</script>
@endsection