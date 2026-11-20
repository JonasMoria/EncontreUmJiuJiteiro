<?php

namespace Tests\Unit\Http\Requests\User;

use App\Http\Requests\User\CreateUserTrainingLocalRequest;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;

class CreateUserTrainingLocalRequestTest extends TestCase {
    private function validData(): array {
        return [
            'name' => 'Academia Central',
            'address' => 'Rua das Flores',
            'number' => '123',
            'complement' => 'Sala 2',
            'neighborhood' => 'Centro',
            'city' => 'Sumaré',
            'state' => 'São Paulo',
            'country' => 'Brasil',
            'postal_code' => '13170-000',
            'latitude' => '-22.8219',
            'longitude' => '-47.2669',
        ];
    }

    public function testValidDataPassesCorrectly(): void {
        $request = new CreateUserTrainingLocalRequest();

        $validator = Validator::make(
            $this->validData(),
            $request->rules()
        );

        $this->assertTrue(
            $validator->passes(),
            'Validação de dados válidos ao cadastrar local de treinamento funcional'
        );
    }

    public function testOptionalFieldsAcceptNullValues(): void {
        $data = $this->validData();

        $data['number'] = null;
        $data['complement'] = null;
        $data['neighborhood'] = null;

        $request = new CreateUserTrainingLocalRequest();

        $validator = Validator::make(
            $data,
            $request->rules()
        );

        $this->assertTrue(
            $validator->passes(),
            'Campos opcionais devem aceitar valores nulos'
        );
    }

    #[DataProvider('validationScenariosProvider')]
    public function testInvalidDataNotPassesCorrectly(
        array $invalidData,
        string $field
    ): void {
        $data = array_merge($this->validData(), $invalidData);

        $request = new CreateUserTrainingLocalRequest();

        $validator = Validator::make(
            $data,
            $request->rules()
        );

        $this->assertFalse(
            $validator->passes(),
            "Validação deve barrar quando {$field} for inválido"
        );
    }

    public static function validationScenariosProvider(): array {
        return [
            // Name
            'Nome não informado' => [
                ['name' => null],
                'name',
            ],
            'Nome vazio' => [
                ['name' => ''],
                'name',
            ],
            'Nome não textual' => [
                ['name' => 123],
                'name',
            ],
            'Nome acima do limite' => [
                ['name' => str_repeat('A', 256)],
                'name',
            ],

            // Address
            'Endereço não informado' => [
                ['address' => null],
                'address',
            ],
            'Endereço vazio' => [
                ['address' => ''],
                'address',
            ],
            'Endereço não textual' => [
                ['address' => 123],
                'address',
            ],
            'Endereço acima do limite' => [
                ['address' => str_repeat('A', 256)],
                'address',
            ],

            // Number
            'Número não textual' => [
                ['number' => 123],
                'number',
            ],
            'Número acima do limite' => [
                ['number' => str_repeat('1', 21)],
                'number',
            ],

            // Complement
            'Complemento não textual' => [
                ['complement' => 123],
                'complement',
            ],
            'Complemento acima do limite' => [
                ['complement' => str_repeat('A', 256)],
                'complement',
            ],

            // Neighborhood
            'Bairro não textual' => [
                ['neighborhood' => 123],
                'neighborhood',
            ],
            'Bairro acima do limite' => [
                ['neighborhood' => str_repeat('A', 256)],
                'neighborhood',
            ],

            // City
            'Cidade não informada' => [
                ['city' => null],
                'city',
            ],
            'Cidade vazia' => [
                ['city' => ''],
                'city',
            ],
            'Cidade não textual' => [
                ['city' => 123],
                'city',
            ],
            'Cidade acima do limite' => [
                ['city' => str_repeat('A', 101)],
                'city',
            ],

            // State
            'Estado não informado' => [
                ['state' => null],
                'state',
            ],
            'Estado vazio' => [
                ['state' => ''],
                'state',
            ],
            'Estado não textual' => [
                ['state' => 123],
                'state',
            ],
            'Estado acima do limite' => [
                ['state' => str_repeat('A', 101)],
                'state',
            ],

            // Country
            'País não informado' => [
                ['country' => null],
                'country',
            ],
            'País vazio' => [
                ['country' => ''],
                'country',
            ],
            'País não textual' => [
                ['country' => 123],
                'country',
            ],
            'País acima do limite' => [
                ['country' => str_repeat('A', 101)],
                'country',
            ],

            // Postal code
            'CEP não informado' => [
                ['postal_code' => null],
                'postal_code',
            ],
            'CEP vazio' => [
                ['postal_code' => ''],
                'postal_code',
            ],
            'CEP não textual' => [
                ['postal_code' => 123],
                'postal_code',
            ],
            'CEP acima do limite' => [
                ['postal_code' => str_repeat('1', 21)],
                'postal_code',
            ],

            // Latitude
            'Latitude não informada' => [
                ['latitude' => null],
                'latitude',
            ],
            'Latitude vazia' => [
                ['latitude' => ''],
                'latitude',
            ],
            'Latitude não numérica' => [
                ['latitude' => 'abc'],
                'latitude',
            ],
            'Latitude acima do limite' => [
                ['latitude' => '90.0001'],
                'latitude',
            ],
            'Latitude abaixo do limite' => [
                ['latitude' => '-90.0001'],
                'latitude',
            ],

            // Longitude
            'Longitude não informada' => [
                ['longitude' => null],
                'longitude',
            ],
            'Longitude vazia' => [
                ['longitude' => ''],
                'longitude',
            ],
            'Longitude não numérica' => [
                ['longitude' => 'abc'],
                'longitude',
            ],
            'Longitude acima do limite' => [
                ['longitude' => '180.0001'],
                'longitude',
            ],
            'Longitude abaixo do limite' => [
                ['longitude' => '-180.0001'],
                'longitude',
            ],
        ];
    }
}
