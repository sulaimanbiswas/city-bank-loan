<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_link',
        'site_title',
        'description',
        'keywords',
        'site_name',
        'tiktok',
        'whatsapp',
        'youtube',
        'telegram',
    ];
}
