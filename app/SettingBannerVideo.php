<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SettingBannerVideo extends Model
{
    protected $fillable = [
        'video', 'status'
    ];
}