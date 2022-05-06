<?php
session_start();

require_once "../vendor/autoload.php";
require_once "../vendor/pecee/simple-router/helpers.php";
require_once "../App/functional/functions.php";
require_once "../App/functional/twigFunctions.php";
require_once "../App/classes/User.php";
require_once "../vendor/ezyang/htmlpurifier/library/HTMLPurifier.auto.php";

$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);


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
    if(isset($_SESSION['loggedin'])){
        if($_SESSION['loggedin'] == true){
            header("Location: /");
        }
        else{
            require "../App/login.php";
        }
    }else{
        require "../App/login.php";
    }
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

SimpleRouter::post("/update-setting", function (){
    requireLogin();
    require "../App/functional/updateSetting.php";
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

