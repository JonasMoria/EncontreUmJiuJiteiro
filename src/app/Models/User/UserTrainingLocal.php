<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 *  @property int $id;
 *  @property int $userId;
 *  @property string $name;
 *  @property string $address;
 *  @property string|null $number;
 *  @property string|null $complement;
 *  @property string|null $neighborhood;
 *  @property string $city;
 *  @property string $state;
 *  @property string $country;
 *  @property string $postalCode;
 *  @property string $latitude;
 *  @property string $longitude;
 *  @property Carbon|null $createdAt;
 *  @property Carbon|null $updatedAt;
 *  @property Carbon|null $deletedAt;
 */
class UserTrainingLocal extends Model {
    protected $table = 'users_training_local';
    protected $fillable = [
        'name',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'country',
        'postal_code',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(UserModel::class, 'user_id');
    }
}
