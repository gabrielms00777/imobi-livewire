<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function home()
    {
        // Dados mockados que serão editáveis no painel administrativo
        $siteSettings = [
            'site_name' => 'Imobiliária Premium',
            'primary_color' => '#422ad5',
            'secondary_color' => '#f43098',
            'text_color' => '#0b0809', // Cor do texto principal
            'logo' => 'https://placehold.co/400x400/3b82f6/white?text=IM',
            'show_logo_and_name' => false,
            'favicon' => null,
        ];

        $heroSection = [
            'background_type' => 'image', // Opções: 'gradient' ou 'image'
            'gradient' => [
                'direction' => 'to-br', // Opções: 'to-t', 'to-b', 'to-l', 'to-r', 'to-tl', 'to-tr', 'to-bl', 'to-br'
                'from_color' => '#65fa60ff', // Cores do Tailwind CSS (e.g., 'blue-500', 'red-700')
                'to_color' => '#0145ffff',
            ],
            'image' => [
                'url' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', // URL da imagem
                'alt_text' => 'Imagem de fundo de um imóvel moderno',
                // Adicione classes para controle de opacidade ou cover, se necessário
                // 'class' => 'absolute inset-0 w-full h-full object-cover z-0 opacity-70',
                'class' => 'absolute inset-0 w-full h-full object-cover z-0 ',
            ],
            'show_text_content' => true, // Opções: true ou false (para mostrar/esconder o texto e avatares)
            // 'title' => 'Encontre o imóvel <span class="text-primary">perfeito</span>',
            'title' => 'Encontre o imóvel perfeito',
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
                'details_link' => route('demo.property', 4) // Exemplo de link dinâmico
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
                'details_link' => route('demo.property', 5)
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
                'details_link' => route('demo.property', 6)
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
                'details_link' => route('demo.property', 7)
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

        return view('demo.home', compact(
            'siteSettings',
            'heroSection',
            'featuredProperties',
            'aboutSection',
            'contactInfo',
            'recentProperties',
            'sectionContent'
        ));
    }

    public function properties(Request $request)
    {
        $siteSettings = [
            'site_name' => 'Imobiliária Premium',
            'primary_color' => '#422ad5',
            'secondary_color' => '#f43098',
            'text_color' => '#0b0809', // Cor do texto principal
            'logo' => 'https://placehold.co/400x400/3b82f6/white?text=IM',
            'show_logo_and_name' => true,
            'favicon' => null,
        ];

        // Array de propriedades (substitua por um model/DB depois)
        $properties = [
            [
                "id" => "1",
                "titulo" => "Apartamento Luxuoso na Praia",
                "endereco" => "Av. Beira Mar, 1234",
                "cidade" => "Rio de Janeiro",
                "estado" => "RJ",
                "bairro" => "Copacabana",
                "tipo" => "Apartamento",
                "quartos" => 3,
                "banheiros" => 2,
                "vagas" => 2,
                "area" => 120,
                "preco" => 2500000,
                "caracteristicas" => ["Piscina", "Academia", "Portaria 24h", "Vista para o mar"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1493809842364-78817add7ffb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Apartamento luxuoso com vista para o mar em Copacabana.",
                "descricao_completa" => "Este apartamento luxuoso oferece uma vista deslumbrante para o mar, localizado no coração de Copacabana. Com 3 quartos, sendo 1 suíte, 2 banheiros, cozinha gourmet e área de lazer completa com piscina, academia e salão de festas. Próximo a restaurantes, shoppings e transporte público.",
                "isFeatured" => true,
                "isNew" => false,
                "latitude" => -22.970722,
                "longitude" => -43.182365,
                "dataPublicacao" => "2023-10-15"
            ],
            [
                "id" => "2",
                "titulo" => "Casa Moderna em Condomínio Fechado",
                "endereco" => "Rua das Flores, 456",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Morumbi",
                "tipo" => "Casa",
                "quartos" => 4,
                "banheiros" => 3,
                "vagas" => 3,
                "area" => 280,
                "preco" => 3800000,
                "caracteristicas" => ["Piscina", "Jardim", "Churrasqueira", "Quintal"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Casa moderna em condomínio fechado no Morumbi.",
                "descricao_completa" => "Esta casa moderna está localizada em um condomínio fechado no bairro do Morumbi, com segurança 24h. Possui 4 quartos (sendo 2 suítes), 3 banheiros, cozinha gourmet, sala de estar e jantar amplas, área de lazer com piscina, churrasqueira e jardim. Garagem para 3 carros.",
                "isFeatured" => true,
                "isNew" => true,
                "latitude" => -23.622739,
                "longitude" => -46.699888,
                "dataPublicacao" => "2023-11-05"
            ],
            [
                "id" => "3",
                "titulo" => "Cobertura com Vista Panorâmica",
                "endereco" => "Av. Paulista, 1001",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Bela Vista",
                "tipo" => "Apartamento",
                "quartos" => 2,
                "banheiros" => 2,
                "vagas" => 1,
                "area" => 90,
                "preco" => 1800000,
                "caracteristicas" => ["Varanda", "Academia", "Portaria 24h", "Mobiliado"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1505691938895-1758d7feb511?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Cobertura moderna com vista panorâmica na Avenida Paulista.",
                "descricao_completa" => "Cobertura moderna localizada no coração da Avenida Paulista, com vista panorâmica da cidade. Possui 2 quartos (sendo 1 suíte), 2 banheiros, cozinha americana, sala ampla e varanda gourmet. O prédio conta com academia, salão de festas e portaria 24h. O apartamento vem mobiliado.",
                "isFeatured" => true,
                "isNew" => false,
                "latitude" => -23.561414,
                "longitude" => -46.655375,
                "dataPublicacao" => "2023-10-20"
            ],
            [
                "id" => "4",
                "titulo" => "Terreno Residencial em Condomínio",
                "endereco" => "Rua das Palmeiras, 789",
                "cidade" => "Campinas",
                "estado" => "SP",
                "bairro" => "Barão Geraldo",
                "tipo" => "Terreno",
                "quartos" => 0,
                "banheiros" => 0,
                "vagas" => 0,
                "area" => 450,
                "preco" => 850000,
                "caracteristicas" => ["Área arborizada", "Segurança 24h", "Infraestrutura completa"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600607688969-a5bfcd646154?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Terreno residencial em condomínio fechado em Barão Geraldo.",
                "descricao_completa" => "Terreno residencial de 450m² localizado em condomínio fechado em Barão Geraldo, Campinas. Área totalmente plana e arborizada, com infraestrutura completa (água, luz, esgoto, gás, internet). O condomínio oferece segurança 24h, áreas de lazer e proximidade com universidades e centros de pesquisa.",
                "isFeatured" => false,
                "isNew" => true,
                "latitude" => -22.818333,
                "longitude" => -47.070833,
                "dataPublicacao" => "2023-11-10"
            ],
            [
                "id" => "5",
                "titulo" => "Loja Comercial em Localização Privilegiada",
                "endereco" => "Rua XV de Novembro, 500",
                "cidade" => "Curitiba",
                "estado" => "PR",
                "bairro" => "Centro",
                "tipo" => "Comercial",
                "quartos" => 0,
                "banheiros" => 1,
                "vagas" => 0,
                "area" => 80,
                "preco" => 1200000,
                "caracteristicas" => ["Frente para rua", "Banheiro", "Piso elevado", "Excelente fluxo"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1605152276897-4f618f831968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600585152220-90363fe7e115?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600566752228-3a2d4e0b09d6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Loja comercial em localização privilegiada no centro de Curitiba.",
                "descricao_completa" => "Loja comercial com 80m² em localização privilegiada na Rua XV de Novembro, no centro de Curitiba. Excelente fluxo de pessoas, frente para rua, piso elevado, banheiro e possibilidade de divisão. Ideal para diversos tipos de comércio. Próximo a shoppings, bancos e pontos de ônibus.",
                "isFeatured" => false,
                "isNew" => false,
                "latitude" => -25.428954,
                "longitude" => -49.267137,
                "dataPublicacao" => "2023-09-28"
            ],
            [
                "id" => "6",
                "titulo" => "Apartamento Compacto no Centro",
                "endereco" => "Rua da Consolação, 789",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Consolação",
                "tipo" => "Apartamento",
                "quartos" => 1,
                "banheiros" => 1,
                "vagas" => 1,
                "area" => 45,
                "preco" => 550000,
                "caracteristicas" => ["Portaria 24h", "Próximo ao metrô", "Mobiliado"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1484154218962-a197022b5858?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Apartamento compacto e mobiliado no centro de São Paulo.",
                "descricao_completa" => "Apartamento compacto de 45m², mobiliado, localizado no coração da Consolação. Ideal para quem busca praticidade e localização. Possui 1 quarto, 1 banheiro, cozinha americana e sala conjugada. O prédio conta com portaria 24h e está a 200m da estação de metrô.",
                "isFeatured" => false,
                "isNew" => false,
                "latitude" => -23.551414,
                "longitude" => -46.655375,
                "dataPublicacao" => "2023-09-15"
            ],
            [
                "id" => "7",
                "titulo" => "Casa de Campo com Lago",
                "endereco" => "Estrada do Sertão, 123",
                "cidade" => "Campos do Jordão",
                "estado" => "SP",
                "bairro" => "Capivari",
                "tipo" => "Casa",
                "quartos" => 3,
                "banheiros" => 2,
                "vagas" => 2,
                "area" => 180,
                "preco" => 1200000,
                "caracteristicas" => ["Lago privativo", "Churrasqueira", "Jardim", "Varanda"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600607688969-a5bfcd646154?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Casa de campo aconchegante com lago privativo em Campos do Jordão.",
                "descricao_completa" => "Casa de campo com 180m² em Campos do Jordão, próxima ao centro de Capivari. Possui 3 quartos (sendo 1 suíte), 2 banheiros, cozinha equipada, sala de estar com lareira, varanda com vista para o lago privativo e área de churrasco com forno a lenha. Terreno de 1.200m² com jardim e árvores frutíferas.",
                "isFeatured" => false,
                "isNew" => true,
                "latitude" => -22.738333,
                "longitude" => -45.570833,
                "dataPublicacao" => "2023-11-12"
            ],
            [
                "id" => "8",
                "titulo" => "Sobrado em Condomínio Clube",
                "endereco" => "Alameda das Hortênsias, 456",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Alphaville",
                "tipo" => "Casa",
                "quartos" => 4,
                "banheiros" => 4,
                "vagas" => 4,
                "area" => 320,
                "preco" => 4200000,
                "caracteristicas" => ["Piscina", "Sauna", "Quadra poliesportiva", "Salão de festas"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600607688969-a5bfcd646154?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Sobrado luxuoso em condomínio clube em Alphaville.",
                "descricao_completa" => "Sobrado luxuoso de 320m² em condomínio clube em Alphaville. Possui 4 suítes, cozinha gourmet, sala de estar e jantar amplas, home theater, lavanderia, área de serviço, piscina aquecida e sauna privativa. O condomínio oferece piscinas, quadras poliesportivas, salão de festas, playground e segurança 24h.",
                "isFeatured" => true,
                "isNew" => false,
                "latitude" => -23.492739,
                "longitude" => -46.849888,
                "dataPublicacao" => "2023-10-10"
            ],
            [
                "id" => "9",
                "titulo" => "Kitnet Mobiliada para Alugar",
                "endereco" => "Rua Augusta, 789",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Consolação",
                "tipo" => "Apartamento",
                "quartos" => 1,
                "banheiros" => 1,
                "vagas" => 0,
                "area" => 35,
                "preco" => 350000,
                "caracteristicas" => ["Mobiliado", "Próximo ao metrô", "Portaria 24h"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1484154218962-a197022b5858?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Kitnet mobiliada para alugar no coração da Augusta.",
                "descricao_completa" => "Kitnet mobiliada de 35m² localizada na Rua Augusta, no coração da vida noturna de São Paulo. Possui 1 quarto conjugado com sala, 1 banheiro, cozinha compacta e armários embutidos. O prédio conta com portaria 24h e está a 300m da estação de metrô Consolação. Ideal para estudantes ou profissionais que buscam praticidade.",
                "isFeatured" => false,
                "isNew" => false,
                "latitude" => -23.551414,
                "longitude" => -46.655375,
                "dataPublicacao" => "2023-09-05"
            ],
            [
                "id" => "10",
                "titulo" => "Cobertura Duplex com Piscina",
                "endereco" => "Av. Brigadeiro Faria Lima, 1500",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Pinheiros",
                "tipo" => "Apartamento",
                "quartos" => 3,
                "banheiros" => 3,
                "vagas" => 2,
                "area" => 180,
                "preco" => 3200000,
                "caracteristicas" => ["Piscina", "Varanda gourmet", "Home theater", "Vista panorâmica"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1505691938895-1758d7feb511?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Cobertura duplex com piscina na Faria Lima.",
                "descricao_completa" => "Cobertura duplex de 180m² com piscina privativa na cobertura, localizada na Avenida Brigadeiro Faria Lima. Possui 3 suítes, sendo 1 master com closet, home theater, varanda gourmet com churrasqueira, cozinha equipada com ilha, lavanderia e dependência completa. O prédio conta com academia, salão de festas e portaria 24h.",
                "isFeatured" => true,
                "isNew" => true,
                "latitude" => -23.568414,
                "longitude" => -46.692375,
                "dataPublicacao" => "2023-11-15"
            ],
            [
                "id" => "11",
                "titulo" => "Terreno Industrial Zona Leste",
                "endereco" => "Av. Marginal Tietê, 5000",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Penha",
                "tipo" => "Terreno",
                "quartos" => 0,
                "banheiros" => 0,
                "vagas" => 0,
                "area" => 1200,
                "preco" => 2800000,
                "caracteristicas" => ["Frente para avenida", "Área plana", "Infraestrutura completa"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600607688969-a5bfcd646154?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Terreno industrial de 1.200m² na Zona Leste de São Paulo.",
                "descricao_completa" => "Terreno industrial de 1.200m² localizado na Avenida Marginal Tietê, na Zona Leste de São Paulo. Área totalmente plana, com infraestrutura completa (água, luz, esgoto, gás, internet). Frente de 30m para avenida, ideal para galpão industrial ou centro de distribuição. Excelente localização com acesso rápido ao centro e às principais rodovias.",
                "isFeatured" => false,
                "isNew" => false,
                "latitude" => -23.528333,
                "longitude" => -46.520833,
                "dataPublicacao" => "2023-08-20"
            ],
            [
                "id" => "12",
                "titulo" => "Flat para Temporada",
                "endereco" => "Rua Oscar Freire, 200",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Jardins",
                "tipo" => "Apartamento",
                "quartos" => 2,
                "banheiros" => 2,
                "vagas" => 1,
                "area" => 75,
                "preco" => 1800000,
                "caracteristicas" => ["Mobiliado", "Pronto para morar", "Portaria 24h", "Academia"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1484154218962-a197022b5858?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Flat mobiliado para temporada nos Jardins.",
                "descricao_completa" => "Flat mobiliado de 75m² localizado na badalada Rua Oscar Freire, no coração dos Jardins. Possui 2 quartos (sendo 1 suíte), 2 banheiros, cozinha americana equipada, sala de estar e varanda. O prédio conta com portaria 24h, academia e salão de festas. Próximo aos melhores restaurantes, bares e lojas de luxo de São Paulo.",
                "isFeatured" => false,
                "isNew" => true,
                "latitude" => -23.561414,
                "longitude" => -46.665375,
                "dataPublicacao" => "2023-11-08"
            ],
            [
                "id" => "13",
                "titulo" => "Sala Comercial no Centro",
                "endereco" => "Rua São Bento, 365",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Centro",
                "tipo" => "Comercial",
                "quartos" => 0,
                "banheiros" => 1,
                "vagas" => 0,
                "area" => 60,
                "preco" => 950000,
                "caracteristicas" => ["Pronto para usar", "Banheiro", "Piso elevado", "Excelente localização"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1605152276897-4f618f831968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600585152220-90363fe7e115?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600566752228-3a2d4e0b09d6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Sala comercial no centro financeiro de São Paulo.",
                "descricao_completa" => "Sala comercial de 60m² localizada na Rua São Bento, no centro financeiro de São Paulo. Pronta para uso, com piso elevado, banheiro e divisórias em drywall. Excelente localização, próxima ao metrô São Bento e a diversos bancos, escritórios e pontos comerciais. Ideal para escritório, consultório ou pequeno comércio.",
                "isFeatured" => false,
                "isNew" => false,
                "latitude" => -23.545414,
                "longitude" => -46.635375,
                "dataPublicacao" => "2023-09-10"
            ],
            [
                "id" => "14",
                "titulo" => "Casa de Praia em Guarujá",
                "endereco" => "Av. Miguel Estéfno, 2000",
                "cidade" => "Guarujá",
                "estado" => "SP",
                "bairro" => "Pitangueiras",
                "tipo" => "Casa",
                "quartos" => 3,
                "banheiros" => 2,
                "vagas" => 2,
                "area" => 150,
                "preco" => 2200000,
                "caracteristicas" => ["Vista para o mar", "Quintal", "Churrasqueira", "Próximo à praia"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600607688969-a5bfcd646154?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Casa de praia com vista para o mar em Guarujá.",
                "descricao_completa" => "Casa de praia de 150m² localizada em Pitangueiras, Guarujá. Possui 3 quartos (sendo 1 suíte), 2 banheiros, cozinha equipada, sala de estar e jantar, varanda com vista para o mar e quintal com churrasqueira. A apenas 300m da praia de Pitangueiras, com fácil acesso ao centro e ao ferry-boat.",
                "isFeatured" => true,
                "isNew" => false,
                "latitude" => -23.988333,
                "longitude" => -46.250833,
                "dataPublicacao" => "2023-10-25"
            ],
            [
                "id" => "15",
                "titulo" => "Apartamento Alto Padrão na Faria Lima",
                "endereco" => "Av. Brigadeiro Faria Lima, 3500",
                "cidade" => "São Paulo",
                "estado" => "SP",
                "bairro" => "Itaim Bibi",
                "tipo" => "Apartamento",
                "quartos" => 3,
                "banheiros" => 3,
                "vagas" => 2,
                "area" => 160,
                "preco" => 3800000,
                "caracteristicas" => ["Academia", "Salão de festas", "Portaria 24h", "Varanda gourmet"],
                "imagens" => [
                    "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80",
                    "https://images.unsplash.com/photo-1505691938895-1758d7feb511?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80"
                ],
                "descricao_curta" => "Apartamento alto padrão na Faria Lima.",
                "descricao_completa" => "Apartamento alto padrão de 160m² localizado na Avenida Brigadeiro Faria Lima, no coração do Itaim Bibi. Possui 3 suítes (sendo 1 master com closet e hidromassagem), cozinha gourmet com ilha, lavanderia, sala de estar e jantar integradas, e varanda gourmet com churrasqueira. O prédio conta com academia, salão de festas, piscina e portaria 24h.",
                "isFeatured" => true,
                "isNew" => true,
                "latitude" => -23.581414,
                "longitude" => -46.685375,
                "dataPublicacao" => "2023-11-18"
            ]
        ];

        // Filtros da requisição
        $filters = [
            'search' => $request->input('search'),
            'location' => $request->input('location'),
            'type' => $request->input('type'),
            'bedrooms' => $request->input('bedrooms', 0),
            'bathrooms' => $request->input('bathrooms', 0),
            'parking' => $request->input('parking', 0),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'min_area' => $request->input('min_area'),
            'max_area' => $request->input('max_area'),
            'features' => $request->input('features', []),
        ];

        // Aplicar filtros
        $filteredProperties = array_filter($properties, function ($property) use ($filters) {
            // Filtro por busca
            if ($filters['search']) {
                $searchLower = strtolower($filters['search']);
                $matchesSearch =
                    str_contains(strtolower($property['titulo']), $searchLower) ||
                    str_contains(strtolower($property['endereco']), $searchLower) ||
                    str_contains(strtolower($property['cidade']), $searchLower) ||
                    str_contains(strtolower($property['bairro']), $searchLower) ||
                    str_contains(strtolower($property['estado']), $searchLower) ||
                    str_contains(strtolower($property['tipo']), $searchLower) ||
                    str_contains(strtolower($property['descricao_curta']), $searchLower);

                if (!$matchesSearch) return false;
            }

            // Filtro por localização
            if ($filters['location']) {
                $locationLower = strtolower($filters['location']);
                $matchesLocation =
                    str_contains(strtolower($property['cidade']), $locationLower) ||
                    str_contains(strtolower($property['bairro']), $locationLower) ||
                    str_contains(strtolower($property['estado']), $locationLower) ||
                    str_contains(strtolower($property['endereco']), $locationLower);

                if (!$matchesLocation) return false;
            }

            // Filtro por tipo
            if ($filters['type'] && $property['tipo'] !== $filters['type']) {
                return false;
            }

            // Filtro por quartos
            if ($filters['bedrooms'] > 0 && $property['quartos'] < $filters['bedrooms']) {
                return false;
            }

            // Filtro por banheiros
            if ($filters['bathrooms'] > 0 && $property['banheiros'] < $filters['bathrooms']) {
                return false;
            }

            // Filtro por vagas
            if ($filters['parking'] > 0 && $property['vagas'] < $filters['parking']) {
                return false;
            }

            // Filtro por preço
            if ($filters['min_price'] && $property['preco'] < $filters['min_price']) {
                return false;
            }
            if ($filters['max_price'] && $property['preco'] > $filters['max_price']) {
                return false;
            }

            // Filtro por área
            if ($filters['min_area'] && $property['area'] < $filters['min_area']) {
                return false;
            }
            if ($filters['max_area'] && $property['area'] > $filters['max_area']) {
                return false;
            }

            // Filtro por características
            if (!empty($filters['features'])) {
                $hasAllFeatures = true;
                foreach ($filters['features'] as $feature) {
                    if (!in_array($feature, $property['caracteristicas'])) {
                        $hasAllFeatures = false;
                        break;
                    }
                }
                if (!$hasAllFeatures) return false;
            }

            return true;
        });

        // Ordenação
        $sortBy = $request->input('sort_by', 'recent');
        usort($filteredProperties, function ($a, $b) use ($sortBy) {
            switch ($sortBy) {
                case 'price-asc':
                    return $a['preco'] <=> $b['preco'];
                case 'price-desc':
                    return $b['preco'] <=> $a['preco'];
                case 'popular':
                    // Prioriza imóveis em destaque e depois os mais recentes
                    if ($a['isFeatured'] && !$b['isFeatured']) return -1;
                    if (!$a['isFeatured'] && $b['isFeatured']) return 1;
                    return strtotime($b['dataPublicacao']) <=> strtotime($a['dataPublicacao']);
                case 'recent':
                default:
                    // Prioriza imóveis novos e depois os mais recentes
                    if ($a['isNew'] && !$b['isNew']) return -1;
                    if (!$a['isNew'] && $b['isNew']) return 1;
                    return strtotime($b['dataPublicacao']) <=> strtotime($a['dataPublicacao']);
            }
        });

        // Paginação manual (simplificada)
        $perPage = 6;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $paginatedProperties = array_slice($filteredProperties, $offset, $perPage);
        $totalPages = ceil(count($filteredProperties) / $perPage);

        // Tipos de imóveis para o dropdown
        $propertyTypes = array_unique(array_column($properties, 'tipo'));

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

        return view('demo.imoveis', [
            'properties' => $paginatedProperties,
            'filters' => $filters,
            'propertyTypes' => $propertyTypes,
            'sortBy' => $sortBy,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalProperties' => count($filteredProperties),
            'siteSettings' => $siteSettings,
            'contactInfo' => $contactInfo,
        ]);
    }

    public function property(Request $request, $id)
    {
        return view('demo.property');
    }
}
