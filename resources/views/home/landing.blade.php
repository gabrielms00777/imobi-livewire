<!DOCTYPE html>
<html lang="pt-BR" x-data="{ darkMode: false, activeTab: 'monthly', showModal: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ImobiSystem - Solução Completa para Imobiliárias</title>
    <meta name="description" content="Sistema completo para gerenciamento de imóveis e sites para corretores e imobiliárias. Tenha seu site profissional com painel administrativo integrado.">
    
    <!-- Tailwind CSS + DaisyUI -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine JS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            scroll-behavior: smooth;
        }
        
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .feature-card {
            transition: all 0.3s ease;
        }
        
        .testimonial-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
        }
    </style>
</head>
<body class="bg-base-100 text-neutral">
    <!-- Header -->
    <header x-data="{ isScrolled: false }" 
            @scroll.window="isScrolled = window.scrollY > 50"
            class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
            :class="isScrolled ? 'bg-white shadow-md dark:bg-neutral' : 'bg-transparent'">
        <div class="container mx-auto px-4">
            <div class="navbar">
                <div class="flex-1">
                    <a href="#" class="btn btn-ghost px-0">
                        <div class="flex items-center">
                            <div class="w-10 mr-2">
                                <img src="https://placehold.co/400x400/3b82f6/white?text=IS" alt="Logo" class="w-full rounded-lg">
                            </div>
                            <span class="text-xl font-bold text-primary">Imobi<span class="text-secondary">System</span></span>
                        </div>
                    </a>
                </div>
                
                <div class="hidden lg:flex items-center gap-6">
                    <nav>
                        <ul class="menu menu-horizontal px-1 gap-1">
                            <li><a href="#features" class="font-medium hover:text-primary">Funcionalidades</a></li>
                            <li><a href="#pricing" class="font-medium hover:text-primary">Planos</a></li>
                            <li><a href="#testimonials" class="font-medium hover:text-primary">Depoimentos</a></li>
                            <li><a href="#faq" class="font-medium hover:text-primary">FAQ</a></li>
                        </ul>
                    </nav>
                    
                    <a href="#cta" class="btn btn-primary btn-sm md:btn-md gap-2">
                        <i class="fas fa-rocket mr-2"></i> Teste Grátis
                    </a>
                </div>
                
                <div class="flex-none lg:hidden">
                    <label for="mobile-menu" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </label>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <input type="checkbox" id="mobile-menu" class="drawer-toggle">
        <div class="drawer-side z-50">
            <label for="mobile-menu" class="drawer-overlay"></label>
            <div class="menu p-4 w-80 h-full bg-base-100 text-base-content">
                <div class="flex items-center justify-between mb-6">
                    <a href="#" class="text-xl font-bold text-primary">Imobi<span class="text-secondary">System</span></a>
                    <label for="mobile-menu" class="btn btn-ghost btn-circle">
                        <i class="fas fa-times"></i>
                    </label>
                </div>
                
                <ul class="space-y-2">
                    <li><a href="#features" class="font-medium">Funcionalidades</a></li>
                    <li><a href="#pricing" class="font-medium">Planos</a></li>
                    <li><a href="#testimonials" class="font-medium">Depoimentos</a></li>
                    <li><a href="#faq" class="font-medium">FAQ</a></li>
                </ul>
                
                <div class="mt-6">
                    <a href="#cta" class="btn btn-primary w-full gap-2">
                        <i class="fas fa-rocket"></i> Teste Grátis
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-32 pb-20">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <div class="lg:w-1/2">
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                        <span class="text-primary">Sistema Completo</span> para sua Imobiliária ou Corretor
                    </h1>
                    <p class="text-xl mb-8">
                        Tenha um site profissional com painel administrativo completo para gerenciar seus imóveis e atrair mais clientes.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="#cta" class="btn btn-primary btn-lg">
                            <i class="fas fa-play-circle mr-2"></i> Teste Grátis
                        </a>
                        <a href="#features" class="btn btn-outline btn-lg">
                            <i class="fas fa-info-circle mr-2"></i> Saiba Mais
                        </a>
                    </div>
                    
                    <div class="flex items-center gap-4 mt-8">
                        <div class="flex -space-x-2">
                            <div class="avatar">
                                <div class="w-10 h-10 rounded-full border-2 border-base-100">
                                    <img src="https://randomuser.me/api/portraits/women/44.jpg" />
                                </div>
                            </div>
                            <div class="avatar">
                                <div class="w-10 h-10 rounded-full border-2 border-base-100">
                                    <img src="https://randomuser.me/api/portraits/men/32.jpg" />
                                </div>
                            </div>
                            <div class="avatar">
                                <div class="w-10 h-10 rounded-full border-2 border-base-100">
                                    <img src="https://randomuser.me/api/portraits/women/68.jpg" />
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="font-bold">+200 clientes satisfeitos</div>
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
                
                <div class="lg:w-1/2">
                    <div class="card bg-base-100 shadow-xl">
                        <figure>
                            <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
                                 alt="Painel administrativo" class="w-full h-auto rounded-t-lg">
                        </figure>
                        <div class="card-body">
                            <h3 class="card-title">Painel Administrativo</h3>
                            <p>Gerencie seus imóveis com facilidade e tenha total controle sobre seu site.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Logos Section -->
    <section class="py-12 bg-base-200">
        <div class="container mx-auto px-4">
            <p class="text-center mb-8 text-lg">Utilizado por imobiliárias e corretores de todo o país</p>
            <div class="flex flex-wrap justify-center gap-8 md:gap-16 items-center">
                <img src="https://placehold.co/160x80/3b82f6/white?text=Imobiliária+A" alt="Logo cliente" class="h-10 opacity-80 hover:opacity-100 transition-opacity">
                <img src="https://placehold.co/160x80/10b981/white?text=Corretor+X" alt="Logo cliente" class="h-10 opacity-80 hover:opacity-100 transition-opacity">
                <img src="https://placehold.co/160x80/f59e0b/white?text=Imóveis+Top" alt="Logo cliente" class="h-10 opacity-80 hover:opacity-100 transition-opacity">
                <img src="https://placehold.co/160x80/3b82f6/white?text=Excelência" alt="Logo cliente" class="h-10 opacity-80 hover:opacity-100 transition-opacity">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Funcionalidades Completas</h2>
                <p class="text-lg max-w-2xl mx-auto">Tudo o que você precisa para gerenciar seus imóveis e atrair mais clientes</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <figure class="px-6 pt-6">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <i class="fas fa-home text-2xl"></i>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Site Profissional</h3>
                        <p>Tenha um site moderno e responsivo, otimizado para conversão e pronto para mobile.</p>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="feature-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <figure class="px-6 pt-6">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <i class="fas fa-sliders-h text-2xl"></i>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Painel Administrativo</h3>
                        <p>Gerencie seus imóveis com facilidade, adicione fotos, vídeos e todas as informações.</p>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="feature-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <figure class="px-6 pt-6">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <i class="fas fa-mobile-alt text-2xl"></i>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Totalmente Responsivo</h3>
                        <p>Seu site perfeito em qualquer dispositivo, do computador ao smartphone.</p>
                    </div>
                </div>
                
                <!-- Feature 4 -->
                <div class="feature-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <figure class="px-6 pt-6">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">SEO Otimizado</h3>
                        <p>Seu site pronto para ser encontrado no Google e outros mecanismos de busca.</p>
                    </div>
                </div>
                
                <!-- Feature 5 -->
                <div class="feature-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <figure class="px-6 pt-6">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <i class="fas fa-bolt text-2xl"></i>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Rápido e Seguro</h3>
                        <p>Tecnologia de ponta para garantir velocidade e segurança para seus visitantes.</p>
                    </div>
                </div>
                
                <!-- Feature 6 -->
                <div class="feature-card card bg-base-100 shadow-md hover:shadow-xl transition-all duration-300">
                    <figure class="px-6 pt-6">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                            <i class="fas fa-plus text-2xl"></i>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">E Muito MAIS</h3>
                        <p>Integrações, formulários de contato, WhatsApp integrado e diversas outras funcionalidades.</p>
                    </div>
                </div>
            </div>
            
            <!-- Future Features -->
            <div class="mt-16 bg-base-200 rounded-xl p-8">
                <h3 class="text-2xl font-bold mb-6 text-center">Em Breve Novas Funcionalidades</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="badge badge-primary badge-lg">
                            <i class="fas fa-calendar-alt mr-1"></i>
                        </div>
                        <span>Agendamento de Visitas</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="badge badge-primary badge-lg">
                            <i class="fas fa-file-signature mr-1"></i>
                        </div>
                        <span>Assinatura Digital</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="badge badge-primary badge-lg">
                            <i class="fas fa-camera mr-1"></i>
                        </div>
                        <span>Tour Virtual 360°</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="badge badge-primary badge-lg">
                            <i class="fas fa-chart-pie mr-1"></i>
                        </div>
                        <span>Relatórios Avançados</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-16 bg-primary text-primary-content">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Como Funciona</h2>
                <p class="text-lg max-w-2xl mx-auto">Em poucos passos você terá seu site profissional pronto para usar</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="card bg-base-100/10 shadow-lg">
                    <div class="card-body items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center text-2xl font-bold mb-4">1</div>
                        <h3 class="card-title text-white">Cadastro</h3>
                        <p>Preencha nosso formulário e crie sua conta gratuitamente.</p>
                    </div>
                </div>
                
                <!-- Step 2 -->
                <div class="card bg-base-100/10 shadow-lg">
                    <div class="card-body items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center text-2xl font-bold mb-4">2</div>
                        <h3 class="card-title text-white">Personalização</h3>
                        <p>Configure seu site com suas cores, logo e informações.</p>
                    </div>
                </div>
                
                <!-- Step 3 -->
                <div class="card bg-base-100/10 shadow-lg">
                    <div class="card-body items-center text-center">
                        <div class="w-16 h-16 rounded-full bg-primary text-white flex items-center justify-center text-2xl font-bold mb-4">3</div>
                        <h3 class="card-title text-white">Pronto!</h3>
                        <p>Comece a cadastrar seus imóveis e atrair clientes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-16">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Planos que Cabem no Seu Bolso</h2>
                <p class="text-lg max-w-2xl mx-auto">Escolha o plano ideal para suas necessidades</p>
                
                <div class="flex justify-center mt-6">
                    <div class="btn-group">
                        <button @click="activeTab = 'monthly'" class="btn" :class="activeTab === 'monthly' ? 'btn-primary' : 'btn-ghost'">Mensal</button>
                        <button @click="activeTab = 'yearly'" class="btn" :class="activeTab === 'yearly' ? 'btn-primary' : 'btn-ghost'">Anual (20% off)</button>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <!-- Plano Básico -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <h3 class="card-title">Básico</h3>
                        <div class="text-4xl font-bold my-4">
                            <span x-show="activeTab === 'monthly'">R$99</span>
                            <span x-show="activeTab === 'yearly'">R$79</span>
                            <span class="text-lg font-normal">/mês</span>
                        </div>
                        <p>Ideal para corretores individuais</p>
                        <div class="divider my-4"></div>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                <span>Até 20 imóveis</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                <span>1 usuário</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                <span>Template básico</span>
                            </li>
                            <li class="flex items-center gap-2 text-gray-400">
                                <i class="fas fa-times text-red-400"></i>
                                <span>Integração com portais</span>
                            </li>
                        </ul>
                        <div class="card-actions justify-center mt-6">
                            <button class="btn btn-primary w-full">Assinar</button>
                        </div>
                    </div>
                </div>
                
                <!-- Plano Profissional (Destaque) -->
                <div class="card bg-primary text-primary-content shadow-xl transform md:-translate-y-4">
                    <div class="card-body">
                        <div class="badge badge-secondary absolute top-4 right-4">Popular</div>
                        <h3 class="card-title text-white">Profissional</h3>
                        <div class="text-4xl font-bold my-4">
                            <span x-show="activeTab === 'monthly'">R$299</span>
                            <span x-show="activeTab === 'yearly'">R$239</span>
                            <span class="text-lg font-normal">/mês</span>
                        </div>
                        <p>Para imobiliárias em crescimento</p>
                        <div class="divider my-4"></div>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-400"></i>
                                <span>Imóveis ilimitados</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-400"></i>
                                <span>Até 5 usuários</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-400"></i>
                                <span>Templates premium</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-400"></i>
                                <span>Integração com portais</span>
                            </li>
                        </ul>
                        <div class="card-actions justify-center mt-6">
                            <button class="btn btn-secondary w-full">Assinar</button>
                        </div>
                    </div>
                </div>
                
                <!-- Plano Enterprise -->
                <div class="card bg-base-100 shadow-xl border border-base-300">
                    <div class="card-body">
                        <h3 class="card-title">Enterprise</h3>
                        <div class="text-4xl font-bold my-4">
                            <span>Sob consulta</span>
                        </div>
                        <p>Para grandes imobiliárias</p>
                        <div class="divider my-4"></div>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                <span>Todos os recursos</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                <span>Usuários ilimitados</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                <span>Template personalizado</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fas fa-check text-green-500"></i>
                                <span>Suporte prioritário</span>
                            </li>
                        </ul>
                        <div class="card-actions justify-center mt-6">
                            <button class="btn btn-primary w-full">Fale Conosco</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <p>Precisa de algo personalizado? <a href="#contact" class="link link-primary">Fale com nossa equipe</a></p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-16 bg-base-200">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">O que dizem nossos clientes</h2>
                <p class="text-lg max-w-2xl mx-auto">Veja a experiência de quem já usa nosso sistema</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="testimonial-card p-6 rounded-xl">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="avatar">
                            <div class="w-12 rounded-full">
                                <img src="https://randomuser.me/api/portraits/women/32.jpg" />
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold">Ana Carolina</h4>
                            <p class="text-sm">Corretora - Imóveis & Cia</p>
                        </div>
                    </div>
                    <div class="rating rating-sm mb-2">
                        <input type="radio" name="rating-1" class="mask mask-star" checked />
                        <input type="radio" name="rating-1" class="mask mask-star" checked />
                        <input type="radio" name="rating-1" class="mask mask-star" checked />
                        <input type="radio" name="rating-1" class="mask mask-star" checked />
                        <input type="radio" name="rating-1" class="mask mask-star" checked />
                    </div>
                    <p>"O sistema transformou meu trabalho. Agora consigo gerenciar meus imóveis com facilidade e meu site atrai muito mais clientes."</p>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="testimonial-card p-6 rounded-xl">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="avatar">
                            <div class="w-12 rounded-full">
                                <img src="https://randomuser.me/api/portraits/men/45.jpg" />
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold">Carlos Eduardo</h4>
                            <p class="text-sm">Diretor - Excelência Imóveis</p>
                        </div>
                    </div>
                    <div class="rating rating-sm mb-2">
                        <input type="radio" name="rating-2" class="mask mask-star" checked />
                        <input type="radio" name="rating-2" class="mask mask-star" checked />
                        <input type="radio" name="rating-2" class="mask mask-star" checked />
                        <input type="radio" name="rating-2" class="mask mask-star" checked />
                        <input type="radio" name="rating-2" class="mask mask-star" checked />
                    </div>
                    <p>"A migração foi super simples e em uma semana já estávamos com tudo funcionando. O suporte é excelente!"</p>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="testimonial-card p-6 rounded-xl">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="avatar">
                            <div class="w-12 rounded-full">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" />
                            </div>
                        </div>
                        <div>
                            <h4 class="font-bold">Fernanda Silva</h4>
                            <p class="text-sm">Corretora Independente</p>
                        </div>
                    </div>
                    <div class="rating rating-sm mb-2">
                        <input type="radio" name="rating-3" class="mask mask-star" checked />
                        <input type="radio" name="rating-3" class="mask mask-star" checked />
                        <input type="radio" name="rating-3" class="mask mask-star" checked />
                        <input type="radio" name="rating-3" class="mask mask-star" checked />
                        <input type="radio" name="rating-3" class="mask mask-star" checked />
                    </div>
                    <p>"Finalmente encontrei uma solução completa por um preço justo. Meus clientes amam o novo site e eu amo o painel de controle."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold mb-4">Perguntas Frequentes</h2>
                <p class="text-lg max-w-2xl mx-auto">Tire suas dúvidas sobre nosso sistema</p>
            </div>
            
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="collapse collapse-plus bg-base-200">
                    <input type="radio" name="my-accordion-3" checked="checked" /> 
                    <div class="collapse-title text-lg font-medium">
                        Quanto tempo leva para ter meu site no ar?
                    </div>
                    <div class="collapse-content"> 
                        <p>Após a confirmação do pagamento, seu site estará disponível em até 48 horas. O tempo pode variar dependendo da complexidade das personalizações solicitadas.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 2 -->
                <div class="collapse collapse-plus bg-base-200">
                    <input type="radio" name="my-accordion-3" /> 
                    <div class="collapse-title text-lg font-medium">
                        Posso migrar meu site atual para a plataforma?
                    </div>
                    <div class="collapse-content"> 
                        <p>Sim, nossa equipe pode ajudar na migração de seus imóveis e conteúdo. Entre em contato para avaliarmos seu caso específico.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 3 -->
                <div class="collapse collapse-plus bg-base-200">
                    <input type="radio" name="my-accordion-3" /> 
                    <div class="collapse-title text-lg font-medium">
                        Há limite de acesso ao painel administrativo?
                    </div>
                    <div class="collapse-content"> 
                        <p>Depende do plano escolhido. O plano Básico permite 1 usuário, o Profissional até 5 usuários e o Enterprise usuários ilimitados.</p>
                    </div>
                </div>
                
                <!-- FAQ Item 4 -->
                <div class="collapse collapse-plus bg-base-200">
                    <input type="radio" name="my-accordion-3" /> 
                    <div class="collapse-title text-lg font-medium">
                        Posso cancelar a qualquer momento?
                    </div>
                    <div class="collapse-content"> 
                        <p>Sim, não há fidelidade. Você pode cancelar quando quiser, mas sentiremos sua falta!</p>
                    </div>
                </div>
                
                <!-- FAQ Item 5 -->
                <div class="collapse collapse-plus bg-base-200">
                    <input type="radio" name="my-accordion-3" /> 
                    <div class="collapse-title text-lg font-medium">
                        Oferecem suporte técnico?
                    </div>
                    <div class="collapse-content"> 
                        <p>Sim, todos os planos incluem suporte por e-mail. Planos superiores incluem suporte prioritário por WhatsApp e telefone.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="cta" class="py-16 bg-primary text-primary-content">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Pronto para transformar seu negócio?</h2>
            <p class="text-xl mb-8 max-w-2xl mx-auto">Experimente gratuitamente por 7 dias e veja os resultados</p>
            
            <div class="max-w-md mx-auto">
                <div class="card bg-base-100/10 shadow-xl">
                    <div class="card-body">
                        <h3 class="card-title text-white mb-4">Teste Grátis</h3>
                        <form class="space-y-4">
                            <input type="text" placeholder="Seu Nome" class="input input-bordered w-full">
                            <input type="email" placeholder="Seu Melhor E-mail" class="input input-bordered w-full">
                            <input type="tel" placeholder="Telefone/WhatsApp" class="input input-bordered w-full">
                            <button type="button" class="btn btn-secondary w-full">
                                <i class="fas fa-play-circle mr-2"></i> Começar Teste Grátis
                            </button>
                        </form>
                        <p class="text-sm mt-4">Ao clicar, você concorda com nossos Termos de Serviço.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-12">
                <div class="lg:w-1/2">
                    <h2 class="text-3xl font-bold mb-6">Fale Conosco</h2>
                    <p class="mb-8">Tem dúvidas ou precisa de ajuda? Nossa equipe está pronta para te atender.</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Telefone</h4>
                                <p>(11) 99999-9999</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">E-mail</h4>
                                <p>contato@imobisystem.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="font-bold">Endereço</h4>
                                <p>Av. Paulista, 1000 - São Paulo/SP</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2">
                    <div class="card bg-base-100 shadow-xl">
                        <div class="card-body">
                            <h3 class="card-title">Envie uma Mensagem</h3>
                            <form class="space-y-4">
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Seu Nome</span>
                                    </label>
                                    <input type="text" placeholder="Nome completo" class="input input-bordered">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Seu E-mail</span>
                                    </label>
                                    <input type="email" placeholder="seu@email.com" class="input input-bordered">
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Assunto</span>
                                    </label>
                                    <select class="select select-bordered">
                                        <option disabled selected>Selecione</option>
                                        <option>Dúvidas</option>
                                        <option>Suporte</option>
                                        <option>Vendas</option>
                                        <option>Outros</option>
                                    </select>
                                </div>
                                <div class="form-control">
                                    <label class="label">
                                        <span class="label-text">Mensagem</span>
                                    </label>
                                    <textarea class="textarea textarea-bordered h-24" placeholder="Sua mensagem..."></textarea>
                                </div>
                                <div class="form-control mt-6">
                                    <button class="btn btn-primary">Enviar Mensagem</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer p-10 bg-neutral text-neutral-content">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <span class="footer-title">ImobiSystem</span>
                    <p>Soluções completas para imobiliárias e corretores</p>
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
                    <span class="footer-title">Links Úteis</span>
                    <a href="#features" class="link link-hover">Funcionalidades</a>
                    <a href="#pricing" class="link link-hover">Planos</a>
                    <a href="#testimonials" class="link link-hover">Depoimentos</a>
                    <a href="#faq" class="link link-hover">FAQ</a>
                </div>
                
                <div>
                    <span class="footer-title">Legal</span>
                    <a href="#" class="link link-hover">Termos de Uso</a>
                    <a href="#" class="link link-hover">Política de Privacidade</a>
                    <a href="#" class="link link-hover">Contrato</a>
                </div>
                
                <div>
                    <span class="footer-title">Newsletter</span>
                    <p>Receba novidades e dicas exclusivas</p>
                    <div class="form-control mt-4">
                        <div class="relative">
                            <input type="text" placeholder="seu@email.com" class="input input-bordered w-full pr-16">
                            <button class="btn btn-primary absolute top-0 right-0 rounded-l-none">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center">
                <p>&copy; 2023 ImobiSystem. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Float Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="https://wa.me/5511999999999" 
           target="_blank"
           class="btn btn-circle bg-green-500 text-white btn-lg shadow-xl hover:shadow-2xl transition-all"
           aria-label="Fale conosco no WhatsApp">
           <i class="fab fa-whatsapp text-2xl"></i>
        </a>
    </div>

    <!-- Modal Trial -->
    <template x-teleport="body">
        <div x-show="showModal" class="modal modal-bottom sm:modal-middle" @click="showModal = false">
            <div class="modal-box" @click.stop>
                <h3 class="font-bold text-lg">Teste Grátis por 7 dias!</h3>
                <p class="py-4">Preencha o formulário abaixo para começar seu teste gratuito:</p>
                <form class="space-y-4">
                    <input type="text" placeholder="Seu Nome" class="input input-bordered w-full">
                    <input type="email" placeholder="Seu Melhor E-mail" class="input input-bordered w-full">
                    <input type="tel" placeholder="Telefone/WhatsApp" class="input input-bordered w-full">
                    <div class="modal-action">
                        <button type="button" class="btn btn-primary w-full">
                            <i class="fas fa-play-circle mr-2"></i> Começar Teste
                        </button>
                    </div>
                </form>
                <div class="modal-action absolute top-2 right-2">
                    <button class="btn btn-sm btn-circle" @click="showModal = false">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </template>

    <script>
        document.addEventListener('alpine:init', () => {
            // Modal trigger
            Alpine.data('triggerModal', () => ({
                openModal() {
                    this.showModal = true;
                }
            }));
        });
    </script>
</body>
</html>