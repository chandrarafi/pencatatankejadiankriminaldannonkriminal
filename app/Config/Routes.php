<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Redirect root ke auth
$routes->get('/', function () {
    return redirect()->to('/auth');
});

// Auth routes
$routes->group('auth', function ($routes) {
    $routes->get('/', 'Auth::index');
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout');
});

// Dashboard routes
$routes->get('dashboard', 'Dashboard::index');

// Kasium routes (Data Anggota & Piket)
$routes->group('kasium', function ($routes) {
    // Anggota routes
    $routes->get('anggota', 'AnggotaController::index');
    $routes->get('anggota/create', 'AnggotaController::create');
    $routes->post('anggota/store', 'AnggotaController::store');
    $routes->get('anggota/show/(:num)', 'AnggotaController::show/$1');
    $routes->get('anggota/edit/(:num)', 'AnggotaController::edit/$1');
    $routes->post('anggota/update/(:num)', 'AnggotaController::update/$1');
    $routes->post('anggota/delete/(:num)', 'AnggotaController::deleteAjax/$1');
    $routes->get('anggota/delete/(:num)', 'AnggotaController::delete/$1');
    $routes->post('anggota/data', 'AnggotaController::getData');
    $routes->get('anggota/active', 'AnggotaController::getActiveAnggota');

    // Piket routes
    $routes->get('piket', 'PiketController::index');
    $routes->post('piket/data', 'PiketController::getData');
    $routes->get('piket/create', 'PiketController::create');
    $routes->post('piket/store', 'PiketController::store');
    $routes->get('piket/show/(:num)', 'PiketController::show/$1');
    $routes->get('piket/edit/(:num)', 'PiketController::edit/$1');
    $routes->post('piket/update/(:num)', 'PiketController::update/$1');
    $routes->get('piket/delete/(:num)', 'PiketController::delete/$1');
    $routes->get('piket/getWeeklySchedule', 'PiketController::getWeeklySchedule');
});

// SPKT routes (Kelola Data Pelapor, Jenis Kasus & Kasus)
$routes->group('spkt', function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Pelapor routes
    $routes->get('pelapor', 'PelaporController::index');
    $routes->post('pelapor/get-data', 'PelaporController::getData');
    $routes->get('pelapor/create', 'PelaporController::create');
    $routes->post('pelapor/store', 'PelaporController::storeAjax');
    $routes->get('pelapor/show/(:num)', 'PelaporController::show/$1');
    $routes->get('pelapor/edit/(:num)', 'PelaporController::edit/$1');
    $routes->post('pelapor/update/(:num)', 'PelaporController::updateAjax/$1');
    $routes->delete('pelapor/delete/(:num)', 'PelaporController::deleteAjax/$1');
    $routes->get('pelapor/get-by-id/(:num)', 'PelaporController::getById/$1');
    $routes->post('pelapor/search', 'PelaporController::search');

    // Jenis Kasus routes
    $routes->get('jenis-kasus', 'JenisKasusController::index');
    $routes->post('jenis-kasus/get-data', 'JenisKasusController::getData');
    $routes->get('jenis-kasus/create', 'JenisKasusController::create');
    $routes->post('jenis-kasus/store', 'JenisKasusController::storeAjax');
    $routes->get('jenis-kasus/show/(:num)', 'JenisKasusController::show/$1');
    $routes->get('jenis-kasus/edit/(:num)', 'JenisKasusController::edit/$1');
    $routes->post('jenis-kasus/update/(:num)', 'JenisKasusController::updateAjax/$1');
    $routes->delete('jenis-kasus/delete/(:num)', 'JenisKasusController::deleteAjax/$1');
    $routes->get('jenis-kasus/get-by-id/(:num)', 'JenisKasusController::getById/$1');

    // Kasus routes
    $routes->get('kasus', 'KasusController::index');
    $routes->post('kasus/get-data', 'KasusController::getData');
    $routes->get('kasus/create', 'KasusController::create');
    $routes->post('kasus/store', 'KasusController::storeAjax');
    $routes->get('kasus/show/(:num)', 'KasusController::show/$1');
    $routes->get('kasus/edit/(:num)', 'KasusController::edit/$1');
    $routes->post('kasus/update/(:num)', 'KasusController::updateAjax/$1');
    $routes->delete('kasus/delete/(:num)', 'KasusController::deleteAjax/$1');
    $routes->get('kasus/get-by-id/(:num)', 'KasusController::getById/$1');
    $routes->post('kasus/get-petugas-data', 'KasusController::getPetugasData');
    $routes->post('kasus/update-status/(:num)', 'KasusController::updateStatus/$1');

    $routes->get('piket', 'PiketController::index');
    $routes->post('piket/data', 'PiketController::getData');
    $routes->get('piket/create', 'PiketController::create');
    $routes->post('piket/store', 'PiketController::store');
    $routes->get('piket/show/(:num)', 'PiketController::show/$1');
    $routes->get('piket/edit/(:num)', 'PiketController::edit/$1');
    $routes->post('piket/update/(:num)', 'PiketController::update/$1');
    $routes->get('piket/delete/(:num)', 'PiketController::delete/$1');
    $routes->get('piket/getWeeklySchedule', 'PiketController::getWeeklySchedule');
});

// Home (untuk default CI4)
$routes->get('home', 'Home::index');
