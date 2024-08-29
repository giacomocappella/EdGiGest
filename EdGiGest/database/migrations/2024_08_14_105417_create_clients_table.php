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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('Ragione_Sociale');
            $table->string('Partita_IVA_CF');
            $table->string('Mail_amministrazione');
            $table->string('Mail_ticket');
            $table->string('Contatto_telefonico')->nullable();
            $table->string('Via');
            $table->string('Civico');
            $table->string('Citta');
            $table->integer('Cap');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
