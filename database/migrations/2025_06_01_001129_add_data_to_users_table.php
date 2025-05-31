<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('shop_address')->nullable()->after('pin');
            $table->text('shop_photo')->nullable()->after('pin');
            $table->string('shop_phone')->nullable()->after('pin');
            $table->string('shop_name')->nullable()->after('pin');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('shop_address');
            $table->dropColumn('shop_photo');
            $table->dropColumn('shop_phone');
            $table->dropColumn('shop_name');
        });
    }
};
