<?php

use Config\Services;

$routes = Services::routes();
// $routes->setAutoRoute(true);

$routes->get('dashboard', 'Home::dashboard', ['filter' => 'MustLogin']);
$routes->get('profile', 'Home::profile', ['filter' => 'MustLogin']);

$routes->post('ws/user/login', 'Ws\User::login', ['filter' => 'NoLogin']);
$routes->get('ws/user/logout', 'Ws\User::logout', ['filter' => 'MustLogin']);

$routes->get('/bumil', 'Bumil::index', ['filter' => 'MustLogin:bidan;kader']);
$routes->get('/bumil/add', 'Bumil::add', ['filter' => 'MustLogin:bidan;kader']);
$routes->post('/bumil/add', 'Bumil::post_add', ['filter' => 'MustLogin:bidan;kader']);
$routes->post('/bumil/set/(:any)', 'Bumil::set/$1', ['filter' => 'MustLogin:bidan;kader']);
$routes->get('/bumil/delete/(:any)', 'Bumil::delete/$1', ['filter' => 'MustLogin:bidan;kader']);
$routes->get('/bumil/update/(:any)', 'Bumil::update/$1', ['filter' => 'MustLogin:bidan;kader']);
$routes->get('/bumil/kunjungan/(:any)', 'Bumil::kunjungan/$1', ['filter' => 'MustLogin:bidan;kader']);

// Kunjugan Bumil

$routes->get('/kunjungan/bumil/periksa/(:any)', 'Bumil::periksa/$1', ['filter' => 'MustLogin:bidan;kader']);
$routes->get('/kunjungan/bumil/update/(:any)', 'Bumil::update_periksa/$1', ['filter' => 'MustLogin:bidan;kader']);
$routes->get('/kunjungan/bumil/detail/(:any)', 'Bumil::detail_periksa/$1', ['filter' => 'MustLogin:bidan;kader']);
$routes->get('/kunjungan/bumil/delete/(:any)', 'Bumil::delete_periksa/$1', ['filter' => 'MustLogin:bidan;kader']);
$routes->post('/kunjungan/bumil/save', 'Bumil::post_periksa', ['filter' => 'MustLogin:bidan;kader']);
$routes->post('/kunjungan/bumil/set/(:any)', 'Bumil::set_periksa/$1', ['filter' => 'MustLogin:bidan;kader']);



// Data Lansia
$routes->get('/lansia', 'Lansia::index', ['filter' => 'MustLogin:kader']);
$routes->get('/lansia/add', 'Lansia::add', ['filter' => 'MustLogin:kader']);
$routes->post('/lansia/save', 'Lansia::save', ['filter' => 'MustLogin:kader']);
$routes->post('/lansia/set/(:any)', 'Lansia::set/$1', ['filter' => 'MustLogin:kader']);
$routes->get('/lansia/delete/(:any)', 'Lansia::delete/$1', ['filter' => 'MustLogin:kader']);
$routes->get('/lansia/update/(:any)', 'Lansia::update/$1', ['filter' => 'MustLogin:kader']);

// Data Kunjungan Lansia
$routes->get('lansia/kunjungan/(:any)/(:any)', 'Lansia::kunjungan/$1/$2', ['filter' => 'MustLogin:kader']);

$routes->post('/kunjungan/lansia/save', 'Lansia::add_kunjungan', ['filter' => 'MustLogin:kader']);
$routes->post('/kunjungan/lansia/set/(:any)', 'Lansia::set_kunjungan/$1', ['filter' => 'MustLogin:kader']);
$routes->post('/kunjungan/lansia/delete', 'Lansia::delete_kunjungan', ['filter' => 'MustLogin:kader']);

// Data Anak
$routes->get('anak/list', 'Anak::list', ['filter' => 'MustLogin:kader']);
$routes->get('anak/list/(:any)', 'Anak::list/$1', ['filter' => 'MustLogin:kader']);
$routes->get('anak/delete/(:any)', 'Anak::delete/$1', ['filter' => 'MustLogin:kader']);
$routes->get('anak/update/(:any)', 'Anak::update/$1', ['filter' => 'MustLogin:kader']);
$routes->get('anak/daftar', 'Anak::add', ['filter' => 'MustLogin:kader']);
$routes->post('anak/daftar', 'Anak::save', ['filter' => 'MustLogin:kader']);
$routes->post('anak/set', 'Anak::set', ['filter' => 'MustLogin:kader']);

// Kunjungan Anak
$routes->get('anak/kunjungan/(:any)', 'Anak::kunjungan/$1/$2', ['filter' => 'MustLogin:kader']);

$routes->post('/kunjungan/anak/save', 'Anak::add_kunjungan', ['filter' => 'MustLogin:kader']);
$routes->post('/kunjungan/anak/set/(:any)', 'Anak::set_kunjungan/$1', ['filter' => 'MustLogin:kader']);
$routes->post('/kunjungan/anak/delete', 'Anak::delete_kunjungan', ['filter' => 'MustLogin:kader']);