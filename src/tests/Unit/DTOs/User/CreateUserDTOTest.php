<?php

namespace Tests\Unit\DTOs\User;

use App\DTOs\User\CreateUserDTO;
use Tests\TestCase;

class CreateUserDTOTest extends TestCase {
    public function testFromArrayWithValidData(): void {
        $data = [
            'name' => 'User Name',
            'email' =>  'user.email@email.com',
            'password' => 'pass123',
        ];

        $actual = CreateUserDTO::fromArray($data);
        $expected = new CreateUserDTO(
            name: $data['name'],
            email: $data['email'],
            password: $data['password']
        );

        $this->assertEquals(
            $expected,
            $actual,
            'DTO deve ser construido com os dados vindos da request'
        );
    }

    public function testFromArrayWithEmptyData(): void {
        $data = [];

        $actual = CreateUserDTO::fromArray($data);
        $expected = new CreateUserDTO(
            name: '',
            email: '',
            password: ''
        );

        $this->assertEquals(
            $expected,
            $actual,
            'DTO deve ser construido com os dados vindos da request'
        );
    }
}
