<?php

namespace Tests\Feature\Http\Controllers\User;

use App\DTOs\User\CreateUserDTO;
use App\Services\User\UserService;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UserControllerTest extends TestCase {
    public function testCreateReturnsSuccessResponseCorrectly(): void {
        $payload = [
            'name' => 'User Name',
            'email' => 'user@email.com',
            'password' => 'Password@123',
        ];

        $expectedUser = [
            'id' => 1,
        ];

        $this->mock(
            UserService::class,
            function (MockInterface $mock) use ($expectedUser, $payload): void {
                $mock->shouldReceive('createUserAccount')
                    ->once()
                    ->with(Mockery::on(
                        fn (CreateUserDTO $dto): bool =>
                            $dto->getName() === $payload['name']
                            && $dto->getEmail() === $payload['email']
                            && $dto->getPassword() === $payload['password']
                    ))
                    ->andReturn($expectedUser);
            }
        );

        $response = $this->postJson(
            '/api/user/create-account',
            $payload,
        );

        $response
            ->assertCreated()
            ->assertJson([
                'message' => 'USER.CREATED',
                'data' => $expectedUser,
            ]);
    }
}
