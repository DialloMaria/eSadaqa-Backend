<?php

use App\Models\Don;
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
        Schema::create('type_produits', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->integer('quantite');
            $table->decimal('montant', 8, 2);
            $table->string('mode_paiement');
            $table->foreignIdFor(Don::class)->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_produits');
    }
};
