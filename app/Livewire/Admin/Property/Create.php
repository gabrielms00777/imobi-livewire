<?php

namespace App\Livewire\Admin\Property;

use App\Livewire\Forms\Admin\PropertyForm; // Importa o Form Object
use App\Models\Property; // Pode ser necessário se você manipular o modelo diretamente aqui
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
// use Livewire\WithFileUploads; // Removido daqui, agora está no PropertyForm

class Create extends Component
{
    use Toast, WithFileUploads; // Habilita o uso de toasts/notificações da MaryUI

    public PropertyForm $form; // Declara a propriedade do formulário

    // Opções para selects e checkboxes (ainda podem ser inicializadas aqui)
    public array $typeOptions;
    public array $purposeOptions;
    public array $statusOptions;
    public array $amenityOptions;
    public array $stateOptions;

    // public bool $showMediaModal = false;

    // Propriedades para lidar com novos uploads de arquivos temporários
    public array $newlyUploadedImages = []; // Array para as novas imagens temporárias
    public ?int $principalNewImageIndex = null; // Índice da nova imagem que será principal (baseado no array newlyUploadedImages)

    /**
     * O método mount é executado quando o componente é inicializado.
     * Aqui, vamos inicializar as opções dos selects.
     */
    public function mount(): void
    {
        // Inicializa as opções dos selects/checkboxes
        $this->typeOptions = [
            ['id' => 'casa', 'name' => 'Casa'],
            ['id' => 'apartamento', 'name' => 'Apartamento'],
            ['id' => 'terreno', 'name' => 'Terreno'],
            ['id' => 'comercial', 'name' => 'Comercial'],
            ['id' => 'outro', 'name' => 'Outro']
        ];
        $this->purposeOptions = [
            ['id' => 'venda', 'name' => 'Venda'],
            ['id' => 'aluguel', 'name' => 'Aluguel'],
            ['id' => 'ambos', 'name' => 'Venda e Aluguel']
        ];
        $this->statusOptions = [
            ['id' => 'rascunho', 'name' => 'Rascunho'],
            ['id' => 'disponivel    ', 'name' => 'Disponível'],
            ['id' => 'vendido', 'name' => 'Vendido'],
            ['id' => 'alugado', 'name' => 'Alugado']
        ];
        $this->amenityOptions = [
            'Piscina' => 'Piscina',
            'Churrasqueira' => 'Churrasqueira',
            'Sacada' => 'Sacada',
            'Academia' => 'Academia',
            'Playground' => 'Playground',
            'Portaria 24h' => 'Portaria 24h',
            'Mobiliado' => 'Mobiliado',
            'Ar Condicionado' => 'Ar Condicionado',
            'Elevador' => 'Elevador',
            'Lareira' => 'Lareira',
            'Jardim' => 'Jardim',
            'Área de Serviço' => 'Área de Serviço',
            'Quadra Esportiva' => 'Quadra Esportiva',
            'Salão de Festas' => 'Salão de Festas',
            'Sauna' => 'Sauna',
            'Varanda Gourmet' => 'Varanda Gourmet',
        ];
        $this->stateOptions = [
            ['id' => 'AC', 'name' => 'Acre'],
            ['id' => 'AL', 'name' => 'Alagoas'],
            ['id' => 'AP', 'name' => 'Amapá'],
            ['id' => 'AM', 'name' => 'Amazonas'],
            ['id' => 'BA', 'name' => 'Bahia'],
            ['id' => 'CE', 'name' => 'Ceará'],
            ['id' => 'DF', 'name' => 'Distrito Federal'],
            ['id' => 'ES', 'name' => 'Espírito Santo'],
            ['id' => 'GO', 'name' => 'Goiás'],
            ['id' => 'MA', 'name' => 'Maranhão'],
            ['id' => 'MT', 'name' => 'Mato Grosso'],
            ['id' => 'MS', 'name' => 'Mato Grosso do Sul'],
            ['id' => 'MG', 'name' => 'Minas Gerais'],
            ['id' => 'PA', 'name' => 'Pará'],
            ['id' => 'PB', 'name' => 'Paraíba'],
            ['id' => 'PR', 'name' => 'Paraná'],
            ['id' => 'PE', 'name' => 'Pernambuco'],
            ['id' => 'PI', 'name' => 'Piauí'],
            ['id' => 'RJ', 'name' => 'Rio de Janeiro'],
            ['id' => 'RN', 'name' => 'Rio Grande do Norte'],
            ['id' => 'RS', 'name' => 'Rio Grande do Sul'],
            ['id' => 'RO', 'name' => 'Rondônia'],
            ['id' => 'RR', 'name' => 'Roraima'],
            ['id' => 'SC', 'name' => 'Santa Catarina'],
            ['id' => 'SP', 'name' => 'São Paulo'],
            ['id' => 'SE', 'name' => 'Sergipe'],
            ['id' => 'TO', 'name' => 'Tocantins'],
        ];

        // Se este componente fosse para edição, você faria:
        // $property = Property::findOrFail($id);
        // $this->form->setForProperty($property);

        // Inicialize o Form Object (seus valores padrão já serão aplicados)
        $this->form->title = 'Teste'; // Limpa defaults se necessário ou confie nos defaults do form object
        $this->form->description = 'Descrição do imóvel';
        $this->form->type = 'casa';
        $this->form->purpose = 'ambos';
        $this->form->status = 'disponivel';
        $this->form->price = 100000;
        $this->form->rent_price = 10000;
        $this->form->bedrooms = 2;
        $this->form->bathrooms = 2;
        $this->form->suites = 2;
        $this->form->garage_spaces = 1;
        $this->form->area = 300;
        // $this->form->total_area = 350;
        // $this->form->construction_area = null;
        // $this->form->floors = null;
        // $this->form->year_built = null;
        $this->form->street = 'Rua Teste';
        $this->form->number = '321';
        $this->form->complement = 'Casa';
        $this->form->neighborhood = 'Teste Bairro';
        $this->form->city = 'Ribeirão Preto';
        $this->form->state = 'SP';
        $this->form->zip_code = '14050090';
        // $this->form->latitude = null;
        // $this->form->longitude = null;
        $this->form->featured = false;
        // $this->form->video_url = null;
        // $this->form->virtual_tour_url = null;
        $this->form->amenities = [];
        $this->form->existingThumbnails = collect(); // Inicializa como coleção vazia
        $this->form->existingGalleryImages = []; // Inicializa como coleção vazia
    }
    public function save(): void
    {
        try {
            $property = $this->form->save(); // Salva os dados básicos do imóvel

            // Lidar com novas imagens temporárias (se houver)
            if (!empty($this->newlyUploadedImages)) {
                $principalFile = null;
                $galleryFiles = [];

                // Identifica qual arquivo, se houver, será a nova miniatura principal
                if ($this->principalNewImageIndex !== null && isset($this->newlyUploadedImages[$this->principalNewImageIndex])) {
                    $principalFile = $this->newlyUploadedImages[$this->principalNewImageIndex];
                }

                // Processa a nova imagem principal
                if ($principalFile) {
                    // Remove a miniatura antiga se existir (para o caso de edição)
                    // Como este é um 'Create', não deveria ter miniatura antiga, mas é uma boa prática
                    if ($property->getFirstMedia('thumbnails')) {
                        $property->getFirstMedia('thumbnails')->delete();
                    }
                    $property->addMedia($principalFile)->toMediaCollection('thumbnails');
                }

                // Adiciona as demais imagens à galeria
                foreach ($this->newlyUploadedImages as $index => $file) {
                    // Se o arquivo não é o principal ou se não há um principal definido
                    if ($index !== $this->principalNewImageIndex) {
                        $property->addMedia($file)->toMediaCollection('gallery');
                    }
                }
            }

            $this->success('Imóvel cadastrado com sucesso!', redirectTo: route('admin.properties.index'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Houve um erro na validação. Verifique os campos.');
        } catch (\Exception $e) {
            $this->error('Ocorreu um erro ao salvar: ' . $e->getMessage());
            Log::error('Erro ao salvar imóvel: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Define uma imagem existente como principal.
     * @param int $mediaId
     * @return void
     */
    public function setMediaAsPrincipal(int $mediaId): void
    {
        if ($this->form->property) {
            try {
                $media = $this->form->property->media()->find($mediaId);
                if ($media) {
                    // Remove a miniatura atual, se houver
                    if ($this->form->property->getFirstMedia('thumbnails')) {
                        $this->form->property->getFirstMedia('thumbnails')->delete();
                    }
                    // Move a imagem da galeria para a coleção de miniaturas
                    $media->move('thumbnails');
                    $this->form->loadExistingMedia(); // Recarrega as mídias para atualizar a UI
                    $this->success('Imagem definida como principal com sucesso!');
                }
            } catch (\Exception $e) {
                $this->error('Erro ao definir imagem como principal: ' . $e->getMessage());
                Log::error('Erro ao definir imagem como principal: ' . $e->getMessage(), ['exception' => $e]);
            }
        } else {
            $this->error('Erro: Propriedade não carregada.');
        }
    }

    /**
     * Remove uma imagem (seja miniatura ou da galeria).
     * @param int $mediaId
     * @return void
     */
    public function removeMedia(int $mediaId): void
    {
        if ($this->form->property) {
            try {
                $media = $this->form->property->media()->find($mediaId);
                if ($media) {
                    $media->delete();
                    $this->form->loadExistingMedia(); // Recarrega as mídias para atualizar a UI
                    $this->success('Imagem removida com sucesso!');
                }
            } catch (\Exception $e) {
                $this->error('Erro ao remover imagem: ' . $e->getMessage());
                Log::error('Erro ao remover imagem: ' . $e->getMessage(), ['exception' => $e]);
            }
        } else {
            $this->error('Erro: Propriedade não carregada.');
        }
    }


    // public function save(): void
    // {
    //     $property = $this->form->save(); // Chama o método save do Form Object

    //     $this->success('Imóvel cadastrado com sucesso!', redirectTo: route('admin.properties.index'));
    //     try {
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         $this->error('Houve um erro na validação. Verifique os campos.');
    //         // O Livewire automaticamente exibirá os erros de validação ao lado dos campos.
    //         Log::error('Erro de validação ao salvar imóvel: ' . $e->getMessage(), ['errors' => $e->errors()]);
    //     } catch (\Exception $e) {
    //         $this->error('Ocorreu um erro ao salvar: ' . $e->getMessage());
    //         Log::error('Erro geral ao salvar imóvel: ' . $e->getMessage(), ['exception' => $e]);
    //     }
    // }

    public function openMediaModal(): void
    {
        $this->form->reset(['newThumbnail', 'newGalleryImages', 'isNewImagePrincipal', 'principalImageIndex']);
        $this->showMediaModal = true;
    }

    public function closeMediaModal(): void
    {
        $this->showMediaModal = false;
        $this->form->reset(['newThumbnail', 'newGalleryImages', 'isNewImagePrincipal', 'principalImageIndex']); // Limpa uploads temporários ao fechar
    }

    public function saveNewMediaFromModal(): void
    {
        try {
            // A validação 'newGalleryImages.*' também é executada aqui pelo Livewire
            // antes de passar os arquivos para o Form Object se estiver no rules() do Form Object.
            // Se preferir validação específica de upload aqui:
            $this->validate([
                'form.newThumbnail' => 'nullable|image|max:2048',
                'form.newGalleryImages.*' => 'nullable|image|max:2048',
            ]);

            // Se o imóvel ainda não existe, salva o imóvel primeiro
            if (!$this->form->property || !$this->form->property->exists) {
                // Valida e salva os dados básicos do imóvel primeiro
                $this->form->validate();
                $this->form->save(); // Isso vai criar o imóvel e anexá-lo ao $this->form->property
            }

            // Agora que o imóvel existe (ou foi criado), o método save() do Form Object
            // pode lidar com o upload das mídias.
            $this->form->save(); // O método save() do form agora lida com os uploads de mídia

            $this->success('Mídia adicionada com sucesso!', position: 'toast-top');
            $this->closeMediaModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Erro de validação ao adicionar mídia. Verifique os campos.', position: 'toast-top');
            // Os erros serão exibidos automaticamente ao lado dos campos do formulário
        } catch (\Exception $e) {
            $this->error('Ocorreu um erro ao adicionar mídia: ' . $e->getMessage(), position: 'toast-top');
            Log::error('Erro ao adicionar mídia no componente Create: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    // public function removeMedia(int $mediaId): void
    // {
    //     try {
    //         $this->form->removeMedia($mediaId);
    //         $this->success('Imagem removida com sucesso!', position: 'toast-top');
    //     } catch (\Exception $e) {
    //         $this->error('Erro ao remover imagem: ' . $e->getMessage(), position: 'toast-top');
    //         Log::error('Erro ao remover imagem no componente Create: ' . $e->getMessage(), ['media_id' => $mediaId, 'exception' => $e]);
    //     }
    // }

    // public function setMediaAsPrincipal(int $mediaId): void
    // {
    //     try {
    //         $this->form->setMediaAsPrincipal($mediaId);
    //         $this->success('Imagem definida como principal!', position: 'toast-top');
    //     } catch (\Exception $e) {
    //         $this->error('Erro ao definir imagem como principal: ' . $e->getMessage(), position: 'toast-top');
    //         Log::error('Erro ao definir imagem principal no componente Create: ' . $e->getMessage(), ['media_id' => $mediaId, 'exception' => $e]);
    //     }
    // }

    public function removeGalleryImage(int $mediaId): void
    {
        // Certifica-se de que a propriedade está carregada no formulário
        if ($this->form->property) {
            try {
                $media = $this->form->property->getMedia('gallery')->find($mediaId);
                if ($media) {
                    $media->delete();
                    // Atualiza o array de imagens existentes no formulário para a UI
                    $this->form->existingGalleryImages = array_filter($this->form->existingGalleryImages, fn($image) => $image['id'] !== $mediaId);
                    $this->success('Imagem da galeria removida com sucesso!');
                }
            } catch (\Exception $e) {
                $this->error('Erro ao remover imagem da galeria: ' . $e->getMessage());
                Log::error('Erro ao remover imagem da galeria: ' . $e->getMessage(), ['exception' => $e]);
            }
        } else {
            $this->error('Erro: Propriedade não carregada.');
        }
    }

    public function removeThumbnail(): void
    {
        // Certifica-se de que a propriedade está carregada no formulário
        if ($this->form->property) {
            try {
                $media = $this->form->property->getFirstMedia('thumbnails');
                if ($media) {
                    $media->delete();
                    $this->form->existingThumbnailUrl = null; // Limpa a URL existente no formulário para a UI
                    $this->success('Miniatura removida com sucesso!');
                }
            } catch (\Exception $e) {
                $this->error('Erro ao remover miniatura: ' . $e->getMessage());
                Log::error('Erro ao remover miniatura: ' . $e->getMessage(), ['exception' => $e]);
            }
        } else {
            $this->error('Erro: Propriedade não carregada.');
        }
    }

    public function render()
    {
        return view('livewire.admin.property.create');
    }
}
