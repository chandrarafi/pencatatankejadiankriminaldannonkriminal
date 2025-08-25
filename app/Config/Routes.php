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

// RESKRIM routes (Investigation Division)
$routes->group('reskrim', function ($routes) {
    // Dashboard
    $routes->get('dashboard', 'Dashboard::index');

    // Data Kasus routes (Read-only access to existing cases)
    $routes->get('kasus', 'ReskrimController::kasus');
    $routes->post('kasus/get-data', 'ReskrimController::getKasusData');
    $routes->get('kasus/show/(:num)', 'ReskrimController::showKasus/$1');
    $routes->post('kasus/update-status/(:num)', 'ReskrimController::updateKasusStatus/$1');

    // Data Korban routes
    $routes->get('korban', 'KorbanController::index');
    $routes->post('korban/get-data', 'KorbanController::getData');
    $routes->get('korban/create', 'KorbanController::create');
    $routes->post('korban/store', 'KorbanController::storeAjax');
    $routes->get('korban/show/(:num)', 'KorbanController::show/$1');
    $routes->get('korban/edit/(:num)', 'KorbanController::edit/$1');
    $routes->post('korban/update/(:num)', 'KorbanController::updateAjax/$1');
    $routes->delete('korban/delete/(:num)', 'KorbanController::deleteAjax/$1');
    $routes->get('korban/get-by-id/(:num)', 'KorbanController::getById/$1');
    $routes->post('korban/search', 'KorbanController::search');
    $routes->get('korban/get-kasus-data', 'KorbanController::getKasusData');

    // Data Tersangka routes
    $routes->get('tersangka', 'TersangkaController::index');
    $routes->post('tersangka/get-data', 'TersangkaController::getData');
    $routes->get('tersangka/create', 'TersangkaController::create');
    $routes->post('tersangka/store', 'TersangkaController::storeAjax');
    $routes->get('tersangka/show/(:num)', 'TersangkaController::show/$1');
    $routes->get('tersangka/edit/(:num)', 'TersangkaController::edit/$1');
    $routes->post('tersangka/update/(:num)', 'TersangkaController::updateAjax/$1');
    $routes->delete('tersangka/delete/(:num)', 'TersangkaController::deleteAjax/$1');
    $routes->get('tersangka/get-by-id/(:num)', 'TersangkaController::getById/$1');
    $routes->post('tersangka/search', 'TersangkaController::search');
    $routes->get('tersangka/get-kasus-data', 'TersangkaController::getKasusData'); // New route for modal

    // Data Saksi routes
    $routes->get('saksi', 'SaksiController::index');
    $routes->post('saksi/get-data', 'SaksiController::getData');
    $routes->get('saksi/create', 'SaksiController::create');
    $routes->post('saksi/store', 'SaksiController::storeAjax');
    $routes->get('saksi/show/(:num)', 'SaksiController::show/$1');
    $routes->get('saksi/edit/(:num)', 'SaksiController::edit/$1');
    $routes->post('saksi/update/(:num)', 'SaksiController::updateAjax/$1');
    $routes->delete('saksi/delete/(:num)', 'SaksiController::deleteAjax/$1');
    $routes->get('saksi/get-by-id/(:num)', 'SaksiController::getById/$1');
    $routes->post('saksi/search', 'SaksiController::search');
    $routes->get('saksi/get-kasus-data', 'SaksiController::getKasusData'); // New route for modal

    // Data Pelapor routes (Read-only access)
    $routes->get('pelapor', 'ReskrimController::pelapor');
    $routes->post('pelapor/get-data', 'ReskrimController::getPelaporData');
    $routes->get('pelapor/show/(:num)', 'ReskrimController::showPelapor/$1');
    $routes->post('pelapor/search', 'ReskrimController::searchPelapor');

    // Data Piket routes (Read-only access)
    $routes->get('piket', 'ReskrimController::piket');
    $routes->post('piket/get-data', 'ReskrimController::getPiketData');
    $routes->get('piket/show/(:num)', 'ReskrimController::showPiket/$1');

    // Laporan routes
    $routes->get('laporan', 'ReskrimController::laporan');
    $routes->post('laporan/generate', 'ReskrimController::generateLaporan');
    $routes->get('laporan/export/(:segment)', 'ReskrimController::exportLaporan/$1');
});

// Home (untuk default CI4)
$routes->get('home', 'Home::index');
