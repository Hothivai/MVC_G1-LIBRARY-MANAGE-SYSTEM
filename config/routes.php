<?php

$router = new Router();

// REGISTER
$router->get('/register', 'AuthController', 'register');
$router->post('/register', 'AuthController', 'handleRegister');
