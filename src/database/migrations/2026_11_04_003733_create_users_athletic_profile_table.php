<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void {
        Schema::create('users_athletic_profile', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->date('birthdate');
            $table->unsignedTinyInteger('gender');

            $table->unsignedTinyInteger('belt_category');
            $table->unsignedTinyInteger('weight_category');
            $table->decimal('weight_kg', 5, 2)->nullable();

            $table->string('avatar_path')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users_athletic_profile');
    }
};
