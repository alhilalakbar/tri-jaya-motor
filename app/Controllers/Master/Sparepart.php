<?php

namespace App\Controllers\Master;

use App\Controllers\BaseCrudController;
use App\Models\Master\Part\SparepartModel;
use App\Models\Master\Part\KategoriPartModel;
use App\Models\Master\Part\MerekPartModel;

class Sparepart extends BaseCrudController
{
    protected $model;

    public function __construct()
    {
        $this->model = new SparepartModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $kat = new KategoriPartModel();
        $merk = new MerekPartModel();

        $builder = $this->model
            ->select('sparepart.*, kategori_part.nama_kategori, merek_part.nama_merek_part')
            ->join('kategori_part', 'kategori_part.id_kategori = sparepart.id_kategori')
            ->join('merek_part', 'merek_part.id_merek_part = sparepart.id_merek_part', 'left');

        if ($keyword) {
            $builder->groupStart()
                ->like('sparepart.nama_part', $keyword)
                ->orLike('kategori_part.nama_kategori', $keyword)
                ->orLike('merek_part.nama_merek_part', $keyword)
                ->groupEnd();
        }

        return view('backend/master/sparepart/index', [
            'sparepart' => $builder->findAll(),
            'kategori' => $kat->findAll(),
            'merek' => $merk->findAll(),
            'keyword' => $keyword
        ]);
    }

    public function save()
    {
        return $this->handleSave($this->request->getPost());
    }

    public function update($id)
    {
        return $this->handleUpdate($id, $this->request->getPost());
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}