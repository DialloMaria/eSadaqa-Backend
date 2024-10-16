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
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo_profile')->nullable()->default('https://www.google.com/url?sa=i&url=https%3A%2F%2Ffr.freepik.com%2Fphotos-vecteurs-libre%2Fplaceholder&psig=AOvVaw2hzhD2CLqHB340xcKDJnzZ&ust=1729082423374000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCLD77pe0kIkDFQAAAAAdAAAAABAJ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('photo_profile');
        });
    }
};
