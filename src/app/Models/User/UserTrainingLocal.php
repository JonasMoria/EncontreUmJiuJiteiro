<?php

namespace App\Models\User;

use App\Collections\User\UserTrainingLocalCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Override;

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
    use HasFactory;

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

    /**
     * @return BelongsTo<UserModel, $this>
     */
    public function user(): BelongsTo {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    /**
     * @param array<int, UserTrainingLocal> $models
     */
    #[Override]
    public function newCollection(array $models = []): UserTrainingLocalCollection {
        return new UserTrainingLocalCollection($models);
    }
}
