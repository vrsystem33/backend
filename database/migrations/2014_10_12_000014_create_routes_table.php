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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('http_method'); // Método HTTP (GET, POST, etc.)
            $table->string('url'); // Caminho da rota
            $table->string('controller'); // Classe do controller
            $table->string('action'); // Método do controller
            $table->string('group')->nullable(); // Grupo ex: 'users' (opcional)
            $table->json('scopes'); // Escopos de acesso
            $table->boolean('status')->default(true); // Se rota está ativa, Padrão TRUE
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
