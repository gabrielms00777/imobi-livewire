<!DOCTYPE html>
<html lang="pt-BR" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">

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

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --color-primary: {{ $tenantSettings->primary_color ?? '#3b82f6' }};
            --color-secondary: {{ $tenantSettings->secondary_color ?? '#f63b3b' }};
            --color-neutral: {{ $tenantSettings->text_color ?? '#333333' }};
            /* Adicionado fallback para text_color */
        }

        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }

        /* Animações personalizadas */
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

    {{-- <header x-data="{ isScrolled: false }" @scroll.window="isScrolled = window.scrollY > 300"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="isScrolled ? 'bg-white shadow-md dark:bg-neutral' : 'bg-transparent'">

        <div class="mx-auto px-4">
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
                                    <span class="text-xl font-bold text-secondary">{{ $remainingWords }}</span>
                                @endif
                            @else
                                <span class="text-xl font-bold text-primary">Seu Site</span>
                            @endif
                        </div>
                    </a>
                </div>

                <div class="flex-none hidden lg:flex items-center gap-2">

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
    </header> --}}

    <x-home.header :tenant="$tenant" :tenantSettings="$tenantSettings" />

    <section
        class="relative py-20 @if ($tenantSettings->hero_background_type === 'gradient') bg-linear-{{ $tenantSettings->hero_gradient_direction }} from-[{{ $tenantSettings->hero_gradient_from_color }}] to-[{{ $tenantSettings->hero_gradient_to_color }}] @else overflow-hidden @endif">
        @if ($tenantSettings->hero_background_type === 'image')
            {{-- A propriedade 'hero_image' agora contém a URL da imagem salva no banco de dados. --}}
            {{-- A classe `absolute inset-0 w-full h-full object-cover z-0` é um estilo comum para imagens de fundo. --}}
            <img src="{{ $tenantSettings->hero_image_url }}" alt="Imagem de fundo do hero"
                class="absolute inset-0 w-full h-full object-cover z-0">
        @endif

        <div class="container mx-auto px-4 mt-18 relative z-10">
            <div class="flex flex-col h-50 items-center gap-12">
                {{-- Adicionado '?? true' para 'hero_show_text_content' caso não esteja definido no modelo --}}
                @if ($tenantSettings->hero_show_text_content ?? true)
                    <div class="text-center animate-fade-in" style="animation-delay: 0.1s">
                        <h1 class="text-4xl md:text-5xl font-bold mb-6">
                            {{ $tenantSettings->hero_title }}
                        </h1>
                        <p class="text-xl mb-8">
                            {{-- CORREÇÃO: Usando 'hero_subtitle' que é a propriedade definida no formulário --}}
                            {{ $tenantSettings->hero_description }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- <section
        class="relative py-20 @if ($tenantSettings->hero_background_type === 'gradient') bg-linear-{{ $tenantSettings->hero_gradient_direction }} from-[{{ $tenantSettings->hero_gradient_from_color }}] to-[{{ $tenantSettings->hero_gradient_to_color }}] @else overflow-hidden @endif">
        @if ($tenantSettings->hero_background_type === 'image')
            <img src="{{ $tenantSettings->hero_image_url }}" alt="{{ $tenantSettings->hero_image_alt_text }}"
                class="{{ $tenantSettings->hero_image_class }}">
        @endif

        <div class="container mx-auto px-4 mt-18 relative z-10">
            <div class="flex flex-col h-50 items-center gap-12">
                @if ($tenantSettings->hero_show_text_content)
                    <div class="text-center animate-fade-in" style="animation-delay: 0.1s">
                        <h1 class="text-4xl md:text-5xl font-bold mb-6">
                            {{ $tenantSettings->hero_title }}
                        </h1>
                        <p class="text-xl mb-8">
                            {{ $tenantSettings->hero_description }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section> --}}
    {{-- <div class="flex items-center gap-4">
            <div class="flex -space-x-2">
                @foreach (json_decode($tenantSettings->hero_avatars) as $avatarUrl)
                    <div class="avatar">
                        <div class="w-12 h-12 rounded-full border-2 border-base-100">
                            <img src="{{ $avatarUrl }}" />
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                <div class="font-bold">{{ $tenantSettings->hero_clients_satisfied_text }}</div>
                <div class="flex text-yellow-400">
                    @for ($i = 0; $i < floor($tenantSettings->hero_stars_rating); $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                    @if ($tenantSettings->stars_rating - floor($tenantSettings->hero_stars_rating) >= 0.5)
                        <i class="fas fa-star-half-alt"></i>
                    @endif
                    @for ($i = 0; $i < 5 - ceil($tenantSettings->hero_stars_rating); $i++)
                        <i class="far fa-star"></i> 
                    @endfor
                </div>
            </div>
        </div> --}}
    {{-- Formulário de busca (sempre visível, mas pode ser condicional se quiser) --}}
    {{-- <div class="lg:w-1/2 w-full">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title mb-4">{{ $tenantSettings->hero_form_title }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach (json_decode($tenantSettings->hero_select_options) as $select)
                        <select class="select select-bordered">
                            <option disabled selected>{{ $select->placeholder }}</option>
                            @foreach ($select->options as $option)
                                <option>{{ $option }}</option>
                            @endforeach
                        </select>
                    @endforeach
                </div>
                <div class="card-actions justify-end mt-4">
                    <button class="btn btn-primary w-full">
                        <i class="{{ $tenantSettings->hero_search_button_icon }} mr-2"></i>
                        {{ $tenantSettings->hero_search_button_text }}
                    </button>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container mx-auto px-4 -mt-12">
        <div class="animate-fade-in" style="animation-delay: 0.1s">
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title mb-4">O que você está buscando?</h2>
                    <form action="{{ route('tenant.properties', ['tenantSlug' => $tenant->slug]) }}" method="GET">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                            <select name="type" class="select select-bordered">
                                <option disabled selected>Tipo de Imóvel</option>
                                <option value="casa">Casa</option>
                                <option value="apartamento">Apartamento</option>
                                <option value="terreno">Terreno</option>
                                <option value="comercial">Comercial</option>
                            </select>

                            <select name="bathrooms" class="select select-bordered">
                                <option disabled selected>Banheiros</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                            </select>

                            <select name="parking" class="select select-bordered">
                                <option disabled selected>Vagas</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                            </select>

                            <select name="bedrooms" class="select select-bordered">
                                <option disabled selected>Quartos</option>
                                <option value="1">1+</option>
                                <option value="2">2+</option>
                                <option value="3">3+</option>
                                <option value="4">4+</option>
                            </select>

                            <button type="submit" class="btn btn-primary w-full">
                                <i class="fas fa-search mr-2"></i> Buscar Imóveis
                            </button>

                        </div>
                    </form>
                    {{-- <div class="card-actions justify-end mt-4">
                            </div> --}}
                </div>
            </div>
        </div>
    </div>

    <section id="destaques" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Imóveis em Destaque</h2>
                <p class="text-lg max-w-2xl mx-auto">Confira nossas melhores opções selecionadas especialmente para
                    você
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($featuredProperties as $property)
                    <div class="property-card card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 animate-fade-in"
                        style="animation-delay: 0.1s">
                        <figure>
                            <img src="{{ $property->getFirstMediaUrl('thumbnails') ?: asset('images/placeholder.jpg') }}"
                                alt="Casa moderna" class="h-64 w-full object-cover">
                            <span class="badge badge-primary absolute top-4 right-4">Destaque</span>
                        </figure>
                        <div class="card-body">
                            <h3 class="card-title">{{ $property->title }}</h3>
                            <div class="flex items-center text-yellow-500 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                                <span>{{ $property->street }}, {{ $property->neighborhood }}, {{ $property->city }} -
                                    {{ $property->state }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <i class="fas fa-bed mr-1"></i>
                                    <span>{{ $property->bedrooms }} Quartos</span>
                                </div>
                                <div>
                                    <i class="fas fa-bath mr-1"></i>
                                    <span>{{ $property->bathrooms }} Banheiros</span>
                                </div>
                                <div>
                                    <i class="fas fa-ruler-combined mr-1"></i>
                                    <span>{{ $property->area }}m²</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-primary">R$
                                    {{ number_format($property->price, 0, ',', '.') }}</span>
                                <a href="{{ route('tenant.properties.show', ['tenantSlug' => $tenant->slug, 'property' => $property->slug]) }}"
                                    class="btn btn-sm btn-secondary">Detalhes</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-8">
                <a href="{{ route('tenant.properties', ['tenantSlug' => $tenant->slug, 'filter' => 'destaque']) }}"
                    class="btn btn-outline btn-primary">Ver mais imóveis</a>
            </div>
        </div>
    </section>

    {{-- <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Imóveis em <span class="text-primary">Destaque</span></h2>

            <div class="flex flex-wrap justify-center gap-8">
                @forelse ($featuredProperties as $property)
                    <div class="property-card card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 animate-fade-in"
                        style="animation-delay: 0.1s; flex: 0 0 calc(33.333% - 2rem); max-width: calc(33.333% - 2rem);">
                        <figure>
                            <img src="{{ $property->main_image_url }}" alt="Casa moderna"
                                class="h-64 w-full object-cover">
                            <span class="badge badge-primary absolute top-4 right-4">Destaque</span>
                        </figure>
                        <div class="card-body">
                            <h3 class="card-title">{{ $property->title }}</h3>
                            <div class="flex items-center text-gray-500 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                                <span>{{ $property->address }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <i class="fas fa-bed mr-1"></i>
                                    <span>{{ $property->bedrooms }} Quartos</span>
                                </div>
                                <div>
                                    <i class="fas fa-bath mr-1"></i>
                                    <span>{{ $property->bathrooms }} Banheiros</span>
                                </div>
                                <div>
                                    <i class="fas fa-ruler-combined mr-1"></i>
                                    <span>{{ $property->area }}m²</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xl font-bold text-primary">R$
                                    {{ number_format($property->price, 0, ',', '.') }}</span>
                                <a href="{{ route('tenant.property', ['tenantSlug' => $tenant->slug, 'id' => $property->id]) }}"
                                    class="btn btn-sm btn-secondary">Detalhes</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-center text-gray-600 col-span-full">Nenhum imóvel em destaque encontrado.</p>
                    @endforelse
                </div>
                <div class="text-center mt-8">
                    <a href="{{ route('tenant.properties', ['tenantSlug' => $tenant->slug, 'filter' => 'destaque']) }}"
                        class="btn btn-outline btn-primary">Ver mais imóveis</a>
                </div>
        </div>
    </section> --}}

    <section id="sobre" class="py-16 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2 animate-fade-in">
                    {{-- <img src="{{ asset($tenantSettings->about_image) ?? 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}" --}}
                    {{-- <img src="{{ '/storage/'.$tenantSettings->about_image ?? 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}" --}}
                    <img src="{{ $tenantSettings->about_image ?? 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80' }}"
                        alt="Destaque da imobiliária" class="rounded-lg shadow-xl w-full h-auto">
                </div>
                <div class="lg:w-1/2 animate-fade-in" style="animation-delay: 0.2s">
                    <h2 class="text-3xl font-bold mb-6">{{ $tenantSettings->about_title }}</h2>
                    <p class="mb-4 text-lg">{{ $tenantSettings->about_content }}</p>
                    {{-- <p class="mb-4 text-lg">Somos uma imobiliária com mais de 20 anos de experiência no mercado,
                        ajudando famílias a encontrar o lar perfeito.</p>
                    <p class="mb-6">Nossa equipe de corretores altamente qualificados está pronta para oferecer o
                        melhor
                        atendimento e encontrar a solução ideal para suas necessidades imobiliárias.</p> --}}

                    <div class="space-y-4">
                        @foreach ($tenantSettings->about_features as $feature)
                            <div class="flex items-start">
                                <div class="text-primary mr-4 mt-1">
                                    <i class="{{ $feature['icon'] ?? 'fas fa-check-circle' }} text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold">{{ $feature['title'] }}</h4>
                                    <p class="text-sm">{{ $feature['description'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- <button class="btn btn-primary mt-8">Conheça nossa equipe</button> --}}
                </div>
            </div>
        </div>
    </section>

    <section id="recentes" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Imóveis Recentes</h2>
                <p class="text-lg max-w-2xl mx-auto">Confira nossas últimas adições ao portfólio</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($recentProperties as $property)
                    <div class="property-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300 animate-fade-in"
                        style="animation-delay: 0.1s">
                        <figure>
                            <img src="{{ $property->getFirstMediaUrl('thumbnails') ?: asset('images/placeholder.jpg') }}"
                                alt="{{ $property->title }}" class="h-48 w-full object-cover">
                            <span class="badge badge-secondary absolute top-4 right-4">Novo</span>
                        </figure>
                        <div class="card-body p-4">
                            <h3 class="card-title text-lg">{{ $property->title }}</h3>
                            <div class="flex items-center text-sm mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                                <span>{{ $property->street }}, {{ $property->neighborhood }}, {{ $property->city }} -
                                    {{ $property->state }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm mb-3">
                                @if ($property->bedrooms > 0)
                                    {{-- Condição para exibir quartos apenas se for relevante --}}
                                    <div>
                                        <i class="fas fa-bed mr-1"></i>
                                        <span>{{ $property->bedrooms }} Quartos</span>
                                    </div>
                                @endif
                                @if ($property->bathrooms > 0)
                                    {{-- Condição para exibir banheiros apenas se for relevante --}}
                                    <div>
                                        <i class="fas fa-bath mr-1"></i>
                                        <span>{{ $property->bathrooms }}
                                            Banheiro{{ $property->bathrooms > 1 ? 's' : '' }}</span>
                                    </div>
                                @endif
                                <div>
                                    <i class="fas fa-ruler-combined mr-1"></i>
                                    <span>{{ $property->area }}m²</span>
                                </div>
                                @if ($property->type === 'terreno' && isset($property->vagas_garagem))
                                    {{-- Exemplo de campo específico para terreno --}}
                                    <div>
                                        <i class="fas fa-car mr-1"></i>
                                        <span>{{ $property->vagas_garagem }} Vagas</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-primary">R$
                                    {{ number_format($property->price, 0, ',', '.') }}</span>
                                <a href="{{ route('tenant.properties.show', ['tenantSlug' => $tenant->slug, 'property' => $property->slug]) }}"
                                    class="btn btn-xs btn-outline btn-primary">Detalhes</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative py-20 bg-primary text-primary-content">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                {{ $tenantSettings->engagement_title }}
            </h1>
            <p class="text-xl mb-12 max-w-3xl mx-auto">
                {{ $tenantSettings->engagement_description }}
            </p>

            {{-- <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto"> --}}
            <div class="flex flex-col md:flex-row justify-center gap-8 max-w-5xl mx-auto">
                @foreach ($tenantSettings->engagement_metrics as $metric)
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2">{{ $metric['value'] }}</div>
                        <div class="opacity-80">{{ $metric['description'] }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ $tenantSettings->engagement_btn_properties_link }}" class="btn btn-secondary btn-lg">
                    <i class="{{ $tenantSettings->engagement_btn_properties_icon }} mr-2"></i>
                    {{ $tenantSettings->engagement_btn_properties_text }}
                </a>
                <a href="{{ $tenantSettings->engagement_btn_contact_link }}"
                    class="btn btn-outline btn-lg btn-primary-content">
                    <i class="{{ $tenantSettings->engagement_btn_contact_icon }} mr-2"></i>
                    {{ $tenantSettings->engagement_btn_contact_text }}
                </a>
            </div>
        </div>
    </section>

    <footer class="footer p-10 bg-neutral text-neutral-content">
        <div class="container mx-auto px-4">
            {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-8"> --}}
            <div class="flex flex-col md:flex-row justify-around gap-8 w-full">
                <div>
                    {{-- Usamos o nome do site das configurações --}}
                    <span class="footer-title">{{ $tenantSettings->site_name ?? 'Sua Imobiliária' }}</span>
                    {{-- Usamos a descrição do site das configurações --}}
                    <p>{{ $tenantSettings->site_description ?? 'Há mais de 20 anos ajudando pessoas a encontrar seu lar ideal.' }}
                    </p>
                    <div class="flex gap-4 mt-4">
                        @if ($tenantSettings->social_facebook)
                            <a href="{{ $tenantSettings->social_facebook }}" class="btn btn-circle btn-sm btn-ghost"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if ($tenantSettings->social_instagram)
                            <a href="{{ $tenantSettings->social_instagram }}" class="btn btn-circle btn-sm btn-ghost"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if ($tenantSettings->social_linkedin)
                            <a href="{{ $tenantSettings->social_linkedin }}" class="btn btn-circle btn-sm btn-ghost"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                        {{-- Adicionado link para Twitter/X, se configurado --}}
                        @if ($tenantSettings->social_twitter)
                            <a href="{{ $tenantSettings->social_twitter }}" class="btn btn-circle btn-sm btn-ghost"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-twitter"></i> {{-- Use fab fa-x-twitter se sua versão do Font Awesome suportar o novo logo --}}
                            </a>
                        @endif
                        {{-- Adicionado link para Youtube, se configurado --}}
                        @if ($tenantSettings->social_youtube)
                            <a href="{{ $tenantSettings->social_youtube }}" class="btn btn-circle btn-sm btn-ghost"
                                target="_blank" rel="noopener noreferrer">
                                <i class="fab fa-youtube"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div>
                    <span class="footer-title">Links Rápidos</span>
                    <ul>
                        <li><a href="#destaques" class="link link-hover">Imóveis em Destaque</a></li>
                        <li><a href="#recentes" class="link link-hover">Imóveis Recentes</a></li>
                        {{-- <li><a href="#sobre" class="link link-hover">Sobre Nós</a></li>
                        <li><a href="#contato" class="link link-hover">Contato</a></li> --}}
                    </ul>
                </div>

                <div>
                    <span class="footer-title">Contato</span>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        {{-- Usamos o endereço de contato das configurações --}}
                        <span>{{ $tenantSettings->contact_address }}</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-phone-alt mr-2"></i>
                        {{-- Usamos o telefone de contato das configurações --}}
                        <span>{{ $tenantSettings->contact_phone }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        {{-- Usamos o e-mail de contato das configurações --}}
                        <span>{{ $tenantSettings->contact_email }}</span>
                    </div>
                </div>

                {{-- A seção de Newsletter continua comentada, se precisar, pode descomentar e configurá-la --}}
            </div>

            <div class="border-t w-full border-gray-700 mt-8 pt-8 text-center">
                {{-- Usamos o nome do site para o copyright --}}
                <p>&copy; {{ date('Y') }} {{ $tenantSettings->site_name }}. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    {{-- <footer class="footer p-10 bg-neutral text-neutral-content">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <span class="footer-title">Imobiliária</span>
                    <p>Há mais de 20 anos ajudando pessoas a encontrar seu lar ideal.</p>
                    <div class="flex gap-4 mt-4">
                        @if ($tenantSettings->social_facebook)
                            <a href="{{ $tenantSettings->social_facebook }}" class="btn btn-circle btn-sm btn-ghost">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        @endif
                        @if ($tenantSettings->social_instagram)
                            <a href="{{ $tenantSettings->social_instagram }}"
                                class="btn btn-circle btn-sm btn-ghost">
                                <i class="fab fa-instagram"></i>
                            </a>
                        @endif
                        @if ($tenantSettings->social_linkedin)
                            <a href="{{ $tenantSettings->social_linkedin }}" class="btn btn-circle btn-sm btn-ghost">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                    </div>
                </div>

                <div>
                    <span class="footer-title">Links Rápidos</span>
                    <ul>
                        <li><a href="#destaques" class="link link-hover">Imóveis em Destaque</a></li>
                        <li><a href="#recentes" class="link link-hover">Imóveis Recentes</a></li>
                        <li><a href="#sobre" class="link link-hover">Sobre Nós</a></li>
                        <li><a href="#contato" class="link link-hover">Contato</a></li>
                    </ul>
                </div>

                <div>
                    <span class="footer-title">Contato</span>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        <span>{{ $tenantSettings->contact_address }}</span>
                    </div>
                    <div class="flex items-center mb-2">
                        <i class="fas fa-phone-alt mr-2"></i>
                        <span>{{ $tenantSettings->contact_phone }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        <span>{{ $tenantSettings->contact_email }}</span>
                    </div>
                </div>

            </div>
            
            <div class="border-t w-full border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; {{ date('Y') }} {{ $tenantSettings->site_name }}. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer> --}}
    {{-- <div>
        <span class="footer-title">Newsletter</span>
        <p>Assine nossa newsletter para receber novidades</p>
        <div class="form-control mt-4">
            <div class="relative">
                <input type="text" placeholder="seu@email.com"
                    class="input input-bordered w-full pr-16">
                <button class="btn btn-primary absolute top-0 right-0 rounded-l-none">Assinar</button>
            </div>
        </div>
    </div> --}}


    <div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50">
        <button @click="open = !open" class="btn btn-circle bg-green-500 text-white btn-xl shadow-xl relative">
            <i class="fab fa-whatsapp text-2xl"></i>
            <span x-show="!open"
                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
        </button>

        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
            class="absolute right-16 bottom-0 w-72 bg-white rounded-lg shadow-xl overflow-hidden">

            <div class="bg-green-500 text-white p-4">
                <h3 class="font-bold">Atendimento Online</h3>
                <p class="text-xs">Normalmente respondemos em minutos</p>
            </div>

            <div class="p-4 text-sm">
                <p>Olá! Como podemos ajudar?</p>
            </div>

            <div class="p-4 border-t">
                <a href="https://wa.me/5511999999999" class="btn bg-green-500 text-white btn-block btn-sm">
                    <i class="fab fa-whatsapp mr-2"></i> Iniciar Conversa
                </a>
            </div>
        </div>
    </div>

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
