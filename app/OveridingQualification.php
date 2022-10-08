<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OveridingQualification extends Model
{
    protected $fillable = [
        'user_id', 'due_date', 'status'
    ];
}
