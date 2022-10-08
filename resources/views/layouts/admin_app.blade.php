@php
    if(Auth::guard('merchant')->check() && empty(Auth::guard('merchant')->user()->permission_lvl)){
        $url = route('home');
        echo "<script>
                 window.location.href = '".$url."'
              </script>";
    }
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(!empty($data['website_name']))
    <title>{{ $data['website_name'] }} Backend</title>
    @else
    <title>Weshare Backend</title>
    @endif
    @if(!empty($data['website_logo']))
    <link rel="shortcut icon" href="{{ url($data['website_logo']) }}">
    @else
    <!-- <link rel="shortcut icon" href="{{ url('images/system/Vesson_Enterprise_Trans_Gold.png') }}"> -->
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/4.5.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.min.css') }}" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.googleapis.com.css') }}" />

    <!-- ace styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />

    <!--[if lte IE 9]>
        <link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('assets/css/ace-skins.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/ace-rtl.min.css') }}" />

    <!--[if lte IE 9]>
      <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="{{ asset('assets/js/ace-extra.min.js') }}"></script>

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    <script src="assets/js/html5shiv.min.js"></script>
    <script src="assets/js/respond.min.js"></script>
    <![endif]-->

    <!-- CkEditor -->
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor/plugins/video/plugin.js') }}"></script>
    <script src="{{ asset('js/ckeditor/plugins/html5video/plugin.js') }}"></script>
    <!-- End CkEditor -->

    <!-- dropzone -->
    <link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}" />
    <!-- EndDropzone -->

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    @toastr_css
</head>
@yield('css')
<style type="text/css">
    .separator {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 10px 0;
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

    .progress{
        margin-bottom: 0px;
    }

    .progress.progress-mini {
        height: 6px;
    }

    .bs-callout {
        padding: 10px 20px;
        border: 1px solid #eee;
        border-left-width: 5px;
        border-radius: 3px;
    }

    .bs-callout-info {
        border-left-color: #1b809e;
    }

    .bs-callout-warning {
        border-left-color: #aa6708;
    }

    .bs-callout-danger {
        border-left-color: #ce4844;
    }

    .panel-success>.panel-heading {
        color: #fff;
        background-color: #1bb787;
        border-color: #d6e9c6;
    }

    .panel-danger>.panel-heading {
        color: #fff;
        background-color: #ed6b77;
        border-color: #ebccd1;
    }

    .panel-primary>.panel-heading {
        color: #fff;
        background-color: #659cdf;
        border-color: #659cdf;
    }

    .panel-info>.panel-heading {
        color: #fff;
        background-color: #34b4c1;
        border-color: #659cdf;
    }

    .panel-footer{
        border-top: 1px solid #fff;
    }

    .panel-footer a{
        color: #fff;
    }

    .dashboard-wording{
        font-size: 1.5rem;
    }

    .dashboard-wording.value{
        font-size: 2rem;
    }

    .dashboard-wording-icon{
        font-size: 4rem;            
    }

    .transfer-loading{
        background-repeat: no-repeat; 
        background-size: cover; 
        background-position: center center; 
        width: 100%; 
        height: 50px;
        display: none;
    }

    .table>thead>tr{
        background: repeat-x #fff;
        background-image: linear-gradient(to bottom,#fff 0,#fff 100%);
    }

    .table>thead>tr>th{
        border-bottom: 1px solid #ddd;
    }

    .important-text{
        color: red !important;
    }

    .submit-form-btn{
        position: fixed;
        bottom: 0px;
        right: 0px;
        left: 0px;
        padding: 10px 20px 0 10px;
        background-color: #F2F2F2;
        z-index: 10;
    }

    .page-content{
        padding: 8px 20px 80px 24px;
    }

    .product-image-thumbnail{
        width: 16.6666667%;
        float: left;
        padding: 0 12px;
    }

    .product-image-thumbnail .form-group{
        position: relative;
        overflow: hidden;
    }

    .delete-image-box{
        position: absolute;
        bottom: 0px;
        right: 0px;
        left: 0px;
        text-align: center;
        display: none;
        z-index: 1;
        padding: 5px 0px;
        background-color: rgba(0, 0, 0, 0.5);
        font-size: 20px;
        
    }

    .delete-image-box .delete-image{
        color: red;
        transition: transform .5s ease;
    }

    .product-image-thumbnail:hover .product-image-thumbnail-img{
        
        transform: scale(1.5);
    }

    .product-image-thumbnail:hover .delete-image-box{
        display: block;
    }

    .clear-both{
        clear: both;
    }
    .product-image-thumbnail .product-image-thumbnail-img{
        overflow: hidden;
        width: 100%;
        transition: transform .5s ease;
        height: 200px;
        background-repeat: no-repeat;
        background-size: 100%;
        background-position: center center;
    }

    .affiliate_list ul{
        list-style-type: none;
        margin-left: 0px;
    }

    .affiliate_list ul li{
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
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
        width: 50px;
        height: 50px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 100%;
    }

    .affiliate_list .affiliate-search-area{
        padding: 10px;
        background-color: #eee;
    }

    .affiliate_list .affiliate-list-area{
        padding: 10px;
    }

    .affiliate_list .affliate-details-background .user-details-img{
        border-radius: 100%;
        width: 100px;
        height: 100px;
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 100%;   
    }

    .affiliate_list .users-details-box{
        float: left;
        display: inline;
        margin-right: 20px;
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
        border-color: #d5d5d5 !important;
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
        background-image: url({{ url('images/profile-background-11.jpg') }});
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
        margin-top: 35px;
    }

    .loading-gif{
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        right: 0;
        z-index: 1000;
        background-size: 20%;
        background-repeat: no-repeat;
        background-position: center center;
        width: 100%;
        height: 100%;
        background-color: rgba(255,255,255, 0.5);
        display: none;
        z-index: 10000;
    }

    .bootstrap-select>.dropdown-toggle{
        color: #000 !important;
        background-color: #fff !important;
        border: 1px solid #FFF;
        border-color: #d5d5d5;
    }

    .add-row-btn{
        border-radius: 100%; 
        border: 1px solid #438EB9; 
        padding: 6px 10px; 
        background-color: #438EB9; 
        color: #fff;
    }

    .select2-container{
        width: 100% !important;
    }

    .select2-container .select2-selection--single{
        height: 34px;
    }

    .input-required-field{
        border: 1px solid red !important;
    }

    .container-box{
        box-shadow: 0 1px 4px 0 rgba(0,0,0,.26);
        padding: 10px;
        background-color: #fff;
    }

    

    @media only screen and (max-width: 1199px) {
        .dashboard-wording{
            font-size: 1rem;
        }

        .dashboard-wording.value{
            font-size: 1.5rem;
        }

        .dashboard-wording-icon{
            font-size: 3rem;            
        }
    }

    @media only screen and (max-width: 992px) {
        .dashboard-wording{
            font-size: 2rem;
        }

        .dashboard-wording.value{
            font-size: 2.5rem;
        }

        .dashboard-wording-icon{
            font-size: 4rem;            
        }
    }

    @media only screen and (max-width: 650px) {
        .affiliate_list .affliate-details-background{
            height: 220px;
        }
    }

    @media only screen and (max-width: 500px) {
        .affiliate_list .affliate-details-background{
            height: 160px;
        }

        .affiliate_list .affliate-details-background .user-details-img{
            width: 60px;
            height: 60px;
        }

        .affiliate_list .user-name{
            margin-top: 20px;
        }

        .affiliate_list .totalResult{
            font-size: 10px;
        }

    }

    @media only screen and (max-width: 360px) {
        .affiliate_list .affliate-details-background{
            padding: 10px;
        }

        .affiliate_list .affliate-details-background{
            height: 136px;
        }

        .affiliate_list .affliate-details-background .user-details-img{
            width: 50px;
            height: 50px;
        }

        .affiliate_list .user-name{
            margin-top: 15px;
        }

        .affiliate_list .users-details-box{
            font-size: 10px;
        }

        .affiliate_list .totalResult{
            font-size: 8px;
        }
    }
</style>
<body class="no-skin">
    <div class="loading-gif" style="background-image: url({{ url('images/loading/lazyload-placeholder.gif') }}); "></div>
    <div id="app">
        @include('partial.admin.header')
        <div class="main-container ace-save-state" id="main-container">
            <script type="text/javascript">
                try{ace.settings.loadState('main-container')}catch(e){}
            </script>
            @include('partial.admin.sidebar')
            <div class="main-content">
                <div class="main-content-inner">
                    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                        <ul class="breadcrumb">
                            <li>
                                <i class="ace-icon fa fa-home home-icon"></i>
                                <a href="{{ route('admin.admins.index') }}">Home </a>
                            </li>

                            @if(Request::segment(1) == 'merchants' && Request::segment(2) == 'create')
                            <li>
                                <a href="{{ route('merchant.merchants.index') }}">
                                    Agent list                                    
                                </a>
                            </li>

                            <li>
                                Create new agent
                            </li>
                            @elseif(Request::segment(1) == 'merchants' && Request::segment(3) == 'edit')
                            <li>
                                <a href="{{ route('merchant.merchants.index') }}">
                                    Agent list
                                </a>
                            </li>

                            <li>
                                Agent details
                            </li>

                            @elseif(Request::segment(1) == 'merchants')
                            <li>
                                Agent list
                            </li>
                            @elseif(Request::segment(1) == 'pending_merchant')
                            <li>
                                Agent pending list
                            </li>
                            @elseif(Request::segment(1) == 'products' && Request::segment(2) == 'create')
                            <li>
                                <a href="{{ route('product.products.index') }}">
                                    Product list                                    
                                </a>
                            </li>
                            <li>
                                Create new product
                            </li>
                            @elseif(Request::segment(1) == 'products' && Request::segment(3) == 'edit')
                                <li>
                                <a href="{{ route('product.products.index') }}">
                                    Product list                                    
                                </a>
                            </li>
                            <li>
                                Product details
                            </li>
                            @elseif(Request::segment(1) == 'products')
                            <li>
                                Product list
                            </li>
                            @elseif(Request::segment(1) == 'point_malls' && Request::segment(2) == 'create')
                            <li>
                                <a href="{{ route('point_mall.point_malls.index') }}">
                                    Point mall list
                                </a>
                            </li>
                            <li>
                                Create new point product
                            </li>
                            @elseif(Request::segment(1) == 'point_malls' && Request::segment(3) == 'edit')
                            <li>
                                <a href="{{ route('point_mall.point_malls.index') }}">
                                    Point mall list
                                </a>
                            </li>
                            <li>
                                Point product details
                            </li>
                            @elseif(Request::segment(1) == 'point_malls')
                            <li>
                                Point mall list
                            </li>
                            @elseif(Request::segment(1) == 'categories' && Request::segment(2) == 'create')
                            <li>
                                <a href="{{ route('category.categories.index') }}">
                                    Category list
                                </a>
                            </li>
                            <li>
                                Create new category
                            </li>
                            @elseif(Request::segment(1) == 'categories' && Request::segment(3) == 'edit')
                            <li>
                                <a href="{{ route('category.categories.index') }}">
                                    Category list
                                </a>
                            </li>
                            <li>
                                Category details
                            </li>
                            @elseif(Request::segment(1) == 'categories')
                            <li>
                                Category list
                            </li>
                            @elseif(Request::segment(1) == 'brands' && Request::segment(2) == 'create')
                            <li>
                                <a href="{{ route('brand.brands.index') }}">
                                    Brand list
                                </a>
                            </li>
                            <li>
                                Create new brand
                            </li>
                            @elseif(Request::segment(1) == 'brands' && Request::segment(3) == 'edit')
                            <li>
                                <a href="{{ route('brand.brands.index') }}">
                                    Brand list
                                </a>
                            </li>
                            <li>
                                Create new brand
                            </li>
                            @elseif(Request::segment(1) == 'brands')
                            <li>
                                Brand list
                            </li>
                            @elseif(Request::segment(1) == 'promotions' && Request::segment(2) == 'create')
                            <li>
                                <a href="{{ route('promotion.promotions.index') }}">
                                    Promotion list
                                </a>
                            </li>
                            <li>
                                Create new promotion
                            </li>
                            @elseif(Request::segment(1) == 'promotions' && Request::segment(3) == 'edit')
                            <li>
                                <a href="{{ route('promotion.promotions.index') }}">
                                    Promotion list
                                </a>
                            </li>
                            <li>
                                Promotion details
                            </li>
                            @elseif(Request::segment(1) == 'promotions')
                            <li>
                                Promotion list
                            </li>
                            @elseif(Request::segment(1) == 'transactions')
                            <li>
                                Transaction list
                            </li>
                            @elseif(Request::segment(1) == 'transactions' && Request::segment(3) == 'edit')
                            <li>
                                <a href="{{ route('transaction.transactions.index') }}">
                                    Transaction list
                                </a>
                            </li>
                            <li>
                                Transaction details
                            </li>
                            @elseif(Request::segment(1) == 'withdrawal_list')
                            <li>
                                Withdrawal list
                            </li>
                            @elseif(Request::segment(1) == 'affiliates')
                            <li>
                                Affiliate list
                            </li>
                            @elseif(Request::segment(1) == 'setting_agent_level')
                            <li>
                                Setting Agent Level
                            </li>
                            @elseif(Request::segment(1) == 'setting_merchant_bonus')
                            <li>
                                Setting Agent Bonus
                            </li>
                            @elseif(Request::segment(1) == 'setting_agent_rebate')
                            <li>
                                Setting Agent Order Rebate
                            </li>
                            @elseif(Request::segment(1) == 'setting_merchant_commission')
                            <li>
                                Setting Affiliate Bonus
                            </li>
                            @elseif(Request::segment(1) == 'setting_performance_dividend')
                            <li>
                                Setting Performance Reward
                            </li>
                            @elseif(Request::segment(1) == 'setting_team_dividend')
                            <li>
                                Setting Team Reward
                            </li>
                            @elseif(Request::segment(1) == 'setting_recommend_bonus')
                            <li>
                                Setting Refferal Reward
                            </li>
                            @elseif(Request::segment(1) == 'setting_shipping_fee')
                            <li>
                                Setting Shipping Fee
                            </li>
                            @elseif(Request::segment(1) == 'admins')
                            <li>
                                Profile
                            </li>
                            @elseif(Request::segment(1) == 'dashboards')
                            <li>
                                Dashboard
                            </li>
                            @elseif(Request::segment(1) == 'sales_report')
                            <li>
                                Profit report
                            </li>
                            @elseif(Request::segment(1) == 'order_report')
                            <li>
                                Order report
                            </li>
                            @elseif(Request::segment(1) == 'commission_report')
                            <li>
                                Commission Report
                            </li>
                            @elseif(Request::segment(1) == 'tree')
                            <li>
                                Affliate List
                            </li>
                            @elseif(Request::segment(1) == 'tree_details')
                            <li>
                                <a href="{{ route('tree', Request::segment(2)) }}">
                                    Affliate list
                                </a>
                            </li>
                            <li>
                                @php
                                if(Request::segment(3) == '1'){
                                    echo "1st Generation";
                                }elseif(Request::segment(3) == '2'){
                                    echo "2nd Generation";
                                }else{
                                    echo "3th Generation";
                                }
                                @endphp
                            </li>
                            @endif
                        </ul>

                        <!-- <div class="nav-search" id="nav-search">
                            <form class="form-search">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div> -->
                    </div>
                    <div class="page-content">
                        <!-- <div class="ace-settings-container" id="ace-settings-container">
                            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                                <i class="ace-icon fa fa-cog bigger-130"></i>
                            </div>

                            <div class="ace-settings-box clearfix" id="ace-settings-box">
                                <div class="pull-left width-50">
                                    <div class="ace-settings-item">
                                        <div class="pull-left">
                                            <select id="skin-colorpicker" class="hide">
                                                <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                                <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                                <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                                <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                            </select>
                                        </div>
                                        <span>&nbsp; Choose Skin</span>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
                                        <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
                                        <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
                                        <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
                                        <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
                                        <label class="lbl" for="ace-settings-add-container">
                                            Inside
                                            <b>.container</b>
                                        </label>
                                    </div>
                                </div>

                                <div class="pull-left width-50">
                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
                                        <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
                                        <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                                    </div>

                                    <div class="ace-settings-item">
                                        <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
                                        <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                                    </div>
                                </div>
                            </div>
                        </div> --><!-- /.ace-settings-container -->
                        @yield('content')
                    </div>
                </div>
            </div>
            @include('partial.admin.footer')

<script src="{{ asset('assets/js/jquery-2.1.4.min.js') }}"></script>
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='{{ asset('assets/js/jquery.mobile.custom.min.js') }}'>"+"<"+"/script>");
</script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>
<!-- ace scripts -->
<script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
<script src="{{ asset('assets/js/ace.min.js') }}"></script>
<script src="{{ asset('assets/js/wizard.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-additional-methods.min.js') }}"></script>
<script src="{{ asset('assets/js/bootbox.js') }}"></script>
<script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="{{ asset('assets/js/tree.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.sparkline.index.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.flot.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.flot.pie.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.flot.resize.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

<link rel="stylesheet" href="{{ asset('assets/croppie/croppie.css') }}" />
<script src="{{ asset('assets/croppie/croppie.js') }}"></script>

<link href = "https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel = "stylesheet">

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script language=Javascript>
   function isNumberKey(evt)
   {
      var charCode = (evt.which) ? evt.which : evt.keyCode;
      if (charCode != 46 && charCode > 31 
        && (charCode < 48 || charCode > 57))
         return false;

      return true;
   }

    $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.date-picker').datepicker({
        autoclose: true,
        todayHighlight: true
    })

    $('.selectpicker').selectpicker();

    if(!ace.vars['old_ie']) $('.date-timepicker1').datetimepicker({
     //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
     icons: {
        time: 'fa fa-clock-o',
        date: 'fa fa-calendar',
        up: 'fa fa-chevron-up',
        down: 'fa fa-chevron-down',
        previous: 'fa fa-chevron-left',
        next: 'fa fa-chevron-right',
        today: 'fa fa-arrows ',
        clear: 'fa fa-trash',
        close: 'fa fa-times'
     }
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });
</script>
@toastr_js
@toastr_render
@yield('js')
</body>
</html>
