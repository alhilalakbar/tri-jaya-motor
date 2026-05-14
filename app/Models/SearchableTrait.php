<?php

namespace App\Models;

trait SearchableTrait
{
    /**
     * Fungsi untuk mencari data berdasarkan keyword pada semua kolom yang diizinkan.
     */
    public function search($keyword)
    {
        if (!$keyword) {
            return $this;
        }

        return $this->groupStart()
            ->like($this->table . '.' . $this->primaryKey, $keyword) // Cari berdasarkan ID
            ->groupStart()
            ->orLike(
                array_combine(
                    $this->allowedFields,
                    array_fill(0, count($this->allowedFields), $keyword)
                )
            )
            ->groupEnd()
            ->groupEnd();
    }
}