<?php

use Illuminate\Database\Seeder;

class InstagramProfileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\InstagramProfile::class)->create();
    }
}
