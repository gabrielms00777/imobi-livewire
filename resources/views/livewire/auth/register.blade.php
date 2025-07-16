<div class="md:w-96 mx-auto mt-10">
    <div class="mb-10">
        {{-- <x-app-brand /> --}}
        <h1 class="text-2xl font-bold text-center mt-4">Crie sua conta</h1>
        <p class="text-sm text-center text-gray-500 mt-2">Crie seu site imobiliário em minutos!</p>
    </div>

    <x-form wire:submit="register">
        {{-- SELEÇÃO DO TIPO DE CONTA --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Você é uma imobiliária ou corretor autônomo?</h2>
            <div class="flex gap-4 mb-4">
                {{-- mary-ui x-radio component --}}
                <x-radio
                    wire:model.live="account_type"
                    :options="[['key' => 'imobiliaria', 'value' => 'Imobiliária'], ['value' => 'Corretor Autônomo', 'key' => 'corretor']]"
                    option-value="key"
                    option-label="value"
                    inline 
                />
                {{-- <x-radio
                    label="Corretor Autônomo"
                    wire:model.live="account_type"
                    value="corretor"
                    class="radio-primary"
                /> --}}
            </div>
            @error('account_type')
                <p class="text-error text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- CAMPOS DA IMOBILIÁRIA (Condicional) --}}
        <div x-show="$wire.account_type === 'imobiliaria'" wire:transition.opacity>
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-3">Informações da Imobiliária</h2>
                <x-input
                    label="Nome da Imobiliária"
                    placeholder="Ex: Mega Imóveis"
                    wire:model="company_name"
                    icon="o-building-office"
                />
                <x-input
                    label="Telefone da Imobiliária"
                    placeholder="(99) 99999-9999"
                    wire:model="company_phone"
                    icon="o-phone"
                />
                <x-input
                    label="E-mail da Imobiliária (Opcional)"
                    placeholder="Ex: contato@megaimoveis.com.br"
                    wire:model="company_email"
                    icon="o-envelope"
                    type="email"
                />
            </div>
        </div>

        {{-- CAMPOS DO CORRETOR AUTÔNOMO (Condicional) --}}
        <div x-show="$wire.account_type === 'corretor'" wire:transition.opacity>
            <div class="mb-6">
                <h2 class="text-lg font-semibold mb-3">Informações do Corretor</h2>
                <x-input
                    label="Número do CRECI"
                    placeholder="Ex: 12345-F ou J-12345"
                    wire:model="creci_number"
                    icon="o-identification"
                />
            </div>
        </div>

        {{-- DADOS COMUNS DO USUÁRIO ADMIN/CORRETOR --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Seus Dados de Acesso</h2>
            <x-input
                label="Seu Nome Completo"
                placeholder="Ex: João da Silva"
                wire:model="name"
                icon="o-user"
            />
            <x-input
                label="Seu E-mail (Será seu login)"
                placeholder="Ex: seuemail@dominio.com"
                wire:model="email"
                icon="o-envelope"
                type="email"
            />
            <x-input
                label="Senha"
                placeholder="Mínimo 8 caracteres"
                wire:model="password"
                type="password"
                icon="o-key"
            />
            <x-input
                label="Confirme a Senha"
                placeholder="Digite novamente"
                wire:model="password_confirmation"
                type="password"
                icon="o-key"
            />
        </div>

        {{-- CAMPOS INICIAIS DE PERSONALIZAÇÃO DO SITE (Opcional) --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold mb-3">Personalização Inicial do Site (Opcional)</h2>
            <x-input
                label="Slogan do seu site"
                placeholder="Ex: Seu sonho, nossa realidade."
                wire:model="site_slogan"
                icon="o-sparkles"
            />
            <x-input
                label="URL da Logo (se já tiver uma online)"
                placeholder="Ex: https://seusite.com/logo.png"
                wire:model="site_logo_url"
                icon="o-photo"
                type="url"
            />
            <p class="text-sm text-gray-500 mt-2">Você poderá mudar e adicionar mais detalhes depois no painel.</p>
        </div>

        <x-slot:actions>
            <x-button
                label="Já tem uma conta? Faça login"
                class="btn-ghost"
                link="/login"
            />
            <x-button
                label="Criar Conta"
                type="submit"
                icon="o-paper-airplane"
                class="btn-primary"
                spinner="register"
            />
        </x-slot:actions>
    </x-form>

    @error('registration')
        <x-alert icon="o-exclamation-triangle" class="mt-4 alert-error">
            {{ $message }}
        </x-alert>
    @enderror
</div>