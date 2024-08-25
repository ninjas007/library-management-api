<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'a1c7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f',
                'name' => 'Test 1',
                'bio' => 'Test bio 1',
                'birth_date' => '2000-01-01',
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00',
            ],
            [
                'id' => 'a2c7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f',
                'name' => 'Test 2',
                'bio' => 'Test bio 2',
                'birth_date' => '2001-01-01',
                'created_at' => '2021-01-01 00:00:00',
                'updated_at' => '2021-01-01 00:00:00',
            ],
        ];

        Author::insert($data);
    }
}
