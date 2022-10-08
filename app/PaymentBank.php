<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentBank extends Model
{
    protected $fillable = [
        'bank_name', 'status'
    ];
}
