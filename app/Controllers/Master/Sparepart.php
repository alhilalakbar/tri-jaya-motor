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
        $data = $this->request->getPost();

        $nama = preg_replace('/\s+/', ' ', trim($data['nama_part']));

        if ((float)$data['harga_jual'] < 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Harga jual tidak boleh negatif.');
        }

        if ((int)$data['stok_minimum'] < 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok minimum tidak boleh negatif.');
        }

        $existing = $this->model
            ->where('TRIM(nama_part)', $nama)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama sparepart sudah terdaftar.');
        }

        $data['nama_part'] = $nama;

        return $this->handleSave($data);
    }

    public function update($id)
    {
        $data = $this->request->getPost();

        $nama = preg_replace('/\s+/', ' ', trim($data['nama_part']));

        if ((float)$data['harga_jual'] < 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Harga jual tidak boleh negatif.');
        }

        if ((int)$data['stok_minimum'] < 0) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Stok minimum tidak boleh negatif.');
        }

        $existing = $this->model
            ->where('TRIM(nama_part)', $nama)
            ->where('id_part !=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama sparepart sudah terdaftar.');
        }

        $data['nama_part'] = $nama;

        return $this->handleUpdate($id, $data);
    }

    public function delete($id)
    {
        return $this->handleDelete($id);
    }
}