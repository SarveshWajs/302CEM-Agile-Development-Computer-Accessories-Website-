<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @if(!empty($data['website_logo']))
    <link rel="shortcut icon" href="{{ url($data['website_logo']) }}">
    @else
    <!-- <link rel="shortcut icon" href="{{ url('images/system/Vesson_Enterprise_Trans_Gold.png') }}"> -->
    @endif
    @if(!empty($data['admin']->website_name))
    <title>{{ $data['admin']->website_name }}</title>
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Lightbox-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/lightbox2/css/lightbox.min.css') }}">
    <!-- Range slider-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/nouislider/nouislider.min.css') }}">
    <!-- Bootstrap select-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/bootstrap-select/css/bootstrap-select.min.css') }}">
    <!-- Owl Carousel-->
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl.carousel2/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/vendor/owl.carousel2/assets/owl.theme.default.css') }}">
    <!-- Google fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Libre+Franklin:wght@300;400;700&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Martel+Sans:wght@300;400;800&amp;display=swap">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('frontend/css/custom.css') }}">
    <!-- Favicon-->
    

    <link rel="stylesheet" href="{{ asset('frontend/thumbnail-zoom/css/main.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor/plugins/video/plugin.js') }}"></script>
    <script src="{{ asset('js/ckeditor/plugins/html5video/plugin.js') }}"></script>
    
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.min.css') }}" />
    @toastr_css
</head>
<style type="text/css">
body{
  font-family: Arial, Helvetica, sans-serif;
}

.flip-card {
  background-color:transparent;
  width: 300px;
  height: 300px;
  border: 2px solid grey;
  perspective: 10000px;

}

.flip-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.5s;
  transform-style: preserve-3d;
  box-shadow: 0 4px 8px 0  black;
}

.flip-card:hover .flip-card-inner {
  transform: rotateY(180deg);
}

.flip-card-front, .flip-card-back {
  position: absolute;
  width: 100%;
  height: 100%;
  -webkit-backface-visibility:show ;
  backface-visibility:hidden ;


}

.flip-card-front {
  background-color:#bbb;
  color: black;
}

.flip-card-back {
  background-color: rgba(255, 255, 255, .15);  
  transform: rotateY(180deg);

}

}
.btn btn-primary {
  background-color:yellow; /* Green */
  border: none;
  color: Black;
  padding: 6px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 8px 4px;
  cursor: pointer;
}


.flip-card h3{
    text-overflow: ellipsis;
    display: block;
    white-space: nowrap;
    width: 100%;
    overflow: hidden;
}
.flip-card p{
    text-overflow: ellipsis;
    display: block;
    white-space: nowrap;
    width: 100%;
    overflow: hidden;
}

div.a {

  padding: 10px 20px;
}

div.b {

  padding: 20px 20px;
}

div.c {

  padding: 10px 10px;
}

div.d {

  padding: 270px 5px;
}

div.e {

  padding: 10px 5px;
}
div.f {

  padding: 10px 5px;
}
.btn btn-primary  {border-radius: 10px;}


.fixed {
    position: fixed;
    top:0; 
    left:0;
    width: 100%; 
    z-index: 2000;
}

.flip-card{
    width: 100%;
}

/*.header-sticky-top
{
    position: fixed;
    z-index: 999;
    opacity:1;
    width: 100%;
}*/

.owl-carousel .owl-nav{
    position: absolute;
    top: 50%;
    width: 115%;
    left: -37px;
}

.owl-carousel .owl-prev{
    float:left;
}

.owl-carousel .owl-next{
    float:right;
}

.owl-carousel .owl-prev, .owl-carousel .owl-next{
    font-size: 45px;
    color: white;
}

.navbar-light .navbar-nav .nav-link{
    font-weight: 100 !important;
}

.product-detail-name{
    font-size: 24px;
}

.product-detail-desc{
    font-size: 18px;
}

.category-item-bg{
    background-position: center;
    background-repeat: no-repeat;
    background-size: 100%;
    width: 250px;
    height: 250px;
    border-radius: 100%;
    margin: auto;
    border: 1px solid #eee;
}

