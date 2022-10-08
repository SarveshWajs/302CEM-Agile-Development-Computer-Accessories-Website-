<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
	protected $fillable = [
    	'dow', 'promotion_title', 'image', 'discount_code', 'amount_type', 'amount', 'quantity', 'limit_type', 'usage_limit', 'products', 'start_date', 'end_date', 'status'
    ];
}
