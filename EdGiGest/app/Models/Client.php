<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    //disabilito i campi automatici update e create at
    public $timestamps = false;

    public $primaryKey='Partita_IVA_CF';

    public $incrementing = false;

    protected $keyType = 'string';

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
        'Provincia',
    ];

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function tickets()
{
    return $this->hasMany(Ticket::class, 'Partita_IVA_CF_Cliente'); 
}


}
