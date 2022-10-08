@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
       Permission Control
    </h1>
</div>

<!-- <h2>SYSTEM UPDATE</h2>
<hr>
<h4>
	This page and functions are temporary unavailable. System update will be complete in soon..<br>
</h4>
<span style="font-size: 12px">(If any inquiries please contact your IT consultance.)</span>
 -->
 <!-- <h3>
	添加新级别
</h3>
<hr>
<label>级别名称</label>
 <div class="parent-box">
	<form method="POST" action="{{ route('add_permission_level') }}" id="setting-permission">
	@csrf
		@foreach($selects as $key => $select)
		<div class="child-box">
		 	<div class="form-group">
				 <div class="row">
				 	<div class="col-sm-6">
				 		<div class="row">
				 			<div class="col-xs-10">
				 				<input type="hidden" name="pid[]" value="{{ $select->id }}">
						 		<input type="text" class="form-control" name="name[]" value="{{ $select->name }}" placeholder="列: 管理员">
				 			</div>
				 			<div class="col-xs-2" align="center">
				 				@if($key != '0')
					 				<a href="#" class="del important-text" data-id="{{ $select->id }}">
					 					<i class="fa fa-trash fa-2x"></i>
					 				</a>
					 			@endif
				 			</div>
				 		</div>
				 	</div>
				 </div>
		 	</div>
	 	</div>
		@endforeach

	 	<div class="child-box">
		 	<div class="form-group">
				 <div class="row">
				 	<div class="col-sm-6">
				 		<div class="row">
				 			<div class="col-xs-10">
				 				<input type="hidden" name="pid[]">
						 		<input type="text" class="form-control" name="name[]" value="" placeholder="列: 管理员">
				 			</div>
				 			<div class="col-xs-2" align="center">
				 				<a class="del important-text">
				 					<i class="fa fa-trash fa-2x"></i>
				 				</a>
				 			</div>
				 		</div>
				 	</div>
				 </div>
		 	</div>
	 	</div>
	</form>
	 <div class="row">
	 	<div class="col-md-6" align="center">
	 		<hr>
	 		<a href="#" class="add-shipping-btn">
	 			<i class="fa fa-plus"></i>
	 		</a>
	 	</div>
	 </div>
</div>
<hr> -->
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->

		<div class="row">
			<div class="col-sm-6">
				<div class="widget-box widget-color-blue2">
					<div class="widget-header">
						<h4 class="widget-title lighter smaller">Super Admin</h4>
					</div>

					<div class="widget-body">
						<div class="widget-main padding-8">
							<ul id="tree1"></ul>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="widget-box widget-color-blue2">
					<div class="widget-header">
						<h4 class="widget-title lighter smaller">Admin</h4>
					</div>

					<div class="widget-body">
						<div class="widget-main padding-8">
							<ul id="tree2"></ul>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="widget-box widget-color-blue2">
					<div class="widget-header">
						<h4 class="widget-title lighter smaller">User 1</h4>
					</div>

					<div class="widget-body">
						<div class="widget-main padding-8">
							<ul id="tree3"></ul>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="widget-box widget-color-blue2">
					<div class="widget-header">
						<h4 class="widget-title lighter smaller">User 2</h4>
					</div>

					<div class="widget-body">
						<div class="widget-main padding-8">
							<ul id="tree4"></ul>
						</div>
					</div>
				</div>
			</div>

			<div class="col-sm-6">
				<div class="widget-box widget-color-blue2">
					<div class="widget-header">
						<h4 class="widget-title lighter smaller">User 3</h4>
					</div>

					<div class="widget-body">
						<div class="widget-main padding-8">
							<ul id="tree5"></ul>
						</div>
					</div>
				</div>
			</div>
		</div>

		
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div>
<!-- <div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<button class="btn btn-primary">
			<i class="fa fa-check"> 保存</i>
		</button>

	</div>
</div> -->
@endsection


