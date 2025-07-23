<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_reserved_points_to_redemptions_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('redemptions', function (Blueprint $table) {
            $table->integer('reserved_points')->default(0)->after('points');
        });
    }

    public function down()
    {
        Schema::table('redemptions', function (Blueprint $table) {
            $table->dropColumn('reserved_points');
        });
    }
};