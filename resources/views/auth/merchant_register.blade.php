@extends('layouts.app')
@section('css')
<style type="text/css">
    .cat_menu_container ul {
        display: block;
        position: absolute;
        top: 100%;
        left: 0;
        visibility: hidden;
        opacity: 0;
        min-width: 100%;
        background: #FFFFFF;
        box-shadow: 0px 10px 25px rgba(0,0,0,0.1);
        -webkit-transition: opacity 0.3s ease;
        -moz-transition: opacity 0.3s ease;
        -ms-transition: opacity 0.3s ease;
        -o-transition: opacity 0.3s ease;
        transition: all 0.3s ease;
    }
    .cat_menu_container:hover .cat_menu {
        visibility: visible;
        opacity: 1;
    }

    .select2-container{
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single{
        padding: 5px;
        height: 39px;
    }

    .nice-select{
        display: none;
    }
</style>
@endsection
@section('content')
<div class="container">
    <div class="profile-content">
        <div class="container-box">
            <form method="POST" action="{{ route('register') }}"  id="register-form" enctype="multipart/form-data">
                @csrf
                <h3 align="center" class="header-login">CREATE AGENT ACCOUNT</h3>
                <br>
                @if(!empty($pcs->id))
                    <h4>Topup Pacakages: RM {{ number_format($pcs->topup_amount, 2) }}</h4>
                @endif
                <div class="register-page merchant">
                    <div class="form-group">
                        @if($errors->any())
                          <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
                        @endif
                        <input type="hidden" name="role" value="2">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control required-feild" placeholder="Full Name" name="f_name" value="{{ old('f_name') }}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control required-feild" placeholder="E-Shop Name" name="e_shop_name" value="{{ old('e_shop_name') }}">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control required-feild" placeholder="IC No." name="ic" value="{{ old('ic') }}" onkeypress="return isNumberKey(event)">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control required-feild" name="address" placeholder="Address">{{ old('address') }}</textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control required-feild" placeholder="Email" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <select class="form-control select2 country_code" name="country_code" id="country_code" data-live-search="true">
                                    <!-- @foreach($countries as $country)
                                    <option value="{{ $country->country_contact }}">(+{{ $country->country_contact }}) {{ $country->country_name }} </option>
                                    @endforeach -->
                                    <option value="60">(+60) Malaysia</option>
                                    <option value="65">(+65) Singapore</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control required-feild" placeholder="Example: 0171234567" name="phone" value="{{ old('phone') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control required-feild"  placeholder="Password" name="password">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control required-feild"  placeholder="Confirm Password" name="password_confirmation">
                    </div>

                    <!-- <div class="form-group">
                        <div class="form-group">
                            <div class="button-inside">
                                <input type="text" class="form-control" name="code" placeholder="Verify code">
                                <a href="#" class="btn btn-sm btn-primary get-verify-code-btn">
                                    Get Verify Code
                                </a>
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group">
                        <div id="action-return-message" style="color: red;"></div>
                    </div>

                    @if(!empty(request('p')))
                        <div class="form-control" style="background-color: gray;">
                            {{ request('p') }}
                            <input type="hidden" name="master_id" value="{{ request('p') }}">
                        </div>
                    @else
                        <div class="form-group">
                            <select class="form-control select2" id="refferal_id" data-live-search="true" name="master_id">
                                <option value="">Select refferal code</option>
                                @foreach($merchants as $merchant)
                                <option {{ request('p') == $merchant->code ? 'selected' : '' }} value="{{ $merchant->code }}">{{ $merchant->code }} ({{ $merchant->f_name }} {{ $merchant->l_name }})</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    
                    <div class="form-group" style="font-size: 10px;">
                        By signing up, I agree to the {{ $data['admin']->website_name }}'s Privacy Policy.
                    </div>
                    <div class="form-group">
                        @if(!empty($pcs->id))
                            <button class="btn btn-primary btn-block register-btn">
                                Next Step
                            </button>
                        @else
                            <button class="btn btn-primary btn-block register-btn" type="button">
                                Sign up
                            </button>
                        @endif
                    </div>

                    <!-- <div class="form-group">
                        <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-primary btn-block facebook-login-button">
                            <i class="fa fa-facebook-square"></i> CONTINUE WITH FACEBOOK
                        </a>
                    </div> -->

                    <div class="form-group" align="center">
                        Already Have an account? <a href="{{ route('login') }}">Login</a>
                    </div>

                    <div class="form-group" align="center">
                        MEMBER ACCOUNT? <a href="{{ route('register') }}">Register as Member</a>
                    </div>
                </div>
                @if(!empty($pcs->id))
                <div class="modal fade" id="register-payment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-body">
                          <h4>Top-up: RM {{ $pcs->topup_amount }}</h4>
                          <input type="hidden" name="topup_id" value="{{ $pcs->id }}">
                          <hr>
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
                                      <input type="file" name="bank_slip" class="form-control" accept="image/*">
                                    </div>
                                  </div><!-- /.#member-tab -->
                                </div>
                              </div><!-- /.widget-main -->
                            </div><!-- /.widget-body -->
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary">
                            Pay & Register
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
<br>

@endsection
@section('js')
<script type="text/javascript">
    $('#refferal_id').select2({
        placeholder: "Select Refferal ID",
        allowClear: true
    });

    $('#country_code').select2({
        placeholder: "Select Country Code",
        allowClear: true
    });


    $('.button-inside').on('click', '.get-verify-code-btn', function(e){
        e.preventDefault();
        var ele = $(this);
        var phone = $('input[name="phone"]').val();
        var country_code = $('.country_code').val();
        if(phone.length < 10){
            alert("Please enter a valid mobile phone number");
            return false;
        }

        var fd = new FormData();
        fd.append('phone', phone);
        fd.append('country_code', country_code);
        fd.append('register', '1');

        $.ajax({
            url: '{{ route("getVerifyCode") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response == '1'){
                    alert('Phone number does not exist');
                    return false;
                }else{
                    ele.prop('disabled', true);
                    
                    $('#action-return-message').html('The verification code has been sent to your mobile phone, the input is valid within 10 minutes, please do not leak');

                    $('#action-return-message').addClass('important-text');

                    var timer2 = response[1];
                    // var timer2 = "0:03";
                    var interval = setInterval(function() {


                    var timer = timer2.split(':');
                    //by parsing integer, I avoid all extra string processing
                    var minutes = parseInt(timer[0], 10);
                    var seconds = parseInt(timer[1], 10);
                    --seconds;
                    minutes = (seconds < 0) ? --minutes : minutes;
                    seconds = (seconds < 0) ? 59 : seconds;
                    seconds = (seconds < 10) ? '0' + seconds : seconds;
                    //minutes = (minutes < 10) ?  minutes : minutes;
                    if (minutes == '0' && seconds == '00'){
                        clearInterval(interval);
                        var fd = new FormData();
                        fd.append('phone', phone);
                        $.ajax({
                            url: '{{ route("resetVerifyCode") }}',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            success: function(response){
                                ele.html("Get Verify Code");
                                ele.prop('disabled', false);
                                $('#action-return-message').html('The verification code has been refreshed! Please click "Get Verification Code" to get the latest verification code!');
                            }
                        });
                    }

                    ele.html(minutes + ':' + seconds);

                    timer2 = minutes + ':' + seconds;
                    }, 1000);                            
                }
            },
        });
    });

    $('#register-form .required-feild').change( function(){
        if($(this).val()){
            $(this).removeClass('required-feild-error');
        }
    });

    $('.register-btn').click( function(e){
       e.preventDefault();

       var e_shop_name = $('input[name="e_shop_name"]').val();

        var fd = new FormData();
        fd.append('e_shop_name',e_shop_name);

        $.ajax({
            url: '{{ route("updateEShopName") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response == '1'){
                    toastr.error('E Shop Name is similar to active users.');
                    return false;
                }else{
                    $("#register-payment").modal('show');
                    // $('#register-payment').modal({backdrop: 'static', keyboard: false});
                }
            }
    });

       // $('input[name="password"]').val(phone);
       var pcs = '{{ $pcs->id }}';
       if(!pcs){
            $('#register-form').submit();
       }
       // var empty_fill;
       // var phone = $('input[name="phone"]').val();
       // var code = $('input[name="code"]').val();
       // var country_code = $('.country_code').val();
       // var refferal_code = $('input[name="refferal_code"]').val();

       // $('#register-form .required-feild').each( function(){
       //      if(!$(this).val()){
       //          $(this).addClass('required-feild-error');
       //          empty_fill = 1;
       //      }
       //  });
       //  if(empty_fill == 1){
       //      $('#action-return-message').html('Please Fill In All Required Field.');
       //      $('.loading-gif').hide();
       //      return false;
       //  }

       // if(!phone){
       //      $('#action-return-message').addClass('important-text');
       //      $('#action-return-message').html("Please enter phone number");
       //      return false;
       // }else{
       //    if(phone.length < 9){
       //          $('#action-return-message').addClass('important-text');
       //          $('#action-return-message').html("Please enter a valid mobile phone number");
       //          return false;
       //    }
       // }


       // $('#action-return-message').html('');
    });

    $('.payment_method').click(function(e){
      var ele = $(this);
      var id = ele.data('id');
      $('.parent_payment_method').removeClass('active');
      ele.parent().addClass('active');
      $('.selected_payment_method').val(id);

    });

</script>
@endsection