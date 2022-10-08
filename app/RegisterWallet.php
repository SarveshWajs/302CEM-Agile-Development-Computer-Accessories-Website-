<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisterWallet extends Model
{
    protected $fillable = [
    	'user_id', 'amount', 'transfer_type', 'created_by', 'status'
    ];
}
