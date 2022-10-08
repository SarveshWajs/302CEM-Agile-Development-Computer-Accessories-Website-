@extends('layouts.app')
<style>
body {
  font-family: Arial;
}

.coupon {
  border: 5px dotted #bbb;
  width: 80%;
  border-radius: 15px;
  margin: 0 auto;
  max-width: 350px;
}



.promo {
  background: #ccc;
  padding: 3px;
}

.expire {
  color: red;
}
</style>
@section('content')
<section class="bg-light">
    <div class="container">
        <div class="row px-4 px-lg-5 py-lg-4 align-items-center">
            <div class="col-lg-6">
                <h1 class="h2 text-uppercase mb-0">Products</h1>
            </div>
            <div class="col-lg-6 text-lg-right">
                <nav aria-label="breadcrumb">
                   <ol class="breadcrumb justify-content-lg-end mb-0 px-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Products
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>


<div class="container">
    <section class="py-5">
        <div class="container p-0">
            <div class="row">
              <!-- SHOP SIDEBAR-->
              <div class="col-lg-3 mb-3">
                <div class="container-box">
                    <h5 class="text-uppercase mb-4">Categories</h5>
                    <ul class="list-unstyled text-muted font-weight-normal">
                        @foreach($categories as $category)
                        <li class="mb-2">
                            @if(count($sub_categories[$category->id]) > 0)
                                <a href="#" class="main_category reset-anchor" data-filter="{{ $category->category_name }}">
                                    <div class="row">
                                        <div class="col-6">
                                            {{ $category->category_name }}
                                        </div>
                                        <div class="col-6" align="right">
                                            @if(count($sub_categories[$category->id]) > 0) 
                                            <span class="fa fa-chevron-right arrow-right"></span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                @else
                                <a href="{{ route('listing', ['category='.urlencode($category->category_name),
                                                              'brand='.request('brand'),
                                                              'from='.request('from'),
                                                              'to='.request('to'),
                                                              'result='.request('result')]) }}">
                                    <div class="row">
                                        <div class="col-6">
                                            <span>{{ $category->category_name }}</span>
                                        </div>
                                        <div class="col-6" align="right">
                                            @if(count($sub_categories[$category->id]) > 0) 
                                            <span class="fa fa-chevron-right arrow-right"></span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                @endif
                                @if(count($sub_categories[$category->id]) > 0)
                                    @foreach($sub_categories[$category->id] as $sub_category)
                                    <div class="sub_categories">
                                        <a href="{{ route('listing', ['category='.urlencode($category->category_name),
                                                                      'subcategory='.urlencode($sub_category->sub_category_name)]) }}"
                                            data-id="0" class="{{ (!empty(request('subcategory')) && request('subcategory') == $sub_category->sub_category_name) ? 'active' : '' }}">
                                            <i class="fa fa-caret-right" aria-hidden="true"></i>
                                            {{ $sub_category->sub_category_name }}
                                        </a>
                                    </div>
                                    @endforeach
                                @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                <br>

                
<div class="coupon container p-0">
    @if(!$data['promotions']->isEmpty())
    @php
      $totalPromotion = count($data['promotions']);
      
    @endphp
    @foreach($data['promotions'] as $pkey => $promotion)
        @php
          $fullscreen = "";
          if($totalPromotion == $pkey+1){
            if($totalPromotion % 2 == 0){
              $fullscreen = "";
            }else{
              $fullscreen = "width: 100%";
            }
          }
        @endphp

  <div class="container">
    <h3>{{ $promotion->promotion_title }}</h3>
  </div>
  <img src="{{ url($promotion->image) }}" alt="Avatar" style="width:100%;">
  <div class="container" style="background-color:white">
    <h2><b>Offer: {{ ($promotion->amount_type == 'Percentage') ? $promotion->amount."%" : 'RM '.$promotion->amount }}</b></h2> 
  </div>
  <div class="container">
    <p>Use Promo Code: <span class="promo">{{ $promotion->discount_code }}</span></p>
    <p >Quantity:{{ $promotion->quantity }}</p>
    <p class="expire">Expires:{{$promotion->end_date }}</p>
    <div align="center">
    <button align="center"class="btn btn-primary claim-voucher" data-id="{{ $promotion->discount_code }}">
      Claim now
    </button>
</div>
  </div>
    
  @endforeach
