<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

//        $this->call(SignerTableSeeder::class);
        $this->call(ApplicantTableSeeder::class);
        $this->call(ManagerTableSeeder::class);
        $this->call(InterviewGroupTableSeeder::class);

        Model::reguard();
    }
}
