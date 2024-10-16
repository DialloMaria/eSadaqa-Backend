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
        Schema::table('dons', function (Blueprint $table) {
            $table->enum('status', ['publie', 'en_attente', 'confirme', 'en_cours', 'distribue'])->default('publie');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dons', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
