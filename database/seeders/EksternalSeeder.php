<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kegiatan;
use App\Models\Penyedia;

class EksternalSeeder extends Seeder
{
    public function run(): void
    {
        // Seeder Kegiatan
        Kegiatan::create([
            'userID' => 1,
            'name' => 'Pengadaan Komputer',
            'order' => now(),
            'deadline' => now()->addDays(7),
            'info' => 'Pengadaan perangkat komputer untuk lab'
        ]);
        // Seeder Penyedia
        Penyedia::create([
            'userID' => 1,
            'company' => 'CV Techria Indonesia',
            'npwp' => 123456789012345,
            'address' => 'Jl. Teknologi No. 1',
            'bank' => 'BRI',
            'post_code' => 9876543210,

            'account' => 9876543210,
            'delegation_name' => 'Najmy',
            'delegate_position' => 'Direktur'
        ]);
    }
}
