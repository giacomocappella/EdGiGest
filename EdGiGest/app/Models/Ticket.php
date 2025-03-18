<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'Nome',
        'Ore_totali',
        'Partita_IVA_CF_Cliente',
        'Stato',
        'Rendicontato',
        'Doppio_tecnico',
    ];

    protected $casts = [
        'Ore_totali' => 'decimal:10',
        'Rendicontato' => 'boolean',
        'Doppio_tecnico' => 'boolean',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'Partita_IVA_CF_Cliente', 'Partita_IVA_CF');
    }

    public function tasks()
{
    return $this->hasMany(Task::class, 'Ticket_ID'); 
}
}
