<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TenantSetting extends Model
{
    /** @use HasFactory<\Database\Factories\TenantSettingFactory> */
    use HasFactory;

    protected $fillable = [
        'configurable_id',
        'configurable_type',
        'site_name',
        'site_description',
        'site_logo',
        'site_favicon',
        'primary_color',
        'secondary_color',
        'text_color',
        'header_display_type',
        'contact_phone',
        'contact_email',
        'contact_address',
        'social_facebook',
        'social_instagram',
        'social_linkedin',
        'social_youtube',
        'social_whatsapp',
        'meta_title',
        'meta_description',
        'meta_image',
        'about_title',
        'about_content',
        'about_image',
        'about_features',
        'engagement_title',
        'engagement_description',
        'engagement_metrics',
        'engagement_btn_properties_text',
        'engagement_btn_properties_icon',
        'engagement_btn_properties_link',
        'engagement_btn_contact_text',
        'engagement_btn_contact_icon',
        'engagement_btn_contact_link',
        'hero_background_type',
        'hero_gradient_direction',
        'hero_gradient_from_color',
        'hero_gradient_to_color',
        'hero_image_url',
        'hero_image_alt_text',
        'hero_image_class',
        'hero_show_text_content',
        'hero_title',
        'hero_description',
        'hero_clients_satisfied_text',
        'hero_avatars',
        'hero_stars_rating',
        'hero_form_title',
        'hero_select_options',
        'hero_search_button_text',
        'hero_search_button_icon',
    ];

    protected $casts = [
        'about_features' => 'array',
        'engagement_metrics' => 'array',
        'hero_avatars' => 'array',
        'hero_select_options' => 'array',
        'hero_show_text_content' => 'boolean',
        'hero_stars_rating' => 'float',
    ];

    // Define a relação polimórfica para saber a qual "tenant" estas configurações pertencem
    public function configurable(): MorphTo // Adicione esta relação
    {
        return $this->morphTo();
    }
}
