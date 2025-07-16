<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $tenant = app('tenant');
        // dd($tenant);
        $tenantSettings = $tenant->tenantSettings;

        if (!$tenantSettings) {
            abort(404, 'Configurações do site não encontradas para este tenant.');
        }

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
            'tenantSettings',
            'featuredProperties',
            'recentProperties',
            'tenant'
        ));
    }

    public function properties(Request $request)
    {
        $tenant = app('tenant');
        $tenantSettings = $tenant->tenantSettings;

        if (!$tenantSettings) {
            abort(404, 'Configurações do site não encontradas para este tenant.');
        }

        // Se for requisição AJAX (filtros)
        if ($request->ajax()) {
            $properties = $this->filterProperties($request);
            return response()->json([
                'properties' => $properties,
                'html' => view('partials.property-list', compact('properties'))->render()
            ]);
        }

        // Carrega todos os imóveis inicialmente
        $properties = Property::where('company_id', $tenant->id)
            ->where('status', 'available')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('home.properties', compact(
            'tenantSettings',
            'tenant',
            'properties'
        ));
    }

    public function property($tenantSlug, $id)
    {
        $tenant = app('tenant');

        $tenantSettings = $tenant->tenantSettings;

        if (!$tenantSettings) {
            abort(404, 'Configurações do site não encontradas para este tenant.');
        }

        // $property = Property::query()->where('slug', $slug)->firstOrFail();
        $property = Property::query()->findOrFail($id);

        if ($tenant instanceof Company && $property->company_id !== $tenant->id) {
            abort(404, 'Imóvel não encontrado para este usuario.');
        }

        if ($tenant instanceof User && $property->user_id !== $tenant->id) {
            abort(404, 'Imóvel não encontrado para este corretor.');
        }

        $propertyImages = [
            $property->main_image_url ?? 'https://via.placeholder.com/1200x800?text=Imagem+Principal+Padrao', // Sua imagem principal
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', // Imagem de exemplo 1
            'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', // Imagem de exemplo 2
            'https://images.unsplash.com/photo-1580216643062-cf460548a66a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', // Imagem de exemplo 3
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', // Imagem de exemplo 1
            'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', // Imagem de exemplo 2
            'https://images.unsplash.com/photo-1580216643062-cf460548a66a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80', // Imagem de exemplo 3
        ];

        // dd($tenantSettings, $property, $tenant);

        return view('home.property-details', compact(
            'tenantSettings',
            'property',
            'tenant',
            'propertyImages'
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
