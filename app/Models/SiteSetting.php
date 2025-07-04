<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    /** @use HasFactory<\Database\Factories\SiteSettingFactory> */
    use HasFactory;

    protected $fillable = [
        'site_name', 'site_description', 'site_logo', 'site_favicon',
        'primary_color', 'secondary_color',
        'contact_phone', 'contact_email', 'contact_address',
        'social_facebook', 'social_instagram', 'social_linkedin',
        'social_youtube', 'social_whatsapp',
        'meta_title', 'meta_description', 'meta_image',
        'hero_title', 'hero_subtitle', 'hero_image',
        'about_title', 'about_content', 'about_image'
    ];
    
    protected $casts = [
        'about_content' => 'string',
    ];
    
    // Retorna a instância única (singleton)
    public static function firstOrNew()
    {
        return self::first() ?? new self();
    }
}
