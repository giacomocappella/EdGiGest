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
            $table->string('Partita_IVA_CF')->nullable(false)->change()->primary();
        });

        DB::statement('
            ALTER TABLE clients 
                DROP PRIMARY KEY, 
                DROP COLUMN id, 
                DROP COLUMN created_at, 
                DROP COLUMN updated_at, 
                ADD PRIMARY KEY (Partita_IVA_CF)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('
            ALTER TABLE clients 
                DROP PRIMARY KEY, 
                ADD COLUMN id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                ADD COLUMN created_at TIMESTAMP NULL, 
                ADD COLUMN updated_at TIMESTAMP NULL
        ');

        Schema::table('clients', function (Blueprint $table) {
            $table->dropUnique(['Partita_IVA_CF']);
        });
    }
};
