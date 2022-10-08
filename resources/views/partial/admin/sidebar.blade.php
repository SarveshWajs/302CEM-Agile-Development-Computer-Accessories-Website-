<div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>

	<!-- <div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-success">
				<i class="ace-icon fa fa-signal"></i>
			</button>

			<button class="btn btn-info">
				<i class="ace-icon fa fa-pencil"></i>
			</button>

			<button class="btn btn-warning">
				<i class="ace-icon fa fa-users"></i>
			</button>

			<button class="btn btn-danger">
				<i class="ace-icon fa fa-cogs"></i>
			</button>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>

			<span class="btn btn-info"></span>

			<span class="btn btn-warning"></span>

			<span class="btn btn-danger"></span>
		</div>
	</div> --><!-- /.sidebar-shortcuts -->
	@php
		$permission_level = (!empty(Auth::guard($data['userGuardRole'])->user()->permission_lvl)) ? Auth::guard($data['userGuardRole'])->user()->permission_lvl : '1';

	@endphp

	<ul class="nav nav-list">
		
		@foreach($data['permission'] as $key => $value)
			@if(isset($value[$permission_level]['dashboard']) && $value[$permission_level]['dashboard'] == 1)
				<li class="{{ (Request::segment(1) == 'dashboards') ? 'active open' : '' }}">
					<a href="{{ route('dashboard.dashboards.index') }}">
						<i class="menu-icon fa fa-tachometer"></i>
						
						<span class="menu-text"> Dashboard</span>
					</a>

					<b class="arrow"></b>
				</li>
			@endif
			@if(isset($value[$permission_level]['profile']) && $value[$permission_level]['profile'] == 1)
				<!-- <li class="{{ (Request::segment(1) == 'admins' || Request::segment(1) == 'setting_faqs') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-user"></i>
					<span class="menu-text">
						Company
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					
					<li class="{{ (Request::segment(1) == 'admins') ? 'active' : '' }}">
						<a href="{{ route('admin.admins.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Profile
						</a>

						<b class="arrow"></b>
					</li>

					<li class="{{ (Request::segment(1) == 'setting_faqs') ? 'active' : '' }}">
						<a href="{{ route('setting_faqs') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Faqs
						</a>

						<b class="arrow"></b>
					</li>
				</ul>
			</li> -->
				<li class="{{ (Request::segment(1) == 'admins') ? 'active open' : '' }}">
					<a href="{{ route('admin.admins.index') }}">
						<i class="menu-icon fa fa-user"></i>
						@if(Auth::guard('admin')->check())
						<span class="menu-text"> Company Profile</span>
						@else
						<span class="menu-text"> Profile</span>
						@endif
					</a>

					<b class="arrow"></b>
				</li>
			@endif

			<!--@if(isset($value[$permission_level]['permission-control']) && $value[$permission_level]['permission-control'] == 1)
		
			<li class="{{ (Request::segment(1) == 'user_permissions') ? 'active open' : '' }}">
				<a href="{{ route('user_permission.user_permissions.index') }}">
					<i class="menu-icon fa fa-lock"></i>
					<span class="menu-text">Permission Control </span>
				</a>

				<b class="arrow"></b>
			</li>
			@endif
			@if((isset($value[$permission_level]['agent-list']) && $value[$permission_level]['agent-list'] == 1) || 
			    (isset($value[$permission_level]['agent-add']) && $value[$permission_level]['agent-add'] == 1) ||
			    (isset($value[$permission_level]['agent-pending']) && $value[$permission_level]['agent-pending'] == 1))
			<li class="{{ (Request::segment(1) == 'merchants' || Request::segment(1) == 'pending_merchant' || Request::segment(1) == 'tree' || Request::segment(1) == 'tree_details') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-users"></i>
					<span class="menu-text">
						Agent Manage 
						@if($data['total_pending'] != 0)
							<span class="badge label-danger">
								{{ $data['total_pending'] }}
							</span>
							@endif
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					@if(isset($value[$permission_level]['agent-list']) && $value[$permission_level]['agent-list'] == 1)
					<li class="{{ (Request::segment(1) == 'merchants' && (Request::segment(2) == '' || Request::segment(3) == 'edit' || Request::segment(1) == 'tree' || Request::segment(1) == 'tree_details')) ? 'active' : '' }}">
						<a href="{{ route('merchant.merchants.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Agent List
						</a>

						<b class="arrow"></b>
					</li>
					@endif
					@if(isset($value[$permission_level]['agent-add']) && $value[$permission_level]['agent-add'] == 1)
					<li class="{{ (Request::segment(1) == 'merchants' && Request::segment(2) == 'create') ? 'active' : '' }}">
						<a href="{{ route('merchant.merchants.create') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Agent
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					<li class="{{ (Request::segment(1) == 'merchants' && Request::segment(2) == 'about') ? 'active' : '' }}">
						<a href="{{ route('agent_about') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Agent About
						</a>

						<b class="arrow"></b>
					</li>

					@if(isset($value[$permission_level]['agent-pending']) && $value[$permission_level]['agent-pending'] == 1)
					<li class="{{ (Request::segment(1) == 'pending_merchant') ? 'active' : '' }}">
						<a href="{{ route('pending_merchant') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Pending Agent 
							@if($data['total_pending'] != 0)
							<span class="badge label-danger">
								{{ $data['total_pending'] }}
							</span>
							@endif
						</a>

						<b class="arrow"></b>
					</li>
					@endif
				</ul>
			</li>
			@endif-->

			@if((isset($value[$permission_level]['member-list']) && $value[$permission_level]['member-list'] == 1) || 
			    (isset($value[$permission_level]['member-add']) && $value[$permission_level]['member-add'] == 1) ||
			    (isset($value[$permission_level]['member-pending']) && $value[$permission_level]['member-pending'] == 1))
			<li class="{{ (Request::segment(1) == 'members' || Request::segment(1) == 'tree' || Request::segment(1) == 'tree_details' ||
						   Request::segment(1) == 'pending_member') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-users"></i>
					<span class="menu-text">
						Member Manage 
						@if($data['total_member_pending'] != 0)
						<span class="badge label-danger">
							{{ $data['total_member_pending'] }}
						</span>
						@endif
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					@if(isset($value[$permission_level]['member-list']) && $value[$permission_level]['member-list'] == 1)
					<li class="{{ (Request::segment(1) == 'members' && (Request::segment(2) == '' || Request::segment(3) == 'edit' || Request::segment(1) == 'tree' || Request::segment(1) == 'tree_details')) ? 'active' : '' }}">
						<a href="{{ route('member.members.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Member List
						</a>

						<b class="arrow"></b>
					</li>
					@endif
					@if(isset($value[$permission_level]['member-add']) && $value[$permission_level]['member-add'] == 1)
					<li class="{{ (Request::segment(1) == 'members' && Request::segment(2) == 'create') ? 'active' : '' }}">
						<a href="{{ route('member.members.create') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Member
						</a>

						<b class="arrow"></b>
					</li>
					@endif
					@if(isset($value[$permission_level]['member-pending']) && $value[$permission_level]['member-pending'] == 1)
					<li class="{{ (Request::segment(1) == 'pending_member') ? 'active' : '' }}">
						<a href="{{ route('pending_member') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Pending Member 
							@if($data['total_member_pending'] != 0)
							<span class="badge label-danger">
								{{ $data['total_member_pending'] }}
							</span>
							@endif
						</a>

						<b class="arrow"></b>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if((isset($value[$permission_level]['product-list']) && $value[$permission_level]['product-list'] == 1) || 
			    (isset($value[$permission_level]['product-add']) && $value[$permission_level]['product-add'] == 1) ||
			    (isset($value[$permission_level]['point-product-list']) && $value[$permission_level]['point-product-list'] == 1) || 
			    (isset($value[$permission_level]['point-product-add']) && $value[$permission_level]['point-product-add'] == 1))
			<li class="{{ (Request::segment(1) == 'products' || Request::segment(1) == 'point_malls') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-cubes"></i>
					<span class="menu-text">
						Product Manage
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					@if(isset($value[$permission_level]['product-list']) && $value[$permission_level]['product-list'] == 1)
					<li class="{{ (Request::segment(1) == 'products' && (Request::segment(2) == '' || Request::segment(3) == 'edit' || Request::segment(3) == 'stock')) ? 'active' : '' }}">
						<a href="{{ route('product.products.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Product List
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					@if(isset($value[$permission_level]['product-add']) && $value[$permission_level]['product-add'] == 1)
					<li class="{{ (Request::segment(1) == 'products' && Request::segment(2) == 'create') ? 'active' : '' }}">
						<a href="{{ route('product.products.create') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Product
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					@if(isset($value[$permission_level]['point-product-list']) && $value[$permission_level]['point-product-list'] == 1)
					<!-- <li class="{{ (Request::segment(1) == 'point_malls' && (Request::segment(2) == '' || Request::segment(3) == 'edit')) ? 'active' : '' }}">
						<a href="{{ route('point_mall.point_malls.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Point Product List
						</a>

						<b class="arrow"></b>
					</li> -->
					@endif

					@if(isset($value[$permission_level]['point-product-add']) && $value[$permission_level]['point-product-add'] == 1)
						<!-- <li class="{{ (Request::segment(1) == 'point_malls' && Request::segment(2) == 'create') ? 'active' : '' }}">
							<a href="{{ route('point_mall.point_malls.create') }}">
								<i class="menu-icon fa fa-caret-right"></i>
								Add New Point Product
							</a>

							<b class="arrow"></b>
						</li> -->
					@endif

					<!--@if(isset($value[$permission_level]['product-packages'] ) && $value[$permission_level]['product-packages'] == 1)
					<li class="{{ (Request::segment(1) == 'products' && Request::segment(2) == 'packages_list') ? 'active' : '' }}">
						<a href="{{ route('packages_list') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Packages List
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					@if(isset($value[$permission_level]['product-packages-add']) && $value[$permission_level]['product-packages-add'] == 1)
					<li class="{{ (Request::segment(1) == 'products' && Request::segment(2) == 'packages' && Request::segment(3) == 'add') ? 'active' : '' }}">
						<a href="{{ route('packages_add') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Packages
						</a>

						<b class="arrow"></b>
					</li>
					@endif-->
				</ul>
			</li>
			@endif

			@if((isset($value[$permission_level]['category-list']) && $value[$permission_level]['category-list'] == 1) || 
				(isset($value[$permission_level]['category-list']) && $value[$permission_level]['category-add'] == 1))
			<li class="{{ (Request::segment(1) == 'categories') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-tags"></i>
					<span class="menu-text">
						Category Manage
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					@if(isset($value[$permission_level]['category-list']) && $value[$permission_level]['category-list'] == 1)
					<li class="{{ (Request::segment(1) == 'categories' && (Request::segment(2) == '' || Request::segment(3) == 'edit' || Request::segment(3) == 'stock')) ? 'active' : '' }}">
						<a href="{{ route('category.categories.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Category List
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					@if(isset($value[$permission_level]['category-add']) && $value[$permission_level]['category-add'] == 1)
					<li class="{{ (Request::segment(1) == 'categories' && Request::segment(2) == 'create') ? 'active' : '' }}">
						<a href="{{ route('category.categories.create') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Category
						</a>

						<b class="arrow"></b>
					</li>
					@endif
				</ul>
			</li>
			@endif
			<!--@if((isset($value[$permission_level]['sub-category-list']) && $value[$permission_level]['sub-category-list'] == 1) || 
				(isset($value[$permission_level]['sub-category-list']) && $value[$permission_level]['sub-category-add'] == 1))
			<li class="{{ (Request::segment(1) == 'sub_categories') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-tags"></i>
					<span class="menu-text">
						Sub Category 
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					@if(isset($value[$permission_level]['sub-category-list']) && $value[$permission_level]['sub-category-list'] == 1)
					<li class="{{ (Request::segment(1) == 'sub_categories' && (Request::segment(2) == '' || Request::segment(3) == 'edit' || Request::segment(3) == 'stock')) ? 'active' : '' }}">
						<a href="{{ route('sub_category.sub_categories.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Sub Category List
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					@if(isset($value[$permission_level]['sub-category-add']) && $value[$permission_level]['sub-category-add'] == 1)
					<li class="{{ (Request::segment(1) == 'sub_categories' && Request::segment(2) == 'create') ? 'active' : '' }}">
						<a href="{{ route('sub_category.sub_categories.create') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Sub Category
						</a>

						<b class="arrow"></b>
					</li>
					@endif
				</ul>
			</li>
			@endif-->
			
			@if((isset($value[$permission_level]['brand-list']) && $value[$permission_level]['brand-list'] == 1) || 
			    (isset($value[$permission_level]['brand-add']) && $value[$permission_level]['brand-add'] == 1))
			<li class="{{ (Request::segment(1) == 'brands') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-cube"></i>
					<span class="menu-text">
						Brand Manage
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					@if(isset($value[$permission_level]['brand-list']) && $value[$permission_level]['brand-list'] == 1)
					<li class="{{ (Request::segment(1) == 'brands' && (Request::segment(2) == '' || Request::segment(3) == 'edit')) ? 'active' : '' }}">
						<a href="{{ route('brand.brands.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Brand List
						</a>

						<b class="arrow"></b>
					</li>
					@endif
					@if(isset($value[$permission_level]['brand-add']) && $value[$permission_level]['brand-add'] == 1)
					<li class="{{ (Request::segment(1) == 'categories' && Request::segment(2) == 'create') ? 'active' : '' }}">
						<a href="{{ route('brand.brands.create') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Brand
						</a>

						<b class="arrow"></b>
					</li>
					@endif
				</ul>
			</li>
			@endif
			<!--<li class="{{ (Request::segment(1) == 'blogs') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					
					<i class="menu-icon fa fa-rss" aria-hidden="true"></i>
					<span class="menu-text">
						Event Manage
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<li class="{{ (Request::segment(1) == 'blogs' && (Request::segment(2) == '' || Request::segment(3) == 'edit')) ? 'active' : '' }}">
						<a href="{{ route('blog.blogs.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Event List
						</a>

						<b class="arrow"></b>
					</li>
					<li class="{{ (Request::segment(1) == 'blogs' && Request::segment(2) == 'create') ? 'active' : '' }}">
						<a href="{{ route('blog.blogs.create') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Event
						</a>

						<b class="arrow"></b>
					</li>
				</ul>
			</li>
			@if((isset($value[$permission_level]['bank-list']) && $value[$permission_level]['bank-list'] == 1) || 
				(isset($value[$permission_level]['bank-add']) && $value[$permission_level]['bank-add'] == 1))
			<li class="{{ (Request::segment(1) == 'payment_banks') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-table"></i>
					<span class="menu-text">
						Bank Manage
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					@if(isset($value[$permission_level]['bank-add']) && $value[$permission_level]['bank-add'] == 1)
					<li class="{{ (Request::segment(1) == 'payment_banks' && (Request::segment(2) == '' || Request::segment(3) == 'edit')) ? 'active' : '' }}">
						<a href="{{ route('payment_bank.payment_banks.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Bank List
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					@if(isset($value[$permission_level]['bank-add']) && $value[$permission_level]['bank-add'] == 1)
					<li class="{{ (Request::segment(1) == 'payment_banks' && Request::segment(2) == 'create') ? 'active' : '' }}">
						<a href="{{ route('payment_bank.payment_banks.create') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Bank
						</a>

						<b class="arrow"></b>
					</li>
					@endif
				</ul>
			</li>
			@endif-->
			@if((isset($value[$permission_level]['promotion-list']) && $value[$permission_level]['promotion-list'] == 1) || 
			    (isset($value[$permission_level]['promotion-add']) && $value[$permission_level]['promotion-add'] == 1))
			<li class="{{ (Request::segment(1) == 'promotions') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-tag"></i>
					<span class="menu-text">
						Promotion Manage
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					@if((isset($value[$permission_level]['promotion-list'])) && $value[$permission_level]['promotion-list'] == 1)
					<li class="{{ (Request::segment(1) == 'promotions' && (Request::segment(2) == '' || Request::segment(3) == 'edit')) ? 'active' : '' }}">
						<a href="{{ route('promotion.promotions.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Promotion List
						</a>

						<b class="arrow"></b>
					</li>
					@endif
					@if((isset($value[$permission_level]['promotion-add'])) && $value[$permission_level]['promotion-add'] == 1)
					<li class="{{ (Request::segment(1) == 'promotions' && Request::segment(2) == 'create') ? 'active' : '' }}">
						<a href="{{ route('promotion.promotions.create') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Add New Promotion
						</a>

						<b class="arrow"></b>
					</li>
					@endif
				</ul>
			</li>
			@endif

			@if((isset($value[$permission_level]['transaction-list']) && $value[$permission_level]['transaction-list'] == 1) ||
				(isset($value[$permission_level]['withdrawal-list']) && $value[$permission_level]['withdrawal-list'] == 1))
			<li class="{{ (Request::segment(1) == 'transactions' || Request::segment(1) == 'withdrawal_list' ||
						   Request::segment(1) == 'topup_list') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text">
						Transaction Manage
						@if($data['totalPendingTrans'] != '0')
							<span class="badge label-danger">
								{{ $data['totalPendingTrans'] }}
							</span>
						@endif
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<ul class="submenu">
					@if(isset($value[$permission_level]['transaction-list']) && $value[$permission_level]['transaction-list'] == 1)
					<li class="{{ (Request::segment(1) == 'transactions' && (Request::segment(2) == '' || Request::segment(3) == 'edit')) ? 'active' : '' }}">
						<a href="{{ route('transaction.transactions.index') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Transaction List
							@if($data['allPendingTrans'] != '0')
								<span class="badge label-danger">
									{{ $data['allPendingTrans'] }}
								</span>
							@endif
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					
					<!--  -->
				</ul>
			</li>
			@endif

			
			<!--@if((isset($value[$permission_level]['agent-stock']) && $value[$permission_level]['agent-stock'] == 1) ||
				(isset($value[$permission_level]['sales-report']) && $value[$permission_level]['sales-report'] == 1) || 
				(isset($value[$permission_level]['order-report']) && $value[$permission_level]['order-report'] == 1) || 
				(isset($value[$permission_level]['commission-report']) && $value[$permission_level]['commission-report'] == 1))
			<li class="{{ (Request::segment(1) == 'agent_stock_report' || Request::segment(1) == 'sales_report' || Request::segment(1) == 'order_report' || Request::segment(1) == 'commission_report' ||
			Request::segment(1) == 'redemption_report') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text">
						Report Manage
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<ul class="submenu">
					@if(isset($value[$permission_level]['agent-stock']) && $value[$permission_level]['agent-stock'] == 1)
					<li class="{{ (Request::segment(1) == 'agent_stock_report') ? 'active open' : '' }}">
						<a href="{{ route('agent_stock_report') }}">
							<i class="menu-icon fa fa-caret-right" aria-hidden="true"></i>
							<span class="menu-text">Agent Stock Report </span>
						</a>

						<b class="arrow"></b>
					</li> 
					@endif

					@if(isset($value[$permission_level]['sales-report']) && $value[$permission_level]['sales-report'] == 1)
					<li class="{{ (Request::segment(1) == 'sales_report') ? 'active open' : '' }}">
						<a href="{{ route('sales_report') }}">
							<i class="menu-icon fa fa-caret-right" aria-hidden="true"></i>
							<span class="menu-text">Item Profit Report </span>
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					@if(isset($value[$permission_level]['order-report']) && $value[$permission_level]['order-report'] == 1)
					<li class="{{ (Request::segment(1) == 'order_report') ? 'active open' : '' }}">
						<a href="{{ route('order_report') }}">
							<i class="menu-icon fa fa-caret-right" aria-hidden="true"></i>
							<span class="menu-text">Order Report </span>
						</a>

						<b class="arrow"></b>
					</li>

					<li class="{{ (Request::segment(1) == 'redemption_report') ? 'active open' : '' }}">
						<a href="{{ route('redemption_report') }}">
							<i class="menu-icon fa fa-caret-right" aria-hidden="true"></i>
							<span class="menu-text">Redemption Report </span>
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					@if(isset($value[$permission_level]['commission-report']) && $value[$permission_level]['commission-report'] == 1)
					<li class="{{ (Request::segment(1) == 'commission_report') ? 'active open' : '' }}">
						<a href="{{ route('commission_report') }}">
							<i class="menu-icon fa fa-caret-right" aria-hidden="true"></i>
							<span class="menu-text">Commission Report </span>
						</a>

						<b class="arrow"></b>
					</li>
					@endif
				</ul>
			</li>
			@endif-->

			<!--@if(isset($value[$permission_level]['affiliate-list']) && $value[$permission_level]['affiliate-list'] == 1)
			<li class="{{ (Request::segment(1) == 'affiliates') ? 'active open' : '' }}">
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-users"></i>
					<span class="menu-text">
						Affiliate Manage
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<ul class="submenu">
					
					<li class="{{ (Request::segment(1) == 'affiliates') ? 'active' : '' }}">
						<a href="{{ route('affiliates', Auth::user()->code) }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Affiliate List
						</a>

						<b class="arrow"></b>
					</li>
				</ul>
			</li>
			@endif-->

			@if(isset($value[$permission_level]['agent-order-rebate']) && $value[$permission_level]['agent-order-rebate'] == 1 || 
				isset($value[$permission_level]['extra-cash-rebate']) && $value[$permission_level]['extra-cash-rebate'] == 1 || 
				isset($value[$permission_level]['shipping-fee']) && $value[$permission_level]['shipping-fee'] == 1 || 
				isset($value[$permission_level]['agent-level']) && $value[$permission_level]['agent-level'] == 1 || 
				isset($value[$permission_level]['setting-uom']) && $value[$permission_level]['setting-uom'] == 1 || 
				isset($value[$permission_level]['setting-banner']) && $value[$permission_level]['setting-banner'] == 1 || isset($value[$permission_level]['setting-banner-testing']) && $value[$permission_level]['setting-banner-testing'] == 1 ||
				isset($value[$permission_level]['setting-banner-video']) && $value[$permission_level]['setting-banner-video'] == 1 ||  
				isset($value[$permission_level]['product-topup']) && $value[$permission_level]['product-topup'] == 1 || 
				isset($value[$permission_level]['affiliate-topup']) && $value[$permission_level]['affiliate-topup'] == 1 || 
				isset($value[$permission_level]['setting-charges']) && $value[$permission_level]['setting-charges'] == 1 || 
				isset($value[$permission_level]['set-pickup-address']) && $value[$permission_level]['set-pickup-address'] == 1)

			<li class="{{ (Request::segment(1) == 'setting_merchant_bonus' || Request::segment(1) == 'setting_agent_rebate' || 
					   Request::segment(1) == 'setting_agent_level' || Request::segment(1) == 'setting_merchant_commission' || 
					   Request::segment(1) == 'setting_performance_dividend' ||
					   Request::segment(1) == 'setting_team_dividend' ||
					   Request::segment(1) == 'setting_shipping_fee' ||
					   Request::segment(1) == 'setting_recommend_bonus' || Request::segment(1) == 'setting_uom' || 
					   Request::segment(1) == 'setting_dual_commission' || Request::segment(1) == 'setting_downline_bonus' || Request::segment(1) == 'setting_agent_monthly_sales_bonus' || 
					   Request::segment(1) == 'setting_charges' || 
					   Request::segment(1) == 'setting_banner' ||
					   Request::segment(1) == 'setting_banner_testing' ||
					   Request::segment(1) == 'setting_banner_video' ||
					   Request::segment(1) == 'setting_topup_amount' ||
					   Request::segment(1) == 'setting_extra_cash_rebate' || 
					   Request::segment(1) == 'setting_affiliate_topups') ? 'active open' : '' }}">
					   
				<a href="#" class="dropdown-toggle">
					<i class="menu-icon fa fa-cogs"></i>
					<span class="menu-text">
						Settings
					</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<ul class="submenu">
					

					
					@if(isset($value[$permission_level]['setting-banner']) && $value[$permission_level]['setting-banner'] == 1)
					<li class="{{ (Request::segment(1) == 'setting_banner') ? 'active' : '' }}">
						<a href="{{ route('setting_banner') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Setting Banner
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					<li class="{{ (Request::segment(1) == 'setting_banner_testing') ? 'active' : '' }}">
						<a href="{{ route('setting_banner_testing') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Setting Home Page Images
						</a>

						<b class="arrow"></b>
					</li>

					<li class="{{ (Request::segment(1) == 'setting_banner_video') ? 'active' : '' }}">
						<a href="{{ route('setting_banner_video') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Setting Banner Video 
						</a>

						<b class="arrow"></b>
					</li>

					

					@if(isset($value[$permission_level]['shipping-fee']) && $value[$permission_level]['shipping-fee'] == 1)
					<li class="{{ (Request::segment(1) == 'setting_shipping_fee') ? 'active' : '' }}">
						<a href="{{ route('setting_shipping_fee') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Shipping Fees
						</a>

						<b class="arrow"></b>
					</li>
					@endif

					@if(isset($value[$permission_level]['setting-uom']) && $value[$permission_level]['setting-uom'] == 1)
					<li class="{{ (Request::segment(1) == 'setting_uom') ? 'active' : '' }}">
						<a href="{{ route('setting_uom') }}">
							<i class="menu-icon fa fa-caret-right"></i>
							Setting UOM
						</a>

						<b class="arrow"></b>
					</li>
					@endif
					
					
					
					
					
					

				</ul>
			</li>
			@endif
		@endforeach
	</ul><!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>