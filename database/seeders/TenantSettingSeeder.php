<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\TenantSetting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Exemplo de configurações para a Mega Imóveis S.A.
        $megaImoveis = Company::where('name', 'Mega Imóveis S.A.')->first();
        if ($megaImoveis) {
            TenantSetting::create([
                'configurable_id' => $megaImoveis->id,
                'configurable_type' => Company::class, // Use o nome da classe completa

                // General Site Settings
                'site_name' => $megaImoveis->name,
                'site_description' => $megaImoveis->description,
                'site_logo' => 'https://placehold.co/400x400/ff0000/white?text=Mega+Logo',
                'site_favicon' => null,
                'primary_color' => '#dc2626', // Vermelho para Mega Imóveis
                'secondary_color' => '#facc15', // Amarelo
                'text_color' => '#1f2937',
                'header_display_type' => 'logo_and_name',

                // Contact Information
                'contact_phone' => '(11) 99999-0000',
                'contact_email' => 'contato@megaimoveis.com.br',
                'contact_address' => 'Av. Central, 500, São Paulo/SP',

                // Social Media Links
                'social_facebook' => 'https://facebook.com/megaimoveis',
                'social_instagram' => 'https://instagram.com/megaimoveis',
                'social_linkedin' => null,
                'social_youtube' => null,
                'social_whatsapp' => '5511999990000',

                // SEO Settings
                'meta_title' => 'Mega Imóveis - Seu Imóvel de Alto Padrão',
                'meta_description' => 'Especialistas em imóveis de luxo em São Paulo. Encontre sua casa dos sonhos.',
                'meta_image' => 'https://placehold.co/1200x630/dc2626/white?text=Mega+SEO',

                // About Section
                'about_title' => 'Sobre a Mega Imóveis',
                'about_content' => 'A Mega Imóveis é referência em imóveis de alto padrão há mais de 30 anos, oferecendo exclusividade e atendimento de primeira.',
                'about_image' => 'https://images.unsplash.com/photo-1574362141979-222a08f5d082?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'about_features' => json_encode([
                    ['title' => 'Exclusividade', 'description' => 'Portfólio selecionado de imóveis de luxo.', 'icon' => 'fas fa-gem'],
                    ['title' => 'Consultoria Especializada', 'description' => 'Nossa equipe de corretores é altamente qualificada.', 'icon' => 'fas fa-handshake'],
                ]),

                // Metrics/Engagement Section
                'engagement_title' => 'Resultados que <span class="text-secondary">inspiram confiança</span>',
                'engagement_description' => 'Construindo o futuro com base em números sólidos.',
                'engagement_metrics' => json_encode([
                    ['value' => '500+', 'description' => 'Imóveis exclusivos'],
                    ['value' => '100%', 'description' => 'Clientes satisfeitos'],
                ]),
                'engagement_btn_properties_text' => 'Ver Imóveis de Luxo',
                'engagement_btn_properties_icon' => 'fas fa-building',
                'engagement_btn_properties_link' => '/imoveis-luxo',
                'engagement_btn_contact_text' => 'Falar com Consultor',
                'engagement_btn_contact_icon' => 'fas fa-envelope',
                'engagement_btn_contact_link' => '/contato',

                // Hero Section
                'hero_background_type' => 'image',
                'hero_gradient_direction' => null,
                'hero_gradient_from_color' => null,
                'hero_gradient_to_color' => null,
                'hero_image_url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'hero_image_alt_text' => 'Mansão de luxo',
                'hero_image_class' => 'absolute inset-0 w-full h-full object-cover z-0 opacity-80',
                'hero_show_text_content' => true,
                'hero_title' => 'Sua mansão <span class="text-secondary">espera por você</span>',
                'hero_description' => 'As propriedades mais exclusivas e sofisticadas do mercado estão aqui.',
                'hero_clients_satisfied_text' => '+50 clientes de alto padrão',
                'hero_avatars' => json_encode([
                    'https://randomuser.me/api/portraits/men/50.jpg',
                    'https://randomuser.me/api/portraits/women/51.jpg',
                ]),
                'hero_stars_rating' => 5.0,
                'hero_form_title' => 'Encontre seu paraíso particular',
                'hero_select_options' => json_encode([
                    ['placeholder' => 'Tipo', 'options' => ['Casa de Luxo', 'Apartamento Cobertura']],
                    ['placeholder' => 'Local', 'options' => ['São Paulo', 'Alphaville', 'Campinas']],
                ]),
                'hero_search_button_text' => 'Buscar Propriedade',
                'hero_search_button_icon' => 'fas fa-gem',
            ]);
        }

        // Exemplo de configurações para o João Corretor (autônomo)
        $joaoCorretor = User::where('email', 'joao@corretor.com')->first();
        if ($joaoCorretor) {
            TenantSetting::create([
                'configurable_id' => $joaoCorretor->id,
                'configurable_type' => User::class, // Use o nome da classe completa

                // General Site Settings
                'site_name' => 'João Corretor Imóveis',
                'site_description' => 'Seu corretor de confiança para os melhores negócios em Curitiba.',
                'site_logo' => 'https://placehold.co/400x400/0000ff/white?text=JC',
                'site_favicon' => null,
                'primary_color' => '#059669', // Verde para João
                'secondary_color' => '#fbbf24', // Laranja
                'text_color' => '#1f2937',
                'header_display_type' => 'logo_and_name',

                // Contact Information
                'contact_phone' => '(41) 98765-4321',
                'contact_email' => 'joao@corretor.com',
                'contact_address' => 'Rua dos Pinheiros, 10, Curitiba/PR',

                // Social Media Links
                'social_facebook' => null,
                'social_instagram' => 'https://instagram.com/joao.corretor',
                'social_linkedin' => 'https://linkedin.com/in/joaocorretor',
                'social_youtube' => null,
                'social_whatsapp' => '5541987654321',

                // SEO Settings
                'meta_title' => 'João Corretor - Imóveis em Curitiba',
                'meta_description' => 'Encontre seu apartamento ou casa em Curitiba com um corretor especializado e de confiança.',
                'meta_image' => 'https://placehold.co/1200x630/059669/white?text=JC+SEO',

                // About Section
                'about_title' => 'Sobre João Corretor',
                'about_content' => 'Com 10 anos de experiência, João Corretor oferece atendimento personalizado e as melhores opções de imóveis em Curitiba e região metropolitana.',
                'about_image' => 'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'about_features' => json_encode([
                    ['title' => 'Conhecimento Local', 'description' => 'Especialista no mercado imobiliário de Curitiba.', 'icon' => 'fas fa-map-marker-alt'],
                    ['title' => 'Negociação', 'description' => 'Assegura os melhores termos para você.', 'icon' => 'fas fa-dollar-sign'],
                ]),

                // Metrics/Engagement Section
                'engagement_title' => 'Sua busca termina <span class="text-secondary">aqui</span>',
                'engagement_description' => 'Realizamos sonhos através de imóveis com dedicação e profissionalismo.',
                'engagement_metrics' => json_encode([
                    ['value' => '200+', 'description' => 'Imóveis vendidos'],
                    ['value' => '100%', 'description' => 'Felicidade do cliente'],
                ]),
                'engagement_btn_properties_text' => 'Ver Imóveis em Curitiba',
                'engagement_btn_properties_icon' => 'fas fa-city',
                'engagement_btn_contact_text' => 'Fale Comigo!',
                'engagement_btn_contact_icon' => 'fas fa-comments',
                'engagement_btn_properties_link' => '/imoveis-curitiba',
                'engagement_btn_contact_link' => '/contato',

                // Hero Section
                'hero_background_type' => 'gradient',
                'hero_gradient_direction' => 'to-br',
                'hero_gradient_from_color' => 'blue-400',
                'hero_gradient_to_color' => 'purple-400',
                'hero_image_url' => null,
                'hero_image_alt_text' => null,
                'hero_image_class' => null,
                'hero_show_text_content' => true,
                'hero_title' => 'Seu novo lar <span class="text-secondary">está aqui</span>',
                'hero_description' => 'As melhores casas e apartamentos em Curitiba, escolhidos a dedo para você.',
                'hero_clients_satisfied_text' => '+70 clientes satisfeitos em Curitiba',
                'hero_avatars' => json_encode([
                    'https://randomuser.me/api/portraits/women/60.jpg',
                    'https://randomuser.me/api/portraits/men/61.jpg',
                    'https://randomuser.me/api/portraits/women/62.jpg',
                ]),
                'hero_stars_rating' => 4.8,
                'hero_form_title' => 'O que você procura em Curitiba?',
                'hero_select_options' => json_encode([
                    ['placeholder' => 'Tipo', 'options' => ['Apartamento', 'Casa']],
                    ['placeholder' => 'Bairro', 'options' => ['Centro', 'Batel', 'Água Verde']],
                ]),
                'hero_search_button_text' => 'Buscar Imóveis',
                'hero_search_button_icon' => 'fas fa-search-location',
            ]);
        }
    }
}
