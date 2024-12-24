<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('title', 20);
            $table->string('description', 500)->nullable();
            $table->string('tag', 20);
            $table->unsignedBigInteger('user_id');
            $table->enum('privacy', ['public', 'friends', 'private']);
            $table->decimal('average_rating', 3, 2)->default(0);
            $table->timestamps();

            // f key for users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
