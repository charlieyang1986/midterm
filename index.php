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

    $options = array("This midterm is easy", "I like midterms", "Today is Monday");

    //If the form has been submitted
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        //Store the data in the session array
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['options'] = $_POST['options'];


        //Redirect to summary page
        $f3->reroute('summary');
    }


    $f3->set('options', $options);
    $view = new Template();
    echo $view->render('views/survey.html');

});

//summary route
$f3->route('GET /summary', function() {

    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();
});


//Run F3
$f3->run();