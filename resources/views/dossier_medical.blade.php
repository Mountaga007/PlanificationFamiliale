<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier Médical</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        h1, h2 {
            color: #333;
        }

        p {
            margin-bottom: 10px;
        }

        .user-info, .medical-info {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }

        /* Ajoutez vos styles personnalisés ici */
    </style>
</head>
<body>
    <h1>Dossier Médical</h1>

    <div class="user-info">
        <h2>Informations de l'utilisateur</h2>
            <p>Prenom de l'utilisateur : {{ $dossierMedical['prenom'] }}</p>
            <p>Nom de l'utilisateur : {{ $dossierMedical['nom'] }}</p>
            <p>Telephone de l'utilisateur : {{ $dossierMedical['telephone'] }}</p>
            <p>Adresse de l'utilisateur : {{ $dossierMedical['adresse'] }}</p>
            <p>Email de l'utilisateur : {{ $dossierMedical['email'] }}</p>
    </div>

    <div class="medical-info">
        <h2>Informations Médicales</h2>
        <p>Statut : {{ $dossierMedical['statut'] }}</p>
        <p>Numéro d'identification du dossier médical : {{ $dossierMedical['numero_Identification'] }}</p>
        <p>Âge de l'utilisateur : {{ $dossierMedical['age'] }}</p>
        <p>Poste avortement : {{ $dossierMedical['poste_avortement'] }}</p>
        <p>Post parfum : {{ $dossierMedical['poste_partum'] }}</p>
        <p>Méthode en cours : {{ $dossierMedical['methode_en_cours'] }}</p>
        <p>Méthode choisie : {{ $dossierMedical['methode_choisie'] }}</p>
        <p>Préciser autres méthodes : {{ $dossierMedical['preciser_autres_methodes'] }}</p>
        <p>Raison de la visite : {{ $dossierMedical['raison_de_la_visite'] }}</p>
        <p>Indication : {{ $dossierMedical['indication'] }}</p>
        <p>Effets indésirables ou complications : {{ $dossierMedical['effets_indesirables_complications'] }}</p>
        <p>Date de visite : {{ $dossierMedical['date_visite'] }}</p>
        <p>Date du prochain rendez-vous : {{ $dossierMedical['date_prochain_rv'] }}</p>
    </div>

</body>
</html>
