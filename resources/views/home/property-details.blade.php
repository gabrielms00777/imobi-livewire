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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

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
        <div class="w-full relative shadow-lg mb-8 rounded-xl overflow-hidden bg-base-200">
            <div x-data="{
                swiper: null,
                initSwiper() {
                    this.swiper = new Swiper(this.$refs.swiperContainer, {
                        slidesPerView: 'auto', // Mostra slides parciais
                        spaceBetween: 16, // Espaço entre os slides (16px = gap-4)
                        centeredSlides: true, // Centraliza o slide ativo
                        loop: true, // Loop infinito
                        navigation: {
                            nextEl: this.$refs.swiperNext,
                            prevEl: this.$refs.swiperPrev,
                        },
                        pagination: {
                            el: this.$refs.swiperPagination,
                            clickable: true,
                        },
                        breakpoints: {
                            // Configurações para mobile
                            640: {
                                slidesPerView: 1, // 1 slide por vez em telas pequenas
                                spaceBetween: 0,
                                centeredSlides: false,
                            },
                            // Configurações para tablet e desktop
                            1024: {
                                slidesPerView: 'auto', // 'auto' para o efeito de slides parciais em telas maiores
                                spaceBetween: 16,
                                centeredSlides: true,
                            }
                        }
                    });
                }
            }" x-init="initSwiper()">

                <div class="swiper-container w-full h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] xl:h-[500px] pb-8"
                    x-ref="swiperContainer">
                    <div class="swiper-wrapper">
                        @foreach ($propertyImages as $imageUrl)
                            <div class="swiper-slide rounded-lg overflow-hidden flex items-center justify-center">
                                <img src="{{ $imageUrl }}" class="w-full h-full object-cover"
                                    alt="Imagem do Imóvel">
                            </div>
                        @endforeach
                    </div>

                    <div x-ref="swiperPrev"
                        class="swiper-button-prev btn btn-circle bg-white/50 hover:bg-white text-base-content border-none shadow-md">
                        ❮</div>
                    <div x-ref="swiperNext"
                        class="swiper-button-next btn btn-circle bg-white/50 hover:bg-white text-base-content border-none shadow-md">
                        ❯</div>

                    <div x-ref="swiperPagination" class="swiper-pagination bottom-0"></div>
                </div>

                @if ($property->is_featured)
                    <span class="badge badge-primary absolute top-4 right-4 text-lg p-3 z-20">Destaque</span>
                @endif
            </div>
        </div>

        <style>
            /* Estilos para alinhar os botões de navegação do Swiper */
            .swiper-button-prev,
            .swiper-button-next {
                width: 48px;
                /* daisyui btn-circle default */
                height: 48px;
                /* daisyui btn-circle default */
                color: var(--fallback-bc, oklch(var(--bc)/1));
                /* Cor do texto para DaisyUI neutral-content */
                transform: translateY(-50%);
            }

            .swiper-button-prev::after,
            .swiper-button-next::after {
                font-size: 1.25rem;
                /* Ajusta o tamanho do ícone */
                content: '';
                /* Remove o conteúdo padrão do Swiper */
            }

            /* Ajuste para o position dos botões, se necessário.
       O Swiper coloca absolute, DaisyUI btn-circle já ajuda. */
            .swiper-button-prev {
                left: 1rem;
                /* DaisyUI padding */
            }

            .swiper-button-next {
                right: 1rem;
                /* DaisyUI padding */
            }

            /* Estilo para a paginação (dots) do Swiper */
            .swiper-pagination-bullet {
                background: var(--fallback-nc, oklch(var(--nc)/1));
                /* Cor dos dots inativos */
                opacity: 0.4;
            }

            .swiper-pagination-bullet-active {
                background: var(--fallback-p, oklch(var(--p)/1));
                /* Cor do dot ativo (primary) */
                opacity: 1;
            }

            /* Customização para o espaçamento das slides "auto" para o visual da sua imagem */
            .swiper-slide {
                width: 80% !important;
                /* Ajuste a largura para o slide principal */
            }

            /* Em telas pequenas, queremos 1 slide por vez */
            @media (max-width: 639px) {
                .swiper-slide {
                    width: 100% !important;
                }
            }

            /* Esconde as setas de navegação em telas pequenas, se desejar */
            @media (max-width: 767px) {

                .swiper-button-prev,
                .swiper-button-next {
                    display: none;
                }
            }
        </style>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Informações Principais -->
            <div class="lg:col-span-2">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <h1 class="text-3xl font-bold text-base-content">{{ $property->title ?? 'Título do Imóvel' }}</h1>
                    <div class="text-2xl font-bold text-primary mt-2 md:mt-0">
                        {{ 'R$ ' . number_format($property->price ?? 0, 2, ',', '.') }}
                    </div>
                </div>

                <div class="flex items-center text-lg mb-6 text-base-content">
                    <i class="fas fa-map-marker-alt text-base-content/60 mr-2"></i>
                    <span>
                        {{ $property->address ?? 'Rua Exemplo, 123' }} -
                        {{ $property->neighborhood ?? 'Bairro' }},
                        {{ $property->city ?? 'Cidade' }}/{{ $property->state ?? 'UF' }}
                    </span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-base-200 p-4 rounded-lg text-center text-base-content">
                        <i class="fas fa-bed text-2xl mb-2 text-primary"></i>
                        <div>{{ $property->bedrooms ?? '?' }} Quartos</div>
                    </div>
                    <div class="bg-base-200 p-4 rounded-lg text-center text-base-content">
                        <i class="fas fa-bath text-2xl mb-2 text-primary"></i>
                        <div>{{ $property->bathrooms ?? '?' }} Banheiros</div>
                    </div>
                    <div class="bg-base-200 p-4 rounded-lg text-center text-base-content">
                        <i class="fas fa-ruler-combined text-2xl mb-2 text-primary"></i>
                        <div>{{ $property->area ?? '?' }} m²</div>
                    </div>
                    <div class="bg-base-200 p-4 rounded-lg text-center text-base-content">
                        <i class="fas fa-car text-2xl mb-2 text-primary"></i>
                        <div>{{ $property->parking_spaces ?? '?' }} Vagas</div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4 text-base-content">Descrição do Imóvel</h2>
                    <p class="mb-4 text-base-content/80">
                        {{ $property->description ?? 'Esta é a descrição detalhada do imóvel. Nenhuma descrição foi fornecida para este imóvel.' }}
                    </p>
                </div>

                @php
                    // Decodifica os destaques se forem uma string JSON, caso contrário usa um array vazio
                    $highlights = is_string($property->highlights ?? null)
                        ? json_decode($property->highlights, true)
                        : $property->highlights ?? [];
                @endphp

                @if (!empty($highlights))
                    <div class="mb-8">
                        <h2 class="text-xl font-bold mb-4 text-base-content">Destaques</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @foreach ($highlights as $highlight)
                                <div class="flex items-center text-base-content/80">
                                    <i class="fas fa-check-circle text-primary mr-2"></i>
                                    <span>{{ $highlight }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-8">
                    <h2 class="text-xl font-bold mb-4 text-base-content">Localização</h2>
                    <div class="bg-base-200 rounded-xl overflow-hidden h-64">
                        @php
                            // Constrói o endereço completo para o mapa
                            $fullAddress = urlencode(
                                ($property->address ?? '') .
                                    ', ' .
                                    ($property->neighborhood ?? '') .
                                    ', ' .
                                    ($property->city ?? '') .
                                    ' - ' .
                                    ($property->state ?? ''),
                            );
                            // URL do Google Maps Embed. Não requer chave API para embeds básicos
                            $mapSrc = "https://maps.google.com/maps?q={$fullAddress}&t=&z=15&ie=UTF8&iwloc=&output=embed";
                        @endphp
                        <iframe src="{{ $mapSrc }}" width="100%" height="100%" style="border:0;"
                            allowfullscreen="" loading="lazy" class="filter grayscale(50%) contrast(1.2)"></iframe>
                    </div>
                </div>
            </div>

            <!-- Sidebar - Contato e Informações -->
            {{-- <div class="lg:col-span-1">
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
            </div> --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="card bg-base-100 shadow-xl mb-6 text-base-content">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Interessado neste imóvel?</h2>

                            <template x-if="!showContactForm">
                                <div>
                                    <p class="mb-4">Entre em contato com nosso corretor especializado para agendar
                                        uma visita ou obter mais informações.</p>
                                    <button @click="showContactForm = true" class="btn btn-primary w-full mb-4">
                                        <i class="fas fa-envelope mr-2"></i> Enviar Mensagem
                                    </button>
                                    {{-- O número de telefone do corretor deve vir do backend --}}
                                    <a href="tel:{{ $broker->phone ?? '+5511999999999' }}"
                                        class="btn btn-outline btn-primary w-full">
                                        <i class="fas fa-phone-alt mr-2"></i> Ligar Agora
                                    </a>
                                </div>
                            </template>

                            <template x-if="showContactForm">
                                <form class="space-y-4">
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text text-base-content/80">Seu Nome</span>
                                        </label>
                                        <input type="text" placeholder="Nome completo"
                                            class="input input-bordered w-full">
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text text-base-content/80">Seu Telefone</span>
                                        </label>
                                        <input type="tel" placeholder="(00) 00000-0000"
                                            class="input input-bordered w-full">
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text text-base-content/80">Seu E-mail</span>
                                        </label>
                                        <input type="email" placeholder="seu@email.com"
                                            class="input input-bordered w-full">
                                    </div>
                                    <div class="form-control">
                                        <label class="label">
                                            <span class="label-text text-base-content/80">Mensagem</span>
                                        </label>
                                        <textarea class="textarea textarea-bordered h-24 w-full"
                                            placeholder="Gostaria de mais informações sobre este imóvel..."></textarea>
                                    </div>
                                    <div class="form-control mt-6">
                                        <button type="submit" class="btn btn-primary w-full">Enviar Mensagem</button>
                                        {{-- Changed to type="submit" --}}
                                        <button type="button" @click="showContactForm = false"
                                            class="btn btn-ghost w-full mt-2">Cancelar</button> {{-- Add a cancel button --}}
                                    </div>
                                </form>
                            </template>
                        </div>
                    </div>

                    @php
                        // Simulação de um objeto $broker se ele não estiver sendo passado diretamente
                        // No seu controlador real, você buscará o corretor associado ao imóvel
                        $broker =
                            $broker ??
                            (object) [
                                'name' => 'Carlos Silva',
                                'creci' => '123456-SP',
                                'phone' => '+5511999999999',
                                'email' => 'carlos@imobiliaria.com',
                                'avatar_url' => 'https://randomuser.me/api/portraits/men/32.jpg', // Imagem padrão
                            ];
                    @endphp
                    <div class="card bg-base-100 shadow-xl text-base-content">
                        <div class="card-body">
                            <h2 class="card-title mb-4">Corretor Responsável</h2>
                            <div class="flex items-center mb-4">
                                <div class="avatar mr-4">
                                    <div class="w-16 rounded-full">
                                        <img src="{{ $broker->avatar_url ?? 'https://via.placeholder.com/150' }}"
                                            alt="Corretor">
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-bold">{{ $broker->name ?? 'Corretor Desconhecido' }}</h3>
                                    <p class="text-sm">CRECI: {{ $broker->creci ?? 'Não Informado' }}</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <i class="fas fa-phone-alt text-primary mr-2"></i>
                                    <span>{{ $broker->phone ?? '(00) 00000-0000' }}</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-envelope text-primary mr-2"></i>
                                    <span>{{ $broker->email ?? 'contato@imobiliaria.com' }}</span>
                                </div>
                                {{-- Adicionar botão WhatsApp (opcional) --}}
                                @if ($broker->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $broker->phone) }}?text=Ol%C3%A1%2C%20gostaria%20de%20mais%20informa%C3%A7%C3%B5es%20sobre%20o%20im%C3%B3vel%3A%20{{ urlencode($property->title ?? 'Im%C3%B3vel') }}%20-%20{{ urlencode(Request::url()) }}"
                                        target="_blank" class="btn btn-success btn-sm w-full mt-4">
                                        <i class="fab fa-whatsapp mr-2"></i> Mensagem via WhatsApp
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Imóveis Similares -->
        <section class="mt-16">
            <h2 class="text-2xl font-bold mb-8 text-base-content">Imóveis Similares</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    // Simulação de dados para imóveis similares, caso $similarProperties não esteja definida
                    // No seu controlador, você buscará os imóveis similares e os passará para a view.
                    $similarProperties = $similarProperties ?? [
                        (object) [
                            'id' => 101,
                            'image_url' =>
                                'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                            'title' => 'Apartamento na Zona Sul',
                            'location' => 'Zona Sul, São Paulo',
                            'bedrooms' => 3,
                            'bathrooms' => 2,
                            'area' => 90,
                            'price' => 750000,
                        ],
                        (object) [
                            'id' => 102,
                            'image_url' =>
                                'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                            'title' => 'Casa com Jardim Amplo',
                            'location' => 'Vila Mariana, São Paulo',
                            'bedrooms' => 4,
                            'bathrooms' => 3,
                            'area' => 150,
                            'price' => 1200000,
                        ],
                        (object) [
                            'id' => 103,
                            'image_url' =>
                                'https://images.unsplash.com/photo-1600566752225-53769df8b5e5?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80',
                            'title' => 'Cobertura Moderna',
                            'location' => 'Itaim Bibi, São Paulo',
                            'bedrooms' => 3,
                            'bathrooms' => 2,
                            'area' => 110,
                            'price' => 950000,
                        ],
                    ];
                @endphp

                @forelse($similarProperties as $similarProperty)
                    <div
                        class="property-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300 text-base-content">
                        <figure>
                            <img src="{{ $similarProperty->image_url ?? 'https://via.placeholder.com/500x300?text=Sem+Imagem' }}"
                                alt="{{ $similarProperty->title ?? 'Imóvel' }}" class="h-48 w-full object-cover">
                        </figure>
                        <div class="card-body p-4">
                            <h3 class="card-title text-base-content">{{ $similarProperty->title ?? 'Imóvel Similar' }}
                            </h3>
                            <div class="flex items-center text-sm mb-2 text-base-content/80">
                                <i class="fas fa-map-marker-alt mr-2 text-base-content/60"></i>
                                <span>{{ $similarProperty->location ?? 'Localização Desconhecida' }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm mb-3 text-base-content/80">
                                <div>
                                    <i class="fas fa-bed mr-1"></i>
                                    <span>{{ $similarProperty->bedrooms ?? '?' }} Quartos</span>
                                </div>
                                <div>
                                    <i class="fas fa-bath mr-1"></i>
                                    <span>{{ $similarProperty->bathrooms ?? '?' }} Banheiros</span>
                                </div>
                                <div>
                                    <i class="fas fa-ruler-combined mr-1"></i>
                                    <span>{{ $similarProperty->area ?? '?' }}m²</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-primary">R$
                                    {{ number_format($similarProperty->price ?? 0, 2, ',', '.') }}</span>
                                {{-- Link para a página de detalhes do imóvel similar --}}
                                {{-- <a href="{{ route('tenant.property.show', ['tenantSlug' => $tenant->slug, 'propertyId' => $similarProperty->id]) }}" --}}
                                <a 
                                    class="btn btn-xs btn-outline btn-primary">Ver Detalhes</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-base-content/70">Nenhum imóvel similar encontrado no
                        momento.</p>
                @endforelse
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
