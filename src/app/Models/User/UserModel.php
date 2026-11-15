<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string|null $remember_token
 *
 */
class UserModel extends Authenticatable {
    use HasApiTokens;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function athleticProfile(): HasOne {
        return $this->hasOne(UserAthleticProfile::class, 'user_id');
    }

    public function trainingLocals(): HasMany {
        return $this->hasMany(UserTrainingLocal::class, 'user_id');
    }
}
