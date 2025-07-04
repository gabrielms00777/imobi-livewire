<?php

namespace Database\Factories;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['casa', 'apartamento', 'terreno', 'comercial'];
        $purposes = ['venda', 'aluguel', 'ambos'];
        $statuses = ['rascunho', 'disponivel', 'vendido', 'alugado'];
        $cities = ['São Paulo', 'Rio de Janeiro', 'Belo Horizonte', 'Curitiba', 'Porto Alegre'];
        $states = ['SP', 'RJ', 'MG', 'PR', 'RS'];

        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'type' => $this->faker->randomElement($types),
            'purpose' => $this->faker->randomElement($purposes),
            'status' => $this->faker->randomElement($statuses),
            'price' => $this->faker->numberBetween(200000, 5000000),
            'rent_price' => $this->faker->optional(0.3)->numberBetween(1000, 15000),
            'bedrooms' => $this->faker->numberBetween(1, 5),
            'bathrooms' => $this->faker->numberBetween(1, 4),
            'garage_spaces' => $this->faker->numberBetween(0, 3),
            'area' => $this->faker->numberBetween(50, 400),
            'total_area' => function (array $attributes) {
                return $attributes['type'] === 'terreno'
                    ? $this->faker->numberBetween(200, 1000)
                    : null;
            },
            'construction_area' => function (array $attributes) {
                return $attributes['type'] !== 'terreno'
                    ? $this->faker->numberBetween(50, 400)
                    : null;
            },
            'floors' => $this->faker->numberBetween(1, 3),
            'year_built' => $this->faker->numberBetween(1960, 2023),
            'street' => $this->faker->streetName,
            'number' => $this->faker->buildingNumber,
            'complement' => $this->faker->optional()->secondaryAddress,
            'neighborhood' => $this->faker->citySuffix,
            'city' => $this->faker->randomElement($cities),
            'state' => $this->faker->randomElement($states),
            'zip_code' => $this->faker->postcode,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'featured' => $this->faker->boolean(20),
            'video_url' => $this->faker->optional()->url,
            'virtual_tour_url' => $this->faker->optional()->url,
            'amenities' => $this->faker->randomElements(
                ['piscina', 'academia', 'churrasqueira', 'salao-de-festas', 'playground', 'portaria-24h', 'elevador', 'quadra', 'salao-de-jogos', 'area-verde'],
                $this->faker->numberBetween(0, 5)
            ),
            'meta_title' => $this->faker->optional()->sentence,
            'meta_description' => $this->faker->optional()->paragraph,
            'user_id' => User::factory(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Property $property) {
            // Garante que o property foi persistido no banco
            if ($property->exists && $this->faker->boolean(80)) {
                try {
                    $property
                        ->addMediaFromUrl('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')
                        ->toMediaCollection('gallery');

                    $property
                        ->addMediaFromUrl('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')
                        ->toMediaCollection('thumbnails');
                } catch (\Exception $e) {
                    // Logar erro se necessário
                    logger()->error('Error adding media to property: ' . $e->getMessage());
                }
            }
        });
    }
}
