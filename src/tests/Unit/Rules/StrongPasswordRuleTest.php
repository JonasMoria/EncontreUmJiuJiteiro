<?php

namespace Tests\Unit\Rules;

use App\Rules\StrongPasswordRule;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class StrongPasswordRuleTest extends TestCase {
    public function testAcceptsStrongPassword(): void {
        $validator = Validator::make(
            ['password' => 'EncontreUmBjj@2026'],
            ['password' => [new StrongPasswordRule()]],
        );

        $this->assertTrue($validator->passes());
    }

    #[DataProvider('invalidPasswordsProvider')]
    public function testRejectsWeakPassword(
        mixed $password,
    ): void {
        $validator = Validator::make(
            ['password' => $password],
            ['password' => [new StrongPasswordRule()]],
        );

        $this->assertFalse($validator->passes());
        $this->assertArrayHasKey(
            'password',
            $validator->errors()->toArray(),
        );
    }

    /**
     * @return array<string, array{mixed}>
     */
    public static function invalidPasswordsProvider(): array {
        return [
            'less than 8 characters' => [
                'Pa@1abc',
            ],
            'missing uppercase letter' => [
                'password@123',
            ],
            'missing lowercase letter' => [
                'PASSWORD@123',
            ],
            'missing number' => [
                'Password@',
            ],
            'missing special character' => [
                'Password123',
            ],
            'contains whitespace' => [
                'Pass word@123',
            ],
            'integer instead of string' => [
                12345678,
            ],
            'array instead of string' => [
                ['Password@123'],
            ],
        ];
    }
}
