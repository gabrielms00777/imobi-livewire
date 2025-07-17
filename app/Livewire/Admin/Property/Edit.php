<?php

// Exemplo de como seria o Edit.php
namespace App\Livewire\Admin\Property;

use App\Livewire\Forms\Admin\PropertyForm;
use App\Models\Property;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use Toast, WithFileUploads;

    public PropertyForm $form;
    public Property $property; // A instância do imóvel que está sendo editada

    // Opções para selects (podem permanecer aqui ou ser movidas para o Form Object)
    public array $stateOptions = [];
    public array $typeOptions = [];
    public array $purposeOptions = [];
    public array $statusOptions = [];
    public array $amenityOptions = [];

    public function mount(Property $property): void
    {
        $this->property = $property; // Define a propriedade local
        $this->form->setProperty($property); // Carrega os dados no Form Object

        // Carregar opções (assim como no Create.php)
        $this->stateOptions = [ /* ... */ ];
        $this->typeOptions = [ /* ... */ ]; // Incluindo os novos tipos
        $this->purposeOptions = [ /* ... */ ];
        $this->statusOptions = [ /* ... */ ];
        $this->amenityOptions = [ /* ... */ ];
    }

    public function save(): void
    {
        try {
            $property = $this->form->save(); // O Form Object já sabe se é para criar ou atualizar

            $this->success('Imóvel atualizado com sucesso!', redirectTo: route('admin.properties.index'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Houve um erro na validação. Verifique os campos.');
        } catch (\Exception $e) {
            $this->error('Ocorreu um erro ao salvar: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.property.edit');
    }
}