<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_pengguna' => 'owner',
                'kata_sandi'    => '$2y$10$FdlY.IzJn8U/vT7mq2GyHOm1xKx8DyhydbyBXg1OIHu7X5/JkEPn2',
                'peran'          => 'Pemilik',
            ],
            [
                'nama_pengguna' => 'admin',
                'kata_sandi'    => '$2y$10$cYjKOmkVM.FbtzUwY0IaduwMiCOBCzx2LABDSMaXmcQsxceekzoTq',
                'peran'          => 'Admin',
            ],
            [
                'nama_pengguna' => 'mekanik',
                'kata_sandi'    => '$2y$10$3ugpWSsSYhu3v4NNxpc8ue0KKJjUFl0S2mPaHJkHmchZNaNnJue8m',
                'peran'          => 'Mekanik',
            ],
        ];

        $this->db->table('pengguna')->insertBatch($data);
    }
}