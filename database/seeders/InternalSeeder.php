<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bendahara;
use App\Models\Kepsek;
use App\Models\Penerima;

class InternalSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder Bendahara
        Bendahara::create([
            'name' => 'Bendahara BOS',
            'type' => 'BOS',
            'nip' => 1234567890,
            'userID' => 1
        ]);
        // Seeder Kepsek
        Kepsek::create([
            'name' => 'Kepala Sekolah',
            'nip' => 1987654321,
            'school' => 'SMKN 1 Talaga',
            'address' => 'Jl. Sekolah No. 20',
            'userID' => 1
        ]);
        // Seeder Penerima
        Penerima::create([
            'name' => 'Penerima Barang',
            'nip' => 1122334455,
            'position' => 'Staff ICT',
            'userID' => 1
        ]);
    }
}
