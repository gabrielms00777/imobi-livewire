<!DOCTYPE html>
<html lang="pt-BR" x-data="{ darkMode: false, filtersOpen: window.innerWidth >= 1024, minPrice: 0, maxPrice: 2000000, currentMinPrice: 200000, currentMaxPrice: 1000000, propertyType: 'all', bedrooms: 'all', bathrooms: 'all', parkingSpaces: 'all', minArea: null, maxArea: null, sortOrder: 'relevance' }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imóveis | Sua Nova Casa Está Aqui</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/daisyui@latest/dist/full.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        
        :root {
            --primary: #3b82f6;
            --secondary: #10b981;
            --accent: #f59e0b;
            --neutral: #1f2937;
            --base-100: #ffffff;
        }

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
            animation: fadeIn 0.6s ease-out forwards;
        }

        .property-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -8px rgba(0, 0, 0, 0.15);
        }

        /* Esconder a barra de rolagem em ranges para melhor UX, se necessário */
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--primary);
            cursor: pointer;
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.3); /* Adicionar um brilho sutil */
        }

        input[type="range"]::-moz-range-thumb {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--primary);
            cursor: pointer;
            box-shadow: 0 0 0 4px rgba(var(--primary-rgb), 0.3);
        }
    </style>
</head>

<body class="bg-base-200 text-neutral min-h-screen flex flex-col">
    <header class="sticky top-0 z-50 shadow-lg bg-base-100">
        <div class="navbar container mx-auto px-4 py-3">
            <div class="flex-1">
                <a href="#" class="btn btn-ghost normal-case text-2xl font-extrabold text-primary"
                    aria-label="Voltar para a página inicial da Imobiliária">Imobiliária</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal p-0 hidden md:flex font-medium">
                    <li><a href="#destaques" class="hover:text-primary transition-colors duration-200">Destaques</a>
                    </li>
                    <li><a href="#sobre" class="hover:text-primary transition-colors duration-200">Sobre Nós</a></li>
                    <li><a href="#recentes" class="hover:text-primary transition-colors duration-200">Recentes</a>
                    </li>
                    <li><a href="#contato" class="hover:text-primary transition-colors duration-200">Contato</a></li>
                </ul>

                <label class="swap swap-rotate ml-4">
                    <input type="checkbox" @change="darkMode = $event.target.checked" :checked="darkMode"
                        class="theme-controller" />
                    <i class="swap-off fas fa-sun text-2xl text-accent"></i>
                    <i class="swap-on fas fa-moon text-2xl text-primary"></i>
                </label>

                <div class="dropdown dropdown-end md:hidden ml-2">
                    <label tabindex="0" class="btn btn-ghost btn-circle" aria-label="Abrir menu de navegação">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                    <ul tabindex="0"
                        class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52 font-medium">
                        <li><a href="#destaques">Destaques</a></li>
                        <li><a href="#sobre">Sobre Nós</a></li>
                        <li><a href="#recentes">Recentes</a></li>
                        <li><a href="#contato">Contato</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <section class="relative h-96 md:h-[450px] bg-cover bg-center flex items-center justify-center text-white p-4"
        style="background-image: url('https://images.unsplash.com/photo-1516156007-ad0749a37e19?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative z-10 text-center animate-fade-in">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight drop-shadow-lg">
                Encontre o Lar dos Seus Sonhos
            </h1>
            <p class="text-lg md:text-xl mb-8 max-w-2xl mx-auto drop-shadow-md">
                Milhares de imóveis selecionados nas melhores localizações para você e sua família.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#imoveis" class="btn btn-primary btn-lg transform hover:scale-105 transition-transform duration-200">
                    <i class="fas fa-search mr-2"></i> Explorar Imóveis
                </a>
                <a href="#contato" class="btn btn-outline btn-lg text-white border-white hover:bg-white hover:text-primary transform hover:scale-105 transition-transform duration-200">
                    <i class="fas fa-phone-alt mr-2"></i> Fale Conosco
                </a>
            </div>
        </div>
    </section>

    <main class="container mx-auto px-4 py-12 flex-grow">
        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="lg:w-80 shrink-0" x-init="$watch('filtersOpen', (value) => { if (!value && window.innerWidth < 1024) { /* Opcional: fechar ao clicar fora, etc. */ } })">
                <div class="lg:sticky lg:top-24 bg-base-100 p-6 rounded-xl shadow-lg">
                    <button @click="filtersOpen = !filtersOpen"
                        class="btn btn-primary w-full lg:hidden mb-6 flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i>
                        <span x-text="filtersOpen ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
                    </button>

                    <div x-show="filtersOpen" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-4"
                        class="space-y-8">
                        <h2 class="text-2xl font-bold text-center mb-6 text-primary">Filtrar Imóveis</h2>

                        <div>
                            <h3 class="font-semibold mb-3 text-lg">Tipo de Imóvel</h3>
                            <div class="grid grid-cols-2 gap-2">
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-base-200 transition-colors duration-150">
                                    <input type="radio" name="propertyType" value="all" x-model="propertyType"
                                        class="radio radio-primary" checked>
                                    <span>Todos</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-base-200 transition-colors duration-150">
                                    <input type="radio" name="propertyType" value="house" x-model="propertyType"
                                        class="radio radio-primary">
                                    <span>Casas</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-base-200 transition-colors duration-150">
                                    <input type="radio" name="propertyType" value="apartment" x-model="propertyType"
                                        class="radio radio-primary">
                                    <span>Apartamentos</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-base-200 transition-colors duration-150">
                                    <input type="radio" name="propertyType" value="land" x-model="propertyType"
                                        class="radio radio-primary">
                                    <span>Terrenos</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer p-2 rounded-lg hover:bg-base-200 transition-colors duration-150">
                                    <input type="radio" name="propertyType" value="commercial" x-model="propertyType"
                                        class="radio radio-primary">
                                    <span>Comercial</span>
                                </label>
                            </div>
                        </div>

                        <div x-data="{
                            minPriceDisplay: 0,
                            maxPriceDisplay: 2000000,
                            init() {
                                this.minPriceDisplay = this.currentMinPrice;
                                this.maxPriceDisplay = this.currentMaxPrice;
                                $watch('currentMinPrice', val => this.minPriceDisplay = val);
                                $watch('currentMaxPrice', val => this.maxPriceDisplay = val);
                            },
                            formatCurrency(value) {
                                return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(value)
                            },
                            updatePriceRange() {
                                if (this.currentMinPrice > this.currentMaxPrice) {
                                    [this.currentMinPrice, this.currentMaxPrice] = [this.currentMaxPrice, this.currentMinPrice];
                                }
                            }
                        }">
                            <h3 class="font-semibold mb-3 text-lg">Faixa de Preço</h3>
                            <div class="flex justify-between mb-4 font-bold text-primary">
                                <span x-text="formatCurrency(minPriceDisplay)"></span>
                                <span x-text="formatCurrency(maxPriceDisplay)"></span>
                            </div>
                            <div class="relative mb-6">
                                <input type="range" :min="minPrice" :max="maxPrice" x-model.number="currentMinPrice"
                                    @input="updatePriceRange"
                                    class="range range-primary range-xs absolute w-full z-20 appearance-none bg-transparent"
                                    style="padding:0; margin:0;" step="10000" aria-label="Preço mínimo">
                                <input type="range" :min="minPrice" :max="maxPrice" x-model.number="currentMaxPrice"
                                    @input="updatePriceRange"
                                    class="range range-primary range-xs absolute w-full z-20 appearance-none bg-transparent"
                                    style="padding:0; margin:0;" step="10000" aria-label="Preço máximo">
                                <div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-1 bg-base-300 rounded-full z-10"></div>
                            </div>
                        </div>


                        <div>
                            <h3 class="font-semibold mb-3 text-lg">Quartos</h3>
                            <div class="flex flex-wrap gap-2">
                                <button @click="bedrooms = 'all'" :class="{'btn-primary': bedrooms === 'all', 'btn-outline': bedrooms !== 'all'}" class="btn btn-sm">Todos</button>
                                <button @click="bedrooms = '1+'" :class="{'btn-primary': bedrooms === '1+', 'btn-outline': bedrooms !== '1+'}" class="btn btn-sm">1+</button>
                                <button @click="bedrooms = '2+'" :class="{'btn-primary': bedrooms === '2+', 'btn-outline': bedrooms !== '2+'}" class="btn btn-sm">2+</button>
                                <button @click="bedrooms = '3+'" :class="{'btn-primary': bedrooms === '3+', 'btn-outline': bedrooms !== '3+'}" class="btn btn-sm">3+</button>
                                <button @click="bedrooms = '4+'" :class="{'btn-primary': bedrooms === '4+', 'btn-outline': bedrooms !== '4+'}" class="btn btn-sm">4+</button>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-3 text-lg">Banheiros</h3>
                            <div class="flex flex-wrap gap-2">
                                <button @click="bathrooms = 'all'" :class="{'btn-primary': bathrooms === 'all', 'btn-outline': bathrooms !== 'all'}" class="btn btn-sm">Todos</button>
                                <button @click="bathrooms = '1+'" :class="{'btn-primary': bathrooms === '1+', 'btn-outline': bathrooms !== '1+'}" class="btn btn-sm">1+</button>
                                <button @click="bathrooms = '2+'" :class="{'btn-primary': bathrooms === '2+', 'btn-outline': bathrooms !== '2+'}" class="btn btn-sm">2+</button>
                                <button @click="bathrooms = '3+'" :class="{'btn-primary': bathrooms === '3+', 'btn-outline': bathrooms !== '3+'}" class="btn btn-sm">3+</button>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-3 text-lg">Vagas</h3>
                            <div class="flex flex-wrap gap-2">
                                <button @click="parkingSpaces = 'all'" :class="{'btn-primary': parkingSpaces === 'all', 'btn-outline': parkingSpaces !== 'all'}" class="btn btn-sm">Todas</button>
                                <button @click="parkingSpaces = '1+'" :class="{'btn-primary': parkingSpaces === '1+', 'btn-outline': parkingSpaces !== '1+'}" class="btn btn-sm">1+</button>
                                <button @click="parkingSpaces = '2+'" :class="{'btn-primary': parkingSpaces === '2+', 'btn-outline': parkingSpaces !== '2+'}" class="btn btn-sm">2+</button>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold mb-3 text-lg">Área (m²)</h3>
                            <div class="flex gap-4">
                                <div class="form-control w-1/2">
                                    <label class="label p-0">
                                        <span class="label-text text-xs">Mínima</span>
                                    </label>
                                    <input type="number" x-model.number="minArea" placeholder="0"
                                        class="input input-bordered w-full input-sm text-sm" aria-label="Área mínima">
                                </div>
                                <div class="form-control w-1/2">
                                    <label class="label p-0">
                                        <span class="label-text text-xs">Máxima</span>
                                    </label>
                                    <input type="number" x-model.number="maxArea" placeholder="Qualquer"
                                        class="input input-bordered w-full input-sm text-sm" aria-label="Área máxima">
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-base-300 mt-8">
                            <button class="btn btn-primary w-full mb-3 text-lg">
                                <i class="fas fa-check-circle mr-2"></i> Aplicar Filtros
                            </button>
                            <button class="btn btn-ghost w-full text-base-content hover:text-primary transition-colors duration-200" @click="
                                propertyType = 'all';
                                currentMinPrice = 200000;
                                currentMaxPrice = 1000000;
                                bedrooms = 'all';
                                bathrooms = 'all';
                                parkingSpaces = 'all';
                                minArea = null;
                                maxArea = null;
                            ">
                                <i class="fas fa-redo mr-2"></i> Limpar Filtros
                            </button>
                        </div>
                    </div>
                </div>
            </aside>

            <section class="flex-1" id="imoveis">
                <h2 class="text-3xl font-bold mb-8 text-center lg:text-left text-primary">Imóveis Disponíveis</h2>

                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 bg-base-100 p-4 rounded-lg shadow-sm">
                    <div class="text-sm md:text-base text-gray-600 dark:text-gray-400">
                        <span class="font-semibold text-lg text-neutral">12</span> imóveis encontrados
                    </div>
                    <div class="flex items-center gap-3">
                        <label for="sort-select" class="text-sm md:text-base text-gray-600 dark:text-gray-400 hidden sm:block">Ordenar por:</label>
                        <select id="sort-select" x-model="sortOrder" class="select select-bordered select-sm w-full max-w-xs">
                            <option value="relevance">Relevância</option>
                            <option value="price-asc">Menor Preço</option>
                            <option value="price-desc">Maior Preço</option>
                            <option value="recent">Mais Recentes</option>
                            <option value="area-desc">Maior Área</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{
                    properties: [
                        {
                            id: 1,
                            title: 'Casa Moderna no Centro',
                            location: 'Centro, São Paulo',
                            bedrooms: 3,
                            bathrooms: 2,
                            area: 180,
                            price: 850000,
                            image: 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            featured: true,
                            description: 'Esta casa moderna no coração da cidade oferece conforto e sofisticação. Com acabamentos de alta qualidade e uma localização privilegiada, é a escolha perfeita para quem busca praticidade e estilo de vida urbano.',
                            rating: 4.5,
                            reviews: 12,
                            parking: 2,
                            type: 'house'
                        },
                        {
                            id: 2,
                            title: 'Apartamento Luxuoso',
                            location: 'Zona Sul, Rio de Janeiro',
                            bedrooms: 4,
                            bathrooms: 3,
                            area: 220,
                            price: 1250000,
                            image: 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            featured: false,
                            description: 'Apartamento de alto padrão com vista para o mar, acabamentos em mármore, cozinha gourmet equipada, sacada ampla e lazer completo com piscina, sauna e academia.',
                            rating: 4.0,
                            reviews: 8,
                            parking: 2,
                            type: 'apartment'
                        },
                        {
                            id: 3,
                            title: 'Casa com Piscina Incrível',
                            location: 'Zona Oeste, Belo Horizonte',
                            bedrooms: 5,
                            bathrooms: 4,
                            area: 350,
                            price: 2500000,
                            image: 'https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            featured: false,
                            new: true,
                            description: 'Mansão moderna com piscina, área gourmet, home theater, jardim vertical e amplos espaços de convivência. Projeto arquitetônico premiado com integração perfeita entre áreas internas e externas.',
                            rating: 5.0,
                            reviews: 15,
                            parking: 4,
                            type: 'house'
                        },
                        {
                            id: 4,
                            title: 'Apartamento Compacto e Moderno',
                            location: 'Centro, Curitiba',
                            bedrooms: 2,
                            bathrooms: 1,
                            area: 65,
                            price: 320000,
                            image: 'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                            new: true,
                            description: 'Ideal para solteiros ou casais, este apartamento oferece praticidade e conforto em uma localização privilegiada. Perto de comércios, transportes e parques.',
                            rating: 3.5,
                            reviews: 5,
                            parking: 1,
                            type: 'apartment'
                        },
                        {
                            id: 5,
                            title: 'Terreno Amplo para Construção',
                            location: 'Alphaville, São Paulo',
                            bedrooms: 0,
                            bathrooms: 0,
                            area: 1200,
                            price: 980000,
                            image: 'https://images.unsplash.com/photo-1543285198-ed21122a7e71?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            featured: false,
                            description: 'Ótimo terreno em condomínio fechado, perfeito para construir a casa dos seus sonhos. Infraestrutura completa e segurança 24h.',
                            rating: 4.0,
                            reviews: 3,
                            parking: 0,
                            type: 'land'
                        },
                        {
                            id: 6,
                            title: 'Sala Comercial de Alto Padrão',
                            location: 'Av. Paulista, São Paulo',
                            bedrooms: 0,
                            bathrooms: 2,
                            area: 150,
                            price: 1800000,
                            image: 'https://images.unsplash.com/photo-1590487958197-0ec99df5e970?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
                            featured: true,
                            description: 'Localização estratégica na Av. Paulista, ideal para escritórios e clínicas. Espaços amplos e modernos com toda a infraestrutura necessária.',
                            rating: 4.8,
                            reviews: 10,
                            parking: 3,
                            type: 'commercial'
                        }
                    ],
                    filteredProperties() {
                        return this.properties.filter(property => {
                            let match = true;

                            // Filter by type
                            if (this.propertyType !== 'all' && property.type !== this.propertyType) {
                                match = false;
                            }

                            // Filter by price range
                            if (property.price < this.currentMinPrice || property.price > this.currentMaxPrice) {
                                match = false;
                            }

                            // Filter by bedrooms
                            if (this.bedrooms !== 'all') {
                                const minBeds = parseInt(this.bedrooms.replace('+', ''));
                                if (property.bedrooms < minBeds) {
                                    match = false;
                                }
                            }

                            // Filter by bathrooms
                            if (this.bathrooms !== 'all') {
                                const minBaths = parseInt(this.bathrooms.replace('+', ''));
                                if (property.bathrooms < minBaths) {
                                    match = false;
                                }
                            }

                            // Filter by parking spaces
                            if (this.parkingSpaces !== 'all') {
                                const minParking = parseInt(this.parkingSpaces.replace('+', ''));
                                if (property.parking < minParking) {
                                    match = false;
                                }
                            }

                            // Filter by area
                            if (this.minArea !== null && property.area < this.minArea) {
                                match = false;
                            }
                            if (this.maxArea !== null && property.area > this.maxArea) {
                                match = false;
                            }

                            return match;
                        }).sort((a, b) => {
                            if (this.sortOrder === 'price-asc') return a.price - b.price;
                            if (this.sortOrder === 'price-desc') return b.price - a.price;
                            if (this.sortOrder === 'area-desc') return b.area - a.area;
                            // Default or 'relevance'
                            return 0;
                        });
                    }
                }">
                    <template x-for="property in filteredProperties()" :key="property.id">
                        <a :href="`detalhes.html?id=${property.id}`" class="block">
                            <div class="property-card card w-full bg-base-100 shadow-xl image-full group animate-fade-in"
                                :style="`animation-delay: ${property.id * 0.05}s;`">
                                <figure class="h-64 sm:h-72 lg:h-64 xl:h-72 overflow-hidden">
                                    <img :src="property.image" :alt="property.title"
                                        class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105"
                                        loading="lazy">
                                </figure>
                                <div class="card-body p-6 relative justify-end">
                                    <div class="absolute top-4 right-4 flex gap-2">
                                        <span x-show="property.featured" class="badge badge-primary font-bold">Destaque</span>
                                        <span x-show="property.new" class="badge badge-secondary font-bold">Novo</span>
                                    </div>

                                    <h3 class="card-title text-white text-2xl font-bold mb-1 leading-tight group-hover:text-primary transition-colors duration-200" x-text="property.title"></h3>
                                    <p class="text-gray-200 text-sm mb-4 flex items-center">
                                        <i class="fas fa-map-marker-alt mr-2 text-primary"></i>
                                        <span x-text="property.location"></span>
                                    </p>

                                    <div class="flex flex-wrap gap-x-4 gap-y-2 text-white text-sm mb-4">
                                        <div class="flex items-center">
                                            <i class="fas fa-bed mr-2 text-primary"></i>
                                            <span x-text="property.bedrooms > 0 ? `${property.bedrooms} Quartos` : 'N/A'"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-bath mr-2 text-primary"></i>
                                            <span x-text="property.bathrooms > 0 ? `${property.bathrooms} Banheiros` : 'N/A'"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-ruler-combined mr-2 text-primary"></i>
                                            <span x-text="`${property.area} m²`"></span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-car mr-2 text-primary"></i>
                                            <span x-text="property.parking > 0 ? `${property.parking} Vagas` : 'N/A'"></span>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between mt-4">
                                        <span class="text-3xl font-extrabold text-white"
                                            x-text="new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL', minimumFractionDigits: 0, maximumFractionDigits: 0 }).format(property.price)"></span>
                                        <button class="btn btn-primary btn-sm md:btn-md">
                                            <i class="fas fa-eye mr-2"></i> Detalhes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </template>

                    <div x-show="filteredProperties().length === 0" class="col-span-full text-center py-10 text-xl text-gray-500">
                        Nenhum imóvel encontrado com os filtros aplicados.
                    </div>
                </div>


                <div class="flex justify-center mt-12">
                    <div class="join shadow-md">
                        <button class="join-item btn btn-outline border-base-300 hover:bg-primary hover:border-primary hover:text-white transition-colors duration-200">
                            <i class="fas fa-chevron-left"></i> Anterior
                        </button>
                        <button class="join-item btn btn-primary border-primary">1</button>
                        <button class="join-item btn btn-outline border-base-300 hover:bg-primary hover:border-primary hover:text-white transition-colors duration-200">2</button>
                        <button class="join-item btn btn-outline border-base-300 hover:bg-primary hover:border-primary hover:text-white transition-colors duration-200">3</button>
                        <button class="join-item btn btn-outline border-base-300 hover:bg-primary hover:border-primary hover:text-white transition-colors duration-200">4</button>
                        <button class="join-item btn btn-outline border-base-300 hover:bg-primary hover:border-primary hover:text-white transition-colors duration-200">
                            Próxima <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <footer class="footer footer-center p-10 bg-neutral text-neutral-content rounded mt-12">
        <aside>
            <a href="#" class="btn btn-ghost normal-case text-3xl font-extrabold text-primary mb-4"
                aria-label="Voltar para a página inicial da Imobiliária">Imobiliária</a>
            <p class="font-bold">
                Encontre seu lar ideal conosco. <br>Oferecendo os melhores imóveis desde 2020.
            </p>
            <p>Copyright © 2025 - Todos os direitos reservados</p>
        </aside>
        <nav>
            <div class="grid grid-flow-col gap-4">
                <a href="#" class="link link-hover text-2xl" aria-label="Link para Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" class="link link-hover text-2xl" aria-label="Link para YouTube"><i class="fab fa-youtube"></i></a>
                <a href="#" class="link link-hover text-2xl" aria-label="Link para Facebook"><i class="fab fa-facebook-f"></i></a>
            </div>
        </nav>
    </footer>

    <script>
        document.addEventListener('alpine:init', () => {
            // No longer using Alpine.store for properties array,
            // instead directly managing it within the component x-data for simplicity in this single file example.
            // For larger apps, Alpine.store or external data fetching would be preferred.

            // Ensure filtersOpen respects screen size on load
            window.addEventListener('resize', () => {
                Alpine.raw(Alpine.data('root')).filtersOpen = window.innerWidth >= 1024;
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