</div>
@endif
   </div>

              <!-- SHOP LISTING-->
              <div class="col-lg-9 mb-5 mb-lg-0">
                <div class="row mb-3 align-items-center">
                  <div class="col-lg-6 mb-2 mb-lg-0">
                    <p class="text-small text-muted mb-0">
                        @if(!empty(request('page')))
                        Showing {{ count($products) * request('page') }} of {{ $count_p }} results
                        @else
                        Showing {{ count($products) }} of {{ $count_p }} results
                        @endif
                        <br>
                        @if(!empty(request('result')))
                            <span class="badge badge-danger p-2">
                                Name: {{ request('result') }} &nbsp;&nbsp;
                                <a href="{{ route('listing', ['category='.request('category'),
                                                              'brand='.request('brand'),
                                                              'from='.request('from'),
                                                              'to='.request('to')]) }}" style="color: white;">
                                    <i class="fa fa-times"></i>
                                </a>
                            </span>
                        @endif


                        @if(!empty(request('category')))
                            <span class="badge badge-danger p-2">
                                Category: {{ request('category') }}  &nbsp;&nbsp;
                                <a href="{{ route('listing', ['result='.request('result'),
                                                              'brand='.request('brand'),
                                                              'from='.request('from'),
                                                              'to='.request('to'),
                                                              'subcategory='.request('subcategory')]) }}" style="color: white;">
                                    <i class="fa fa-times"></i>
                                </a>
                            </span>
                        @endif

                        @if(!empty(request('subcategory')))
                            <span class="badge badge-danger p-2">
                                Subcategory: {{ request('subcategory') }}  &nbsp;&nbsp;
                                <a href="{{ route('listing', ['category='.request('category'),
                                                              'result='.request('result'),
                                                              'brand='.request('brand'),
                                                              'from='.request('from'),
                                                              'to='.request('to')]) }}" style="color: white;">
                                    <i class="fa fa-times"></i>
                                </a>
                            </span>
                        @endif

                        @if(!empty(request('brand')))
                            <span class="badge badge-danger p-2">
                                Brand: {{ request('brand') }}  &nbsp;&nbsp;
                                <a href="{{ route('listing', ['result='.request('result'),
                                                              'category='.request('category'),
                                                              'from='.request('from'),
                                                              'to='.request('to')]) }}" style="color: white;">
                                    <i class="fa fa-times"></i>
                                </a>
                            </span>
                        @endif

                        @if(!empty(request('from')) && !empty(request('to')))
                            <span class="badge badge-danger p-2">
                                Price: {{ request('from') }} - {{ request('to') }} &nbsp;&nbsp;
                                <a href="{{ route('listing', ['result='.request('result'),
                                                              'category='.request('category'),
                                                              'brand='.request('brand')]) }}" style="color: white;">
                                    <i class="fa fa-times"></i>
                                </a>
                            </span>
                        @endif
                    </p>
                  </div>
                </div>
                <div class="row">
                  <!-- PRODUCT-->
                    @foreach($products as $featured)
                    @php
                        $discount_percentage = 0;
                        $second_percentage = 0;
                        if(Auth::guard('merchant')->check() || Auth::guard('admin')->check()){
                            if($featured->variation_enable == '1'){
                                if($priceV[$featured->id][3] == $priceV[$featured->id][2]){
                                    if($priceV[$featured->id][4]){
                                        $discount_percentage = (($priceV[$featured->id][5] - $priceV[$featured->id][4])*100) / $priceV[$featured->id][5];
                                    }
                                }else{
                                    if($priceV[$featured->id][4]){
                                        $discount_percentage = (($priceV[$featured->id][7] - $priceV[$featured->id][6])*100) / $priceV[$featured->id][7];
                                    }
                                }
                            }else{
                                if(!empty($featured->agent_special_price)){
                                    $discount_percentage =  (($featured->agent_price - $featured->agent_special_price)*100) / $featured->agent_price;
                                }
                            }
                        }else{
                            if($featured->variation_enable == '1'){
                                if($priceV[$featured->id][1] == $priceV[$featured->id][0]){
                                    if($priceV[$featured->id][8]){
                                        $discount_percentage = (($priceV[$featured->id][9] - $priceV[$featured->id][8])*100) / $priceV[$featured->id][9];
                                    }
                                }else{
                                    if($priceV[$featured->id][8]){
                                        $discount_percentage = (($priceV[$featured->id][11] - $priceV[$featured->id][10])*100) / $priceV[$featured->id][10];
                                    }
                                }
                            }else{
                                if(!empty($featured->special_price)){
                                    $discount_percentage = (($featured->price - $featured->special_price)*100) / $featured->price;
                                }
                            }
                        }

                    @endphp
                    <div class="col-lg-3 col-6 mb-5">
                        <a href="{{ route('details', [str_replace('/', '-', $featured->product_name), md5($featured->id)]) }}">
                            <div class="product text-center">
                                <div class="mb-3 position-relative">
                                    <div class="badge text-white badge-"></div>
                                    <img class="img-fluid w-100" src="{{ (!empty($listingImages[$featured->id]->image)) ? url($listingImages[$featured->id]->image) : url('images/no-image-available-icon-61.jpg') }}" alt="...">
                                    <!-- <div style="background-image: url({{ (!empty($listingImages[$featured->id]->image)) ? url($listingImages[$featured->id]->image) : url('images/no-image-available-icon-61.jpg') }});
                                                background-repeat: no-repeat;
                                                background-size: cover;
                                                background-position: center;
                                                width: 100%;
                                                height: 200px;"></div> -->
                                </div>
                                <p style="color: black; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 100%;">
                                    {{ $featured->product_name }}
                                </p>
                                <div class="" style="text-align: left !important;">
                                    @if(Auth::guard('merchant')->check() || Auth::guard('admin')->check())
                                        @if($featured->variation_enable == '1')
                                            @if($priceV[$featured->id][3] == $priceV[$featured->id][2])
                                                <b class="item-price">
                                                    <span>RM {{ number_format($priceV[$featured->id][3], 2) }}</span>
                                                </b>
                                            @else
                                                <b class="item-price">
                                                    <span>RM {{ number_format($priceV[$featured->id][3], 2) }} - {{ number_format($priceV[$featured->id][2], 2) }}</span>
                                                </b>
                                            @endif
                                        @else
                                            @if(!empty($featured->agent_special_price))
                                                <b class="item-price">
                                                    <div>
                                                    <span>RM {{ number_format($featured->agent_special_price, 2) }}</span>
                                                    @if(!empty($discount_percentage))
                                                        <label class="badge badge-danger">-{{ number_format($discount_percentage) }}%</label>
                                                    @endif
                                                    </div>
                                                    <small><del>RM{{ number_format($featured->agent_price, 2) }}</del></small>
                                                </b>
                                            @else
                                                <b class="item-price">
                                                    <span>RM {{ number_format($featured->agent_price, 2) }}</span>
                                                </b>
                                            @endif
                                        @endif
                                    @else
                                        @if($featured->variation_enable == '1')
                                            @if($priceV[$featured->id][1] == $priceV[$featured->id][0])
                                                <b class="item-price">
                                                    <span>RM {{ number_format($priceV[$featured->id][1], 2) }}</span>
                                                </b>
                                            @else
                                                <b class="item-price">
                                                    <span>RM {{ number_format($priceV[$featured->id][1], 2) }} - {{ number_format($priceV[$featured->id][0], 2) }}</span>
                                                </b>
                                            @endif
                                        @else
                                            @if(!empty($featured->special_price))
                                                <b class="item-price">
                                                    <div>
                                                    <span>RM {{ number_format($featured->special_price, 2) }}</span>
                                                    @if(!empty($discount_percentage))
                                                        <label class="badge badge-danger">-{{ number_format($discount_percentage) }}%</label>
                                                    @endif
                                                    </div>
                                                    <small><del>RM{{ number_format($featured->price, 2) }}</del></small>
                                                </b>
                                            @else
                                                <b class="item-price">
                                                    <span>RM {{ number_format($featured->price, 2) }}</span>
                                                </b>
                                            @endif
                                        @endif
                                    @endif
                                    <div class="form-group" align="right">
                                        {{ !empty($soldCount[$featured->id]) ? $soldCount[$featured->id]." sold" : '' }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                {{ $products->links() }}
                <!-- PAGINATION-->
                <!-- <nav aria-label="Page navigation example">
                  <ul class="pagination justify-content-center justify-content-lg-end">
                    <li class="page-item"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                  </ul>
                </nav> -->
              </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')

<script type="text/javascript">
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
        var id = ele.data('id');
        var nameProduct = ele.parent().parent().find('.js-name-b2').html();
        if(auth_check){
            var fd = new FormData();
            fd.append('product_id', id);

            $.ajax({
                url: '{{ route("Favourite") }}',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    $('.loading-gif').hide();
                    if(ele.hasClass('active') == true){
                        // ele.removeClass('active');
                        toastr.success('Removed from wish list');
                    }else{
                        // ele.addClass('active');
                        toastr.success('Added to wish list');
                    }

                    $('.wishlist_count').html(response);
                }
            });
        }else{
            window.location.href = "{{ route('login') }}";
        }
  });


