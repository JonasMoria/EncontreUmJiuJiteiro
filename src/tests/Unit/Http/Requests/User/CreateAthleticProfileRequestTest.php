<?php

namespace Tests\Unit\Http\Requests\User;

use App\Enums\BeltCategory;
use App\Enums\Gender;
use App\Enums\WeightCategory;
use App\Http\Requests\User\CreateAthleticProfileRequest;
use Carbon\CarbonImmutable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CreateAthleticProfileRequestTest extends TestCase {
    public function testValidDataPassesCorrectly(): void {
        $data = [
            'birthdate' => CarbonImmutable::now()->subYears(20)->toDateString(),
            'gender' => Gender::cases()[0]->value,
            'belt_category' => BeltCategory::cases()[0]->value,
            'weight_category' => WeightCategory::cases()[0]->value,
        ];

        $request = new CreateAthleticProfileRequest();

        $validator = Validator::make(
            $data,
            $request->rules()
        );

        $this->assertTrue(
            $validator->passes(),
            'Validação de dados válidos ao criar o perfil do atleta funcional'
        );
    }

    #[DataProvider('validationScenariosProvider')]
    public function testInvalidDataNotPassesCorrectly(
        array $data,
        string $field
    ): void {
        $request = new CreateAthleticProfileRequest();

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
            // Birthdate
            'Data de nascimento não informada' => [
                ['birthdate' => null],
                'birthdate',
            ],
            'Data de nascimento vazia' => [
                ['birthdate' => ''],
                'birthdate',
            ],
            'Data de nascimento inválida' => [
                ['birthdate' => 'data-invalida'],
                'birthdate',
            ],
            'Data de nascimento futura' => [
                ['birthdate' => '2999-01-01'],
                'birthdate',
            ],

            // Gender
            'Gênero não informado' => [
                ['gender' => null],
                'gender',
            ],
            'Gênero vazio' => [
                ['gender' => ''],
                'gender',
            ],
            'Gênero inválido' => [
                ['gender' => 'INVALID'],
                'gender',
            ],

            // Belt category
            'Faixa não informada' => [
                ['belt_category' => null],
                'belt_category',
            ],
            'Faixa vazia' => [
                ['belt_category' => ''],
                'belt_category',
            ],
            'Faixa inválida' => [
                ['belt_category' => 'INVALID'],
                'belt_category',
            ],

            // Weight category
            'Categoria de peso não informada' => [
                ['weight_category' => null],
                'weight_category',
            ],
            'Categoria de peso vazia' => [
                ['weight_category' => ''],
                'weight_category',
            ],
            'Categoria de peso inválida' => [
                ['weight_category' => 'INVALID'],
                'weight_category',
            ],

            // Avatar
            'Avatar em formato PDF' => [
                [
                    'avatar' => UploadedFile::fake()
                        ->create('avatar.pdf', 100, 'application/pdf'),
                ],
                'avatar',
            ],
            'Avatar em formato TXT' => [
                [
                    'avatar' => UploadedFile::fake()
                        ->create('avatar.txt', 100, 'text/plain'),
                ],
                'avatar',
            ],
            'Avatar acima do tamanho permitido' => [
                [
                    'avatar' => UploadedFile::fake()
                        ->create('avatar.jpg', 3073, 'image/jpeg'),
                ],
                'avatar',
            ],
        ];
    }
}
