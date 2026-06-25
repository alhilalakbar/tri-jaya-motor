<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('CounterKodeSeeder');
        $this->call('MasterSeeder');
        $this->call('PemasokSeeder');
        $this->call('UserSeeder');
    }
}