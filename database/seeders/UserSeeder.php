<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    public function run(): void {
        DB::table('users')->insert([
            [
                'name'       => 'Admin PPKD',
                'email'      => 'admin@ppkdhotel.com',
                'password'   => Hash::make('admin123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Resepsionis 1',
                'email'      => 'resepsionis@ppkdhotel.com',
                'password'   => Hash::make('resepsionis123'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
