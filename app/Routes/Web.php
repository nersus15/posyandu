<?php

use Config\Services;

$routes = Services::routes();
// $routes->setAutoRoute(true);

$routes->get('dashboard', 'Home::dashboard', ['filter' => 'MustLogin']);
$routes->get('anak/list/(:any)', 'Anak::list/$1', ['filter' => 'MustLogin']);

$routes->post('ws/user/login', 'Ws\User::login');
$routes->get('ws/user/logout', 'Ws\User::logout');

$routes->get('/bumil', 'Bumil::index', ['filter' => 'MustLogin']);
$routes->get('/bumil/add', 'Bumil::add', ['filter' => 'MustLogin']);
$routes->post('/bumil/add', 'Bumil::post_add', ['filter' => 'MustLogin']);
$routes->post('/bumil/set/(:any)', 'Bumil::set/$1', ['filter' => 'MustLogin']);
$routes->get('/bumil/delete/(:any)', 'Bumil::delete/$1', ['filter' => 'MustLogin']);
$routes->get('/bumil/update/(:any)', 'Bumil::update/$1', ['filter' => 'MustLogin']);
$routes->get('/bumil/kunjungan/(:any)', 'Bumil::kunjungan/$1', ['filter' => 'MustLogin']);

// Kunjugan Bumil

$routes->get('/kunjungan/bumil/periksa/(:any)', 'Bumil::periksa/$1', ['filter' => 'MustLogin']);
$routes->get('/kunjungan/bumil/update/(:any)', 'Bumil::update_periksa/$1', ['filter' => 'MustLogin']);
$routes->get('/kunjungan/bumil/detail/(:any)', 'Bumil::detail_periksa/$1', ['filter' => 'MustLogin']);
$routes->get('/kunjungan/bumil/delete/(:any)', 'Bumil::delete_periksa/$1', ['filter' => 'MustLogin']);
$routes->post('/kunjungan/bumil/save', 'Bumil::post_periksa', ['filter' => 'MustLogin']);
$routes->post('/kunjungan/bumil/set', 'Bumil::set_periksa', ['filter' => 'MustLogin']);

