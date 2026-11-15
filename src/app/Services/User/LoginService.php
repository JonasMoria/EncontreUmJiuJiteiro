<?php

namespace App\Services\User;

use App\DTOs\User\LoginDTO;
use App\Http\Enums\HttpStatusCode;
use App\Http\Exceptions\AppRuntimeException;
use App\Models\User\UserModel;
use App\Repository\User\UserRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\NewAccessToken;

class LoginService {
    private UserRepository $userRepository;

    public function __construct(
        ?UserRepository $userRepository = null
    ) {
        $this->userRepository = $userRepository ?? new UserRepository();
    }

    public function generateAccessToken(LoginDTO $loginDTO): array {
        $user = $this->getUser($loginDTO->getEmail());

        $this->validatePassword(
            $loginDTO->getPassword(),
            $user->password
        );

        $this->revokeAllTokens($user);

        $hoursToExpire = now()->addHours(8);
        $token = $this->createBearerToken($user, $hoursToExpire);

        return [
            'token' => $token->plainTextToken,
            'type' => 'Bearer',
            'expires_at' => $token->accessToken->expires_at,
        ];
    }

    protected function getUser(string $email): UserModel {
        $user = $this->userRepository->findByEmail($email);

        if ($user === null) {
            throw new AppRuntimeException(
                'USER.LOGIN.INVALID_CREDENTIALS',
                HttpStatusCode::BAD_REQUEST
            );
        }

        return $user;
    }

    protected function validatePassword(string $requestPassword, string $userPassword): void {
        $validPassword = $this->checkPassword($requestPassword, $userPassword);

        if (!$validPassword) {
            throw new AppRuntimeException(
                'USER.LOGIN.INVALID_CREDENTIALS',
                HttpStatusCode::BAD_REQUEST
            );
        }
    }

    protected function createBearerToken(UserModel $user, Carbon $hoursToExpire): NewAccessToken {
        return $user->createToken(
            $user->email,
            ['*'],
            $hoursToExpire
        );
    }

    protected function revokeAllTokens(UserModel $userModel): void {
        $userModel->tokens()->delete();
    }

    protected function checkPassword(string $requestPassword, string $userPassword): bool {
        return Hash::check($requestPassword, $userPassword);
    }
}
