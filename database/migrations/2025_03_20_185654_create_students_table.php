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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('session');
            $table->string('department');
            $table->string('gender');
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('employment_status')->nullable();
            $table->string('company_name')->nullable();
            $table->string('position')->nullable();
            $table->json('additional_info')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
