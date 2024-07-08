<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//login filter
$routes->group("", ["filter" => "login"], static function ($routes) {
    $routes->get('/articles', 'Articles::index');
});
   

service('auth')->routes($routes);




$routes->get('/my-times', 'Home::myTimes');

$routes->post('time-tracking/start', 'Home::startTimer');
$routes->post('time-tracking/end', 'Home::endTimer');


$routes->post('time-tracking/delete/(:num)', 'Home::deleteTimeLog/$1');
// $routes->post('time-tracking/update/(:num)', 'Home::updateTimeLog/$1');
