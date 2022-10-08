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
            <form method="POST" action="{{ route('register') }}" id="register-form">
                @csrf
                <h3 align="center" class="header-login">CREATE ACCOUNT</h3>
                <br>
                <div class="register-page">
                    <div class="form-group">
                        @if($errors->any())
                          <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
                        @endif
                        <input type="hidden" name="role" value="1">
                    </div>
                    
		    <div class="form-group">
                        <input type="text" class="form-control required-feild" placeholder="Full Name" name="f_name" value="{{ old('f_name') }}">
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
                                <input type="text" class="form-control" placeholder="Example: 0171234567" name="phone" value="{{ old('phone') }}"  onkeypress="return isNumberKey(event)">
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
                        <div id="action-return-message"></div>
                    </div>


                    <div class="form-group">
                        <b id="error-message" class="important-text error-message"></b>
                    </div>
                    
                    <div class="form-group" style="font-size: 10px;">
                        By signing up, I agree to the {{ $data['admin']->website_name }}'s Privacy Policy.
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block login-submit-button register-btn">
                            SIGN UP
                        </button>
                    </div>

                    <!-- <div class="form-group">
                        <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-primary btn-block facebook-login-button">
                            <i class="fa fa-facebook-square"></i> CONTINUE WITH FACEBOOK
                        </a>
                    </div> -->

                    <div class="form-group" align="center">
                        Already Have an account? <a href="{{ route('login') }}">Login</a>
                    </div>

                    <!-- <div class="form-group" align="center">
                        Be an agent? <a href="{{ route('merchant_register') }}">Register as Agent</a>
                    </div> -->
                </div>
            </form>
        </div>
    </div>
</div>
<br>
@endsection

@section('js')
<script type="text/javascript">
   

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

        var ele = $(this);
        var master_id = $('input[name="master_id"]').val();

        var fd = new FormData();
        fd.append('master_id', master_id);

        $.ajax({
            url: '{{ route("checkRefferalCode") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
              // alert (response);
              // return false;
              
                $('#register-form').submit();
              }
            }
          });

       // $('input[name="password"]').val(phone);
       // $('#register-form').submit();
       // var empty_fill;
       // var phone = $('input[name="phone"]').val();
       // var code = $('input[name="code"]').val();
       // var country_code = $('.country_code').val();
       // // var refferal_code = $('input[name="refferal_code"]').val();

       // $('#register-form .required-feild').each( function(){
       //      if(!$(this).val()){
       //          $(this).addClass('required-feild-error');
       //          empty_fill = 1;
       //      }
       //  });
       //  if(empty_fill == 1){
       //      $('.error-message').html('Please Fill In All Required Field.');
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

       // if(!code){
       //      $('#action-return-message').addClass('important-text');
       //      $('#action-return-message').html("Please enter a valid verification code");

       //      return false;
       // }



       // var fd = new FormData();
       // fd.append('phone', phone);
       // fd.append('code', code);
       // fd.append('country_code', country_code);
       // // fd.append('refferal_code', refferal_code);

       // $.ajax({
       //      url: '{{ route("CheckLogin") }}',
       //      type: 'post',
       //      data: fd,
       //      contentType: false,
       //      processData: false,
       //      success: function(response){
       //          if(response == 1){
       //              $('#action-return-message').html("Verification code error");
       //              $('#action-return-message').addClass('important-text');
       //              return false;
       //          }else if(response == 2){
       //              // $('input[name="password"]').val(phone);
       //              $('#register-form').submit();
       //          }else if(response == 3){
       //              $('#action-return-message').html("Account exists");
       //              $('#action-return-message').addClass('important-text');
       //          }else if(response == 4){
       //              $('#action-return-message').html("Referrer's mobile phone number does not exist");
       //              $('#action-return-message').addClass('important-text');
       //          }else{
       //              $('#action-return-message').html("System error");
       //              $('#action-return-message').addClass('important-text');
       //          }
       //      },
       //  }); 
    });
</script>
@endsection