<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        UserPermissionSedder::class,
        ]);
        // \App\Models\Category::factory(10)->create();
        // \App\Models\Page::factory(20)->create();
        // \App\Models\Notice::factory(20)->create();
        // \App\Models\News::factory(20)->create();
        // \App\Models\Project::factory(20)->create();

    }
}
