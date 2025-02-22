<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('license', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('key')->unique();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->dateTime('expired_at')->nullable();
            $table->bigInteger('status_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->on('category')->references('id');
            $table->foreign('status_id')->on('status')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('license');
    }
};
