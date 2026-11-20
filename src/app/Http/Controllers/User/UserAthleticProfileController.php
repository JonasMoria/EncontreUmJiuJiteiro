<?php

namespace App\Http\Controllers\User;

use App\DTOs\User\CreateAthleticProfileDTO;
use App\Http\Controllers\Controller;
use App\Http\Enums\HttpStatusCode;
use App\Http\Exceptions\AppRuntimeException;
use App\Http\Exceptions\FormRequestException;
use App\Http\Requests\User\CreateAthleticProfileRequest;
use App\Services\LogService;
use App\Services\User\UserAthleticProfileService;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserAthleticProfileController extends Controller {
    private UserAthleticProfileService $userAthleticProfileService;
    private LogService $logService;

    public function __construct(
        ?UserAthleticProfileService $userAthleticProfileService = null,
        ?LogService $logService = null
    ) {
        $this->userAthleticProfileService = $userAthleticProfileService ?? new UserAthleticProfileService();
        $this->logService = $logService ?? new LogService();
    }

    public function create(CreateAthleticProfileRequest $request): JsonResponse {
        try {
            $user = $this->getLoggedUser();

            $data = $request->validated();
            $profileDTO = CreateAthleticProfileDTO::fromArray($data);

            $user = $this->userAthleticProfileService->createUserAthleticProfile($user, $profileDTO);

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
