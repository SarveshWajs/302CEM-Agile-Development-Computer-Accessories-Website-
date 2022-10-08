@extends('layouts.admin_app')
@section('content')
<div class="page-header">
    <h1>
        Setting Charges
        <!-- <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            @if(Auth::check())
            {{ Auth::user()->f_name }} 
            @endif
        </small> -->
    </h1>
</div>
<form method="POST" action="{{ route('save_setting_charges') }}" id="setting-merchant-form">
    @csrf
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                 <label>Purchase Charges</label>
                 <div class="row">
                    <div class="col-md-6">
                        @php
                            $selectedptype = isset($setting_charges) ? $setting_charges->purchase_charges_amount : '';
                        @endphp
                        <select class="form-control" name="purchase_charges_type">
                            <option {{ ($selectedptype == 'Percentage') ? 'selected' : '' }} value="Percentage">Percentage</option>
                            <option {{ ($selectedptype == 'Amount') ? 'selected' : '' }} value="Amount">Amount</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="purchase_charges_amount" placeholder="Purchase Charges"
                               value="{{ isset($setting_charges) ? $setting_charges->purchase_charges_amount : '' }}">
                    </div>
                 </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Withdrawal Charges</label>
                <div class="row">
                    <div class="col-md-6">
                        @php
                            $selectedwtype = isset($setting_charges) ? $setting_charges->withdrawal_charges_type : '';
                        @endphp
                        <select class="form-control" name="withdrawal_charges_type">
                            <option {{ ($selectedptype == 'Percentage') ? 'selected' : '' }} value="Percentage">Percentage</option>
                            <option {{ ($selectedptype == 'Amount') ? 'selected' : '' }} value="Amount">Amount</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="withdrawal_charges_amount" placeholder="Withdrawal Charges"
                               value="{{ isset($setting_charges) ? $setting_charges->withdrawal_charges_amount : '' }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group">
                <label>Transfer Product Wallet Charges</label>
                <div class="row">
                    <div class="col-md-6">
                        @php
                            $selectedpwctype = isset($setting_charges) ? $setting_charges->transfer_wallet_charges_type : '';
                        @endphp
                        <select class="form-control" name="transfer_wallet_charges_type">
                            <option {{ ($selectedpwctype == 'Percentage') ? 'selected' : '' }} value="Percentage">Percentage</option>
                            <option {{ ($selectedpwctype == 'Amount') ? 'selected' : '' }} value="Amount">Amount</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="transfer_wallet_charges_amount" placeholder="Product Wallet Charges"
                               value="{{ isset($setting_charges) ? $setting_charges->transfer_wallet_charges_amount : '' }}">
                    </div>
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
        $('.loading-gif').show();
        $('#setting-merchant-form').submit();
    });
</script>
@endsection