<?php

namespace App\Models\User;

use App\Enums\BeltCategory;
use App\Enums\Gender;
use App\Enums\WeightCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAthleticProfile extends Model {
    public int $id;
    public int $user_id;
    public Carbon $birthdate;
    public Gender $gender;
    public BeltCategory $beltCategory;
    public WeightCategory $weightCategory;
    public ?string $weightKg;
    public ?string $avatarPath;

    protected $table = 'users_athletic_profile';
    protected $fillable = [
        'birthdate',
        'gender',
        'belt_category',
        'weight_category',
        'weight_kg',
        'avatar_path',
    ];

    protected function casts(): array {
        return [
            'birthdate' => 'date',
            'gender' => Gender::class,
            'belt_category' => BeltCategory::class,
            'weight_category' => WeightCategory::class,
            'weight_kg' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
