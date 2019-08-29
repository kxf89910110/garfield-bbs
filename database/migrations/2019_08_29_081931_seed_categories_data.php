<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedCategoriesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $categories = [
            [
                'name' => 'Share',
                'description' => 'Share creation, share discovery.',
            ],
            [
                'name' => 'Tutorial',
                'description' => 'Development skills, recommended extensions, etc.',
            ],
            [
                'name' => 'Discuss',
                'description' => 'Please be friendly and help each other.',
            ],
            [
                'name' => 'announcement',
                'description' => 'Site announcement',
            ],
        ];

        DB::table('categories')->insert($categories);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categories')->truncate();
    }
}
