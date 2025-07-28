@assets
    <script defer type="text/javascript"
        src="https://cdn.jsdelivr.net/gh/robsontenorio/mary@0.44.2/libs/currency/currency.js"></script>
@endassets

<div>
    <x-header title="Cadastrar Novo Imóvel" separator>
        <x-slot:actions>
            <x-button label="Cancelar" link="{{ route('admin.properties.index') }}" icon="o-arrow-uturn-left"
                class="btn-ghost" />
        </x-slot:actions>
    </x-header>
    
    <x-form wire:submit="save">
        {{-- Seção de Informações Básicas --}}
        <x-card title="Informações Básicas" shadow separator>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <x-input label="Título*" wire:model="form.title" placeholder="Ex: Casa moderna com piscina no centro" />
                <x-textarea label="Descrição*" wire:model="form.description"
                    placeholder="Descreva detalhadamente o imóvel..." rows="5" />

                <x-select label="Tipo*" wire:model="form.type" :options="$typeOptions" placeholder="Selecione o tipo..." />
                <x-select label="Finalidade*" wire:model.live="form.purpose" :options="$purposeOptions"
                    placeholder="Selecione a finalidade..." />

                <x-select label="Status*" wire:model="form.status" :options="$statusOptions"
                    placeholder="Selecione o status..." />
                <x-checkbox label="Destaque" wire:model="form.featured" class="checkbox-primary" />

                <x-input label="Preço (R$)*" wire:model="form.price" icon="o-currency-dollar" money locale="pt-BR" />
                <x-input label="Preço de Aluguel (R$)" wire:model="form.rent_price" icon="o-currency-dollar" money
                    locale="pt-BR" :disabled="$form->purpose === 'venda'" />
            </div>
        </x-card>

        {{-- Seção de Características --}}
        <x-card title="Características" shadow separator class="mt-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <x-input label="Quartos" wire:model="form.bedrooms" type="number" />
                <x-input label="Banheiros" wire:model="form.bathrooms" type="number" />
                <x-input label="Vagas" wire:model="form.garage_spaces" type="number" />
                <x-input label="Área (m²)" wire:model="form.area" type="number" />

                {{-- <x-input label="Área Total (m²)" wire:model="form.total_area" type="number" :disabled="$form->type !== 'terreno'" /> --}}
                {{-- <x-input label="Área Construída (m²)" wire:model="form.construction_area" type="number" :disabled="$form->type === 'terreno'" /> --}}
                {{-- <x-input label="Andares" wire:model="form.floors" type="number" /> --}}
                {{-- <x-input label="Ano de Construção" wire:model="form.year_built" type="number" /> --}}
            </div>
        </x-card>

        {{-- Seção de Endereço --}}
        <x-card title="Endereço" shadow separator class="mt-5">
            <div x-data="{
                cepSearching: false,
                addressSearching: false,
                searchCep: async function(cep) {
                    if (!cep) return;
                    this.cepSearching = true;
                    cep = cep.replace(/\D/g, ''); // Remove non-digits

                    try {
                        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                        const data = await response.json();

                        if (!data.erro) {
                            @this.set('form.street', data.logradouro || '');
                            @this.set('form.neighborhood', data.bairro || '');
                            @this.set('form.city', data.localidade || '');
                            @this.set('form.state', data.uf || '');

                            // Dá um pequeno delay para o Livewire atualizar os modelos antes de buscar coordenadas
                            setTimeout(() => {
                                this.getCoordinates();
                            }, 100);

                        } else {
                            @this.set('form.street', '');
                            @this.set('form.neighborhood', '');
                            @this.set('form.city', '');
                            @this.set('form.state', '');
                            @this.set('form.latitude', null);
                            @this.set('form.longitude', null);
                            console.error('CEP não encontrado.');
                            $wire.error('CEP não encontrado.', { position: 'toast-top' });
                        }
                    } catch (error) {
                        console.error('Erro ao consultar ViaCEP:', error);
                        $wire.error('Erro ao consultar CEP. Tente novamente.', { position: 'toast-top' });
                    } finally {
                        this.cepSearching = false;
                    }
                },
                getCoordinates: Alpine.debounce(async function() {
                    const street = @this.get('form.street');
                    const number = @this.get('form.number');
                    const city = @this.get('form.city');
                    const state = @this.get('form.state');
                    const zip_code = @this.get('form.zip_code');

                    if (!street || !city || !state) {
                        @this.set('form.latitude', null);
                        @this.set('form.longitude', null);
                        return;
                    }

                    this.addressSearching = true;
                    // Monta a query para o Nominatim
                    const addressQuery = encodeURIComponent(`${street}, ${number}, ${city}, ${state}, Brasil, ${zip_code}`);
                    const nominatimUrl = `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${addressQuery}`;

                    try {
                        const response = await fetch(nominatimUrl, {
                            headers: {
                                'User-Agent': 'ImobiliariaApp/1.0 (seumail@example.com)' // OBRIGATÓRIO para Nominatim
                            }
                        });
                        const data = await response.json();

                        if (data && data.length > 0) {
                            @this.set('form.latitude', parseFloat(data[0].lat));
                            @this.set('form.longitude', parseFloat(data[0].lon));
                        } else {
                            @this.set('form.latitude', null);
                            @this.set('form.longitude', null);
                            console.warn('Coordenadas não encontradas para o endereço.');
                            $wire.warning('Não foi possível obter as coordenadas automaticamente.', { position: 'toast-top' });
                        }
                    } catch (error) {
                        console.error('Erro ao obter coordenadas:', error);
                        @this.set('form.latitude', null);
                        @this.set('form.longitude', null);
                        $wire.error('Erro ao obter coordenadas. Tente preencher manualmente.', { position: 'toast-top' });
                    } finally {
                        this.addressSearching = false;
                    }
                }, 1000) // Debounce para evitar múltiplas chamadas rápidas
            }">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    {{-- CEP como primeiro campo --}}
                    <x-input label="CEP*" wire:model.live="form.zip_code" placeholder="Ex: 14000-000" x-mask="99999-999"
                        x-on:blur="searchCep($el.value)" x-bind:disabled="cepSearching" />
                    <x-input label="Rua*" wire:model="form.street" placeholder="Ex: Av. Brasil"
                        x-bind:disabled="cepSearching" />
                    <x-input label="Número*" wire:model="form.number" placeholder="Ex: 123" />
                    <x-input label="Complemento" wire:model="form.complement" placeholder="Ex: Bloco A, Apartamento 101" />
                    <x-input label="Bairro*" wire:model="form.neighborhood" placeholder="Ex: Centro"
                        x-bind:disabled="cepSearching" />
                    <x-input label="Cidade*" wire:model="form.city" placeholder="Ex: São Paulo"
                        x-bind:disabled="cepSearching" />
                    <x-select label="Estado*" wire:model="form.state" :options="$stateOptions"
                        placeholder="Selecione o estado..." x-bind:disabled="cepSearching" />
                    {{-- <x-input label="Latitude" wire:model="form.latitude" type="number" step="any"
                        x-bind:disabled="addressSearching" />
                    <x-input label="Longitude" wire:model="form.longitude" type="number" step="any"
                        x-bind:disabled="addressSearching" /> --}}
                </div>
            </div>
        </x-card>
        {{-- <x-card title="Localização" shadow separator class="mt-5">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <x-input label="Logradouro*" wire:model="form.street" placeholder="Rua, Avenida, etc." />
                <x-input label="Número*" wire:model="form.number" placeholder="Número ou S/N" />

                <x-input label="Complemento" wire:model="form.complement" placeholder="Apto, Bloco, etc." />
                <x-input label="Bairro*" wire:model="form.neighborhood" />

                <x-input label="Cidade*" wire:model="form.city" />
                <x-select label="Estado*" wire:model="form.state" :options="$stateOptions"
                    placeholder="Selecione o estado..." />

                <x-input label="CEP*" wire:model="form.zip_code" x-mask="99999-999" placeholder="00000-000" />

                <div class="grid grid-cols-2 gap-4">
                    <x-input label="Latitude" wire:model="form.latitude" type="number" step="0.000001" />
                    <x-input label="Longitude" wire:model="form.longitude" type="number" step="0.000001" />
                </div>
            </div>

            <div class="mt-4 h-64 bg-gray-100 rounded-lg flex items-center justify-center">
                <p class="text-gray-500">Mapa de localização será implementado aqui</p>
            </div>
        </x-card> --}}

        {{-- Seção de Mídia --}}
        <x-card title="Mídia" shadow separator class="mt-5">
            <div class="grid grid-cols-1 gap-4">
                <x-file  label="Thumbnail (Imagem Principal)" wire:model="form.thumbnail" accept="image/png, image/jpeg" hint="Clique para enviar ou arraste uma imagem" />
                
                @if ($form->thumbnail)
                    <div class="flex items-center gap-2">
                        <x-avatar :image="$form->thumbnail->temporaryUrl()" class="!w-24 !h-24" />
                        <x-button icon="o-trash" wire:click="$set('thumbnail', null)" spinner class="btn-ghost btn-sm text-error" />
                    </div>
                @endif
                
                <x-file  label="Galeria de Imagens (Máx. 20)" wire:model="form.galleryImages" multiple accept="image/png, image/jpeg" hint="Clique para enviar ou arraste múltiplas imagens" />
                
                @if (count($form->galleryImages) > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                        @foreach ($form->galleryImages as $index => $image)
                            <div class="relative group">
                                <x-avatar :image="$image->temporaryUrl()" class="!w-full !h-32 !rounded" />
                                <x-button icon="o-trash" wire:click="removeGalleryImage({{ $index }})" spinner class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" />
                            </div>
                        @endforeach
                    </div>
                @endif
                
                {{-- <x-input label="URL do Vídeo (Youtube/Vimeo)" wire:model="form.video_url" placeholder="https://youtu.be/..." />
                <x-input label="URL do Tour Virtual" wire:model="form.virtual_tour_url" placeholder="https://..." />  --}}
            </div>
        </x-card>

        {{-- <div>
            <x-card title="Mídia" shadow separator class="mt-5">
                <x-slot:menu>
                    <x-button label="Adicionar Imagens" icon="o-plus" class="btn-primary"
                        @click="$wire.openMediaModal()" />
                </x-slot:menu>

                <div class="grid grid-cols-1 gap-4">
                    @if ($form->existingThumbnails->isNotEmpty())
                        <div class="border border-base-300 p-4 rounded-lg bg-base-100 shadow-sm">
                            <h5 class="text-lg font-semibold mb-3">Imagem Principal Atual</h5>
                            <div class="relative group w-full max-w-xs mx-auto">
                                <x-avatar :image="$form->existingThumbnails->first()->getUrl('thumb')" class="!w-full !h-48 !rounded object-cover" />
                                <span class="absolute top-2 left-2 badge badge-success text-white">Principal</span>
                                <x-button icon="o-trash"
                                    wire:click="removeMedia({{ $form->existingThumbnails->first()->id }})" spinner
                                    class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" />
                            </div>
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-4">
                            Nenhuma imagem principal definida. Adicione uma!
                        </div>
                    @endif

                    <div class="border border-base-300 p-4 rounded-lg bg-base-100 shadow-sm mt-4">
                        <h5 class="text-lg font-semibold mb-3">Galeria de Imagens</h5>
                        @if ($form->existingGalleryImages != [])
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                                @foreach ($form->existingGalleryImages as $image)
                                    <div class="relative group">
                                        <x-avatar :image="$image->getUrl('thumb')" class="!w-full !h-32 !rounded object-cover" />
                                        <x-button icon="o-trash" wire:click="removeMedia({{ $image->id }})" spinner
                                            class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" />
                                        <x-button icon="o-star" wire:click="setMediaAsPrincipal({{ $image->id }})"
                                            spinner
                                            class="absolute bottom-1 left-1 btn-ghost btn-xs text-warning opacity-0 group-hover:opacity-100 transition-opacity"
                                            tooltip="Definir como principal" />
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-gray-500 py-4">
                                Nenhuma imagem na galeria.
                            </div>
                        @endif
                    </div>
                </div>
            </x-card>

            <x-modal wire:model="showMediaModal" title="Adicionar Novas Imagens" class="backdrop-blur">
                <div x-data="{
                    selectedFiles: [],
                    filePreviews: [],
                    isPrincipal: @entangle('isNewImagePrincipal'),
                    principalIndex: @entangle('principalImageIndex'),
                    handleFileChange(event) {
                        this.selectedFiles = Array.from(event.target.files);
                        this.filePreviews = [];
                        this.selectedFiles.forEach(file => {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                this.filePreviews.push(e.target.result);
                            };
                            reader.readAsDataURL(file);
                        });
                        // Reset principal selection if new files are added
                        this.isPrincipal = false;
                        this.principalIndex = null;
                    },
                    setAsPrincipal(index) {
                        if (this.principalIndex === index) {
                            this.isPrincipal = false;
                            this.principalIndex = null;
                        } else {
                            this.isPrincipal = true;
                            this.principalIndex = index;
                        }
                    },
                    // Função para enviar os arquivos para Livewire
                    uploadFiles() {
                        // Atribui os arquivos selecionados para as propriedades Livewire
                        // Se apenas 1 arquivo e marcado como principal, vai para newThumbnail
                        // Caso contrário, vai para newGalleryImages
                        if (this.selectedFiles.length === 1 && this.isPrincipal) {
                            @this.set('newThumbnail', this.selectedFiles[0]);
                            @this.set('newGalleryImages', []); // Garante que a galeria esteja vazia
                        } else {
                            @this.set('newThumbnail', null); // Garante que a thumbnail esteja vazia
                            @this.set('newGalleryImages', this.selectedFiles);
                            // Se houver uma principal entre as de galeria, Livewire vai lidar com isso
                            @this.set('principalImageIndex', this.principalIndex);
                        }
                        @this.call('saveMediaFromModal');
                    }
                }">
                    <div class="space-y-4">
                        <x-file label="Selecione as Imagens" x-ref="fileInput" @change="handleFileChange($event)"
                            multiple accept="image/png, image/jpeg"
                            hint="Selecione uma ou mais imagens para upload." />

                        <div x-show="filePreviews.length > 0"
                            class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 mt-4">
                            <template x-for="(preview, index) in filePreviews" :key="index">
                                <div class="relative group border rounded-lg overflow-hidden">
                                    <img :src="preview" class="w-full h-24 object-cover"
                                        alt="Pré-visualização da imagem" />
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button" @click="setAsPrincipal(index)"
                                            :class="{
                                                'btn btn-circle btn-sm btn-success': isPrincipal && principalIndex ===
                                                    index,
                                                'btn btn-circle btn-sm btn-ghost text-white': !isPrincipal ||
                                                    principalIndex !== index
                                            }"
                                            tooltip="Definir como Principal">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </div>
                                    <span x-show="isPrincipal && principalIndex === index"
                                        class="absolute top-1 left-1 badge badge-success text-white">Principal</span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <x-slot:actions>
                        <x-button label="Cancelar" @click="showMediaModal = false" />
                        <x-button label="Salvar Imagens" class="btn-primary" @click="uploadFiles()" />
                    </x-slot:actions>
                </div>
            </x-modal>
        </div> --}}

        {{-- Seção de Mídia --}}
        {{-- <x-card title="Mídia" shadow separator class="mt-5">
            <div x-data="{
                newlySelectedFiles: [],
                newlySelectedFilePreviews: [],
                principalNewImageIndex: @entangle('principalNewImageIndex').defer, // Sincroniza com a propriedade do componente Livewire
                
                handleNewFileChange(event) {
                    this.newlySelectedFiles = Array.from(event.target.files);
                    this.newlySelectedFilePreviews = [];
                    this.newlySelectedFiles.forEach(file => {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.newlySelectedFilePreviews.push(e.target.result);
                        };
                        reader.readAsDataURL(file);
                    });
                    // Reset principal selection if new files are added or if there's no new principal candidate
                    this.principalNewImageIndex = null; 
                    // Directly update the Livewire component property for new uploads
                    @this.set('newlyUploadedImages', this.newlySelectedFiles);
                },
                setNewAsPrincipal(index) {
                    if (this.principalNewImageIndex === index) {
                        this.principalNewImageIndex = null; // Deselect if already principal
                    } else {
                        this.principalNewImageIndex = index; // Set as new principal
                    }
                },
                isThisNewImagePrincipal(index) {
                    return this.principalNewImageIndex !== null && this.principalNewImageIndex === index;
                }
            }">
                <div class="grid grid-cols-1 gap-4">
                    <x-file label="Adicionar Novas Imagens" x-ref="newFileInput" @change="handleNewFileChange($event)" multiple accept="image/png, image/jpeg" hint="Arraste e solte ou clique para adicionar imagens. Uma delas pode ser definida como principal." />

                    <div class="border border-base-300 p-4 rounded-lg bg-base-100 shadow-sm mt-4">
                        <h5 class="text-lg font-semibold mb-3">Imagens do Imóvel</h5>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-2">
                            @if ($form->existingThumbnails->isNotEmpty())
                                @php $thumbnail = $form->existingThumbnails->first(); @endphp
                                <div class="relative group">
                                    <x-avatar :image="$thumbnail->getUrl('thumb')" class="!w-full !h-32 !rounded object-cover" />
                                    <span class="absolute top-2 left-2 badge badge-success text-white text-xs px-2 py-1">Principal</span>
                                    <x-button icon="o-trash" wire:click="removeMedia({{ $thumbnail->id }})" spinner class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" tooltip="Remover imagem" />
                                </div>
                            @endif

                            @foreach ($form->existingGalleryImages as $image)
                                <div class="relative group">
                                    <x-avatar :image="$image->getUrl('thumb')" class="!w-full !h-32 !rounded object-cover" />
                                    <x-button icon="o-trash" wire:click="removeMedia({{ $image->id }})" spinner class="absolute top-1 right-1 btn-ghost btn-xs text-error opacity-0 group-hover:opacity-100 transition-opacity" tooltip="Remover imagem" />
                                    <x-button icon="o-star" wire:click="setMediaAsPrincipal({{ $image->id }})" spinner class="absolute bottom-1 left-1 btn-ghost btn-xs text-warning opacity-0 group-hover:opacity-100 transition-opacity" tooltip="Definir como principal" />
                                </div>
                            @endforeach

                            <template x-for="(preview, index) in newlySelectedFilePreviews" :key="'new-image-' + index">
                                <div class="relative group border rounded-lg overflow-hidden">
                                    <img :src="preview" class="w-full h-24 object-cover" alt="Pré-visualização da imagem" />
                                    <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button type="button" @click="setNewAsPrincipal(index)"
                                            :class="{
                                                'btn btn-circle btn-sm btn-success': isThisNewImagePrincipal(index),
                                                'btn btn-circle btn-sm btn-ghost text-white': !isThisNewImagePrincipal(index)
                                            }"
                                            tooltip="Definir como Principal">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </div>
                                    <span x-show="isThisNewImagePrincipal(index)" class="absolute top-1 left-1 badge badge-success text-white text-xs px-2 py-1">Principal</span>
                                </div>
                            </template>
                        </div>
                        <div x-show="$wire.form.existingThumbnails.length === 0 && $wire.form.existingGalleryImages.length === 0 && newlySelectedFilePreviews.length === 0" class="text-center text-gray-500 py-4">
                            Nenhuma imagem adicionada ainda.
                        </div>
                    </div>

                    <x-input label="URL do Vídeo (Youtube/Vimeo)" wire:model="form.video_url" placeholder="https://youtu.be/..." />
                    <x-input label="URL do Tour Virtual" wire:model="form.virtual_tour_url" placeholder="https://..." />
                </div>
            </div>
        </x-card> --}}

        {{-- Seção de Comodidades --}}
        <x-card title="Comodidades" shadow separator class="mt-5">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @foreach ($amenityOptions as $value => $label)
                    <x-checkbox :label="$label" wire:model="form.amenities" value="{{ $value }}"
                        class="checkbox-primary" />
                @endforeach
            </div>
        </x-card>

        {{-- Botão de Submit --}}
        <div class="mt-5 flex justify-end gap-x-3">
            <x-button label="Cancelar" link="{{ route('admin.properties.index') }}" />
            <x-button label="Salvar" type="submit" icon="o-check" class="btn-primary" spinner="save" />
        </div>
    </x-form>
</div>
