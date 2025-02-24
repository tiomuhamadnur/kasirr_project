<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('license', function (Blueprint $table) {
            $table->boolean('is_used')->default(false)->after('status_id');
            $table->bigInteger('user_id')->after('status_id')->unsigned()->nullable();

            $table->foreign('user_id')->on('users')->references('id');
        });
    }

    public function down(): void
    {
        Schema::table('license', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            $table->dropColumn('is_used');
            $table->dropColumn('gender_id');
        });
    }
};
