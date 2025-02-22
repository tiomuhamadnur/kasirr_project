<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('gender_id')->after('email')->unsigned()->nullable();
            $table->bigInteger('group_id')->after('email')->unsigned()->nullable();
            $table->bigInteger('role_id')->after('email')->unsigned()->nullable();

            $table->foreign('gender_id')->on('gender')->references('id');
            $table->foreign('group_id')->on('group')->references('id');
            $table->foreign('role_id')->on('role')->references('id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['gender_id']);
            $table->dropForeign(['group_id']);
            $table->dropForeign(['role_id']);

            $table->dropColumn('gender_id');
            $table->dropColumn('group_id');
            $table->dropColumn('role_id');
        });
    }
};
