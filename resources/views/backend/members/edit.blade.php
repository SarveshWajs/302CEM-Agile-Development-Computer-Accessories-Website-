@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Member Details
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            {{ $user->f_name }} {{ $user->l_name }}
        </small>
    </h1>
</div>
@if($errors->any())
  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
@endif
<form method="POST" action="{{ route('member.members.update', $user->id) }}" id="agent-form" enctype="multipart/form-data">
@csrf
@method('PUT')
@include('backend.members.form')
</form>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <h3>&nbsp;&nbsp;&nbsp;<i class="fa fa-key"></i> Change New Password</h3>
      <hr>
      <form method="POST" action="{{ route('saveMemberNewPassword', [$user->id]) }}" id="change_password-form">
        @csrf
        <div class="modal-body">
              <div class="form-group">
                  <label>New Password</label>
                  <input type="text" name="new_password" class="form-control">
              </div>
              <div class="form-group">
                  <label>Confirm Password</label>
                  <input type="text" name="password_confirmation" class="form-control">
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary save-password">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<a href="{{ route('merchant.merchants.index') }}" class="btn btn-default">
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
    $('.submit-form-btn .btn-primary').click( function(e){
    	e.preventDefault();
    	$('.loading-gif').show();
    	$('#agent-form').submit();
    });

    $('.save-password').click( function(e){
        e.preventDefault();

        var new_password = $('input[name="new_password"]').val();
        var con_password = $('input[name="password_confirmation"]').val();

        if(new_password == con_password){
            
            $('#change_password-form').submit();
        }else{
            alert('Password Not Match');
            return false;
        }
    });
</script>

@endsection