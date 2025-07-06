<!DOCTYPE html>
<html lang="pt-BR" x-data="{ darkMode: false, activeImage: 0, showContactForm: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Casa Moderna no Centro - Imobiliária</title>
    <!-- Tailwind CSS + DaisyUI -->
    {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @else --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> --}}

    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    </style>
</head>

<body class="bg-base-100 text-neutral">
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

                <!-- <button @click="darkMode = !darkMode" class="btn btn-ghost btn-circle ml-2">
                    <i x-show="!darkMode" class="fas fa-moon"></i>
                    <i x-show="darkMode" class="fas fa-sun"></i>
                </button> -->

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

    <!-- Conteúdo Principal -->
    <main class="container mx-auto px-4 py-8">
        <!-- Caminho de Navegação -->
        <div class="text-sm breadcrumbs mb-6">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Imóveis</a></li>
                <li><a href="#">São Paulo</a></li>
                <li class="font-semibold">Casa Moderna no Centro</li>
            </ul>
        </div>

        <!-- Galeria de Imagens -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-8">
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
                <button @click="activeImage = 0" class="rounded-xl overflow-hidden hover:opacity-90 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Fachada" class="w-full h-full object-cover">
                </button>
                <button @click="activeImage = 1" class="rounded-xl overflow-hidden hover:opacity-90 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Sala de estar" class="w-full h-full object-cover">
                </button>
                <button @click="activeImage = 2" class="rounded-xl overflow-hidden hover:opacity-90 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1580216643062-cf460548a66a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Cozinha" class="w-full h-full object-cover">
                </button>
                <button @click="activeImage = 3" class="rounded-xl overflow-hidden hover:opacity-90 transition-opacity">
                    <img src="https://images.unsplash.com/photo-1580216643062-cf460548a66a?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80"
                        alt="Quarto" class="w-full h-full object-cover">
                </button>
            </div>
        </div>

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
