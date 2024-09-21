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

    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'organisation_id'); // Assurez-vous que 'organisation_id' est la clé étrangère correcte
    }

    const STATUS_EN_ATTENTE = 'en_attente';
    const STATUS_RESERVE = 'reserve';
    const STATUS_DISTRIBUE = 'distribue';


    public function setStatusEnAttente()
    {
        $this->status = self::STATUS_EN_ATTENTE;
        $this->save();
    }

    public function setStatusReserve()
    {
        $this->status = self::STATUS_RESERVE;
        $this->save();
    }

    public function setStatusDistribue()
    {
        $this->status = self::STATUS_DISTRIBUE;
        $this->save();
    }
}
