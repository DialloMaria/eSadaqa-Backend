<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeProduit extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'quantite', 'montant', 'mode_paiement', 'don_id'];

    // Relation avec Don
    public function don()
    {
        return $this->belongsTo(Don::class);
    }
}
