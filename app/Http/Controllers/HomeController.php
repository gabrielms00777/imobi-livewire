<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

/*************  ✨ Windsurf Command ⭐  *************/
    /**
     * Display the landing page view.
     *
     * @return \Illuminate\Contracts\View\View
     */

/*******  fad8b802-46e7-4831-a317-fc441a714007  *******/
    public function landing()
    {
        return view('home.landing');
    }

    public function index()
    {
        // Pega o tenant que foi definido pelo middleware
        $tenant = app('tenant');
        
        // Pega as configurações específicas deste tenant
        // A relação tenantSettings já deve estar carregada pelo middleware
        $tenantSettings = $tenant->tenantSettings;
        // dd($tenantSettings);

        // Se por algum motivo o tenant não tiver configurações personalizadas,
        // você pode carregar um fallback ou criar uma na hora.
        if (!$tenantSettings) {
             // Redirecione ou mostre uma mensagem de erro, ou crie uma configuração padrão.
             // Ex: TenantSetting::createDefaultFor($tenant);
             abort(404, 'Configurações do site não encontradas para este tenant.');
        }

        // Buscar imóveis relacionados SOMENTE a este tenant
        $featuredProperties = Property::where('is_featured', true)
            ->when($tenant instanceof Company, function ($query) use ($tenant) {
                return $query->where('company_id', $tenant->id);
            })
            ->when($tenant instanceof User, function ($query) use ($tenant) {
                return $query->where('user_id', $tenant->id);
            })
            ->take(4)
            ->get();

        $recentProperties = Property::orderBy('created_at', 'desc')
            ->when($tenant instanceof Company, function ($query) use ($tenant) {
                return $query->where('company_id', $tenant->id);
            })
            ->when($tenant instanceof User, function ($query) use ($tenant) {
                return $query->where('user_id', $tenant->id);
            })
            ->take(4)
            ->get();

        
            // dd($tenantSettings, $featuredProperties, $recentProperties, $tenant);


        return view('home.index', compact(
            'tenantSettings', // Agora passamos 'tenantSettings' em vez de 'siteSettings'
            'featuredProperties',
            'recentProperties',
            'tenant' // Você pode precisar passar o próprio tenant também
        ));
    }

    public function properties()
    {
        return view('home.properties');
    }

    public function property()
    {
        return view('home.property');
    }
}
