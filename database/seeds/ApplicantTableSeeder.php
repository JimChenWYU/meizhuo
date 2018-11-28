<?php

use Illuminate\Database\Seeder;

class ApplicantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $department = [
            '移动组', 'Web组', '美工组', '营销策划'
        ];

        $fake = \Faker\Factory::create();

        if (config('app.debug')) {
            for ($i = 0; $i < 100; $i++) {
                \App\Applicant::create([
                    'student_id' => $fake->numberBetween(1000000000, 9999999999),
                    'name' => $fake->lastName,
                    'major' => $fake->company,
                    'phone_num' => $fake->numberBetween(18219111000, 18219119999),
                    'grade' => '大一',
                    'department' => $department[$fake->numberBetween(0, 3)],
                    'introduce' => $fake->regexify('[\u4e00-\u9fa5]{6,50}')
                ]);
            }

            \App\Applicant::create([
                'student_id' => 3114002521,
                'name' => '陈君武',
                'major' => '计算机科学与技术',
                'phone_num' => '18219111672',
                'grade' => '大一',
                'department' => '移动组',
                'introduce' => '哈哈哈哈哈哈啊哈哈'
            ]);

            \App\Applicant::create([
                'student_id' => 3114002521,
                'name' => '陈君武',
                'major' => '计算机科学与技术',
                'phone_num' => '18219111672',
                'grade' => '大一',
                'department' => 'Web组',
                'introduce' => '哈哈哈哈哈哈啊哈哈'
            ]);
        }
    }
}
