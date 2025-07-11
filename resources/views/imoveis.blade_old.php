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
            animation: fadeIn 0.9s ease-out forwards;
        }

        .property-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .property-card {
            transition: all 0.3s ease;
        }

        [x-cloak] { display: none !important; }
    </style>
</head>

<body class="bg-base-100 text-neutral" x-data="{ filtersOpen: false, priceRange: [200000, 1000000] }">
    <!-- Header/Navbar (igual ao template principal) -->
    <header class="sticky top-0 z-50 shadow-md bg-base-100">
        <div class="navbar container mx-auto px-4">
            <div class="flex-1">
                <a href="#" class="btn btn-ghost normal-case text-xl font-bold text-primary">Imobiliária</a>
            </div>
            <div class="flex-none">
                <ul class="menu menu-horizontal p-0 hidden md:flex">
                    <li><a href="#destaques">Destaques</a></li>
                    <li><a href="#sobre">Sobre</a></li>
                    <li><a href="#recentes">Recentes</a></li>
                    <li><a href="#contato">Contato</a></li>
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
                        <li><a href="#destaques">Destaques</a></li>
                        <li><a href="#sobre">Sobre</a></li>
                        <li><a href="#recentes">Recentes</a></li>
                        <li><a href="#contato">Contato</a></li>
                    </ul>
                </div>
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

    <!-- Conteúdo Principal -->
    <main class="container mx-auto px-4 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Filtros - Sidebar -->
            <aside class="lg:w-80 shrink-0">
                <div class="sticky top-4 lg:top-24"> <!-- Ajustado top para mobile -->
                    <!-- Botão para mobile -->
                    <button @click="filtersOpen = !filtersOpen" class="btn btn-primary w-full lg:hidden mb-4">
                        <i class="fas fa-filter mr-2"></i>
                        <span x-text="filtersOpen ? 'Ocultar Filtros' : 'Mostrar Filtros'"></span>
                    </button>

                    <!-- Filtros -->
                    <!-- Adicionado lg:block para sempre mostrar em telas grandes -->
                    <div x-show="filtersOpen || window.innerWidth >= 1024" x-clock
                        x-transition:enter="transition ease-out duration-300" 
                        x-transition:enter-start="opacity-0 transform -translate-y-4" 
                        x-transition:enter-end="opacity-100 transform translate-y-0" 
                        x-transition:leave="transition ease-in duration-200" 
                        x-transition:leave-start="opacity-100 transform translate-y-0" 
                        x-transition:leave-end="opacity-0 transform -translate-y-4" 
                        class="bg-base-100 p-6 rounded-xl shadow-md space-y-6 lg:block">
                        <h2 class="text-xl font-bold">Filtrar Imóveis</h2>

                        <!-- Tipo de Imóvel -->
                        <div>
                            <h3 class="font-semibold mb-2">Tipo de Imóvel</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" checked class="checkbox checkbox-primary">
                                    <span>Todos</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="checkbox checkbox-primary">
                                    <span>Casas</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="checkbox checkbox-primary">
                                    <span>Apartamentos</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="checkbox checkbox-primary">
                                    <span>Terrenos</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" class="checkbox checkbox-primary">
                                    <span>Comercial</span>
                                </label>
                            </div>
                        </div>

                        <!-- Faixa de Preço -->
                        <div>
                            <h3 class="font-semibold mb-2">Faixa de Preço</h3>
                            <div x-data="{
                                minPrice: 200000,
                                maxPrice: 1000000,
                                formatCurrency(value) {
                                    return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value)
                                }
                            }" x-init="priceRange = [minPrice, maxPrice]"> <!-- Inicializa priceRange com valores padrão -->
                                <div class="flex justify-between mb-2 text-sm">
                                    <span x-text="formatCurrency(priceRange[0])"></span>
                                    <span x-text="formatCurrency(priceRange[1])"></span>
                                </div>
                                <input type="range" x-model="priceRange[0]" :min="0" :max="1000000"
                                    step="10000" class="range range-primary range-xs mb-4">
                                <input type="range" x-model="priceRange[1]" :min="0" :max="1000000"
                                    step="10000" class="range range-primary range-xs">
                            </div>
                        </div>

                        <!-- Quartos -->
                        <div>
                            <h3 class="font-semibold mb-2">Quartos</h3>
                            <div class="flex flex-wrap gap-2">
                                <button class="btn btn-sm">Todos</button>
                                <button class="btn btn-sm btn-outline">1+</button>
                                <button class="btn btn-sm btn-outline">2+</button>
                                <button class="btn btn-sm btn-outline">3+</button>
                                <button class="btn btn-sm btn-outline">4+</button>
                            </div>
                        </div>

                        <!-- Banheiros -->
                        <div>
                            <h3 class="font-semibold mb-2">Banheiros</h3>
                            <div class="flex flex-wrap gap-2">
                                <button class="btn btn-sm">Todos</button>
                                <button class="btn btn-sm btn-outline">1+</button>
                                <button class="btn btn-sm btn-outline">2+</button>
                                <button class="btn btn-sm btn-outline">3+</button>
                            </div>
                        </div>

                        <!-- Vagas -->
                        <div>
                            <h3 class="font-semibold mb-2">Vagas</h3>
                            <div class="flex flex-wrap gap-2">
                                <button class="btn btn-sm">Todas</button>
                                <button class="btn btn-sm btn-outline">1+</button>
                                <button class="btn btn-sm btn-outline">2+</button>
                            </div>
                        </div>

                        <!-- Área -->
                        <div>
                            <h3 class="font-semibold mb-2">Área (m²)</h3>
                            <div class="flex gap-4">
                                <div class="form-control flex-1"> <!-- Usar flex-1 para ocupar espaço disponível -->
                                    <label class="label">
                                        <span class="label-text">Mínima</span>
                                    </label>
                                    <input type="number" placeholder="0" class="input input-bordered w-full">
                                </div>
                                <div class="form-control flex-1"> <!-- Usar flex-1 para ocupar espaço disponível -->
                                    <label class="label">
                                        <span class="label-text">Máxima</span>
                                    </label>
                                    <input type="number" placeholder="Qualquer" class="input input-bordered w-full">
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="pt-4">
                            <button class="btn btn-primary w-full mb-2">Aplicar Filtros</button>
                            <button class="btn btn-ghost w-full">Limpar Filtros</button>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Lista de Imóveis -->
            <div class="flex-1">
                <!-- Ordenação e Contagem -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                    <div class="text-sm">
                        <span class="font-semibold">12</span> imóveis encontrados
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm hidden md:block">Ordenar por:</span>
                        <select class="select select-bordered select-sm">
                            <option>Relevância</option>
                            <option>Menor Preço</option>
                            <option>Maior Preço</option>
                            <option>Mais Recentes</option>
                            <option>Maior Área</option>
                        </select>
                    </div>
                </div>

                <!-- Lista Vertical de Imóveis -->
                <div class="space-y-6">
                    <!-- Imóvel 1 -->
                    <!-- Adicionado flex-col para mobile e md:flex-row para telas maiores -->
                    <div
                        class="property-card card flex flex-col md:flex-row bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                        <figure class="w-full md:w-80 shrink-0 h-48 md:h-auto"> <!-- Ajustado altura para mobile -->
                            <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                                alt="Casa moderna" class="h-full w-full object-cover rounded-t-xl md:rounded-l-xl md:rounded-t-none">
                            <span class="badge badge-primary absolute top-4 right-4">Destaque</span>
                        </figure>
                        <div class="card-body">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div>
                                    <h2 class="card-title">Casa Moderna no Centro</h2>
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span>Centro, São Paulo</span>
                                    </div>
                                </div>
                                <div class="text-2xl font-bold text-primary mt-2 sm:mt-0">R$ 850.000</div>
                            </div>

                            <div class="flex flex-wrap gap-4 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-bed mr-2 text-primary"></i>
                                    <span>3 Quartos</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-bath mr-2 text-primary"></i>
                                    <span>2 Banheiros</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-ruler-combined mr-2 text-primary"></i>
                                    <span>180 m²</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-car mr-2 text-primary"></i>
                                    <span>2 Vagas</span>
                                </div>
                            </div>

                            <p class="mb-4 line-clamp-2">Esta casa moderna no coração da cidade oferece conforto e
                                sofisticação. Com acabamentos de alta qualidade e uma localização privilegiada, é a
                                escolha perfeita para quem busca praticidade e estilo de vida urbano.</p>

                            <div class="card-actions flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div class="flex gap-1 text-yellow-400 mb-2 sm:mb-0">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span class="text-gray-500 ml-1">(12)</span>
                                </div>
                                <a href="detalhes.html" class="btn btn-primary w-full sm:w-auto">
                                    <i class="fas fa-eye mr-2"></i> Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Imóvel 2 -->
                    <div
                        class="property-card card flex flex-col md:flex-row bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                        <figure class="w-full md:w-80 shrink-0 h-48 md:h-auto">
                            <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                                alt="Apartamento luxuoso" class="h-full w-full object-cover rounded-t-xl md:rounded-l-xl md:rounded-t-none">
                        </figure>
                        <div class="card-body">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div>
                                    <h2 class="card-title">Apartamento Luxuoso</h2>
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span>Zona Sul, Rio de Janeiro</span>
                                    </div>
                                </div>
                                <div class="text-2xl font-bold text-primary mt-2 sm:mt-0">R$ 1.250.000</div>
                            </div>

                            <div class="flex flex-wrap gap-4 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-bed mr-2 text-primary"></i>
                                    <span>4 Quartos</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-bath mr-2 text-primary"></i>
                                    <span>3 Banheiros</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-ruler-combined mr-2 text-primary"></i>
                                    <span>220 m²</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-car mr-2 text-primary"></i>
                                    <span>2 Vagas</span>
                                </div>
                            </div>

                            <p class="mb-4 line-clamp-2">Apartamento de alto padrão com vista para o mar, acabamentos
                                em mármore, cozinha gourmet equipada, sacada ampla e lazer completo com piscina, sauna e
                                academia.</p>

                            <div class="card-actions flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div class="flex gap-1 text-yellow-400 mb-2 sm:mb-0">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <span class="text-gray-500 ml-1">(8)</span>
                                </div>
                                <a href="detalhes.html" class="btn btn-primary w-full sm:w-auto">
                                    <i class="fas fa-eye mr-2"></i> Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Imóvel 3 -->
                    <div
                        class="property-card card flex flex-col md:flex-row bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                        <figure class="w-full md:w-80 shrink-0 h-48 md:h-auto">
                            <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                                alt="Casa com piscina" class="h-full w-full object-cover rounded-t-xl md:rounded-l-xl md:rounded-t-none">
                            <span class="badge badge-secondary absolute top-4 right-4">Novo</span>
                        </figure>
                        <div class="card-body">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div>
                                    <h2 class="card-title">Casa com Piscina</h2>
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        <span>Zona Oeste, Belo Horizonte</span>
                                    </div>
                                </div>
                                <div class="text-2xl font-bold text-primary mt-2 sm:mt-0">R$ 2.500.000</div>
                            </div>

                            <div class="flex flex-wrap gap-4 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-bed mr-2 text-primary"></i>
                                    <span>5 Quartos</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-bath mr-2 text-primary"></i>
                                    <span>4 Banheiros</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-ruler-combined mr-2 text-primary"></i>
                                    <span>350 m²</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-car mr-2 text-primary"></i>
                                    <span>4 Vagas</span>
                                </div>
                            </div>

                            <p class="mb-4 line-clamp-2">Mansão moderna com piscina, área gourmet, home theater, jardim
                                vertical e amplos espaços de convivência. Projeto arquitetônico premiado com integração
                                perfeita entre áreas internas e externas.</p>

                            <div class="card-actions flex-col sm:flex-row justify-between items-start sm:items-center">
                                <div class="flex gap-1 text-yellow-400 mb-2 sm:mb-0">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span class="text-gray-500 ml-1">(15)</span>
                                </div>
                                <a href="detalhes.html" class="btn btn-primary w-full sm:w-auto">
                                    <i class="fas fa-eye mr-2"></i> Ver Detalhes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Paginação -->
                <div class="join grid grid-cols-2 md:flex justify-center mt-10">
                    <button class="join-item btn btn-outline">Anterior</button>
                    <button class="join-item btn btn-active">1</button>
                    <button class="join-item btn btn-outline">2</button>
                    <button class="join-item btn btn-outline">3</button>
                    <button class="join-item btn btn-outline">4</button>
                    <button class="join-item btn btn-outline">Próxima</button>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts adicionais -->
    <script>
        // document.addEventListener('alpine:init', () => {
        //     Alpine.store('properties', {
        //         featured: [{
        //                 id: 1,
        //                 title: 'Casa Moderna no Centro',
        //                 location: 'Centro, São Paulo',
        //                 bedrooms: 3,
        //                 bathrooms: 2,
        //                 area: 180,
        //                 price: 850000,
        //                 image: 'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        //                 featured: true
        //             },
        //             // Outros imóveis...
        //         ],

        //         recent: [{
        //                 id: 4,
        //                 title: 'Apartamento Compacto',
        //                 location: 'Centro, Curitiba',
        //                 bedrooms: 2,
        //                 bathrooms: 1,
        //                 area: 65,
        //                 price: 320000,
        //                 image: 'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
        //                 new: true
        //             },
        //             // Outros imóveis recentes...
        //         ]
        //     });
        // });

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
