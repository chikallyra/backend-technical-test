<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/register', 'Home::register');

$routes->post('api/register', 'AuthController::register');

$routes->post('api/login', 'AuthController::login');

$routes->post('api/forgot-password', 'AuthController::forgotPassword');
$routes->post('api/reset-password', 'AuthController::resetPassword');

$routes->get('/coba', 'Home::coba');
