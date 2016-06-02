<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(InstagramProfileTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(ImageTableSeeder::class);
    }
}
