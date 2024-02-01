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
            $table->string('statut');
            $table->string('numero_Identification');
            $table->string('new_programme');
            $table->string('prenom');
            $table->string('nom');
            $table->string('age');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('poste_avortement');
            $table->string('poste_partum');
            $table->string('pilule');
            $table->string('dui');
            $table->string('injection');
            $table->string('implant');
            $table->string('anneau_vaginale_a_progresterone');
            $table->string('condom');
            $table->string('cu');
            $table->string('methode_naturelle');
            $table->string('preciser_autres_methodes');
            $table->string('raison_de_la_visite');
            $table->string('indication');
            $table->string('effets_indesirables_complications');
            $table->string('service_additiojnale');
            $table->string('observation');
            $table->date('date_visite');
            $table->date('date_prochain_rv');
            $table->date('tout');
            $table->date('hrz');
            
            $table->unsignedBigInteger('personnelsante_id');
            $table->foreign('personnelsante_id')->references('id')->on('personnel_santes')->onDelete('cascade');

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
