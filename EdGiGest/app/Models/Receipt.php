<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'Anno',
        'Numero',
        'Data',
        'Importo_Lordo',
        'Importo_Netto',
        'Percorso_File',
        'P_IVA_CF_Cliente',
        'CF_Sistemista',
    ];
    public $timestamps = false;

    public function client()
    {
        return $this->belongsTo(Client::class, 'Partita_IVA_CF', 'P_IVA_CF_Cliente');
    }

    public function system_admin()
    {
        return $this->belongsTo(System_admin::class);
    }
}
