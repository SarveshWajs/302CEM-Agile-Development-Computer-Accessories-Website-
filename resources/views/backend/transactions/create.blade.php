@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Add New Transaction
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
<form method="POST" action="{{ route('transaction.transactions.store') }}" id="transaction-form" enctype="multipart/form-data">
	@csrf
	<div class="row">
		<div class="col-xs-12">
			@if($errors->any())
			  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
			@endif
			<div class="form-group">
				<label>Agent</label>
				<select class="form-control select2" name="merchants">
					<option value="">Select Merchant</option>
					@foreach($merchants as $merchant)
					<option value="{{ $merchant->code }}">
						{{ $merchant->f_name }} {{ $merchant->l_name }} ({{ $merchant->code }}) | 
						Product Wallet Balance: {{ $GetProductWalletBalance[$merchant->code] }}
					</option>
					@endforeach
				</select>
			</div>

			<div class="form-group big-parent">
				<label>Items</label>
				<div class="child-div">
					<div class="form-group child-row">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<select class="form-control products select2" name="product_id[]">
										<option value="">Select Product</option>
										@foreach($products as $product)
										<option value="{{ $product->id }}">
											{{ $product->product_name }} | 
											Price: RM {{ !empty($product->agent_special_price) ? number_format($product->agent_special_price, 2) : number_format($product->agent_price, 2) }}
										</option>
										@endforeach
									</select>
								</div>
								<div class="product_variation">
								</div>
								<div class="stockBalance">
								</div>
								<input type="hidden" class="price" name="price[]">
							</div>
							<div class="col-md-6">
								<input type="text" name="quantity[]" value="" class="form-control quantity" placeholder="Quantity">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-12" align="center">
							<button class="add-row-btn">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" class="grandTotal" name="grandTotal">
</form>
<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<span style="font-size: 20px;">
			Price: RM <span class="totalPrice">0.00</span>			

		</span>
		&nbsp;&nbsp;&nbsp;
		<button class="btn btn-primary">
			<i class="fa fa-check"> SAVE CHANGES</i>
		</button>

	</div>
</div>
@endsection

@section('js')
<script type="text/javascript">
	$('.select2').select2();

	$('.add-row-btn').click(function(e){
		e.preventDefault();

		var ele = $(this);

		var add_new_row = '<div class="form-group child-row">\
								<div class="row">\
									<div class="col-md-6">\
										<div class="form-group">\
											<select class="form-control products select2" name="product_id[]">\
												<option value="">Select Product</option>\
												@foreach($products as $product)\
												<option value="{{ $product->id }}">\
													{{ $product->product_name }} | \
													Price: RM {{ !empty($product->agent_special_price) ? number_format($product->agent_special_price, 2) : number_format($product->agent_price, 2) }}\
												</option>\
												@endforeach\
											</select>\
										</div>\
										<div class="product_variation">\
										</div>\
										<div class="stockBalance">\
										</div>\
										<input type="hidden" class="price" name="price[]">\
									</div>\
									<div class="col-md-6">\
										<input type="text" name="quantity[]" value="" class="form-control quantity" placeholder="Quantity">\
									</div>\
								</div>\
							</div>';

		ele.closest('.big-parent').find('.child-div').append(add_new_row);
		$('.big-parent .select2').select2();
	});

	$('.big-parent').on('change', '.products', function(){

		var ele = $(this);
		var numItems = $('.big-parent .products').length;
		var pid = ele.val();
		var fd = new FormData();
	  		fd.append('num', numItems);
	  		fd.append('pid', pid);

		$.ajax({
	        url: '{{ route("getTransactionVariation") }}',
	        type: 'post',
	        data: fd,
	        contentType: false,
	        processData: false,
	        success: function(response){
	        	if(response[0] == '2'){
	        		ele.closest('.child-row').find('.stockBalance').html('Balance left: '+response[1]);
	        		ele.closest('.child-row').find('.price').val(response[2]);

	        		calc();
	        	}else{
	        		ele.closest('.child-row').find('.product_variation').html(response[1]);
	        	}
	        },
	    });
	});

	$('.big-parent').on('change', '.product_variation_option', function(){
		var ele = $(this);
		
		var vid = ele.val();
		var fd = new FormData();
	  		fd.append('vid', vid);

		$.ajax({
	        url: '{{ route("getVariationStock") }}',
	        type: 'post',
	        data: fd,
	        contentType: false,
	        processData: false,
	        success: function(response){
	        	ele.closest('.child-row').find('.stockBalance').html('Balance left: '+response);	        	
	        },
	    });
	});

	$('.big-parent').on('keyup', '.quantity', function(){
		calc();
	});

	$('.submit-form-btn .btn-primary').click( function(e){
    	e.preventDefault();

    	$('#transaction-form').submit();
    });

    function calc(){
    	var totalPrice = 0;
    	$('.big-parent').find('.price').each(function () {

	        var price = $(this).val();
	        var qty = $(this).closest('.child-row').find('.quantity').val();
	        totalPrice += Number(price) * Number(qty);   	
	    });
    	
    	$('.totalPrice').html(Number(totalPrice).toFixed(2));
    	$('.grandTotal').val(totalPrice);
    	return totalPrice;
    }
</script>
@endsection