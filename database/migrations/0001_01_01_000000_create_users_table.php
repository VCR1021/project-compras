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
        /*
         * =================================================================
         * ⚠️ PROHIBIDO DESCOMENTAR ESTE BLOQUE ⚠️
         * =================================================================
         * La tabla 'users' ya fue creada, estructurada e insertada manualmente 
         * mediante el script SQL en la base de datos (Workbench) para cumplir 
         * con los requerimientos específicos del negocio (first_name, role, etc.).
         * Si se descomenta este bloque, Laravel intentará crear la tabla de nuevo 
         * y causará un error fatal de "Table already exists".
         */
        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->timestamps();
        // });

        // Estas tablas SÍ deben crearse, son exclusivas del sistema de Laravel
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /* * Comentado por seguridad: Evita que Laravel borre tu tabla 
         * original de usuarios si algún día ejecutas un 'migrate:rollback'
         */
        // Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};