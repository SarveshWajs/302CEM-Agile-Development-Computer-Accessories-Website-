@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Dashboard
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>

<div class="form-group">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-2">
							<div class="dashboard-wording-icon">
								<b>
					            	<i class="fa fa-usd"></i>
					            </b>
							</div>
						</div>
						<div class="col-xs-10">
							<div class="" align="right">
								<b class="dashboard-wording">
					            	Monthly Sales
					            </b>
					            <p class="dashboard-wording value">
					            	RM {{ number_format($totalSales->totalSales, 2) }}
					            </p>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer" align="center" style="background-color: #85b0e5;">
					<a href="{{ route('transaction.transactions.index') }}">
						View all transaction
					</a>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-info">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-2">
							<div class="dashboard-wording-icon">
								<b>
					            	<i class="fa fa-money"></i>
					            </b>
							</div>
						</div>
						<div class="col-xs-10">
							<div class="" align="right">
								<b class="dashboard-wording">
					            	Monthly Commission
					            </b>
					            <p class="dashboard-wording value">
					            	RM {{ number_format($totalCommission->totalCommission, 2) }}
					            </p>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer" align="center" style="background-color: #5dc4cd;">
					<a href="{{ route('commission_report') }}">
						View all commission report
					</a>
				</div>
			</div>
		</div>

		<!-- <div class="col-md-3">
			<div class="panel panel-success">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-2">
							<div class="dashboard-wording-icon">
								<b>
					            	<i class="fa fa-users"></i>
					            </b>
							</div>
						</div>
						<div class="col-xs-10">
							<div class="" align="right">
								<b class="dashboard-wording">
					            	Total Agent
					            </b>
					            <p class="dashboard-wording value">
					            	{{ $totalAgents->totalAgent }}
					            </p>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer" align="center" style="background-color: #49c5a0;">
					<a href="{{ route('merchant.merchants.index') }}">
						View all agent
					</a>
				</div>
			</div>
		</div> -->

		<div class="col-md-4">
			<div class="panel panel-danger">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-2">
							<div class="dashboard-wording-icon">
								<b>
					            	<i class="fa fa-cubes"></i>
					            </b>
							</div>
						</div>
						<div class="col-xs-10">
							<div class="" align="right">
								<b class="dashboard-wording">
					            	Total Product
					            </b>
					            <p class="dashboard-wording value">
					            	{{ $totalProduct->totalProduct }}
					            </p>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-footer" align="center" style="background-color: #f18992;">
					<a href="{{ route('product.products.index') }}">
						View all Product
					</a>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-sm-12">
			<div class="widget-box transparent" id="recent-box">
				<div class="widget-header">
					<h4 class="widget-title lighter smaller">
						<i class="ace-icon fa fa-signal"></i>Sale Stats
					</h4>

					<div class="widget-toolbar no-border">
						<ul class="nav nav-tabs" id="recent-tab">
							<li class="active">
								<a data-toggle="tab" href="#daily-tab">Daily</a>
							</li>

							<li>
								<a data-toggle="tab" href="#monthly-tab">Monthly</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="widget-body">
					<div class="widget-main padding-4">
						<div class="tab-content padding-8">
							<div id="daily-tab" class="tab-pane active">
								<canvas id="line-chart-daily" width="800" height="450"></canvas>
							</div>

							<div id="monthly-tab" class="tab-pane">
								<canvas id="line-chart-monthly" width="800" height="450"></canvas>
							</div><!-- /.#member-tab -->
						</div>
					</div><!-- /.widget-main -->
				</div><!-- /.widget-body -->
			</div><!-- /.widget-box -->
		</div>

		<!-- <div class="col-sm-6">
			<div class="widget-box transparent" id="recent-box">
				<div class="widget-header">
					<h4 class="widget-title lighter smaller">
						<i class="ace-icon fa fa-signal"></i>Traffic Sources
					</h4>

					<div class="widget-toolbar no-border">
						<ul class="nav nav-tabs" id="recent-tab">
							<li class="active">
								<a data-toggle="tab" href="#today-tab">Today</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="widget-body">
					<div class="widget-main padding-4">
						<div class="tab-content padding-8">
							<div id="today-tab" class="tab-pane active">
								@if(!empty($totalAgent->totalAgent) || !empty($totalCustomer->totalCustomer))
								<div id="piechart-placeholder-today"></div>
								@else
								No data result
								@endif
								<div class="hr hr8 hr-double"></div>

								<div class="clearfix">
									<div class="grid3">
										<span class="grey">
											<i class="ace-icon fa fa-users fa-2x green"></i>
											&nbsp; Agent
										</span>
										<h4 class="bigger pull-right">{{ $totalAgent->totalAgent }}</h4>
									</div>

									<div class="grid3">
										<span class="grey">
											<i class="ace-icon fa fa-user fa-2x blue"></i>
											&nbsp; Customer
										</span>
										<h4 class="bigger pull-right">{{ $totalCustomer->totalCustomer }}</h4>
									</div>	
								</div>
							</div>				
							
						</div>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</div>
