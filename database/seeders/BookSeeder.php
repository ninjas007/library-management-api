<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'abc7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f',
                'title' => 'Book 1',
                'description' => 'Description 1',
                'publish_date' => "2024-08-24",
                'author_id' => 'a1c7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f',
                "created_at" => "2024-08-24 10:00:00",
                "updated_at" => "2024-08-24 10:00:00",
            ],
            [
                'id' => 'abd7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f',
                'title' => 'Book 2',
                'description' => 'Description 2',
                'publish_date' => "2023-08-24",
                'author_id' => 'a2c7c5a5-9f5c-4f6b-8a0b-1c2b3a4d5e6f',
                "created_at" => "2023-08-24 11:00:00",
                "updated_at" => "2023-08-24 11:00:00",
            ],
        ];

        Book::insert($data);
    }
}
