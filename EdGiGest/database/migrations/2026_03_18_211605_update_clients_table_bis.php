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
        Schema::table('clients', function (Blueprint $table) {
            $table->string('Cod_destinatario', 7)->nullable();
            $table->string('PEC')->nullable();
            $table->string('Codice_Fiscale', 16)->nullable()->after('Partita_IVA_CF');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['Cod_destinatario', 'PEC', 'Codice_Fiscale']);
        });
    }
};
