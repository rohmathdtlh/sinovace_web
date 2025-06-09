<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder untuk user
        User::create([
            'name' => 'admin',
            'email' => 'sinovacedisdik@gmail.com',
            'password' => bcrypt('#dibaleka24'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'user',
            'email' => 'devisetya764@gmail.com',
            'password' => bcrypt('devisetya'),
            'role' => 'user',
        ]);

        // **Memanggil Seeder Kategori & Sub Kategori**
        $this->call([
            KategoriSubKategoriSeeder::class,
        ]);
    }
}
