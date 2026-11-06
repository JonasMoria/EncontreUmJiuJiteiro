<?php

namespace Tests\Feature\Repository\User;

use App\DTOs\User\CreateUserDTO;
use App\Models\User\UserModel;
use App\Repository\User\UserRepository;
use Tests\DatabaseTestCase;

class UserRepositoryTest extends DatabaseTestCase {
    public function testCreatePersistsUserInDatabase(): void {
        $userDTO = new CreateUserDTO(
            name: 'User Name',
            email: 'user.name@email.com',
            password: 'pass123'
        );

        $actual = (new UserRepository())->create($userDTO);

        $this->assertInstanceOf(
            UserModel::class,
            $actual,
            'Insert de um usuário deve retornar o objeto UserModel'
        );

        $expected = [
            'id' => $actual->id,
            'name' => 'User Name',
            'email' => 'user.name@email.com',
        ];

        $this->assertDatabaseHas(
            ((new UserModel())->getTable()),
            $expected
        );
    }

    public function testCreatePersistsUserPasswordAsHash(): void {
        $userPassword = 'PassWord@2026';
        $userDTO = new CreateUserDTO(
            name: 'User Name',
            email: 'user.name@email.com',
            password: $userPassword
        );

        $actual = (new UserRepository())->create($userDTO);

        $this->assertNotSame(
            $userPassword,
            $actual->password,
            'Senha enviada pelo POST não deve ser igual a senha persistida no banco de dados'
        );

        $this->assertTrue(
            password_verify($userPassword, $actual->password),
            'Senha persistida no banco deve estar criptografada'
        );
    }
}
