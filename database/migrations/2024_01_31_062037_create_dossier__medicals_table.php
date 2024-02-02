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
        Schema::create('dossier__medicals', function (Blueprint $table) {
            $table->id();
            $table->string('statut')->nullable();
            $table->string('numero_Identification')->nullable();
            $table->integer('age')->nullable();
            $table->boolean('poste_avortement')->default(false);
            $table->boolean('poste_partum')->default(false);
            $table->enum('methode_en_cours', ['pilule','dui','injection','implant','anneau_vaginale_a_progresterone','condom','cu'])->nullable();
            $table->enum('methode', ['pilule','dui','injection','implant','anneau_vaginale_a_progresterone','condom','cu'])->nullable();
            $table->enum('methode_choisie', ['pilule','dui','injection','implant','anneau_vaginale_a_progresterone','condom','cu'])->nullable();
            $table->string('preciser_autres_methodes')->nullable(); 
            $table->string('raison_de_la_visite')->nullable();
            $table->string('indication')->nullable();
            $table->string('effets_indesirables_complications')->nullable();
            $table->date('date_visite')->nullable();
            $table->date('date_prochain_rv')->nullable();

            $table->unsignedBigInteger('personnelsante_id');
            $table->foreign('personnelsante_id')->references('id')->on('personnel_santes')->onDelete('cascade');

            $table->unsignedBigInteger('patiente_id');
            $table->foreign('patiente_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier__medicals');
    }
};
