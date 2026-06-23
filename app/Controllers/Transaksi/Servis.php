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
            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi_servis.id_kendaraan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik', 'left')
            ->join('pengguna', 'pengguna.id_pengguna = transaksi_servis.id_pengguna', 'left')
            ->orderBy('transaksi_servis.tanggal_masuk', 'DESC')
            ->findAll();

        $data = [
            'data'      => $riwayat,
            'pelanggan' => $db->table('pelanggan')->get()->getResultArray(),
            'mekanik'   => $db->table('mekanik')->get()->getResultArray(),
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
            $listJasa   = $this->request->getPost('jasa');
            $listPart   = $this->request->getPost('part');

            if (empty($headerData['id_kendaraan'])) throw new \Exception('Kendaraan wajib dipilih.');
            if (empty($headerData['id_mekanik'])) throw new \Exception('Mekanik wajib dipilih.');
            if (empty($listJasa) && empty($listPart)) throw new \Exception('Minimal harus ada jasa servis atau sparepart.');

            $transModel     = new TransaksiServisModel();
            $jasaModel      = new \App\Models\Transaksi\Servis\DetailJasaModel();
            $partModel      = new \App\Models\Transaksi\Servis\DetailPartModel();
            $sparepartModel = new \App\Models\Master\Part\SparepartModel();

            $headerData['id_pengguna']      = session()->get('id_pengguna');
            $headerData['tanggal_masuk']    = date('Y-m-d H:i:s');
            $headerData['status_transaksi'] = 'Draft'; 

            $idTrans = $transModel->insert($headerData, true);
            if (!$idTrans) throw new \Exception('Gagal menyimpan data utama transaksi.');

            if (is_array($listJasa)) {
                foreach ($listJasa as $j) {
                    if (empty($j['id_jasa'])) continue;
                    $j['id_transaksi'] = $idTrans;
                    $jasaModel->insert($j);
                }
            }

            if (is_array($listPart)) {
                foreach ($listPart as $p) {
                    if (empty($p['id_part'])) continue;

                    $masterPart = $sparepartModel->find($p['id_part']);
                    if (!$masterPart) throw new \Exception('Data sparepart tidak ditemukan.');

                    $p['id_transaksi']       = $idTrans;
                    $p['harga_satuan_modal'] = $masterPart['harga_modal']; 
                    $p['harga_satuan_jual']  = $p['harga_satuan_jual'] ?? $masterPart['harga_jual'];

                    $partModel->insert($p); 
                }
            }

            if ($db->transStatus() === false) throw new \Exception('Transaksi gagal. Pastikan stok mencukupi.');
            $db->transCommit();

            return redirect()->to('transaksi/servis')->with('success', 'Data servis berhasil disimpan.');

        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }


    public function edit($id)
    {
        $db = \Config\Database::connect();
        $transModel = new TransaksiServisModel();

        $header = $transModel->find($id);
        if (!$header) return redirect()->to('transaksi/servis')->with('error', 'Transaksi tidak ditemukan.');

        if ($header['status_pembayaran'] === 'Lunas' || (isset($header['status_transaksi']) && $header['status_transaksi'] === 'Lunas')) {
            return redirect()->to('transaksi/servis')->with('error', 'Transaksi yang sudah lunas tidak dapat diedit.');
        }

        $data = [
            'header'    => $header,
            'jasa_lama' => $db->table('detail_jasa_servis')->where('id_transaksi', $id)->get()->getResultArray(),
            'part_lama' => $db->table('detail_penggunaan_part')->where('id_transaksi', $id)->get()->getResultArray(),
            'kendaraan' => $db->table('kendaraan')
                              ->select('kendaraan.id_kendaraan, kendaraan.nomor_plat, pelanggan.nama_pelanggan')
                              ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
                              ->get()->getResultArray(),
            'mekanik'   => $db->table('mekanik')->get()->getResultArray(),
            'jasa_list' => $db->table('jasa_servis')->get()->getResultArray(),
            'part_list' => $db->table('sparepart')->get()->getResultArray(),
        ];

        return view('backend/transaksi/servis/edit', $data);
    }


    public function update()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $idTrans = $this->request->getPost('id_transaksi');
            if (empty($idTrans)) throw new \Exception('ID Transaksi tidak valid.');

            $transModel = new TransaksiServisModel();
            $transaksiLama = $transModel->find($idTrans);

            if (!$transaksiLama) throw new \Exception('Transaksi tidak ditemukan.');
            if ($transaksiLama['status_pembayaran'] === 'Lunas' || (isset($transaksiLama['status_transaksi']) && $transaksiLama['status_transaksi'] === 'Lunas')) {
                throw new \Exception('Transaksi lunas sudah dikunci.');
            }

            $headerData = $this->request->getPost('header');
            $listJasa   = $this->request->getPost('jasa');
            $listPart   = $this->request->getPost('part');

            $partModel      = new \App\Models\Transaksi\Servis\DetailPartModel();
            $jasaModel      = new \App\Models\Transaksi\Servis\DetailJasaModel();
            $sparepartModel = new \App\Models\Master\Part\SparepartModel(); 

            $partModel->where('id_transaksi', $idTrans)->delete();
            $jasaModel->where('id_transaksi', $idTrans)->delete();

            if (is_array($listJasa)) {
                foreach ($listJasa as $j) {
                    if (empty($j['id_jasa'])) continue;
                    $j['id_transaksi'] = $idTrans;
                    $jasaModel->insert($j);
                }
            }

            if (is_array($listPart)) {
                foreach ($listPart as $p) {
                    if (empty($p['id_part'])) continue;

                    $masterPart = $sparepartModel->find($p['id_part']);
                    if (!$masterPart) throw new \Exception('Data sparepart tidak ditemukan.');

                    $p['id_transaksi']       = $idTrans;
                    $p['harga_satuan_modal'] = $masterPart['harga_modal']; 
                    $p['harga_satuan_jual']  = $p['harga_satuan_jual'] ?? $masterPart['harga_jual'];

                    $partModel->insert($p);
                }
            }

            $transModel->update($idTrans, $headerData);

            if ($db->transStatus() === false) throw new \Exception('Terjadi kesalahan saat memproses data, mungkin karena stok tidak cukup.');
            $db->transCommit();

            return redirect()->to('transaksi/servis')->with('success', 'Data transaksi servis berhasil diperbarui!');

        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function update_status()
    {
        try {
            $id = $this->request->getPost('id_transaksi');
            if (empty($id)) throw new \Exception('Transaksi tidak ditemukan.');

            $model = new TransaksiServisModel();
            $model->update($id, ['status_pengerjaan' => $this->request->getPost('status_pengerjaan')]);

            return redirect()->to('transaksi/servis')->with('success', 'Status pengerjaan berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update_pembayaran()
    {
        try {
            $id = $this->request->getPost('id_transaksi');
            if (empty($id)) throw new \Exception('Transaksi tidak ditemukan.');

            $model = new TransaksiServisModel();
            $model->update($id, [
                'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
                'status_pembayaran' => $this->request->getPost('status_pembayaran')
            ]);

            return redirect()->to('transaksi/servis')->with('success', 'Pembayaran berhasil diperbarui.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        $model = new TransaksiServisModel();
        $db = \Config\Database::connect();

        $header = $model
            ->select('transaksi_servis.*, kendaraan.nomor_plat, pelanggan.nama_pelanggan, mekanik.nama_mekanik')
            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi_servis.id_kendaraan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik')
            ->where('id_transaksi', $id)
            ->first();

        $jasa = $db->table('detail_jasa_servis')
            ->select('detail_jasa_servis.*, jasa_servis.nama_jasa')
            ->join('jasa_servis', 'jasa_servis.id_jasa = detail_jasa_servis.id_jasa')
            ->where('id_transaksi', $id)
            ->get()->getResultArray();

        $part = $db->table('detail_penggunaan_part')
            ->select('detail_penggunaan_part.*, sparepart.nama_part')
            ->join('sparepart', 'sparepart.id_part = detail_penggunaan_part.id_part')
            ->where('id_transaksi', $id)
            ->get()->getResultArray();

        return view('backend/transaksi/servis/detail', [
            'h'    => $header,
            'jasa' => $jasa,
            'part' => $part
        ]);
    }
}