.top-header-nav{
    background-color: #000; 
    padding: 10px 0;
}

.top-header-nav a{
    color: #fff;
}

#page{
    overflow-x: visible;
}

.justify-content-center{
    display: flex;
    justify-content: center;
}
.fh5co-heading h2, .fh5co-heading span{
    color: #DF0030;
}

#fh5co-testimonial .testimony-slide figure img{
    border-radius: 100%;
    width: 200px;
}

.fh5co-nav .menu-2 li a.cart span small{
    top: -16px;
    padding: 9px 6px;
}

.fh5co-nav .menu-2 li.shopping-cart, .fh5co-nav ul li{
    margin-top: 20px;
}

.fh5co-nav .menu-2 li.search{
    margin-top: 10px;
}

.payment-area{
    display: none;
}

.separator {
    display: flex;
    align-items: center;
    text-align: center;
    margin-bottom: 10px;
}
.separator::before, .separator::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #000;
}
.separator::before {
    margin-right: .25em;
}
.separator::after {
    margin-left: .25em;
}

.container-box a:hover, a:focus{
    color: #000 !important;
}

.main_category{
    display: block;
}

.product__item:hover .product__item__text h6{
    opacity: 1;
}

.header__nav__option a span{
    top: 3px;
}

.fb_dialog_content iframe{
    bottom: 80px !important;
}

.item-price, .item-price span{
    color: #e53637;
}

small{
    font-size: 10px;
}

.scrolling-text{
    color: #fff;
}

.myPopUp{
    position: fixed; 
    top: 50%; 
    left: 50%; 
    transform: translate(-50%, -50%); 
    box-shadow: 0 0 10px 0 rgba(0,0,0,0.5);
    background-color: white;
    width: 320px;
}


@media screen and ( max-width: 400px ){

    li.page-item {

        display: none;
    }

    .page-item:first-child,
    .page-item:nth-child( 2 ),
    .page-item:nth-last-child( 2 ),
    .page-item:last-child,
    .page-item.active,
    .page-item.disabled {

        display: block;
    }
}

.product__discount__item__pic .product__discount__percent {
    height: 45px;
    /* width: 45px; */
    width: auto;
    min-width: 45px !important;
    background: #dd2222;
    border-radius: 50%;
    padding: 0px 10px  !important;
    font-size: 14px;
    color: #ffffff;
    line-height: 45px;
    text-align: center;
    position: absolute;
    left: 15px;
    top: 15px;
}

.details-img{
    width: 100%;
    height: 450px;
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
}

.required-feild-error{
    border-color: red;
}


.sub_categories a.active{
    font-weight: bold;
}

.sub_categories{
    display: none; 
    margin-left: 20px; 
    padding: 10px 0;
}

.breadcrumb-section{
    padding: 70px 0 70px;
}

.listing-video{
    height: 265px;
    width: 100%;
}

.variation_option{
    border: 1px solid #ddd; 
    padding: 10px; 
    text-align: center;
    cursor: pointer;
}

.variation_option{
    padding: 10px; 
    text-align: center;
    cursor: pointer;
    min-width: 5rem;
    min-height: 2.125rem;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding: .25rem .75rem;
    margin: 0 8px 8px 0;
    color: rgba(0,0,0,.8);
    text-align: left;
    border-radius: 2px;
    border: 1px solid rgba(0,0,0,.09);
    position: relative;
    background: #fff;
    outline: 0;
    word-break: break-word;
    display: -webkit-inline-box;
    display: -webkit-inline-flex;
    display: -moz-inline-box;
    display: -ms-inline-flexbox;
    display: inline-flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -moz-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
    -moz-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
}

.variation_option.active{
    border: 2px solid #e53637; 
}

.variation_option.out-of-stock{
    border: 2px solid #eee; 
    background-color: #eee;
    cursor: not-allowed;
    pointer-events:none;
}

.button-inside{
    position: relative;
}

.button-inside input{
    padding-right: 85px;
}

