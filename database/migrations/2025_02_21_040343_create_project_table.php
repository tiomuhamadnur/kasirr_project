<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('code')->unique()->nullable();
            $table->text('description')->nullable();
            $table->bigInteger('license_id')->unsigned()->nullable();
            $table->bigInteger('group_id')->unsigned()->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('license_id')->on('license')->references('id');
            $table->foreign('group_id')->on('group')->references('id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project');
    }
};
