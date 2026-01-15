<?php

$router = new Router();

$router->get('/', 'AuthController', 'register');

// Register
$router->get('/register', 'AuthController', 'register');
$router->post('/register', 'AuthController', 'handleRegister');
