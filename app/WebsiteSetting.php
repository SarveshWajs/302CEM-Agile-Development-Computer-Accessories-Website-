<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    protected $fillable = [
        'company_registration_no', 'sst_registration_no', 'about_us', 'faqs', 'address', 'about_us_image','contact_us', 
        'contact_us_image', 'contact_whatsapp', 'privacy_policy_description', 'return_policy_description', 'mission_description',
        'vision_description', 'shipping_policy_description', 'join_us_description'
    ];
}
