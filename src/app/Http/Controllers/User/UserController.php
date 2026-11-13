<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Enums\HttpStatusCode;
use App\Http\Exceptions\FormRequestException;
use App\Http\Requests\User\CreateUserRequest;
use App\Services\LogService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserController extends Controller {
    private UserService $userService;
    private LogService $logService;

    public function __construct(
        ?UserService $userService = null,
        ?LogService $logService = null
    ) {
        $this->userService = $userService ?? new UserService();
        $this->logService = $logService ?? new LogService();
    }

    public function create(CreateUserRequest $request): JsonResponse {
        try {
            $data = $request->validated();
            $createUserDTO = CreateUserDTO::fromArray($data);

            $user = $this->userService->createUserAccount($createUserDTO);

            return self::makeResponse(
                'USER.CREATED',
                HttpStatusCode::CREATED,
                $user
            );

        } catch (FormRequestException $formException) {
            return self::makeResponse(
                $formException->getMessage(),
                HttpStatusCode::from($formException->getCode())
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