.button-inside a{
    position:absolute;
    right: 10px;
    top: 8px;
    outline:none;
    text-align:center;
    font-weight:bold;
    color: #fff;
    font-size: 10px;
    padding: 2px 8px;
}

.btn{
    color: #fff !important;
}

.word-in-line {
   width: 100%; 
   text-align: center; 
   border-bottom: 1px solid #000; 
   line-height: 0.1em;
   margin: 10px 0 20px; 
} 

.word-in-line span { 
    background:#fff; 
    padding:0 5px; 
    font-size: 15px;
}

.bw-brg{
    background-color: #fff;
}

.product-description img{
    max-width: 100% !important;
}

.packages_badges{
    background: #dd2222;
    font-size: 12px;
    color: #ffffff;
    text-align: center;
    position: absolute;
    left: 15px;
    top: 15px;
    padding: 10px;
}

.footer{
    padding-bottom: 40px;
}

.product__discount__item, .featured__item{
    box-shadow: 0px 6px 10px -6px rgba(127, 173, 57, 1);
    padding-bottom: 10px;
    margin-top: 20px;
}

.product__discount__item__text h6, .featured__item__text h6{
    height: 50px;
    overflow: hidden;
}

.product__discount__item__text h5{
    height: 50px;
    overflow: hidden;
}

.details-box li{
    margin-left: 17px;
}

.price-range-wrap .range-slider .price-input input{
    max-width: 40%;
}


.nice-select{
    width: 100% !important;
}

.cat_menu li a i{
    display: block;
}

#toast-container *{
    color: #fff;
}

.container-box{
    box-shadow: 0 0 10px 0 #eee;
    padding: 15px;
    font-size: 12px;
    background-color: #fff;
}

.important-text{
    color: red;
}

label {
    font-weight: 400;
    font-size: 14px;
}

label input[type=checkbox].ace, label input[type=radio].ace {
    z-index: -100!important;
    width: 1px!important;
    height: 1px!important;
    clip: rect(1px,1px,1px,1px);
    position: absolute;
}


input[type=checkbox].ace+.lbl, input[type=radio].ace+.lbl {
    position: relative;
    display: inline-block;
    margin: 0;
    line-height: 20px;
    min-height: 18px;
    min-width: 18px;
    font-weight: 400;
    cursor: pointer;
}

input[type=checkbox].ace+.lbl::before, input[type=radio].ace+.lbl::before {
    cursor: pointer;
    font-family: fontAwesome;
    font-weight: 400;
    font-size: 12px;
    color: #FFF;
    content: "\a0";
    background-color: #FAFAFA;
    border: 1px solid #c59868;
    box-shadow: 0 1px 2px rgba(0,0,0,.05);
    border-radius: 0;
    display: inline-block;
    text-align: center;
    height: 16px;
    line-height: 14px;
    min-width: 16px;
    margin-right: 1px;
    position: relative;
    top: -1px;
}

input[type=checkbox].ace:checked+.lbl::before, input[type=radio].ace:checked+.lbl::before {
    display: inline-block;
    content: '\f00c';
    color: #000;
    background-color: #F5F8FC;
    border-color: #ADB8C0;
    box-shadow: 0 1px 2px rgba(0,0,0,.05),inset 0 -15px 10px -12px rgba(0,0,0,.05),inset 15px 10px -12px rgba(255,255,255,.1);
}


.cart-header-list, .cart-details-list, .cart-checkout{
  padding: 10px;
  box-shadow: 0 1px 4px 0 rgba(0,0,0,.26);
  background-color: #fff;
}

.cart-header-list ul, .cart-details-list ul, .cart-checkout ul{
  list-style-type: none;
  margin: 0px;
  width: 100%;

}

.cart-details-list ul{
  border-bottom: 1px solid #d3d3d3;
}

.cart-header-list ul li, .cart-details-list ul li, .cart-checkout ul li{
  display: inline-block;
  vertical-align: top;
}

ul .select-cart{
  width: 5%;
}

ul .product-name{
  width: 45%;
}

