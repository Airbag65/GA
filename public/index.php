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
    //requireLogin();
    require "../App/home.php";
});

SimpleRouter::get('/logout', function (){
    require "../App/functional/sessionKill.php";
});

SimpleRouter::get("/profile", function (){
   require "../App/profile/profile.php";
});

SimpleRouter::get("/login", function (){
    echo "login/";
    var_dump($_SESSION);
    require "../App/login.php";
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

