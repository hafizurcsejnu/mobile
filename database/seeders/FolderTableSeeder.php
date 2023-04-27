<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FolderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('folders')->insert([
            ["name"=>"Resume"],
            ["name"=>"Cover Letters"],
            ["name"=>"Certificates"],
            ["name"=>"Recommendations"],
            ["others"=>"Others"]
        ]);
    }
}
