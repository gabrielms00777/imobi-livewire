<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            {{-- <x-app-brand /> --}}
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
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            {{-- <x-app-brand class="px-5 pt-4" /> --}}
            <a href="/" class="btn btn-ghost px-5 mt-4">
                <div class="flex items-center">
                    <div class="w-10 mr-2">
                        <img src="https://placehold.co/400x400/3b82f6/white?text=IM" alt="Logo"
                            class="w-full rounded-lg">
                    </div>
                    <span class="text-xl font-bold text-primary">Imobiliária<span
                            class="text-secondary">Premium</span></span>
                </div>
            </a>

            {{-- MENU --}}
            <x-menu activate-by-route>

                {{-- User --}}
                @php
                    $user = auth()->user();
                    $slug = $user->slug ?? null;
                    if(!$slug){
                        $slug = $user->company->slug;
                    }
                @endphp
                <x-menu-separator />

                <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                    class="-mx-2 !-my-2 rounded">
                    <x-slot:actions>
                        <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff"
                            no-wire-navigate link="/logout" />
                    </x-slot:actions>
                </x-list-item>

                <x-menu-separator />

                <x-menu-item title="Dashboard" icon="o-sparkles" link="/admin" />
                <x-menu-item title="Imoveis" icon="o-sparkles" link="/admin/properties" />

                <x-menu-sub title="Configurações" icon="o-cog-6-tooth">
                    <x-menu-item title="Usuarios" icon="o-wifi" :link="route('admin.users.index')" />
                    <x-menu-item title="Site" icon="o-archive-box" :link="route('admin.tenant-settings.index')" />
                </x-menu-sub>
                <x-menu-item title="ir para o site" icon="o-sparkles" :link="route('tenant.home', ['tenantSlug' => $slug])" />
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
</body>

</html>
