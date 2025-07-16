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
            $table->string('primary_color')->default('#3B82F6'); // Default primary color
            $table->string('secondary_color')->default('#F59E0B'); // Default secondary color
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
            $table->string('about_title')->nullable()->default('Sobre Nossa Imobiliária');
            $table->text('about_content')->nullable()->default('Somos uma imobiliária com mais de 20 anos de experiência no mercado, ajudando famílias a encontrar o lar perfeito.');
            $table->string('about_image')->nullable()->default('https://images.unsplash.com/photo-1600880292203-757bb62b4baf');
            $table->json('about_features')->nullable()->default(json_encode([
                [
                    'title' => 'Atendimento Personalizado',
                    'description' => 'Entendemos suas necessidades e oferecemos soluções sob medida.',
                    'icon' => 'fas fa-check-circle'
                ],
                [
                    'title' => 'Transparência',
                    'description' => 'Processos claros e sem surpresas desagradáveis.',
                    'icon' => 'fas fa-check-circle'
                ],
                [
                    'title' => 'Variedade de Imóveis',
                    'description' => 'Ampla seleção de propriedades para todos os gostos e orçamentos.',
                    'icon' => 'fas fa-check-circle'
                ],
            ])); // Storing array of features as JSON

            // Metrics/Engagement Section (previous 'sectionContent')
            $table->string('engagement_title')->nullable()->default('A melhor experiência em negócios imobiliários');
            $table->text('engagement_description')->nullable()->default('Conectamos você aos melhores imóveis com transparência e segurança');
            $table->json('engagement_metrics')->nullable()->default(json_encode([
                 [
                    'value' => '1.200+',
                    'description' => 'Imóveis disponíveis'
                ],
                [
                    'value' => '25+',
                    'description' => 'Bairros atendidos'
                ],
                [
                    'value' => '98%',
                    'description' => 'Satisfação dos clientes'
                ],
                [
                    'value' => '15+',
                    'description' => 'Anos de experiência'
                ],
            ])); // Storing array of metrics as JSON
            $table->string('engagement_btn_properties_text')->nullable()->default('Ver Imóveis');
            $table->string('engagement_btn_properties_icon')->nullable()->default('fas fa-home'); // Ícone como string
            $table->string('engagement_btn_properties_link')->nullable()->default('#destaques');
            $table->string('engagement_btn_contact_text')->nullable()->default('Falar com Corretor');
            $table->string('engagement_btn_contact_icon')->nullable()->default('fas fa-phone-alt');
            $table->string('engagement_btn_contact_link')->nullable()->default('#contato');

            // Hero Section (Homepage Banner/Search)
            $table->enum('hero_background_type', ['gradient', 'image'])->default('gradient');
            $table->string('hero_gradient_direction')->nullable()->default('to-b'); // e.g., 'to-t', 'to-r'
            $table->string('hero_gradient_from_color')->nullable()->default('#F59E0B'); 
            $table->string('hero_gradient_to_color')->nullable()->default('#3B82F6'); 
            $table->string('hero_image_url')->nullable();
            $table->string('hero_image_alt_text')->nullable();
            $table->string('hero_image_class')->nullable(); // For Tailwind classes like opacity, cover
            $table->boolean('hero_show_text_content')->default(true);
            $table->string('hero_title')->nullable()->default('Encontre o imóvel perfeito'); // Text like "Encontre o imóvel <span>perfeito</span>"
            $table->text('hero_description')->nullable()->default('Mais de 1.000 propriedades disponíveis com as melhores condições do mercado');
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
