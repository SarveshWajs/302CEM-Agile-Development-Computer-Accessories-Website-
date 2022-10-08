@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Create New Member
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
@if($errors->any())
  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
@endif
<form method="POST" action="{{ route('member.members.store') }}" id="agent-form" enctype="multipart/form-data">
@csrf
@include('backend.members.form')
</form>

<div class="submit-form-btn">
    <div class="form-group wizard-actions" align="right">
        <a href="{{ route('member.members.index') }}" class="btn btn-default">
            <i class="fa fa-ban"> Cancel</i>
        </a>

        <button class="btn btn-primary">
            <i class="fa fa-check"> Save Changes</i>
        </button>

    </div>
</div>

@endsection

@section('js')
<script type="text/javascript">


    $('#agent-form .required-field').change( function(){
        if($(this).val()){
            $(this).removeClass('required-feild-error');
        }
    });

    $('.submit-form-btn .btn-primary').click( function(e){
       e.preventDefault();
       $('.loading-gif').show();
       $('#agent-form').submit();

       var phone = $('input[name="phone"]').val();
       var code = $('input[name="code"]').val();
       var empty_fill = 0;
       $('#agent-form .required-field').each( function(){
            if(!$(this).val()){
                $(this).addClass('required-feild-error');
                empty_fill = 1;
            }
        });

       if(empty_fill == 1){
          $('.loading-gif').hide();
          return false;
       }

       if(!phone){
            $('#action-return-message').addClass('important-text');
            $('#action-return-message').html("Please fill in phone number");
            $('.loading-gif').hide();
            return false;
       }else{
          // if(phone.length < 10){
          //       $('#action-return-message').addClass('important-text');
          //       $('#action-return-message').html("Please fill in valid phone number");
          //       return false;
          // }
       }

       if(!code){
            $('#action-return-message').addClass('important-text');
            $('#action-return-message').html("Please fill in valid verification code");
            $('.loading-gif').hide();
            return false;
       }

       var fd = new FormData();
       fd.append('phone', phone);
       fd.append('code', code);
       fd.append('country_code', '1');

       

        
    });

    $('.agent_type').change( function(){
        var ele = $(this);

        if(ele.val() == '1'){
          // $('input[name="agent_pno"]').attr('readonly');
          $('input[name="agent_pno"]').val('');
          $('input[name="agent_pno"]').prop('readonly', true);
        }else{
          // $('input[name="agent_pno"]').removeAttr('readonly');
          $('input[name="agent_pno"]').prop('readonly', false);
        }
    });
</script>

@endsection