<?php

namespace App\Livewire\Admin\TenantSettings;

use App\Livewire\Forms\TenantSettingsForm;
use App\Models\TenantSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast; // Habilita o uso de toasts/notificações da MaryUI

    public TenantSettingsForm $form;

    public string $tab = 'general'; // Para controlar a aba ativa

    /**
     * O método mount é executado quando o componente é inicializado.
     * Aqui, vamos obter as configurações do tenant logado.
     */
    public function mount(): void
    {
        // Obtém o tenant logado do container de serviços (definido pelo middleware SetTenant)
        $tenant = Auth::user();
        // dd($tenant);

        if (!$tenant) {
            // Isso não deveria acontecer se o middleware SetTenant estiver funcionando corretamente
            // e as rotas estiverem protegidas.
            $this->error('Erro: Tenant não identificado. Por favor, faça login novamente.');
            return;
        }

        // Tenta encontrar as configurações existentes para este tenant
        $tenantSetting = TenantSetting::firstOrNew([
            'configurable_id' => $tenant->id,
            'configurable_type' => get_class($tenant)
        ]);

        // Se for um novo registro e não tiver nome, use o nome do tenant
        if (!$tenantSetting->exists && empty($tenantSetting->site_name)) {
            $tenantSetting->site_name = $tenant->name;
        }

        // Popula o formulário com os dados do TenantSetting
        $this->form->setTenantSetting($tenantSetting);
    }

    /**
     * Salva as configurações do Tenant.
     */
    public function save(): void
    {
        try {
            $this->form->save(); // Chama o método save do Form Object

            $this->success('Configurações salvas com sucesso!', redirectTo: route('admin.tenant-settings.index'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->error('Houve um erro na validação. Verifique os campos.');
            // O Livewire automaticamente exibirá os erros de validação ao lado dos campos.
        } catch (\Exception $e) {
            $this->error('Ocorreu um erro ao salvar: ' . $e->getMessage());
            Log::error('Erro ao salvar tenant settings: ' . $e->getMessage(), ['exception' => $e]);
        }
    }

    /**
     * Renderiza a view do componente.
     */
    public function render()
    {
        return view('livewire.admin.tenant-settings.index');
    }
}
