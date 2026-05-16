<?php

namespace App\Controllers;

use App\Controllers\BaseController;

abstract class BaseCrudController extends BaseController
{
    protected $model;
    protected $successMessages = [
        'save' => 'Data berhasil ditambahkan.',
        'update' => 'Data berhasil diperbarui.',
        'delete' => 'Data berhasil dihapus.',
    ];

    protected function handleSave(array $data)
    {
        if (!$this->model->save($data)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(', ', $this->model->errors()));
        }

        return redirect()->back()
            ->with('success', $this->successMessages['save']);
    }

    protected function handleUpdate($id, array $data)
    {
        if (!$this->model->update($id, $data)) {
            return redirect()->back()
                ->withInput()
                ->with('error', implode(', ', $this->model->errors()));
        }

        return redirect()->back()
            ->with('success', $this->successMessages['update']);
    }

    protected function handleDelete($id)
    {
        try {
            $this->model->delete($id);

            return redirect()->back()
                ->with('success', $this->successMessages['delete']);
        } catch (\Throwable $e) {
            return redirect()->back()
                ->with('error', 'Data tidak dapat dihapus karena masih digunakan.');
        }
    }
}