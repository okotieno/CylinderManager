<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(BrandSeeder::class);
        $this->call(DepotSeeder::class);
        $this->call(DealerSeeder::class);
        $this->call(TransporterSeeder::class);
    }
}
