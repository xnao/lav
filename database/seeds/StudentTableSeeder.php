<?php

use Illuminate\Database\Seeder;

class StudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('students')
            ->insert([
           ['name'  =>  'sean', 'age'   =>  20, 'sex'   => 1],
           ['name'  =>  'david', 'age'   =>  22, 'sex'   => 0],

            ]);
    }
}
