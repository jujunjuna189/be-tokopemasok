<?php

namespace Database\Seeders;

use App\Models\Api\v1\Category\CategoryModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'image' => '',
                'title' => 'Bahan',
            ],
        ];

        CategoryModel::truncate();
        CategoryModel::insert($data);
    }
}
