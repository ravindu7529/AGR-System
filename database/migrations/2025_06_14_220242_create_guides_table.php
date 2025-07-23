<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuidesTable extends Migration
{
    public function up()
    {
        Schema::create('guides', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mobile_number')->unique(); // used for login
            $table->date('date_of_birth')->nullable();
            $table->string('email')->nullable();
            $table->string('profile_photo')->nullable(); // path to image
            $table->string('whatsapp_number')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('guides');
    }
}

