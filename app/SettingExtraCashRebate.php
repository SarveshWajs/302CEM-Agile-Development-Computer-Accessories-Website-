<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingExtraCashRebate extends Model
{
    protected $fillable = [
        'agent_lvl', 'type', 'amount', 'status'
    ];
}
