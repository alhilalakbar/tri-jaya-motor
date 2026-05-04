<?php
namespace App\Controllers\Transaksi;
use App\Controllers\BaseController;
use App\Models\Transaksi\Servis\TransaksiServisModel;
use App\Models\Transaksi\Servis\DetailJasaModel;
use App\Models\Transaksi\Servis\DetailPartModel;

class Servis extends BaseController
{
    public function index()
    {
        $model = new TransaksiServisModel();
        return view('transaksi/servis/index', ['data' => $model->findAll()]);
    }
    public function create()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $transModel = new TransaksiServisModel();
            $idTrans = $transModel->insert($this->request->getPost('header'), true);

            $jasaModel = new DetailJasaModel();
            foreach ($this->request->getPost('jasa') as $j) {
                $j['id_transaksi'] = $idTrans;
                $jasaModel->insert($j);
            }

            $partModel = new DetailPartModel();
            foreach ($this->request->getPost('part') as $p) {
                $p['id_transaksi'] = $idTrans;
                $partModel->insert($p);
            }

            $db->transCommit();
            return redirect()->to('/transaksi/servis');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back();
        }
    }
}