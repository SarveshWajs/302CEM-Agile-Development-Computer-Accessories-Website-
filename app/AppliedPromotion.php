<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AppliedPromotion extends Model
{
    protected $fillable = [
        'promotion_id', 'user_id', 'transaction_id', 'status'
    ];
}
