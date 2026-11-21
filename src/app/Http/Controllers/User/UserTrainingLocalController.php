<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\CreateTrainingLocalDTO;
use App\Http\Controllers\Controller;
use App\Http\Enums\HttpStatusCode;
use App\Http\Exceptions\AppRuntimeException;
use App\Http\Exceptions\FormRequestException;
use App\Http\Requests\User\CreateUserTrainingLocalRequest;
use App\Services\LogService;
use App\Services\User\UserTrainingLocalService;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserTrainingLocalController extends Controller {
    private UserTrainingLocalService $userTrainingLocalService;
    private LogService $logService;

    public function __construct(
        ?UserTrainingLocalService $userTrainingLocalService = null,
        ?LogService $logService = null
    ) {
        $this->userTrainingLocalService = $userTrainingLocalService ?? new UserTrainingLocalService();
        $this->logService = $logService ?? new LogService();
    }

    public function create(CreateUserTrainingLocalRequest $request): JsonResponse {
        try {
            $user = $this->getLoggedUser();

            $data = $request->validated();
            $trainingLocal = CreateTrainingLocalDTO::fromArray($data);

            $user = $this->userTrainingLocalService->createUserTrainingLocal($user, $trainingLocal);

            return self::makeResponse(
                'USER.PROFILE.CREATED',
                HttpStatusCode::CREATED,
                $user
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
