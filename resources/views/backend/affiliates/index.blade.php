@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Affiliate List
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<div class="affiliate_list">
	<div class="affliate-details-background">
		<div class="users-details-box">
			@if(!empty($profile_logo))
				<div class="user-details-img" style="background-image: url({{ url($profile_logo) }})"></div>
			@else
				<div class="user-details-img" style="background-image: url({{ url('images/images.png') }})"></div>
			@endif
		</div>
		<div class="users-details-box white user-name">
			Vesson - {{ $name }}
		</div>
		<div style="clear: both;"></div>

		<div class="row totalResult">
			<div class="col-xs-4 white" align="center">
				<div class="form-group">
					<b>{{ $OwnTotalAffiliate }}</b><br>
					<b>Total cumulative number</b>
				</div>
			</div>
			<div class="col-xs-4 white" align="center">
				<div class="form-group">
					<b>{{ $OwnMonthlyTotalAffiliate }}</b><br>
					<b>This month new</b>
				</div>
			</div>
			<div class="col-xs-4 white" align="center">
				<div class="form-group">
					<b>{{ $GetSelectedUserDailyTotalAffiliates }}</b><br>
					<b>Today new</b>
				</div>
			</div>
		</div>
	</div>
	<div class="affiliate-search-area">
		<form method="GET" action="{{ route('affiliates', $code)}}">
			<div class="input-group">
	            <input type="text" name="name" class="form-control search-query" placeholder="Search Affiliates">
	            <span class="input-group-btn">
	                <button type="submit" class="btn btn-inverse btn-white search-button" style="outline: none;">
	                    <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
	                    Search
	                </button>
	            </span>
	        </div>
	    </form>
	</div>
	<div class="form-group affiliate-list-area">
		<ul>
			@if(!$affiliates->isEmpty())
			@foreach($affiliates as $affiliate)
			<li>
				<a href="{{ route('affiliates', $affiliate->code) }}">
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
							Today new: {{ $TodayTotalAffiliates[$affiliate->code] }}
					</div>
					<div class="users-details-box view-affiliate">
						{{ $TotalAffiliates[$affiliate->code] }} People <i class="fa fa-chevron-right"></i>
					</div>
					<div style="clear: both;"></div>
				</a>
			</li>
			@endforeach
			@else
			<li>
				No Affiliate Yet!
			</li>
			@endif
		</ul>
	</div>
</div>
@endsection