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
                'about_image' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D',
                'about_features' => json_encode([
                    ['title' => 'Exclusividade', 'description' => 'Portfólio selecionado de imóveis de luxo.', 'icon' => 'fas fa-gem'],
                    ['title' => 'Consultoria Especializada', 'description' => 'Nossa equipe de corretores é altamente qualificada.', 'icon' => 'fas fa-handshake'],
                ]),

                // Metrics/Engagement Section
                'engagement_title' => 'Resultados que inspiram confiança',
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
                'hero_image_url' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D',
                'hero_image_alt_text' => 'Mansão de luxo',
                'hero_image_class' => 'absolute inset-0 w-full h-full object-cover z-0 opacity-80',
                'hero_show_text_content' => true,
                'hero_title' => 'Sua mansão espera por você',
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
                'engagement_title' => 'Sua busca termina aqui',
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
                'hero_gradient_from_color' => '#60a5fa',
                'hero_gradient_to_color' => '#a78bfa',
                'hero_image_url' => null,
                'hero_image_alt_text' => null,
                'hero_image_class' => null,
                'hero_show_text_content' => true,
                'hero_title' => 'Seu novo lar está aqui',
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

        $litoralPrime = Company::where('name', 'Litoral Prime Imobiliária')->first();
        if ($litoralPrime) {
            TenantSetting::create([
                'configurable_id' => $litoralPrime->id,
                'configurable_type' => Company::class,

                // General Site Settings
                'site_name' => $litoralPrime->name,
                'site_description' => $litoralPrime->description,
                'site_logo' => 'https://placehold.co/400x400/0000ff/white?text=LP+Logo',
                'site_favicon' => null,
                'primary_color' => '#007bff', // Azul vibrante para o mar
                'secondary_color' => '#ffc107', // Amarelo areia
                'text_color' => '#343a40',
                'header_display_type' => 'logo_and_name',

                // Contact Information
                'contact_phone' => '(13) 9988-7766',
                'contact_email' => 'contato@litoralprime.com.br',
                'contact_address' => 'Av. da Praia, 456, Gonzaga, Santos - SP',

                // Social Media Links
                'social_facebook' => 'https://facebook.com/litoralprime',
                'social_instagram' => 'https://instagram.com/litoralprime',
                'social_linkedin' => 'https://linkedin.com/company/litoralprime',
                'social_youtube' => null,
                'social_whatsapp' => '551399887766',

                // SEO Settings
                'meta_title' => 'Litoral Prime Imobiliária - Imóveis na Praia',
                'meta_description' => 'As melhores casas e apartamentos de frente para o mar no litoral de São Paulo. Seu imóvel dos sonhos está aqui!',
                'meta_image' => 'https://placehold.co/1200x630/007bff/white?text=Litoral+SEO',

                // About Section
                'about_title' => 'Conheça a Litoral Prime',
                'about_content' => 'Com anos de experiência no mercado imobiliário litorâneo, a Litoral Prime é sua parceira ideal para encontrar propriedades exclusivas e realizar seu sonho de viver perto do mar.',
                'about_image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGNhc2F8ZW58MHx8MHx8fDA%3D',
                'about_features' => json_encode([
                    ['title' => 'Praia Exclusiva', 'description' => 'Acesso direto às melhores praias.', 'icon' => 'fas fa-umbrella-beach'],
                    ['title' => 'Vista Mar', 'description' => 'Imóveis com panoramas deslumbrantes.', 'icon' => 'fas fa-water'],
                    ['title' => 'Alto Padrão', 'description' => 'Luxo e conforto em cada detalhe.', 'icon' => 'fas fa-crown'],
                ]),

                // Metrics/Engagement Section
                'engagement_title' => 'Concretizando Seus Sonhos à Beira-Mar',
                'engagement_description' => 'Veja por que somos a escolha número um para imóveis no litoral.',
                'engagement_metrics' => json_encode([
                    ['value' => '300+', 'description' => 'Propriedades Vendidas'],
                    ['value' => '15', 'description' => 'Anos de Experiência'],
                    ['value' => '95%', 'description' => 'Satisfação do Cliente'],
                ]),
                'engagement_btn_properties_text' => 'Ver Imóveis na Praia',
                'engagement_btn_properties_icon' => 'fas fa-water',
                'engagement_btn_properties_link' => '/imoveis-na-praia',
                'engagement_btn_contact_text' => 'Fale Conosco',
                'engagement_btn_contact_icon' => 'fas fa-phone-alt',
                'engagement_btn_contact_link' => '/contato',

                // Hero Section
                'hero_background_type' => 'image',
                'hero_gradient_direction' => null,
                'hero_gradient_from_color' => null,
                'hero_gradient_to_color' => null,
                'hero_image_url' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D', // Imagem de praia/mansão
                'hero_image_alt_text' => 'Casa de praia luxuosa',
                'hero_image_class' => 'absolute inset-0 w-full h-full object-cover z-0 opacity-80',
                'hero_show_text_content' => false,
                'hero_title' => 'Sua Vida de Praia Começa Aqui',
                'hero_description' => 'Explore o melhor do litoral com nossas propriedades exclusivas.',
                'hero_clients_satisfied_text' => 'Mais de 100 famílias felizes',
                'hero_avatars' => json_encode([
                    'https://randomuser.me/api/portraits/women/65.jpg',
                    'https://randomuser.me/api/portraits/men/66.jpg',
                    'https://randomuser.me/api/portraits/women/67.jpg',
                    'https://randomuser.me/api/portraits/men/68.jpg',
                ]),
                'hero_stars_rating' => 4.9,
                'hero_form_title' => 'Encontre sua Propriedade à Beira-Mar',
                'hero_select_options' => json_encode([
                    ['placeholder' => 'Tipo', 'options' => ['Casa de Praia', 'Apartamento Litoral', 'Cobertura com Vista']],
                    ['placeholder' => 'Cidade', 'options' => ['Santos', 'Guarujá', 'Riviera de São Lourenço']],
                ]),
                'hero_search_button_text' => 'Buscar Paraíso',
                'hero_search_button_icon' => 'fas fa-search',
            ]);
        }

        // https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D
        // https://images.unsplash.com/photo-1572120360610-d971b9d7767c?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D
        // https://images.unsplash.com/photo-1480074568708-e7b720bb3f09?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D
        // https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8OHx8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D
        // https://plus.unsplash.com/premium_photo-1661915661139-5b6a4e4a6fcc?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8NXx8Y2FzYXxlbnwwfHwwfHx8MA%3D%3D
        // https://images.unsplash.com/photo-1580587771525-78b9dba3b914?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGNhc2F8ZW58MHx8MHx8fDA%3D
        // https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTJ8fGNhc2F8ZW58MHx8MHx8fDA%3D
    }
}
