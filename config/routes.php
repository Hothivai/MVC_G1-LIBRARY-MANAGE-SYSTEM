<?php

$router = new Router();

// REGISTER
$router->get('/register', 'AuthController', 'register');
$router->post('/register', 'AuthController', 'handleRegister');

// LOGIN
$router->get('/login', 'AuthController', 'login');
$router->post('/login', 'AuthController', 'handleLogin');