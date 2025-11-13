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
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('purok')->nullable();
            $table->string('street')->nullable();
            $table->foreignId('assigned_official_id')->nullable()->constrained('brgy_officials')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign(['assigned_official_id']);
            $table->dropColumn(['purok', 'street', 'assigned_official_id']);
        });
    }
};
