@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Create New Bank 
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
        </small> -->
    </h1>
</div>
@if($errors->any())
  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
@endif
<form method="POST" action="{{ route('payment_bank.payment_banks.store') }}" id="payment_banks-form" enctype="multipart/form-data">
@csrf
@include('backend.payment_banks.form')
</form>


<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<a href="{{ route('payment_bank.payment_banks.index') }}" class="btn btn-default">
			<i class="fa fa-ban"> CANCEL</i>
		</a>

		<button class="btn btn-primary">
			<i class="fa fa-check"> CREATE</i>
		</button>

	</div>
</div>

@endsection

@section('js')
<script type="text/javascript">
	$('.submit-form-btn .btn-primary').click( function(e){
    	e.preventDefault();
    	
    	$('#payment_banks-form').submit();
    });
</script>
@endsection