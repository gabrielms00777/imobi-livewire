<div>
    <x-header title="Configurações do Meu Site" separator progress-indicator>
        <x-slot:actions>
            <x-button label="Salvar" icon="o-check" wire:click="save" class="btn-primary" spinner="save" />
        </x-slot:actions>
    </x-header>

    <x-tabs wire:model="tab">
        <x-tab name="general">
            <x-slot:label>
                <x-icon name="o-cog" class="mr-2" />
                Geral
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-input label="Nome do Site*" wire:model="form.site_name" />
                    <x-textarea label="Descrição do Site*" wire:model="form.site_description" />

                    <div>
                        <x-file label="Logo do Site" wire:model="form.site_logo" accept="image/png, image/jpeg" />
                        @if ($form->site_logo || $form->site_logo_url_existing)
                            <div class="flex items-center gap-4 mt-2">
                                <x-avatar :image="$form->site_logo
                                    ? $form->site_logo->temporaryUrl()
                                    : ($form->site_logo_url_existing
                                        ? Storage::url($form->site_logo_url_existing)
                                        : '')" class="!w-32 !h-auto" />
                                @if ($form->site_logo || $form->site_logo_url_existing)
                                    <x-button icon="o-trash"
                                        wire:click="form.site_logo = null; form.site_logo_url_existing = null;" spinner
                                        class="btn-ghost btn-sm text-error" />
                                @endif
                            </div>
                        @endif
                    </div>

                    <div>
                        <x-file label="Favicon (PNG/ICO)" wire:model="form.site_favicon"
                            accept="image/png, image/x-icon, .ico" />
                        @if ($form->site_favicon || $form->site_favicon_url_existing)
                            <div class="flex items-center gap-4 mt-2">
                                <x-avatar :image="$form->site_favicon
                                    ? $form->site_favicon->temporaryUrl()
                                    : ($form->site_favicon_url_existing
                                        ? Storage::url($form->site_favicon_url_existing)
                                        : '')" class="!w-16 !h-16" />
                                @if ($form->site_favicon || $form->site_favicon_url_existing)
                                    <x-button icon="o-trash"
                                        wire:click="form.site_favicon = null; form.site_favicon_url_existing = null;"
                                        spinner class="btn-ghost btn-sm text-error" />
                                @endif
                            </div>
                        @endif
                    </div>

                    <x-colorpicker label="Cor Primária*" wire:model="form.primary_color" />
                    <x-colorpicker label="Cor Secundária*" wire:model="form.secondary_color" />
                    <x-colorpicker label="Cor do Texto*" wire:model="form.text_color" />

                    <x-select label="Exibição do Cabeçalho" wire:model="form.header_display_type" :options="[
                        ['id' => 'logo_only', 'name' => 'Somente Logo'],
                        ['id' => 'name_only', 'name' => 'Somente Nome'],
                        ['id' => 'logo_and_name', 'name' => 'Logo e Nome'],
                    ]"
                        option-value="id" option-label="name" />
                </div>
            </x-card>
        </x-tab>

        <x-tab name="contact">
            <x-slot:label>
                <x-icon name="o-phone" class="mr-2" />
                Contato
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-input label="Telefone*" wire:model="form.contact_phone" x-mask="(99) 99999-9999" />
                    <x-input label="E-mail*" wire:model="form.contact_email" type="email" />
                    <x-textarea label="Endereço*" wire:model="form.contact_address" class="lg:col-span-2" />
                </div>
            </x-card>
        </x-tab>

        <x-tab name="social">
            <x-slot:label>
                <x-icon name="o-share" class="mr-2" />
                Redes Sociais
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-input label="Facebook" wire:model="form.social_facebook" placeholder="https://..." />
                    <x-input label="Instagram" wire:model="form.social_instagram" placeholder="https://..." />
                    <x-input label="LinkedIn" wire:model="form.social_linkedin" placeholder="https://..." />
                    <x-input label="YouTube" wire:model="form.social_youtube" placeholder="https://..." />
                    <x-input label="WhatsApp" wire:model="form.social_whatsapp" x-mask="(99) 99999-9999" />
                </div>
            </x-card>
        </x-tab>

        <x-tab name="seo">
            <x-slot:label>
                <x-icon name="o-magnifying-glass" class="mr-2" />
                SEO
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <div class="grid grid-cols-1 gap-6">
                    <x-input label="Meta Título" wire:model="form.meta_title"
                        helper="Título exibido nos resultados de busca (até 60 caracteres)" />
                    <x-textarea label="Meta Descrição" wire:model="form.meta_description"
                        helper="Descrição exibida nos resultados de busca (até 160 caracteres)" />

                    <div>
                        <x-file label="Meta Imagem" wire:model="form.meta_image" accept="image/png, image/jpeg" />
                        @if ($form->meta_image || $form->meta_image_url_existing)
                            <div class="flex items-center gap-4 mt-2">
                                <x-avatar :image="$form->meta_image
                                    ? $form->meta_image->temporaryUrl()
                                    : ($form->meta_image_url_existing
                                        ? Storage::url($form->meta_image_url_existing)
                                        : '')" class="!w-32 !h-auto" />
                                @if ($form->meta_image || $form->meta_image_url_existing)
                                    <x-button icon="o-trash"
                                        wire:click="form.meta_image = null; form.meta_image_url_existing = null;"
                                        spinner class="btn-ghost btn-sm text-error" />
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </x-card>
        </x-tab>

        <x-tab name="homepage">
            <x-slot:label>
                <x-icon name="o-home" class="mr-2" />
                Página Inicial
            </x-slot:label>

            <x-card shadow separator class="mb-5">
                <h3 class="font-bold text-lg mb-4">Seção Hero (Topo)</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="lg:col-span-2">
                        <x-toggle label="Mostrar Conteúdo de Texto" wire:model="form.hero_show_text_content"
                            class="toggle-primary" />
                    </div>
                    <x-input label="Título" wire:model="form.hero_title" />
                    <x-input label="Descrição" wire:model="form.hero_description" /> {{-- Ajuste de subtítulo para descrição --}}
                    {{-- <x-input label="Texto Clientes Satisfeitos" wire:model="form.hero_clients_satisfied_text" />
                    <x-input label="Avaliação em Estrelas" wire:model="form.hero_stars_rating" type="number" step="0.1" min="0" max="5" />
                    <x-input label="Título do Formulário de Busca" wire:model="form.hero_form_title" />
                    <x-input label="Texto Botão de Busca" wire:model="form.hero_search_button_text" />
                    <x-input label="Ícone Botão de Busca (Font Awesome)" wire:model="form.hero_search_button_icon" /> --}}


                    <div class="mb-4 lg:col-span-2">
                        <x-radio label="Tipo de Fundo do Hero" inline wire:model.live="form.hero_background_type"
                            :options="[
                                ['id' => 'gradient', 'name' => 'Gradiente'],
                                ['id' => 'image', 'name' => 'Imagem'],
                            ]" />
                    </div>

                    @if ($form->hero_background_type === 'gradient')
                        <x-colorpicker label="Cor Inicial do Gradiente" wire:model="form.hero_gradient_from_color" />
                        <x-colorpicker label="Cor Final do Gradiente" wire:model="form.hero_gradient_to_color" />
                        <x-select label="Direção do Gradiente" wire:model="form.hero_gradient_direction"
                            :options="[
                                ['id' => 'to-t', 'name' => 'Para Cima'],
                                ['id' => 'to-tr', 'name' => 'Para Cima Direita'],
                                ['id' => 'to-r', 'name' => 'Para Direita'],
                                ['id' => 'to-br', 'name' => 'Para Baixo Direita'],
                                ['id' => 'to-b', 'name' => 'Para Baixo'],
                                ['id' => 'to-bl', 'name' => 'Para Baixo Esquerda'],
                                ['id' => 'to-l', 'name' => 'Para Esquerda'],
                                ['id' => 'to-tl', 'name' => 'Para Cima Esquerda'],
                            ]" option-value="id" option-label="name"
                            placeholder="Selecione uma direção" />
                    @elseif ($form->hero_background_type === 'image')
                        <div>
                            <x-file label="Imagem de Fundo do Hero" wire:model="form.hero_image_url"
                                accept="image/png, image/jpeg" />
                            @if ($form->hero_image_url || $form->hero_image_url_existing)
                                <div class="flex items-center gap-4 mt-2">
                                    <x-avatar :image="$form->hero_image_url
                                        ? $form->hero_image_url->temporaryUrl()
                                        : ($form->hero_image_url_existing
                                            ? Storage::url($form->hero_image_url_existing)
                                            : '')" class="!w-32 !h-auto" />
                                    @if ($form->hero_image_url || $form->hero_image_url_existing)
                                        <x-button icon="o-trash"
                                            wire:click="form.hero_image_url = null; form.hero_image_url_existing = null;"
                                            spinner class="btn-ghost btn-sm text-error" />
                                    @endif
                                </div>
                            @endif
                        </div>
                        {{-- Os inputs comentados serão mantidos assim --}}
                        {{-- <x-input label="Alt Text da Imagem" wire:model="form.hero_image_alt_text" />
    <x-input label="Classe CSS da Imagem" wire:model="form.hero_image_class" helper="Ex: absolute inset-0 w-full h-full object-cover z-0 opacity-70" /> --}}
                    @endif

                    {{-- <div class="lg:col-span-2">
                            <x-textarea label="Avatares do Hero (URLs separadas por vírgula)" wire:model="form.hero_avatars_string" helper="URLs das imagens dos avatares, separadas por vírgula." />
                    </div> --}}

                    {{-- <div class="lg:col-span-2">
                            <x-textarea label="Opções de Seleção do Formulário de Busca (JSON)" wire:model="form.hero_select_options_json" rows="5" helper="JSON Array de objetos para as opções de seleção. Ex: [{ placeholder: 'Tipo', options: ['Casa', 'Apto'] }]"></x-textarea>
                    </div> --}}
                </div>

                <hr class="my-8">

                <h3 class="font-bold text-lg mb-4">Seção Sobre</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <x-input label="Título" wire:model="form.about_title" />
                    <div class="lg:col-span-2">
                        <x-textarea label="Conteúdo" wire:model="form.about_content" rows="5" />
                    </div>
                    <div>
                        <x-file label="Imagem da Seção Sobre" wire:model="form.about_image"
                            accept="image/png, image/jpeg" />
                        @if ($form->about_image || $form->about_image_url_existing)
                            <div class="flex items-center gap-4 mt-2">
                                <x-avatar :image="$form->about_image
                                    ? $form->about_image->temporaryUrl()
                                    : ($form->about_image_url_existing
                                        ? // ? Storage::url($form->about_image_url_existing)
                                        asset($form->about_image_url_existing)
                                        : '')" class="!w-32 !h-auto !rounded-lg" />
                                @if ($form->about_image || $form->about_image_url_existing)
                                    <x-button icon="o-trash"
                                        wire:click="form.about_image = null; form.about_image_url_existing = null;"
                                        spinner class="btn-ghost btn-sm text-error" />
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="lg:col-span-2">
                        <x-collapse separator>
                            <x-slot:heading>
                                <h4 class="text-lg font-semibold mb-3">Características da Seção Sobre</h4>
                            </x-slot:heading>
                            <x-slot:content>
                                @foreach ($form->about_features_list as $index => $feature)
                                    <div wire:key="feature-{{ $index }}"
                                        class="bg-base-200 p-4 rounded-lg mb-4 flex flex-col gap-3">
                                        <div class="flex justify-between items-center">
                                            <span class="font-medium text-sm">Característica
                                                #{{ $index + 1 }}</span>
                                            <x-button icon="o-trash"
                                                wire:click="removeAboutFeature({{ $index }})" spinner
                                                class="btn-ghost btn-sm text-error" />
                                        </div>
                                        <x-input label="Título da Característica"
                                            wire:model="form.about_features_list.{{ $index }}.title" />
                                        <x-textarea label="Descrição da Característica"
                                            wire:model="form.about_features_list.{{ $index }}.description"
                                            rows="2" />
                                        <x-input label="Ícone da Característica (Font Awesome)"
                                            wire:model="form.about_features_list.{{ $index }}.icon"
                                            helper="Ex: fas fa-check-circle. Veja em fontawesome.com" />
                                    </div>
                                @endforeach
                                <x-button label="Adicionar Característica" icon="o-plus"
                                    wire:click="addAboutFeature" class="btn-outline btn-primary mt-4" />
                            </x-slot:content>
                        </x-collapse>
                    </div>
                    {{-- <div class="lg:col-span-2">
                        <x-textarea label="Características da Seção Sobre (JSON)"
                            wire:model="form.about_features_json" rows="5"
                            helper="JSON Array de objetos para características. Ex: [{ title: 'Atendimento', description: '...', icon: 'fas fa-star' }]"></x-textarea>
                    </div> --}}
                </div>

                <hr class="my-8">

                <h3 class="font-bold text-lg mb-4">Seção de Engajamento/Métricas</h3>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <x-input label="Título" wire:model="form.engagement_title" />
                    <x-textarea label="Descrição" wire:model="form.engagement_description" rows="3" />

                    <div class="lg:col-span-2">
                        <h4 class="text-lg font-semibold mb-3">Métricas de Engajamento</h4>
                        @foreach ($form->engagement_metrics_list as $index => $metric)
                            <div wire:key="metric-{{ $index }}"
                                class="bg-base-200 p-4 rounded-lg mb-4 flex flex-col gap-3">
                                <div class="flex justify-between items-center">
                                    <span class="font-medium text-sm">Métrica #{{ $index + 1 }}</span>
                                    <x-button icon="o-trash" wire:click="removeEngagementMetric({{ $index }})"
                                        spinner class="btn-ghost btn-sm text-error" />
                                </div>
                                <x-input label="Valor da Métrica"
                                    wire:model="form.engagement_metrics_list.{{ $index }}.value"
                                    placeholder="Ex: 1.200+, 98%" />
                                <x-input label="Descrição da Métrica"
                                    wire:model="form.engagement_metrics_list.{{ $index }}.description" />
                            </div>
                        @endforeach
                        <x-button label="Adicionar Métrica" icon="o-plus" wire:click="addEngagementMetric"
                            class="btn-outline btn-primary mt-4" />
                    </div>

                    <x-input label="Texto Botão Imóveis" wire:model="form.engagement_btn_properties_text" />
                    <x-input label="Ícone Botão Imóveis (Font Awesome)"
                        wire:model="form.engagement_btn_properties_icon"
                        helper="Ex: fas fa-home. Veja em fontawesome.com" />
                    <x-input label="Link Botão Imóveis" wire:model="form.engagement_btn_properties_link" />
                    <x-input label="Texto Botão Contato" wire:model="form.engagement_btn_contact_text" />
                    <x-input label="Ícone Botão Contato (Font Awesome)" wire:model="form.engagement_btn_contact_icon"
                        helper="Ex: fas fa-phone-alt. Veja em fontawesome.com" />
                    <x-input label="Link Botão Contato" wire:model="form.engagement_btn_contact_link" />
                </div>
            </x-card>
        </x-tab>
    </x-tabs>
</div>
