<?php
/*
 * Name: Chunhai Yang
 * IT328
 * midterm survey
 */
//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

//Require the autoload file
require_once("vendor/autoload.php");
require_once("models/validate.php");

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

        //Validate the data
//        if (empty($_POST['name']) || !in_array($_POST['options'], $options)) {
//            echo "<p>Please enter your name and select an option</p>";
//        }

          if(!validName($_POST['name'])){

              // set an error variable in the F3 hive
              $f3->set('errors["name"]', "Enter a valid name");
          }

          if(!isset($_POST['options'])){

              // set an error variable in the F3 hive
              $f3->set('errors["options"]',"Please select at least one");
          }
          if(empty($f3->get('errors'))){
              //Store the data in the session array
              $_SESSION['name'] = $_POST['name'];
              $_SESSION['options'] = $_POST['options'];

              //Redirect to summary page
              $f3->reroute('summary');
              session_destroy();
          }

    }

   $f3->set('options', $options);
    $f3->set('name', $_POST['name']);
    $f3->set('selectedOption', $_POST['option']);


    $view = new Template();
    echo $view->render('views/survey.html');

});

//summary route
$f3->route('GET /summary', function() {

    $view = new Template();
    echo $view->render('views/summary.html');

});


//Run F3
$f3->run();