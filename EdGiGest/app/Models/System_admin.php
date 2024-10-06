<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System_admin extends Model
{
    use HasFactory;

    //disabilito i campi automatici update e create at
    public $timestamps = false;

    protected $fillable = [
        'Nome',
        'Cognome',
        'Codice_Fiscale',
        'Indirizzo_Mail',
        'Password',
        'Via',
        'Civico',
        'Citta',
        'Cap',
        'Provincia',
    ];

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
}
