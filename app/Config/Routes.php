<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/logout', 'Home::index');
$routes->post('/login', 'Home::login');
$routes->post('/register', 'Home::register');

//home page
$routes->get('/dashboard', 'UserController::index');
$routes->get('/chat', 'ChatServer::index');
$routes->get('/user-frined', 'UserController::frndData');
$routes->get('/frined', 'UserController::getfrnd');
$routes->get('side-bar/(:num)', 'UserController::sideData/$1');
$routes->get('rqst-sent/(:num)', 'UserController::sent/$1');
$routes->get('add-sent/(:num)', 'UserController::accept/$1');
$routes->get('load-msg/(:num)', 'UserController::loadmsg/$1');
$routes->get('block/(:num)', 'UserController::block/$1');
$routes->get('unblock/(:num)', 'UserController::unblock/$1');
//chat send
$routes->post('/sendMessage', 'UserController::sendMessage');
$routes->group('/call', function ($routes) {
    $routes->get('call/(:num)', 'VideoCallController::vopen/$1');
    $routes->get('hcall/(:num)', 'VideoCallController::copen/$1');
    $routes->get('show/(:num)/(:num)', 'VideoCallController::copen/$1/$1');
});
// $routes->get('/sendSocket', 'UserController::sendMessage');
