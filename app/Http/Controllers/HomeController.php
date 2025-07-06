<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function landing()
    {
        return view('home.landing');
    }

    public function index()
    {
        // Dados mockados que serão editáveis no painel administrativo
        $siteSettings = [
            'site_name' => 'Imobiliária Premium',
            'primary_color' => '#422ad5',
            'secondary_color' => '#f43098',
            'text_color' => '#0b0809', // Cor do texto principal
            'logo' => 'https://placehold.co/400x400/3b82f6/white?text=IM',
            'show_logo_and_name' => false,
            // Versão full backend
            // 'header_display_type' => 'logo_and_name', // Opções: 'logo_only', 'name_only', 'logo_and_name'
            // 'logo' => null,
            'favicon' => null,
        ];

        $heroSection = [
            'background_type' => 'gradient', // Opções: 'gradient' ou 'image'
            'gradient' => [
                'direction' => 'to-t', // Opções: 'to-t', 'to-b', 'to-l', 'to-r', 'to-tl', 'to-tr', 'to-bl', 'to-br'
                'from_color' => 'green-400', // Cores do Tailwind CSS (e.g., 'blue-500', 'red-700')
                'to_color' => 'blue-400',
            ],
            'image' => [
                'url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', // URL da imagem
                'alt_text' => 'Imagem de fundo de um imóvel moderno',
                // Adicione classes para controle de opacidade ou cover, se necessário
                // 'class' => 'absolute inset-0 w-full h-full object-cover z-0 opacity-70',
                'class' => 'absolute inset-0 w-full h-full object-cover z-0 ',
            ],
            'show_text_content' => true, // Opções: true ou false (para mostrar/esconder o texto e avatares)
            'title' => 'Encontre o imóvel <span class="text-primary">perfeito</span>',
            'description' => 'Mais de 1.000 propriedades disponíveis com as melhores condições do mercado',
            'clients_satisfied_text' => '+100 clientes satisfeitos',
            // 'text_content_class' => '', // Cor do texto, pode ser uma classe Tailwind CSS
            'avatars' => [ // URLs das imagens dos avatares
                'https://randomuser.me/api/portraits/women/44.jpg',
                'https://randomuser.me/api/portraits/men/32.jpg',
                'https://randomuser.me/api/portraits/women/68.jpg',
            ],
            'stars_rating' => 4.5, // Para controlar o número de estrelas (pode ser 0 a 5, com .5 para metade)

            // Dados para os selects (opções dinâmicas)
            'form_title' => 'O que você está buscando?',
            'select_options' => [
                [
                    'placeholder' => 'Tipo de Imóvel',
                    'options' => ['Casa', 'Apartamento', 'Terreno', 'Comercial']
                ],
                [
                    'placeholder' => 'Localização',
                    'options' => ['São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Curitiba', 'Porto Alegre', 'Florianópolis', 'Brasília']
                ],
                [
                    'placeholder' => 'Faixa de Preço',
                    'options' => ['Até R$ 300.000', 'R$ 300-600 mil', 'R$ 600-1 milhão', 'Acima de R$ 1 milhão']
                ],
                [
                    'placeholder' => 'Quartos',
                    'options' => ['1+', '2+', '3+', '4+']
                ],
                // Você pode adicionar mais selects aqui
            ],
            'search_button_text' => 'Buscar Imóveis',
            'search_button_icon' => 'fas fa-search',
        ];

        $featuredProperties = [
            [
                'id' => 1,
                'title' => 'Casa Moderna no Centro',
                'address' => 'Centro, São Paulo',
                'price' => 850000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 180,
                'type' => 'casa',
                'image' => 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914',
                'featured' => true,
                'status' => 'disponivel'
            ],
            [
                'id' => 2,
                'title' => 'Apartamento Luxuoso',
                'address' => 'Zona Sul, Rio de Janeiro',
                'price' => 1250000, // Preço corrigido para numérico
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 220,
                'type' => 'apartamento',
                'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'featured' => true,
                'status' => 'disponivel'
            ],
            [
                'id' => 3,
                'title' => 'Casa com Piscina',
                'address' => 'Zona Oeste, Belo Horizonte',
                'price' => 2500000, // Preço corrigido para numérico
                'bedrooms' => 5,
                'bathrooms' => 4,
                'area' => 350,
                'type' => 'casa',
                'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'featured' => true,
                'status' => 'disponivel'
            ],
        ];

        $recentProperties = [
            [
                'id' => 4, // ID único, continuando a sequência
                'title' => 'Apartamento Compacto',
                'address' => 'Centro, Curitiba',
                'price' => 320000,
                'bedrooms' => 2,
                'bathrooms' => 1,
                'area' => 65,
                'type' => 'apartamento',
                'image' => 'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'status' => 'novo', // Use 'novo' ou 'disponivel' conforme sua lógica
                'details_link' => route('home.property', 4) // Exemplo de link dinâmico
            ],
            [
                'id' => 5,
                'title' => 'Casa Térrea',
                'address' => 'Zona Leste, Porto Alegre',
                'price' => 450000,
                'bedrooms' => 3,
                'bathrooms' => 2,
                'area' => 120,
                'type' => 'casa',
                'image' => 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'status' => 'novo',
                'details_link' => route('home.property', 5)
            ],
            [
                'id' => 6,
                'title' => 'Cobertura Duplex',
                'address' => 'Zona Sul, Florianópolis',
                'price' => 1800000,
                'bedrooms' => 4,
                'bathrooms' => 3,
                'area' => 280,
                'type' => 'apartamento',
                'image' => 'https://images.unsplash.com/photo-1605146769289-440113cc3d00?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'status' => 'novo',
                'details_link' => route('home.property', 6)
            ],
            [
                'id' => 7,
                'title' => 'Terreno Residencial',
                'address' => 'Bairro Nobre, Brasília',
                'price' => 600000,
                // Terrenos geralmente não têm quartos ou banheiros, então podemos omitir ou deixar 0
                'bedrooms' => 0,
                'bathrooms' => 0,
                'area' => 500,
                'type' => 'terreno', // Novo tipo
                'image' => 'https://images.unsplash.com/photo-1600566752225-53769df8b5e5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                'status' => 'novo',
                // Adicionei 'vagas_garagem' para o terreno, se for relevante, ou omita
                'vagas_garagem' => 2,
                'details_link' => route('home.property', 7)
            ],
        ];

        $aboutSection = [
            'title' => 'Sobre Nossa Imobiliária',
            'content' => 'Somos uma imobiliária com mais de 20 anos de experiência no mercado, ajudando famílias a encontrar o lar perfeito.',
            'image' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf',
            // 'image' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
            'features' => [
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
            ]
        ];

        $contactInfo = [
            'phone' => '(11) 88888-8888',
            'whatsapp' => '5511999999999',
            'email' => 'contato@imobiliaria.com',
            'address' => 'Av. Paulista, 1000 - São Paulo/SP',
            'social_media' => [
                'facebook' => '#facebook',
                'instagram' => '#instagram',
                'linkedin' => '#linkedin',
            ]
        ];

        $sectionContent = [
            'title' => 'A melhor experiência em <span class="text-secondary">negócios imobiliários</span>',
            'description' => 'Conectamos você aos melhores imóveis com transparência e segurança',
            'metrics' => [
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
            ],
            // Adicione os textos dos botões se quiser torná-los dinâmicos também
            'button_properties_text' => 'Ver Imóveis',
            'button_contact_text' => 'Falar com Corretor',
            'button_properties_icon' => 'fas fa-home', // Ícone como string
            'button_contact_icon' => 'fas fa-phone-alt', // Ícone como string
            'button_properties_link' => '#destaques', // Links também podem ser dinâmicos
            'button_contact_link' => '#contato',
        ];

        return view('home.index', compact(
            'siteSettings',
            'heroSection',
            'featuredProperties',
            'aboutSection',
            'contactInfo',
            'recentProperties',
            'sectionContent'
        ));
    }

    public function properties()
    {
        return view('home.properties');
    }

    public function property()
    {
        return view('home.property');
    }
}
