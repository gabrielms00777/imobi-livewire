<!DOCTYPE html>
<html lang="pt-BR" x-data="{ darkMode: false, filtersOpen: true, priceRange: [200000, 1000000] }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Moderna no Centro - Imobiliária</title>
    <!-- Tailwind CSS + DaisyUI -->
    {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @else --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --color-primary: {{ $tenantSettings->primary_color ?? '#3b82f6' }};
            --color-secondary: {{ $tenantSettings->secondary_color ?? '#f63b3b' }};
            --color-neutral: {{ $tenantSettings->text_color }};
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
    <header x-data="{ isScrolled: false }" @scroll.window="isScrolled = window.scrollY > 50"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="isScrolled ? 'bg-white shadow-md dark:bg-neutral' : 'bg-transparent'">

        <div class="container mx-auto px-4">
            <div class="navbar">
                <div class="flex-1">
                    <a :href="route('tenant.home', ['tenantSlug' => $tenant - > slug])" class="px-0">
                        <div class="flex items-center">
                            <a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}">
                                @if ($tenantSettings->logo && $tenantSettings->show_logo_and_name)
                                    <img src="{{ $tenantSettings->logo }}" alt="Logo {{ $tenantSettings->site_name }}"
                                        class="h-8 w-auto mr-2 rounded-lg">
                                    @php
                                        $names = explode(' ', $tenantSettings->site_name);
                                    @endphp
                                    <span class="text-xl font-bold text-primary">{{ $names[0] ?? '' }}
                                        @if (isset($names[1]))
                                            <span class="text-secondary">{{ $names[1] }}</span>
                                        @endif
                                    </span>
                                @elseif ($tenantSettings->logo)
                                    <img src="{{ $tenantSettings->logo }}" alt="Logo {{ $tenantSettings->site_name }}"
                                        class="h-10 w-auto rounded-lg">
                                @elseif ($tenantSettings->site_name)
                                    @php
                                        $names = explode(' ', $tenantSettings->site_name);
                                    @endphp
                                    <span class="text-xl font-bold text-primary">{{ $names[0] ?? '' }}
                                        @if (isset($names[1]))
                                            <span class="text-secondary">{{ $names[1] }}</span>
                                        @endif
                                    </span>
                                @else
                                    <span class="text-xl font-bold text-primary">Seu Site</span>
                                @endif
                            </a>
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

    <!-- Hero Minimalista -->
    <section class="relative h-96 bg-base-200 flex items-center">
        <!-- Fundo com gradiente sutil -->
        <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-secondary/10 z-0"></div>

        <!-- Conteúdo -->
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                    Seu próximo lar <span class="text-primary">está aqui</span>
                </h1>
                <p class="text-xl mb-8 opacity-90">
                    Encontre imóveis selecionados com as melhores localizações e condições
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#destaques" class="btn btn-primary btn-lg">
                        <i class="fas fa-home mr-2"></i> Ver Destaques
                    </a>
                    <a href="#contato" class="btn btn-outline btn-lg">
                        <i class="fas fa-headset mr-2"></i> Fale com Corretor
                    </a>
                </div>
            </div>
        </div>

        <!-- Elemento decorativo -->
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-base-100/80"></div>
    </section>

    <main class="container mx-auto px-4 py-8" x-data="propertyFilter()">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filtros - Sidebar -->
            <aside class="lg:w-80 shrink-0">
                <div class="sticky top-24">
                    <button @click="filtersOpen = !filtersOpen" class="btn btn-primary w-full lg:hidden mb-4">
                        <i class="fas fa-filter mr-2"></i>
                        <span x-text="filtersOpen ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
                    </button>

                    <div x-show="filtersOpen" class="bg-base-100 p-6 rounded-xl shadow-md space-y-6">
                        <h2 class="text-xl font-bold">Filtrar Imóveis</h2>

                        <!-- Tipo de Imóvel -->
                        <div>
                            <h3 class="font-semibold mb-2">Tipo de Imóvel</h3>
                            <div class="space-y-2">
                                <template x-for="type in propertyTypes">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="property_type" x-model="filters.property_type"
                                            :value="type.value" @change="applyFilters()"
                                            class="radio radio-primary">
                                        <span x-text="type.label"></span>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <!-- Tipo de Transação -->
                        <div>
                            <h3 class="font-semibold mb-2">Tipo de Transação</h3>
                            <div class="space-y-2">
                                <template x-for="transaction in transactionTypes">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="radio" name="transaction_type"
                                            x-model="filters.transaction_type" :value="transaction.value"
                                            @change="applyFilters()" class="radio radio-primary">
                                        <span x-text="transaction.label"></span>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <!-- Faixa de Preço -->
                        <div>
                            <h3 class="font-semibold mb-2">Faixa de Preço</h3>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span x-text="formatCurrency(filters.min_price)"></span>
                                    <span x-text="formatCurrency(filters.max_price)"></span>
                                </div>
                                <input type="range" x-model="filters.min_price" min="0" max="5000000"
                                    step="10000" @change="applyFilters()"
                                    class="range range-primary range-xs mb-4">
                                <input type="range" x-model="filters.max_price" min="0" max="5000000"
                                    step="10000" @change="applyFilters()" class="range range-primary range-xs">
                            </div>
                        </div>

                        <!-- Quartos -->
                        <div>
                            <h3 class="font-semibold mb-2">Quartos</h3>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="n in 5">
                                    <button
                                        @click="filters.bedrooms = (filters.bedrooms === n ? null : n); applyFilters()"
                                        :class="filters.bedrooms === n ? 'btn btn-sm' : 'btn btn-sm btn-outline'"
                                        x-text="n === 5 ? '5+' : n"></button>
                                </template>
                            </div>
                        </div>

                        <!-- Banheiros -->
                        <div>
                            <h3 class="font-semibold mb-2">Banheiros</h3>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="n in 3">
                                    <button
                                        @click="filters.bathrooms = (filters.bathrooms === n ? null : n); applyFilters()"
                                        :class="filters.bathrooms === n ? 'btn btn-sm' : 'btn btn-sm btn-outline'"
                                        x-text="n === 3 ? '3+' : n"></button>
                                </template>
                            </div>
                        </div>

                        <!-- Área -->
                        <div>
                            <h3 class="font-semibold mb-2">Área (m²)</h3>
                            <div class="flex gap-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Mínima</span>
                                    </label>
                                    <input type="number" x-model="filters.min_area"
                                        @change.debounce.500ms="applyFilters()" placeholder="0"
                                        class="input input-bordered w-full">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Máxima</span>
                                    </label>
                                    <input type="number" x-model="filters.max_area"
                                        @change.debounce.500ms="applyFilters()" placeholder="Qualquer"
                                        class="input input-bordered w-full">
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="pt-4">
                            <button @click="resetFilters()" class="btn btn-ghost w-full mb-2">Limpar Filtros</button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Lista de Imóveis -->
            <div class="flex-1">
                <!-- Ordenação e Contagem -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div class="text-sm">
                        <span class="font-semibold" x-text="totalProperties"></span> imóveis encontrados
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm hidden md:block">Ordenar por:</span>
                        <select class="select select-bordered select-sm" x-model="filters.order_by"
                            @change="applyFilters()">
                            <option value="created_at:desc">Mais Recentes</option>
                            <option value="price:asc">Menor Preço</option>
                            <option value="price:desc">Maior Preço</option>
                            <option value="area:desc">Maior Área</option>
                        </select>
                    </div>
                </div>

                <!-- Lista de Imóveis -->
                <div id="property-list" class="space-y-6">
                    @include('partials.property-list', ['properties' => $properties])
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('propertyFilter', () => ({
                filtersOpen: true,
                totalProperties: {{ $properties->total() }},
                propertyTypes: [{
                        value: '',
                        label: 'Todos'
                    },
                    {
                        value: 'Casa',
                        label: 'Casa'
                    },
                    {
                        value: 'Apartamento',
                        label: 'Apartamento'
                    },
                    {
                        value: 'Terreno',
                        label: 'Terreno'
                    },
                    {
                        value: 'Comercial',
                        label: 'Comercial'
                    }
                ],
                transactionTypes: [{
                        value: '',
                        label: 'Todos'
                    },
                    {
                        value: 'Venda',
                        label: 'Venda'
                    },
                    {
                        value: 'Aluguel',
                        label: 'Aluguel'
                    }
                ],
                filters: {
                    property_type: '',
                    transaction_type: '',
                    min_price: 0,
                    max_price: 5000000,
                    bedrooms: null,
                    bathrooms: null,
                    min_area: null,
                    max_area: null,
                    order_by: 'created_at:desc'
                },
                loading: false,

                init() {
                    // Se houver filtros na URL, aplica eles
                    const urlParams = new URLSearchParams(window.location.search);
                    for (const [key, value] of urlParams) {
                        if (this.filters.hasOwnProperty(key)) {
                            this.filters[key] = value;
                        }
                    }

                    // Formata preço inicial
                    this.formatCurrency = this.debounce((value) => {
                        return new Intl.NumberFormat('pt-BR', {
                            style: 'currency',
                            currency: 'BRL',
                            maximumFractionDigits: 0
                        }).format(value);
                    }, 300);
                },

                applyFilters() {
                    this.loading = true;

                    // Atualiza URL sem recarregar a página
                    const queryString = new URLSearchParams();
                    for (const [key, value] of Object.entries(this.filters)) {
                        if (value !== null && value !== '') {
                            queryString.set(key, value);
                        }
                    }
                    history.pushState(null, null, `?${queryString.toString()}`);

                    // Faz a requisição AJAX
                    fetch(`/properties?${queryString.toString()}&ajax=1`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('property-list').innerHTML = data.html;
                            this.totalProperties = data.properties.total;
                            this.loading = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.loading = false;
                        });
                },

                loadPage(url) {
                    this.loading = true;
                    fetch(`${url}&ajax=1`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('property-list').innerHTML = data.html;
                            this.totalProperties = data.properties.total;
                            this.loading = false;
                        });
                },

                resetFilters() {
                    this.filters = {
                        property_type: '',
                        transaction_type: '',
                        min_price: 0,
                        max_price: 5000000,
                        bedrooms: null,
                        bathrooms: null,
                        min_area: null,
                        max_area: null,
                        order_by: 'created_at:desc'
                    };
                    this.applyFilters();
                },

                debounce(func, wait) {
                    let timeout;
                    return function(...args) {
                        const context = this;
                        clearTimeout(timeout);
                        timeout = setTimeout(() => func.apply(context, args), wait);
                    };
                }
            }));
        });
    </script>
</body>

</html>
