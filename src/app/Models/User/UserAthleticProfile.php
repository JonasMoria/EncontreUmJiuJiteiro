<?php

namespace App\Models\User;

use App\Enums\BeltCategory;
use App\Enums\Gender;
use App\Enums\WeightCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property Carbon $birthdate
 * @property Gender $gender
 * @property BeltCategory $belt_category
 * @property WeightCategory $weight_category
 * @property numeric-string|null $weight_kg
 * @property string|null $avatar_path
 */
class UserAthleticProfile extends Model {
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