@section('js')
<script type="text/javascript">
			jQuery(function($){	var sampleData = initiateDemoData();
			$('#tree1').ace_tree({		
				dataSource: sampleData['dataSource1'],		
				multiSelect: true,		
				cacheItems: true,		
				'open-icon' : 'ace-icon tree-minus',		
				'close-icon' : 'ace-icon tree-plus',		
				'itemSelect' : true,		
				'folderSelect': false,		
				'selected-icon' : 'ace-icon fa fa-check',		
				'unselected-icon' : 'ace-icon fa fa-times',		
				loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'	
			});
			$('#tree2').ace_tree({		
				dataSource: sampleData['dataSource2'],		
				multiSelect: true,		
				cacheItems: true,		
				'open-icon' : 'ace-icon tree-minus',		
				'close-icon' : 'ace-icon tree-plus',		
				'itemSelect' : true,		
				'folderSelect': false,		
				'selected-icon' : 'ace-icon fa fa-check',		
				'unselected-icon' : 'ace-icon fa fa-times',		
				loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'	
			});
			$('#tree3').ace_tree({		
				dataSource: sampleData['dataSource3'],		
				multiSelect: true,		
				cacheItems: true,		
				'open-icon' : 'ace-icon tree-minus',		
				'close-icon' : 'ace-icon tree-plus',		
				'itemSelect' : true,		
				'folderSelect': false,		
				'selected-icon' : 'ace-icon fa fa-check',		
				'unselected-icon' : 'ace-icon fa fa-times',		
				loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'	
			});
			$('#tree4').ace_tree({		
				dataSource: sampleData['dataSource4'],		
				multiSelect: true,		
				cacheItems: true,		
				'open-icon' : 'ace-icon tree-minus',		
				'close-icon' : 'ace-icon tree-plus',		
				'itemSelect' : true,		
				'folderSelect': false,		
				'selected-icon' : 'ace-icon fa fa-check',		
				'unselected-icon' : 'ace-icon fa fa-times',		
				loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'	
			});
			$('#tree5').ace_tree({		
				dataSource: sampleData['dataSource5'],		
				multiSelect: true,		
				cacheItems: true,		
				'open-icon' : 'ace-icon tree-minus',		
				'close-icon' : 'ace-icon tree-plus',		
				'itemSelect' : true,		
				'folderSelect': false,		
				'selected-icon' : 'ace-icon fa fa-check',		
				'unselected-icon' : 'ace-icon fa fa-times',		
				loadingHTML : '<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>'	
			});
			$('#tree1').find("li:not([data-template])").remove();	
			$('#tree1').tree('render');		
			
			$('#tree1').tree('discloseAll');
			$('#tree1')	.on('loaded.fu.tree', function(e) {

			}).on('updated.fu.tree', function(e, result) {	

			}).on('selected.fu.tree', function(e, result) {	
				// console.log(result.target.attr['id']);
				// $('.loading-gif').show();
				// var fd = new FormData();
				// 	fd.append('page', result.target.attr['class']);
				// 	fd.append('permission_lvl', result.target.attr['data-id']);
				// $.ajax({
			 //       url: '{{ route("SetPermission") }}',
			 //       type: 'post',
			 //       data: fd,
			 //       contentType: false,
			 //       processData: false,
			 //       success: function(response){
			       		
			 //       		$('.loading-gif').hide();
			 //       }
			 //   });
			}).on('deselected.fu.tree', function(e, result) {
				$('.loading-gif').show();
				var fd = new FormData();
					fd.append('page', result.target.attr['class']);
					fd.append('permission_lvl', result.target.attr['data-id']);
				$.ajax({
			       url: '{{ route("UnsetPermission") }}',
			       type: 'post',
			       data: fd,
			       contentType: false,
			       processData: false,
			       success: function(response){

			       		$('.loading-gif').hide();
			       }
			    });
			}).on('opened.fu.tree', function(e) {	

			}).on('closed.fu.tree', function(e) {	

			}).on('disclosedAll.fu.tree', function(e) {	
				
			});

			$('#tree2').find("li:not([data-template])").remove();	
			$('#tree2').tree('render');		
			
			$('#tree2').tree('discloseAll');
			$('#tree2')	.on('loaded.fu.tree', function(e) {

			}).on('updated.fu.tree', function(e, result) {	

			}).on('selected.fu.tree', function(e, result) {	
				// console.log(result.target.attr['class']);
				// $('.loading-gif').show();
				// var fd = new FormData();
				// 	fd.append('page', result.target.attr['class']);
				// 	fd.append('permission_lvl', result.target.attr['data-id']);
				// $.ajax({
			 //       url: '{{ route("SetPermission") }}',
			 //       type: 'post',
			 //       data: fd,
			 //       contentType: false,
			 //       processData: false,
			 //       success: function(response){
			 //       		$('.loading-gif').hide();
			 //       }
			 //   });
			}).on('deselected.fu.tree', function(e, result) {
				$('.loading-gif').show();
				var fd = new FormData();
					fd.append('page', result.target.attr['class']);
					fd.append('permission_lvl', result.target.attr['data-id']);
				$.ajax({
			       url: '{{ route("UnsetPermission") }}',
			       type: 'post',
			       data: fd,
			       contentType: false,
			       processData: false,
			       success: function(response){
			       		$('.loading-gif').hide();
			       }
			    });
			}).on('opened.fu.tree', function(e) {	

			}).on('closed.fu.tree', function(e) {	

			}).on('disclosedAll.fu.tree', function(e) {	
				
			});		

			$('#tree3').find("li:not([data-template])").remove();	
			$('#tree3').tree('render');		
			
			$('#tree3').tree('discloseAll');
			$('#tree3')	.on('loaded.fu.tree', function(e) {

			}).on('updated.fu.tree', function(e, result) {	

			}).on('selected.fu.tree', function(e, result) {	
				// console.log(result.target.attr['class']);
				// $('.loading-gif').show();
				// var fd = new FormData();
				// 	fd.append('page', result.target.attr['class']);
				// 	fd.append('permission_lvl', result.target.attr['data-id']);
				// $.ajax({
			 //       url: '{{ route("SetPermission") }}',
			 //       type: 'post',
			 //       data: fd,
			 //       contentType: false,
			 //       processData: false,
			 //       success: function(response){
			 //       		$('.loading-gif').hide();
			 //       }
			 //   });
			}).on('deselected.fu.tree', function(e, result) {
				$('.loading-gif').show();
				var fd = new FormData();
					fd.append('page', result.target.attr['class']);
					fd.append('permission_lvl', result.target.attr['data-id']);
				$.ajax({
			       url: '{{ route("UnsetPermission") }}',
			       type: 'post',
			       data: fd,
			       contentType: false,
			       processData: false,
			       success: function(response){
			       		$('.loading-gif').hide();
			       }
			    });
			}).on('opened.fu.tree', function(e) {	

			}).on('closed.fu.tree', function(e) {	

			}).on('disclosedAll.fu.tree', function(e) {	
				
			});

			$('#tree4').find("li:not([data-template])").remove();	
			$('#tree4').tree('render');		
			
			$('#tree4').tree('discloseAll');
			$('#tree4')	.on('loaded.fu.tree', function(e) {

			}).on('updated.fu.tree', function(e, result) {	

			}).on('selected.fu.tree', function(e, result) {	
				// console.log(result.target.attr['class']);
				// $('.loading-gif').show();
				// var fd = new FormData();
				// 	fd.append('page', result.target.attr['class']);
				// 	fd.append('permission_lvl', result.target.attr['data-id']);
				// $.ajax({
			 //       url: '{{ route("SetPermission") }}',
			 //       type: 'post',
			 //       data: fd,
			 //       contentType: false,
			 //       processData: false,
			 //       success: function(response){
			 //       		$('.loading-gif').hide();
			 //       }
			 //   });
			}).on('deselected.fu.tree', function(e, result) {
				$('.loading-gif').show();
				var fd = new FormData();
					fd.append('page', result.target.attr['class']);
					fd.append('permission_lvl', result.target.attr['data-id']);
				$.ajax({
			       url: '{{ route("UnsetPermission") }}',
			       type: 'post',
			       data: fd,
			       contentType: false,
			       processData: false,
			       success: function(response){
			       		$('.loading-gif').hide();
			       }
			    });
			}).on('opened.fu.tree', function(e) {	

			}).on('closed.fu.tree', function(e) {	

			}).on('disclosedAll.fu.tree', function(e) {	
				
			});

			$('#tree5').find("li:not([data-template])").remove();	
			$('#tree5').tree('render');		
			
			$('#tree5').tree('discloseAll');
			$('#tree5')	.on('loaded.fu.tree', function(e) {

			}).on('updated.fu.tree', function(e, result) {	

			}).on('selected.fu.tree', function(e, result) {	
				// console.log(result.target.attr['class']);
				// $('.loading-gif').show();
				// var fd = new FormData();
				// 	fd.append('page', result.target.attr['class']);
				// 	fd.append('permission_lvl', result.target.attr['data-id']);
				// $.ajax({
			 //       url: '{{ route("SetPermission") }}',
			 //       type: 'post',
			 //       data: fd,
			 //       contentType: false,
			 //       processData: false,
			 //       success: function(response){
			 //       		$('.loading-gif').hide();
			 //       }
			 //   });
			}).on('deselected.fu.tree', function(e, result) {
				$('.loading-gif').show();
				var fd = new FormData();
					fd.append('page', result.target.attr['class']);
					fd.append('permission_lvl', result.target.attr['data-id']);
				$.ajax({
			       url: '{{ route("UnsetPermission") }}',
			       type: 'post',
			       data: fd,
			       contentType: false,
			       processData: false,
			       success: function(response){
			       		$('.loading-gif').hide();
			       }
			    });
			}).on('opened.fu.tree', function(e) {	

			}).on('closed.fu.tree', function(e) {	

			}).on('disclosedAll.fu.tree', function(e) {	
				
			});

			function initiateDemoData(){		
				var tree_data = {
					'dashboard' : {text: 'Dashboard', 
								 type: 'item',
								 "attr": {
									        "class": "dashboard",
									        "data-id": '1'
									     }
								},
					'profile' : {text: 'Company Profile', 
								 type: 'item',
								 "attr": {
									        "class": "profile",
									        "data-id": '1'
									     }
								},
					'permission' : {text: 'Permission Control', 
								 type: 'item',
								 "attr": {
									        "class": "permission-control",
									        "data-id": '1'
									     }
								},
					'for-sale' : {text: 'Agent Manage', type: 'folder'},
					'members' : {text: 'Member Manage', type: 'folder'},
					'vehicles' : {text: 'Product Manage', type: 'folder'},
					
					'rentals' : {text: 'Category Manage', type: 'folder'},
					'sub_category' : {text: 'Sub Category Manage', type: 'folder'},
					'real-estate' : {text: 'Brand Manage', type: 'folder'},			
					'banks' : {text: 'Bank Manage', type: 'folder'},			
					'pets' : {text: 'Promotion Manage', type: 'folder'}	,			
					'tickets' : {text: 'Transaction Manage', type: 'folder'},
					'reports' : {text: 'Report Manage', type: 'folder'},
					'services' : {text: 'Affiliate Manage', type: 'folder'},			
					'personals' : {text: 'Setting Manage', type: 'folder'}		
				}		
				tree_data['for-sale']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Agent List', 
										type: 'item',
										"attr": {
									        "class": "agent-list",
									        "data-id": '1'
									    }
									   },
						'arts-crafts' : {text: 'Add New Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-add",
									        "data-id": '1'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-pending",
									        "data-id": '1'
									     }
									    },
					}
				}	
				tree_data['members']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Member List', 
										type: 'item',
										"attr": {
									        "class": "member-list",
									        "data-id": '1'
									    }
									   },
						'arts-crafts' : {text: 'Add New Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-add",
									        "data-id": '1'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-pending",
									        "data-id": '1'
									     }
									    },
					}
				}		
				tree_data['vehicles']['additionalParameters'] = {			
					'children' : {
						'motorcycles' : {
										 text: 'Product List', 
										 type: 'item',
									     "attr": {
									        "class": "product-list",
									        "data-id": '1'
									     }
										},				
						'boats' : {
								         text: 'Add New Product', type: 'item',
									     "attr": {
									        "class": "product-add",
									        "data-id": '1'
									     }
								  },
						'sdffgh' : {
									text: 'Packages List', type: 'item',
									     "attr": {
									        "class": "product-packages",
									        "data-id": '1'
									     }
								  },
						'zxcvbn' : {
									text: 'Add New Packages', type: 'item',
									     "attr": {
									        "class": "product-packages-add",
									        "data-id": '1'
									     }
								  }


					}		
				}
				tree_data['rentals']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Category List', type: 'item',
									     "attr": {
									        "class": "category-list",
									        "data-id": '1'
									     }},				
						'vacation-rentals' : {text: 'Add New Category', type: 'item',
									     "attr": {
									        "class": "category-add",
									        "data-id": '1'
									     }}			
					}		
				}	
				tree_data['sub_category']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Sub Category List', type: 'item',
									     "attr": {
									        "class": "sub-category-list",
									        "data-id": '1'
									     }},				
						'vacation-rentals' : {text: 'Add New Sub Category', type: 'item',
									     "attr": {
									        "class": "sub-category-add",
									        "data-id": '1'
									     }}			
					}		
				}		
				tree_data['real-estate']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Brand List', type: 'item',
									     "attr": {
									        "class": "brand-list",
									        "data-id": '1'
									     }},
						'plots' : {text: 'Add New Brand', type: 'item',
									     "attr": {
									        "class": "brand-add",
									        "data-id": '1'
									     }}			
					}		
				}		
				tree_data['banks']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Bank List', type: 'item',
									     "attr": {
									        "class": "bank-list",
									        "data-id": '1'
									     }},
						'plots' : {text: 'Add New Bank', type: 'item',
									     "attr": {
									        "class": "bank-add",
									        "data-id": '1'
									     }}			
					}		
				}		
				tree_data['pets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Promotion List', type: 'item',
									     "attr": {
									        "class": "promotion-list",
									        "data-id": '1'
									     }},				
						'dogs' : {text: 'Add New Promotion', type: 'item',
									     "attr": {
									        "class": "promotion-add",
									        "data-id": '1'
									     }},
					}		
				}
				tree_data['tickets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Transaction List', type: 'item',
									     "attr": {
									        "class": "transaction-list",
									        "data-id": '1'
									     }},
						'dogs' : {text: 'Withdrawal List', type: 'item',
									     "attr": {
									        "class": "withdrawal-list",
									        "data-id": '1'
									     }},
					}		
				}
				tree_data['reports']['additionalParameters'] = {			
					'children' : {				
						
						'dogs' : {text: 'Item Profit Report', type: 'item',
									     "attr": {
									        "class": "sales-report",
									        "data-id": '1'
									     }},
						'c' : {text: 'Order Report', type: 'item',
									     "attr": {
									        "class": "order-report",
									        "data-id": '1'
									     }},
						'd' : {text: 'Commission Report', type: 'item',
									     "attr": {
									        "class": "commission-report",
									        "data-id": '1'
									     }},
					}		
				}
				tree_data['services']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Affiliate List', type: 'item',
									     "attr": {
									        "class": "affiliate-list",
									        "data-id": '1'
									     }},
					}		
				}
				tree_data['personals']['additionalParameters'] = {
					'children' : {
						'agent-level' : {text: 'Agent Level', type: 'item',
									     "attr": {
									        "class": "agent-level",
									        "data-id": '1'
									     }},
						'cars' : {text: 'Bonus Setting', type: 'folder'},				
						'banners' : {text: 'Setting Banner', type: 'item',
									     "attr": {
									        "class": "setting-banner",
									        "data-id": '1'
									     }},				
						'motorcycles-1' : {text: 'Setting Shipping Fee', type: 'item',
									     "attr": {
									        "class": "shipping-fee",
									        "data-id": '1'
									     }},
						'motorcycles' : {text: 'Setting UOM', type: 'item',
									     "attr": {
									        "class": "setting-uom",
									        "data-id": '1'
									     }},
						'product-topup' : {text: 'Product Topup Packages', type: 'item',
									     "attr": {
									        "class": "product-topup",
									        "data-id": '1'
									     }},
						'affiliate-topup' : {text: 'Affiliate Topup Packages', type: 'item',
									     "attr": {
									        "class": "affiliate-topup",
									        "data-id": '1'
									     }},
						'setting-charges' : {text: 'Setting Charges', type: 'item',
									     "attr": {
									        "class": "setting-charges",
									        "data-id": '1'
									     }},
						'set-pickup-address' : {text: 'Setting Pickup Address', type: 'item',
									     "attr": {
									        "class": "set-pickup-address",
									        "data-id": '1'
									     }},
					}		
				}
				
				tree_data['personals']['additionalParameters']['children']['cars']['additionalParameters'] = {			
					'children' : {				
						'classics' : {text: 'Agent Order Rebate', type: 'item',
									     "attr": {
									        "class": "agent-order-rebate",
									        "data-id": '1'
									     }},
					}		
				}

				var tree_data_2 = {
					'dashboard' : {text: 'Dashboard', 
								 type: 'item',
								 "attr": {
									        "class": "dashboard",
									        "data-id": '2'
									     }
								},
					'profile' : {text: 'Profile', 
								 type: 'item',
								 "attr": {
									        "class": "profile",
									        "data-id": '2'
									     }
								},
					'permission' : {text: 'Permission Control', 
								 type: 'item',
								 "attr": {
									        "class": "permission-control",
									        "data-id": '2'
									     }
								},
					'for-sale' : {text: 'Agent Manage', type: 'folder'},
					'members' : {text: 'Member Manage', type: 'folder'},
					'vehicles' : {text: 'Product Manage', type: 'folder'},
					
					'rentals' : {text: 'Category Manage', type: 'folder'},
					'sub_category' : {text: 'Sub Category Manage', type: 'folder'},
					'real-estate' : {text: 'Brand Manage', type: 'folder'},
					'banks' : {text: 'Bank Manage', type: 'folder'},
					'pets' : {text: 'Promotion Manage', type: 'folder'},
					'tickets' : {text: 'Transaction Manage', type: 'folder'},
					'reports' : {text: 'Report Manage', type: 'folder'},
					'services' : {text: 'Affiliate Manage', type: 'folder'},			
					'personals' : {text: 'Setting Manage', type: 'folder'}		
				}		
				tree_data_2['for-sale']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Agent List', 
										type: 'item',
										"attr": {
									        "class": "agent-list",
									        "data-id": '2'
									    }
									   },
						'arts-crafts' : {text: 'Add New Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-add",
									        "data-id": '2'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-pending",
									        "data-id": '2'
									     }
									    },
					}
				}	
				tree_data_2['members']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Member List', 
										type: 'item',
										"attr": {
									        "class": "member-list",
									        "data-id": '2'
									    }
									   },
						'arts-crafts' : {text: 'Add New Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-add",
									        "data-id": '2'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-pending",
									        "data-id": '2'
									     }
									    },
					}
				}		
				tree_data_2['vehicles']['additionalParameters'] = {			
					'children' : {
						'motorcycles' : {
										 text: 'Product List', 
										 type: 'item',
									     "attr": {
									        "class": "product-list",
									        "data-id": '2'
									     }
										},				
						'boats' : {text: 'Add New Product', type: 'item',
									     "attr": {
									        "class": "product-add",
									        "data-id": '2'
									     }
								  },
						'sdffgh' : {
									text: 'Packages List', type: 'item',
									     "attr": {
									        "class": "product-packages",
									        "data-id": '2'
									     }
								  },
						'zxcvbn' : {
									text: 'Add New Packages', type: 'item',
									     "attr": {
									        "class": "product-packages-add",
									        "data-id": '2'
									     }
								  }
					}		
				}
				tree_data_2['rentals']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Category List', type: 'item',
									     "attr": {
									        "class": "category-list",
									        "data-id": '2'
									     }},				
						'vacation-rentals' : {text: 'Add New Category', type: 'item',
									     "attr": {
									        "class": "category-add",
									        "data-id": '2'
									     }}			
					}		
				}	
				tree_data_2['sub_category']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Sub Category List', type: 'item',
									     "attr": {
									        "class": "sub-category-list",
									        "data-id": '2'
									     }},				
						'vacation-rentals' : {text: 'Add New Sub Category', type: 'item',
									     "attr": {
									        "class": "sub-category-add",
									        "data-id": '2'
									     }}			
					}		
				}		
				tree_data_2['real-estate']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Brand List', type: 'item',
									     "attr": {
									        "class": "brand-list",
									        "data-id": '2'
									     }},
						'plots' : {text: 'Add New Brand', type: 'item',
									     "attr": {
									        "class": "brand-add",
									        "data-id": '2'
									     }}			
					}		
				}		
				tree_data_2['banks']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Bank List', type: 'item',
									     "attr": {
									        "class": "bank-list",
									        "data-id": '2'
									     }},
						'plots' : {text: 'Add New Bank', type: 'item',
									     "attr": {
									        "class": "bank-add",
									        "data-id": '2'
									     }}			
					}		
				}		
				tree_data_2['pets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Promotion List', type: 'item',
									     "attr": {
									        "class": "promotion-list",
									        "data-id": '2'
									     }},				
						'dogs' : {text: 'Add New Promotion', type: 'item',
									     "attr": {
									        "class": "promotion-add",
									        "data-id": '2'
									     }},
					}		
				}
				tree_data_2['tickets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Transaction List', type: 'item',
									     "attr": {
									        "class": "transaction-list",
									        "data-id": '2'
									     }},
						'dogs' : {text: 'Withdrawal List', type: 'item',
									     "attr": {
									        "class": "withdrawal-list",
									        "data-id": '2'
									     }},
					}
				}
				tree_data_2['reports']['additionalParameters'] = {			
					'children' : {				
						
						'dogs' : {text: 'Item Profit Report', type: 'item',
									     "attr": {
									        "class": "sales-report",
									        "data-id": '2'
									     }},
						'c' : {text: 'Order Report', type: 'item',
									     "attr": {
									        "class": "order-report",
									        "data-id": '2'
									     }},
						'd' : {text: 'Commission Report', type: 'item',
									     "attr": {
									        "class": "commission-report",
									        "data-id": '2'
									     }},
					}	
				}
				tree_data_2['services']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Affiliate List', type: 'item',
									     "attr": {
									        "class": "affiliate-list",
									        "data-id": '2'
									     }},
					}		
				}
				tree_data_2['personals']['additionalParameters'] = {
					'children' : {
						'agent-level' : {text: 'Agent Level', type: 'item',
									     "attr": {
									        "class": "agent-level",
									        "data-id": '2'
									     }},
						'cars' : {text: 'Bonus Setting', type: 'folder'},				
						'banners' : {text: 'Setting Banner', type: 'item',
									     "attr": {
									        "class": "setting-banner",
									        "data-id": '2'
									     }},				
						'motorcycles-1' : {text: 'Setting Shipping Fee', type: 'item',
									     "attr": {
									        "class": "shipping-fee",
									        "data-id": '2'
									     }},
						'motorcycles' : {text: 'Setting UOM', type: 'item',
									     "attr": {
									        "class": "setting-uom",
									        "data-id": '2'
									     }},
						'product-topup' : {text: 'Product Topup Packages', type: 'item',
									     "attr": {
									        "class": "product-topup",
									        "data-id": '2'
									     }},
						'affiliate-topup' : {text: 'Affiliate Topup Packages', type: 'item',
									     "attr": {
									        "class": "affiliate-topup",
									        "data-id": '2'
									     }},
						'setting-charges' : {text: 'Setting Charges', type: 'item',
									     "attr": {
									        "class": "setting-charges",
									        "data-id": '2'
									     }},
						'set-pickup-address' : {text: 'Setting Pickup Address', type: 'item',
									     "attr": {
									        "class": "set-pickup-address",
									        "data-id": '2'
									     }},
					}		
				}
				tree_data_2['personals']['additionalParameters']['children']['cars']['additionalParameters'] = {			
					'children' : {				
						'classics' : {text: 'Agent Order Rebate', type: 'item',
									     "attr": {
									        "class": "agent-order-rebate",
									        "data-id": '2'
									     }},
					}		
				}

				var tree_data_3 = {
					'dashboard' : {text: 'Dashboard', 
								 type: 'item',
								 "attr": {
									        "class": "dashboard",
									        "data-id": '3'
									     }
								},
					'profile' : {text: 'Profile', 
								 type: 'item',
								 "attr": {
									        "class": "profile",
									        "data-id": '3'
									     }
								},
					'permission' : {text: 'Permission Control', 
								 type: 'item',
								 "attr": {
									        "class": "permission-control",
									        "data-id": '3'
									     }
								},
					'for-sale' : {text: 'Agent Manage', type: 'folder'},
					'members' : {text: 'Member Manage', type: 'folder'},
					'vehicles' : {text: 'Product Manage', type: 'folder'},
					
					'rentals' : {text: 'Category Manage', type: 'folder'},
					'sub_category' : {text: 'Sub Category Manage', type: 'folder'},
					'real-estate' : {text: 'Brand Manage', type: 'folder'},
					'banks' : {text: 'Bank Manage', type: 'folder'},
					'pets' : {text: 'Promotion Manage', type: 'folder'},
					'tickets' : {text: 'Transaction Manage', type: 'folder'},
					'reports' : {text: 'Report Manage', type: 'folder'},
					'services' : {text: 'Affiliate Manage', type: 'folder'},			
					'personals' : {text: 'Setting Manage', type: 'folder'}		
				}		
				tree_data_3['for-sale']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Agent List', 
										type: 'item',
										"attr": {
									        "class": "agent-list",
									        "data-id": '3'
									    }
									   },
						'arts-crafts' : {text: 'Add New Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-add",
									        "data-id": '3'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-pending",
									        "data-id": '3'
									     }
									    },
					}
				}

				tree_data_3['members']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Member List', 
										type: 'item',
										"attr": {
									        "class": "member-list",
									        "data-id": '3'
									    }
									   },
						'arts-crafts' : {text: 'Add New Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-add",
									        "data-id": '3'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-pending",
									        "data-id": '3'
									     }
									    },
					}
				}			
				tree_data_3['vehicles']['additionalParameters'] = {			
					'children' : {
						'motorcycles' : {
										 text: 'Product List', 
										 type: 'item',
									     "attr": {
									        "class": "product-list",
									        "data-id": '3'
									     }
										},				
						'boats' : {text: 'Add New Product', type: 'item',
									     "attr": {
									        "class": "product-add",
									        "data-id": '3'
									     }
								  },
						'sdffgh' : {
									text: 'Packages List', type: 'item',
									     "attr": {
									        "class": "product-packages",
									        "data-id": '3'
									     }
								  },
						'zxcvbn' : {
									text: 'Add New Packages', type: 'item',
									     "attr": {
									        "class": "product-packages-add",
									        "data-id": '3'
									     }
								  }
					}		
				}
				tree_data_3['rentals']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Category List', type: 'item',
									     "attr": {
									        "class": "category-list",
									        "data-id": '3'
									     }},				
						'vacation-rentals' : {text: 'Add New Category', type: 'item',
									     "attr": {
									        "class": "category-add",
									        "data-id": '3'
									     }}			
					}		
				}	
				tree_data_3['sub_category']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Sub Category List', type: 'item',
									     "attr": {
									        "class": "sub-category-list",
									        "data-id": '3'
									     }},				
						'vacation-rentals' : {text: 'Add New Sub Category', type: 'item',
									     "attr": {
									        "class": "sub-category-add",
									        "data-id": '3'
									     }}			
					}		
				}		
				tree_data_3['real-estate']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Brand List', type: 'item',
									     "attr": {
									        "class": "brand-list",
									        "data-id": '3'
									     }},
						'plots' : {text: 'Add New Brand', type: 'item',
									     "attr": {
									        "class": "brand-add",
									        "data-id": '3'
									     }}			
					}		
				}		
				tree_data_3['banks']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Bank List', type: 'item',
									     "attr": {
									        "class": "bank-list",
									        "data-id": '3'
									     }},
						'plots' : {text: 'Add New Bank', type: 'item',
									     "attr": {
									        "class": "bank-add",
									        "data-id": '3'
									     }}			
					}		
				}		
				tree_data_3['pets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Promotion List', type: 'item',
									     "attr": {
									        "class": "promotion-list",
									        "data-id": '3'
									     }},				
						'dogs' : {text: 'Add New Promotion', type: 'item',
									     "attr": {
									        "class": "promotion-add",
									        "data-id": '3'
									     }},
					}		
				}
				tree_data_3['tickets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Transaction List', type: 'item',
									     "attr": {
									        "class": "transaction-list",
									        "data-id": '3'
									     }},
						'dogs' : {text: 'Withdrawal List', type: 'item',
									     "attr": {
									        "class": "withdrawal-list",
									        "data-id": '3'
									     }},
					}
				}
				tree_data_3['reports']['additionalParameters'] = {			
					'children' : {				
						
						'dogs' : {text: 'Item Profit Report', type: 'item',
									     "attr": {
									        "class": "sales-report",
									        "data-id": '3'
									     }},
						'c' : {text: 'Order Report', type: 'item',
									     "attr": {
									        "class": "order-report",
									        "data-id": '3'
									     }},
						'd' : {text: 'Commission Report', type: 'item',
									     "attr": {
									        "class": "commission-report",
									        "data-id": '3'
									     }},
					}	
				}
				tree_data_3['services']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Affiliate List', type: 'item',
									     "attr": {
									        "class": "affiliate-list",
									        "data-id": '3'
									     }},
					}		
				}
				tree_data_3['personals']['additionalParameters'] = {
					'children' : {
						'agent-level' : {text: 'Agent Level', type: 'item',
									     "attr": {
									        "class": "agent-level",
									        "data-id": '3'
									     }},
						'cars' : {text: 'Bonus Setting', type: 'folder'},				
						'banners' : {text: 'Setting Banner', type: 'item',
									     "attr": {
									        "class": "setting-banner",
									        "data-id": '3'
									     }},				
						'motorcycles-1' : {text: 'Setting Shipping Fee', type: 'item',
									     "attr": {
									        "class": "shipping-fee",
									        "data-id": '3'
									     }},
						'motorcycles' : {text: 'Setting UOM', type: 'item',
									     "attr": {
									        "class": "setting-uom",
									        "data-id": '3'
									     }},
						'product-topup' : {text: 'Product Topup Packages', type: 'item',
									     "attr": {
									        "class": "product-topup",
									        "data-id": '3'
									     }},
						'affiliate-topup' : {text: 'Affiliate Topup Packages', type: 'item',
									     "attr": {
									        "class": "affiliate-topup",
									        "data-id": '3'
									     }},
						'setting-charges' : {text: 'Setting Charges', type: 'item',
									     "attr": {
									        "class": "setting-charges",
									        "data-id": '3'
									     }},
						'set-pickup-address' : {text: 'Setting Pickup Address', type: 'item',
									     "attr": {
									        "class": "set-pickup-address",
									        "data-id": '3'
									     }},
					}		
				}
				tree_data_3['personals']['additionalParameters']['children']['cars']['additionalParameters'] = {			
					'children' : {				
						'classics' : {text: 'Agent Order Rebate', type: 'item',
									     "attr": {
									        "class": "agent-order-rebate",
									        "data-id": '3'
									     }},		
					}		
				}

				var tree_data_4 = {
					'dashboard' : {text: 'Dashboard', 
								 type: 'item',
								 "attr": {
									        "class": "dashboard",
									        "data-id": '4'
									     }
								},
					'profile' : {text: 'Profile', 
								 type: 'item',
								 "attr": {
									        "class": "profile",
									        "data-id": '4'
									     }
								},
					'permission' : {text: 'Permission Control', 
								 type: 'item',
								 "attr": {
									        "class": "permission-control",
									        "data-id": '4'
									     }
								},
					'for-sale' : {text: 'Agent Manage', type: 'folder'},
					'members' : {text: 'Member Manage', type: 'folder'},
					'vehicles' : {text: 'Product Manage', type: 'folder'},
					
					'rentals' : {text: 'Category Manage', type: 'folder'},
					'sub_category' : {text: 'Sub Category Manage', type: 'folder'},
					'real-estate' : {text: 'Brand Manage', type: 'folder'},
					'banks' : {text: 'Bank Manage', type: 'folder'},
					'pets' : {text: 'Promotion Manage', type: 'folder'},
					'tickets' : {text: 'Transaction Manage', type: 'folder'},
					'reports' : {text: 'Report Manage', type: 'folder'},
					'services' : {text: 'Affiliate Manage', type: 'folder'},			
					'personals' : {text: 'Setting Manage', type: 'folder'}		
				}		
				tree_data_4['for-sale']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Agent List', 
										type: 'item',
										"attr": {
									        "class": "agent-list",
									        "data-id": '4'
									    }
									   },
						'arts-crafts' : {text: 'Add New Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-add",
									        "data-id": '4'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-pending",
									        "data-id": '4'
									     }
									    },
					}
				}		
				tree_data_4['vehicles']['additionalParameters'] = {			
					'children' : {
						'motorcycles' : {
										 text: 'Product List', 
										 type: 'item',
									     "attr": {
									        "class": "product-list",
									        "data-id": '4'
									     }
										},				
						'boats' : {text: 'Add New Product', type: 'item',
									     "attr": {
									        "class": "product-add",
									        "data-id": '4'
									     }
								  },
						'sdffgh' : {
									text: 'Packages List', type: 'item',
									     "attr": {
									        "class": "product-packages",
									        "data-id": '4'
									     }
								  },
						'zxcvbn' : {
									text: 'Add New Packages', type: 'item',
									     "attr": {
									        "class": "product-packages-add",
									        "data-id": '4'
									     }
								  }
					}		
				}


				tree_data_4['members']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Member List', 
										type: 'item',
										"attr": {
									        "class": "member-list",
									        "data-id": '4'
									    }
									   },
						'arts-crafts' : {text: 'Add New Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-add",
									        "data-id": '4'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-pending",
									        "data-id": '4'
									     }
									    },
					}
				}
				tree_data_4['rentals']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Category List', type: 'item',
									     "attr": {
									        "class": "category-list",
									        "data-id": '4'
									     }},				
						'vacation-rentals' : {text: 'Add New Category', type: 'item',
									     "attr": {
									        "class": "category-add",
									        "data-id": '4'
									     }}			
					}		
				}	
				tree_data_4['sub_category']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Sub Category List', type: 'item',
									     "attr": {
									        "class": "sub-category-list",
									        "data-id": '4'
									     }},				
						'vacation-rentals' : {text: 'Add New Sub Category', type: 'item',
									     "attr": {
									        "class": "sub-category-add",
									        "data-id": '4'
									     }}			
					}		
				}		
				tree_data_4['real-estate']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Brand List', type: 'item',
									     "attr": {
									        "class": "brand-list",
									        "data-id": '4'
									     }},
						'plots' : {text: 'Add New Brand', type: 'item',
									     "attr": {
									        "class": "brand-add",
									        "data-id": '4'
									     }}			
					}		
				}		
				tree_data_4['banks']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Bank List', type: 'item',
									     "attr": {
									        "class": "bank-list",
									        "data-id": '4'
									     }},
						'plots' : {text: 'Add New Bank', type: 'item',
									     "attr": {
									        "class": "bank-add",
									        "data-id": '4'
									     }}			
					}		
				}		
				tree_data_4['pets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Promotion List', type: 'item',
									     "attr": {
									        "class": "promotion-list",
									        "data-id": '4'
									     }},				
						'dogs' : {text: 'Add New Promotion', type: 'item',
									     "attr": {
									        "class": "promotion-add",
									        "data-id": '4'
									     }},
					}		
				}
				tree_data_4['tickets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Transaction List', type: 'item',
									     "attr": {
									        "class": "transaction-list",
									        "data-id": '4'
									     }},
						'dogs' : {text: 'Withdrawal List', type: 'item',
									     "attr": {
									        "class": "withdrawal-list",
									        "data-id": '4'
									     }},
					}
				}
				tree_data_4['reports']['additionalParameters'] = {			
					'children' : {				
						
						'dogs' : {text: 'Item Profit Report', type: 'item',
									     "attr": {
									        "class": "sales-report",
									        "data-id": '4'
									     }},
						'c' : {text: 'Order Report', type: 'item',
									     "attr": {
									        "class": "order-report",
									        "data-id": '4'
									     }},
						'd' : {text: 'Commission Report', type: 'item',
									     "attr": {
									        "class": "commission-report",
									        "data-id": '4'
									     }},
					}	
				}
				tree_data_4['services']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Affiliate List', type: 'item',
									     "attr": {
									        "class": "affiliate-list",
									        "data-id": '4'
									     }},
					}		
				}
				tree_data_4['personals']['additionalParameters'] = {
					'children' : {
						'agent-level' : {text: 'Agent Level', type: 'item',
									     "attr": {
									        "class": "agent-level",
									        "data-id": '4'
									     }},
						'cars' : {text: 'Bonus Setting', type: 'folder'},				
						'banners' : {text: 'Setting Banner', type: 'item',
									     "attr": {
									        "class": "setting-banner",
									        "data-id": '4'
									     }},				
						'motorcycles-1' : {text: 'Setting Shipping Fee', type: 'item',
									     "attr": {
									        "class": "shipping-fee",
									        "data-id": '4'
									     }},
						'motorcycles' : {text: 'Setting UOM', type: 'item',
									     "attr": {
									        "class": "setting-uom",
									        "data-id": '4'
									     }},
						'product-topup' : {text: 'Product Topup Packages', type: 'item',
									     "attr": {
									        "class": "product-topup",
									        "data-id": '4'
									     }},
						'affiliate-topup' : {text: 'Affiliate Topup Packages', type: 'item',
									     "attr": {
									        "class": "affiliate-topup",
									        "data-id": '4'
									     }},
						'setting-charges' : {text: 'Setting Charges', type: 'item',
									     "attr": {
									        "class": "setting-charges",
									        "data-id": '4'
									     }},
						'set-pickup-address' : {text: 'Setting Pickup Address', type: 'item',
									     "attr": {
									        "class": "set-pickup-address",
									        "data-id": '4'
									     }},
					}		
				}
				tree_data_4['personals']['additionalParameters']['children']['cars']['additionalParameters'] = {			
					'children' : {				
						'classics' : {text: 'Agent Order Rebate', type: 'item',
									     "attr": {
									        "class": "agent-order-rebate",
									        "data-id": '4'
									     }},		
					}		
				}

				var tree_data_5 = {
					'dashboard' : {text: 'Dashboard', 
								 type: 'item',
								 "attr": {
									        "class": "dashboard",
									        "data-id": '5'
									     }
								},
					'profile' : {text: 'Profile', 
								 type: 'item',
								 "attr": {
									        "class": "profile",
									        "data-id": '5'
									     }
								},
					'permission' : {text: 'Permission Control', 
								 type: 'item',
								 "attr": {
									        "class": "permission-control",
									        "data-id": '5'
									     }
								},
					'for-sale' : {text: 'Agent Manage', type: 'folder'},
					'members' : {text: 'Member Manage', type: 'folder'},
					'vehicles' : {text: 'Product Manage', type: 'folder'},
					
					'rentals' : {text: 'Category Manage', type: 'folder'},
					'sub_category' : {text: 'Sub Category Manage', type: 'folder'},
					'real-estate' : {text: 'Brand Manage', type: 'folder'},
					'banks' : {text: 'Bank Manage', type: 'folder'},
					'pets' : {text: 'Promotion Manage', type: 'folder'},
					'tickets' : {text: 'Transaction Manage', type: 'folder'},
					'reports' : {text: 'Report Manage', type: 'folder'},
					'services' : {text: 'Affiliate Manage', type: 'folder'},			
					'personals' : {text: 'Setting Manage', type: 'folder'}		
				}		
				tree_data_5['for-sale']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Agent List', 
										type: 'item',
										"attr": {
									        "class": "agent-list",
									        "data-id": '5'
									    }
									   },
						'arts-crafts' : {text: 'Add New Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-add",
									        "data-id": '5'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Agent', 
									     type: 'item',
									     "attr": {
									        "class": "agent-pending",
									        "data-id": '5'
									     }
									    },
					}
				}			

				tree_data_5['members']['additionalParameters'] = {			
					'children' : {				
						'appliances' : {
										text: 'Member List', 
										type: 'item',
										"attr": {
									        "class": "member-list",
									        "data-id": '5'
									    }
									   },
						'arts-crafts' : {text: 'Add New Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-add",
									        "data-id": '5'
									     }
									    },
						'arts-crafts1' : {text: 'Pending Member', 
									     type: 'item',
									     "attr": {
									        "class": "member-pending",
									        "data-id": '5'
									     }
									    },
					}
				}		
				tree_data_5['vehicles']['additionalParameters'] = {			
					'children' : {
						'motorcycles' : {
										 text: 'Product List', 
										 type: 'item',
									     "attr": {
									        "class": "product-list",
									        "data-id": '5'
									     }
										},				
						'boats' : {text: 'Add New Product', type: 'item',
									     "attr": {
									        "class": "product-add",
									        "data-id": '5'
									     }
								  },
						'sdffgh' : {
									text: 'Packages List', type: 'item',
									     "attr": {
									        "class": "product-packages",
									        "data-id": '5'
									     }
								  },
						'zxcvbn' : {
									text: 'Add New Packages', type: 'item',
									     "attr": {
									        "class": "product-packages-add",
									        "data-id": '5'
									     }
								  }
					}		
				}
				tree_data_5['rentals']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Category List', type: 'item',
									     "attr": {
									        "class": "category-list",
									        "data-id": '5'
									     }},				
						'vacation-rentals' : {text: 'Add New Category', type: 'item',
									     "attr": {
									        "class": "category-add",
									        "data-id": '5'
									     }}			
					}		
				}	
				tree_data_5['sub_category']['additionalParameters'] = {			
					'children' : {
						'office-space-rentals' : {text: 'Sub Category List', type: 'item',
									     "attr": {
									        "class": "sub-category-list",
									        "data-id": '5'
									     }},				
						'vacation-rentals' : {text: 'Add New Sub Category', type: 'item',
									     "attr": {
									        "class": "sub-category-add",
									        "data-id": '5'
									     }}			
					}		
				}		
				tree_data_5['real-estate']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Brand List', type: 'item',
									     "attr": {
									        "class": "brand-list",
									        "data-id": '5'
									     }},
						'plots' : {text: 'Add New Brand', type: 'item',
									     "attr": {
									        "class": "brand-add",
									        "data-id": '5'
									     }}			
					}		
				}		
				tree_data_5['banks']['additionalParameters'] = {			
					'children' : {				
						'apartments' : {text: 'Bank List', type: 'item',
									     "attr": {
									        "class": "bank-list",
									        "data-id": '5'
									     }},
						'plots' : {text: 'Add New Bank', type: 'item',
									     "attr": {
									        "class": "bank-add",
									        "data-id": '5'
									     }}			
					}		
				}		
				tree_data_5['pets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Promotion List', type: 'item',
									     "attr": {
									        "class": "promotion-list",
									        "data-id": '5'
									     }},				
						'dogs' : {text: 'Add New Promotion', type: 'item',
									     "attr": {
									        "class": "promotion-add",
									        "data-id": '5'
									     }},
					}		
				}
				tree_data_5['tickets']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Transaction List', type: 'item',
									     "attr": {
									        "class": "transaction-list",
									        "data-id": '5'
									     }},
						'dogs' : {text: 'Withdrawal List', type: 'item',
									     "attr": {
									        "class": "withdrawal-list",
									        "data-id": '5'
									     }},
					}
				}
				tree_data_5['reports']['additionalParameters'] = {			
					'children' : {				
						
						'dogs' : {text: 'Item Profit Report', type: 'item',
									     "attr": {
									        "class": "sales-report",
									        "data-id": '5'
									     }},
						'c' : {text: 'Order Report', type: 'item',
									     "attr": {
									        "class": "order-report",
									        "data-id": '5'
									     }},
						'd' : {text: 'Commission Report', type: 'item',
									     "attr": {
									        "class": "commission-report",
									        "data-id": '5'
									     }},
					}	
				}
				tree_data_5['services']['additionalParameters'] = {			
					'children' : {				
						'cats' : {text: 'Affiliate List', type: 'item',
									     "attr": {
									        "class": "affiliate-list",
									        "data-id": '5'
									     }},
					}		
				}
				tree_data_5['personals']['additionalParameters'] = {
					'children' : {
						'agent-level' : {text: 'Agent Level', type: 'item',
									     "attr": {
									        "class": "agent-level",
									        "data-id": '5'
									     }},
						'cars' : {text: 'Bonus Setting', type: 'folder'},				
						'banners' : {text: 'Setting Banner', type: 'item',
									     "attr": {
									        "class": "setting-banner",
									        "data-id": '5'
									     }},				
						'motorcycles-1' : {text: 'Setting Shipping Fee', type: 'item',
									     "attr": {
									        "class": "shipping-fee",
									        "data-id": '5'
									     }},
						'motorcycles' : {text: 'Setting UOM', type: 'item',
									     "attr": {
									        "class": "setting-uom",
									        "data-id": '5'
									     }},
						'product-topup' : {text: 'Product Topup Packages', type: 'item',
									     "attr": {
									        "class": "product-topup",
									        "data-id": '5'
									     }},
						'affiliate-topup' : {text: 'Affiliate Topup Packages', type: 'item',
									     "attr": {
									        "class": "affiliate-topup",
									        "data-id": '5'
									     }},
						'setting-charges' : {text: 'Setting Charges', type: 'item',
									     "attr": {
									        "class": "setting-charges",
									        "data-id": '5'
									     }},
						'set-pickup-address' : {text: 'Setting Pickup Address', type: 'item',
									     "attr": {
									        "class": "set-pickup-address",
									        "data-id": '5'
									     }},
					}		
				}
				tree_data_5['personals']['additionalParameters']['children']['cars']['additionalParameters'] = {			
					'children' : {				
						'classics' : {text: 'Agent Order Rebate', type: 'item',
									     "attr": {
									        "class": "agent-order-rebate",
									        "data-id": '5'
									     }},
					}		
				}
				var dataSource1 = function(options, callback){			
					var $data = null

					if(!("text" in options) && !("type" in options)){				
						$data = tree_data;
						callback({ data: $data });				
						return;			
						}else if("type" in options && options.type == "folder") {				
							if("additionalParameters" in options && "children" in options.additionalParameters)	$data = options.additionalParameters.children || {}; else $data = {}
						}						
						if($data != null)
							setTimeout(function(){callback({ data: $data });} , 
							parseInt(Math.random() * 500) + 200);
				}

				var dataSource2 = function(options, callback){			
					var $data = null			
					if(!("text" in options) && !("type" in options)){				
						$data = tree_data_2;
						callback({ data: $data });				
						return;			
					}			
					else if("type" in options && options.type == "folder") {				
						if("additionalParameters" in options && "children" in options.additionalParameters)	$data = options.additionalParameters.children || {};			
						else $data = {}			
					}						
					if($data != null)
						setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);
				}

				var dataSource3 = function(options, callback){			
					var $data = null			
					if(!("text" in options) && !("type" in options)){				
						$data = tree_data_3;
						callback({ data: $data });				
						return;			
					}			
					else if("type" in options && options.type == "folder") {				
						if("additionalParameters" in options && "children" in options.additionalParameters)	$data = options.additionalParameters.children || {};			
						else $data = {}			
					}						
					if($data != null)
						setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);
				}

				var dataSource4 = function(options, callback){			
					var $data = null			
					if(!("text" in options) && !("type" in options)){				
						$data = tree_data_4;
						callback({ data: $data });				
						return;			
					}			
					else if("type" in options && options.type == "folder") {				
						if("additionalParameters" in options && "children" in options.additionalParameters)	$data = options.additionalParameters.children || {};			
						else $data = {}			
					}						
					if($data != null)
						setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);
				}

				var dataSource5 = function(options, callback){			
					var $data = null			
					if(!("text" in options) && !("type" in options)){				
						$data = tree_data_5;
						callback({ data: $data });				
						return;			
					}			
					else if("type" in options && options.type == "folder") {				
						if("additionalParameters" in options && "children" in options.additionalParameters)	$data = options.additionalParameters.children || {};			
						else $data = {}			
					}						
					if($data != null)
						setTimeout(function(){callback({ data: $data });} , parseInt(Math.random() * 500) + 200);
				}
				return {'dataSource1': dataSource1, 'dataSource2': dataSource2, 'dataSource3': dataSource3, 'dataSource4': dataSource4, 'dataSource5': dataSource5}	

			}});


		$(document).ready( function(){
			$('#tree1').on('disclosedAll.fu.tree', function (event, data) {
			  	
			  	$.ajax({
			       url: '{{ route("GetPermission") }}',
			       type: 'get',
			       success: function(response){
			       		$.each( response, function( key, value ) {
			       		  if(value['permission_lvl'] == '1' && value['status'] == 1){
						  	$('#tree1').tree('selectItem', $('#tree1 .'+value['page']));			       		  	
			       		  }
			       		  $('.'+value['page']).click( function(){
			       		  		$('.loading-gif').show();
			       		  		var title = $(this).attr('class');
			       		  		if(!$(this).hasClass('tree-selected')){
									var fd = new FormData();
										
										// alert($(this).attr('class'));
										fd.append('page', value['page']);
										fd.append('permission_lvl', $(this).data('id'));

									$.ajax({
								       url: '{{ route("SetPermission") }}',
								       type: 'post',
								       data: fd,
								       contentType: false,
								       processData: false,
								       success: function(response){
								       		
								       		$('.loading-gif').hide();
								       }
								    });
			       		  		}
			       		  });
						});
			       }
			   });
			})

			$('#tree2').on('disclosedAll.fu.tree', function (event, data) {
			  	
			  	$.ajax({
			       url: '{{ route("GetPermission") }}',
			       type: 'get',
			       success: function(response){
			       		$.each( response, function( key, value ) {
			       		  if(value['permission_lvl'] == '2' && value['status'] == 1){
						  	$('#tree2').tree('selectItem', $('#tree2 .'+value['page']));			       		  	
			       		  }
			       		  $('.'+value['page']).click( function(){
			       		  		$('.loading-gif').show();
			       		  		var title = $(this).attr('class');
			       		  		if(!$(this).hasClass('tree-selected')){
									var fd = new FormData();
										
										// alert($(this).attr('class'));
										fd.append('page', value['page']);
										fd.append('permission_lvl', $(this).data('id'));

									$.ajax({
								       url: '{{ route("SetPermission") }}',
								       type: 'post',
								       data: fd,
								       contentType: false,
								       processData: false,
								       success: function(response){
								       		
								       		$('.loading-gif').hide();
								       }
								    });
			       		  		}
			       		  });
						});
			       }
			   });
			})

			$('#tree3').on('disclosedAll.fu.tree', function (event, data) {
			  	
			  	$.ajax({
			       url: '{{ route("GetPermission") }}',
			       type: 'get',
			       success: function(response){
			       		$.each( response, function( key, value ) {
			       		  if(value['permission_lvl'] == '3' && value['status'] == 1){
						  	$('#tree3').tree('selectItem', $('#tree3 .'+value['page']));			       		  	
			       		  }
			       		  $('.'+value['page']).click( function(){
			       		  		$('.loading-gif').show();
			       		  		var title = $(this).attr('class');
			       		  		if(!$(this).hasClass('tree-selected')){
									var fd = new FormData();
										
										// alert($(this).attr('class'));
										fd.append('page', value['page']);
										fd.append('permission_lvl', $(this).data('id'));
										

									$.ajax({
								       url: '{{ route("SetPermission") }}',
								       type: 'post',
								       data: fd,
								       contentType: false,
								       processData: false,
								       success: function(response){
								       		
								       		$('.loading-gif').hide();
								       }
								    });
			       		  		}
			       		  });
						});
			       }
			   });
			})

			$('#tree4').on('disclosedAll.fu.tree', function (event, data) {
			  	
			  	$.ajax({
			       url: '{{ route("GetPermission") }}',
			       type: 'get',
			       success: function(response){
			       		$.each( response, function( key, value ) {
			       		  if(value['permission_lvl'] == '4' && value['status'] == 1){
						  	$('#tree4').tree('selectItem', $('#tree4 .'+value['page']));			       		  	
			       		  }
			       		  $('.'+value['page']).click( function(){
			       		  		$('.loading-gif').show();
			       		  		var title = $(this).attr('class');
			       		  		if(!$(this).hasClass('tree-selected')){
									var fd = new FormData();
										
										// alert($(this).attr('class'));
										fd.append('page', value['page']);
										fd.append('permission_lvl', $(this).data('id'));
										

									$.ajax({
								       url: '{{ route("SetPermission") }}',
								       type: 'post',
								       data: fd,
								       contentType: false,
								       processData: false,
								       success: function(response){
								       		
								       		$('.loading-gif').hide();
								       }
								    });
			       		  		}
			       		  });
						});
			       }
			   });
			})

			$('#tree5').on('disclosedAll.fu.tree', function (event, data) {
			  	
			  	$.ajax({
			       url: '{{ route("GetPermission") }}',
			       type: 'get',
			       success: function(response){
			       		$.each( response, function( key, value ) {
			       		  if(value['permission_lvl'] == '5' && value['status'] == 1){
						  	$('#tree5').tree('selectItem', $('#tree5 .'+value['page']));			       		  	
			       		  }
			       		  $('.'+value['page']).click( function(){
			       		  		$('.loading-gif').show();
			       		  		var title = $(this).attr('class');
			       		  		if(!$(this).hasClass('tree-selected')){
									var fd = new FormData();
										
										// alert($(this).attr('class'));
										fd.append('page', value['page']);
										fd.append('permission_lvl', $(this).data('id'));
										

									$.ajax({
								       url: '{{ route("SetPermission") }}',
								       type: 'post',
								       data: fd,
								       contentType: false,
								       processData: false,
								       success: function(response){
								       		
								       		$('.loading-gif').hide();
								       }
								    });
			       		  		}
			       		  });
						});
			       }
			   });
			})
		});
		</script>
@endsection
