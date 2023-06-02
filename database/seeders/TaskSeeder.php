<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->has(Tag::factory()->count(3))->count(50)->create();
    }
}
