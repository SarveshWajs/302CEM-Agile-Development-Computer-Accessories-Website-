@extends('layouts.app')

@section('content')


<div class="container">
    <!-- <div class="row animate-box">
        <div class="col-md-8 col-md-offset-2 text-center fh5co-heading">
            <span>Products</span>
            <h2>{{ $product->product_name }}</h2>
        </div>
    </div> -->

    <nav aria-label="breadcrumb">
	  	<ol class="breadcrumb">
	    	<li class="breadcrumb-item">
	    		<a href="home">
	    			Home
	    		</a>
	    	</li>
	    	
	    	<li class="breadcrumb-item active" aria-current="page">
	    		{{ $diets->product_name }}
	    	</li>
	  	</ol>
	</nav>

</div>

<div class="shop mt-5">
	<div class="container details-page">
		<div class="row">
			<div class="col-md-12">
				<div class="">
					<div class="row">
						<div class="col-md-7">
							<div class="form-group">
								@php
									if(!empty($Pimage->image))
										$Fimage = file_exists($Pimage->image) ? url($Pimage->image) : url('images/no-image-available-icon-6.jpg');
									else
										$Fimage = url('images/no-image-available-icon-6.jpg');
									

									$exp_one = explode(".", $Fimage);
        							$file_ext_one = end($exp_one);
								@endphp
								<div class="" href="{{ url($Fimage) }}" style="width: 100%; height: auto !important;">
									<div id="show-img">
									    @if($file_ext_one == 'mp4')
											<video style="width: 100%;" autoplay="autoplay" loop="1" controls controlsList="nodownload">
					                            <source src="{{ url($Fimage) }}" type="video/mp4">
					                        </video>
										@else
									    	<!-- <img src="{{ url($Fimage) }}" alt="{{ $product->product_name }}"> -->
									    	<div class="details-img" style="background-image: url({{ url($Fimage) }});">
									    	</div>
									    	<!-- <img src="{{ url($Fimage) }}"> -->
										@endif
									</div>
								</div>
								<div class="small-img">
							    	<img src="{{ asset('frontend/thumbnail-zoom/images/online_icon_right@2x.png') }}" class="icon-left" alt="" id="prev-img">
							    	<div class="small-container">
							      		<div id="small-img-roll" class="small-img-roll">
							      		@if(!$images->isEmpty())
											@foreach($images as $key => $image)
											@php
												$image = file_exists($image->image) ? url($image->image) : url('images/no-image-available-icon-6.jpg');
												$exp_two = explode(".", $image);
        										$file_ext_two = end($exp_two);
											@endphp
											@if($file_ext_two == 'mp4')
												<video style="width: 70px;" loop="1" class="show-small-img" src="{{ url($image) }}">
					                            	<source src="{{ url($image) }}" type="video/mp4">
					                        	</video>
											@else
								        		<img src="{{ $image }}" class="show-small-img" alt="" width="100%;">
											@endif
							        		@endforeach
										@else
											<img src="{{ url('images/no-image-available-icon-6.jpg') }}" class="show-small-img" alt="" width="100%;">
										@endif
							      		</div>
							    	</div>
							    	<img src="{{ asset('frontend/thumbnail-zoom/images/online_icon_right@2x.png') }}" class="icon-right" alt="" id="next-img" width="100%;">
							  	</div>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<div class="row">
									<div class="col-9">
										<div class="" style="/*overflow: hidden; text-overflow: ellipsis; white-space: nowrap;*/ width: 100%;">
											<b class="product-detail-name">
												{{ $product->product_name }}
											</b>
											<br>
											
											
											
										</div>
										<div class="form-group product-description">
										
										{!! htmlspecialchars_decode($product->description) !!}
			                            </div>
									</div>
									
								</div>
								
							</div>

							
							@if($product->variation_enable == '1')
								@if(!$variations->isEmpty())
								<b style="font-size: 18px;">Option: </b><br>
								<div class="form-group">
									@foreach($variations as $variationsKey => $variation)
											<div class="variation_option 
														{{ ($variationsKey == 0) ? 'active' : '' }}
														{{ ($vStock[$variation->id] <= 0) ? 'out-of-stock' : '' }}" 
												 data-id="{{ $variation->id }}">
												{{ $variation->variation_name }}
											</div> 
									@endforeach
								</div>
								@endif
							@endif


							<!--@if(!empty($product->faq) && isset($product->faq))
								<div class="form-group">
								FAQ:
								{!! htmlspecialchars_decode ($product->faq) !!}
								</div>
							@endif

							@if(!empty($product->efficacy) && isset($product->efficacy))
								<div class="form-group">
								Product Efficacy:
								{!! htmlspecialchars_decode ($product->efficacy) !!}
								</div>
							@endif

							@if(!empty($product->inspection_report) && isset($product->inspection_report))
								<div class="form-group">
								Inspection Report:
								{!! htmlspecialchars_decode ($product->inspection_report) !!}
								</div>
							@endif-->

							
							
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group">
			@if(!$Ppackages->isEmpty())
			<hr>
			<h3 class="gold-word">
			Whats in the box: </h3>
			<br>
			<div class="form-group" style="overflow: auto;">
				<table class="table table-bordered table-free-gift">
					<tr style="background-color: #ad39a7;">
						<td>Product Description</td>
						<td>Unit Price</td>
						<td>Quantity</td>
						<td>Total Price</td>
					</tr>
					@php
					$totalPrice = 0;
					@endphp
					@foreach($Ppackages as $Ppackage)
					<tr style="color: white;">
						<td>
							<p>
								<img src="{{ url($Ppackage->image) }}" style="width: 90px;">
								{{ $Ppackage->product_name }}
							</p>
						</td>
						<td>
							<p>{{ number_format($Ppackage->unit_price, 2) }}</p>
						</td>
						<td>
							<p>{{ $Ppackage->qty }}</p>
						</td>
						<td>
							<p>{{ number_format($Ppackage->unit_price * $Ppackage->qty, 2) }}</p>
						</td>
					</tr>

					@php
					$totalPrice += $Ppackage->unit_price * $Ppackage->qty;
					@endphp
					@endforeach
					<tr>
						<td colspan="3" align="right">Subtotal</td>
						<td>
							<p>{{ number_format($totalPrice, 2) }}</p>
						</td>
					</tr>
					@if(!empty($product->free_gift))
					<tr style="color: white;">
						<td colspan="4">
							<h4><b>Free Gift:</b></h4>
							<br>
							{!! $product->free_gift !!}
						</td>
					</tr>
					@endif
				</table>
			</div>
			@endif
		</div>
	</div><section class="jss11"><p class="MuiTypography-root MuiTypography-h2 MuiTypography-paragraph MuiTypography-alignCenter">Activity Needed to Burn:</p><p class="MuiTypography-root MuiTypography-h1 MuiTypography-colorTextPrimary MuiTypography-paragraph MuiTypography-alignCenter">{!! htmlspecialchars_decode($product->short_description) !!}<!-- -->&nbsp;<!-- -->calories</p><div class="jss113"><div class="jss115 jss110"><img src="https://www.myfitnesspal.com/react-static/bff79fcc13f01ae3f07daaac6f846f48.svg"><span class="MuiTypography-root jss69 jss116 MuiTypography-colorTextPrimary">1.6</span><span class="MuiTypography-root jss75 jss117 MuiTypography-colorTextSecondary">Hours<!-- --> of <!-- -->Cycling</span></div> <div class="jss115 jss110"><img src="https://www.myfitnesspal.com/react-static/0a76177801896575ee652edc1f3e7f42.svg"><span class="MuiTypography-root jss69 jss116 MuiTypography-colorTextPrimary">1.1</span><span class="MuiTypography-root jss75 jss117 MuiTypography-colorTextSecondary">Hours<!-- --> of <!-- -->Running</span></div> <div class="jss115 jss110"><img src="https://www.myfitnesspal.com/react-static/bd243ced3936ce6f96242571d496b87c.svg"><span class="MuiTypography-root jss69 jss116 MuiTypography-colorTextPrimary">4</span><span class="MuiTypography-root jss75 jss117 MuiTypography-colorTextSecondary">Hours<!-- --> of <!-- -->Cleaning</span></div></div></section>
