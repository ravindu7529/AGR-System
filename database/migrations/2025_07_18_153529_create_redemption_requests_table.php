<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_redemption_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('redemption_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guide_id')->constrained()->onDelete('cascade');
            $table->json('item_ids'); // Store selected item IDs
            $table->json('item_details'); // Store item names and points for reference
            $table->integer('total_points');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('admins')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('redemption_requests');
    }
};