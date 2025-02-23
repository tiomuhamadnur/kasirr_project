<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('gender_id');
            $table->text('photo')->nullable()->after('gender_id');
            $table->date('birth_date')->nullable()->after('gender_id');
            $table->text('address')->nullable()->after('gender_id');
            $table->softDeletes()->after('remember_token');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('photo');
            $table->dropColumn('birth_date');
            $table->dropColumn('address');
            $table->dropSoftDeletes();
        });
    }
};
