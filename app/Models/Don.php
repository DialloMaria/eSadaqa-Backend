<?php

namespace App\Models;

use App\Models\User;
use App\Models\TypeProduit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Don extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'description', 'categorie', 'status', 'adresse', 'image', 'user_id'];

    // Relation avec TypeProduit
    public function typeProduits()
    {
        return $this->hasMany(TypeProduit::class);
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
}
