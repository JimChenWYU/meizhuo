<?php

use Illuminate\Database\Seeder;

class SignerTableSeeder extends Seeder
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
        for ($i = 0; $i < 100; $i++) {
            \App\Signer::create([
                'student_id' => $fake->numberBetween(1000000000, 9999999999),
                'name' => $fake->name,
                'major' => $fake->company,
                'phone_num' => $fake->numberBetween(18219111000, 18219119999),
                'grade' => '大一',
                'department' => $department[$fake->numberBetween(0, 3)],
                'introduce' => $fake->regexify('[\u4e00-\u9fa5]{6,50}')
            ]);
        }
    }
}
