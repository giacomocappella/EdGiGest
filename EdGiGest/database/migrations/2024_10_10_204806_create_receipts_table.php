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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->integer('Anno');
            $table->integer('Numero');
            $table->date('Data');
            $table->decimal('Importo_Lordo',5,2);
            $table->decimal('Importo_Netto',5,2);
            $table->string('Percorso_File')->nullable();
            $table->string('P_IVA_CF_Cliente');
            $table->string('CF_Sistemista');

            $table->foreign('P_IVA_CF_Cliente')
                  ->references('Partita_IVA_CF')
                  ->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('CF_Sistemista')
            ->references('Codice_Fiscale')
            ->on('system_admins')
            ->onDelete('cascade')
            ->onUpdate('cascade');
            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
