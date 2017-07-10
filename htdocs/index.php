<?php
/**
* Bootstrap the framework.
*/
// Where are all the files? Both are needed by Anax.
define("ANAX_INSTALL_PATH", realpath(__DIR__ . "/.."));
define("ANAX_APP_PATH", ANAX_INSTALL_PATH);

// Include essentials
require ANAX_INSTALL_PATH . "/config/error_reporting.php";

// Get the autoloader by using composers version.
require ANAX_INSTALL_PATH . "/vendor/autoload.php";

// Add all resources to $app
$app = new \Mag\App\App();
$app->request = new \Anax\Request\Request();
$app->response = new \Anax\Response\Response();
$app->url     = new \Anax\Url\Url();
$app->router  = new \Anax\Route\RouterInjectable();
$app->view    = new \Anax\View\ViewContainer();

$app->navbar = new \Mag\Navbar\Navbar();
$app->navbar->setApp($app);
$app->navbar->configure("navbar.php");

// Create new instance of class Textfilter, and inject in $app
$app->textfilter = new \Anax\TextFilter\TextFilter();

// var_dump($app->textfilter->getFilters());

$app->db = new \Anax\Database\DatabaseConfigure();
// $app->db = new \Mag\Database\Database();
$app->db->configure("database.php");
$app->db->setDefaultsFromConfiguration();
$app->db->connect();
$app->access = new \Mag\Access\Access($app->db);

// Create an admin class, to use its methods
// Inject $app into class to be able to use database, access and session classes
// $app->admin = new \Mag\Admin\Admin($app->db);
$app->admin = new \Mag\Admin\Admin($app);

// Create a new instance of class Webshop and inject in $app
$app->webshop = new \Mag\Webshop\Webshop($app->db);

// Load footer data and inject to app

$sql = "SELECT * FROM Content WHERE title='Footer'";
$app->footer = $app->db->executeFetch($sql);


// Save a cookie

$my_cookie = "my_cookie";
$app->cookie = new \Mag\Cookie\Cookie();
$app->cookie->set($my_cookie, "en chokladruta");


// Start a session if not started and set $key 'number' to 1 if not set
if (!isset($app->session)) {
    $app->session = new \Mag\Session\Session();
    $app->session->start();
    if (!$app->session->has("number")) {
        $app->session->set("number", 1);
    }
}


// Create calendar
$app->calendar = new \Mag\Calendar\Calendar();


// Inject $app into the view container for use in view files.
$app->view->setApp($app);

// Update view configuration with values from config file.
$app->view->configure("view.php");

// Init the object of the request class.
$app->request->init();

// Init the url-object with default values from the request object.
$app->url->setSiteUrl($app->request->getSiteUrl());
$app->url->setBaseUrl($app->request->getBaseUrl());
$app->url->setStaticSiteUrl($app->request->getSiteUrl());
$app->url->setStaticBaseUrl($app->request->getBaseUrl());
$app->url->setScriptName($app->request->getScriptName());

// Update url configuration with values from config file.
$app->url->configure("url.php");
$app->url->setDefaultsFromConfiguration();

// $app->style = $app->url->asset("css/style.css");
$app->style = $app->url->asset("css/main.min.css");

// Load the Routes
require ANAX_INSTALL_PATH . "/config/route.php";

// Leave to router to match incoming request to routes
$app->router->handle($app->request->getRoute());