ul .unit-price, ul .product-quantity, ul .product-total-price, ul .list-action{
  width: 12%;
  text-align: center;
}

.product-name img{
  width: 70px;
  display: inline-flex;

}

.product-all-details{
  height: 100px;
}

.product-details-name{
  width: 200px;
  display: inline-flex;
  word-wrap: break-word;
  vertical-align: top;
}

.product-details{
    padding-top: 0px;
}

.quantity-setting{
  display: inline-flex;
}

.quantity-setting .deduct-qty-button, .quantity-setting .add-qty-button{
  font-size: 15px;
  padding: 6px 10px;
  background-color: #fff !important;
  border-color: #fff !important;
  border: 1px solid #d3d3d3 !important;
  color: #000 !important;
  margin: 0px;
}

.quantity-setting input{
  width: 70px;
  text-align: center;
}

.list-action i{
  font-size: 20px;
}

.mobile-cart{
  display: none;
}

.checkout-total {
    width: 93%;
}

.checkout-total b.total-amount, .checkout-total b.east-total-amount{
    font-size: 20px;
    margin-right: 10px;
    color: #717fe0;
}

.details-page .details-box{
    padding: 10px;
    box-shadow: 0 1px 4px 0 rgba(0,0,0,.26);
}

.quantity-balance{
    font-size: 10px;
    color: #928c8c;
}

