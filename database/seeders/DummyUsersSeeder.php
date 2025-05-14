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
            'name' => 'qiqi',
            'email' => 'lalurfqi@gmail.com',
            'role' => 'pembeli',
            'password' =>bcrypt(123456),
            ],
            [
            'name' => 'ayu',
            'email' => 'ayuliza@gmail.com',
            'role' => 'penjual',
            'password' =>bcrypt(123456),
            ],
            [
            'name' => 'aan',
            'email' => 'aan@gmail.com',
            'role' => 'inspektor',
            'password' =>bcrypt(123456),
            ],
            [
            'name' => 'eca',
            'email' => 'eca@gmail.com',
            'role' => 'admin',
            'password' =>bcrypt(123456),
            ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
