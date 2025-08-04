@props(['tenant', 'tenantSettings'])

<header x-data="{ isScrolled: false }" @scroll.window="isScrolled = window.scrollY > 300"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
    :class="isScrolled ? 'bg-white shadow-md dark:bg-neutral' : 'bg-transparent'">

    <div class="container mx-auto px-4">
        <div class="navbar">
            <div class="flex-1">
                <a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}" class="px-0">
                    <div class="flex items-center">
                        @if ($tenantSettings->site_logo && $tenantSettings->header_display_type == 'logo_and_name')
                            <img src="{{ $tenantSettings->site_logo }}" alt="Logo {{ $tenantSettings->site_name }}"
                                class="h-8 w-auto mr-2 rounded-lg">
                            @php
                                $words = explode(' ', $tenantSettings->site_name);
                                $firstWord = array_shift($words);
                                $remainingWords = implode(' ', $words);
                            @endphp
                            <span class="text-xl font-bold text-primary">{{ $firstWord ?? '' }}</span>
                            @if (!empty($remainingWords))
                                <span class="text-xl font-bold text-secondary">{{ $remainingWords }}</span>
                            @endif
                        @elseif ($tenantSettings->site_logo && $tenantSettings->header_display_type == 'logo_only')
                            <img src="{{ $tenantSettings->site_logo }}" alt="Logo {{ $tenantSettings->site_name }}"
                                class="h-10 w-auto rounded-lg">
                        @elseif ($tenantSettings->site_name && $tenantSettings->header_display_type == 'name_only')
                            @php
                                $words = explode(' ', $tenantSettings->site_name);
                                $firstWord = array_shift($words);
                                $remainingWords = implode(' ', $words);
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

                {{-- <a href="https://wa.me/{{ $tenantSettings->social_whatsapp }}"
                    class="btn btn-primary btn-sm md:btn-md gap-2">
                    <i class="fab fa-whatsapp"></i>
                    <span class="hidden sm:inline">{{ $tenantSettings->contact_phone }}</span>
                </a> --}}
                <div x-data="{
                    formatPhone: (phone) => {
                        // Remove tudo que não for dígito
                        const cleaned = ('' + phone).replace(/\D/g, '');
                
                        // Aplica a formatação (xx) xxxxx-xxxx
                        const match = cleaned.match(/^(\d{2})(\d{5})(\d{4})$/);
                        if (match) {
                            return '(' + match[1] + ') ' + match[2] + '-' + match[3];
                        }
                
                        // Se o número não tiver o formato esperado, retorna o original
                        return phone;
                    }
                }">
                    <a href="https://wa.me/{{ $tenantSettings->social_whatsapp }}"
                        class="btn btn-primary btn-sm md:btn-md gap-2">
                        <i class="fab fa-whatsapp"></i>
                        <span x-text="formatPhone('{{ $tenantSettings->social_whatsapp }}')"></span>
                    </a>
                </div>
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

    <div class="drawer-side z-50">
        <label for="mobile-menu" class="drawer-overlay"></label>
        <div class="menu p-4 w-80 h-full bg-base-100 text-base-content">
            <div class="flex items-center justify-between mb-6">
                <a href="{{ route('tenant.home', ['tenantSlug' => $tenant->slug]) }}" class="px-0">
                    <div class="flex items-center">
                        @if ($tenantSettings->site_logo && $tenantSettings->header_display_type == 'logo_and_name')
                            <img src="{{ $tenantSettings->site_logo }}" alt="Logo {{ $tenantSettings->site_name }}"
                                class="h-8 w-auto mr-2 rounded-lg">
                            @php
                                $words = explode(' ', $tenantSettings->site_name);
                                $firstWord = array_shift($words);
                                $remainingWords = implode(' ', $words);
                            @endphp
                            <span class="text-xl font-bold text-primary">{{ $firstWord ?? '' }}</span>
                            @if (!empty($remainingWords))
                                <span class="text-xl font-bold text-secondary">{{ $remainingWords }}</span>
                            @endif
                        @elseif ($tenantSettings->site_logo && $tenantSettings->header_display_type == 'logo_only')
                            <img src="{{ $tenantSettings->site_logo }}" alt="Logo {{ $tenantSettings->site_name }}"
                                class="h-10 w-auto rounded-lg">
                        @elseif ($tenantSettings->site_name && $tenantSettings->header_display_type == 'name_only')
                            @php
                                $words = explode(' ', $tenantSettings->site_name);
                                $firstWord = array_shift($words);
                                $remainingWords = implode(' ', $words);
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
                <label for="mobile-menu" class="btn btn-ghost btn-circle">
                    <i class="fas fa-times"></i>
                </label>
            </div>

            {{-- <ul class="space-y-2">
                <li><a href="#" class="font-medium">Início</a></li>
                <li><a href="#destaques" class="font-medium">Destaques</a></li>
                <li><a href="#sobre" class="font-medium">Sobre</a></li>
                <li><a href="#contato" class="font-medium">Contato</a></li>
                @if (auth()->check())
                    <li><a href="/admin" class="font-medium">Dashboard</a></li>
                @else
                    <li><a href="/login" class="font-medium">Login</a></li>
                @endif
            </ul>

            <div class="divider my-4"></div> --}}

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

            <div x-data="{
                formatPhone: (phone) => {
                    // Remove tudo que não for dígito
                    const cleaned = ('' + phone).replace(/\D/g, '');
            
                    // Aplica a formatação (xx) xxxxx-xxxx
                    const match = cleaned.match(/^(\d{2})(\d{5})(\d{4})$/);
                    if (match) {
                        return '(' + match[1] + ') ' + match[2] + '-' + match[3];
                    }
            
                    // Se o número não tiver o formato esperado, retorna o original
                    return phone;
                }
            }">
                <a href="https://wa.me/{{ $tenantSettings->social_whatsapp }}"
                    class="btn btn-primary btn-sm md:btn-md gap-2">
                    <i class="fab fa-whatsapp"></i>
                    <span x-text="formatPhone('{{ $tenantSettings->social_whatsapp }}')"></span>
                </a>
            </div>
        </div>
    </div>
</header>
