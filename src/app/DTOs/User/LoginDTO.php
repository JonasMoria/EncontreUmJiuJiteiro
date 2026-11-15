<?php

namespace App\DTOs\User;

final readonly class LoginDTO {
    public function __construct(
        private string $email,
        private string $password,
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            email: $data['email'] ?? '',
            password: $data['password'] ?? ''
        );
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }
}
