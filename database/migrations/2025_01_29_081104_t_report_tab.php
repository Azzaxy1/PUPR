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
        Schema::create('t_report_tab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('user_tab')->cascadeOnDelete();
            $table->string('number_registration');
            $table->text('report');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_report_tab');
    }
};