<br>
</div>
@endsection

@section('js')
<script type="text/javascript">

  
  var variation_enable = '{{ $product->variation_enable }}';

  $('.add-to-cart-button').click( function(e){
  	// alert('123');
  	e.preventDefault();
	

  	$('.loading-gif').show();
  	var mall = '{{ $product->mall }}';
  	var isAdmin = '{{ Auth::guard("admin")->check() }}';
  	var isMerchant = '{{ Auth::guard("merchant")->check() }}';
  	var isUser = '{{ Auth::guard("web")->check() }}';
  	var isGuest = "{{ !empty($_COOKIE['new_guest']) ? $_COOKIE['new_guest'] : $data['new_guest'] }}";
  	var option = $('.variation_option.active').data('id');

  	if(variation_enable == 1 && !option){
  		alert('Please select product variation first');
  		$('.loading-gif').hide();
  		return false;
  	}

  	if(isAdmin){
  		auth_check = '{{ !empty(Auth::guard("admin")->user()->code) ? Auth::guard("admin")->user()->code : '' }}';
  	}else if(isMerchant){
  		auth_check = '{{ !empty(Auth::guard("merchant")->user()->code) ? Auth::guard("merchant")->user()->code : '' }}';
  	}else if(isUser){
  		auth_check = '{{ !empty(Auth::guard("web")->user()->code) ? Auth::guard("web")->user()->code : '' }}';
  	}else if(isGuest){
  		auth_check = isGuest;
  	}else{
  		auth_check = "";
  	}
  	
  	if(auth_check){
	  	var fd = new FormData();
	  	fd.append('product_id', '{{ $product->id }}');
	  	fd.append('quantity', $('input[name="quantity"]').val());
	  	fd.append('sub_category_id', option);
	  	fd.append('second_sub_category_id', $('.second_sub_category_id').val());
	  	


	  	$.ajax({
	        url: '{{ route("AddToCart") }}',
	        type: 'post',
	        data: fd,
	        contentType: false,
	        processData: false,
	        success: function(response){
	        	// alert(response);
	        	// return false;
	        	$('.loading-gif').hide();

	        	if(response == 'wallet not enough balance'){
	        		toastr.error('Wallet Balance Not Enough');
	        		return false;
	        	}

	        	if(response == 'quantity error'){
	        		toastr.error('Please Add Quantity At least 1');
	        		return false;
	        	}

	        	if(response == 'quantity exceed error'){
	        		toastr.error('Product Balance Quantity Not Enough');
	        		return false;
	        	}

	        	// if(response == 'quantity personal exceed'){
	        	// 	toastr.error('The maximum quantity available for this item is '+'{{ $stockBalance }}');
	        	// 	return false;
	        	// }

	        	if(response == 'ok'){
	        		$.ajax({
				        url: '{{ route("CountCart") }}',
				        type: 'get',
				        success: function(response){
				        	$('.count-cart').html(response[0]);
				        	// $('.cart_price').html('RM '+parseFloat(response[1]).toFixed(2));
				        	
				        }
				    });
				    if(mall == 1){
				    	toastr.success('Items Add To Cart. <a href="{{ route("checkout", "m=1") }}" class="view-cart-button pull-right"><i class="fa fa-shopping-cart"></i> View Cart</a>');
				    }else{
	            		toastr.success('Items Add To Cart. <a href="{{ route("checkout") }}" class="view-cart-button pull-right"><i class="fa fa-shopping-cart"></i> View Cart</a>');
				    }
	            }else{
	            	toastr.error('Error Please Contact Admin');
	            }
	        },
	    });
  	}else{
  		window.location.href = "{{ route('login') }}";
  	}
  });

  $('.add-favourite-btn').click( function(e){
  		e.preventDefault();
  		$('.loading-gif').show();
  		var ele = $(this);
	  	var isAdmin = '{{ Auth::guard("admin")->check() }}';
	  	var isMerchant = '{{ Auth::guard("merchant")->check() }}';
	  	var isUser = '{{ Auth::check() }}';

	  	if(isAdmin){
	  		auth_check = isAdmin;
	  	}else if(isMerchant){
	  		auth_check = isMerchant;
	  	}else if(isUser){
	  		auth_check = isUser;
	  	}else{
	  		auth_check = "";
	  	}
	  	
	  	if(auth_check){
	  		var fd = new FormData();
		  	fd.append('product_id', '{{ $product->id }}');

		  	$.ajax({
		        url: '{{ route("Favourite") }}',
		        type: 'post',
		        data: fd,
		        contentType: false,
		        processData: false,
		        success: function(response){
		        	$('.wishlist_count').html(response);
		        	$('.loading-gif').hide();
		        	if(response == 1){
		        		ele.html('<i class="fa fa-heart fa-2x" aria-hidden="true"></i>')
		        	}else{
		        		ele.html('<i class="fa fa-heart-o fa-2x" aria-hidden="true"></i>')
		        	}
		        }
		    });
	  	}else{
	  		window.location.href = "{{ route('login') }}";
	  	}
  });

  $('.add-to-wish-btn').click( function(e){
  		e.preventDefault();
  		$('.loading-gif').show();
  		var ele = $(this);
	  	var isAdmin = '{{ Auth::guard("admin")->check() }}';
	  	var isMerchant = '{{ Auth::guard("merchant")->check() }}';
	  	var isUser = '{{ Auth::check() }}';

	  	if(isAdmin){
	  		auth_check = isAdmin;
	  	}else if(isMerchant){
	  		auth_check = isMerchant;
	  	}else if(isUser){
	  		auth_check = isUser;
	  	}else{
	  		auth_check = "";
	  	}
	  	
	  	if(auth_check){
	  		var fd = new FormData();
		  	fd.append('product_id', '{{ $product->id }}');

		  	$.ajax({
		        url: '{{ route("add_to_wish") }}',
		        type: 'post',
		        data: fd,
		        contentType: false,
		        processData: false,
		        success: function(response){
		        	$('.loading-gif').hide();
		        	if(response == 1){
		        		$('.wishlist_count').html(response);
		        		$('.add-favourite-btn').html('<i class="fa fa-heart fa-2x" aria-hidden="true"></i>')
		        	}else{
		        		toastr.info('Already In Wishlist');
		        	}
		        }
		    });
	  	}else{
	  		window.location.href = "{{ route('login') }}";
	  	}
  });

  $('.sub-category-list').click( function(){
  	  var ele = $(this);
  	  $('.sub-category-list').removeClass('active');
  	  $(this).addClass('active');
  	  ele.parent().find('input[name="sub_category_id"]').prop("checked", true);
  });

  $('.add-qty-button').click( function(e){

		e.preventDefault();
		
		var ele = $(this);
		var quantity = ele.parent().find('input[name="quantity"]').val();
		var balance = ele.closest('ul').find('input[name="balance_quantity"]').val();
		quantity = Number(quantity) + 1;
		if(quantity > balance){
			alert('The maximum quantity available for this item is '+balance);
			$('.loading-gif').hide();
			return false;
		}else{
			ele.parent().find('input[name="quantity"]').val(quantity);			
		}
		
	});

	$('.deduct-qty-button').click( function(e){
		e.preventDefault();
		
		var ele = $(this);
		var quantity = ele.parent().find('input[name="quantity"]').val();
		if(quantity != 1){
			quantity = Number(quantity) - 1;
			ele.parent().find('input[name="quantity"]').val(quantity);
		}		
	});

	
	if(variation_enable == 1){
		$('.variation_option').click( function(e){
			e.preventDefault();

			$('.loading-gif').show();
			var ele = $(this);
			var vid = ele.data('id');

			$('.variation_option').removeClass('active');
			ele.addClass('active');

			var fd = new FormData();
			  	fd.append('vid', vid);

			$.ajax({
		        url: '{{ route("getVariation") }}',
		        type: 'post',
		        data: fd,
		        contentType: false,
		        processData: false,
		        success: function(response){
		        	$('.loading-gif').hide();
		        	if(response[0] != 0){
			        	$('.main-price').html('RM '+response[0]);
						$('.has-special-price').html('RM '+response[1]);
		        	}else{
		        		$('.main-price').html('RM '+response[1]);
						$('.has-special-price').hide();
		        	}

		        	if(response[2] <= 0){
		        		$('.quantity-balance').html('Out of stock');
		        	}else{
		        		$('.quantity-balance').html('Only '+ response[2] +' Items Left');
		        	}
		        }
		    });
		});

		$.ajaxSetup({
	          headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	    });
		$('.variation_option.active').trigger('click');		
	}
	
</script>
@endsection