<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
$routes->get('/', 'Auth::index');
$routes->get('auth', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('akun/ubah-password', 'Master\Pengguna::ubahPassword');
$routes->post('akun/ubah-password', 'Master\Pengguna::prosesUbahPassword');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
$routes->group('', ['filter' => 'auth'], function ($routes) {

    /*
    |--------------------------------------------------------------------------
    | MASTER DATA
    | Admin + Pemilik
    |--------------------------------------------------------------------------
    */
    $routes->group('master', ['filter' => 'role:Admin,Pemilik'], function ($routes) {

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
        $routes->get('tipe-motor', 'Master\TipeMotor::index');
        $routes->post('tipe-motor/save', 'Master\TipeMotor::save');
        $routes->post('tipe-motor/update/(:any)', 'Master\TipeMotor::update/$1');
        $routes->get('tipe-motor/delete/(:any)', 'Master\TipeMotor::delete/$1');

        // Merek Motor
        $routes->get('merek-motor', 'Master\MerekMotor::index');
        $routes->post('merek-motor/save', 'Master\MerekMotor::save');
        $routes->post('merek-motor/update/(:any)', 'Master\MerekMotor::update/$1');
        $routes->get('merek-motor/delete/(:any)', 'Master\MerekMotor::delete/$1');

        // Jasa Servis
        $routes->get('jasa-servis', 'Master\JasaServis::index');
        $routes->post('jasa-servis/save', 'Master\JasaServis::save');
        $routes->post('jasa-servis/update/(:any)', 'Master\JasaServis::update/$1');
        $routes->get('jasa-servis/delete/(:any)', 'Master\JasaServis::delete/$1');

        // Sparepart
        $routes->get('sparepart', 'Master\Sparepart::index');
        $routes->post('sparepart/save', 'Master\Sparepart::save');
        $routes->post('sparepart/update/(:any)', 'Master\Sparepart::update/$1');
        $routes->get('sparepart/delete/(:any)', 'Master\Sparepart::delete/$1');

        // Kategori Part
        $routes->get('kategori-part', 'Master\KategoriPart::index');
        $routes->post('kategori-part/save', 'Master\KategoriPart::save');
        $routes->post('kategori-part/update/(:any)', 'Master\KategoriPart::update/$1');
        $routes->get('kategori-part/delete/(:any)', 'Master\KategoriPart::delete/$1');

        // Kategori Biaya Operasional
        $routes->get('kategori-biaya-operasional', 'Master\KategoriBiayaOperasional::index');
        $routes->post('kategori-biaya-operasional/save', 'Master\KategoriBiayaOperasional::save');
        $routes->post('kategori-biaya-operasional/update/(:any)', 'Master\KategoriBiayaOperasional::update/$1');
        $routes->get('kategori-biaya-operasional/delete/(:any)', 'Master\KategoriBiayaOperasional::delete/$1');

        // Merek Part
        $routes->get('merek-part', 'Master\MerekPart::index');
        $routes->post('merek-part/save', 'Master\MerekPart::save');
        $routes->post('merek-part/update/(:any)', 'Master\MerekPart::update/$1');
        $routes->get('merek-part/delete/(:any)', 'Master\MerekPart::delete/$1');

        // Pemasok
        $routes->get('pemasok', 'Master\Pemasok::index');
        $routes->post('pemasok/save', 'Master\Pemasok::save');
        $routes->post('pemasok/update/(:any)', 'Master\Pemasok::update/$1');
        $routes->get('pemasok/delete/(:any)', 'Master\Pemasok::delete/$1');
    });


    /*
    |--------------------------------------------------------------------------
    | USER MANAGEMENT
    | Pemilik Only
    |--------------------------------------------------------------------------
    */
    $routes->group('master', ['filter' => 'role:Pemilik'], function ($routes) {
        $routes->get('pengguna', 'Master\Pengguna::index');
        $routes->post('pengguna/save', 'Master\Pengguna::save');
        $routes->post('pengguna/update/(:any)', 'Master\Pengguna::update/$1');
        $routes->get('pengguna/delete/(:any)', 'Master\Pengguna::delete/$1');
    });


    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI
    |--------------------------------------------------------------------------
    */
    $routes->group('transaksi', function ($routes) {

        /*
        |--------------------------------------------------------------------------
        | Shared: Admin + Pemilik + Mekanik
        |--------------------------------------------------------------------------
        */
        $routes->group('', ['filter' => 'role:Admin,Pemilik,Mekanik'], function ($routes) {

            $routes->get('servis', 'Transaksi\Servis::index');
            $routes->get('servis/detail/(:any)', 'Transaksi\Servis::detail/$1');

            $routes->post(
                'servis/update-status',
                'Transaksi\Servis::update_status'
            );
        });

        /*
        |--------------------------------------------------------------------------
        | Admin + Pemilik
        |--------------------------------------------------------------------------
        */
        $routes->group('', ['filter' => 'role:Admin,Pemilik'], function ($routes) {

            $routes->post('servis/create', 'Transaksi\Servis::create');
            $routes->post('servis/update-pembayaran', 'Transaksi\Servis::update_pembayaran');
            $routes->get('pembelian', 'Transaksi\Pembelian::index');
            $routes->post('pembelian/save', 'Transaksi\Pembelian::save');
            $routes->get('pembelian/detail/(:any)', 'Transaksi\Pembelian::detail/$1');

            $routes->get('jasa-luar', 'Transaksi\JasaLuar::index');
            $routes->post('jasa-luar/save', 'Transaksi\JasaLuar::save');
            $routes->post('jasa-luar/update/(:any)', 'Transaksi\JasaLuar::update/$1');
            $routes->get('jasa-luar/delete/(:any)', 'Transaksi\JasaLuar::delete/$1');

            $routes->get('gaji-mekanik', 'Transaksi\GajiMekanik::index');
            $routes->post('gaji-mekanik/save', 'Transaksi\GajiMekanik::save');
            $routes->post('gaji-mekanik/update/(:any)', 'Transaksi\GajiMekanik::update/$1');
            $routes->get('gaji-mekanik/delete/(:any)', 'Transaksi\GajiMekanik::delete/$1');

            $routes->get('biaya-operasional', 'Transaksi\BiayaOperasional::index');
            $routes->post('biaya-operasional/save', 'Transaksi\BiayaOperasional::save');
            $routes->post('biaya-operasional/update/(:any)', 'Transaksi\BiayaOperasional::update/$1');
            $routes->get('biaya-operasional/delete/(:any)', 'Transaksi\BiayaOperasional::delete/$1');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    | Pemilik Only
    |--------------------------------------------------------------------------
    */
    $routes->group('laporan', [
        'namespace' => 'App\Controllers\Laporan',
        'filter' => 'role:Pemilik'
    ], function ($routes) {

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

});