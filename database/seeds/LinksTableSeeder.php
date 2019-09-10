<?php

use Illuminate\Database\Seeder;
use App\Models\Link;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Generating data sets
        $links = factory(Link::class)->times(6)->make();

        // Convert the data collection to an array and insert it into the database
        Link::insert($links->toArray());
    }
}
