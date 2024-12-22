<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');


$routes->post('auth/login', 'AuthController::login');
$routes->post('auth/register', 'AuthController::register');


$routes->group('user', ['filter' => 'jwtauth'], function ($routes) {
    $routes->get('', 'UserController::index');
    $routes->post('', 'UserController::addUsesr');
    $routes->get('(:num)', 'UserController::show/$1');
    $routes->put('(:num)', 'UserController::update/$1');
    $routes->delete('(:num)', 'UserController::delete/$1');
});
