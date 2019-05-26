<?php

use Illuminate\Database\Seeder;
use App\Grade;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(Grade::class, 20)->create();
        factory(User::class, 1)->create();
    }
}
