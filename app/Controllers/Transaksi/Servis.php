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

        $riwayat = $model->select('transaksi_servis.*, kendaraan.nomor_plat, pelanggan.nama_pelanggan, mekanik.nama_mekanik, pengguna.nama_pengguna')
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
                ->get()->getResultArray(),
        ];

        return view('backend/transaksi/servis/index', $data);
    }
    public function create()
    {
        $db = \Config\Database::connect();

        $db->transBegin();

        try {

            $transModel = new \App\Models\Transaksi\Servis\TransaksiServisModel();

            $headerData = $this->request->getPost('header');

            $headerData['id_pengguna'] = session()->get('id_pengguna');

            $headerData['tanggal_masuk'] = date('Y-m-d H:i:s');

            $idTrans = $transModel->insert($headerData, true);

            if (!$idTrans) {
                throw new \Exception("Gagal menyimpan data utama transaksi.");
            }

            $jasaModel = new \App\Models\Transaksi\Servis\DetailJasaModel();

            $listJasa = $this->request->getPost('jasa');

            if (is_array($listJasa)) {

                foreach ($listJasa as $j) {

                    $j['id_transaksi'] = $idTrans;

                    $jasaModel->insert($j);
                }
            }

            $partModel = new \App\Models\Transaksi\Servis\DetailPartModel();

            $listPart = $this->request->getPost('part');

            if (is_array($listPart)) {

                foreach ($listPart as $p) {

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
                ->to('backend/transaksi/servis')
                ->with('message', 'Data servis berhasil disimpan.');

        } catch (\Exception $e) {

            $db->transRollback();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
    public function update_status()
    {
        $model = new \App\Models\Transaksi\Servis\TransaksiServisModel();
        $id = $this->request->getPost('id_transaksi');

        $data = [
            'status_pengerjaan' => $this->request->getPost('status_pengerjaan'),
            'metode_pembayaran' => $this->request->getPost('metode_pembayaran'),
            'status_pembayaran' => $this->request->getPost('status_pembayaran'),
        ];

        $model->update($id, $data);

        return redirect()->to('backend/transaksi/servis')->with('message', 'Status transaksi berhasil diperbarui');
    }

    public function detail($id)
    {
        $model = new \App\Models\Transaksi\Servis\TransaksiServisModel();
        $db = \Config\Database::connect();

        $header = $model->select('transaksi_servis.*, kendaraan.nomor_plat, pelanggan.nama_pelanggan, mekanik.nama_mekanik')
            ->join('kendaraan', 'kendaraan.id_kendaraan = transaksi_servis.id_kendaraan')
            ->join('pelanggan', 'pelanggan.id_pelanggan = kendaraan.id_pelanggan')
            ->join('mekanik', 'mekanik.id_mekanik = transaksi_servis.id_mekanik')
            ->where('id_transaksi', $id)->first();

        $jasa = $db->table('detail_jasa_servis')
            ->select('detail_jasa_servis.*, jasa_servis.nama_jasa')
            ->join('jasa_servis', 'jasa_servis.id_jasa = detail_jasa_servis.id_jasa')
            ->where('id_transaksi', $id)->get()->getResultArray();

        $part = $db->table('detail_penggunaan_part')
            ->select('detail_penggunaan_part.*, sparepart.nama_part')
            ->join('sparepart', 'sparepart.id_part = detail_penggunaan_part.id_part')
            ->where('id_transaksi', $id)->get()->getResultArray();

        return view('backend/transaksi/servis/detail', ['h' => $header, 'jasa' => $jasa, 'part' => $part]);
    }
}