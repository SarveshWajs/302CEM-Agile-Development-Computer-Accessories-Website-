<div class="bottom-menu-bar">
    <div class="row">
        <div class="col-3" align="center">
            <div class="top-menu-bar-box">
                <a href="{{ route('home') }}" style="">
                    <i style="font-size: 15px;" class="fa fa-home"></i>
                    <br>
                    <span class="">Home</span>            
                </a>
            </div>
        </div>

        <div class="col-3" align="center">
            <div class="top-menu-bar-box">
                <a href="{{ route('listing') }}" style="">
                    <i style="font-size: 15px;" class="fa fa-cubes"></i>
                    <br>
                    <span class="">Shop</span>
                </a>
            </div>
        </div>

        <div class="col-3" align="center">
            <div class="top-menu-bar-box">
                <a href="{{ route('checkout') }}" style="position: relative; ">
                    <i style="font-size: 15px;" class="fa fa-shopping-cart" aria-hidden="true"></i>
                    <br>
                    <span class="">Cart</span>
                    
                </a>
            </div>
        </div>

        <div class="col-3" align="center">
            <div class="top-menu-bar-box">
                <a href="{{ route('profile') }}" style="">
                    <i style="font-size: 15px;" class="fa fa-user"></i>
                    <br>
                    <span class="">Account</span>
                </a>
            </div>
        </div>
    </div>
</div>
@if(Request::segment(1) == 'Listing' || Request::segment(1) == 'Details' || Request::segment(1) == 'Cart' || Request::segment(1) == '' || Request::segment(1) == 'Checkout' || Request::segment(1) == 'login' || Request::segment(1) == 'About' || Request::segment(1) == 'Contact' || Request::segment(1) == 'register' || Request::segment(1) == 'merchant_register' || Request::segment(1) == 'faqs' || Request::segment(1) == 'verify_success' || Request::segment(1) == 'Blog' || 
Request::segment(1) == 'BlogDetail' || Request::segment(1) == 'TnC' || Request::segment(1) == 'ReturnPolicy' ||
Request::segment(1) == 'PrivacyPolicy' || Request::segment(1) == 'PrivacyPolicy' || Request::segment(1) == 'JoinUs' || Request::segment(1) == 'Gallery'|| Request::segment(1) == 'tree_view')
<footer class="bg-dark text-white">
<div class="container py-4">
  <div class="row py-5">
   <div class="col-md-4 mb-3 mb-md-0">
      <h6 class="text-uppercase mb-3">Social media</h6>
      <ul class="list-unstyled mb-0">
        @if(!empty($data['admin']->facebook))
        <li><a class="footer-link" href="{{ $data['admin']->facebook }}" target="_blank">Facebook</a></li>
        @endif
        @if(!empty($data['admin']->google))
        <li><a class="footer-link" href="{{ $data['admin']->google }}" target="_blank">Google</a></li>
        @endif
        @if(!empty($data['admin']->youtube))
        <li><a class="footer-link" href="{{ $data['admin']->youtube }}" target="_blank">Youtube</a></li>
        @endif
        @if(!empty($data['admin']->twitter))
        <li><a class="footer-link" href="{{ $data['admin']->twitter }}" target="_blank">Twitter</a></li>
        @endif
        @if(!empty($data['admin']->instagram))
        <li><a class="footer-link" href="{{ $data['admin']->instagram }}" target="_blank">Instagram</a></li>
        @endif
      </ul>
    </div>
    
    
  </div>
  <div class="border-top pt-4" style="border-color: #1d1d1d !important">
    <div class="row">
      <div class="col-lg-6">
        <p class="small text-muted mb-0">&copy; 2022 All rights reserved.</p>
      </div>
      <div class="col-lg-6 text-lg-right">
        <p class="small text-muted mb-0">Template designed by 
          <a class="text-white reset-anchor">
            SarveshWajs Design
          </a>
        </p>
      </div>
    </div>
  </div>
</div>
</footer>
@endif