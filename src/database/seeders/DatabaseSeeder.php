<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkTime;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        WorkTime::factory(200)->create();
    }
}
