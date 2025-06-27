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
        Schema::create('approved_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('temp_student_id')->nullable();
            $table->string('action');
            $table->string('maker_by')->nullable();
            $table->dateTime('maker_at')->nullable();
            $table->string('approved_by')->nullable();
            $table->dateTime('approved_at')->nullable();
            
            $table->foreign('temp_student_id')->references('id')->on('student_temp_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approved_students');
    }
};
