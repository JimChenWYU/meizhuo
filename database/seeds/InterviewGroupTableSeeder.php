<?php

use Illuminate\Database\Seeder;

class InterviewGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [ 'department' => '移动组', 'number' => 1 ],
            [ 'department' => '移动组', 'number' => 2 ],
            [ 'department' => '移动组', 'number' => 3 ],

            [ 'department' => 'Web组', 'number' => 1 ],
            [ 'department' => 'Web组', 'number' => 2 ],
            [ 'department' => 'Web组', 'number' => 3 ],

            [ 'department' => '美工组', 'number' => 1 ],
            [ 'department' => '美工组', 'number' => 2 ],
            [ 'department' => '美工组', 'number' => 3 ],

            [ 'department' => '营销策划', 'number' => 1 ],
            [ 'department' => '营销策划', 'number' => 2 ],
            [ 'department' => '营销策划', 'number' => 3 ],
        ];
        //
        DB::table('interview_group')->delete();
        DB::table('interview_group')->insert($data);
    }
}
