<?php

namespace App\DTOs\User;

use App\Enums\BeltCategory;
use App\Enums\Gender;
use App\Enums\WeightCategory;
use Carbon\CarbonImmutable;
use Illuminate\Http\UploadedFile;

final readonly class CreateAthleticProfileDTO {
    public function __construct(
        private CarbonImmutable $birthDate,
        private Gender $gender,
        private BeltCategory $beltCategory,
        private WeightCategory $weightCategory,
        private ?UploadedFile $avatar = null
    ) {
    }

    public static function fromArray(array $data): self {
        return new self(
            birthDate: CarbonImmutable::parse($data['birthdate']),
            gender: Gender::from($data['gender']),
            beltCategory: BeltCategory::from($data['belt_category']),
            weightCategory: WeightCategory::from($data['weight_category']),
            avatar: $data['avatar'] ?? null
        );
    }

    public function getBirthDate(): CarbonImmutable {
        return $this->birthDate;
    }

    public function getGender(): Gender {
        return $this->gender;
    }

    public function getBeltCategory(): BeltCategory {
        return $this->beltCategory;
    }

    public function getWeightCategory(): WeightCategory {
        return $this->weightCategory;
    }

    public function getAvatar(): ?UploadedFile {
        return $this->avatar;
    }
}
