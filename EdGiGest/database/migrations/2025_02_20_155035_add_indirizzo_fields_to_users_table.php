<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('CF')->nullable();
            $table->string('Via')->nullable();
            $table->string('Civico')->nullable();
            $table->string('Citta')->nullable();
            $table->string('CAP')->nullable();
            $table->string('Provincia')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['CF', 'Via', 'Civico', 'Citta', 'CAP', 'Provincia']);
        });
    }
};

