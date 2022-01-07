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
        // \App\Models\User::factory(10)->create();
        DB::transaction(function() {
            $this->call(
                [
                    RoleSeeder::class,
                    UserSeeder::class,
                    CategorySeeder::class
                ]
            );
        });
    }
}
