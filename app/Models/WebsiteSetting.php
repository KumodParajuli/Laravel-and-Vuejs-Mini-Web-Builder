<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    // use HasFactory;
    protected $fillable = ['site_title', 'homepage_id', 'footer_content'];

}
