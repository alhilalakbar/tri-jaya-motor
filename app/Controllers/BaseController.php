<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);
        $db = \Config\Database::connect();

        $stokKritis = $db->table('sparepart')
            ->where('stok_saat_ini <= stok_minimum')
            ->countAllResults();

        $transaksi_aktif = $db->table('transaksi_servis')
            ->groupStart()
            ->where('status_transaksi', 'Draft')
            ->orWhere('status_transaksi', 'Progress')
            ->groupEnd()
            ->countAllResults();

        $notifGlobal = [
            'stok_kritis_count' => $stokKritis,
            'transaksi_aktif' => $transaksi_aktif,
            'progress' => $transaksi_aktif,
            'total_notif' => $stokKritis + $transaksi_aktif
        ];

        \Config\Services::renderer()->setData($notifGlobal);

    }
}