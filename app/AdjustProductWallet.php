<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdjustProductWallet extends Model
{
    protected $fillable = [
        'user_id', 'type', 'amount', 'remark', 'status', 'created_by', 'updated_by'
    ];
}
