<?php


namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravel\Jetstream\Role; 

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //llamar a los seeders creados
        $this -> call(RoleSeeder::class);
        $this -> call(UserSeeder::class);


        // User::factory(10)->create();

    }
}
