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

 * @OA\DELETE(
 *     path="/api/supprimer_information/{id}",
 *     summary="Supprimer information",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des contenues"},
*),


 * @OA\DELETE(
 *     path="/api/supprimer_ressource/{id}",
 *     summary="Supprimer ressource",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="204", description="Deleted successfully"),
 * @OA\Response(response="401", description="Unauthorized"),
 * @OA\Response(response="403", description="Forbidden"),
 * @OA\Response(response="404", description="Not Found"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des contenues"},
*),


 * @OA\POST(
 *     path="/api/update_information/{id}",
 *     summary="Update information",
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
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="texte", type="string"),
 *                     @OA\Property(property="image", type="string", format="binary"),
 *                     @OA\Property(property="document", type="string", format="binary"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion des contenues"},
*),


 * @OA\POST(
 *     path="/api/update_ressource/{id}",
 *     summary="Update ressource",
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
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 type="object",
 *                 properties={
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="texte", type="string"),
 *                     @OA\Property(property="image", type="string", format="binary"),
 *                     @OA\Property(property="document", type="string", format="binary"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion des contenues"},
*),


 * @OA\POST(
 *     path="/api/create_information",
 *     summary="Créer une information",
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
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="texte", type="string"),
 *                     @OA\Property(property="image", type="string", format="binary"),
 *                     @OA\Property(property="document", type="string", format="binary"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion des contenues"},
*),


 * @OA\POST(
 *     path="/api/create_ressource",
 *     summary="Créer une ressource",
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
 *                     @OA\Property(property="titre", type="string"),
 *                     @OA\Property(property="texte", type="string"),
 *                     @OA\Property(property="image", type="string", format="binary"),
 *                     @OA\Property(property="document", type="string", format="binary"),
 *                 },
 *             ),
 *         ),
 *     ),
 *     tags={"Gestion des contenues"},
*),


 * @OA\GET(
 *     path="/api/detail_information/{id}",
 *     summary="Détail d'une information",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des contenues"},
*),


 * @OA\GET(
 *     path="/api/liste_information",
 *     summary="Liste des informations",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des contenues"},
*),


 * @OA\GET(
 *     path="/api/detail_ressource/{id}",
 *     summary="Détail d'une ressource",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="path", name="id", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des contenues"},
*),


 * @OA\GET(
 *     path="/api/liste_ressource",
 *     summary="Liste des ressources",
 *     description="",
 *         security={
 *    {       "BearerAuth": {}}
 *         },
 * @OA\Response(response="200", description="OK"),
 * @OA\Response(response="404", description="Not Found"),
 * @OA\Response(response="500", description="Internal Server Error"),
 *     @OA\Parameter(in="header", name="User-Agent", required=false, @OA\Schema(type="string")
 * ),
 *     @OA\Parameter(in="header", name="Authorization", required=false, @OA\Schema(type="string")
 * ),
 *     tags={"Gestion des contenues"},
*),


*/

 class GestiondescontenuesAnnotationController {}
