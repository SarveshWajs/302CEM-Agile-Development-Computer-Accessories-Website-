<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingMerchantRebate extends Model
{
    protected $fillable = [
        'agent_lvl', 'type', 'amount', 'personal_sale', 'line_group_sale', 'status'
    ];
}
