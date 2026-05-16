<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ======================
// AUTH
// ======================
$routes->get('/', 'Auth::index');
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// ======================
// DASHBOARD
// ======================
// Agar tidak error 404 saat klik logo yang mengarah ke backend/dashboard
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('backend/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// ======================
// BACKEND & TRANSAKSI
// ======================
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // ----------------------
    // MASTER DATA (Sesuaikan dengan Sidebar)
    // ----------------------
    $routes->group('backend/master', function ($routes) {

        // Mekanik
        $routes->get('mekanik', 'Master\Mekanik::index');
        $routes->post('mekanik/save', 'Master\Mekanik::save');
        $routes->post('mekanik/update/(:any)', 'Master\Mekanik::update/$1');
        $routes->get('mekanik/delete/(:any)', 'Master\Mekanik::delete/$1');

        // Pelanggan
        $routes->get('pelanggan', 'Master\Pelanggan::index');
        $routes->post('pelanggan/save', 'Master\Pelanggan::save');
        $routes->post('pelanggan/update/(:any)', 'Master\Pelanggan::update/$1');
        $routes->get('pelanggan/delete/(:any)', 'Master\Pelanggan::delete/$1');

        // Kendaraan
        $routes->get('kendaraan', 'Master\Kendaraan::index');
        $routes->post('kendaraan/save', 'Master\Kendaraan::save');
        $routes->post('kendaraan/update/(:any)', 'Master\Kendaraan::update/$1');
        $routes->get('kendaraan/delete/(:any)', 'Master\Kendaraan::delete/$1');

        // Tipe Motor
        $routes->get('tipe_motor', 'Master\TipeMotor::index');
        $routes->post('tipe_motor/save', 'Master\TipeMotor::save');
        $routes->post('tipe_motor/update/(:any)', 'Master\TipeMotor::update/$1');
        $routes->get('tipe_motor/delete/(:any)', 'Master\TipeMotor::delete/$1');

        // Merek Motor (FIXED: Tambah 'e' agar sesuai sidebar)
        $routes->get('merek_motor', 'Master\MerekMotor::index');
        $routes->post('merek_motor/save', 'Master\MerekMotor::save');
        $routes->post('merek_motor/update/(:any)', 'Master\MerekMotor::update/$1');
        $routes->get('merek_motor/delete/(:any)', 'Master\MerekMotor::delete/$1');

        // Jasa Servis
        $routes->get('jasa_servis', 'Master\JasaServis::index');
        $routes->post('jasa_servis/save', 'Master\JasaServis::save');
        $routes->post('jasa_servis/update/(:any)', 'Master\JasaServis::update/$1');
        $routes->get('jasa_servis/delete/(:any)', 'Master\JasaServis::delete/$1');

        // Sparepart
        $routes->get('sparepart', 'Master\Sparepart::index');
        $routes->post('sparepart/save', 'Master\Sparepart::save');
        $routes->post('sparepart/update/(:any)', 'Master\Sparepart::update/$1');
        $routes->get('sparepart/delete/(:any)', 'Master\Sparepart::delete/$1');

        // Kategori Part
        $routes->get('kategori_part', 'Master\KategoriPart::index');
        $routes->post('kategori_part/save', 'Master\KategoriPart::save');
        $routes->post('kategori_part/update/(:any)', 'Master\KategoriPart::update/$1');
        $routes->get('kategori_part/delete/(:any)', 'Master\KategoriPart::delete/$1');

        // Kategori Biaya Operasional 
        $routes->get('kategori_biaya_operasional', 'Master\KategoriBiayaOperasional::index');
        $routes->post('kategori_biaya_operasional/save', 'Master\KategoriBiayaOperasional::save');
        $routes->post('kategori_biaya_operasional/update/(:any)', 'Master\KategoriBiayaOperasional::update/$1');
        $routes->get('kategori_biaya_operasional/delete/(:any)', 'Master\KategoriBiayaOperasional::delete/$1');

        // Merek Part (FIXED: Tambah 'e' agar sesuai sidebar)
        $routes->get('merek_part', 'Master\MerekPart::index');
        $routes->post('merek_part/save', 'Master\MerekPart::save');
        $routes->post('merek_part/update/(:any)', 'Master\MerekPart::update/$1');
        $routes->get('merek_part/delete/(:any)', 'Master\MerekPart::delete/$1');

        // Pemasok
        $routes->get('pemasok', 'Master\Pemasok::index');
        $routes->post('pemasok/save', 'Master\Pemasok::save');
        $routes->post('pemasok/update/(:any)', 'Master\Pemasok::update/$1');
        $routes->get('pemasok/delete/(:any)', 'Master\Pemasok::delete/$1');

        // Pengguna
        $routes->get('pengguna', 'Master\Pengguna::index');
        $routes->post('pengguna/save', 'Master\Pengguna::save');
        $routes->post('pengguna/update/(:any)', 'Master\Pengguna::update/$1');
        $routes->get('pengguna/delete/(:any)', 'Master\Pengguna::delete/$1');
    });

    // ----------------------
    // LAPORAN
    // ----------------------
    // Bagian LAPORAN
    $routes->group('backend/laporan', ['namespace' => 'App\Controllers\Laporan'], function ($routes) {
        $routes->get('transaksi', 'Laporan::transaksi');
        $routes->get('stok', 'Laporan::stok');
        $routes->get('mekanik', 'Laporan::mekanik');
        $routes->get('pembelian', 'Laporan::pembelian');
        $routes->get('pengeluaran', 'Laporan::pengeluaran');
        $routes->get('loyalitas', 'Laporan::loyalitas');
        $routes->get('laba-rugi', 'Laporan::labaRugi');
        $routes->get('export/excel/(:segment)', 'Laporan::exportExcel/$1');
        $routes->get('export/pdf/(:segment)', 'Laporan::exportPdf/$1');
    });

    // ----------------------
    // TRANSAKSI (Namespace: App\Controllers\Transaksi)
    // ----------------------
    $routes->group('backend/transaksi', function ($routes) {

        // Pembelian Stok
        $routes->get('pembelian', 'Transaksi\Pembelian::index');
        $routes->post('pembelian/save', 'Transaksi\Pembelian::save');
        $routes->get('pembelian/detail/(:any)', 'Transaksi\Pembelian::detail/$1');

        // Servis
        $routes->get('servis', 'Transaksi\Servis::index');
        $routes->post('servis/create', 'Transaksi\Servis::create');
        $routes->get('servis/detail/(:any)', 'Transaksi\Servis::detail/$1');
        $routes->post('servis/update_status', 'Transaksi\Servis::update_status');

        // Jasa Luar
        $routes->get('jasa_luar', 'Transaksi\JasaLuar::index');
        $routes->post('jasa_luar/save', 'Transaksi\JasaLuar::save');
        $routes->post('jasa_luar/update/(:any)', 'Transaksi\JasaLuar::update/$1');
        $routes->get('jasa_luar/delete/(:any)', 'Transaksi\JasaLuar::delete/$1');

        // Gaji Mekanik
        $routes->get('gaji_mekanik', 'Transaksi\GajiMekanik::index');
        $routes->post('gaji_mekanik/save', 'Transaksi\GajiMekanik::save');
        $routes->post('gaji_mekanik/update/(:any)', 'Transaksi\GajiMekanik::update/$1');
        $routes->get('gaji_mekanik/delete/(:any)', 'Transaksi\GajiMekanik::delete/$1');

        // Biaya Operasional
        $routes->get('biaya_operasional', 'Transaksi\BiayaOperasional::index');
        $routes->post('biaya_operasional/save', 'Transaksi\BiayaOperasional::save');
        $routes->post('biaya_operasional/update/(:any)', 'Transaksi\BiayaOperasional::update/$1');
        $routes->get('biaya_operasional/delete/(:any)', 'Transaksi\BiayaOperasional::delete/$1');
    });

});