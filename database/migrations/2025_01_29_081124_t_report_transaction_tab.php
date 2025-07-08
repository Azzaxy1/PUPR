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
        Schema::create('t_report_transaction_tab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('t_report_tab_id')->constrained('t_report_tab')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('user_tab')->cascadeOnDelete();
            $table->integer('status_ref');
            $table->boolean('status_active')->default(0);
            $table->timestamp('approve_dates')->nullable();
            $table->foreignId('m_status_tab_id')->constrained('m_status_tab');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_report_transaction_tab');
    }
};
