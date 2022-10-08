@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting pickup address
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
<form method="POST" action="{{ route('save_setting_pick_up_address') }}" id="setting-merchant-form">
	@csrf
	<div class="form-group">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Company name <span class="important-text">*</span></label>
					<input type="text" name="company_name" class="form-control" placeholder="公司名称" value="{{ isset($select) ? $select->company_name : old('company_name') }}">
				</div>

				<div class="form-group">
					<label>Contact Person <span class="important-text">*</span></label>
					<input type="text" name="contact" class="form-control" placeholder="联络人" value="{{ isset($select) ? $select->contact : old('contact') }}"  onkeypress="return isNumberKey(event)">
				</div>

				<div class="form-group">
					<label>Address <span class="important-text">*</span></label>
					<textarea name="address" class="form-control" placeholder="地址">{!! isset($select) ? $select->address : old('address') !!}</textarea>
				</div>

				<div class="form-group">
					<label>Postcode <span class="important-text">*</span></label>
					<input type="text" name="postcode" class="form-control" placeholder="邮政编码" value="{{ isset($select) ? $select->postcode : old('postcode') }}"  onkeypress="return isNumberKey(event)">
				</div>

				<div class="form-group">
					<label>City <span class="important-text">*</span></label>
					<input type="text" name="city" class="form-control" placeholder="市" value="{{ isset($select) ? $select->city : old('city') }}">
				</div>
				@php
					$selectedValue = isset($select) ? $select->state : old('state');
				@endphp
				<div class="form-group">
					<label>State <span class="important-text">*</span></label>
					<select class="form-control" name="state">
						<option>Select State</option>
						@foreach($states as $state)
						<option {{ ($selectedValue == $state->id) ? 'selected' : '' }} value="{{ $state->id }}">{{ $state->name }}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>
</form>
<div class="submit-form-btn">
	<div class="form-group wizard-actions" align="right">

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
    	
    	$('#setting-merchant-form').submit();
    });
</script>
@endsection