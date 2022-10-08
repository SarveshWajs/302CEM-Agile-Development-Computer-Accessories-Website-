<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingCharge extends Model
{
    protected $fillable = [
        'purchase_charges_type', 'purchase_charges_amount', 'withdrawal_charges_type', 'withdrawal_charges_amount', 
        'transfer_wallet_charges_type', 'transfer_wallet_charges_amount', 'status'
    ];
}
