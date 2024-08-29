<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'Ragione_Sociale',
        'Partita_IVA_CF',
        'Mail_amministrazione',
        'Mail_ticket',
        'Contatto_telefonico',
        'Via',
        'Civico',
        'Citta',
        'Cap',
    ];
}