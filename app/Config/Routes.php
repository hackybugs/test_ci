<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/registerv', 'UserController::viewreg');
// $routes->post('/register', 'UserController::register');
// $routes->get('/login', 'UserController::login');
// $routes->post('/login', 'UserController::login');
// $routes->get('/dashboard', 'UserController::dashboard', ['filter' => 'auth']);
// $routes->get('/profile', 'UserController::profile', ['filter' => 'auth']);
// $routes->post('/profile', 'UserController::profile', ['filter' => 'auth']);
// $routes->get('/search', 'UserController::search', ['filter' => 'auth']);
// $routes->post('/search', 'UserController::search', ['filter' => 'auth']);
$routes->post('api/register', 'AuthController::register');
$routes->post('api/login', 'AuthController::login');
$routes->get('dashboard', 'AdminController::dashboard',['filter' => 'auth:admin']);

$routes->get('dashboard', 'UserController::dashboard',['filter' => 'auth:customer']);


$routes->get('api/users/(:num)', 'UserController::getProfile/$1', ['filter' => 'auth']);


$routes->set404Override(function () {
    echo view('errors/custom_404');
});
