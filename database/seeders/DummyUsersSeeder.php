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
                'name'=>'Mas Kasir1',
                'email'=>'kasir1@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'kasir',
            ],
            [
                'name'=>'Mas Kasir2',
                'email'=>'kasir2@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'kasir',
            ],
            [
                'name'=>'Mas Kasir3',
                'email'=>'kasir3@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'kasir',
            ],
            [
                'name'=>'Mas Kasir4',
                'email'=>'kasir4@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'kasir',
            ],
            [
                'name'=>'Mas pelanggan1',
                'email'=>'pelanggan1@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'pelanggan',
            ],
            [
                'name'=>'Mas pelanggan2',
                'email'=>'pelanggan2@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'pelanggan',
            ],
            [
                'name'=>'Mas pelanggan3',
                'email'=>'pelanggan3@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'pelanggan',
            ],
            [
                'name'=>'Mas pelanggan4',
                'email'=>'pelanggan4@gmail.com',
                'password'=>bcrypt('123'),
                'role'=>'pelanggan',
            ],
        ];

        foreach($userData as $key => $val){
            User::create($val);
        }
    }
}
