<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'Data',
        'Ora_inzio',
        'Ora_fine',
        'Descrizione',
        'Ticket_ID',
        'Durata'

    ];

    // Relazione con Ticket
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'Ticket_ID', 'id');
    }
}
