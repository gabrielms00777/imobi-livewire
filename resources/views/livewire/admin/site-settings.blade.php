<div>
    <x-header title="Configurações do Site" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Salvar" icon="o-check" wire:click="save" class="btn-primary" spinner="save" />
        </x-slot:actions>
    </x-header>

    <x-tabs wire:model="tab">
        <!-- Tab Geral -->
        <x-tab name="general">
            <x-slot:label>
                <x-icon name="o-cog" class="mr-2" />
                Geral
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-input label="Nome do Site*" wire:model="site_name" />
                    <x-textarea label="Descrição do Site*" wire:model="site_description" />

                    <x-file label="Logo do Site" wire:model="site_logo" accept="image/png, image/jpeg" />
                    {{-- @if ($site_logo || SiteSetting::first()?->site_logo)
                        <div class="flex items-center gap-4">
                            <x-avatar :image="$site_logo
                                ? $site_logo->temporaryUrl()
                                : Storage::url(SiteSetting::first()?->site_logo)" class="!w-32 !h-auto" />
                            @if ($site_logo)
                                <x-button icon="o-trash" wire:click="$set('site_logo', null)" spinner
                                    class="btn-ghost btn-sm text-error" />
                            @endif
                        </div>
                    @endif --}}

                    <x-file label="Favicon (PNG/ICO)" wire:model="site_favicon"
                        accept="image/png, image/x-icon, .ico" />
                    {{-- @if ($site_favicon || SiteSetting::first()?->site_favicon)
                        <div class="flex items-center gap-4">
                            <x-avatar :image="$site_favicon
                                ? $site_favicon->temporaryUrl()
                                : Storage::url(SiteSetting::first()?->site_favicon)" class="!w-16 !h-16" />
                            @if ($site_favicon)
                                <x-button icon="o-trash" wire:click="$set('site_favicon', null)" spinner
                                    class="btn-ghost btn-sm text-error" />
                            @endif
                        </div>
                    @endif --}}

                    <x-colorpicker label="Cor Primária*" wire:model="primary_color" />
                    <x-colorpicker label="Cor Secundária*" wire:model="secondary_color" />
                </div>
            </x-card>
        </x-tab>

        <!-- Tab Contato -->
        <x-tab name="contact">
            <x-slot:label>
                <x-icon name="o-phone" class="mr-2" />
                Contato
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-input label="Telefone*" wire:model="contact_phone" x-mask="(99) 99999-9999" />
                    <x-input label="E-mail*" wire:model="contact_email" type="email" />
                    <x-textarea label="Endereço*" wire:model="contact_address" class="lg:col-span-2" />
                </div>
            </x-card>
        </x-tab>

        <!-- Tab Redes Sociais -->
        <x-tab name="social">
            <x-slot:label>
                <x-icon name="o-share" class="mr-2" />
                Redes Sociais
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- <x-input label="Facebook" wire:model="social_facebook" icon="o-facebook" --}}
                    <x-input label="Facebook" wire:model="social_facebook" 
                        placeholder="https://..." />
                    {{-- <x-input label="Instagram" wire:model="social_instagram" icon="o-instagram" --}}
                    <x-input label="Instagram" wire:model="social_instagram" 
                        placeholder="https://..." />
                    {{-- <x-input label="LinkedIn" wire:model="social_linkedin" icon="o-linkedin" --}}
                    <x-input label="LinkedIn" wire:model="social_linkedin" 
                        placeholder="https://..." />
                    {{-- <x-input label="YouTube" wire:model="social_youtube" icon="o-youtube" placeholder="https://..." /> --}}
                    <x-input label="YouTube" wire:model="social_youtube" placeholder="https://..." />
                    {{-- <x-input label="WhatsApp" wire:model="social_whatsapp" icon="o-whatsapp" x-mask="(99) 99999-9999" /> --}}
                    <x-input label="WhatsApp" wire:model="social_whatsapp"  x-mask="(99) 99999-9999" />
                </div>
            </x-card>
        </x-tab>

        <!-- Tab SEO -->
        <x-tab name="seo">
            <x-slot:label>
                <x-icon name="o-magnifying-glass" class="mr-2" />
                SEO
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <div class="grid grid-cols-1 gap-6">
                    <x-input label="Meta Título" wire:model="meta_title"
                        helper="Título exibido nos resultados de busca (até 60 caracteres)" />
                    <x-textarea label="Meta Descrição" wire:model="meta_description"
                        helper="Descrição exibida nos resultados de busca (até 160 caracteres)" />
                    <x-file label="Meta Imagem" wire:model="meta_image" accept="image/png, image/jpeg" />
                    {{-- @if ($meta_image || $siteMetaImage) --}}
                    @if ($meta_image)
                        <div class="flex items-center gap-4">
                            {{-- <x-avatar :image="$meta_image ? $meta_image->temporaryUrl() : Storage::url($siteMetaImage)" class="!w-32 !h-auto" /> --}}
                            <x-avatar :image="$meta_image ? $meta_image->temporaryUrl() : Storage::url($meta_image)" class="!w-32 !h-auto" />
                            @if ($meta_image)
                                <x-button icon="o-trash" wire:click="$set('meta_image', null)" spinner
                                    class="btn-ghost btn-sm text-error" />
                            @endif
                        </div>
                    @endif

                    {{-- @if ($meta_image || SiteSetting::first()?->meta_image)
                        <div class="flex items-center gap-4">
                            <x-avatar :image="$meta_image ? $meta_image->temporaryUrl() : Storage::url(SiteSetting::first()?->meta_image)" class="!w-32 !h-auto" />
                            @if ($meta_image)
                                <x-button icon="o-trash" wire:click="$set('meta_image', null)" spinner class="btn-ghost btn-sm text-error" />
                            @endif
                        </div>
                    @endif --}}
                </div>
            </x-card>
        </x-tab>

        <!-- Tab Homepage -->
        <x-tab name="homepage">
            <x-slot:label>
                <x-icon name="o-home" class="mr-2" />
                Página Inicial
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <h3 class="font-bold text-lg mb-4">Seção Hero (Topo)</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <x-input label="Título" wire:model="hero_title" />
                    <x-input label="Subtítulo" wire:model="hero_subtitle" />
                    <x-file label="Imagem de Fundo" wire:model="hero_image" accept="image/png, image/jpeg"
                        class="lg:col-span-2" />
                    {{-- @if ($hero_image || SiteSetting::first()?->hero_image) --}}
                    
                </div>

                <h3 class="font-bold text-lg mb-4">Seção Sobre</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-input label="Título" wire:model="about_title" />
                    <x-textarea label="Conteúdo" wire:model="about_content" rows="5" />
                    <x-file label="Imagem" wire:model="about_image" accept="image/png, image/jpeg" />
                    {{-- @if ($about_image || SiteSetting::first()?->about_image) --}}
                </div>
            </x-card>
        </x-tab>

    </x-tabs>
</div>