input[name="bank_id"], input[name="sub_category_id"] { 
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

input[name="bank_id"] + img {
  cursor: pointer;
  width: 100px;
}

input[name="bank_id"]:checked + img {
  border: 2px solid #211c1c;
}

.widget-box.transparent {
    border-width: 0;
}

.widget-box {
    padding: 0;
    box-shadow: none;
    margin: 3px 0;
    border: 1px solid #CCC;
}

.progress, .widget-box {
    -webkit-box-shadow: none;
}

.widget-box.transparent>.widget-header {
    background: 0 0;
    border-width: 0;
    border-bottom: 1px solid #DCE8F1;
    color: #4383B4;
    padding-left: 3px;
}

.widget-box.transparent>.widget-header, .widget-header-flat {
    filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
}

.widget-header {
    -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box;
    position: relative;
    min-height: 38px;
    background: repeat-x #f7f7f7;
    background-image: -webkit-linear-gradient(top,#FFF 0,#EEE 100%);
    background-image: -o-linear-gradient(top,#FFF 0,#EEE 100%);
    background-image: linear-gradient(to bottom,#FFF 0,#EEE 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffeeeeee', GradientType=0);
    color: #669FC7;
    border-bottom: 1px solid #DDD;
    padding-left: 12px;
}

.widget-header:after, .widget-header:before {
    content: "";
    display: table;
    line-height: 0;
}

.widget-header:after {
    clear: right;
}

.widget-header>.widget-title {
    line-height: 36px;
    padding: 0;
    margin: 0;
    display: inline;
}

.widget-header>.widget-title>.ace-icon {
    margin-right: 5px;
    font-weight: 400;
    display: inline-block;
}

h4.smaller {
    font-size: 17px;
}

.lighter {
    font-weight: lighter;
}

.widget-toolbar {
    display: inline-block;
    padding: 0 10px;
    line-height: 37px;
    float: right;
    position: relative;
}

.no-border {
    border-width: 0;
}

.widget-toolbar>.nav-tabs {
    border-bottom-width: 0;
    margin-bottom: 0;
    top: auto;
    margin-top: 3px!important;
}

.nav-tabs {
    border-color: #C5D0DC;
    margin-bottom: 0!important;
    position: relative;
    top: 1px;
}

.nav-tabs, .nav-tabs>li:first-child>a {
    margin-left: 0;
}

button:hover{
    color: #000 !important;
}

.btn-group-vertical>.btn-group:after, .btn-toolbar:after, .clearfix:after, .container-fluid:after, .container:after, .dl-horizontal dd:after, .form-horizontal .form-group:after, .modal-footer:after, .modal-header:after, .nav:after, .navbar-collapse:after, .navbar-header:after, .navbar:after, .pager:after, .panel-body:after, .row:after {
    clear: both;
}


.widget-toolbar>.nav-tabs>li {
    margin-bottom: auto;
}

.nav-tabs>li {
    float: left;
    margin-bottom: -1px;
}

.nav>li, .nav>li>a {
    display: block;
    position: relative;
}

.transparent>.widget-header>.widget-toolbar>.nav-tabs>li.active>a {
    border-top-color: #4C8FBD;
    border-right: 1px solid #C5D0DC;
    border-left: 1px solid #C5D0DC;
    background-color: #FFF;
    box-shadow: none;
}

.transparent>.widget-header>.widget-toolbar>.nav-tabs>li>a {
    color: #555;
    background-color: transparent;
    border-right: 1px solid transparent;
    border-left: 1px solid transparent;
}

.widget-toolbar>.nav-tabs>li.active>a {
    background-color: #FFF;
    border-bottom-color: transparent;
    box-shadow: none;
    margin-top: auto;
}

.widget-toolbar>.nav-tabs>li>a {
    box-shadow: none;
    position: relative;
    top: 1px;
    margin-top: 1px;
}

.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
    color: #576373;
    border-color: #C5D0DC #C5D0DC transparent;
    border-top: 2px solid #4C8FBD;
    background-color: #FFF;
    z-index: 1;
    line-height: 18px;
    margin-top: -1px;
    box-shadow: 0 -2px 3px 0 rgba(0,0,0,.15);
}

.nav-tabs, .nav-tabs>li:first-child>a {
    margin-left: 0;
}

.nav-tabs>li>a, .nav-tabs>li>a:focus {
    border-radius: 0!important;
    border-color: #C5D0DC;
    background-color: #F9F9F9;
    color: #999;
    margin-right: -1px;
    line-height: 18px;
    position: relative;
}
.nav-tabs>li>a {
    padding: 7px 12px 8px;
}

.widget-box.transparent>.widget-body {
    border-width: 0;
    background-color: transparent;
}

.widget-body {
    background-color: #FFF;
}

.widget-main.padding-4 {
    padding: 4px;
}

.widget-main {
    /*overflow: auto;*/
}

.widget-main {
    padding: 12px;
}

.widget-main .tab-content {
    border-width: 0;
}

.tab-content.padding-8 {
    padding: 8px 6px;
}

.tab-content {
    border: 1px solid #C5D0DC;
    padding: 16px 12px;
    position: relative;
}

.tab-content>.tab-pane {
    display: none;
}

.tab-content>.active {
    display: block;
}

select{
    margin-left: 0px;
}


.profile-own-bg {
    background-color: #e53637;
    padding: 50px 0 150px 0;
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    position: relative;
}

.personal-header-info {
    position: absolute;
    top: 5%;
    width: 100%;
}

.profile-content {
    margin-top: 65px;
}

.profile-logo{
    border-radius: 100%;
}

.header-title, .setting-btn, .profile-name, .profile-code, .profile-level{
    color: #fff;
}

.profile-setting-list li {
    list-style-type: none;
    border-bottom: 1px solid #eee;
    padding: 10px 0;
}

.profile-setting-list li a {
    width: 100%;
    display: block;
}

.pull-right {
    float: right;
}

.pull-left {
    float: left;
}

.profile-word{
    color: #000;
    margin-top : 5px;
    display: block;
}

.bottom-menu-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 10px 10px;
    box-shadow: 0 0 7px #eee;
    z-index: 100000;
    background-color: #fff;
    display: none;
    font-size: 11px;
}

.wallet-desc {
    border-top: 1px solid #eee;
    display: block;
    width: 100%;
    font-size: 10px;
    padding-top: 5px;
}

.wallet-balance-amount {
    color: #4F99C6;
    font-size: 20px;
}

.affiliate_list ul{
    list-style-type: none;
    margin-left: 0px;
}

.affiliate_list ul li{
    padding: 10px 0;
    border-bottom: 1px solid #000;
}

.affiliate_list ul li a{
    display: block;
    width: 100%;
}

.affiliate_list ul li a .view-affiliate{
    float: right;
    margin-top: 20px;
}

.affiliate_list ul li .users-img{
    border-radius: 100%;
    width: 40px;
    height: 40px;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 100%;
}

.affiliate_list .affiliate-search-area{
    padding: 10px;
    background-color: transparent;
}

.affiliate_list .affiliate-list-area{
    padding: 10px;
    
    margin: 0 10px;
    border-radius: 10px;
}

.affiliate_list .affliate-details-background .user-details-img{
    border-radius: 100%;
    width: 50px;
    height: 50px;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: 100%;   
}

.affiliate_list .users-details-box{
    float: left;
    display: inline;
    margin-right: 20px;
    color: #000;
}

.affiliate_list .search_affiliates{
    border-radius: 25px !important;
    padding-left: 15px;
}

.affiliate_list .search-query{
    border-top-left-radius: 25px !important;
    border-bottom-left-radius: 25px !important;
    padding-left: 15px;
}

.affiliate_list .search-button{
    border-top-right-radius: 25px !important;
    border-bottom-right-radius: 25px !important;
    border-left: none;
    border-color: #c59868 !important;
    padding: 6.2px 10px;

}

.affiliate_list .affliate-details-background{
    position: relative;
    padding: 20px;
    width: 100%;
    height: 300px;
    background-size: 100%;
    background-position: center center;
    background-repeat: no-repeat;
    color: #fff;
    /*background-image: url({{ url('images/videoblocks-golden-globe-of-light-appears-and-moves-over-a-dark-background-abstract-warm-bulb-of-light_bnqdhq_9e_thumbnail-full02.png') }});*/
    background-color: #e53637;
}

.affiliate_list .affliate-details-background .totalResult{
    position: absolute;
    bottom: 5px;
    width: 100%;
}

.affiliate_list .totalResult .col-xs-4{
    border-right: 1px solid #fff;
}

.affiliate_list .totalResult .col-xs-4:last-child{
    border-right: none;
}

.affiliate_list .user-name{
    margin-top: 5px;
}

.loading-gif{
    position: fixed;
    left: 0;
    top: 0;
    bottom: 0;
    right: 0;
    z-index: 1000;
    background-size: 2%;
    background-repeat: no-repeat;
    background-position: center center;
    width: 100%;
    height: 100%;
    background-color: rgba(255,255,255, 0.5);
    display: none;
    z-index: 10000;
}

.banner-images{
    background-size: 100%;
    background-position: center;
    background-repeat: no-repeat;
    width: 100%;
    height: 378px;
}

.header__logo__box__mobile{
    display: none;
}

.featured__item__text h6{
    font-size: 14px;
    color: #b2b2b2;
    display: block;
    margin-bottom: 4px;
}

.product__discount__item__text span{
    color: #000 !important;
    
}

@media (min-width: 1600px){
    .container {
        max-width: 1500px !important;
    }
}

@media (min-width: 1400px){
    .container {
        max-width: 1400px;
    }
}

@media only screen and (max-width: 1200px) {
    .category-item-bg{
        width: 150px;
        height: 150px;
    }
}

@media only screen and (max-width: 992px) {
    .mobile-cart {
        display: block;
    }

    .web-cart {
        display: none;
    }

    ul .select-cart {
        width: 35px;
    }

    ul .unit-price {
        width: auto;
        text-align: left;
        font-size: 11px;
    }

    ul .product-name {
        width: 120px;
    }
}

@media only screen and (max-width: 768px) {
    .profile-word{
        font-size: 10px;
    }

    .bottom-menu-bar {
        display: block;
    }

    .banner-images{
        height: 200px;
    }

    .header__cart__box{
        display: none;
    }

    .header__cart{
        margin-top: 13px;
    }

    .header__cart ul li a i{
        font-size: 25px;
    }

    .header__cart ul li a span{
        top: -10px;
    }

    .header__logo__box__mobile{
        display: block;
    }

    .header__logo__box{
        display: none;
    }

    .f-15{
        font-size: 12px !important;
    }

    .listing-video{
        height: 150px;
    }

    .offcanvas__nav__option a span{
        top: 4.5px !important;
    }

    .category-item-bg{
        width: 100px;
        height: 100px;
    }

    body{
        font-size: 12px;
    }

    .page-holder{
        margin-bottom: 60px;
    }
}
@media only screen and (max-width: 767px) {
    .details-img{
        height: 200px;
    }

    .product-detail-name{
        font-size: 15px;
    }

    .product-detail-desc{
        font-size: 11px;
    }
    @if(Request::segment(1) == 'Details')
    .header{
        display: none;
    }

    .breadcrumb{
        margin-top: 10px;
    }

    .breadcrumb-item{
        font-size: 10px;
    }
    @endif

}

@media only screen and (max-width: 600px) {
    .product .product-grid{
        height: 250px;
    }
}

@media only screen and (max-width: 540px) {
    .category-item-bg{
        width: 60px;
        height: 60px;
    }
}

@media only screen and (max-width: 480px) {
    .profile-word{
        font-size: 9px;
    }

    ul .select-cart {
        width: 20px;
    }

    .product-name img, ul .product-name {
        width: 50px;
    }

    .product__discount__item__pic, .featured__item__pic{
        height: 150px;
    }

    .product .product-grid{
        height: 200px;
    }
}

@media only screen and (max-width: 360px) {
    .profile-word{
        font-size: 8px;
    }

    .product .product-grid{
        height: 150px;
    }

    @if(Request::segment(1) == 'Details')
    .breadcrumb-item{
        font-size: 9px;
    }
    @endif
}
</style>
@yield('css')

<body>
    <div class="loading-gif" style="background-image: url({{ url('images/loading/09b24e31234507.564a1d23c07b4.gif') }}); ">
    </div>
    <div id="app">
        <div class="page-holder">
            @include('partial.frontend.header')
            @yield('content')
            @include('partial.frontend.footer')
        </div>
    </div>

    @if(!empty(Session::get('registered_account')))
    <div class="myPopUp" align="center">
        <img src="{{ url('images/successgif.gif') }}" width="70%">
        <div class="" style="padding: 15px;">
            <p>
                <b>Register Successfully! </b>
                <br>
                A verification link has been sent to your Email account. Please check your Junk Mail / Spam Mail if you did not receive any Email and click on the link to verify your account.
            </p>
            <button class="btn btn-success close-pop-up-message-btn">
                Close
            </button>
        </div>
    </div>
    @endif

    @if(!empty(Session::get('registered_account_topup')))
    <div class="myPopUp" align="center">
        <img src="{{ url('images/successgif.gif') }}" width="70%">
        <div class="" style="padding: 15px;">
            <p>
                Register Successfully! Please wait Admin for approver.
            </p>
            <button class="btn btn-success close-pop-up-message-btn">
                Close
            </button>
        </div>
    </div>
    @endif

    @if(Auth::guard('merchant')->check())
        @if(!empty($data['upline_phone']))
            <a href="https://api.whatsapp.com/send?phone=6{{ $data['upline_phone'] }}&source=&data=" target="_blank"
               style="position: fixed; bottom: 9%; right: 2%; border-radius: 100%; z-index: 99999; background-image: url({{ url('images/Whatsapp.png') }}); background-size: 90%; width: 60px; background-position: center; background-repeat: no-repeat; height: 60px; display: block;" >
              
            </a>
        @else
            @if(!empty($data['web_setting']->contact_whatsapp))
            <a href="https://api.whatsapp.com/send?phone=6{{ $data['web_setting']->contact_whatsapp }}&source=&data=" target="_blank"
               style="position: fixed; bottom: 9%; right: 2%; border-radius: 100%; z-index: 99999; background-image: url({{ url('images/Whatsapp.png') }}); background-size: 90%; width: 60px; background-position: center; background-repeat: no-repeat; height: 60px; display: block;" >
              
            </a>
            @endif
        @endif
    @else
        @if(!empty($data['web_setting']->contact_whatsapp))
        <a href="https://api.whatsapp.com/send?phone=6{{ $data['web_setting']->contact_whatsapp }}&source=&data=" target="_blank"
           style="position: fixed; bottom: 9%; right: 2%; border-radius: 100%; z-index: 99999; background-image: url({{ url('images/Whatsapp.png') }}); background-size: 90%; width: 60px; background-position: center; background-repeat: no-repeat; height: 60px; display: block;" >
          
        </a>
        @endif
    @endif

    
<!-- jQuery -->
<script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/lightbox2/js/lightbox.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/nouislider/nouislider.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/owl.carousel2/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js') }}"></script>
<script src="{{ asset('frontend/js/front.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script>
// ------------------------------------------------------- //
//   Inject SVG Sprite - 
//   see more here 
//   https://css-tricks.com/ajaxing-svg-sprite/
// ------------------------------------------------------ //
function injectSvgSprite(path) {

    var ajax = new XMLHttpRequest();
    ajax.open("GET", path, true);
    ajax.send();
    ajax.onload = function(e) {
    var div = document.createElement("div");
    div.className = 'd-none';
    div.innerHTML = ajax.responseText;
    document.body.insertBefore(div, document.body.childNodes[0]);
    }
}
// this is set to BootstrapTemple website as you cannot 
// inject local SVG sprite (using only 'icons/orion-svg-sprite.svg' path)
// while using file:// protocol
// pls don't forget to change to your domain :)
injectSvgSprite('https://bootstraptemple.com/files/icons/orion-svg-sprite.svg'); 

</script>
<!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

<script src="{{ asset('frontend/thumbnail-zoom/scripts/zoom-image.js') }}"></script>
<script src="{{ asset('frontend/thumbnail-zoom/scripts/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

</body>

@toastr_js
@toastr_render
@yield('js')

<script type="text/javascript">
    $(window).scroll(function(){
        var sticky = $('.sticky'),
        scroll = $(window).scrollTop();

        if (scroll >= 100) sticky.addClass('fixed');
            else sticky.removeClass('fixed');
});
</script>

<script type="text/javascript">
    $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    function isNumberKey(evt)
    {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
         return false;

      return true;
    }

    $('.close-pop-up-message-btn').click( function(e){

        $.ajax({
            url: '{{ route("Confirmation_message") }}',
            type: 'get',
            success: function(response){
                $('.myPopUp').remove();                
            },
        }); 
    });
</script>
@if(!empty(request("a")))
<script type="text/javascript">
        
    function guestAgent()
    {

        var fd = new FormData();
            fd.append('agent', '{{ request("a") }}');

        $.ajax({
            url: '{{ route("guestAgent") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                
            },
        }); 
    }

    guestAgent();
</script>
@endif
@if(!empty(request("l")))
    <script type="text/javascript">
        function ProceedCartLink()
        {
            var checkLogin = "{{ Auth::guard($data['userGuardRole'])->check() }}";
            var fd = new FormData();
                fd.append('link_id', '{{ request("l") }}');

            $.ajax({
                url: '{{ route("ProceedCartLink") }}',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                    window.location.href = "{{ route('checkout') }}";
                },
            });
        }
        ProceedCartLink();
    </script>
@endif
<script type="text/javascript">
    $('.select-packages').change( function(){
        var ele = $(this);
        $('.loading-gif').show();
        var fd = new FormData();
            fd.append('pid', ele.val());

        $.ajax({
            url: '{{ route("getAffPackages") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                $('.loading-gif').hide();
                $('.payment-area').show();
                $('.topup_amount_display').html(parseFloat(response[0]));
            },
        });
    });

    function checkUserActive()
    {
        $.ajax({
            url: '{{ route("checkUserActive") }}',
            type: 'get',
            success: function(response){
                if(response == 3){
                    $.ajax({
                        url: '{{ route("forceLogout") }}',
                        type: 'get',
                        success: function(response){
                            // alert(response);
                            window.location.href = "{{ route('login') }}";
                        },
                    });
                }
            },
        });
    }

    checkUserActive();
    
</script>


</html>
