<?php
/**
 * Front Controller - Single Entry Point
 * All requests are routed through this file
 */

// Load configuration
require_once '../config/config.php';

// Load core classes
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Router.php';

// Initialize router
$router = new Router();