$('.add-to-cart-btn').click( function(e){
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
        fd.append('product_id', ele.data('id'));
        fd.append('quantity', '1');

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

                if(response == 'ok'){
                    $.ajax({
                        url: '{{ route("CountCart") }}',
                        type: 'get',
                        success: function(response){
                            $('.cart_count span').html(response[0]);
                            $('.cart_price').html('RM '+parseFloat(response[1]).toFixed(2));
                            
                        }
                    });
                    
                    toastr.success('Items Add To Cart. <a href="{{ route("checkout") }}" class="view-cart-button pull-right"><i class="fa fa-shopping-cart"></i> View Cart</a>');
                }else{
                    toastr.error('Error Please Contact Admin');
                }
            },
        });
    }else{
        window.location.href = "{{ route('login') }}";
    }
});

$('.main_category').click( function(e){
    e.preventDefault();

    var ele = $(this);
    ele.find('.arrow-right').toggleClass('fa-chevron-down');
    // alert(ele.parent().html());
    ele.parent().find('.sub_categories').slideToggle('fast', function(){});
});
$('.claim-voucher').click( function(e){
    e.preventDefault();

    var ele = $(this);
    var promo_id = ele.data('id');

    $('.loading-gif').show();
    var fd = new FormData();
    fd.append('discount_code', promo_id);
    fd.append('save', '1');

    $.ajax({
       url: '{{ route("ApplyPromo") }}',
       type: 'post',
       data: fd,
       contentType: false,
       processData: false,
       success: function(response){
            $('.loading-gif').hide();
            if(response == 0){
                toastr.error('Invalid promotion code');
            }else if(response == 1){
                toastr.error('This promotion code has run out of limit');
            }else if(response == 2){
                toastr.error('This Code Not In Promotion Date Range');
            }else if(response == 4){
                toastr.error("Opps! Today You run out of yours promotion code limit.");
            }else if(response == 5){
                toastr.error("Opps! You run out of yours promotion code limit.");
            }else if(response == '6'){
                toastr.error("You've claimed this voucher");
            }else{
                toastr.success('Claim Successfully');                
            }
       }
    });
});
</script>
<script type="text/javascript">
    const second = 1000,
          minute = second * 60,
          hour = minute * 60,
          day = hour * 24;
