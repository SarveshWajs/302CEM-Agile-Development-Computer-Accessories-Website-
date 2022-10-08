<div class="bottom-menu-bar">
    <div class="row">
        <div class="col-3" align="center">
            <div class="top-menu-bar-box">
                <a href="{{ route('home') }}">
                    <i class="fa fa-home fa-2x"></i>
                    <br>
                    <span class="">Home</span>            
                </a>
            </div>
        </div>

        <div class="col-3" align="center">
            <div class="top-menu-bar-box">
                <a href="{{ route('listing') }}">
                    <i class="fa fa-cubes fa-2x"></i>
                    <br>
                    <span class="">Shop</span>
                </a>
            </div>
        </div>

        <div class="col-3" align="center">
            <div class="top-menu-bar-box">
                <a href="{{ route('checkout') }}" style="position: relative;">
                    <i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i>
                    <br>
                    <span class="">Cart</span>
                    
                </a>
            </div>
        </div>

        <div class="col-3" align="center">
            <div class="top-menu-bar-box">
                <a href="{{ route('profile') }}">
                    <i class="fa fa-user fa-2x"></i>
                    <br>
                    <span class="">Account</span>
                </a>
            </div>
        </div>
    </div>
</div>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="{{ route('home') }}">
                            <h4 style="color: white;">{{ $data['website_name'] }}</h4>
                        </a>
                    </div>
                    <!-- <p>The customer is at the heart of our unique business model, which includes design.</p>
                    <a href="#"><img src="img/payment.png" alt=""></a> -->
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Menu</h6>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('listing') }}">
                                Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}">
                                About
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('faqs') }}">
                                FAQs
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-6">
                <div class="footer__widget">
                    <h6>Support</h6>
                    <ul>
                        <li><a href="{{ route('Contact') }}">Contact Us</a></li>
                        <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('return_policy') }}">Return Policy</a></li>
                        <li><a href="{{ route('tnc') }}">Term & Condition</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
                <div class="footer__widget">
                    <h6>Logistic</h6>
                    <div class="footer__newslatter">
                        <p>Place your tracking no here</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="TrackNo" placeholder="TrackNo" aria-label="TrackNo" aria-describedby="basic-addon2" maxlength="50">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="inputTrack()">
                                    TRACK
                                </button>
                            </div>
                        </div>

                        <script src="//www.tracking.my/track-button.js"></script>
                        <script>
                          function inputTrack() {
                            var num = document.getElementById("TrackNo").value;
                            if(num===""){
                              alert("Please enter tracking number");
                              return;
                            }
                            TrackButton.track({
                              tracking_no: num
                            });
                          }
                        </script>
                    </div>
                </div>
            </div>
        </div>
        <div class="" align="center">
            <a href="#" class="upgradeAgent" data-toggle="modal" data-target="#exampleModal">
                Upgrade to an agent? Join Us Now!
            </a>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upgrade to an agent</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="POST" action="{{ route('upgrade_agent_form') }}" id="topup-form" enctype="multipart/form-data">
                        @csrf
                            <div class="modal-body" align="left">
                                    <div class="form-group">
                                        <select class="form-control select-packages" name="selected_packages">
                                            <option value="">Select Topup Packages</option>
                                            @foreach($data['aff_topups'] as $aff_topup)
                                            @php
                                                $profit_bonus = 0;
                                                if(!empty($aff_topup->profit_amount)){
                                                    if($aff_topup->profit_type == 'Percentage'){
                                                        $profit_bonus = $aff_topup->topup_amount * $aff_topup->profit_amount / 100;
                                                    }else{
                                                        $profit_bonus = $aff_topup->profit_amount;
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $aff_topup->id }}">
                                                RM {{ number_format($aff_topup->topup_amount, 2) }} 
                                                @if($profit_bonus > 0)
                                                + (RM {{ number_format($profit_bonus, 2) }})
                                                @endif
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <br>
                                    <br>
                                    <hr>
                                    <div class="form-group payment-area">
                                        <h4>Top-up: RM 
                                            <span class="topup_amount_display">
                                                
                                            </span>
                                            <input type="hidden" class="topup_amount" name='topup_amount'>
                                        </h4>
                                        <div class="widget-box transparent" id="recent-box">
                                            <div class="widget-header">
                                              <h4 class="widget-title lighter smaller">
                                                <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Select a payment
                                              </h4>

                                              <div class="widget-toolbar no-border">
                                                <ul class="nav nav-tabs" id="recent-tab">
                                                  <li class="parent_payment_method active">
                                                    <a data-toggle="tab" class="payment_method f-15" data-id="1" href="#online-tab">Online Transfer</a>
                                                  </li>

                                                  <li class="parent_payment_method">
                                                    <a data-toggle="tab" class="payment_method f-15" data-id="2" href="#cdm-tab">Bank Transfer</a>
                                                  </li>
                                                </ul>
                                              </div>
                                              <input type="hidden" name="selected_payment_method" class="selected_payment_method" value="1">
                                            </div>

                                            <div class="widget-body">
                                              <div class="widget-main padding-4">
                                                <div class="tab-content padding-8">
                                                  <div id="online-tab" class="tab-pane active">
                                                    <div class="form-group">
                                                      <h4>Select Banks </h4>
                                                    </div>
                                                    <div class="form-group">
                                                      <div class="row">
                                                        
                                                        <div class="col-4" align="center">
                                                          <label>
                                                            <input type="radio" name="bank_id" value="1">
                                                            <img src="{{ url('images/banks/maybank.jpg') }}">
                                                          </label>
                                                        </div>
                                                        <div class="col-4" align="center">
                                                          <label>
                                                            <input type="radio" name="bank_id" value="2">
                                                            <img src="{{ url('images/banks/cimb.jpg') }}">
                                                          </label>
                                                        </div>
                                                        <div class="col-4" align="center">
                                                          <label>
                                                            <input type="radio" name="bank_id" value="4">
                                                            <img src="{{ url('images/banks/rhb.jpg') }}">
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                      <div class="row">
                                                        <div class="col-4" align="center">
                                                          <label>
                                                            <input type="radio" name="bank_id" value="5">
                                                            <img src="{{ url('images/banks/hongleong.jpg') }}">
                                                          </label>
                                                        </div>
                                                        <div class="col-4" align="center">
                                                          <label>
                                                            <input type="radio" name="bank_id" value="3">
                                                            <img src="{{ url('images/banks/pbe.jpg') }}">
                                                          </label>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <div class="form-group">
                                                      <b id="error-message-banks" class="important-text"></b>
                                                    </div>
                                                  </div>

                                                  <div id="cdm-tab" class="tab-pane" align="center">
                                                    <div class="form-group">
                                                      <input type="hidden" name="cdm_bank_id" value="10000743">
                                                      <div class="card border-danger mb-3" style="max-width: 18rem;" align="center">
                                                        <div class="card-body text-danger">
                                                            <h5 class="card-title">Bank Holder</h5>
                                                            <h5 class="card-title">Bank Name</h5>
                                                            <p class="card-text">Bank Account</p>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <div class="form-group bank_details">

                                                    </div>
                                                    <div class="form-group">
                                                      <input type="file" name="bank_slip" class="form-control upgrade_bank_slip" accept="image/*">
                                                    </div>
                                                  </div><!-- /.#member-tab -->
                                                </div>
                                              </div><!-- /.widget-main -->
                                            </div><!-- /.widget-body -->
                                          </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-primary upgrade-now-btn">Upgrade Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="footer__copyright__text">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    <p>Copyright ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        All rights reserved | This template is made by <a href="https://vesson.my" target="_blank">Vesson Web Design</a>
                    </p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </div>
            </div>
        </div>
    </div>
</footer>