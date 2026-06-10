<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\Servis\TransaksiServisModel;

class Servis extends BaseController
{
    public function index()
    {
        $model = new TransaksiServisModel();
        $db = \Config\Database::connect();

        $riwayat = $model
            ->select('
                transaksi_servis.*,
                kendaraan.nomor_plat,
                pelanggan.nama_pelanggan,
                mekanik.nama_mekanik,
                pengguna.nama_pengguna
            ')
            ->join(
                'kendaraan',
                'kendaraan.id_kendaraan = transaksi_servis.id_kendaraan'
            )
            ->join(
                'pelanggan',
                'pelanggan.id_pelanggan = kendaraan.id_pelanggan'
            )
            ->join(
                'mekanik',
                'mekanik.id_mekanik = transaksi_servis.id_mekanik',
                'left'
            )
            ->join(
                'pengguna',
                'pengguna.id_pengguna = transaksi_servis.id_pengguna',
                'left'
            )
            ->orderBy('transaksi_servis.tanggal_masuk', 'DESC')
            ->findAll();

        $data = [
            'data' => $riwayat,
            'pelanggan' => $db->table('pelanggan')->get()->getResultArray(),
            'mekanik' => $db->table('mekanik')->get()->getResultArray(),
            'jasa_list' => $db->table('jasa_servis')->get()->getResultArray(),
            'part_list' => $db->table('sparepart')->get()->getResultArray(),
            'kendaraan' => $db->table('kendaraan')
                ->select('kendaraan.id_kendaraan, kendaraan.nomor_plat, pelanggan.nama_pelanggan')
                ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
                ->get()
                ->getResultArray(),
        ];

        return view('backend/transaksi/servis/index', $data);
    }

    public function create()
    {
        $db = \Config\Database::connect();

        $db->transBegin();

        try {
            $headerData = $this->request->getPost('header');
            $listJasa = $this->request->getPost('jasa');
            $listPart = $this->request->getPost('part');

            if (empty($headerData['id_kendaraan'])) {
                throw new \Exception('Kendaraan wajib dipilih.');
            }

            if (empty($headerData['id_mekanik'])) {
                throw new \Exception('Mekanik wajib dipilih.');
            }

            if (
                (!is_array($listJasa) || empty($listJasa)) &&
                (!is_array($listPart) || empty($listPart))
            ) {
                throw new \Exception(
                    'Minimal harus ada jasa servis atau sparepart.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | VALIDASI JASA
            |--------------------------------------------------------------------------
            */
            if (is_array($listJasa)) {
                foreach ($listJasa as $j) {

                    if (
                        empty($j['id_jasa']) &&
                        empty($j['harga_saat_transaksi']) &&
                        empty($j['biaya_tambahan'])
                    ) {
                        continue;
                    }

                    if (empty($j['id_jasa'])) {
                        throw new \Exception('Jasa servis harus dipilih.');
                    }

                    if (
                        isset($j['harga_saat_transaksi']) &&
                        (float)$j['harga_saat_transaksi'] < 0
                    ) {
                        throw new \Exception(
                            'Biaya jasa tidak boleh bernilai negatif.'
                        );
                    }

                    if (
                        isset($j['biaya_tambahan']) &&
                        (float)$j['biaya_tambahan'] < 0
                    ) {
                        throw new \Exception(
                            'Biaya tambahan tidak boleh bernilai negatif.'
                        );
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | VALIDASI SPAREPART
            |--------------------------------------------------------------------------
            */
            if (is_array($listPart)) {
                foreach ($listPart as $p) {

                    // skip dummy row kosong
                    if (empty($p['id_part'])) {
                        continue;
                    }

                    if ((int)$p['jumlah_pakai'] <= 0) {
                        throw new \Exception(
                            'Jumlah sparepart harus lebih dari 0.'
                        );
                    }

                    if (
                        isset($p['harga_saat_transaksi']) &&
                        (float)$p['harga_saat_transaksi'] < 0
                    ) {
                        throw new \Exception(
                            'Harga sparepart tidak valid.'
                        );
                    }
                }
            }

            $transModel = new TransaksiServisModel();

            $headerData['id_pengguna'] = session()->get('id_pengguna');
            $headerData['tanggal_masuk'] = date('Y-m-d H:i:s');

            $idTrans = $transModel->insert($headerData, true);

            if (!$idTrans) {
                throw new \Exception(
                    'Gagal menyimpan data utama transaksi.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | INSERT DETAIL JASA
            |--------------------------------------------------------------------------
            */
            $jasaModel = new \App\Models\Transaksi\Servis\DetailJasaModel();

            if (is_array($listJasa)) {
                foreach ($listJasa as $j) {

                    if (empty($j['id_jasa'])) {
                        continue;
                    }

                    $j['id_transaksi'] = $idTrans;
                    $jasaModel->insert($j);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | INSERT DETAIL SPAREPART
            |--------------------------------------------------------------------------
            */
            $partModel = new \App\Models\Transaksi\Servis\DetailPartModel();

            if (is_array($listPart)) {
                foreach ($listPart as $p) {

                    if (empty($p['id_part'])) {
                        continue;
                    }

                    $p['id_transaksi'] = $idTrans;
                    $partModel->insert($p);
                }
            }

            if ($db->transStatus() === false) {
                throw new \Exception(
                    'Stok sparepart tidak mencukupi atau transaksi gagal.'
                );
            }

            $db->transCommit();

            return redirect()
                ->to('transaksi/servis')
                ->with('success', 'Data servis berhasil disimpan.');

        } catch (\Throwable $e) {
            $db->transRollback();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function update_status()
    {
        try {
            $model = new TransaksiServisModel();

            $id = $this->request->getPost('id_transaksi');

            if (empty($id)) {
                throw new \Exception('Transaksi tidak ditemukan.');
            }

            $data = [
                'status_pengerjaan' =>
                    $this->request->getPost('status_pengerjaan'),

                'metode_pembayaran' =>
                    $this->request->getPost('metode_pembayaran'),

                'status_pembayaran' =>
                    $this->request->getPost('status_pembayaran'),
            ];

            $model->update($id, $data);

            return redirect()
                ->to('transaksi/servis')
                ->with('success', 'Status transaksi berhasil diperbarui.');

        } catch (\Throwable $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        $model = new TransaksiServisModel();
        $db = \Config\Database::connect();

        $header = $model
            ->select('
                transaksi_servis.*,
                kendaraan.nomor_plat,
                pelanggan.nama_pelanggan,
                mekanik.nama_mekanik
            ')
            ->join(
                'kendaraan',
                'kendaraan.id_kendaraan = transaksi_servis.id_kendaraan'
            )
            ->join(
                'pelanggan',
                'pelanggan.id_pelanggan = kendaraan.id_pelanggan'
            )
            ->join(
                'mekanik',
                'mekanik.id_mekanik = transaksi_servis.id_mekanik'
            )
            ->where('id_transaksi', $id)
            ->first();

        $jasa = $db
            ->table('detail_jasa_servis')
            ->select('detail_jasa_servis.*, jasa_servis.nama_jasa')
            ->join(
                'jasa_servis',
                'jasa_servis.id_jasa = detail_jasa_servis.id_jasa'
            )
            ->where('id_transaksi', $id)
            ->get()
            ->getResultArray();

        $part = $db
            ->table('detail_penggunaan_part')
            ->select('detail_penggunaan_part.*, sparepart.nama_part')
            ->join(
                'sparepart',
                'sparepart.id_part = detail_penggunaan_part.id_part'
            )
            ->where('id_transaksi', $id)
            ->get()
            ->getResultArray();

        return view('backend/transaksi/servis/detail', [
            'h' => $header,
            'jasa' => $jasa,
            'part' => $part
        ]);
    }
}