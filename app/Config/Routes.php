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

// Laporan routes (accessible by all roles)
$routes->group('laporan', function ($routes) {
    $routes->get('/', 'LaporanController::index');
    $routes->post('get-data', 'LaporanController::getData');
    $routes->get('kasus-lengkap/(:num)', 'LaporanController::kasusLengkap/$1');
});

// Surat routes (accessible by all roles)
$routes->group('surat', function ($routes) {
    $routes->get('/', 'SuratController::index');

    // Laporan Polisi
    $routes->get('laporan-polisi/(:num)', 'SuratController::laporanPolisi/$1');

    // Berita Acara Pemeriksaan
    $routes->get('berita-acara-pemeriksaan/(:num)/(:any)/(:num)', 'SuratController::beritaAcaraPemeriksaan/$1/$2/$3');

    // Surat Panggilan
    $routes->get('surat-panggilan/(:num)/(:any)/(:num)', 'SuratController::suratPanggilan/$1/$2/$3');

    // Resume Kasus
    $routes->get('resume-kasus/(:num)', 'SuratController::resumeKasus/$1');

    // Surat Keterangan
    $routes->get('surat-keterangan/(:num)', 'SuratController::suratKeterangan/$1');

    // Laporan Harian
    $routes->get('laporan-harian', 'SuratController::laporanHarian');
    $routes->get('laporan-harian/(:any)', 'SuratController::laporanHarian/$1');

    // API for person selection
    $routes->get('get-persons/(:num)', 'SuratController::getPersons/$1');
});

// Laporan Manajemen routes (KAPOLSEK & RESKRIM)
$routes->group('laporan-manajemen', function ($routes) {
    // KAPOLSEK Reports
    $routes->get('dashboard-kapolsek', 'LaporanManajemenController::dashboardKapolsek');
    $routes->get('kinerja-unit', 'LaporanManajemenController::kinerjaUnit');

    // RESKRIM Reports  
    $routes->get('dashboard-reskrim', 'LaporanManajemenController::dashboardReskrim');
    $routes->get('progress-investigasi', 'LaporanManajemenController::progressInvestigasi');

    // Shared Reports
    $routes->get('statistik-kriminalitas', 'LaporanManajemenController::statistikKriminalitas');

    // API endpoints
    $routes->get('api/statistics/(:any)', 'LaporanManajemenController::getStatisticsData/$1');
});

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
    $routes->get('korban/get-by-kasus/(:num)', 'KorbanController::getByKasus/$1');

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
    $routes->get('tersangka/get-by-kasus/(:num)', 'TersangkaController::getByKasus/$1');

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
    $routes->get('saksi/get-by-kasus/(:num)', 'SaksiController::getByKasus/$1');

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

// Laporan Kasus Per Tanggal routes (accessible by kapolsek and reskrim)
$routes->group('laporan-kasus', function ($routes) {
    $routes->get('/', 'LaporanKasusController::index');
    $routes->post('get-data', 'LaporanKasusController::getData');
    $routes->get('print', 'LaporanKasusController::print');
    $routes->get('statistics', 'LaporanKasusController::getStatistics');
    $routes->get('detail/(:num)', 'LaporanKasusController::detail/$1');
    $routes->get('print-detail/(:num)', 'LaporanKasusController::printDetail/$1');

    // Monthly reports
    $routes->get('monthly', 'LaporanKasusController::monthly');
    $routes->post('monthly/get-data', 'LaporanKasusController::getMonthlyData');
    $routes->get('monthly/print', 'LaporanKasusController::printMonthly');

    // Yearly reports
    $routes->get('yearly', 'LaporanKasusController::yearly');
    $routes->get('yearly/get-data', 'LaporanKasusController::getYearlyData');
    $routes->get('yearly/print', 'LaporanKasusController::printYearly');
});

// Laporan Pelapor routes
$routes->group('laporan-pelapor', function ($routes) {
    $routes->get('/', 'LaporanPelaporController::index');
    $routes->post('get-data', 'LaporanPelaporController::getData');
    $routes->get('detail/(:num)', 'LaporanPelaporController::getDetail/$1');
    $routes->get('print', 'LaporanPelaporController::print');
    $routes->get('statistics', 'LaporanPelaporController::getStatistics');
});

// Laporan Korban routes
$routes->group('laporan-korban', function ($routes) {
    $routes->get('/', 'LaporanKorbanController::index');
    $routes->post('get-data', 'LaporanKorbanController::getData');
    $routes->get('detail/(:num)', 'LaporanKorbanController::getDetail/$1');
    $routes->get('print', 'LaporanKorbanController::print');
    $routes->get('statistics', 'LaporanKorbanController::getStatistics');
});

// Laporan Saksi routes
$routes->group('laporan-saksi', function ($routes) {
    $routes->get('/', 'LaporanSaksiController::index');
    $routes->post('get-data', 'LaporanSaksiController::getData');
    $routes->get('detail/(:num)', 'LaporanSaksiController::getDetail/$1');
    $routes->get('print', 'LaporanSaksiController::print');
    $routes->get('statistics', 'LaporanSaksiController::getStatistics');
});

// Laporan Tersangka routes
$routes->group('laporan-tersangka', function ($routes) {
    $routes->get('/', 'LaporanTersangkaController::index');
    $routes->post('get-data', 'LaporanTersangkaController::getData');
    $routes->get('detail/(:num)', 'LaporanTersangkaController::getDetail/$1');
    $routes->get('print', 'LaporanTersangkaController::print');
    $routes->get('statistics', 'LaporanTersangkaController::getStatistics');
});

// Laporan Anggota routes
$routes->group('laporan-anggota', function ($routes) {
    $routes->get('/', 'LaporanAnggotaController::index');
    $routes->post('get-data', 'LaporanAnggotaController::getData');
    $routes->get('detail/(:num)', 'LaporanAnggotaController::getDetail/$1');
    $routes->get('print', 'LaporanAnggotaController::print');
    $routes->get('statistics', 'LaporanAnggotaController::getStatistics');
});

// Laporan Piket routes
$routes->group('laporan-piket', function ($routes) {
    // Daily reports
    $routes->get('/', 'LaporanPiketController::index');
    $routes->post('get-data', 'LaporanPiketController::getData');
    $routes->get('detail/(:num)', 'LaporanPiketController::getDetail/$1');
    $routes->get('print', 'LaporanPiketController::print');
    $routes->get('statistics', 'LaporanPiketController::getStatistics');

    // Monthly reports
    $routes->get('monthly', 'LaporanPiketController::monthly');
    $routes->post('monthly/get-data', 'LaporanPiketController::getMonthlyData');
    $routes->get('monthly/print', 'LaporanPiketController::printMonthly');
});

// Home (untuk default CI4)
$routes->get('home', 'Home::index');
