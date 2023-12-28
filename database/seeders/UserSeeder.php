<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'RENAN RODRIGUES DE OLIVEIRA',
            'email' => 'renanzip2@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
            'created_at' => now()
        ]);
    }
}
