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
        Schema::create('user_clients', function (Blueprint $table) {
            $table->string('Indirizzo_Mail')->primay();
            $table->string('Password');
            $table->string('P_IVA_CF_Cliente');
            $table->foreign('P_IVA_CF_Cliente')
                  ->references('Partita_IVA_CF')
                  ->on('clients')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->datetime('ultimo accesso');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_clients');
    }
};
