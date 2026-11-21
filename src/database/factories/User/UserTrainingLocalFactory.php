<?php

namespace Database\Factories\User;

use App\Models\User\UserTrainingLocal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserTrainingLocal>
 */
class UserTrainingLocalFactory extends Factory {
    protected $model = UserTrainingLocal::class;

    /**
     * Coordenadas de referência em bairros de São José dos Campos.
     *
     * latitude, longitude
     *
     * @var array<int, array{
     *     neighborhood: string,
     *     latitude: float,
     *     longitude: float
     * }>
     */
    private const LOCATIONS = [
        [
            'neighborhood' => 'Centro',
            'latitude' => -23.18651,
            'longitude' => -45.88673,
        ],
        [
            'neighborhood' => 'Vila Adyana',
            'latitude' => -23.19643,
            'longitude' => -45.89192,
        ],
        [
            'neighborhood' => 'Jardim Aquarius',
            'latitude' => -23.21060,
            'longitude' => -45.90452,
        ],
        [
            'neighborhood' => 'Urbanova',
            'latitude' => -23.19640,
            'longitude' => -45.93552,
        ],
    ];

    public function definition(): array {
        $location = fake()->randomElement(self::LOCATIONS);

        return [
            'name' => fake()->company() . ' Jiu-Jitsu',
            'address' => fake()->streetName(),
            'number' => (string) fake()->numberBetween(1, 1500),
            'complement' => fake()->optional(0.3)->secondaryAddress(),
            'neighborhood' => $location['neighborhood'],
            'city' => 'São José dos Campos',
            'state' => 'SP',
            'country' => 'BR',
            'postal_code' => '12200000',

            // Pequena variação para não concentrar todos os pontos
            // exatamente na coordenada de referência do bairro.
            'latitude' => $location['latitude'] + fake()->randomFloat(5, -0.0015, 0.0015),
            'longitude' => $location['longitude'] + fake()->randomFloat(5, -0.0015, 0.0015),
        ];
    }
}
