<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

$routes = Services::routes();

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// Auth routes
$routes->group('auth', function ($routes) {
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
    $routes->post('update-role', 'AuthController::updateRole', ['filter' => 'jwt']);
    $routes->get('me', 'AuthController::me', ['filter' => 'jwt']);
    $routes->get('logout', 'AuthController::logout', ['filter' => 'jwt']);
});

// Bus routes
$routes->group('bus', ['filter' => 'jwt'], function ($routes) {
    $routes->get('schedule', 'BusController::getBusSchedule');
    $routes->post('bus', 'BusController::createNewBus', ['filter' => 'admin']);
    $routes->get('conductor', 'BusController::getAllConductors', ['filter' => 'admin']);
    $routes->get('conductor/(:segment)', 'BusController::getConductorById/$1', ['filter' => 'admin']);
    $routes->post('conductor', 'BusController::createNewConductor', ['filter' => 'admin']);
    $routes->delete('conductor/(:segment)', 'BusController::removeConductor/$1', ['filter' => 'admin']);
    $routes->get('contractor', 'BusController::getAllContractors', ['filter' => 'admin']);
    $routes->get('contractor/(:segment)', 'BusController::getContractorById/$1', ['filter' => 'admin']);
    $routes->post('contractor', 'BusController::createNewContractor', ['filter' => 'admin']);
    $routes->delete('contractor/(:segment)', 'BusController::removeContractor/$1', ['filter' => 'admin']);
    $routes->post('schedule', 'BusController::createNewSchedule', ['filter' => 'admin']);
    $routes->get('admin-protected', 'BusController::adminProtected', ['filter' => 'admin']);
});

// Order routes
// In Config/Routes.php

$routes->group('orders', ['filter' => 'jwt'], function ($routes) {
    $routes->post('create', 'OrdersController::create');
    $routes->get('', 'OrdersController::index');
    $routes->put('update/(:segment)', 'OrdersController::update/$1');
    $routes->delete('delete/(:segment)', 'OrdersController::delete/$1');
    $routes->get('(:segment)', 'OrdersController::show/$1');
});

