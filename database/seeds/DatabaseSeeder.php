<?php

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
        // $this->call(UserSeeder::class);
        $this->call([
            ProvinceTableSeeder::class,
            CityTableSeeder::class,
            DistrictTableSeeder::class,
            UsersTableSeeder::class
        ]);
        // $this->call(CityTableSeeder::class);
        // $this->call(DistrictTableSeeder::class);
    }
}
