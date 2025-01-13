<?php

namespace Database\Seeders;

use App\Models\Multimedia;
use Illuminate\Database\Seeder;

class MultimediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Multimedia::factory(30)->create();
    }
}