<div class="form-group">
	<div class="row">
		<div class="col-sm-12">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-flat">
					<h4 class="widget-title lighter">
						<i class="ace-icon fa fa-signal"></i>
						Transaction (Waiting for approval)
					</h4>

					<div class="widget-toolbar">
						<a href="#" data-action="collapse">
							<i class="ace-icon fa fa-chevron-up"></i>
						</a>
					</div>
				</div>

				<div class="widget-body">
					<div class="widget-main padding-4" style="overflow: auto;">
						<table class="table table-bordered">
							<tr>
								<th>#</th>
								<th>Transaction no</th>
								<th>Buyer</th>
								<th>Amount</th>
								<th>Status</th>
								<th>Created</th>
								<th></th>
							</tr>
							@if(!$transactions->isEmpty())
							@foreach($transactions as $key => $transaction)
							<tr>
								<td>{{ $key+1 }}
									<input type="hidden" name="tid" value="{{ $transaction->id }}">
								</td>
								<td>{{ $transaction->transaction_no }}</td>
								<td>{{ $transaction->user_id }}</td>
								<td>{{ $transaction->grand_total }}</td>
								<td>
									<span class="label label-info">
										Waiting for approval
									</span>
								</td>
								<td>13/02/2020 15:40:35</td>
								<td align="center">
									<a href="{{ route('transaction.transactions.edit', $transaction->id) }}" class="btn btn-primary btn-sm" title="View Transaction">
										<i class="fa fa-search"></i>
									</a>
									<a href="#" class="btn btn-success btn-sm change_action" data-id="1" title="Approve This Transaction">
										<i class="fa fa-check"></i>
									</a>
									<a href="#" class="btn btn-danger btn-sm change_action" data-id="96" title="Reject This Transaction">
										<i class="fa fa-ban"></i>
									</a>
								</td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="7" align="center">No Result Found</td>
							</tr>
							@endif
						</table>
					</div><!-- /.widget-main -->
				</div><!-- /.widget-body -->
			</div><!-- /.widget-box -->
		</div>
		<!-- <div class="col-sm-12">
			<div class="widget-box transparent">
				<div class="widget-header widget-header-flat">
					<h4 class="widget-title lighter">
						<i class="ace-icon fa fa-users"></i>
						Agent (Waiting for approval)
					</h4>

					<div class="widget-toolbar">
						<a href="#" data-action="collapse">
							<i class="ace-icon fa fa-chevron-up"></i>
						</a>
					</div>
				</div>

				<div class="widget-body">
					<div class="widget-main padding-4"  style="overflow: auto;">
						<table class="table table-bordered">
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Code</th>
								<th>Upline</th>
								<th>Status</th>
								<th>Created</th>
								<th></th>
							</tr>
							@if(!$agents->isEmpty())
							@foreach($agents as $key2 => $agent)
							<tr>
								<td>
									{{ $key2+1 }}
									<input type="hidden" name="mid" value="{{ $agent->id }}">
								</td>
								<td>{{ $agent->f_name }} {{ $agent->l_name }}</td>
								<td>{{ $agent->code }}</td>
								<td>{{ $agent->master_id }}</td>
								<td>
									<span class="label label-info">
										Waiting for approval
									</span>
								</td>
								<td>{{ $agent->created_at }}</td>
								<td align="center">
									<a href="{{ route('merchant.merchants.edit', $agent->id) }}" class="btn btn-primary btn-sm" title="View Transaction">
										<i class="fa fa-search"></i>
									</a>

									<a href="#" class="btn btn-success btn-sm change_action_merchant" data-id="1" title="Approve This Transaction">
										<i class="fa fa-check"></i>
									</a>

									<a href="#" class="btn btn-danger btn-sm change_action_merchant" data-id="98" title="Reject This Transaction">
										<i class="fa fa-ban"></i>
									</a>
								</td>
							</tr>
							@endforeach
							@else
							<tr>
								<td colspan="7" align="center">No Result Found</td>
							</tr>
							@endif
						</table>
					</div>
				</div>
			</div>
		</div> -->
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$('.change_action').click( function(e){
	e.preventDefault();
	$('.loading-gif').show();

	var ele = $(this);
	var action_id = $(this).data('id');
	var tid = $(this).closest('tr').find('input[name="tid"]').val();
	var fd = new FormData();
	fd.append('action_id', action_id);
	fd.append('tid', tid);
	if(action_id == '1'){
		var confirmMessage = confirm('Complete This Transaction?');
	}else if(action_id == '95'){
		var confirmMessage = confirm('Cancel This Transaction? ');
	}else if(action_id == '96'){
		var confirmMessage = confirm('Reject This Transaction?');
	}else if(action_id == '11'){
		var confirmMessage = confirm('Delivered?');
	}


	if(confirmMessage == true){
		$.ajax({
	       url: '{{ route("change_transaction_action") }}',
	       type: 'post',
	       data: fd,
	       contentType: false,
	       processData: false,
	       success: function(response){
	       		$('.loading-gif').hide();
	       		
	       		toastr.success('Update Successful');
	       		window.location.href = "{{ route('transaction.transactions.index') }}";
	       		// if(action_id == '1'){
	       		// 	ele.closest('tr').find('.status_id').html('<span class="badge badge-success">Approved</span>');
	       		// }else if(action_id == '98'){
	       		// 	ele.closest('tr').find('.status_id').html('<span class="badge badge-danger">Rejected</span>');
	       		// }else{
	       		// 	ele.closest('tr').find('.status_id').html('<span class="badge badge-danger">Cancelled</span>');
	       		// }
	       },
	    });			
	}else{
		$('.loading-gif').hide();
	}
});


