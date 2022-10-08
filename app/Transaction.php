<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'guest_agent', 'transaction_no', 'user_id', 'discount_code', 'discount', 'processing_fee', 'tax', 'shipping_fee', 'grand_total', 
        'sub_total', 'address_name', 'address', 'postcode', 'city', 'state', 'phone', 'email', 'mall', 'bank_id', 'cdm_bank_id', 'bank_slip', 
        'bank_slip_no', 'bank_slip_date', 'status', 'completed', 'ad_discount',
        'customer_address', 'c_address_name', 'c_address', 'c_postcode', 'c_city', 'c_state', 'c_phone', 'c_email', 
        'parcel_number', 'order_number', 'courier', 'courier_logo', 'tracking_no', 'weight', 'awb_no', 'to_receive',
        'deduct_wallet', 'transaction_charges_type', 'transaction_charges_amount'
    ];
}
