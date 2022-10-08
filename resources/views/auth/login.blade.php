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
</style>
@endsection
@section('content')
<div class="container">
    <div class="profile-content">
        <div class="container-box">
            <form method="POST" action="{{ route('login') }}" id="login-form">
                @csrf
                <h3 align="center" class="header-login" style="color: #000;">
                    LOGIN
                </h3>
                <br>
                
                <div class="form-group login-page">
                    <div class="form-group">
                        @if($errors->any())
                          <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="email" class="form-control"  placeholder="Email" name="email">
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control"  placeholder="Password" name="password">
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
                        <label>
                            <input name="remember" type="checkbox" class="ace" />
                            <span class="lbl"> Remember me</span>
                        </label>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary btn-block login-submit-button login-btn">
                            SIGN IN
                        </button>
                    </div>

                    <!-- <div class="form-group">
                        <a href="{{ url('/auth/redirect/facebook') }}" class="btn btn-primary btn-block facebook-login-button">
                            <i class="fa fa-facebook-square"></i> FACEBOOK
                        </a>
                    </div> -->

                    <div class="form-group" align="center">
                        <a href="{{ route('register') }}">Create an account</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
@endsection
@section('js')
<script type="text/javascript">
    $('.button-inside').on('click', '.get-verify-code-btn', function(e){
        e.preventDefault();
        $('.loading-gif').show();
        var ele = $(this);
        var phone = $('input[name="phone"]').val();
        if(phone.length < 10){
            alert("Please enter a valid mobile phone number");
            $('.loading-gif').hide();
            return false;
        }

        var fd = new FormData();
        fd.append('phone', phone);

        $.ajax({
            url: '{{ route("getVerifyCode") }}',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                // alert(response);
                // return false;
                if(response == '1'){
                    alert('Phone number does not exist');
                    $('.loading-gif').hide();
                    return false;
                }else{
                    $('.loading-gif').hide();
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
                                ele.html("Get Verfiy Code");
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


    $('.login-btn').click( function(e){
       e.preventDefault();
       $('#login-form').submit();
       // $('.loading-gif').show();
       // // $('input[name="password"]').val(phone);
       // // $('#login-form').submit();
       // var phone = $('input[name="phone"]').val();
       // var code = $('input[name="code"]').val();
       // var country_code = $('.country_code').val();

       // if(!phone){
       //      $('#action-return-message').addClass('important-text');
       //      $('#action-return-message').html("Please enter phone number");
       //      $('.loading-gif').hide();
       //      return false;
       // }else{
       //    if(phone.length < 10){
       //          $('#action-return-message').addClass('important-text');
       //          $('#action-return-message').html("Please enter a valid mobile phone number");
       //          $('.loading-gif').hide();
       //          return false;
       //    }
       // }

       // if(!code){
       //      $('#action-return-message').addClass('important-text');
       //      $('#action-return-message').html("Please enter a valid verification code");
       //      $('.loading-gif').hide();
       //      return false;
       // }



       // var fd = new FormData();
       // fd.append('phone', phone);
       // fd.append('code', code);
       // fd.append('country_code', country_code);

       // $.ajax({
       //      url: '{{ route("CheckLogin") }}',
       //      type: 'post',
       //      data: fd,
       //      contentType: false,
       //      processData: false,
       //      success: function(response){
       //          // alert(response);
       //          if(response == 1){
       //              $('#action-return-message').html("Verification code error");
       //              $('#action-return-message').addClass('important-text');
       //              $('.loading-gif').hide();
       //              return false;
       //          }else if(response == 2){
       //              $('#action-return-message').html("Phone number does not exist");
       //              $('#action-return-message').addClass('important-text');
       //              $('.loading-gif').hide();
       //          }else{
       //              // $('input[name="password"]').val(phone);
       //              $('#login-form').submit();
       //          }
       //      },
       //  }); 
    });
</script>
@endsection