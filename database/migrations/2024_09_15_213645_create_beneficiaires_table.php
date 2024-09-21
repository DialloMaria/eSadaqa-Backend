<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('beneficiaires', function (Blueprint $table) {
            $table->id();
            $table->string('nomstructure');
            $table->integer('telstructure')->nullable()->unique();
            $table->string('emailstructure')->nullable()->unique();
            $table->text('description');
            $table->string('logo')->nullable();
            $table->string('adresse')->nullable();
            $table->string('fondateur');
            $table->date('date_creation');
            $table->string('recepisse');
            $table->foreignIdFor(User::class)->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaires');
    }
};
