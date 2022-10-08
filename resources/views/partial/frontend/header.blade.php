<!-- Humberger Begin -->
@if(Request::segment(1) == 'Listing' || Request::segment(1) == 'Details' || Request::segment(1) == 'Cart' || Request::segment(1) == '' || Request::segment(1) == 'Checkout' || Request::segment(1) == 'login' || Request::segment(1) == 'About' || Request::segment(1) == 'Contact' || Request::segment(1) == 'register' || Request::segment(1) == 'merchant_register' || Request::segment(1) == 'faqs' || Request::segment(1) == 'verify_success' || Request::segment(1) == 'Blog' || 
Request::segment(1) == 'BlogDetail' || Request::segment(1) == 'TnC' || Request::segment(1) == 'ReturnPolicy' ||
Request::segment(1) == 'PrivacyPolicy' || Request::segment(1) == 'PrivacyPolicy' || Request::segment(1) == 'JoinUs' || Request::segment(1) == 'Gallery' || Request::segment(1) == 'tree_view') 
<style>
.dropbtn {
  background-color:transparent;
  color: black;
  font-size: 16px;
  border: none;
}



.dropdown-content {
  display: none;
  position: absolute;
  background-color: white;
  min-width: 140px;
  border-radius: 10px 10px 10px 10px;
  border: 1px solid rgba(0,0,0,.15);
  border: 1px solid #ccc;
 z-index: 160

}

.dropdown-content a {
  color: black;
  padding: 1.5px;
  text-decoration: none;
  display: block;
  border-radius: 10px 10px 10px 10px;
}

.dropdown-content a:hover {background-color:  #d1d1e0;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: transparent;}
</style>
<div class="sticky">
<header class="header bg-white" style="box-shadow: 5px 5px 5px grey;">
    <div class="container px-0 px-lg-3">
        <nav class="navbar navbar-expand-lg navbar-light py-3 px-lg-0">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="font-weight-bold text-uppercase text-dark">
                    @if(!empty($data['website_logo']))
                        <img src="{{ url($data['website_logo']) }}" width="130px">
                    @endif
                    {{ $data['website_name'] }}
                </span>
            </a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item" style="text-align: center;">
              <i class="fa fa-home"></i>
              <a class="nav-link {{ (Request::segment(1) == '') ? 'active' : '' }}" href="{{ route('home') }}">
                Home
              </a>
            </li>
            <li class="nav-item" style="text-align: center;">
               <div class="dropdown">
              <i class="fa fa-shopping-basket"></i>
              <a class="nav-link  {{ (Request::segment(1) == 'Listing') ? 'active' : '' }}" href="{{ route('listing') }}">
                Products
              </a>
  <div class="dropdown-content">
     @foreach($data['brands'] as $topBrand)
                        
                            
        <a href="{{ route('listing', ['brand='.urlencode($topBrand->brand_name),
                                      'category='.request('category'),
                                      'from='.request('from'),
                                      'to='.request('to'),
                                      'result='.request('result')]) }}">
            <div class="row">
                <div class="col-12">
                    <span>{{ $topBrand->brand_name }}</span>
                </div>
            </div>
        </a>
      @endforeach
  </div>
</div>
            </li>
            <li class="nav-item" style="text-align: center;">
              <i class="fa fa-building"></i>
              <a class="nav-link  {{ (Request::segment(1) == 'About') ? 'active' : '' }}" href="{{ route('about') }}">
                About
              </a>
            </li>
            <li class="nav-item" style="text-align: center;">
              <i class="fa fa-question-circle"></i>
              <a class="nav-link  {{ (Request::segment(1) == 'faqs') ? 'active' : '' }}" href="{{ route('faqs') }}">
                FAQs
              </a>
            </li>
            <li class="nav-item" style="text-align: center;">
              <i class="fa fa-address-book"></i>
              <a class="nav-link  {{ (Request::segment(1) == 'Contact') ? 'active' : '' }}" href="{{ route('Contact') }}">
                Contact
              </a>
            </li>
           <!-- <li class="nav-item" style="text-align: center;">
              <i class="fa fa-calendar"></i>
              <a class="nav-link {{ (Request::segment(1) == 'Event') ? 'active' : '' }}" href="{{ route('blogs') }}">
                Event
              </a>
            </li>-->
            <li class="nav-item" style="text-align: center;">
           
             
          </ul>
          <ul class="navbar-nav ml-auto">               
            <li class="nav-item">
              <a class="nav-link" href="{{ route('checkout') }}"> 
                <i class="fas fa-dolly-flatbed mr-1 text-gray"></i>
                Cart
                <small class="text-gray">
                  (<span class="count-cart">{{ !empty($data['totalCart']) ? $data['totalCart'] : '0' }}</span>)
                </small>
              </a>
            </li>
            <li class="nav-item">
              @if(Auth::guard($data['userGuardRole'])->check())
                <a class="nav-link" href="{{ route('profile') }}">
                  <i class="fas fa-user-alt mr-1 text-gray"></i>
                  My Account
                </a>
              @else
                <a class="nav-link" href="{{ route('login') }}">
                  <i class="fas fa-user-alt mr-1 text-gray"></i>
                  Login / Register
                </a>
              @endif
            </li>
          </ul>
        </div>
      </nav>
    </div>
</header>
</div>

@endif