<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            
            // DATI DOCUMENTO
            $table->integer('numero');
            $table->integer('anno');
            $table->date('data_emissione');
            $table->string('tipo_documento')->default('TD01');
            $table->string('progressivo_invio', 10)->unique();

            // RELAZIONI
            $table->string('client_id'); // Partita_IVA_CF
            $table->unsignedBigInteger('sistemista_id');   // CF_Sistemista

            // IMPORTI
            $table->decimal('prezzo_totale', 10, 2);
            $table->decimal('importo_totale', 10, 2);

            // IVA
            $table->decimal('aliquota_iva', 5, 2)->default(0.00);
            $table->string('natura')->default('N2.2');

            // PAGAMENTO
            $table->string('modalita_pagamento')->default('MP05'); // bonifico
            $table->date('data_scadenza')->nullable();

            // FILE E STATO
            $table->string('percorso_xml')->nullable();
            $table->string('stato')->default('bozza'); // bozza, generato, inviato, scartato, incassato

            $table->timestamps();

            // FOREIGN KEY (opzionali ma consigliati)
            $table->foreign('client_id')
                  ->references('Partita_IVA_CF')
                  ->on('clients')
                  ->onDelete('cascade');

            $table->foreign('sistemista_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
 
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_invoices');
    }
};
