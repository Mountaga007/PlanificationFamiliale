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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('telephone');
            $table->string('image')->nullable();
            $table->enum('role', ['utilisateur','personnelsante','patiente','admin'])->default('utilisateur');
            $table->boolean('statut_compte')->default(false);

            // $table->unsignedBigInteger('dossier_medical_id');
            // $table->foreign('dossier_medical_id')->references('id')->on('dossier__medicals')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
