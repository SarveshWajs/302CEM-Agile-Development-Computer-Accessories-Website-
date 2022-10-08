@extends('layouts.admin_app')

@section('content')
<div class="page-header">
    <h1>
        Bank Details
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            {{ $payment_bank->title }}
        </small>
    </h1>
</div>
@if($errors->any())
  <div class="alert alert-danger">{!! implode('<br/>', $errors->all(':message')) !!}</div>
@endif
<form method="POST" action="{{ route('payment_bank.payment_banks.update', $payment_bank->id) }}" id="payment_banks-form" enctype="multipart/form-data">
@csrf
@method('PUT')
@include('backend.payment_banks.form')
</form>
<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">
		<a href="{{ route('payment_bank.payment_banks.index') }}" class="btn btn-default">
			<i class="fa fa-ban"> CANCEL</i>
		</a>

		<button class="btn btn-primary">
			<i class="fa fa-check"> SAVE CHANGES</i>
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