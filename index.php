<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

//Require the autoload file
require_once("vendor/autoload.php");
//require_once("models/data-layer.php");


//Instantiate the F3 Base class
$f3 = Base::instance();

//Default route
$f3->route('GET /', function() {

    $view = new Template();
    echo $view->render('views/home.html');
});

//survey route
$f3->route('GET|POST /survey', function($f3) {

      //$options = getOptions();

    $options = array("this midterm is easy", "i like midterms", "today is Monday");

    $f3->set('options', $options);
    $view = new Template();
    echo $view->render('views/survey.html');

});


//Run F3
$f3->run();