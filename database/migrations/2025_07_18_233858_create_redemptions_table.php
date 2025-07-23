<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedemptionsTable extends Migration
{
    public function up()
    {
        Schema::create('redemptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guide_id')->constrained('guides')->onDelete('cascade');
            $table->integer('points'); // redeemed points
            $table->integer('reserved_points')->nullable();
            $table->timestamp('redeemed_at')->nullable(); // time of redemption
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('redemptions');
    }
}

