<!DOCTYPE html>
{{-- <html lang="pt-BR" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }"> --}}
<html lang="pt-BR" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imobiliária - Encontre seu imóvel dos sonhos</title>
    <meta name="description"
        content="Encontre o imóvel perfeito para você com a nossa imobiliária. Temos apartamentos, casas, terrenos e mais.">

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
        /* :root {
            --primary: #3b82f6;
            --secondary: #10b981;
            --accent: #f59e0b;
            --neutral: #1f2937;
            --base-100: #ffffff;
        } */

        /* .dark {
            --primary: #60a5fa;
            --secondary: #34d399;
            --accent: #fbbf24;
            --neutral: #d1d5db;
            --base-100: #1f2937;
        } */

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
    <!-- Header/Navbar -->
    {{-- <header class="sticky top-0 z-50 shadow-md bg-base-100">
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
    </header> --}}

    {{-- Opção 1 --}}
    <header x-data="{ isScrolled: false }" @scroll.window="isScrolled = window.scrollY > 50"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
        :class="isScrolled ? 'bg-white shadow-md dark:bg-neutral' : 'bg-transparent'">

        <div class="container mx-auto px-4">
            <div class="navbar">
                <div class="flex-1">
                    <a href="/" class="btn btn-ghost px-0">
                        <div class="flex items-center">
                            <div class="w-10 mr-2">
                                <img src="https://placehold.co/400x400/3b82f6/white?text=IM" alt="Logo"
                                    class="w-full rounded-lg">
                            </div>
                            <span class="text-xl font-bold text-primary">Imobiliária<span
                                    class="text-secondary">Premium</span></span>
                        </div>
                    </a>
                </div>

                <div class="flex-none hidden lg:flex items-center gap-2">
                    <nav class="flex items-center">
                        <ul class="menu menu-horizontal px-1 gap-1">
                            <li><a href="#" class="font-medium hover:text-primary">Início</a></li>
                            <li><a href="#destaques" class="font-medium hover:text-primary">Destaques</a></li>
                            <li><a href="#sobre" class="font-medium hover:text-primary">Sobre</a></li>
                            <li><a href="#contato" class="font-medium hover:text-primary">Contato</a></li>
                            @if(auth()->check())
                                <li><a href="/admin" class="font-medium hover:text-primary">Dashboard</a></li>
                            @else
                                <li><a href="/login" class="font-medium hover:text-primary">Login</a></li>
                            @endif
                        </ul>
                    </nav>

                    <div class="divider divider-horizontal h-6 mx-2"></div>

                    <div class="flex items-center gap-2 mr-4">
                        <a href="#" class="btn btn-ghost btn-circle btn-sm text-gray-600 hover:text-primary">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="btn btn-ghost btn-circle btn-sm text-gray-600 hover:text-primary">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-ghost btn-circle btn-sm text-gray-600 hover:text-primary">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>

                    <a href="https://wa.me/5511999999999" class="btn btn-primary btn-sm md:btn-md gap-2">
                        <i class="fab fa-whatsapp"></i>
                        <span class="hidden sm:inline">(11) 99999-9999</span>
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
                    <a href="#" class="btn btn-ghost btn-circle">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-ghost btn-circle">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-ghost btn-circle">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>

                <a href="https://wa.me/5511999999999" class="btn btn-primary gap-2">
                    <i class="fab fa-whatsapp"></i>
                    (11) 99999-9999
                </a>
            </div>
        </div>
    </header>

    {{-- Opção 2 --}}
    {{-- <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-sm shadow-sm dark:bg-neutral/90">
        <div class="container mx-auto px-4">
            <div class="navbar">
                <div class="flex-1">
                    <a href="#" class="flex items-center gap-2">
                        <div class="w-10 p-2 bg-primary text-white rounded-lg flex items-center justify-center">
                            <i class="fas fa-home text-xl"></i>
                        </div>
                        <span class="text-xl font-bold">Imobiliária<span class="text-primary">Plus</span></span>
                    </a>
                </div>

                <div class="hidden lg:flex items-center gap-6">
                    <nav>
                        <ul class="menu menu-horizontal gap-1">
                            <li>
                                <details>
                                    <summary class="font-medium">Comprar</summary>
                                    <ul class="p-2 bg-base-100 rounded-box shadow-lg">
                                        <li><a href="#">Casas</a></li>
                                        <li><a href="#">Apartamentos</a></li>
                                        <li><a href="#">Terrenos</a></li>
                                    </ul>
                                </details>
                            </li>
                            <li><a href="#" class="font-medium">Vender</a></li>
                            <li><a href="#" class="font-medium">Alugar</a></li>
                            <li><a href="#" class="font-medium">Sobre</a></li>
                            <li><a href="#" class="font-medium">Contato</a></li>
                        </ul>
                    </nav>

                    <div class="indicator">
                        <span class="indicator-item badge badge-primary badge-xs"></span>
                        <a href="https://wa.me/5511999999999" class="btn btn-primary btn-sm gap-2">
                            <i class="fab fa-whatsapp"></i>
                            <span class="hidden md:inline">Fale Conosco</span>
                        </a>
                    </div>
                </div>

                <div class="flex-none lg:hidden">
                    <label for="mobile-drawer" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>
            </div>
        </div>

        <input type="checkbox" id="mobile-drawer" class="drawer-toggle">
        <div class="drawer-side z-50">
            <label for="mobile-drawer" class="drawer-overlay"></label>
            <div class="menu p-4 w-80 h-full bg-base-100 text-base-content">
                <div class="flex items-center justify-between mb-8">
                    <a href="#" class="text-xl font-bold">Imobiliária<span class="text-primary">Plus</span></a>
                    <label for="mobile-drawer" class="btn btn-ghost btn-circle">
                        <i class="fas fa-times"></i>
                    </label>
                </div>

                <ul class="space-y-2">
                    <li><a href="#" class="font-medium">Comprar</a></li>
                    <li><a href="#" class="font-medium">Vender</a></li>
                    <li><a href="#" class="font-medium">Alugar</a></li>
                    <li><a href="#" class="font-medium">Sobre</a></li>
                    <li><a href="#" class="font-medium">Contato</a></li>
                </ul>

                <div class="divider my-4"></div>

                <a href="https://wa.me/5511999999999" class="btn btn-primary gap-2 mt-4">
                    <i class="fab fa-whatsapp"></i>
                    Fale Conosco
                </a>
            </div>
        </div>
    </header> --}}

    {{-- Opção 3 --}}
    {{-- <header class="sticky top-0 z-50 border-b border-gray-100 bg-white/80 backdrop-blur-sm dark:bg-neutral/80">
        <div class="container mx-auto px-4">
            <div class="navbar px-0">
                <div class="flex-1">
                    <a href="#" class="text-2xl font-bold">
                        <span class="text-primary">I</span>MOB
                    </a>
                </div>

                <div class="hidden md:flex items-center gap-8">
                    <nav>
                        <ul class="flex gap-6">
                            <li><a href="#" class="font-medium hover:text-primary transition-colors">Início</a>
                            </li>
                            <li><a href="#" class="font-medium hover:text-primary transition-colors">Imóveis</a>
                            </li>
                            <li><a href="#" class="font-medium hover:text-primary transition-colors">Serviços</a>
                            </li>
                            <li><a href="#" class="font-medium hover:text-primary transition-colors">Sobre</a>
                            </li>
                        </ul>
                    </nav>

                    <div class="flex items-center gap-4">
                        <a href="tel:+5511999999999" class="flex items-center gap-2 text-sm font-medium">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                <i class="fas fa-phone-alt text-primary"></i>
                            </div>
                            <span class="hidden lg:inline">(11) 99999-9999</span>
                        </a>

                        <a href="https://wa.me/5511999999999" class="btn btn-primary btn-sm gap-2">
                            <i class="fab fa-whatsapp"></i>
                            WhatsApp
                        </a>
                    </div>
                </div>

                <div class="flex-none md:hidden">
                    <label for="mobile-nav" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>
            </div>
        </div>

        <input type="checkbox" id="mobile-nav" class="drawer-toggle">
        <div class="drawer-side z-50">
            <label for="mobile-nav" class="drawer-overlay"></label>
            <div class="menu p-4 w-80 h-full bg-base-100 text-base-content">
                <div class="flex items-center justify-between mb-8">
                    <a href="#" class="text-2xl font-bold">
                        <span class="text-primary">I</span>MOB
                    </a>
                    <label for="mobile-nav" class="btn btn-ghost btn-circle">
                        <i class="fas fa-times"></i>
                    </label>
                </div>

                <ul class="space-y-4">
                    <li><a href="#" class="font-medium text-lg">Início</a></li>
                    <li><a href="#" class="font-medium text-lg">Imóveis</a></li>
                    <li><a href="#" class="font-medium text-lg">Serviços</a></li>
                    <li><a href="#" class="font-medium text-lg">Sobre</a></li>
                </ul>

                <div class="divider my-6"></div>

                <div class="space-y-4">
                    <a href="tel:+5511999999999" class="flex items-center gap-4 font-medium text-lg">
                        <i class="fas fa-phone-alt text-primary"></i>
                        (11) 99999-9999
                    </a>
                    <a href="https://wa.me/5511999999999" class="btn btn-primary gap-2">
                        <i class="fab fa-whatsapp"></i>
                        WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </header> --}}

    <!-- Hero com Busca Avançada -->
    {{-- <section style="background-image: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center; background-repeat: no-repeat;" class="relative py-20 bg-base-200 bg-[url('https://images.unsplash.com/photo-1486312338219-fe70aa2a6f43?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80')] bg-cover bg-center bg-no-repeat"> --}}
    <section class="relative py-20 bg-linear-to-t from-green-300 to-blue-300 ">
        <div class="container mx-auto px-4 mt-18">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6">
                        Encontre o imóvel <span class="text-primary">perfeito</span>
                    </h1>
                    <p class="text-xl mb-8">
                        Mais de 1.000 propriedades disponíveis com as melhores condições do mercado
                    </p>
                    <div class="flex items-center gap-4">
                        <div class="flex -space-x-2">
                            <div class="avatar">
                                <div class="w-12 h-12 rounded-full border-2 border-base-100">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" />
                                </div>
                            </div>
                            <div class="avatar">
                                <div class="w-12 h-12 rounded-full border-2 border-base-100">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" />
                                </div>
                            </div>
                            <div class="avatar">
                                <div class="w-12 h-12 rounded-full border-2 border-base-100">
                                    <img src="https://randomuser.me/api/portraits/women/68.jpg" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold">+100 clientes satisfeitos</div>
                            <div class="flex text-yellow-400">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:w-1/2 w-full">
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h2 class="card-title mb-4">O que você está buscando?</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <select class="select select-bordered">
                                    <option disabled selected>Tipo de Imóvel</option>
                                    <option>Casa</option>
                                    <option>Apartamento</option>
                                    <option>Terreno</option>
                                    <option>Comercial</option>
                                </select>
                                <select class="select select-bordered">
                                    <option disabled selected>Localização</option>
                                    <option>São Paulo</option>
                                    <option>Rio de Janeiro</option>
                                    <option>Belo Horizonte</option>
                                </select>
                                <select class="select select-bordered">
                                    <option disabled selected>Faixa de Preço</option>
                                    <option>Até R$ 300.000</option>
                                    <option>R$ 300-600 mil</option>
                                    <option>R$ 600-1 milhão</option>
                                </select>
                                <select class="select select-bordered">
                                    <option disabled selected>Quartos</option>
                                    <option>1+</option>
                                    <option>2+</option>
                                    <option>3+</option>
                                </select>
                            </div>
                            <div class="card-actions justify-end mt-4">
                                <button class="btn btn-primary w-full">
                                    <i class="fas fa-search mr-2"></i> Buscar Imóveis
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- 1. Banner Hero com Filtros Sobrepostos -->
    {{-- <section class="hero relative min-h-[80vh] h-">
        <div class="hero-overlay bg-black/50 absolute inset-0 z-0"></div>
        <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
            alt="Casa de luxo" class="absolute inset-0 w-full h-full object-cover z-0">

        <div class="hero-content text-center text-white relative z-10 pt-32 pb-64 animate-fade-in">
            <div class="max-w-4xl">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Encontre seu imóvel dos sonhos</h1>
                <p class="text-xl md:text-2xl mb-8">Temos as melhores opções de imóveis para você e sua família</p>
                <a href="#contato" class="btn btn-primary btn-lg">Fale conosco</a>
            </div>
        </div>
    </section> --}}

    <!-- 2. Filtros de Busca Sobrepostos -->
    {{-- <div class="container mx-auto px-4 relative z-20 -mt-20">
        <div class="card bg-base-100 shadow-2xl">
            <div class="card-body p-6 md:p-8">
                <h2 class="card-title text-2xl md:text-3xl mb-6">Encontre o imóvel perfeito</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Tipo de Imóvel</span>
                        </label>
                        <select class="select select-bordered">
                            <option disabled selected>Selecione</option>
                            <option>Casa</option>
                            <option>Apartamento</option>
                            <option>Terreno</option>
                            <option>Comercial</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Localização</span>
                        </label>
                        <select class="select select-bordered">
                            <option disabled selected>Selecione</option>
                            <option>Centro</option>
                            <option>Zona Norte</option>
                            <option>Zona Sul</option>
                            <option>Zona Leste</option>
                            <option>Zona Oeste</option>
                        </select>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Faixa de Preço</span>
                        </label>
                        <select class="select select-bordered">
                            <option disabled selected>Selecione</option>
                            <option>Até R$ 200.000</option>
                            <option>R$ 200.000 - R$ 500.000</option>
                            <option>R$ 500.000 - R$ 1.000.000</option>
                            <option>Acima de R$ 1.000.000</option>
                        </select>
                    </div>

                    <div class="form-control flex items-end">
                        <button class="btn btn-primary w-full h-14">Buscar Imóveis</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- 3. Imóveis em Destaque -->
    <section id="destaques" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Imóveis em Destaque</h2>
                <p class="text-lg max-w-2xl mx-auto">Confira nossas melhores opções selecionadas especialmente para
                    você
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Imóvel 1 -->
                <div class="property-card card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 animate-fade-in"
                    style="animation-delay: 0.1s">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Casa moderna" class="h-64 w-full object-cover">
                        <span class="badge badge-primary absolute top-4 right-4">Destaque</span>
                    </figure>
                    <div class="card-body">
                        <h3 class="card-title">Casa Moderna no Centro</h3>
                        <div class="flex items-center text-yellow-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Centro, São Paulo</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
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
                                <span>180m²</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-primary">R$ 850.000</span>
                            <button class="btn btn-sm btn-secondary">Detalhes</button>
                        </div>
                    </div>
                </div>

                <!-- Imóvel 2 -->
                <div class="property-card card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 animate-fade-in"
                    style="animation-delay: 0.2s">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Apartamento luxuoso" class="h-64 w-full object-cover">
                        <span class="badge badge-primary absolute top-4 right-4">Destaque</span>
                    </figure>
                    <div class="card-body">
                        <h3 class="card-title">Apartamento Luxuoso</h3>
                        <div class="flex items-center text-yellow-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Zona Sul, Rio de Janeiro</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
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
                                <span>220m²</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-primary">R$ 1.250.000</span>
                            <button class="btn btn-sm btn-secondary">Detalhes</button>
                        </div>
                    </div>
                </div>

                <!-- Imóvel 3 -->
                <div class="property-card card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 animate-fade-in"
                    style="animation-delay: 0.3s">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Casa com piscina" class="h-64 w-full object-cover">
                        <span class="badge badge-primary absolute top-4 right-4">Destaque</span>
                    </figure>
                    <div class="card-body">
                        <h3 class="card-title">Casa com Piscina</h3>
                        <div class="flex items-center text-yellow-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Zona Oeste, Belo Horizonte</span>
                        </div>
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <i class="fas fa-bed mr-1"></i>
                                <span>5 Quartos</span>
                            </div>
                            <div>
                                <i class="fas fa-bath mr-1"></i>
                                <span>4 Banheiros</span>
                            </div>
                            <div>
                                <i class="fas fa-ruler-combined mr-1"></i>
                                <span>350m²</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-primary">R$ 2.500.000</span>
                            <button class="btn btn-sm btn-secondary">Detalhes</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <button class="btn btn-outline btn-primary">Ver mais imóveis</button>
            </div>
        </div>
    </section>

    <!-- 4. Sobre a Imobiliária -->
    <section id="sobre" class="py-16 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2 animate-fade-in">
                    <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                        alt="Equipe da imobiliária" class="rounded-lg shadow-xl w-full h-auto">
                </div>
                <div class="lg:w-1/2 animate-fade-in" style="animation-delay: 0.2s">
                    <h2 class="text-3xl font-bold mb-6">Sobre Nossa Imobiliária</h2>
                    <p class="mb-4 text-lg">Somos uma imobiliária com mais de 20 anos de experiência no mercado,
                        ajudando famílias a encontrar o lar perfeito.</p>
                    <p class="mb-6">Nossa equipe de corretores altamente qualificados está pronta para oferecer o
                        melhor
                        atendimento e encontrar a solução ideal para suas necessidades imobiliárias.</p>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="text-primary mr-4 mt-1">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Atendimento Personalizado</h4>
                                <p class="text-sm">Entendemos suas necessidades e oferecemos soluções sob medida.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="text-primary mr-4 mt-1">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Transparência</h4>
                                <p class="text-sm">Processos claros e sem surpresas desagradáveis.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="text-primary mr-4 mt-1">
                                <i class="fas fa-check-circle text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Variedade de Imóveis</h4>
                                <p class="text-sm">Ampla seleção de propriedades para todos os gostos e orçamentos.</p>
                            </div>
                        </div>
                    </div>

                    <button class="btn btn-primary mt-8">Conheça nossa equipe</button>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Imóveis Recentes -->
    <section id="recentes" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Imóveis Recentes</h2>
                <p class="text-lg max-w-2xl mx-auto">Confira nossas últimas adições ao portfólio</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Imóvel 1 -->
                <div class="property-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300 animate-fade-in"
                    style="animation-delay: 0.1s">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Apartamento compacto" class="h-48 w-full object-cover">
                        <span class="badge badge-secondary absolute top-4 right-4">Novo</span>
                    </figure>
                    <div class="card-body p-4">
                        <h3 class="card-title text-lg">Apartamento Compacto</h3>
                        <div class="flex items-center text-sm mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Centro, Curitiba</span>
                        </div>
                        <div class="flex justify-between items-center text-sm mb-3">
                            <div>
                                <i class="fas fa-bed mr-1"></i>
                                <span>2 Quartos</span>
                            </div>
                            <div>
                                <i class="fas fa-bath mr-1"></i>
                                <span>1 Banheiro</span>
                            </div>
                            <div>
                                <i class="fas fa-ruler-combined mr-1"></i>
                                <span>65m²</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-primary">R$ 320.000</span>
                            <button class="btn btn-xs btn-outline btn-primary">Detalhes</button>
                        </div>
                    </div>
                </div>

                <!-- Imóvel 2 -->
                <div class="property-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300 animate-fade-in"
                    style="animation-delay: 0.2s">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1600607687920-4e2a09cf159d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Casa térrea" class="h-48 w-full object-cover">
                        <span class="badge badge-secondary absolute top-4 right-4">Novo</span>
                    </figure>
                    <div class="card-body p-4">
                        <h3 class="card-title text-lg">Casa Térrea</h3>
                        <div class="flex items-center text-sm mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Zona Leste, Porto Alegre</span>
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
                                <span>120m²</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-primary">R$ 450.000</span>
                            <button class="btn btn-xs btn-outline btn-primary">Detalhes</button>
                        </div>
                    </div>
                </div>

                <!-- Imóvel 3 -->
                <div class="property-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300 animate-fade-in"
                    style="animation-delay: 0.3s">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1605146769289-440113cc3d00?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Cobertura" class="h-48 w-full object-cover">
                        <span class="badge badge-secondary absolute top-4 right-4">Novo</span>
                    </figure>
                    <div class="card-body p-4">
                        <h3 class="card-title text-lg">Cobertura Duplex</h3>
                        <div class="flex items-center text-sm mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Zona Sul, Florianópolis</span>
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
                                <span>280m²</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-primary">R$ 1.800.000</span>
                            <button class="btn btn-xs btn-outline btn-primary">Detalhes</button>
                        </div>
                    </div>
                </div>

                <!-- Imóvel 4 -->
                <div class="property-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300 animate-fade-in"
                    style="animation-delay: 0.4s">
                    <figure>
                        <img src="https://images.unsplash.com/photo-1600566752225-53769df8b5e5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Terreno residencial" class="h-48 w-full object-cover">
                        <span class="badge badge-secondary absolute top-4 right-4">Novo</span>
                    </figure>
                    <div class="card-body p-4">
                        <h3 class="card-title text-lg">Terreno Residencial</h3>
                        <div class="flex items-center text-sm mb-2">
                            <i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                            <span>Bairro Nobre, Brasília</span>
                        </div>
                        <div class="flex justify-between items-center text-sm mb-3">
                            <div>
                                <i class="fas fa-ruler-combined mr-1"></i>
                                <span>500m²</span>
                            </div>
                            <div>
                                <i class="fas fa-car mr-1"></i>
                                <span>2 Vagas</span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-primary">R$ 600.000</span>
                            <button class="btn btn-xs btn-outline btn-primary">Detalhes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero com Estatísticas -->
    <section class="relative py-20 bg-primary text-primary-content">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                A melhor experiência em <span class="text-secondary">negócios imobiliários</span>
            </h1>
            <p class="text-xl mb-12 max-w-3xl mx-auto">
                Conectamos você aos melhores imóveis com transparência e segurança
            </p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 max-w-5xl mx-auto">
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">1.200+</div>
                    <div class="opacity-80">Imóveis disponíveis</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">25+</div>
                    <div class="opacity-80">Bairros atendidos</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">98%</div>
                    <div class="opacity-80">Satisfação dos clientes</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold mb-2">15+</div>
                    <div class="opacity-80">Anos de experiência</div>
                </div>
            </div>

            <div class="mt-12 flex flex-col sm:flex-row justify-center gap-4">
                <a href="#destaques" class="btn btn-secondary btn-lg">
                    <i class="fas fa-home mr-2"></i> Ver Imóveis
                </a>
                <a href="#contato" class="btn btn-outline btn-lg btn-primary-content">
                    <i class="fas fa-phone-alt mr-2"></i> Falar com Corretor
                </a>
            </div>
        </div>
    </section>

    <!-- 6. CTA Contato -->
    <section id="contato" class="py-16 bg-primary text-primary-content">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Pronto para encontrar seu imóvel ideal?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Nossa equipe está pronta para te ajudar em todas as etapas do
                processo.</p>

            <div class="flex flex-col md:flex-row justify-center gap-4 max-w-2xl mx-auto">
                <a href="tel:+5511999999999" class="btn btn-secondary btn-lg">
                    <i class="fas fa-phone-alt mr-2"></i>
                    (11) 99999-9999
                </a>
                <a href="mailto:contato@imobiliaria.com" class="btn btn-accent btn-lg">
                    <i class="fas fa-envelope mr-2"></i>
                    Enviar Mensagem
                </a>
            </div>
        </div>
    </section>

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

    <!-- Botão Flutuante do WhatsApp -->
    {{-- <div class="fixed bottom-6 left-6 z-50">
        <span class="absolute -top-2 -right-2 flex h-6 w-6 animate-pulse">
            <span class="absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
            <span
                class="relative inline-flex rounded-full h-6 w-6 bg-green-800 items-center justify-center text-white font-bold text-xs">1</span>
        </span>

            class="btn btn-circle bg-green-500 text-white btn-lg shadow-xl hover:shadow-2xl transition-all duration-300 group"
            aria-label="Fale conosco no WhatsApp">

            <div class="relative">
                <i class="fab fa-whatsapp text-2xl group-hover:scale-110 transition-transform"></i>

                <span class="absolute inset-0 flex items-center justify-center">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-0 group-hover:opacity-40 transition-opacity duration-300"></span>
                </span>
            </div>
        </a>

        <div
            class="absolute right-16 bottom-2 hidden md:block opacity-0 group-hover:opacity-100 transition-opacity duration-300">
            <div class="bg-neutral text-neutral-content px-3 py-2 rounded-lg whitespace-nowrap shadow-md">
                Fale conosco agora!
                <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1 w-2 h-2 bg-neutral rotate-45">
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Versão Simplificada -->
    {{-- <div class="fixed bottom-6 left-6 z-50">
    <a href="https://wa.me/5511999999999" 
       target="_blank"
       class="btn btn-circle btn-primary btn-lg shadow-lg hover:scale-105 hover:shadow-xl transition-all" 
       class="btn btn-circle bg-green-500 text-white btn-lg shadow-lg hover:scale-105 hover:shadow-xl transition-all"
       aria-label="WhatsApp">
       <i class="fab fa-whatsapp text-2xl"></i>
    </a>
</div> --}}

    <!-- Versão com Chat Expansível -->
    <div x-data="{ open: false }" class="fixed bottom-6 right-6 z-50">
        <!-- Botão Principal -->
        <button @click="open = !open" class="btn btn-circle bg-green-500 text-white btn-xl shadow-xl relative">
            <i class="fab fa-whatsapp text-2xl"></i>
            <span x-show="!open"
                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
        </button>

        <!-- Chat Box -->
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
