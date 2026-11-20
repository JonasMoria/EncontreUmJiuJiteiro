<?php

namespace App\Services\User;

use App\DTOs\User\CreateAthleticProfileDTO;
use App\Models\User\UserModel;
use App\Repository\User\UserAthleticProfileRepository;
use App\Services\LogService;
use Illuminate\Http\UploadedFile;

class UserAthleticProfileService {
    private UserAthleticProfileRepository $userAthleticProfileRepository;
    private LogService $logService;

    public function __construct(
        ?UserAthleticProfileRepository $userAthleticProfileRepository = null,
        ?LogService $logService = null
    ) {
        $this->userAthleticProfileRepository = $userAthleticProfileRepository ?? new UserAthleticProfileRepository();
        $this->logService = $logService ?? new LogService();
    }

    public function createUserAthleticProfile(
        UserModel $user,
        CreateAthleticProfileDTO $profileDTO
    ): array {
        $userAthleticProfile = $this->userAthleticProfileRepository->createProfile(
            $user,
            $profileDTO
        );

        $avatarImageUploaded = $profileDTO->getAvatar();
        $avatarPath = null;

        if ($avatarImageUploaded !== null) {
            $avatarPath = $this->saveAvatarImage($user->id, $avatarImageUploaded);

            $this->userAthleticProfileRepository
                ->updateAvatarPath($user, $avatarPath);
        }

        return [
            'user_id' => $user->id,
            'profile_id' => $userAthleticProfile->id,
            'avatar_path' => $avatarPath,
        ];
    }

    protected function saveAvatarImage(int $userId, UploadedFile $file): ?string {
        $path = $file->store(
            "users/{$userId}/avatar",
            'public'
        );

        if ($path === false || empty(trim($path))) {
            $this->logService->logWarning(
                'USER.PROFILE.AVATAR.UPLOAD.FAILED',
                [
                    'user_id' => $userId,
                    'original_filename' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]
            );

            return null;
        }

        return $path;
    }
}
