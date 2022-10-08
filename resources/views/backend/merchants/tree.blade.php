@extends('layouts.admin_app')
<link rel="stylesheet" href="{{ asset('frontend/tree/style.css') }}">
@section('css')
<style type="text/css">
	.tree:before {
		border: none;
	}

	.tree code, .tree span{
		border: none;
	}
</style>
@endsection
@section('content')

<div class="widget-box transparent" id="recent-box">
	<div class="widget-header">
		<h4 class="widget-title lighter smaller">
			<i class="fa fa-users" aria-hidden="true"></i> Agent Affiliate List

			<small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            {{ Request::segment(2) }}
        </small>
		</h4>

		<div class="widget-toolbar no-border">
			<ul class="nav nav-tabs" id="recent-tab">
				<li class="active">
					<a data-toggle="tab" class="payment_method" data-id="1" href="#tab-list-tab">Tab View</a>
				</li>

				<li>
					<a data-toggle="tab" class="payment_method" data-id="2" href="#tree-tab">Tree View</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="widget-body">
		<div class="widget-main padding-4">
			<div class="tab-content padding-8">
				<div id="tab-list-tab" class="tab-pane active">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<a href="{{ route('tree_details', [$merchant->code, '1']) }}">
									<div class="bs-callout bs-callout-info" id="callout-alerts-dismiss-plugin">
							    		<div class="form-group">
							    			1st generation downline
							    		</div>
									    <div class="row">
									    	<div class="col-xs-6">
									    		<div class="form-group">
									    			Quantity
									    		</div>
									    	</div>
									    	<div class="col-xs-6" align="right">
									    		<div class="form-group">
									    			{{ $fg }}
									    		</div>
									    	</div>
									    </div>
									    <div class="row">
									    	<div class="col-md-12" align="right">
										    	<div class="progress progress-mini">
													<div class="progress-bar progress-danger" style="width: {{ $fgp }}%;"></div>
												</div>
									    	</div>

											<div class="col-xs-6">
												<small>Percentage</small>
											</div>
											<div class="col-xs-6" align="right">
												<small>{{ $fgp }}%</small>
											</div>
									    </div>
									</div>									
								</a>
							</div>	
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<a href="{{ route('tree_details', [$merchant->code, '2']) }}">
									<div class="bs-callout bs-callout-danger" id="callout-alerts-dismiss-plugin">
							    		<div class="form-group">
							    			2nd generation downline
							    		</div>
									    <div class="row">
									    	<div class="col-xs-6">
									    		<div class="form-group">
									    			Quantity
									    		</div>
									    	</div>
									    	<div class="col-xs-6" align="right">
									    		<div class="form-group">
									    			{{ $sg }}
									    		</div>
									    	</div>
									    </div>
									    <div class="row">
									    	<div class="col-md-12" align="right">
										    	<div class="progress progress-mini">
													<div class="progress-bar progress-danger" style="width: {{ $sgp }}%;"></div>
												</div>
									    	</div>
									    	
											<div class="col-xs-6">
												<small>Percentage</small>
											</div>
											<div class="col-xs-6" align="right">
												<small>{{ $sgp }}%</small>
											</div>
									    </div>
									</div>
								</a>
							</div>	
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<a href="{{ route('tree_details', [$merchant->code, '3']) }}">
									<div class="bs-callout bs-callout-warning" id="callout-alerts-dismiss-plugin">
							    		<div class="form-group">
							    			3th generation downline
							    		</div>
									    <div class="row">
									    	<div class="col-xs-6">
									    		<div class="form-group">
									    			Quantity
									    		</div>
									    	</div>
									    	<div class="col-xs-6" align="right">
									    		<div class="form-group">
									    			{{ $tg }}
									    		</div>
									    	</div>
									    </div>
									    <div class="row">
									    	<div class="col-md-12" align="right">
										    	<div class="progress progress-mini">
													<div class="progress-bar progress-danger" style="width: {{ $tgp }}%;"></div>
												</div>
									    	</div>
									    	
											<div class="col-xs-6">
												<small>Percentage</small>
											</div>
											<div class="col-xs-6" align="right">
												<small>{{ $tgp }}%</small>
											</div>
									    </div>
									</div>
								</a>
							</div>	
						</div>
					</div>
				</div>

				<div id="tree-tab" class="tab-pane">
					<div class="row" style="overflow: auto;">
						<div class="col-xs-12">
							<figure>
							  <ul class="tree">
							    	<li>
							    		<span>
							    			<img src="{{ !empty($merchant->profile_logo) ? $merchant->profile_logo : url('images/images.png') }}" width="100px">
							    			<br>
							    			{{ $merchant->f_name }} {{ $merchant->l_name }}
							    		</span>

							      		<ul>
							      			@foreach($merchantD as $merchantDv)
							        		<li>
							        			<span>

							        				<img src="{{ !empty($merchantDv->profile_logo) ? url($merchantDv->profile_logo) : url('images/images.png') }}" width="100px">
							        				<br>
							        				{{ $merchantDv->f_name }} {{ $merchantDv->l_name }}
							        			</span>
							        			@if(!$mdd[$merchantDv->code]->isEmpty())
								        			<ul>

								        				@foreach($mdd[$merchantDv->code] as $mddv)
								        				<li>
								        					<span>
								        						<img src="{{ !empty($mddv->profile_logo) ? url($mddv->profile_logo) : url('images/images.png') }}" width="100px">
							        							<br>
								        						{{ $mddv->f_name }} {{ $mddv->l_name }}</span>

								        					@if(!$mddd[$mddv->code]->isEmpty())
								        					<ul>
								        						@foreach($mddd[$mddv->code] as $mdddv)
									        						<li>
									        							<span>
									        								<img src="{{ !empty($mdddv->profile_logo) ? url($mdddv->profile_logo) : url('images/images.png') }}" width="100px">
							        										<br>
									        								{{ $mdddv->f_name }} {{ $mdddv->l_name }}
									        							</span>
									        						</li>
									        					@endforeach
								        					</ul>
								        					@endif
								        				</li>
								        				@endforeach
								        			</ul>
								        		@endif
							        		</li>
							        		@endforeach
							      		</ul>
							    	</li>
							  </ul>
							</figure>
						</div>
					</div>				
				</div><!-- /.#member-tab -->
			</div>
		</div><!-- /.widget-main -->
	</div>
</div>
@endsection
