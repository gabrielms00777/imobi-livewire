<!DOCTYPE html>
<html lang="pt-BR" x-data="{ darkMode: false, activeImage: 0, showContactForm: false }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Meta tags dinâmicas --}}
    <title>
        {{ $property->meta_title ?? $property->title . ' - ' . $property->city . '/' . $property->state . ' - ' . ($tenantSettings->site_name ?? 'Imobiliária Padrão') }}
    </title>
    <meta name="description"
        content="{{ $property->meta_description ?? \Illuminate\Support\Str::limit($property->description, 160) }}">
    <meta property="og:title"
        content="{{ $property->meta_title ?? $property->title . ' - ' . $property->city . '/' . $property->state }}">
    <meta property="og:description"
        content="{{ $property->meta_description ?? \Illuminate\Support\Str::limit($property->description, 160) }}">
    <meta property="og:image"
        content="{{ $property->main_image_url ?? ($tenantSettings->meta_image ?? asset('images/default-share-image.jpg')) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    {{-- Favicon dinâmico --}}
    @if ($tenantSettings->site_favicon)
        <link rel="icon" href="{{ $tenantSettings->site_favicon }}" type="image/x-icon">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"> {{-- Caminho para um favicon padrão --}}
    @endif


    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            /* Cores primárias e secundárias do tenant */
            /* --primary: {{ $tenantSettings->primary_color ?? '#422ad5' }};
            --secondary: {{ $tenantSettings->secondary_color ?? '#f43098' }};
            --text-color: {{ $tenantSettings->text_color ?? '#0b0809' }}; */
            /* Cor do texto principal */
            --color-primary: {{ $tenantSettings->primary_color ?? '#422ad5' }};
            --color-secondary: {{ $tenantSettings->secondary_color ?? '#f43098' }};
            --color-neutral: {{ $tenantSettings->text_color ?? '#0b0809' }};

            /* Cores neutras e base do DaisyUI podem ser fixas ou adaptadas */
            /* --accent: #f59e0b; */
            /* Pode ser customizada se houver campo no DB */
            /* --neutral: #1f2937; */
            /* Pode ser customizada */
            /* --base-100: #ffffff; */
            /* Pode ser customizada */
        }

        .dark {
            /* Cores para o modo escuro, ajuste conforme a necessidade e tema DaisyUI */
            --primary: {{ $tenantSettings->primary_color_dark ?? '#60a5fa' }};
            /* Exemplo: campo para cor escura */
            --secondary: {{ $tenantSettings->secondary_color_dark ?? '#34d399' }};
            --text-color: {{ $tenantSettings->text_color_dark ?? '#d1d5db' }};
            --accent: #fbbf24;
            --neutral: #d1d5db;
            --base-100: #1f2937;
        }

        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
            color: var(--text-color);
            /* Aplica a cor do texto padrão */
        }

        /* Animações personalizadas - manter como estão */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.9s ease-out forwards;
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .property-card {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-base-100 text-neutral">
    <header x-data="{ isScrolled: false, showMobileMenu: false }" @scroll.window="isScrolled = window.scrollY > 50"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="isScrolled ? 'bg-white shadow-md dark:bg-neutral' : 'bg-transparent'">

        <div class="container mx-auto px-4">
            <div class="navbar">
                <div class="flex-1">
                    <a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}" class="px-0">
                        <div class="flex items-center">
                            {{-- Lógica para exibir Logo, Nome ou Ambos --}}
                            @php
                                $headerDisplayType = $tenantSettings->header_display_type ?? 'logo_only'; // Fallback
                                $showLogo = in_array($headerDisplayType, ['logo_only', 'logo_and_name']);
                                $showName = in_array($headerDisplayType, ['name_only', 'logo_and_name']);
                                $siteNameParts = explode(' ', $tenantSettings->site_name ?? 'Seu Site');
                            @endphp

                            @if ($showLogo && $tenantSettings->site_logo)
                                <img src="{{ $tenantSettings->site_logo }}"
                                    alt="Logo {{ $tenantSettings->site_name ?? 'Imobiliária' }}"
                                    class="h-10 w-auto rounded-lg {{ $showName ? 'mr-2' : '' }}">
                            @endif

                            @if ($showName && $tenantSettings->site_name)
                                <span class="text-xl font-bold text-primary">
                                    {{ $siteNameParts[0] ?? '' }}
                                    @if (isset($siteNameParts[1]))
                                        <span class="text-secondary">{{ $siteNameParts[1] }}</span>
                                    @endif
                                </span>
                            @endif

                            {{-- Fallback se nada estiver configurado ou apenas um tipo de display sem os dados --}}
                            @if ((!$showLogo || !$tenantSettings->site_logo) && (!$showName || !$tenantSettings->site_name))
                                <span class="text-xl font-bold text-primary">Seu Site</span>
                            @endif
                        </div>
                    </a>
                </div>

                {{-- Navegação principal (desktop) --}}
                <div class="flex-none hidden lg:flex items-center gap-2">
                    <nav class="flex items-center">
                        <ul class="menu menu-horizontal px-1 gap-1">
                            <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}"
                                    class="font-medium hover:text-primary">Início</a></li>
                            {{-- Links para seções específicas da HOME --}}
                            <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug, '#destaques']) }}"
                                    class="font-medium hover:text-primary">Destaques</a></li>
                            <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug, '#sobre']) }}"
                                    class="font-medium hover:text-primary">Sobre</a></li>
                            <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug, '#contato']) }}"
                                    class="font-medium hover:text-primary">Contato</a></li>
                            <li><a href="{{ route('tenant.properties', ['tenantSlug' => $tenant->slug]) }}"
                                    class="font-medium hover:text-primary">Imóveis</a></li> {{-- Link para a página de listagem de imóveis --}}
                            @if (auth()->check())
                                <li><a href="/admin" class="font-medium hover:text-primary">Dashboard</a></li>
                            @else
                                <li><a href="/login" class="font-medium hover:text-primary">Login</a></li>
                            @endif
                        </ul>
                    </nav>

                    <div class="divider divider-horizontal h-6 mx-2"></div>

                    {{-- Links de Redes Sociais --}}
                    <div class="flex items-center gap-2 mr-4">
                        @if ($tenantSettings->social_facebook)
                            <a href="{{ $tenantSettings->social_facebook }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-ghost btn-circle btn-sm hover:text-primary">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if ($tenantSettings->social_instagram)
                            <a href="{{ $tenantSettings->social_instagram }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-ghost btn-circle btn-sm hover:text-primary">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if ($tenantSettings->social_linkedin)
                            <a href="{{ $tenantSettings->social_linkedin }}" target="_blank" rel="noopener noreferrer"
                                class="btn btn-ghost btn-circle btn-sm hover:text-primary">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                    </div>

                    {{-- Botão WhatsApp --}}
                    @if ($tenantSettings->social_whatsapp && $tenantSettings->contact_phone)
                        <a href="https://wa.me/{{ preg_replace('/\D/', '', $tenantSettings->social_whatsapp) }}"
                            target="_blank" rel="noopener noreferrer" class="btn btn-primary btn-sm md:btn-md gap-2">
                            <i class="fab fa-whatsapp"></i>
                            <span class="hidden sm:inline">{{ $tenantSettings->contact_phone }}</span>
                        </a>
                    @endif
                </div>

                {{-- Botão do Menu Hamburguer (mobile) --}}
                <div class="flex-none lg:hidden">
                    <button @click="showMobileMenu = !showMobileMenu" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Overlay e Drawer para Mobile --}}
        <div x-show="showMobileMenu" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="fixed inset-0 bg-base-300 bg-opacity-75 z-40 lg:hidden" @click="showMobileMenu = false"></div>
        {{-- Fecha o menu ao clicar no overlay --}}

        <div x-show="showMobileMenu" x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed top-0 left-0 w-80 h-full bg-base-100 text-base-content shadow-xl z-50 p-4 lg:hidden">
            <div class="flex items-center justify-between mb-6">
                {{-- Logo ou Nome do Site no Mobile Drawer --}}
                <a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}"
                    class="text-xl font-bold text-primary">
                    @if ($showLogo && $tenantSettings->site_logo)
                        <img src="{{ $tenantSettings->site_logo }}"
                            alt="Logo {{ $tenantSettings->site_name ?? 'Imobiliária' }}"
                            class="h-8 w-auto rounded-lg inline-block mr-2">
                    @endif
                    @if ($showName && $tenantSettings->site_name)
                        {{ $siteNameParts[0] ?? '' }}
                        @if (isset($siteNameParts[1]))
                            <span class="text-secondary">{{ $siteNameParts[1] }}</span>
                        @endif
                    @endif
                    @if ((!$showLogo || !$tenantSettings->site_logo) && (!$showName || !$tenantSettings->site_name))
                        Seu Site
                    @endif
                </a>
                <button @click="showMobileMenu = false" class="btn btn-ghost btn-circle">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <ul class="space-y-2">
                <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}"
                        @click="showMobileMenu = false" class="font-medium">Início</a></li>
                <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug, '#destaques']) }}"
                        @click="showMobileMenu = false" class="font-medium">Destaques</a></li>
                <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug, '#sobre']) }}"
                        @click="showMobileMenu = false" class="font-medium">Sobre</a></li>
                <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug, '#contato']) }}"
                        @click="showMobileMenu = false" class="font-medium">Contato</a></li>
                <li><a href="{{ route('tenant.properties', ['tenantSlug' => $tenant->slug]) }}"
                        @click="showMobileMenu = false" class="font-medium">Imóveis</a></li>
                @if (auth()->check())
                    <li><a href="/admin" @click="showMobileMenu = false" class="font-medium">Dashboard</a></li>
                @else
                    <li><a href="/login" @click="showMobileMenu = false" class="font-medium">Login</a></li>
                @endif
            </ul>

            <div class="divider my-4"></div>

            <div class="flex justify-center gap-4 mb-6">
                @if ($tenantSettings->social_facebook)
                    <a href="{{ $tenantSettings->social_facebook }}" target="_blank" rel="noopener noreferrer"
                        class="btn btn-ghost btn-circle">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                @endif
                @if ($tenantSettings->social_instagram)
                    <a href="{{ $tenantSettings->social_instagram }}" target="_blank" rel="noopener noreferrer"
                        class="btn btn-ghost btn-circle">
                        <i class="fab fa-instagram"></i>
                    </a>
                @endif
                @if ($tenantSettings->social_linkedin)
                    <a href="{{ $tenantSettings->social_linkedin }}" target="_blank" rel="noopener noreferrer"
                        class="btn btn-ghost btn-circle">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                @endif
            </div>

            @if ($tenantSettings->social_whatsapp && $tenantSettings->contact_phone)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $tenantSettings->social_whatsapp) }}"
                    target="_blank" rel="noopener noreferrer" class="btn btn-primary gap-2">
                    <i class="fab fa-whatsapp"></i>
                    {{ $tenantSettings->contact_phone }}
                </a>
            @endif
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="container mx-auto px-4 py-8 mt-10">
        <!-- Caminho de Navegação -->
        <div class="text-sm breadcrumbs mb-6 text-base-content">
            <ul>
                <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}"
                        class="hover:text-primary">Home</a></li>
                <li><a href="{{ route('tenant.properties', ['tenantSlug' => $tenant->slug]) }}"
                        class="hover:text-primary">Imóveis</a></li>
                @if ($property->city && $property->state)
                    <li><a href="{{ route('tenant.properties', ['tenantSlug' => $tenant->slug, 'city' => $property->city]) }}"
                            class="hover:text-primary">{{ $property->city }}</a></li>
                    <li><a href="{{ route('tenant.properties', ['tenantSlug' => $tenant->slug, 'state' => $property->state]) }}"
                            class="hover:text-primary">{{ $property->state }}</a></li>
                @endif
                <li class="font-semibold">{{ $property->title }}</li>
            </ul>
        </div>

        <!-- Galeria de Imagens -->
        {{-- <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-8">
            <!-- Imagem Principal -->
            <div class="lg:col-span-3 relative rounded-xl overflow-hidden h-96 bg-base-200">
                <img x-bind:src="activeImage === 0 ?
                    'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' :
                    activeImage === 1 ?
                    'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' :
                    activeImage === 2 ?
                    'https://images.unsplash.com/photo-1580216643062-cf460548a66a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' :
                    'https://images.unsplash.com/photo-1580216643062-cf460548a66a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'"
                    alt="Imóvel" class="w-full h-full object-cover transition-opacity duration-300">

                <!-- Controles da Galeria -->
                <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2">
                    <button @click="activeImage = 0" class="w-3 h-3 rounded-full"
                        :class="activeImage === 0 ? 'bg-primary' : 'bg-white/50'"></button>
                    <button @click="activeImage = 1" class="w-3 h-3 rounded-full"
                        :class="activeImage === 1 ? 'bg-primary' : 'bg-white/50'"></button>
                    <button @click="activeImage = 2" class="w-3 h-3 rounded-full"
                        :class="activeImage === 2 ? 'bg-primary' : 'bg-white/50'"></button>
                </div>

                <!-- Badge de Destaque -->
                <span class="badge badge-primary absolute top-4 right-4">Destaque</span>
            </div>

            <!-- Miniaturas -->
            <div class="hidden lg:grid grid-cols-2 gap-2 h-96">
                <button @click="activeImage = 0"
                    class="rounded-xl overflow-hidden hover:opacity-90 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Fachada" class="w-full h-full object-cover">
                </button>
                <button @click="activeImage = 1"
                    class="rounded-xl overflow-hidden hover:opacity-90 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Sala de estar" class="w-full h-full object-cover">
                </button>
                <button @click="activeImage = 2"
                    class="rounded-xl overflow-hidden hover:opacity-90 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1580216643062-cf460548a66a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Cozinha" class="w-full h-full object-cover">
                </button>
                <button @click="activeImage = 3"
                    class="rounded-xl overflow-hidden hover:opacity-90 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1580216643062-cf460548a66a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Quarto" class="w-full h-full object-cover">
                </button>
            </div>
        </div> --}}
        <div x-data="{
            currentImageIndex: 0,
            images: @json($propertyImages),
            next() {
                this.currentImageIndex = (this.currentImageIndex === this.images.length - 1) ? 0 : this.currentImageIndex + 1;
            },
            prev() {
                this.currentImageIndex = (this.currentImageIndex === 0) ? this.images.length - 1 : this.currentImageIndex - 1;
            },
            get transformValue() {
                    // Calcula o deslocamento para centralizar a imagem atual, considerando o espaçamento
                    // `gap-4` = 16px. A imagem principal é `w-[calc(100%-8rem)]` em desktop.
                    // A largura total das imagens visíveis é (w_img + gap) * num_imgs_visiveis_laterais * 2 + w_img_central
                    // Isso requer um cálculo mais exato do posicionamento para alinhar no centro.
                    // Por simplicidade, vamos calcular o deslocamento como se cada slide ocupasse 100% e depois ajustar o espaçamento.
                    // Isso pode precisar de calibração fina com a largura das imagens visíveis.
        
                    // Para um carrossel onde 3 imagens são parcialmente visíveis (esquerda, centro, direita)
                    // e queremos centralizar a do meio.
                    // Cada item no carrossel precisa ter a mesma largura para o calculo de translateX ser simples.
        
                    // Para o layout da imagem, onde as laterais são cortadas, vamos fazer
                    // com que cada slide ocupe um percentual da tela e a transform faça o resto.
                    // Em mobile (col-1), a imagem ocupa 100%. Em lg (col-3, gap-4), a imagem central é maior.
                    // Para simplificar, vou focar no `transform: translateX` para centralizar a imagem *principal*
                    // e as outras serão visíveis por causa do padding ou margem negativa.
        
                    // Se for um slide por vez (como a primeira opção, mas com padding), a lógica é simples.
                    {{-- // Para "slides expostos", precisamos de um cálculo que leve em conta a largura total do container e a largura de cada slide. 
            // Ex: Se cada slide tem 80% da largura do container, e queremos 10% de
            padding em cada lado. // A imagem atual estaria em `currentImageIndex * (80% + gap)`. // Vamos usar uma
            abordagem mais simples: o translateX vai mover o carousel baseado no índice, // e o "padding" visual virá do
            `mx-auto` e `overflow-hidden` com padding no container pai. // Adaptei o translateX para a visualização da
            imagem. // Supondo que você queira a imagem central com largura total, e as vizinhas "aparecendo" pelos
            lados. // Isso é mais complexo com Tailwind puro para larguras dinâmicas. // Para o visual da sua imagem, o
            carrossel não é 100% de largura por slide. // Cada item no carrossel tem uma largura definida (ex: 80% da
            viewport, com margens laterais). // O `transform` precisa mover a `ul` inteira para que o item
            `currentImageIndex` fique no centro. if (this.images.length===0) return '0' ; // Assumindo que a imagem
            central tem a classe `w-full` dentro de um contêiner com `px-16` para mostrar os vizinhos. // ou que cada
            item tem uma largura calculada (ex: `w-[80vw]` para mobile, `w-[60vw]` para desktop) // e o container
            principal tem overflow hidden e um padding para expor os lados. // Vamos simular o efeito da imagem: um
            flexbox com 3 itens visíveis, o do meio centralizado. // O transform deve levar em conta a largura do item e
            o gap. // Por enquanto, vou manter o translateX simples (para 100% de largura por slide) // e adicionar
            classes que simulam a visibilidade lateral via padding/margin.  --}}
            return `-${this.currentImageIndex * 100}%`; }
            }" class="w-full relative shadow-lg mb-8 rounded-xl overflow-hidden bg-base-200">

            {{-- Área de Visualização Principal do Carrossel --}}
            <div class="relative w-full h-80 sm:h-96 md:h-[450px] lg:h-[550px] flex overflow-hidden">
                {{-- Container das Imagens (movido pelo Alpine.js) --}}
                <div class="flex h-full transition-transform duration-500 ease-in-out"
                    :style="'transform: translateX(' + transformValue + ')'">
                    @foreach ($propertyImages as $imageUrl)
                        {{-- Cada item do carrossel. As classes `w-full flex-shrink-0` garantem que cada imagem ocupe a largura total do seu pai flexível --}}
                        {{-- Para o efeito da sua imagem, onde você vê as laterais, a estrutura seria mais como: --}}
                        {{-- um container com `overflow-hidden` e `padding-x` (ou `margin-x` negativa)
                --}}
                        <div class="flex-shrink-0 w-full h-full"> {{-- Este item irá ocupar 100% do espaço visível, mas o contêiner pai fará o "corte" --}}
                            <img src="{{ $imageUrl }}" class="w-full h-full object-cover"
                                alt="Imagem do Imóvel">
                        </div>
                    @endforeach
                </div>

                {{-- Controles de Navegação (setas sobrepostas) --}}
                <div
                    class="absolute left-0 right-0 top-1/2 flex justify-between transform -translate-y-1/2 px-4 md:px-8 z-10">
                    <button @click="prev()"
                        class="btn btn-circle bg-white/50 hover:bg-white text-base-content border-none shadow-md">❮</button>
                    <button @click="next()"
                        class="btn btn-circle bg-white/50 hover:bg-white text-base-content border-none shadow-md">❯</button>
                </div>

                @if ($property->is_featured)
                    <span class="badge badge-primary absolute top-4 right-4 text-lg p-3 z-20">Destaque</span>
                @endif
            </div>

            {{-- Botões de navegação (dots) na parte inferior, se desejar --}}
            <div class="flex justify-center w-full py-2 gap-2 bg-base-200 rounded-b-xl relative z-10">
                @foreach ($propertyImages as $index => $imageUrl)
                    <button @click="currentImageIndex = {{ $index }}"
                        class="w-3 h-3 rounded-full transition-colors duration-200"
                        :class="currentImageIndex === {{ $index }} ? 'bg-primary' :
                            'bg-base-content/40 hover:bg-base-content/70'">
                    </button>
                @endforeach
            </div>

        </div>

        {{-- **IMPORTANTE:** Para obter o efeito da sua imagem, onde as laterais das fotos vizinhas são visíveis,
     você precisará de um pouco mais de CSS customizado ou de uma biblioteca de carrossel JS mais robusta
     (como Swiper.js ou Splide.js) configurada para 'slidesPerView: auto' ou 'slidesOffsetBefore/After'.

     O código acima usa `w-full` para cada slide. Para o efeito de "exposed slides", a div externa `<div class="relative w-full h-80 ... flex overflow-hidden">`
     precisaria de `padding-x` e os `carousel-item` teriam uma largura menor que 100%
     (ex: `w-[80%]` ou `w-[calc(100%-gap-size)]` para um layout de 3 slides visíveis).
     O `transformValue` no Alpine.js precisaria ser mais complexo para centralizar a imagem ativa.

     **Tentativa de Simular o Layout da Imagem com Tailwind/Alpine puro (Mais avançado):**
     Isso exige um ajuste fino das larguras e margens negativas, e pode não ser 100% perfeito sem um JS mais complexo.
     Vou dar um exemplo conceitual de como o CSS/JS para o `transformValue` mudaria, mas o HTML base é o mesmo.

     **Conceito para `transformValue` em Carrossel "Exposto":**
     Em vez de `-${this.currentImageIndex * 100}%`, seria algo como:
     `currentSlideOffset = (this.currentImageIndex * (larguraDoSlide + espacamentoEntreSlides));`
     `centralizationOffset = (larguraDoContainer / 2) - (larguraDoSlide / 2);`
     `transform = -(currentSlideOffset - centralizationOffset);`

     Isso seria um cálculo JavaScript dentro do Alpine.js para o `transformValue`.
     Para o Tailwind, as classes seriam:
     `<div class="flex-shrink-0 w-[calc(80%-1rem)] mx-2 h-full">` (exemplo para cada slide, com margens)
     E o container principal teria `overflow-hidden`.
--}}

        {{-- Para o seu caso, a Opção 1 (Carrossel Principal com Miniaturas Abaixo) era a mais fácil de adaptar para
     mostrar todas as imagens de forma interativa sem uma área de foto *muito* grande no topo.
     Mas se a imagem que você mandou é o objetivo, o DaisyUI Carousel padrão não faz isso.
     Precisamos de uma biblioteca de terceiros (Swiper, Splide) ou de um Alpine/Tailwind mais complexo.

     **Dado que você quer o estilo da imagem, o código acima é uma tentativa mais próxima.**
     Ele usa `flex` e `overflow-hidden` com `transform` no Alpine.js.
     A **altura** do carrossel foi reduzida para 320px/384px/450px/550px em diferentes viewports para deixá-lo mais compacto.
     As setas de navegação estão sobrepostas na imagem, como na sua referência.
     Os "dots" de navegação foram mantidos na parte inferior para clareza.
--}}

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informações Principais -->
            <div class="lg:col-span-2">
                <!-- Título e Preço -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <h1 class="text-3xl font-bold">Casa Moderna no Centro</h1>
                    <div class="text-2xl font-bold text-primary mt-2 md:mt-0">R$ 850.000</div>
                </div>

                <!-- Localização -->
                <div class="flex items-center text-lg mb-6">
                    <i class="fas fa-map-marker-alt text-gray-500 mr-2"></i>
                    <span>Rua Exemplo, 123 - Centro, São Paulo/SP</span>
                </div>

                <!-- Características -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-base-200 p-4 rounded-lg text-center">
                        <i class="fas fa-bed text-2xl mb-2 text-primary"></i>
                        <div>3 Quartos</div>
                    </div>
                    <div class="bg-base-200 p-4 rounded-lg text-center">
                        <i class="fas fa-bath text-2xl mb-2 text-primary"></i>
                        <div>2 Banheiros</div>
                    </div>
                    <div class="bg-base-200 p-4 rounded-lg text-center">
                        <i class="fas fa-ruler-combined text-2xl mb-2 text-primary"></i>
                        <div>180 m²</div>
                    </div>
                    <div class="bg-base-200 p-4 rounded-lg text-center">
                        <i class="fas fa-car text-2xl mb-2 text-primary"></i>
                        <div>2 Vagas</div>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4">Descrição do Imóvel</h2>
                    <p class="mb-4">Esta casa moderna no coração da cidade oferece conforto e sofisticação. Com
                        acabamentos de alta qualidade e uma localização privilegiada, é a escolha perfeita para quem
                        busca praticidade e estilo de vida urbano.</p>
                    <p>O imóvel possui ampla sala de estar integrada à cozinha gourmet, três suítes (sendo uma master
                        com closet), área de serviço completa, garagem coberta para dois carros e um terraço com vista
                        deslumbrante para a cidade.</p>
                </div>

                <!-- Destaques -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4">Destaques</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            <span>Cozinha com armários planejados</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            <span>Pisos em porcelanato</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            <span>Sistema de segurança</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            <span>Ar condicionado split</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            <span>Aquecimento solar</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            <span>Varanda gourmet</span>
                        </div>
                    </div>
                </div>

                <!-- Mapa -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4">Localização</h2>
                    <div class="bg-base-200 rounded-xl overflow-hidden h-64">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3657.197353585618!2d-46.65867598447599!3d-23.56134918468293!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce59c8da0aa315%3A0xd59f9431f2c9776a!2sAv.%20Paulista%2C%20S%C3%A3o%20Paulo%20-%20SP!5e0!3m2!1spt-BR!2sbr!4v1623865703949!5m2!1spt-BR!2sbr"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            class="filter grayscale(50%) contrast(1.2)"></iframe>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Contato e Informações -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <!-- Formulário de Contato -->
                    <div class="card bg-base-100 shadow-xl mb-6">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Interessado neste imóvel?</h2>

                            <template x-if="!showContactForm">
                                <div>
                                    <p class="mb-4">Entre em contato com nosso corretor especializado para agendar
                                        uma visita ou obter mais informações.</p>
                                    <button @click="showContactForm = true" class="btn btn-primary w-full mb-4">
                                        <i class="fas fa-envelope mr-2"></i> Enviar Mensagem
                                    </button>
                                    <a href="tel:+5511999999999" class="btn btn-outline btn-primary w-full">
                                        <i class="fas fa-phone-alt mr-2"></i> Ligar Agora
                                    </a>
                                </div>
                            </template>

                            <template x-if="showContactForm">
                                <form class="space-y-4">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Seu Nome</span>
                                        </label>
                                        <input type="text" placeholder="Nome completo"
                                            class="input input-bordered">
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Seu Telefone</span>
                                        </label>
                                        <input type="tel" placeholder="(00) 00000-0000"
                                            class="input input-bordered">
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Seu E-mail</span>
                                        </label>
                                        <input type="email" placeholder="seu@email.com"
                                            class="input input-bordered">
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text">Mensagem</span>
                                        </label>
                                        <textarea class="textarea textarea-bordered h-24" placeholder="Gostaria de mais informações sobre este imóvel..."></textarea>
                                    </div>
                                    <div class="form-control mt-6">
                                        <button type="button" class="btn btn-primary">Enviar Mensagem</button>
                                    </div>
                                </form>
                            </template>
                        </div>
                    </div>

                    <!-- Informações do Corretor -->
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Corretor Responsável</h2>
                            <div class="flex items-center mb-4">
                                <div class="avatar mr-4">
                                    <div class="w-16 rounded-full">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Corretor">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-bold">Carlos Silva</h3>
                                    <p class="text-sm">CRECI: 123456-SP</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <i class="fas fa-phone-alt text-primary mr-2"></i>
                                    <span>(11) 99999-9999</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-primary mr-2"></i>
                                    <span>carlos@imobiliaria.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imóveis Similares -->
        <section class="mt-16">
            <h2 class="text-2xl font-bold mb-8">Imóveis Similares</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card Imóvel Similar 1 -->
                <div class="property-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                            alt="Apartamento similar" class="h-48 w-full object-cover">
                    </figure>
                    <div class="card-body p-4">
                        <h3 class="card-title">Apartamento na Zona Sul</h3>
                        <div class="flex items-center text-sm mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Zona Sul, São Paulo</span>
                        </div>
                        <div class="flex justify-between items-center text-sm mb-3">
                            <div>
                                <i class="fas fa-bed mr-1"></i>
                                <span>3 Quartos</span>
                            </div>
                            <div>
                                <i class="fas fa-bath mr-1"></i>
                                <span>2 Banheiros</span>
                            </div>
                            <div>
                                <i class="fas fa-ruler-combined mr-1"></i>
                                <span>90m²</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-primary">R$ 750.000</span>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>

                <!-- Card Imóvel Similar 2 -->
                <div class="property-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                            alt="Casa similar" class="h-48 w-full object-cover">
                    </figure>
                    <div class="card-body p-4">
                        <h3 class="card-title">Casa com Jardim</h3>
                        <div class="flex items-center text-sm mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Vila Mariana, São Paulo</span>
                        </div>
                        <div class="flex justify-between items-center text-sm mb-3">
                            <div>
                                <i class="fas fa-bed mr-1"></i>
                                <span>4 Quartos</span>
                            </div>
                            <div>
                                <i class="fas fa-bath mr-1"></i>
                                <span>3 Banheiros</span>
                            </div>
                            <div>
                                <i class="fas fa-ruler-combined mr-1"></i>
                                <span>150m²</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-primary">R$ 1.200.000</span>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>

                <!-- Card Imóvel Similar 3 -->
                <div class="property-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1600566752225-53769df8b5e5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                            alt="Cobertura similar" class="h-48 w-full object-cover">
                    </figure>
                    <div class="card-body p-4">
                        <h3 class="card-title">Cobertura Moderna</h3>
                        <div class="flex items-center text-sm mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Itaim Bibi, São Paulo</span>
                        </div>
                        <div class="flex justify-between items-center text-sm mb-3">
                            <div>
                                <i class="fas fa-bed mr-1"></i>
                                <span>3 Quartos</span>
                            </div>
                            <div>
                                <i class="fas fa-bath mr-1"></i>
                                <span>2 Banheiros</span>
                            </div>
                            <div>
                                <i class="fas fa-ruler-combined mr-1"></i>
                                <span>110m²</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-primary">R$ 950.000</span>
                            <a href="#" class="btn btn-xs btn-outline btn-primary">Ver Detalhes</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- 7. Footer -->
    <footer class="footer p-10 bg-neutral text-neutral-content">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <span class="footer-title">Imobiliária</span>
                    <p>Há mais de 20 anos ajudando pessoas a encontrar seu lar ideal.</p>
                    <div class="flex gap-4 mt-4">
                        <a href="#" class="btn btn-circle btn-sm btn-ghost">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-circle btn-sm btn-ghost">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-circle btn-sm btn-ghost">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <span class="footer-title">Links Rápidos</span>
                    <a href="#destaques" class="link link-hover">Imóveis em Destaque</a>
                    <a href="#recentes" class="link link-hover">Imóveis Recentes</a>
                    <a href="#sobre" class="link link-hover">Sobre Nós</a>
                    <a href="#contato" class="link link-hover">Contato</a>
                </div>

                <div>
                    <span class="footer-title">Contato</span>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>Av. Paulista, 1000 - São Paulo/SP</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-phone-alt mr-2"></i>
                        <span>(11) 9999-9999</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>contato@imobiliaria.com</span>
                    </div>
                </div>

                <div>
                    <span class="footer-title">Newsletter</span>
                    <p>Assine nossa newsletter para receber novidades</p>
                    <div class="form-control mt-4">
                        <div class="relative">
                            <input type="text" placeholder="seu@email.com"
                                class="input input-bordered w-full pr-16">
                            <button class="btn btn-primary absolute top-0 right-0 rounded-l-none">Assinar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; 2023 Imobiliária. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts adicionais -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('properties', {
                featured: [{
                        id: 1,
                        title: 'Casa Moderna no Centro',
                        location: 'Centro, São Paulo',
                        bedrooms: 3,
                        bathrooms: 2,
                        area: 180,
                        price: 850000,
                        image: 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                        featured: true
                    },
                    // Outros imóveis...
                ],

                recent: [{
                        id: 4,
                        title: 'Apartamento Compacto',
                        location: 'Centro, Curitiba',
                        bedrooms: 2,
                        bathrooms: 1,
                        area: 65,
                        price: 320000,
                        image: 'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                        new: true
                    },
                    // Outros imóveis recentes...
                ]
            });
        });

        // Observador de interseção para animações
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.animate-fade-in');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1
            });

            elements.forEach(el => {
                el.style.opacity = 0;
                el.style.transform = 'translateY(20px)';
                observer.observe(el);
            });
        };

        document.addEventListener('DOMContentLoaded', animateOnScroll);
    </script>
</body>

</html>
