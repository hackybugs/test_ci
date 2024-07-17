<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/registerv', 'UserController::viewreg');
$routes->post('/register', 'UserController::register');
$routes->get('/login', 'UserController::login');
$routes->post('/login', 'UserController::login');
$routes->get('/dashboard', 'UserController::dashboard', ['filter' => 'auth']);
$routes->get('/profile', 'UserController::profile', ['filter' => 'auth']);
$routes->post('/profile', 'UserController::profile', ['filter' => 'auth']);
$routes->get('/search', 'UserController::search', ['filter' => 'auth']);
$routes->post('/search', 'UserController::search', ['filter' => 'auth']);

