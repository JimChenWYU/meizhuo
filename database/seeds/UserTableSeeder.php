<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('manager')->delete();
        DB::table('manager')->insert([
            'name' => 'hr',
            'email' => 'hr@163.com',
            'password' => Crypt::encrypt('123'),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}
