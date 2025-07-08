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
        Schema::create('t_report_document_output_tab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('t_report_tab_id')->constrained('t_report_tab')->cascadeOnDelete();
            $table->string('filename');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_report_document_output_tab');
    }
};
