<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void {
        Schema::create('users_training_local', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('name');

            // Address
            $table->string('address');
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('city');
            $table->string('state', 2);
            $table->string('country', 2)->default('BR');
            $table->string('postal_code', 10)->nullable();

            // Geolocation
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);

            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void {
        Schema::dropIfExists('users_training_local');
    }
};
