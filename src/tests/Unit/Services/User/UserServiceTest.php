<?php

namespace Tests\Unit\Services\User;

use App\DTOs\User\CreateUserDTO;
use App\Models\User\UserModel;
use App\Repository\User\UserRepository;
use App\Services\User\UserService;
use Tests\TestCase;

class UserServiceTest extends TestCase {
    public function testCreateUserAccountReturnsCreatedUserId(): void {
        $userIdExpected = 123;
        $userModel = new UserModel();
        $userModel->id = $userIdExpected;

        $createUserDTO = new CreateUserDTO(
            name: 'User Test',
            email: 'user.email@email.com',
            password: 'pass123'
        );

        $userRepositoryMocked = $this->createMock(UserRepository::class);
        $userRepositoryMocked
            ->expects($this->once())
            ->method('create')
            ->with($createUserDTO)
            ->willReturn($userModel);

        $userService = new UserService($userRepositoryMocked);

        $actual = $userService->createUserAccount($createUserDTO);
        $expected = [
            'id' => $userIdExpected,
        ];

        $this->assertSame(
            $expected,
            $actual,
            'Service deve retornar ID do usuário criado'
        );
    }
}
