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
        Schema::create('brgy_officials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position'); // Captain, Kagawad, Tanod, etc.
            $table->string('photo')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('purok_assigned')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brgy_officials');
    }
};
