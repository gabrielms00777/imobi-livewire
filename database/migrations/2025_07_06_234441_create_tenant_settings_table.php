<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tenant_settings', function (Blueprint $table) {
            $table->id();

            // Relação polimórfica: tenant pode ser uma Company ou um User
            $table->morphs('configurable'); // Isso cria configurable_id (INT) e configurable_type (STRING)

            // General Site Settings
            $table->string('site_name')->default('Imobiliária Padrão'); // Default name
            $table->string('site_description')->nullable();
            $table->string('site_logo')->nullable(); // URL to logo image
            $table->string('site_favicon')->nullable(); // URL to favicon
            $table->string('primary_color')->default('#422ad5'); // Default primary color
            $table->string('secondary_color')->default('#f43098'); // Default secondary color
            $table->string('text_color')->default('#0b0809'); // Default text color
            $table->enum('header_display_type', ['logo_only', 'name_only', 'logo_and_name'])->default('logo_only'); // For header logo/name display

            // Contact Information
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_address')->nullable(); // Changed to string, text is usually for larger blocks

            // Social Media Links (can be simplified if dynamic, or kept as separate columns)
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_linkedin')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_whatsapp')->nullable();

            // SEO Settings
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_image')->nullable(); // URL to social share image

            // --- Homepage Sections Configuration ---

            // About Section
            $table->string('about_title')->nullable();
            $table->text('about_content')->nullable();
            $table->string('about_image')->nullable();
            $table->json('about_features')->nullable(); // Storing array of features as JSON

            // Metrics/Engagement Section (previous 'sectionContent')
            $table->string('engagement_title')->nullable();
            $table->text('engagement_description')->nullable();
            $table->json('engagement_metrics')->nullable(); // Storing array of metrics as JSON
            $table->string('engagement_btn_properties_text')->nullable();
            $table->string('engagement_btn_properties_icon')->nullable();
            $table->string('engagement_btn_properties_link')->nullable();
            $table->string('engagement_btn_contact_text')->nullable();
            $table->string('engagement_btn_contact_icon')->nullable();
            $table->string('engagement_btn_contact_link')->nullable();

            // Hero Section (Homepage Banner/Search)
            $table->enum('hero_background_type', ['gradient', 'image'])->default('gradient');
            $table->string('hero_gradient_direction')->nullable(); // e.g., 'to-t', 'to-r'
            $table->string('hero_gradient_from_color')->nullable(); // e.g., 'green-400'
            $table->string('hero_gradient_to_color')->nullable(); // e.g., 'blue-400'
            $table->string('hero_image_url')->nullable();
            $table->string('hero_image_alt_text')->nullable();
            $table->string('hero_image_class')->nullable(); // For Tailwind classes like opacity, cover
            $table->boolean('hero_show_text_content')->default(true);
            $table->string('hero_title')->nullable(); // Text like "Encontre o imóvel <span>perfeito</span>"
            $table->text('hero_description')->nullable();
            $table->string('hero_clients_satisfied_text')->nullable(); // "+100 clientes satisfeitos"
            $table->json('hero_avatars')->nullable(); // Array of avatar URLs as JSON
            $table->float('hero_stars_rating')->nullable(); // e.g., 4.5
            $table->string('hero_form_title')->nullable(); // "O que você está buscando?"
            $table->json('hero_select_options')->nullable(); // Array of objects for select inputs as JSON
            $table->string('hero_search_button_text')->nullable();
            $table->string('hero_search_button_icon')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenant_settings');
    }
};
