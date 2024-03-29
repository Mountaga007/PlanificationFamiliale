<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identifiants de Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .colAuth {
            background-color: #222222ce;
            color: white;
            padding: 3vh;
        }

        .colAuth h3 {
            color: #F2743B;
            font-weight: bold;
        }

        .card {
            margin: 0 auto;
            border: none;
            border-radius: 2vh;
        }

        .card img {
            width: 100%;
            height: 100%;
        }

        .logo {
            max-width: 25vh !important;
            height: 8vh;
            margin: 5vh 0;
        }

        .card .btnAuth {
            background-color: #F2743B;
            color: white;
            margin-top: 5vh;
        }

        .require {
            color: #2CCED2;
        }

        .containerConnexion {
            min-height: 80vh;
        }

        .containerConnexion .card img {
            max-height: 60vh;
        }
    </style>
</head>

<body>
    <div class="containerConnexion  py-5">
        <div class="card mb-3" style="max-width: 840px;">
            <div class="row g-0">
                <div class="col-md-6">
                    
                    <!-- Remplacer src par le chemin de l'image -->
                    <img src="https://ibb.co/LdtsV8d" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col-md-6 colAuth rounded-end">
                    <div class="card-body"> 
                        <h3 class="card-title text-center">RENDEZ-VOUS</h3>
                        <div class="text-center">
                            <img src="https://ibb.co/LdtsV8d" alt="Logo Planification Familiale, DEBBO" class="logo">
                        </div>
                            <div>
                                <p class="fs-5 mt-4">Bonjour {{ $prenom }} {{ $nom }} ,</p>
                                <p class="fs-5 mt-4">Votre prochaine rendez-vous est le :
                                    <strong> 
                                        {{ $date_prochain_rv }}
                                    </strong>
                                </p>
                            </div>
                        <div class="text-center">
                            <p class="fs-5 mt-4">Cordialement {{ $nom_personnel }}</p>
                           <!-- <a href="http://localhost:4200/login" style="color: white">Login</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>