<?php

namespace Tests\Unit\Services\User;

use App\DTOs\User\LoginDTO;
use App\Http\Enums\HttpStatusCode;
use App\Http\Exceptions\AppRuntimeException;
use App\Models\User\UserModel;
use App\Repository\User\UserRepository;
use App\Services\User\LoginService;
use Carbon\Carbon;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class LoginServiceTest extends TestCase {
    protected function tearDown(): void {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function testGenerateAccessTokenThrowsExceptionWhenUserNotFound(): void {
        $loginDTO = LoginDTO::fromArray([
            'email' => "test@email.com",
            'password' => "pass123*",
        ]);

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($loginDTO->getEmail())
            ->willReturn(null);

        $service = new LoginService($userRepository);

        $this->expectException(AppRuntimeException::class);
        $this->expectExceptionMessage('USER.LOGIN.INVALID_CREDENTIALS');
        $this->expectExceptionCode(HttpStatusCode::BAD_REQUEST->value);

        $service->generateAccessToken($loginDTO);
    }

    public function testGenerateAccessTokenThrowsExceptionWithInvalidPassword(): void {
        $loginDTO = LoginDTO::fromArray([
            'email' => 'test@email.com',
            'password' => 'pass123*',
        ]);

        $userModel = new UserModel();
        $userModel->email = 'test@email.com';
        $userModel->password = 'pass321?';

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($loginDTO->getEmail())
            ->willReturn($userModel);

        $service = $this->getMockBuilder(LoginService::class)
            ->setConstructorArgs([$userRepository])
            ->onlyMethods(['checkPassword'])
            ->getMock();
        $service
            ->expects($this->once())
            ->method('checkPassword')
            ->with(
                $loginDTO->getPassword(),
                $userModel->password
            )
            ->willReturn(false);

        $this->expectException(AppRuntimeException::class);
        $this->expectExceptionMessage('USER.LOGIN.INVALID_CREDENTIALS');
        $this->expectExceptionCode(HttpStatusCode::BAD_REQUEST->value);

        $service->generateAccessToken($loginDTO);
    }

    public function testGenerateAccessTokenReturnsBearerTokenCorrectly(): void {
        $loginDTO = LoginDTO::fromArray([
            'email' => 'test@email.com',
            'password' => 'pass123*',
        ]);

        $userModel = new UserModel();
        $userModel->email = 'test@email.com';
        $userModel->password = 'pass123*';

        $now = Carbon::parse('2026-11-15 20:00:00');
        Carbon::setTestNow($now);

        $expiresAt =  $now->addHours(8);
        $accessToken = new PersonalAccessToken();
        $accessToken->expires_at = $expiresAt;
        $newAccessToken = new NewAccessToken(
            $accessToken,
            'fake-access-token'
        );

        $userRepository = $this->createMock(UserRepository::class);
        $userRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($loginDTO->getEmail())
            ->willReturn($userModel);

        $service = $this->getMockBuilder(LoginService::class)
            ->setConstructorArgs([$userRepository])
            ->onlyMethods([
                'checkPassword',
                'revokeAllTokens',
                'createBearerToken',
            ])
            ->getMock();
        $service
            ->expects($this->once())
            ->method('checkPassword')
            ->with(
                $loginDTO->getPassword(),
                $userModel->password
            )
            ->willReturn(true);
        $service
            ->expects($this->once())
            ->method('revokeAllTokens')
            ->with($userModel);
        $service
            ->expects($this->once())
            ->method('createBearerToken')
            ->with($userModel, $expiresAt)
            ->willReturn($newAccessToken);

        $actual = $service->generateAccessToken($loginDTO);

        $this->assertSame('fake-access-token', $actual['token']);
        $this->assertSame('Bearer', $actual['type']);
        $this->assertEquals($expiresAt, $actual['expires_at']);
    }
}
