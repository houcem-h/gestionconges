<?php

use Illuminate\Database\Seeder;

class HistoriqueCongeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HistoriqueConge::class, 1200)->create();
    }
}
