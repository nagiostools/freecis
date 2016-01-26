<?php

// Load configuration
require 'config/config.php';

// Include some useful helper functions
require 'lib/DbHelper.class.php';

// include and register Twig auto-loader
include 'lib/Twig/Autoloader.php';
Twig_Autoloader::register();

// Connect to the database
$dsn = $cisConfig['db']['dsn'] . ":host=" . $cisConfig['db']['dbhost'] . ";dbname=" . $cisConfig['db']['dbname'];
try {
    $dbh = new PDO($dsn, $cisConfig['db']['dbuser'], $cisConfig['db']['dbpasswd']);
} catch (PDOException $e) {
    echo "Error: Could not connect. " . $e->getMessage();
}
// set error mode
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// We need to see if a command has been issued
$cmd = $_REQUEST['cmd'];

// attempt some queries
try {

        // Set up our helper
        $dbHelper = new DbHelper( $dbh );

        // Get categories and things...
        $categories  = $dbHelper->getCategories();
        $products    = $dbHelper->getProducts();

        // close connection, clean up
        #unset($dbh);

        // define template directory location
        $loader = new Twig_Loader_Filesystem('views');

        // initialize Twig environment
        $twig = new Twig_Environment($loader);

        if ( $cmd == "search_criteria" ) {

                // load template
                $template = $twig->loadTemplate('categories.tmpl');

                // set template variables
                // render template
                echo $template->render(array (

                        'categories' => $categories,
                        'departments' => $departments,
                        'clients' => $clients
                 ));
        } else if ( $cmd == "blaha" ) {
        } else {
                $template = $twig->loadTemplate('index.tpl');

                echo $template->render(array (
                        'cntProducts'   => sizeof($products),
                        'products'      => $products,
                        'cntCategories' => sizeof($categories), 
                        'categories'    => $categories
                 ));
        }


} catch (Exception $e) {
        die ('ERROR: ' . $e->getMessage());
}

// Close the database connection
$dbh = null;

?>

