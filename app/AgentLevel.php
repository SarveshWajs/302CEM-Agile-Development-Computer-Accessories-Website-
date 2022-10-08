<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentLevel extends Model
{
    protected $fillable = [
        'agent_lvl', 'product_id', 'buy_quantity', 'affiliate_quantity', 'status'
    ];
}
