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
        // \App\Models\User::factory(10)->create();
        $this->call(PermissionsDemoSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(JurusanSeeder::class);
        $this->call(AngkatanSeeder::class);
        $this->call(SiswaSeeder::class);
        $this->call(GolRkasSeeder::class);
    }
}
