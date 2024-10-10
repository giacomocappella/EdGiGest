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
        Schema::create('system_admins', function (Blueprint $table) {
            $table->string('Nome');
            $table->string('Cognome');
            $table->string('Codice_Fiscale')->primary();
            $table->string('Indirizzo_Mail');
            $table->string('Password');
            $table->string('Via');
            $table->string('Civico');
            $table->string('Citta');
            $table->integer('Cap');
            $table->string('Provincia');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_admins');
    }
};
