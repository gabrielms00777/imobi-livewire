<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $tenant = app('tenant');
        $tenantSettings = $tenant->tenantSettings;

        if (!$tenantSettings) {
            abort(404, 'Configurações do site não encontradas para este tenant.');
        }

        $featuredProperties = Property::where('featured', true)
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
            'tenantSettings',
            'featuredProperties',
            'recentProperties',
            'tenant'
        ));
    }

    public function properties(Request $request)
    {
        $tenant = app('tenant'); // Assume que o tenant já está resolvido pelo middleware

        // Carrega as configurações do tenant
        $tenantSettings = $tenant->tenantSettings;

        if (!$tenantSettings) {
            abort(404, 'Configurações do site não encontradas para este tenant.');
        }

        // Mapeia os dados do tenantSettings para o formato do seu array demo $siteSettings
        $siteSettings = [
            'site_name' => $tenantSettings->site_name,
            'site_description' => $tenantSettings->site_description, // Adicionado
            'primary_color' => $tenantSettings->primary_color,
            'secondary_color' => $tenantSettings->secondary_color,
            'text_color' => $tenantSettings->text_color,
            'logo' => $tenantSettings->site_logo ? Storage::url($tenantSettings->site_logo) : null,
            'show_logo_and_name' => $tenantSettings->show_logo_and_name,
            'favicon' => $tenantSettings->site_favicon ? Storage::url($tenantSettings->site_favicon) : null,
            // Adicione outras configurações do seu TenantSetting que sejam relevantes para o frontend
            'engagement_title' => $tenantSettings->engagement_title,
            'engagement_description' => $tenantSettings->engagement_description,
            'engagement_metrics_json' => $tenantSettings->engagement_metrics_json,
            'engagement_btn_properties_text' => $tenantSettings->engagement_btn_properties_text,
            'engagement_btn_properties_icon' => $tenantSettings->engagement_btn_properties_icon,
            'engagement_btn_properties_link' => $tenantSettings->engagement_btn_properties_link,
            'engagement_btn_contact_text' => $tenantSettings->engagement_btn_contact_text,
            'engagement_btn_contact_icon' => $tenantSettings->engagement_btn_contact_icon,
            'engagement_btn_contact_link' => $tenantSettings->engagement_btn_contact_link,
        ];

        // Dados de contato (assumindo que vêm de TenantSettings ou de outro lugar)
        // Se estes dados estão em TenantSettings, você precisará adicioná-los ao modelo e ao formulário de TenantSettings.
        // Por agora, vou adicioná-los como exemplo, assumindo que eles existem ou podem ser estáticos se não houver no DB.
        $contactInfo = [
            'phone' => $tenantSettings->phone ?? '(XX) XXXXX-XXXX', // Exemplo
            'whatsapp' => $tenantSettings->whatsapp ?? '55XXYYYYYYYYY', // Exemplo
            'email' => $tenantSettings->email ?? 'contato@seusite.com', // Exemplo
            'address' => $tenantSettings->address ?? 'Endereço da Imobiliária', // Exemplo
            'social_media' => [
                'facebook' => $tenantSettings->facebook_url ?? '#',
                'instagram' => $tenantSettings->instagram_url ?? '#',
                'linkedin' => $tenantSettings->linkedin_url ?? '#',
                // Adicione outras redes sociais conforme necessário
            ]
        ];


        // Inicia a query de imóveis
        $propertiesQuery = Property::query()
            ->with('media') // Carrega as mídias (imagens) relacionadas
            ->where('status', 'disponivel'); // Apenas imóveis disponíveis para o público

        // Aplica o filtro de tenant
        if ($tenant instanceof Company) {
            $propertiesQuery->where('company_id', $tenant->id);
        } elseif ($tenant instanceof User) {
            $propertiesQuery->where('user_id', $tenant->id);
        }

        // === Aplicação dos filtros da requisição (adaptado do seu demo) ===

        // Filtro por busca (título, descrição, endereço, cidade, bairro, estado, tipo)
        if ($search = $request->input('search')) {
            $propertiesQuery->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('street', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('neighborhood', 'like', "%{$search}%")
                    ->orWhere('state', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }

        // Filtro por localização (cidade, bairro, estado) - Pode ser mesclado com a busca geral se o "search" já cobre
        if ($location = $request->input('location')) {
            $propertiesQuery->where(function ($query) use ($location) {
                $query->where('city', 'like', "%{$location}%")
                    ->orWhere('neighborhood', 'like', "%{$location}%")
                    ->orWhere('state', 'like', "%{$location}%")
                    ->orWhere('street', 'like', "%{$location}%"); // Incluindo rua aqui também
            });
        }

        // Filtro por tipo
        if ($type = $request->input('type')) {
            $propertiesQuery->where('type', $type);
        }

        // Filtro por quartos (bedrooms)
        if ($bedrooms = $request->input('bedrooms')) {
            $propertiesQuery->where('bedrooms', '>=', (int) $bedrooms);
        }

        // Filtro por banheiros (bathrooms)
        if ($bathrooms = $request->input('bathrooms')) {
            $propertiesQuery->where('bathrooms', '>=', (int) $bathrooms);
        }

        // Filtro por suítes
        if ($suites = $request->input('suites')) {
            $propertiesQuery->where('suites', '>=', (int) $suites);
        }

        // Filtro por vagas de garagem (garage_spaces)
        if ($parking = $request->input('parking')) {
            $propertiesQuery->where('garage_spaces', '>=', (int) $parking);
        }

        // Filtro por preço
        if ($minPrice = $request->input('min_price')) {
            $propertiesQuery->where('price', '>=', (float) $minPrice);
        }
        if ($maxPrice = $request->input('max_price')) {
            $propertiesQuery->where('price', '<=', (float) $maxPrice);
        }

        // Filtro por área total (total_area)
        if ($minArea = $request->input('min_area')) {
            $propertiesQuery->where('total_area', '>=', (float) $minArea);
        }
        if ($maxArea = $request->input('max_area')) {
            $propertiesQuery->where('total_area', '<=', (float) $maxArea);
        }

        // Filtro por área construída (construction_area)
        if ($minConstructionArea = $request->input('min_construction_area')) {
            $propertiesQuery->where('construction_area', '>=', (float) $minConstructionArea);
        }
        if ($maxConstructionArea = $request->input('max_construction_area')) {
            $propertiesQuery->where('construction_area', '<=', (float) $maxConstructionArea);
        }

        // Filtro por andares (floors)
        if ($floors = $request->input('floors')) {
            $propertiesQuery->where('floors', '>=', (int) $floors);
        }

        // Filtro por ano de construção (year_built)
        if ($minYearBuilt = $request->input('min_year_built')) {
            $propertiesQuery->where('year_built', '>=', (int) $minYearBuilt);
        }
        if ($maxYearBuilt = $request->input('max_year_built')) {
            $propertiesQuery->where('year_built', '<=', (int) $maxYearBuilt);
        }

        // Filtro por características (amenities) - Assumindo JSON array na coluna 'amenities'
        if ($amenities = $request->input('amenities')) {
            if (is_array($amenities) && !empty($amenities)) {
                foreach ($amenities as $amenity) {
                    $propertiesQuery->whereJsonContains('amenities', $amenity);
                }
            }
        }


        // === Ordenação ===
        $sortBy = $request->input('sort_by', 'recent'); // Default para 'recent'
        switch ($sortBy) {
            case 'price-asc':
                $propertiesQuery->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $propertiesQuery->orderBy('price', 'desc');
                break;
            case 'popular':
                // Para popular, você pode ordenar por 'featured' primeiro, depois 'created_at'
                $propertiesQuery->orderBy('featured', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'recent':
            default:
                // Para 'recent', pode ordenar por 'featured' (se houver um indicador de 'novo' ou 'destaque')
                // e depois por data de criação.
                $propertiesQuery->orderBy('featured', 'desc')->orderBy('created_at', 'desc');
                break;
        }

        // === Paginação ===
        $perPage = 6; // Ou use $request->input('per_page', 6);
        $properties = $propertiesQuery->paginate($perPage)->withQueryString();

        // dd($properties);

        // Passa os filtros atuais para a view para preencher os campos do formulário
        // $filters = $request->all();
        $filters = array_merge($request->all(), [
            'search' => $request->input('search'),
            'location' => $request->input('location'),
            'type' => $request->input('type'),
            'bedrooms' => $request->input('bedrooms', 0),
            'bathrooms' => $request->input('bathrooms', 0),
            'parking' => $request->input('parking', 0),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'min_area' => $request->input('min_area'),
            'max_area' => $request->input('max_area'),
            'features' => $request->input('features', []),
            'amenities' => $request->input('amenities', []),
        ]);

        // dd($filters);

        // Tipos de imóveis para o dropdown (busque do seu modelo Property, ou defina estaticamente)
        // Se você tem um enum ou uma lista fixa, pode fazer assim:
        $propertyTypes = Property::select('type')->distinct()->pluck('type')->toArray();
        // Ou, se você tem uma lista predefinida:
        // $propertyTypes = ['casa', 'apartamento', 'terreno', 'comercial', 'sitio/chacara', 'galpao', 'outro'];

        // Seus dados de TenantSettings já estão no formato esperado para $siteSettings.

        $totalProperties = $properties->total(); // Total de imóveis encontrados
        $totalPages = $properties->lastPage(); // Total de páginas

        $amenityOptions = [
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

        return view('home.properties', compact(
            'siteSettings',
            'tenantSettings',
            'tenant',
            'contactInfo',
            'properties',
            'filters',
            'propertyTypes',
            'sortBy', // Passa o sortBy atual para a view
            'totalProperties',
            'totalPages',
            'amenityOptions'
        ));
    }
    // public function properties(Request $request)
    // {
    //     $tenant = app('tenant');
    //     $tenantSettings = $tenant->tenantSettings;

    //     if (!$tenantSettings) {
    //         abort(404, 'Configurações do site não encontradas para este tenant.');
    //     }

    //     // Se for requisição AJAX (filtros)
    //     if ($request->ajax()) {
    //         $properties = $this->filterProperties($request);
    //         return response()->json([
    //             'properties' => $properties,
    //             'html' => view('partials.property-list', compact('properties'))->render()
    //         ]);
    //     }

    //     // Carrega todos os imóveis inicialmente
    //     $properties = Property::where('company_id', $tenant->id)
    //         ->where('status', 'available')
    //         ->orderBy('is_featured', 'desc')
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(12);

    //     return view('home.properties', compact(
    //         'tenantSettings',
    //         'tenant',
    //         'properties'
    //     ));
    // }

    public function property($tenantSlug, $slug)
    {
        $tenant = app('tenant');

        $tenantSettings = $tenant->tenantSettings;

        if (!$tenantSettings) {
            abort(404, 'Configurações do site não encontradas para este tenant.');
        }

        $properties = Property::query()
            ->with('media') // Carrega as mídias (imagens) relacionadas
            ->where('status', 'disponivel'); // Apenas imóveis disponíveis para o público

        if ($tenant instanceof Company) {
            $properties->where('company_id', $tenant->id);
        } elseif ($tenant instanceof User) {
            $properties->where('user_id', $tenant->id);
        }

        $property = Property::query()->where('slug', $slug)->with('media')->firstOrFail();
        $properties = $properties->where('id', '!=', $property->id)->inRandomOrder()->limit(3)-> get();

        if ($tenant instanceof Company && $property->company_id !== $tenant->id) {
            abort(404, 'Imóvel não encontrado para este usuario.');
        }

        if ($tenant instanceof User && $property->user_id !== $tenant->id) {
            abort(404, 'Imóvel não encontrado para este corretor.');
        }
        // dd($property, $properties);

        return view('home.property-details', compact(
            'tenantSettings',
            'property',
            'tenant',
            'properties'
        ));
    }

    private function filterProperties(Request $request)
    {
        $query = Property::query()->where('company_id', app('tenant')->id);

        // Filtros
        if ($request->has('property_type')) {
            $query->where('property_type', $request->property_type);
        }

        if ($request->has('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }

        if ($request->has('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }

        if ($request->has('min_area')) {
            $query->where('area', '>=', $request->min_area);
        }

        if ($request->has('order_by')) {
            $order = explode(':', $request->order_by);
            $query->orderBy($order[0], $order[1]);
        } else {
            $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
        }

        return $query->paginate(12);
    }
}
