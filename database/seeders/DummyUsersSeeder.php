<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [
            [
                'name'=>'Mas Kasir',
                'email'=>'kasir@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'kasir',
            ],
            [
                'name'=>'Mas pelanggan',
                'email'=>'pelanggan@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'pelanggan',
            ],
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
