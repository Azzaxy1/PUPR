<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_detail_tab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_tab_id')->constrained('user_tab')->cascadeOnDelete();
            $table->string('number_identification');
            $table->string('number_phone');
            $table->text('address');
            $table->string('working')->nullable();
            $table->string('address_office')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_detail_tab');
    }
};
