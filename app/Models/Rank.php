<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_evoluer';
    protected $fillable = ['note', 'date', 'id_utilisateur', 'id_evenement'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_utilisateur');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'id_evenement');
    }
}
