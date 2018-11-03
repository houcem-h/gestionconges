<?php

use Illuminate\Database\Seeder;

class CongeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Conge::class, 500)->create();
    }
}
