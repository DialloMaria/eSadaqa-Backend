<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Don extends Model
{
    use HasFactory;
    protected $fillable = ['libelle', 'description', 'categorie', 'status', 'adresse', 'image', 'user_id'];

    // Relation avec TypeProduit
    public function typeProduits()
    {
        return $this->hasMany(TypeProduit::class);
    }
}
