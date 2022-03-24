<?php
session_start();

require_once "../vendor/autoload.php";
require_once "../vendor/pecee/simple-router/helpers.php";
require_once "../App/functional/functions.php";
require_once "../App/functional/twigFunctions.php";
require_once "../App/classes/User.php";

$pdo = initDb();

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', function (){
    requireLogin();
    require "../App/home.php";
    exit;
});

SimpleRouter::get('/home', function (){
    requireLogin();
    require "../App/home.php";
    exit;
});

SimpleRouter::get('/logout', function (){
    require "../App/functional/sessionKill.php";
    exit;
});

SimpleRouter::get("/profile", function (){
    requireLogin();
   require "../App/profile/profile.php";
   exit;
});

SimpleRouter::get("/login", function (){
    require "../App/login.php";
    exit;
});

SimpleRouter::get("/addData", function (){
   require "../App/functional/addIcdData.php";
   exit;
});

SimpleRouter::post("/auth", function (){
    require "../App/functional/auth.php";
    exit;
});

SimpleRouter::get("/admin", function(){
    requireLogin();
    require "../App/profile/admin.php";
    exit;
});

SimpleRouter::post("/save-patient", function(){
    requireLogin();
    require "../App/functional/savePatient.php";
    exit;
});

SimpleRouter::post("/save-personell", function(){
    requireLogin();
    require "../App/functional/savePersonell.php";
    exit;
});

SimpleRouter::post("/search", function (){
    requireLogin();
    require "../App/functional/search.php";
    exit;
});

SimpleRouter::get("/meeting/{id}", function ($id){
    requireLogin();
    require "../App/journalanteckning/meeting.php";
    exit;
});

SimpleRouter::post("/meeting", function (){
    requireLogin();
    require "../App/functional/saveMeeting.php";
    exit;
});

SimpleRouter::get("/journal/{id}", function ($id){
    requireLogin();
    require "../App/journalanteckning/journal.php";
    exit;
});

SimpleRouter::get("/save-bloodgroup/{id}", function($id){
    requireLogin();
    require "../App/edit/editBloodGroup.php";
    exit;
});

SimpleRouter::post("/save-bloodgroup", function(){
    requireLogin();
    require "../App/functional/saveBloodGroup.php";
    exit;
});

SimpleRouter::get("/images/", function (){
    requireLogin();
    header("Location: /");
    exit;
});

SimpleRouter::get("/hidden", function () {
   requireLogin();
   require "../App/hidden/index.php";
   exit;
});

SimpleRouter::get("/hidden/api", function (){
   requireLogin();
   require "../App/hidden/api.php";
   exit;
});

SimpleRouter::get("/hidden/api/{id}", function ($id){
    requireLogin();
    require "../App/hidden/details.php";
    exit;
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

SimpleRouter::start();

