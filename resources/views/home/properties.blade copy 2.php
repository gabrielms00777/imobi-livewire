<!DOCTYPE html>
<html lang="pt-BR" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO: Título da Página --}}
    {{-- Prioriza meta_title, depois site_name com sufixo, senão um padrão --}}
    <title>
        {{ $tenantSettings->meta_title ?? ($tenantSettings->site_name ? $tenantSettings->site_name . ' - Encontre seu imóvel dos sonhos' : 'Sua Imobiliária - Encontre seu imóvel dos sonhos') }}
    </title>

    {{-- SEO: Meta Descrição --}}
    {{-- Prioriza meta_description, depois site_description, senão um padrão --}}
    <meta name="description"
        content="{{ $tenantSettings->meta_description ?? ($tenantSettings->site_description ?? 'Encontre o imóvel perfeito para você com a nossa imobiliária. Temos apartamentos, casas, terrenos e mais.') }}">

    {{-- SEO: Meta Keywords --}}
    @if ($tenantSettings->meta_keywords)
        <meta name="keywords" content="{{ $tenantSettings->meta_keywords }}">
    @endif

    {{-- SEO: Favicon --}}
    {{-- O site_favicon guarda o caminho do arquivo, então usamos Storage::url() --}}
    @if ($tenantSettings->site_favicon)
        <link rel="icon" href="{{ Storage::url($tenantSettings->site_favicon) }}" type="image/x-icon">
    @endif

    {{-- Open Graph Meta Tags (para compartilhamento em redes sociais como Facebook, LinkedIn) --}}
    <meta property="og:title"
        content="{{ $tenantSettings->meta_title ?? ($tenantSettings->site_name ? $tenantSettings->site_name . ' - Encontre seu imóvel dos sonhos' : 'Sua Imobiliária - Encontre seu imóvel dos sonhos') }}">
    <meta property="og:description"
        content="{{ $tenantSettings->meta_description ?? ($tenantSettings->site_description ?? 'Encontre o imóvel perfeito para você com a nossa imobiliária. Temos apartamentos, casas, terrenos e mais.') }}">
    {{-- A meta_image guarda o caminho do arquivo, então usamos Storage::url() --}}
    @if ($tenantSettings->meta_image)
        <meta property="og:image" content="{{ Storage::url($tenantSettings->meta_image) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}"> {{-- URL canônica da página atual --}}
    <meta property="og:type" content="website"> {{-- Tipo de conteúdo --}}

    {{-- Twitter Card Meta Tags (para compartilhamento no Twitter/X) --}}
    <meta name="twitter:card" content="summary_large_image"> {{-- Tipo de card, 'summary_large_image' é comum para imagens --}}
    <meta name="twitter:title"
        content="{{ $tenantSettings->meta_title ?? ($tenantSettings->site_name ? $tenantSettings->site_name . ' - Encontre seu imóvel dos sonhos' : 'Sua Imobiliária - Encontre seu imóvel dos sonhos') }}">
    <meta name="twitter:description"
        content="{{ $tenantSettings->meta_description ?? ($tenantSettings->site_description ?? 'Encontre o imóvel perfeito para você com a nossa imobiliária. Temos apartamentos, casas, terrenos e mais.') }}">
    {{-- A meta_image guarda o caminho do arquivo, então usamos Storage::url() --}}
    @if ($tenantSettings->meta_image)
        <meta name="twitter:image" content="{{ Storage::url($tenantSettings->meta_image) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    {{-- O script @tailwindcss/browser é mais para desenvolvimento. Em produção, geralmente o Tailwind é compilado. --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Estilos Customizados -->
    <style>
        :root {
            --color-primary: {{ $tenantSettings->primary_color ?? '#3b82f6' }};
            --color-secondary: {{ $tenantSettings->secondary_color ?? '#f63b3b' }};
            --color-neutral: {{ $tenantSettings->text_color ?? '#333333' }};
            /* Adicionado fallback para text_color */
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .fixed-sidebar {
            width: 280px;
            min-width: 280px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 50;
        }

        .content-area {
            flex-grow: 1;
        }

        @media (min-width: 1024px) {
            .content-area {
                margin-left: 280px;
            }
        }

        .property-card .carousel-item {
            transition: transform 0.5s ease;
        }

        .filter-badge {
            transition: all 0.2s ease;
        }

        .filter-badge:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <header x-data="{ isScrolled: false }" @scroll.window="isScrolled = window.scrollY > 300"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="isScrolled ? 'bg-white shadow-md dark:bg-neutral' : 'bg-transparent'">

        <div class="container mx-auto px-4">
            <div class="navbar">
                <div class="flex-1">
                    <a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}" class="px-0">
                        <div class="flex items-center">
                            @if ($tenantSettings->site_logo && $tenantSettings->header_display_type == 'logo_and_name')
                                <img src="{{ $tenantSettings->site_logo }}"
                                    alt="Logo {{ $tenantSettings->site_name }}" class="h-8 w-auto mr-2 rounded-lg">
                                @php
                                    $words = explode(' ', $tenantSettings->site_name); // Divide o nome em um array de palavras
                                    $firstWord = array_shift($words); // Pega a primeira palavra e a remove do array
                                    $remainingWords = implode(' ', $words); // Junta as palavras restantes de volta em uma string
                                @endphp
                                <span class="text-xl font-bold text-primary">{{ $firstWord ?? '' }}</span>
                                @if (!empty($remainingWords))
                                    {{-- Se houver palavras restantes, exibe-as em secondary --}}
                                    <span class="text-xl font-bold text-secondary">{{ $remainingWords }}</span>
                                @endif
                            @elseif ($tenantSettings->site_logo && $tenantSettings->header_display_type == 'logo_only')
                                <img src="{{ $tenantSettings->site_logo }}"
                                    alt="Logo {{ $tenantSettings->site_name }}" class="h-10 w-auto rounded-lg">
                            @elseif ($tenantSettings->site_name && $tenantSettings->header_display_type == 'name_only')
                                @php
                                    $words = explode(' ', $tenantSettings->site_name); // Divide o nome em um array de palavras
                                    $firstWord = array_shift($words); // Pega a primeira palavra e a remove do array
                                    $remainingWords = implode(' ', $words); // Junta as palavras restantes de volta em uma string
                                @endphp
                                <span class="text-xl font-bold text-primary">{{ $firstWord ?? '' }}</span>
                                @if (!empty($remainingWords))
                                    {{-- Se houver palavras restantes, exibe-as em secondary --}}
                                    <span class="text-xl font-bold text-secondary">{{ $remainingWords }}</span>
                                @endif
                            @else
                                <span class="text-xl font-bold text-primary">Seu Site</span>
                            @endif
                        </div>
                    </a>
                </div>

                <div class="flex-none hidden lg:flex items-center gap-2">
                    {{-- <nav class="flex items-center">
                        <ul class="menu menu-horizontal px-1 gap-1">
                            <li><a href="#" class="font-medium hover:text-primary">Início</a></li>
                            <li><a href="#destaques" class="font-medium hover:text-primary">Destaques</a></li>
                            <li><a href="#sobre" class="font-medium hover:text-primary">Sobre</a></li>
                            <li><a href="#contato" class="font-medium hover:text-primary">Contato</a></li>
                            @if (auth()->check())
                                <li><a href="/admin" class="font-medium hover:text-primary">Dashboard</a></li>
                            @else
                                <li><a href="/login" class="font-medium hover:text-primary">Login</a></li>
                            @endif
                        </ul>
                    </nav>

                    <div class="divider divider-horizontal h-6 mx-2"></div> --}}

                    <div class="flex items-center gap-2 mr-4">
                        @if ($tenantSettings->social_facebook)
                            <a href="{{ $tenantSettings->social_facebook }}"
                                class="btn btn-ghost btn-circle btn-sm hover:text-primary">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if ($tenantSettings->social_instagram)
                            <a href="{{ $tenantSettings->social_instagram }}"
                                class="btn btn-ghost btn-circle btn-sm hover:text-primary">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if ($tenantSettings->social_linkedin)
                            <a href="{{ $tenantSettings->social_linkedin }}"
                                class="btn btn-ghost btn-circle btn-sm hover:text-primary">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                        @if ($tenantSettings->social_youtube)
                            <a href="{{ $tenantSettings->social_youtube }}"
                                class="btn btn-ghost btn-circle btn-sm hover:text-primary">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif
                    </div>

                    <a href="https://wa.me/{{ $tenantSettings->social_whatsapp }}"
                        class="btn btn-primary btn-sm md:btn-md gap-2">
                        <i class="fab fa-whatsapp"></i>
                        <span class="hidden sm:inline">{{ $tenantSettings->contact_phone }}</span>
                    </a>
                </div>

                <div class="flex-none lg:hidden">
                    <label for="mobile-menu" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>
            </div>
        </div>

        <input type="checkbox" id="mobile-menu" class="drawer-toggle">
        <div class="drawer-side z-50">
            <label for="mobile-menu" class="drawer-overlay"></label>
            <div class="menu p-4 w-80 h-full bg-base-100 text-base-content">
                <div class="flex items-center justify-between mb-6">
                    <a href="#" class="text-xl font-bold text-primary">Imobiliária<span
                            class="text-secondary">Premium</span></a>
                    <label for="mobile-menu" class="btn btn-ghost btn-circle">
                        <i class="fas fa-times"></i>
                    </label>
                </div>

                <ul class="space-y-2">
                    <li><a href="#" class="font-medium">Início</a></li>
                    <li><a href="#destaques" class="font-medium">Destaques</a></li>
                    <li><a href="#sobre" class="font-medium">Sobre</a></li>
                    <li><a href="#contato" class="font-medium">Contato</a></li>
                    <li><a href="/login" class="font-medium">Login</a></li>
                </ul>

                <div class="divider my-4"></div>

                <div class="flex justify-center gap-4 mb-6">
                    @if ($tenantSettings->social_facebook)
                        <a href="{{ $tenantSettings->social_facebook }}" class="btn btn-ghost btn-circle">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if ($tenantSettings->social_instagram)
                        <a href="{{ $tenantSettings->social_instagram }}" class="btn btn-ghost btn-circle">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if ($tenantSettings->social_linkedin)
                        <a href="{{ $tenantSettings->social_linkedin }}" class="btn btn-ghost btn-circle">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    @endif
                </div>

                <a href="https://wa.me/{{ $tenantSettings->social_whatsapp }}" class="btn btn-primary gap-2">
                    <i class="fab fa-whatsapp"></i>
                    {{ $tenantSettings->contact_phone }}
                </a>
            </div>
        </div>
    </header>

    <!-- Sidebar Fixa (Desktop) -->
    <aside class="fixed-sidebar hidden mt-16 lg:flex flex-col p-6">
        <form method="GET" action="{{ route('demo.properties') }}">
            <!-- Logotipo -->
            {{-- <a href="{{ route('demo.properties') }}" class="btn btn-ghost text-2xl font-bold text-primary mb-8">Imóveis.com</a> --}}

            <!-- Título Filtros -->
            <h3 class="text-xl font-bold mb-6">Filtros</h3>

            <!-- Formulário de Filtros -->
            <div class="space-y-6">
                <!-- Localização -->
                <div>
                    <label class="label">
                        <span class="label-text font-medium">Localização</span>
                    </label>
                    <input type="text" name="location" placeholder="Cidade, Bairro, Estado"
                        class="input input-bordered w-full" value="{{ $filters['location'] }}" />
                </div>

                <!-- Tipo de Imóvel -->
                <div>
                    <label class="label">
                        <span class="label-text font-medium">Tipo de Imóvel</span>
                    </label>
                    <select class="select select-bordered w-full" name="type">
                        <option value="">Todos</option>
                        @foreach ($propertyTypes as $type)
                            <option value="{{ $type }}" {{ $filters['type'] == $type ? 'selected' : '' }}>
                                {{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Quartos -->
                <div>
                    <label class="label">
                        <span class="label-text font-medium">Quartos: {{ $filters['bedrooms'] }}+</span>
                    </label>
                    <input type="range" name="bedrooms" min="0" max="5" step="1"
                        class="range range-primary range-xs" value="{{ $filters['bedrooms'] }}" />
                    <div class="w-full flex justify-between text-xs px-2">
                        <span>0</span>
                        <span>1</span>
                        <span>2</span>
                        <span>3</span>
                        <span>4</span>
                        <span>5+</span>
                    </div>
                </div>

                <!-- Banheiros -->
                <div>
                    <label class="label">
                        <span class="label-text font-medium">Banheiros: {{ $filters['bathrooms'] }}+</span>
                    </label>
                    <input type="range" name="bathrooms" min="0" max="4" step="1"
                        class="range range-primary range-xs" value="{{ $filters['bathrooms'] }}" />
                    <div class="w-full flex justify-between text-xs px-2">
                        <span>0</span>
                        <span>1</span>
                        <span>2</span>
                        <span>3</span>
                        <span>4+</span>
                    </div>
                </div>

                <!-- Vagas -->
                <div>
                    <label class="label">
                        <span class="label-text font-medium">Vagas: {{ $filters['parking'] }}+</span>
                    </label>
                    <input type="range" name="parking" min="0" max="3" step="1"
                        class="range range-primary range-xs" value="{{ $filters['parking'] }}" />
                    <div class="w-full flex justify-between text-xs px-2">
                        <span>0</span>
                        <span>1</span>
                        <span>2</span>
                        <span>3+</span>
                    </div>
                </div>

                <!-- Faixa de Preço -->
                <div>
                    <label class="label">
                        <span class="label-text font-medium">Faixa de Preço (R$)</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="number" name="min_price" placeholder="Mínimo"
                            class="input input-bordered w-full" value="{{ $filters['min_price'] }}" />
                        <input type="number" name="max_price" placeholder="Máximo"
                            class="input input-bordered w-full" value="{{ $filters['max_price'] }}" />
                    </div>
                </div>

                <!-- Área -->
                <div>
                    <label class="label">
                        <span class="label-text font-medium">Área (m²)</span>
                    </label>
                    <div class="flex gap-2">
                        <input type="number" name="min_area" placeholder="Mínimo"
                            class="input input-bordered w-full" value="{{ $filters['min_area'] }}" />
                        <input type="number" name="max_area" placeholder="Máximo"
                            class="input input-bordered w-full" value="{{ $filters['max_area'] }}" />
                    </div>
                </div>

                <!-- Características -->
                <div>
                    <label class="label">
                        <span class="label-text font-medium">Características</span>
                    </label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="features[]" value="Piscina"
                                class="checkbox checkbox-primary"
                                {{ in_array('Piscina', $filters['features']) ? 'checked' : '' }} />
                            <span>Piscina</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="features[]" value="Academia"
                                class="checkbox checkbox-primary"
                                {{ in_array('Academia', $filters['features']) ? 'checked' : '' }} />
                            <span>Academia</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="features[]" value="Jardim"
                                class="checkbox checkbox-primary"
                                {{ in_array('Jardim', $filters['features']) ? 'checked' : '' }} />
                            <span>Jardim</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="features[]" value="Portaria 24h"
                                class="checkbox checkbox-primary"
                                {{ in_array('Portaria 24h', $filters['features']) ? 'checked' : '' }} />
                            <span>Portaria 24h</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="features[]" value="Mobiliado"
                                class="checkbox checkbox-primary"
                                {{ in_array('Mobiliado', $filters['features']) ? 'checked' : '' }} />
                            <span>Mobiliado</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="features[]" value="Permite Animais"
                                class="checkbox checkbox-primary"
                                {{ in_array('Permite Animais', $filters['features']) ? 'checked' : '' }} />
                            <span>Permite Animais</span>
                        </label>
                    </div>
                </div>

                <!-- Botões -->
                <div class="pt-4 space-y-2">
                    <button type="submit" class="btn btn-primary w-full">
                        Aplicar Filtros
                    </button>
                    <a href="{{ route('demo.properties') }}" class="btn btn-outline w-full">
                        Limpar Filtros
                    </a>
                </div>
            </div>
        </form>
    </aside>

    <!-- Área de Conteúdo Principal -->
    <main class="content-area mt-16">
        <!-- Navbar Mobile -->
        <nav class="navbar fixed top-0 left-0 right-0 z-40 bg-base-100 shadow-md ">
            <div class="navbar-start">
                <a href="{{ route('demo.properties') }}"
                    class="btn btn-ghost text-xl font-bold text-primary">Imóveis.com</a>
            </div>
            <div class="navbar-end">
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost">
                        <i class="fas fa-sliders-h"></i>
                        <span>Filtros</span>
                    </div>
                    <div tabindex="0"
                        class="dropdown-content z-[1] mt-3 p-2 shadow bg-base-100 rounded-box w-screen max-h-[80vh] overflow-y-auto"
                        style="margin-left: -16rem;">
                        <!-- Filtros Mobile -->
                        <form method="GET" action="{{ route('demo.properties') }}" class="p-4 space-y-4">
                            <!-- Localização -->
                            <div>
                                <label class="label">
                                    <span class="label-text font-medium">Localização</span>
                                </label>
                                <input type="text" name="location" placeholder="Cidade, Bairro, Estado"
                                    class="input input-bordered w-full" value="{{ $filters['location'] }}" />
                            </div>

                            <!-- Tipo de Imóvel -->
                            <div>
                                <label class="label">
                                    <span class="label-text font-medium">Tipo de Imóvel</span>
                                </label>
                                <select class="select select-bordered w-full" name="type">
                                    <option value="">Todos</option>
                                    @foreach ($propertyTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ $filters['type'] == $type ? 'selected' : '' }}>{{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Quartos -->
                            <div>
                                <label class="label">
                                    <span class="label-text font-medium">Quartos: {{ $filters['bedrooms'] }}+</span>
                                </label>
                                <input type="range" name="bedrooms" min="0" max="5" step="1"
                                    class="range range-primary range-xs" value="{{ $filters['bedrooms'] }}" />
                                <div class="w-full flex justify-between text-xs px-2">
                                    <span>0</span>
                                    <span>1</span>
                                    <span>2</span>
                                    <span>3</span>
                                    <span>4</span>
                                    <span>5+</span>
                                </div>
                            </div>

                            <!-- Botões -->
                            <div class="pt-4 space-y-2">
                                <button type="submit" class="btn btn-primary w-full">
                                    Aplicar Filtros
                                </button>
                                <a href="{{ route('demo.properties') }}" class="btn btn-outline w-full">
                                    Limpar Filtros
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section com Formulário de Busca Integrado -->
        <div id="hero-section"
            class="relative min-h-[400px] flex items-center justify-center mb-4 mt-4 rounded-box shadow-lg overflow-hidden bg-linear-to-r from-cyan-500 to-blue-500">
            {{-- style="background-image: url('https://placehold.co/1600x800/1e40af/ffffff?text=Encontre+seu+imóvel+perfeito'); background-size: cover; background-position: center;"> --}}
            {{-- style="background-image: url('https://placehold.co/1600x800/1e40af/ffffff'); background-size: cover; background-position: center;"> --}}
            <div class="hero-overlay bg-opacity-60 rounded-box absolute inset-0"></div>

            <div class="relative z-10 flex flex-col items-center justify-center h-full text-neutral-content p-4">
                <div class="text-center max-w-2xl">
                    <h1 class="mb-5 text-4xl md:text-5xl font-bold">Encontre seu imóvel dos sonhos</h1>
                    <p class="mb-5 text-lg">Busque entre milhares de propriedades em todo o Brasil</p>
                </div>
            </div>
        </div>

        <!-- Seção de Filtros Ativos (abaixo do Hero) -->
        @if (request()->anyFilled([
                'search',
                'location',
                'type',
                'bedrooms',
                'bathrooms',
                'parking',
                'min_price',
                'max_price',
                'min_area',
                'max_area',
                'features',
            ]))
            <section class="container mx-auto px-4 py-4 mb-8">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <h2 class="text-xl font-bold text-gray-800">Resultados para:</h2>
                    <a href="{{ route('demo.properties') }}" class="btn btn-sm btn-outline btn-error">
                        Limpar Todos os Filtros
                    </a>
                </div>

                <div class="flex flex-wrap gap-2">
                    @if ($filters['search'])
                        <div class="badge badge-lg badge-info text-white">
                            <span>Busca: {{ $filters['search'] }}</span>
                            <a href="{{ route('demo.properties', array_merge(request()->except('search'), ['page' => 1])) }}"
                                class="ml-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                    @if ($filters['location'])
                        <div class="badge badge-lg badge-info text-white">
                            <span>Local: {{ $filters['location'] }}</span>
                            <a href="{{ route('demo.properties', array_merge(request()->except('location'), ['page' => 1])) }}"
                                class="ml-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                    @if ($filters['type'])
                        <div class="badge badge-lg badge-info text-white">
                            <span>Tipo: {{ $filters['type'] }}</span>
                            <a href="{{ route('demo.properties', array_merge(request()->except('type'), ['page' => 1])) }}"
                                class="ml-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                    @if ($filters['bedrooms'] > 0)
                        <div class="badge badge-lg badge-info text-white">
                            <span>Quartos: {{ $filters['bedrooms'] }}+</span>
                            <a href="{{ route('demo.properties', array_merge(request()->except('bedrooms'), ['page' => 1])) }}"
                                class="ml-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                    @if ($filters['bathrooms'] > 0)
                        <div class="badge badge-lg badge-info text-white">
                            <span>Banheiros: {{ $filters['bathrooms'] }}+</span>
                            <a href="{{ route('demo.properties', array_merge(request()->except('bathrooms'), ['page' => 1])) }}"
                                class="ml-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                    @if ($filters['parking'] > 0)
                        <div class="badge badge-lg badge-info text-white">
                            <span>Vagas: {{ $filters['parking'] }}+</span>
                            <a href="{{ route('demo.properties', array_merge(request()->except('parking'), ['page' => 1])) }}"
                                class="ml-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                    @if ($filters['min_price'] || $filters['max_price'])
                        <div class="badge badge-lg badge-info text-white">
                            <span>
                                Preço:
                                {{ $filters['min_price'] ? 'R$ ' . number_format($filters['min_price'], 2, ',', '.') : 'Qualquer' }}
                                -
                                {{ $filters['max_price'] ? 'R$ ' . number_format($filters['max_price'], 2, ',', '.') : 'Qualquer' }}
                            </span>
                            <a href="{{ route('demo.properties', array_merge(request()->except(['min_price', 'max_price']), ['page' => 1])) }}"
                                class="ml-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                    @if ($filters['min_area'] || $filters['max_area'])
                        <div class="badge badge-lg badge-info text-white">
                            <span>
                                Área:
                                {{ $filters['min_area'] ? $filters['min_area'] . 'm²' : 'Qualquer' }}
                                -
                                {{ $filters['max_area'] ? $filters['max_area'] . 'm²' : 'Qualquer' }}
                            </span>
                            <a href="{{ route('demo.properties', array_merge(request()->except(['min_area', 'max_area']), ['page' => 1])) }}"
                                class="ml-1">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                    @if ($filters['features'] && count($filters['features']) > 0)
                        @foreach ($filters['features'] as $feature)
                            <div class="badge badge-lg badge-info text-white">
                                <span>Característica: {{ $feature }}</span>
                                <a href="{{ route('demo.properties', array_merge(request()->except('features'), ['features' => array_diff($filters['features'], [$feature])]), ['page' => 1]) }}"
                                    class="ml-1">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </section>
        @endif


        <!-- Seção de Resultados -->
        <section class="container mx-auto px-4 py-4">
            <!-- Cabeçalho e Ordenação -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <h2 class="text-2xl font-bold">Resultados da Busca ({{ $totalProperties }}
                    Imóvel{{ $totalProperties != 1 ? 'es' : '' }})</h2>

                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium">Ordenar por:</span>
                    <form method="GET" action="{{ route('demo.properties') }}">
                        <!-- Manter todos os filtros na URL -->
                        @foreach (request()->except('sort_by', 'page') as $key => $value)
                            @if (is_array($value))
                                @foreach ($value as $item)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach

                        <select class="select select-bordered select-sm" name="sort_by"
                            onchange="this.form.submit()">
                            <option value="recent" {{ $sortBy == 'recent' ? 'selected' : '' }}>Mais Recentes</option>
                            <option value="price-asc" {{ $sortBy == 'price-asc' ? 'selected' : '' }}>Preço (Menor para
                                Maior)</option>
                            <option value="price-desc" {{ $sortBy == 'price-desc' ? 'selected' : '' }}>Preço (Maior
                                para Menor)</option>
                            <option value="popular" {{ $sortBy == 'popular' ? 'selected' : '' }}>Mais Populares
                            </option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Lista de Imóveis -->
            <!-- Lista de Imóveis -->
            <div class="grid grid-cols-1 gap-8">
                @forelse($properties as $property)
                    <div
                        class="card lg:card-side bg-base-100 shadow-xl property-card overflow-hidden transition-transform transform hover:scale-[1.01] duration-300 ease-in-out">
                        <figure class="lg:w-2/5 lg:h-full h-[250px] relative">
                            <div x-data="{
                                currentImageIndex: 0,
                                startX: 0,
                                endX: 0,
                                handleTouchStart(event) {
                                    // Registra a posição inicial do toque
                                    this.startX = event.touches[0].clientX;
                                },
                                handleTouchMove(event) {
                                    // Registra a posição atual do toque enquanto arrasta
                                    this.endX = event.touches[0].clientX;
                                },
                                handleTouchEnd() {
                                    // Calcula a diferença para determinar a direção do swipe
                                    const diff = this.startX - this.endX;
                                    const threshold = 50; // Limiar mínimo para considerar um swipe
                            
                                    if (diff > threshold) { // Swipe para a esquerda (próxima imagem)
                                        this.currentImageIndex = (this.currentImageIndex + 1) % {{ count($property['imagens']) }};
                                    } else if (diff < -threshold) { // Swipe para a direita (imagem anterior)
                                        this.currentImageIndex = (this.currentImageIndex - 1 + {{ count($property['imagens']) }}) % {{ count($property['imagens']) }};
                                    }
                                    // Reseta as posições de toque
                                    this.startX = 0;
                                    this.endX = 0;
                                }
                            }" @touchstart.passive="handleTouchStart($event)"
                                @touchmove.passive="handleTouchMove($event)" @touchend="handleTouchEnd()"
                                class="carousel w-full h-full flex flex-col justify-center items-center">
                                <div class="relative w-full h-full overflow-hidden">
                                    <!-- Container para os itens do carrossel, adicionado overflow-hidden para cortar as imagens fora da tela -->
                                    @foreach ($property['imagens'] as $index => $image)
                                        <div x-show="currentImageIndex === {{ $index }}"
                                            x-transition:enter="transition ease-out duration-500"
                                            x-transition:enter-start="transform translate-x-full opacity-0"
                                            x-transition:enter-end="transform translate-x-0 opacity-100"
                                            x-transition:leave="transition ease-in duration-500"
                                            x-transition:leave-start="transform translate-x-0 opacity-100"
                                            x-transition:leave-end="transform -translate-x-full opacity-0"
                                            class="carousel-item absolute top-0 left-0 w-full h-full">
                                            <!-- A imagem é exibida ou ocultada pelo x-show. A opacidade é controlada pelas bolinhas de navegação. -->
                                            <!-- Novo div para manter a proporção de aspecto (16:9) -->
                                            <div class="relative w-full" style="padding-bottom: 56.25%;">
                                                <img src="{{ $image }}" alt="{{ $property['titulo'] }}"
                                                    class="absolute top-0 left-0 w-full h-full object-cover" />
                                            </div>

                                            <!-- Controles de navegação (setas) -->
                                            <div
                                                class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                                <button
                                                    @click="currentImageIndex = (currentImageIndex - 1 + {{ count($property['imagens']) }}) % {{ count($property['imagens']) }}"
                                                    class="btn btn-circle btn-sm">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <button
                                                    @click="currentImageIndex = (currentImageIndex + 1) % {{ count($property['imagens']) }}"
                                                    class="btn btn-circle btn-sm">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Div para as bolinhas de paginação -->
                                <div class="flex justify-center z-10 -mt-8 w-full py-2 gap-2">
                                    @foreach ($property['imagens'] as $index => $image)
                                        <button @click="currentImageIndex = {{ $index }}"
                                            :class="{
                                                'opacity-100 bg-gray-700': currentImageIndex ===
                                                    {{ $index }},
                                                'opacity-50 bg-gray-400': currentImageIndex !==
                                                    {{ $index }}
                                            }"
                                            class="w-3 h-3 rounded-full transition-opacity duration-300"
                                            aria-label="Ir para imagem {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>
                            </div>


                            <!-- Badges -->
                            <div class="absolute w-10 h-10 top-4 left-4 flex gap-2">
                                @if ($property['isFeatured'])
                                    <span class="badge badge-secondary">DESTAQUE</span>
                                @endif
                                @if ($property['isNew'])
                                    <span class="badge badge-accent">NOVO</span>
                                @endif
                            </div>
                        </figure>

                        <div class="card-body lg:w-3/5 p-6">
                            <h3 class="card-title text-2xl">R$ {{ number_format($property['preco'], 2, ',', '.') }}
                            </h3>
                            <h4 class="text-xl font-semibold">{{ $property['titulo'] }}</h4>
                            <p class="flex items-center gap-2 text-gray-600">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $property['endereco'] }}, {{ $property['bairro'] }}, {{ $property['cidade'] }} -
                                {{ $property['estado'] }}
                            </p>
                            <p>{{ $property['descricao_curta'] }}</p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 my-4">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-bed"></i>
                                    <span>{{ $property['quartos'] }}
                                        Quarto{{ $property['quartos'] != 1 ? 's' : '' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-bath"></i>
                                    <span>{{ $property['banheiros'] }}
                                        Banheiro{{ $property['banheiros'] != 1 ? 's' : '' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-car"></i>
                                    <span>{{ $property['vagas'] }}
                                        Vaga{{ $property['vagas'] != 1 ? 's' : '' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-ruler-combined"></i>
                                    <span>{{ $property['area'] }} m²</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach ($property['caracteristicas'] as $feature)
                                    <span class="badge badge-outline badge-primary">{{ $feature }}</span>
                                @endforeach
                            </div>

                            <div class="card-actions justify-between items-center">
                                {{-- <a href="{{ route('imoveis.show', $property['id']) }}" class="btn btn-primary">Ver Detalhes</a> --}}
                                <a class="btn btn-primary">Ver Detalhes</a>
                                <button class="btn btn-circle btn-ghost">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-home text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-600">Nenhum imóvel encontrado</h3>
                        <p class="text-gray-500 mt-2">Tente ajustar seus filtros de busca</p>
                        <a href="{{ route('demo.properties') }}" class="btn btn-primary mt-4">Limpar Filtros</a>
                    </div>
                @endforelse
            </div>

            {{-- <div class="grid grid-cols-1 gap-8">
                @forelse($properties as $property)
                    <div
                        class="card lg:card-side bg-base-100 shadow-xl property-card overflow-hidden transition-transform transform hover:scale-[1.01] duration-300 ease-in-out">
                        <figure class="lg:w-2/5 h-[250px] relative">
                            <div x-data="{ currentImageIndex: 0 }"
                                class="carousel w-full h-full flex flex-col justify-center items-center">
                                <div class="relative w-full h-full overflow-hidden">
                                    <!-- Container para os itens do carrossel, adicionado overflow-hidden para cortar as imagens fora da tela -->
                                    @foreach ($property['imagens'] as $index => $image)
                                        <div x-show="currentImageIndex === {{ $index }}"
                                            x-transition:enter="transition ease-out duration-500"
                                            x-transition:enter-start="transform translate-x-full opacity-0"
                                            x-transition:enter-end="transform translate-x-0 opacity-100"
                                            x-transition:leave="transition ease-in duration-500"
                                            x-transition:leave-start="transform translate-x-0 opacity-100"
                                            x-transition:leave-end="transform -translate-x-full opacity-0"
                                            class="carousel-item absolute top-0 left-0 w-full h-64 lg:h-full">
                                            <!-- A imagem é exibida ou ocultada pelo x-show. A opacidade é controlada pelas bolinhas de navegação. -->
                                            <img src="{{ $image }}" alt="{{ $property['titulo'] }}"
                                                class="w-full h-full object-cover" />

                                            <!-- Controles de navegação (setas) -->
                                            <div
                                                class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                                <button
                                                    @click="currentImageIndex = (currentImageIndex - 1 + {{ count($property['imagens']) }}) % {{ count($property['imagens']) }}"
                                                    class="btn btn-circle btn-sm">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <button
                                                    @click="currentImageIndex = (currentImageIndex + 1) % {{ count($property['imagens']) }}"
                                                    class="btn btn-circle btn-sm">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Div para as bolinhas de paginação -->
                                <div class="flex justify-center z-10 -mt-8 w-full py-2 gap-2">
                                    @foreach ($property['imagens'] as $index => $image)
                                        <button @click="currentImageIndex = {{ $index }}"
                                            :class="{
                                                'opacity-100 bg-gray-700': currentImageIndex ===
                                                    {{ $index }},
                                                'opacity-50 bg-gray-400': currentImageIndex !==
                                                    {{ $index }}
                                            }"
                                            class="w-3 h-3 rounded-full transition-opacity duration-300"
                                            aria-label="Ir para imagem {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>
                            </div>


                            <!-- Badges -->
                            <div class="absolute w-10 h-10 top-4 left-4 flex gap-2">
                                @if ($property['isFeatured'])
                                    <span class="badge badge-secondary">DESTAQUE</span>
                                @endif
                                @if ($property['isNew'])
                                    <span class="badge badge-accent">NOVO</span>
                                @endif
                            </div>
                        </figure>

                        <div class="card-body lg:w-3/5 p-6">
                            <h3 class="card-title text-2xl">R$ {{ number_format($property['preco'], 2, ',', '.') }}
                            </h3>
                            <h4 class="text-xl font-semibold">{{ $property['titulo'] }}</h4>
                            <p class="flex items-center gap-2 text-gray-600">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $property['endereco'] }}, {{ $property['bairro'] }}, {{ $property['cidade'] }} -
                                {{ $property['estado'] }}
                            </p>
                            <p>{{ $property['descricao_curta'] }}</p>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 my-4">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-bed"></i>
                                    <span>{{ $property['quartos'] }}
                                        Quarto{{ $property['quartos'] != 1 ? 's' : '' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-bath"></i>
                                    <span>{{ $property['banheiros'] }}
                                        Banheiro{{ $property['banheiros'] != 1 ? 's' : '' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-car"></i>
                                    <span>{{ $property['vagas'] }}
                                        Vaga{{ $property['vagas'] != 1 ? 's' : '' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-ruler-combined"></i>
                                    <span>{{ $property['area'] }} m²</span>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach ($property['caracteristicas'] as $feature)
                                    <span class="badge badge-outline badge-primary">{{ $feature }}</span>
                                @endforeach
                            </div>

                            <div class="card-actions justify-between items-center">
                                <a class="btn btn-primary">Ver Detalhes</a>
                                <button class="btn btn-circle btn-ghost">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <i class="fas fa-home text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-600">Nenhum imóvel encontrado</h3>
                        <p class="text-gray-500 mt-2">Tente ajustar seus filtros de busca</p>
                        <a href="{{ route('demo.properties') }}" class="btn btn-primary mt-4">Limpar Filtros</a>
                    </div>
                @endforelse
            </div> --}}

            <!-- Paginação -->
            @if ($totalPages > 1)
                <div class="join flex justify-center mt-8">
                    <!-- Botão Anterior -->
                    <a href="{{ route('demo.properties', array_merge(request()->except('page'), ['page' => $currentPage - 1])) }}"
                        class="join-item btn {{ $currentPage == 1 ? 'btn-disabled' : '' }}">
                        «
                    </a>

                    <!-- Botões de página -->
                    @php
                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($totalPages, $currentPage + 2);
                    @endphp

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <a href="{{ route('demo.properties', array_merge(request()->except('page'), ['page' => $i])) }}"
                            class="join-item btn {{ $i == $currentPage ? 'btn-active' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    <!-- Botão Próximo -->
                    <a href="{{ route('demo.properties', array_merge(request()->except('page'), ['page' => $currentPage + 1])) }}"
                        class="join-item btn {{ $currentPage == $totalPages ? 'btn-disabled' : '' }}">
                        »
                    </a>
                </div>
            @endif
        </section>

        <!-- Rodapé -->
        <footer class="footer sm:footer-horizontal p-10 bg-neutral text-neutral-content mt-auto">
            <div>
                <span class="btn btn-ghost text-xl font-bold text-white">Imóveis.com</span>
                <p>Encontre o imóvel perfeito para você e sua família.</p>
            </div>
            <div>
                <span class="footer-title">Serviços</span>
                <a class="link link-hover">Venda</a>
                <a class="link link-hover">Aluguel</a>
                <a class="link link-hover">Financiamento</a>
                <a class="link link-hover">Avaliação</a>
            </div>
            <div>
                <span class="footer-title">Empresa</span>
                <a class="link link-hover">Sobre nós</a>
                <a class="link link-hover">Contato</a>
                <a class="link link-hover">Trabalhe conosco</a>
            </div>
            <div>
                <span class="footer-title">Legal</span>
                <a class="link link-hover">Termos de uso</a>
                <a class="link link-hover">Política de privacidade</a>
                <a class="link link-hover">Cookies</a>
            </div>
            <div>
                <span class="footer-title">Redes Sociais</span>
                <div class="grid grid-flow-col gap-4">
                    <a><i class="fab fa-facebook-f text-xl"></i></a>
                    <a><i class="fab fa-instagram text-xl"></i></a>
                    <a><i class="fab fa-twitter text-xl"></i></a>
                    <a><i class="fab fa-whatsapp text-xl"></i></a>
                </div>
            </div>
        </footer>
    </main>



    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>

</html>
