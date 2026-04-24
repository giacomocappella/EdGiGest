<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'numero',
        'anno',
        'data_emissione',
        'progressivo_invio',
        'client_id',
        'sistemista_id',
        'prezzo_totale',
        'aliquota_iva',
        'natura',
        'modalita_pagamento',
        'data_scandenza',
        'percorso_xml',
        'percorso_pdf',
        'stato',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class, 'Partita_IVA_CF', 'client_id');
    }

}
