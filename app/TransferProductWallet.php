<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferProductWallet extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'actual_amount', 'charges_type', 'charges_amount', 'status'
    ];
}
