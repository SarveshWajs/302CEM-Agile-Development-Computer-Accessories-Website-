@extends('layouts.app')

@section('content')
<div class="shop_inner_inf">
	<!-- product right -->
	<div class="col-md-12" style="padding: 0px">
		<div class="affiliate_list">
			<!-- <div class="" style="background-color: #fff; width: 100%; padding: 13px 10px;">
				<div class="row">
					<div class="col-xs-4" align="left">
						@if($code != Auth::user()->code)
							<a href="{{ route('MyAffiliate', $upline) }}">
								<i class="fa fa-chevron-left"></i>	{{ $upline }}
							</a>
						@else
							<a href="{{ route('profile') }}">
								<i class="fa fa-chevron-left"></i>	回到我的
							</a>
						@endif
					</div>

					<div class="col-xs-4" align="center" style="font-size: 12px;">
						<b>我的团队</b>
					</div>
				</div>
				
			</div> -->
			<div class="affliate-details-background">
				<a href="{{ route('profile') }}">
					<p style="color:white;"><i class="fa fa-chevron-left"></i> Back</p>
				</a>
				<br>
				<div class="users-details-box">
					@if(!empty($profile_logo))
						<div class="user-details-img" style="background-image: url({{ url($profile_logo) }})"></div>
					@else
						<div class="user-details-img" style="background-image: url({{ url('images/images.png') }})"></div>
					@endif
				</div>
				<div class="users-details-box white user-name" style="color: white;">
					<span>{{ (!empty($name)) ? $name : $phone  }} ({{ $code }})</span>
					<br>
					Level: {{ $lvl }}
					<br>
					Upline: {{ $upline }}
				</div>
				<div style="clear: both;"></div>

				<div class="row totalResult">
					<div class="col-4 white" align="center">
						<div class="form-group">
							<span style="color: white;">{{ $totalCustomer }}</span><br>
							<span style="color: white;">Total Customer</span>
						</div>
					</div>
					<div class="col-4 white" align="center">
						<div class="form-group">
							<span style="color: white;">{{ $TodayNewCustomer }}</span><br>
							<span style="color: white;">Today New Customer</span>
						</div>
					</div>
					<div class="col-4 white" align="center">
						<div class="form-group">
							<span style="color: white;">{{ $TotalSales }}</span><br>
							<span style="color: white;">Today Total Sales</span>
						</div>
					</div>
				</div>
			</div>
			<div class="affiliate-search-area">
				<form method="GET" action="">
					<div class="input-group">
			            <input type="text" name="name" class="form-control search-query" placeholder="Key in username" value="{{ !empty(request('name')) ? request('name') : '' }}">
			            <span class="input-group-btn">
			                <button type="submit" class="btn btn-primary btn-white search-button" style="outline: none;">
			                    <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
			                    Search
			                </button>
			            </span>
			        </div>
			    </form>
			</div>
			<div class="form-group affiliate-list-area mb-5">
				<ul>
					@if(!$affiliates->isEmpty())
						@foreach($affiliates as $affiliate)
							<li>
								<a>
									<div class="users-details-box">
											@if(!empty($affiliate->profile_logo))
												<div class="users-img" style="background-image: url({{ url($affiliate->profile_logo) }})"></div>
											@else
												<div class="users-img" style="background-image: url({{ url('images/images.png') }})"></div>
											@endif
										</div>
										<div class="users-details-box">
												{{ $affiliate->l_name }}{{ $affiliate->f_name }}<br>
												{{ $affiliate->created_at }}<br>
												Today Sales: {{ $customerTotalTodaySales[$affiliate->code] }}
										</div>
									<div style="clear: both;"></div>
								</a>
							</li>
						@endforeach
					@else
					<li style="font-size: 10px;" align="center">
						No result
					</li>
					@endif
					
				</ul>
			</div>
		</div>
	</div>
</div>

<div style="clear: both;"></div>
@endsection