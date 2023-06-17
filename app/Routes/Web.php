<?php

use Config\Services;

$routes = Services::routes();
// $routes->setAutoRoute(true);

$routes->get('dashboard', 'Home::dashboard', ['filter' => 'MustLogin']);
$routes->post('ws/user/login', 'Ws\User::login');