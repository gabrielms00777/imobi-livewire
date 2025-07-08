<!DOCTYPE html>
<html lang="pt-BR" x-data="{ darkMode: false, filtersOpen: false, priceRange: [$wire.minPrice, $wire.maxPrice] }"
    :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imóveis Disponíveis - {{ $tenant->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --color-primary: {{ $$tenant->tenantSettings->primary_color ?? '#422ad5' }};
            --color-secondary: {{ $$tenant->tenantSettings->secondary_color ?? '#f43098' }};
            --color-neutral: {{ $$tenant->tenantSettings->text_color ?? '#0b0809' }};
        }

        /* Cores dinâmicas do tenant */
        html {
            --tenant-primary: {{ $tenant->tenantSetting->primary_color ?? '#3b82f6' }};
            --tenant-secondary: {{ $tenant->tenantSetting->secondary_color ?? '#10b981' }};
            --tenant-text: {{ $tenant->tenantSetting->text_color ?? '#1f2937' }};
        }

        .btn-primary, .badge-primary {
            background-color: var(--tenant-primary);
            border-color: var(--tenant-primary);
            color: white; /* Ou uma cor contrastante com o primary */
        }
        .btn-primary:hover {
            background-color: color-mix(in srgb, var(--tenant-primary) 80%, black);
            border-color: color-mix(in srgb, var(--tenant-primary) 80%, black);
        }

        .text-primary {
            color: var(--tenant-primary);
        }

        .text-secondary {
            color: var(--tenant-secondary);
        }

        .btn-secondary {
            background-color: var(--tenant-secondary);
            border-color: var(--tenant-secondary);
            color: white; /* Ou uma cor contrastante com o secondary */
        }
        .btn-secondary:hover {
            background-color: color-mix(in srgb, var(--tenant-secondary) 80%, black);
            border-color: color-mix(in srgb, var(--tenant-secondary) 80%, black);
        }

        .checkbox-primary:checked, .range-primary::-webkit-slider-thumb, .range-primary::-moz-range-thumb {
            background-color: var(--tenant-primary) !important;
            border-color: var(--tenant-primary) !important;
        }

        /* Cores para o modo escuro, se houver */
        .dark {
            --primary: #60a5fa;
            --secondary: #34d399;
            --accent: #fbbf24;
            --neutral: #d1d5db;
            --base-100: #1f2937;
        }

        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
            color: var(--tenant-text); /* Aplica a cor de texto do tenant */
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

        /* Ajuste para centralizar cards quando menos de 3 em telas grandes */
        .grid-auto-fit {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Ajuste o minmax conforme o tamanho do card */
            justify-items: center; /* Centraliza os itens dentro de suas células de grid */
            gap: 2rem; /* Gap entre os itens */
        }

        /* Medias queries para responsividade do grid */
        @media (min-width: 768px) { /* md */
            .grid-properties {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (min-width: 1024px) { /* lg */
            .grid-properties {
                grid-template-columns: repeat(3, 1fr);
            }
        }
        /* Para o caso de 1 ou 2 itens em telas grandes, o 'justify-items-center' e 'auto-fit' já ajudam */
        /* Se ainda precisar de centralização perfeita para <3 itens: */
        @media (min-width: 1024px) {
            .grid-properties:has(> *:nth-last-child(1):nth-child(1)) { /* Apenas 1 item */
                grid-template-columns: 1fr;
                justify-content: center; /* Centraliza o grid em si */
            }
            .grid-properties:has(> *:nth-last-child(2):nth-child(1)) { /* Apenas 2 itens */
                grid-template-columns: repeat(2, 1fr);
                justify-content: center;
            }
        }
    </style>
</head>

<body class="bg-base-100 text-neutral">
    <header class="sticky top-0 z-50 shadow-md bg-base-100">
        <div class="navbar container mx-auto px-4">
            <div class="flex-1">
                <a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}"
                    class="btn btn-ghost normal-case text-xl font-bold text-primary">
                    @if ($tenant->tenantSetting->header_display_type === 'logo_only' && $tenant->tenantSetting->site_logo)
                        <img src="{{ Storage::url($tenant->tenantSetting->site_logo) }}" alt="{{ $tenant->name }} Logo" class="h-8">
                    @elseif ($tenant->tenantSetting->header_display_type === 'name_only' || !$tenant->tenantSetting->site_logo)
                        {{ $tenant->name }}
                    @elseif ($tenant->tenantSetting->header_display_type === 'logo_and_name' && $tenant->tenantSetting->site_logo)
                        <img src="{{ Storage::url($tenant->tenantSetting->site_logo) }}" alt="{{ $tenant->name }} Logo" class="h-8 mr-2">
                        {{ $tenant->name }}
                    @endif
                </a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal p-0 hidden md:flex">
                    <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}#destaques">Destaques</a></li>
                    <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}#sobre">Sobre</a></li>
                    <li><a href="{{ route('tenant.properties.index', ['tenantSlug' => $tenant->slug]) }}">Imóveis</a></li>
                    <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}#contato">Contato</a></li>
                </ul>

                <div class="dropdown dropdown-end md:hidden">
                    <label tabindex="0" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                    <ul tabindex="0"
                        class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
                        <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}#destaques">Destaques</a></li>
                        <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}#sobre">Sobre</a></li>
                        <li><a href="{{ route('tenant.properties.index', ['tenantSlug' => $tenant->slug]) }}">Imóveis</a></li>
                        <li><a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}#contato">Contato</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <section class="relative h-64 bg-base-200 flex items-center">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-secondary/10 z-0"></div>
        <div class="container mx-auto px-4 relative z-10">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                Imóveis <span class="text-primary">Disponíveis</span>
            </h1>
            <p class="text-xl opacity-90">
                Encontre o imóvel perfeito para você em {{ $tenant->name }}
            </p>
        </div>
    </section>

    <main class="container mx-auto px-4 py-8" x-data="{ minPrice: @entangle('minPrice'), maxPrice: @entangle('maxPrice') }">
        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="lg:w-80 shrink-0" wire:ignore.self> {{-- wire:ignore.self para evitar re-render desnecessário do Alpine --}}
                <div class="sticky top-24">
                    <button @click="filtersOpen = !filtersOpen" class="btn btn-primary w-full lg:hidden mb-4">
                        <i class="fas fa-filter mr-2"></i>
                        <span x-text="filtersOpen ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
                    </button>

                    <div x-show="filtersOpen" class="bg-base-100 p-6 rounded-xl shadow-md space-y-6" x-transition>
                        <h2 class="text-xl font-bold">Filtrar Imóveis</h2>

                        <div>
                            <h3 class="font-semibold mb-2">Buscar</h3>
                            <input type="text" placeholder="Buscar por título, endereço..." class="input input-bordered w-full" wire:model.live.debounce.300ms="search">
                        </div>

                        <div>
                            <h3 class="font-semibold mb-2">Tipo de Imóvel</h3>
                            <div class="space-y-2">
                                @foreach($propertyTypesOptions as $type)
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" value="{{ $type }}" wire:model.live="propertyTypes" class="checkbox checkbox-primary">
                                        <span>{{ $type }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-2">Faixa de Preço</h3>
                            <div x-data="{
                                formatCurrency(value) {
                                    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value)
                                }
                            }">
                                <div class="flex justify-between mb-2">
                                    <span x-text="formatCurrency(minPrice)"></span>
                                    <span x-text="formatCurrency(maxPrice)"></span>
                                </div>
                                <input type="range" x-model="minPrice" min="0" max="10000000"
                                    step="10000" class="range range-primary range-xs mb-4" wire:change="setMinPrice($event.target.value)">
                                <input type="range" x-model="maxPrice" min="0" max="10000000"
                                    step="10000" class="range range-primary range-xs" wire:change="setMaxPrice($event.target.value)">
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-2">Quartos</h3>
                            <div class="flex flex-wrap gap-2">
                                <button class="btn btn-sm" :class="{ 'btn-primary': $wire.bedrooms === null }" wire:click="bedrooms = null">Todos</button>
                                <button class="btn btn-sm btn-outline" :class="{ 'btn-primary': $wire.bedrooms === 1 }" wire:click="bedrooms = 1">1+</button>
                                <button class="btn btn-sm btn-outline" :class="{ 'btn-primary': $wire.bedrooms === 2 }" wire:click="bedrooms = 2">2+</button>
                                <button class="btn btn-sm btn-outline" :class="{ 'btn-primary': $wire.bedrooms === 3 }" wire:click="bedrooms = 3">3+</button>
                                <button class="btn btn-sm btn-outline" :class="{ 'btn-primary': $wire.bedrooms === 4 }" wire:click="bedrooms = 4">4+</button>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-2">Banheiros</h3>
                            <div class="flex flex-wrap gap-2">
                                <button class="btn btn-sm" :class="{ 'btn-primary': $wire.bathrooms === null }" wire:click="bathrooms = null">Todos</button>
                                <button class="btn btn-sm btn-outline" :class="{ 'btn-primary': $wire.bathrooms === 1 }" wire:click="bathrooms = 1">1+</button>
                                <button class="btn btn-sm btn-outline" :class="{ 'btn-primary': $wire.bathrooms === 2 }" wire:click="bathrooms = 2">2+</button>
                                <button class="btn btn-sm btn-outline" :class="{ 'btn-primary': $wire.bathrooms === 3 }" wire:click="bathrooms = 3">3+</button>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-2">Vagas</h3>
                            <div class="flex flex-wrap gap-2">
                                <button class="btn btn-sm" :class="{ 'btn-primary': $wire.garages === null }" wire:click="garages = null">Todas</button>
                                <button class="btn btn-sm btn-outline" :class="{ 'btn-primary': $wire.garages === 1 }" wire:click="garages = 1">1+</button>
                                <button class="btn btn-sm btn-outline" :class="{ 'btn-primary': $wire.garages === 2 }" wire:click="garages = 2">2+</button>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-2">Área (m²)</h3>
                            <div class="flex gap-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Mínima</span>
                                    </label>
                                    <input type="number" placeholder="0" class="input input-bordered w-full" wire:model.live.debounce.300ms="minArea">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Máxima</span>
                                    </label>
                                    <input type="number" placeholder="Qualquer" class="input input-bordered w-full" wire:model.live.debounce.300ms="maxArea">
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            {{-- Os filtros aplicam automaticamente com wire:model.live.debounce --}}
                            <button class="btn btn-ghost w-full" wire:click="resetFilters">Limpar Filtros</button>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="flex-1">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div class="text-sm">
                        <span class="font-semibold">{{ $properties->total() }}</span> imóveis encontrados
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm hidden md:block">Ordenar por:</span>
                        <select class="select select-bordered select-sm" wire:model.live="orderBy">
                            <option value="relevance">Relevância</option>
                            <option value="price_asc">Menor Preço</option>
                            <option value="price_desc">Maior Preço</option>
                            <option value="latest">Mais Recentes</option>
                            <option value="area_desc">Maior Área</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-6">
                    @forelse ($properties as $property)
                        <div
                            class="property-card card card-side bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                            <figure class="w-full md:w-80 shrink-0">
                                <img src="{{ $property->main_image_url }}" alt="{{ $property->title }}"
                                    class="h-full w-full object-cover">
                                @if ($property->is_featured)
                                    <span class="badge badge-primary absolute top-4 right-4">Destaque</span>
                                @elseif ($property->is_new) {{-- Supondo um campo is_new ou baseado em created_at --}}
                                    <span class="badge badge-secondary absolute top-4 right-4">Novo</span>
                                @endif
                            </figure>
                            <div class="card-body">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h2 class="card-title">{{ $property->title }}</h2>
                                        <div class="flex items-center text-sm text-gray-500 mb-2">
                                            <i class="fas fa-map-marker-alt mr-2"></i>
                                            <span>{{ $property->address }}</span>
                                        </div>
                                    </div>
                                    <div class="text-2xl font-bold text-primary">R$ {{ number_format($property->price, 0, ',', '.') }}</div>
                                </div>

                                <div class="flex flex-wrap gap-4 mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-bed mr-2 text-primary"></i>
                                        <span>{{ $property->bedrooms }} Quartos</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-bath mr-2 text-primary"></i>
                                        <span>{{ $property->bathrooms }} Banheiros</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-ruler-combined mr-2 text-primary"></i>
                                        <span>{{ $property->area }} m²</span>
                                    </div>
                                    @if($property->garages)
                                    <div class="flex items-center">
                                        <i class="fas fa-car mr-2 text-primary"></i>
                                        <span>{{ $property->garages }} Vagas</span>
                                    </div>
                                    @endif
                                </div>

                                <p class="mb-4 line-clamp-2">{{ $property->description }}</p>

                                <div class="card-actions justify-between items-center">
                                    {{-- Avaliação (se tiver um campo rating na Property) --}}
                                    @if ($property->rating)
                                    <div class="flex gap-1 text-yellow-400">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($property->rating >= $i)
                                                <i class="fas fa-star"></i>
                                            @elseif ($property->rating >= $i - 0.5)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="text-gray-500 ml-1">({{ $property->reviews_count ?? 0 }})</span>
                                    </div>
                                    @endif
                                    <a href="{{ route('tenant.property.show', ['tenantSlug' => $tenant->slug, 'propertySlug' => $property->slug]) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-eye mr-2"></i> Ver Detalhes
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-600 py-10">
                            <i class="fas fa-frown text-6xl mb-4"></i>
                            <p class="text-lg">Nenhum imóvel encontrado com os filtros aplicados.</p>
                            <button class="btn btn-ghost mt-4" wire:click="resetFilters">Limpar todos os filtros</button>
                        </div>
                    @endforelse
                </div>

                <div class="mt-10">
                    {{ $properties->links('vendor.livewire.tailwind') }} {{-- DaisyUI já estiliza bem com classes Tailwind --}}
                </div>
            </div>
        </div>
    </main>

    @livewireScriptConfig
    <script>
        document.addEventListener('alpine:init', () => {
            // Livewire já gerencia as propriedades aqui
            // Alpine.store('properties', { ... });
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