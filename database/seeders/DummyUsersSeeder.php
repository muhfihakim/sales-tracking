<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'nama' => 'KimDev',
                'email' => 'admin@mybbs.id',
                'role' => 'Admin',
                'password' => bcrypt('admin123')
            ]
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
