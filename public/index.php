<?php
session_start();

require_once "../vendor/autoload.php";
require_once "../vendor/pecee/simple-router/helpers.php";
require_once "../App/functional/functions.php";
require_once "../App/functional/twigFunctions.php";

use Pecee\Http\Request;
use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', function (){
    requireLogin();
    require "../App/home.php";
});

SimpleRouter::get('/home', function (){
//    require "../App/home.php";
    echo "/home";
});

SimpleRouter::get('/logout', function (){
    session_destroy();
    header("Location: /");
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

