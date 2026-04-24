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
        Schema::table('users', function (Blueprint $table) {
            $table->string('Partita_Iva', 20)->nullable()->after('CF');

            $table->decimal('Costo_orario_netto', 5, 2)->after('Partita_Iva');

            $table->string('Tipo_collab')->after('Costo_orario_netto');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn(['Partita_Iva', 'Costo_orario_netto', 'Tipo_collab']);
        });
    }
};
