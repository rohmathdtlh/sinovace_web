<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // Pastikan sudah mengimport model Admin

class AdminTableSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan admin baru
        Admin::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'), // pastikan menggunakan bcrypt untuk password
        ]);

        // Jika ingin menambahkan lebih banyak admin, bisa menggunakan factory atau create lagi
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('superadmin123'),
        ]);
    }
}
