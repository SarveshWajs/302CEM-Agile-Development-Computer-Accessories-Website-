<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id', 'product_id', 'sub_category_id', 'second_sub_category_id', 'qty', 'status'
    ];
}
