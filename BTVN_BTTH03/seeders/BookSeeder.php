<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('books')->insert([
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'publication_year' => 2008,
                'genre' => 'Programming',
                'library_id' => 1
            ],
            [
                'title' => 'Design Patterns',
                'author' => 'Erich Gamma',
                'publication_year' => 1994,
                'genre' => 'Software Engineering',
                'library_id' => 1
            ],
            [
                'title' => 'Kinh tế vi mô',
                'author' => 'N. Gregory Mankiw',
                'publication_year' => 2010,
                'genre' => 'Economics',
                'library_id' => 2
            ]
        ]);

    }
}
