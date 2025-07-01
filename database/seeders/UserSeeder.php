<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada user dengan id=1
        User::unguard();
        User::updateOrCreate(['id' => 1], [
            'username' => 'admin_utama',
            'namalengkap' => 'Admin Utama',
            'password' => 'aadmin_utama'
        ]);
        // Data user lain
        $users = [
            [
                'username' => 'admin_1',
                'namalengkap' => 'Admin Satu',
                'password' => 'admin_01'
            ],
            [
                'username' => 'admin_2',
                'namalengkap' => 'Admin Dua',
                'password' => 'admin_001'
            ],
            [
                'username' => 'admin_3',
                'namalengkap' => 'Admin Tiga',
                'password' => 'admin_003'
            ],
        ];
        foreach ($users as $user) {
            User::firstOrCreate(['username' => $user['username']], $user);
        }
        User::reguard();
    }
}
