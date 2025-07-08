@foreach($properties as $property)
<div class="property-card card card-side bg-base-100 shadow-md hover:shadow-xl transition-all duration-300 mb-6">
    <figure class="w-full md:w-80 shrink-0">
        <img src="{{ $property->main_image_url ?? '/placeholder-property.jpg' }}" 
             alt="{{ $property->title }}" 
             class="h-full w-full object-cover">
        @if($property->is_featured)
            <span class="badge badge-primary absolute top-4 right-4">Destaque</span>
        @endif
    </figure>
    <div class="card-body">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="card-title">{{ $property->title }}</h2>
                <div class="flex items-center text-sm text-gray-500 mb-2">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span>{{ $property->address }}, {{ $property->city }}/{{ $property->state }}</span>
                </div>
            </div>
            <div class="text-2xl font-bold text-primary">R$ {{ number_format($property->price, 2, ',', '.') }}</div>
        </div>

        <div class="flex flex-wrap gap-4 mb-4">
            @if($property->bedrooms)
                <div class="flex items-center">
                    <i class="fas fa-bed mr-2 text-primary"></i>
                    <span>{{ $property->bedrooms }} Quarto(s)</span>
                </div>
            @endif
            
            @if($property->bathrooms)
                <div class="flex items-center">
                    <i class="fas fa-bath mr-2 text-primary"></i>
                    <span>{{ $property->bathrooms }} Banheiro(s)</span>
                </div>
            @endif
            
            @if($property->area)
                <div class="flex items-center">
                    <i class="fas fa-ruler-combined mr-2 text-primary"></i>
                    <span>{{ $property->area }} m²</span>
                </div>
            @endif
            
            @if($property->garage_spaces)
                <div class="flex items-center">
                    <i class="fas fa-car mr-2 text-primary"></i>
                    <span>{{ $property->garage_spaces }} Vaga(s)</span>
                </div>
            @endif
        </div>

        <p class="mb-4 line-clamp-2">{{ $property->description }}</p>

        <div class="card-actions justify-end">
            {{-- <a href="{{ route('property.show', $property->id) }}" class="btn btn-primary"> --}}
            <a class="btn btn-primary">
                <i class="fas fa-eye mr-2"></i> Ver Detalhes
            </a>
        </div>
    </div>
</div>
@endforeach

@if($properties->hasPages())
<div class="join grid grid-cols-2 md:flex justify-center mt-10">
    @if($properties->previousPageUrl())
        <button class="join-item btn btn-outline" 
                @click="loadPage('{{ $properties->previousPageUrl() }}')">Anterior</button>
    @endif
    
    @foreach(range(1, $properties->lastPage()) as $page)
        <button class="join-item btn {{ $properties->currentPage() == $page ? 'btn-active' : 'btn-outline' }}" 
                @click="loadPage('{{ $properties->url($page) }}')">{{ $page }}</button>
    @endforeach
    
    @if($properties->nextPageUrl())
        <button class="join-item btn btn-outline" 
                @click="loadPage('{{ $properties->nextPageUrl() }}')">Próxima</button>
    @endif
</div>
@endif