<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->date('Data'); 
            $table->time('Ora_inizio'); 
            $table->time('Ora_fine'); 
            $table->unsignedBigInteger('Ticket_ID');
            $table->timestamps();

            // Definizione della chiave esterna
            $table->foreign('Ticket_ID')
                  ->references('id')
                  ->on('tickets')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