</script>
@if(!$data['promotions']->isEmpty())
@foreach($data['promotions'] as $pkey_two => $promotion)
<script type="text/javascript">

    let countDown{{$pkey_two}} = new Date("{{ date('M d, Y H:i:s', strtotime($promotion->end_date)) }}").getTime(),
        x{{$pkey_two}} = setInterval(function() {

          let now{{$pkey_two}} = new Date().getTime(),
              distance{{$pkey_two}} = countDown{{$pkey_two}} - now{{$pkey_two}};

          var display_day = Math.floor(distance{{$pkey_two}} / (day));
          var display_hour = Math.floor((distance{{$pkey_two}} % (day)) / (hour));
          var display_minutes = Math.floor((distance{{$pkey_two}} % (hour)) / (minute));
          var display_seconds = Math.floor((distance{{$pkey_two}} % (minute)) / second);

          document.getElementById('days{{ $pkey_two }}').innerText =  display_day,
          document.getElementById('hours{{ $pkey_two }}').innerText = display_hour,
          document.getElementById('minutes{{ $pkey_two }}').innerText = display_minutes,
          document.getElementById('seconds{{ $pkey_two }}').innerText = display_seconds;

        }, second)
</script>
@endforeach
@endif
@if(!empty(request('category')))
<script type="text/javascript">
    var categoryS = "{{ request('category') }}";
    $(document).ready(function() {
        $(window).on('load', function() {
            $('.main_category').filter(function(){return $(this).data('filter')==categoryS}).click();
        });
    });
</script>
@endif
@endsection