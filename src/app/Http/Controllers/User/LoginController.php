<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\LoginDTO;
use App\Http\Controllers\Controller;
use App\Http\Enums\HttpStatusCode;
use App\Http\Exceptions\AppRuntimeException;
use App\Http\Exceptions\FormRequestException;
use App\Http\Requests\User\LoginRequest;
use App\Services\LogService;
use App\Services\User\LoginService;
use Illuminate\Http\JsonResponse;
use Throwable;

class LoginController extends Controller {
    private LoginService $loginService;
    private LogService $logService;

    public function __construct(
        ?LoginService $loginService = null,
        ?LogService $logService = null
    ) {
        $this->loginService = $loginService ?? new LoginService();
        $this->logService = $logService ?? new LogService();
    }

    public function login(LoginRequest $request): JsonResponse {
        try {
            $data = $request->validated();
            $loginDTO = LoginDTO::fromArray($data);

            $loginInformations = $this->loginService->generateAccessToken($loginDTO);

            return self::makeResponse(
                'USER.LOGGED',
                HttpStatusCode::OK,
                $loginInformations
            );

        } catch (FormRequestException $formException) {
            return self::makeResponse(
                $formException->getMessage(),
                HttpStatusCode::from($formException->getCode())
            );
        } catch (AppRuntimeException $runtimeException) {
            return self::makeResponse(
                $runtimeException->getMessage(),
                HttpStatusCode::from($runtimeException->getCode())
            );
        } catch (Throwable $throwable) {
            $this->logService->logException($throwable, [
                'controller' => self::class,
                'action' => __FUNCTION__,
            ]);

            return self::makeResponse(
                'SYSTEM.FATAL.ERROR',
                HttpStatusCode::INTERNAL_SERVER_ERROR
            );
        }
    }
}
