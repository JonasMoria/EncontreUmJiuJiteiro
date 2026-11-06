<?php

namespace Tests\Feature\Http\Request\User;

use App\Http\Requests\User\CreateUserRequest;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CreateUserRequestTest extends TestCase {
    private function validate(array $data): \Illuminate\Validation\Validator {
        $request = new CreateUserRequest();

        return Validator::make(
            $data,
            $request->rules(),
            $request->messages(),
        );
    }

    public function testAcceptsValidUserData(): void {
        $validator = $this->validate([
            'name' => 'Jonas',
            'email' => 'jonas@example.com',
            'password' => 'Bjj@2026',
        ]);

        $this->assertTrue($validator->passes());
    }

    public function testNotAcceptsUserWithoutEmail(): void {
        $validator = $this->validate([
            'name' => 'Jonas',
            'password' => 'Bjj@2026',
        ]);

        $this->assertFalse($validator->passes());
    }

    public function testNotAcceptsUserWithNullEmail(): void {
        $validator = $this->validate([
            'name' => 'Jonas',
            'email' => null,
            'password' => 'Bjj@2026',
        ]);

        $this->assertFalse($validator->passes());
    }

    #[DataProvider('invalidPayloadsProvider')]
    public function testRejectsInvalidUserData(
        array $data,
        string $expectedMessage,
    ): void {
        $validator = $this->validate($data);

        $this->assertTrue($validator->fails());

        $this->assertSame(
            $expectedMessage,
            $validator->errors()->first(),
        );
    }

    public static function invalidPayloadsProvider(): array {
        $validPayload = [
            'name' => 'Jonas',
            'email' => 'jonas@example.com',
            'password' => 'Bjj@2026',
        ];

        return [
            'missing name' => [
                [
                    'email' => $validPayload['email'],
                    'password' => $validPayload['password'],
                ],
                'FORM.CLIENT.NAME.REQUIRED',
            ],

            'name with fewer than 3 characters' => [
                [
                    'name' => 'ab',
                    'email' => $validPayload['email'],
                    'password' => $validPayload['password'],
                ],
                'FORM.USER.NAME.MIN',
            ],

            'invalid name type' => [
                [
                    ...$validPayload,
                    'name' => 123,
                ],
                'FORM.CLIENT.NAME.STRING',
            ],

            'name exceeds maximum length' => [
                [
                    ...$validPayload,
                    'name' => str_repeat('a', 256),
                ],
                'FORM.CLIENT.NAME.MAX',
            ],

            'invalid email format' => [
                [
                    ...$validPayload,
                    'email' => 'invalid-email',
                ],
                'FORM.CLIENT.EMAIL.INVALID',
            ],

            'email exceeds maximum length' => [
                [
                    ...$validPayload,
                    'email' => str_repeat('a', 244) . '@example.com',
                ],
                'FORM.CLIENT.EMAIL.MAX',
            ],

            'missing password' => [
                [
                    'name' => $validPayload['name'],
                    'email' => $validPayload['email'],
                ],
                'FORM.USER.PASSWORD.REQUIRED',
            ],

            'invalid password type' => [
                [
                    ...$validPayload,
                    'password' => ['Bjj@2026'],
                ],
                'FORM.USER.PASSWORD.STRING',
            ],

            'weak password' => [
                [
                    ...$validPayload,
                    'password' => 'password123',
                ],
                'FORM.USER.PASSWORD.STRONG',
            ],
        ];
    }
}
