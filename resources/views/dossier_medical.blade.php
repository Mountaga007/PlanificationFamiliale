<!DOCTYPE html>
<html>
<head>
    <title>Dossier Médical</title>
    <style>
        /* Styles CSS pour la vue du dossier médical */
        /* Ajoutez vos styles personnalisés ici */
    </style>
</head>
<body>
    <h1>Dossier Médical</h1>
    
    <h2>Informations du Patient</h2>
    <p>Nom du patient : {{ $dossierMedical['user']['nom'] }}</p>
    <p>Email du patient : {{ $dossierMedical['user']['email'] }}</p>
    <p>Téléphone du patient : {{ $dossierMedical['user']['telephone'] }}</p>
    <p>Image du patient : {{ $dossierMedical['user']['image'] }}</p>
    <p>Rôle du patient : {{ $dossierMedical['user']['role'] }}</p>

    <h2>Informations Médicales</h2>
    <p>Identificant de l'utilisateur : {{ $dossierMedical['id'] }}</p>
    <p>Statut : {{ $dossierMedical['statut'] }}</p>
    <p>Numéro d'identification du dossier médical : {{ $dossierMedical['numero_Identification'] }}</p>
    <p>Âge de l'utilisateur : {{ $dossierMedical['age'] }}</p>
    <p>Poste avortement : {{ $dossierMedical['poste_avortement'] }}</p>
    <p>Post parfum : {{ $dossierMedical['poste_partum'] }}</p>
    <p>Méthode en cours : {{ $dossierMedical['methode_en_cours'] }}</p>
    <p>Méthode : {{ $dossierMedical['methode'] }}</p>
    <p>Méthode choisie : {{ $dossierMedical['methode_choisie'] }}</p>
    <p>Préciser autres méthodes : {{ $dossierMedical['preciser_autres_methodes'] }}</p>
    <p>Raison de la visite : {{ $dossierMedical['raison_de_la_visite'] }}</p>
    <p>Indication : {{ $dossierMedical['indication'] }}</p>
    <p>Effets indésirables ou complications : {{ $dossierMedical['effets_indesirables_complications'] }}</p>
    <p>Date de visite : {{ $dossierMedical['date_visite'] }}</p>
    <p>Date du prochain rendez-vous : {{ $dossierMedical['date_prochain_rv'] }}</p>

</body>
</html>
