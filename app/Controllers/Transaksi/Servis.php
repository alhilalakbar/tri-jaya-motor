<?php

namespace App\Controllers\Transaksi;

use App\Controllers\BaseController;
use App\Models\Transaksi\Servis\TransaksiServisModel;
use App\Models\Transaksi\Servis\DetailJasaModel;
use App\Models\Transaksi\Servis\DetailPartModel;
use App\Models\Transaksi\Servis\JasaLuarModel;
use App\Models\Master\Part\SparepartModel;

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

            if (empty($headerData['id_kendaraan']))
                throw new \Exception('Kendaraan wajib dipilih.');
            if (empty($headerData['id_mekanik']))
                throw new \Exception('Mekanik wajib dipilih.');
            if (empty($listJasa) && empty($listPart))
                throw new \Exception('Minimal harus ada jasa servis atau sparepart.');

            $transModel = new TransaksiServisModel();
            $jasaModel = new DetailJasaModel();
            $partModel = new DetailPartModel();
            $sparepartModel = new SparepartModel();

            $headerData['id_pengguna'] = session()->get('id_pengguna');
            $headerData['tanggal_masuk'] = date('Y-m-d H:i:s');
            $headerData['status_transaksi'] = 'Draft';

            $idTrans = $transModel->insert($headerData, true);
            if (!$idTrans)
                throw new \Exception('Gagal menyimpan data utama transaksi.');

            if (is_array($listJasa)) {
                foreach ($listJasa as $j) {
                    if (empty($j['id_jasa']))
                        continue;
                    $j['id_transaksi'] = $idTrans;
                    $jasaModel->insert($j);
                }
            }

            if (is_array($listPart)) {
                foreach ($listPart as $p) {
                    if (empty($p['id_part']))
                        continue;

                    $masterPart = $sparepartModel->find($p['id_part']);
                    if (!$masterPart)
                        throw new \Exception('Data sparepart tidak ditemukan.');

                    $p['id_transaksi'] = $idTrans;

                    $p['harga_satuan_modal'] = 0;

                    $p['harga_satuan_jual'] =
                        $p['harga_satuan_jual']
                        ?? $masterPart['harga_jual'];

                    $partModel->insert($p);
                }
            }

            if ($db->transStatus() === false)
                throw new \Exception('Transaksi gagal. Pastikan stok mencukupi.');
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
        if (!$header)
            return redirect()->to('transaksi/servis')->with('error', 'Transaksi tidak ditemukan.');

        if ($header['status_transaksi'] === 'Lunas') {
            return redirect()
                ->to('transaksi/servis')
                ->with('error', 'Transaksi yang sudah lunas tidak dapat diedit.');
        }

        $data = [
            'header' => $header,
            'jasa_lama' => $db->table('detail_jasa_servis')->where('id_transaksi', $id)->get()->getResultArray(),
            'part_lama' => $db->table('detail_penggunaan_part')->where('id_transaksi', $id)->get()->getResultArray(),
            'kendaraan' => $db->table('kendaraan')
                ->select('kendaraan.id_kendaraan, kendaraan.nomor_plat, pelanggan.nama_pelanggan')
                ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
                ->get()->getResultArray(),
            'mekanik' => $db->table('mekanik')->get()->getResultArray(),
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
            if (empty($idTrans))
                throw new \Exception('ID Transaksi tidak valid.');

            $transModel = new TransaksiServisModel();
            $transaksiLama = $transModel->find($idTrans);

            if (!$transaksiLama)
                throw new \Exception('Transaksi tidak ditemukan.');
            if ($transaksiLama['status_transaksi'] === 'Lunas') {
                throw new \Exception('Transaksi lunas sudah dikunci.');
            }

            $headerData = $this->request->getPost('header');
            $listJasa = $this->request->getPost('jasa');
            $listPart = $this->request->getPost('part');

            $partModel = new DetailPartModel();
            $jasaModel = new DetailJasaModel();
            $sparepartModel = new SparepartModel();

            $partModel->where('id_transaksi', $idTrans)->delete();
            $jasaModel->where('id_transaksi', $idTrans)->delete();

            if (is_array($listJasa)) {
                foreach ($listJasa as $j) {
                    if (empty($j['id_jasa']))
                        continue;
                    $j['id_transaksi'] = $idTrans;
                    $jasaModel->insert($j);
                }
            }

            if (is_array($listPart)) {
                foreach ($listPart as $p) {
                    if (empty($p['id_part']))
                        continue;

                    $masterPart = $sparepartModel->find($p['id_part']);
                    if (!$masterPart)
                        throw new \Exception('Data sparepart tidak ditemukan.');

                    $p['id_transaksi'] = $idTrans;

                    $p['harga_satuan_modal'] = 0;

                    $p['harga_satuan_jual'] =
                        $p['harga_satuan_jual']
                        ?? $masterPart['harga_jual'];

                    $partModel->insert($p);
                }
            }

            $transModel->update($idTrans, $headerData);

            if ($db->transStatus() === false)
                throw new \Exception('Terjadi kesalahan saat memproses data, mungkin karena stok tidak cukup.');
            $db->transCommit();

            return redirect()->to('transaksi/servis')->with('success', 'Data transaksi servis berhasil diperbarui!');

        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function update_status()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {

            $id = $this->request->getPost('id_transaksi');

            if (empty($id)) {
                throw new \Exception('Transaksi tidak ditemukan.');
            }

            $statusPengerjaan = $this->request->getPost('status_pengerjaan');

            $model = new TransaksiServisModel();

            $transaksi = $model->find($id);

            if (!$transaksi) {
                throw new \Exception('Transaksi tidak ditemukan.');
            }

            if (in_array($transaksi['status_transaksi'], ['Lunas', 'Dibatalkan'])) {
                throw new \Exception('Transaksi sudah final.');
            }

            $data = [
                'status_pengerjaan' => $statusPengerjaan,
            ];

            switch ($statusPengerjaan) {

                case 'Antre':
                    $data['status_transaksi'] = 'Draft';
                    break;

                case 'Diproses':
                case 'Menunggu Part':
                case 'Selesai':
                    $data['status_transaksi'] = 'Progress';
                    break;

                case 'Diambil':

                    // Jalankan FIFO sebelum transaksi dikunci
                    $this->prosesFIFO($id);

                    $data['status_transaksi'] = 'Lunas';
                    break;
            }

            $model->update($id, $data);

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal memperbarui status.');
            }

            $db->transCommit();

            return redirect()
                ->to('transaksi/servis')
                ->with('success', 'Status berhasil diperbarui.');

        } catch (\Throwable $e) {

            $db->transRollback();

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    public function update_transaksi()
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        try {

            $id = $this->request->getPost('id_transaksi');

            if (empty($id)) {
                throw new \Exception('Transaksi tidak ditemukan.');
            }

            $model = new TransaksiServisModel();

            $transaksi = $model->find($id);
            if (!$transaksi) {
                throw new \Exception('Data transaksi tidak ada di database.');
            }

            if (in_array($transaksi['status_transaksi'], ['Lunas', 'Dibatalkan'])) {
                throw new \Exception('Transaksi sudah final dan tidak dapat diubah.');
            }

            $statusTransaksi = $this->request->getPost('status_transaksi');
            $metodePembayaran = $this->request->getPost('metode_pembayaran');

            $data = [
                'status_transaksi' => $statusTransaksi,
            ];

            if ($statusTransaksi === 'Lunas') {

                $data['metode_pembayaran'] = $metodePembayaran;
                $data['status_pengerjaan'] = 'Diambil';

                if (
                    in_array(
                        $transaksi['status_transaksi'],
                        ['Draft', 'Progress']
                    )
                ) {
                    $this->prosesFIFO($id);
                }

            } elseif ($statusTransaksi === 'Dibatalkan') {

                $data['metode_pembayaran'] = null;
                $data['status_pengerjaan'] = 'Diambil';

            } else {

                $data['metode_pembayaran'] = $metodePembayaran;

            }

            $model->update($id, $data);

            if ($db->transStatus() === false) {
                throw new \Exception('Gagal memperbarui transaksi.');
            }

            $db->transCommit();

            return redirect()
                ->to('transaksi/servis')
                ->with('success', 'Status transaksi berhasil diperbarui.');

        } catch (\Throwable $e) {

            $db->transRollback();

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    private function prosesFIFO(int $idTransaksi): void
    {
        $db = \Config\Database::connect();

        $detailPart = $db->table('detail_penggunaan_part')
            ->where('id_transaksi', $idTransaksi)
            ->get()
            ->getResultArray();

        foreach ($detailPart as $part) {

            $jumlah = (int) $part['jumlah_pakai'];
            $sisa = $jumlah;
            $totalHPP = 0;

            $batchList = $db->table('detail_pembelian_stok')
                ->where('id_part', $part['id_part'])
                ->where('qty_tersisa >', 0)
                ->orderBy('id_detail_pembelian', 'ASC')
                ->get()
                ->getResultArray();

            foreach ($batchList as $batch) {

                if ($sisa <= 0) {
                    break;
                }

                $ambil = min($batch['qty_tersisa'], $sisa);

                $db->table('detail_pembelian_stok')
                    ->where('id_detail_pembelian', $batch['id_detail_pembelian'])
                    ->update([
                        'qty_tersisa' => $batch['qty_tersisa'] - $ambil
                    ]);

                $totalHPP += $ambil * (float) $batch['harga_beli_satuan'];

                $sisa -= $ambil;
            }

            if ($sisa > 0) {
                throw new \Exception(
                    "Stok FIFO untuk part ID {$part['id_part']} tidak mencukupi."
                );
            }

            $hppRata = round($totalHPP / $jumlah, 2);

            $db->table('detail_penggunaan_part')
                ->where('id_detail_part', $part['id_detail_part'])
                ->update([
                    'harga_satuan_modal' => $hppRata
                ]);
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

        $jasaLuarModel = new JasaLuarModel();
        $jasa_luar = $jasaLuarModel->where('id_transaksi', $id)->findAll();

        return view('backend/transaksi/servis/detail', [
            'h' => $header,
            'jasa' => $jasa,
            'part' => $part,
            'jasa_luar' => $jasa_luar
        ]);
    }
}