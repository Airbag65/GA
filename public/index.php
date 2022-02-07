<?php
session_start();

require_once "../vendor/autoload.php";
require_once "../vendor/pecee/simple-router/helpers.php";
require_once "../App/functional/functions.php";
require_once "../App/functional/twigFunctions.php";

$pdo = initDb();

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', function (){
    require "../App/home.php";
});

SimpleRouter::get('/home', function (){
    requireLogin();
    require "../App/home.php";
});

SimpleRouter::get('/logout', function (){
    require "../App/functional/sessionKill.php";
});

SimpleRouter::get("/profile", function (){
   require "../App/profile/profile.php";
});

SimpleRouter::get("/login", function (){
    require "../App/login.php";
});

SimpleRouter::get("/addData", function (){
   require "../App/functional/addIcdData.php";
});

SimpleRouter::post("/auth", function (){
    require "../App/functional/auth.php";
});

SimpleRouter::get("/profile", function(){
    require "../App/profile/profile.php";
});

SimpleRouter::get("/admin", function(){
    require "../App/profile/admin.php";
});

SimpleRouter::post("/save-patient", function(){
    require "../App/functional/savePatient.php";
});

SimpleRouter::post("/save-personell", function(){
    require "../App/functional/savePersonell.php";
});

SimpleRouter::post("/search", function (){
    require "../App/functional/search.php";
});

SimpleRouter::get("/meeting/{id}", function ($id){
    require "../App/journalanteckning/meeting.php?id=$id";
});

SimpleRouter::get("/journal/{id}", function ($id){
    require "../App/journalanteckning/journal.php?id=$id";
});

SimpleRouter::error(function(Request $request, \Exception $exception) {

    switch($exception->getCode()) {
        case 404:
            response()->redirect('/');
            break;
        default:
            response()->redirect('/');
    }

});

SimpleRouter:: start();

