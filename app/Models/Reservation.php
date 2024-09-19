<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'don_id', 'beneficiaire_id'];

    // Relation avec Don
    public function don()
    {
        return $this->belongsTo(Don::class);
    }

        // Relation avec le modèle User (créateur)
        public function creator()
        {
            return $this->belongsTo(User::class, 'created_by');
        }

        // Relation avec le modèle User (modificateur)
        public function modifier()
        {
            return $this->belongsTo(User::class, 'modified_by');
        }

        // Relation avec Beneficiaire
        public function beneficiaire()
        {
            return $this->belongsTo(Beneficiaire::class);
        }
}
