<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->bigIncrements('id')->startingValue(1000)->primary(); 
            $table->string('Nome');
            $table->decimal('Ore_totali', 8, 2);
            $table->string('Partita_IVA_CF_Cliente');
            $table->string('Stato');
            $table->boolean('Rendicontato')->default(false);
            $table->boolean('Doppio_tecnico')->default(false);
            $table->timestamps();

            // Foreign key
            $table->foreign('Partita_IVA_CF_Cliente')
                  ->references('Partita_IVA_CF')
                  ->on('clients')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
