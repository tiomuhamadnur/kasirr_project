<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->string('file')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset');
    }
};
