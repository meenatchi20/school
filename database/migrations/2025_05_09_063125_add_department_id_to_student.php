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
        Schema::table('student', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->after('age');

            // Add the foreign key constraint
            $table->foreign('department_id')->references('id')->on('department')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student', function (Blueprint $table) {
            
                $table->dropForeign(['department_id']);
                $table->dropColumn('department_id');
            });
      
    }
};
