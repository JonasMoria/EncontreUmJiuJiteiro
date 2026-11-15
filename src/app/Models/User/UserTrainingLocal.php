<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class UserTrainingLocal extends Model {
    public int $id;
    public int $userId;
    public string $name;
    public string $address;
    public ?string $number;
    public ?string $complement;
    public ?string $neighborhood;
    public string $city;
    public string $state;
    public string $country;
    public ?string $postalCode;
    public string $latitude;
    public string $longitude;
    public ?Carbon $createdAt;
    public ?Carbon $updatedAt;
    public ?Carbon $deletedAt;

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
