<?php

namespace Database\Seeders;

use App\Models\Api\v1\User\UserModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('Tes123@tes'),
            ],
        ];

        UserModel::truncate();
        UserModel::insert($data);
    }
}