$('.change_action_merchant').click( function(e){
		e.preventDefault();

		$('.loading-gif').show();
		var ele = $(this);
		var action_id = $(this).data('id');
		var mid = $(this).closest('tr').find('input[name="mid"]').val();
		var fd = new FormData();
		fd.append('action_id', action_id);
		fd.append('mid', mid);

		if(action_id == '1'){
			var action_confirm = confirm('Approve this agent?');
		}else{
			var action_confirm = confirm('Reject this agent?');
		}
		if(action_confirm == true){
			$.ajax({
		       url: '{{ route("ApproveRejectMerchant") }}',
		       type: 'post',
		       data: fd,
		       contentType: false,
		       processData: false,
		       success: function(response){
		       		// alert(response);
		       		$('.loading-gif').hide();
		       		toastr.success('Update Successful');
		       		window.location.href = "{{ route('merchant.merchants.index') }}";
		       },
		    });			
		}else{
			$('.loading-gif').hide();
		}
	});

var today = new Date(); // current date
var end = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate(); // end date of month
var month = today.getMonth()+1;
var result = [];

for(let i = 1; i <= end; i++){
   result.push(today.getFullYear() + '-' + (today.getMonth() < 10? '0'+month: month) +'-'+ (i < 10 ? '0'+ i: i))
}

var date = 
new Chart(document.getElementById("line-chart-daily"), {
  type: 'line',
  data: {
    labels: result,
    datasets: [{ 
        data: {{ json_encode($list) }},
        label: "Daily Sales",
        borderColor: "#3e95cd",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
    }
  }
});

var date1 = 
new Chart(document.getElementById("line-chart-monthly"), {
  type: 'line',
  data: {
    labels: ['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sep','Oct','Nov','Dec'],
    datasets: [{ 
        data: {{ json_encode($list2) }},
        label: "Monthly Sales",
        borderColor: "#3e95cd",
        fill: false
      }
    ]
  },
  options: {
    title: {
      display: true,
    }
  }
});


var placeholder = $('#piechart-placeholder-today').css({'width':'90%' , 'min-height':'300px'});
var data = [
{ label: "Agent",  data: '{{ $totalAgent->totalAgent }}', color: "#68BC31"},
{ label: "Customer",  data: '{{ $totalCustomer->totalCustomer }}', color: "#2091CF"},
]
function drawPieChart(placeholder, data, position) {
	  $.plot(placeholder, data, {
	series: {
		pie: {
			show: true,
			tilt:0.8,
			highlight: {
				opacity: 0.25
			},
			stroke: {
				color: '#fff',
				width: 2
			},
			startAngle: 2
		}
	},
	legend: {
		show: true,
		position: position || "ne", 
		labelBoxBorderColor: null,
		margin:[-30,15]
	}
	,
	grid: {
		hoverable: true,
		clickable: true
	}
 })
}
drawPieChart(placeholder, data);

/**
we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
so that's not needed actually.
*/
placeholder.data('chart', data);
placeholder.data('draw', drawPieChart);


//pie chart tooltip example
var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
var previousPoint = null;

placeholder.on('plothover', function (event, pos, item) {
if(item) {
	if (previousPoint != item.seriesIndex) {
		previousPoint = item.seriesIndex;
		var tip = item.series['label'] + " : " + item.series['percent']+'%';
		$tooltip.show().children(0).text(tip);
	}
	$tooltip.css({top:pos.pageY + 10, left:pos.pageX + 10});
} else {
	$tooltip.hide();
	previousPoint = null;
}

});



</script>
@endsection