<?php

namespace Admin\Config;
use Config\Services;

/**
 * @var RouteCollection $routes
 */

 $routes->group("admin", ["namespace" => "Admin\Controllers", "filter" => "group:admin"], static function ($routes) {
    $routes->get("users", "Users::index");
    $routes->get("users/(:num)", "Users::show/$1");
    $routes->post("users/(:num)/toggle-ban" , "Users::toggleBan/$1");
    $routes->match(["get","post"],"users/(:num)/groups", "Users::groups/$1");
});