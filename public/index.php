
<?php
session_start();

require_once '../config/config.php';
require_once '../app/core/Router.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';

// load routes
require_once '../config/routes.php';

// run router
$router->dispatch();
