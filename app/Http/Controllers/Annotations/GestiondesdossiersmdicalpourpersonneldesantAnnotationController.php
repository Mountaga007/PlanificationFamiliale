<?php

namespace App\Http\Controllers\Annotations ;

/**
 * @OA\Security(
 *     security={
 *         "BearerAuth": {}
 *     }),

 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"),

 * @OA\Info(
 *     title="Planification Familiale",
 *     description="La digitalisation de la Planification Familiale au Sénégal vise à améliorer l'accès et la qualité des services de Planification Familiale grâce aux TIC. L'objectif principal est de développer une application dédiée qui facilite l'accès aux informations, aux services et aux ressources liées à la planification familiale, tant pour les professionnels de la santé que pour le grand public.",
 *     version="1.0.0"),

 * @OA\Consumes({
 *     "multipart/form-data"
 * }),

 *

 * @OA\GET(
 *     path="/api/Details_DM/{dossierMedical}",
 *     summary="Détail d'un dossier médical pour PS",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="dossierMedical", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des dossiers médical pour personnel de santé"},
*),


 * @OA\GET(
 *     path="/api/listes_generale_DM",
 *     summary="Liste générale des dossiers médicaux pour l'admin",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des dossiers médical pour personnel de santé"},
*),


 * @OA\POST(
 *     path="/api/telechargers_DM/{id}",
 *     summary="Télécharger un dossier médical",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des dossiers médical pour personnel de santé"},
*),


 * @OA\DELETE(
 *     path="/api/archiver_DM/{dossier_Medical}",
 *     summary="Archiver un dossier médical",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="dossier_Medical", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des dossiers médical pour personnel de santé"},
*),


 * @OA\POST(
 *     path="/api/update_DM/{dossier_Medical}",
 *     summary="Update d'une dossier médical",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="path", name="dossier_Medical", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="numero_Identification", type="string"),
 *                     @OA\Property(property="age", type="string"),
 *                     @OA\Property(property="poste_avortement", type="string"),
 *                     @OA\Property(property="poste_partum", type="string"),
 *                     @OA\Property(property="methode_en_cours", type="string"),
 *                     @OA\Property(property="methode_choisie", type="string"),
 *                     @OA\Property(property="preciser_autres_methodes", type="string"),
 *                     @OA\Property(property="raison_de_la_visite", type="string"),
 *                     @OA\Property(property="indication", type="string"),
 *                     @OA\Property(property="effets_indesirables_complications", type="string"),
 *                     @OA\Property(property="date_visite", type="string"),
 *                     @OA\Property(property="date_prochain_rv", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion des dossiers médical pour personnel de santé"},
*),


 * @OA\GET(
 *     path="/api/Detail_DM/{dossierMedical}",
 *     summary="Détail d'un dossier médical pour l'admin",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="dossierMedical", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des dossiers médical pour personnel de santé"},
*),


 * @OA\GET(
 *     path="/api/listes_totale_DM",
 *     summary="Liste des dossiers médicaux créés par un PS",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des dossiers médical pour personnel de santé"},
*),


 * @OA\POST(
 *     path="/api/enregistrer_Dossier_Medical",
 *     summary="Enregistrer un dossier médical",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="201", description="Created successfully"),
 * @OA\Response(response="400", description="Bad Request"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="prenom", type="string"),
 *                     @OA\Property(property="nom", type="string"),
 *                     @OA\Property(property="telephone", type="string"),
 *                     @OA\Property(property="adresse", type="string"),
 *                     @OA\Property(property="email", type="string"),
 *                     @OA\Property(property="statut", type="string"),
 *                     @OA\Property(property="numero_Identification", type="string"),
 *                     @OA\Property(property="age", type="string"),
 *                     @OA\Property(property="poste_avortement", type="string"),
 *                     @OA\Property(property="poste_partum", type="string"),
 *                     @OA\Property(property="methode_en_cours", type="string"),
 *                     @OA\Property(property="methode_choisie", type="string"),
 *                     @OA\Property(property="preciser_autres_methodes", type="string"),
 *                     @OA\Property(property="raison_de_la_visite", type="string"),
 *                     @OA\Property(property="indication", type="string"),
 *                     @OA\Property(property="effets_indesirables_complications", type="string"),
 *                     @OA\Property(property="date_visite", type="string"),
 *                     @OA\Property(property="date_prochain_rv", type="string"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion des dossiers médical pour personnel de santé"},
*),


*/

 class GestiondesdossiersmdicalpourpersonneldesantAnnotationController {}
