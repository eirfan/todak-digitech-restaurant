<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class SeedUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        try{
            DB::beginTransaction();
            for($i = 0; $i<10; $i++) {
                User::create([
                    'name'=> $faker->name(),
                    'email'=> $faker->email(),
                    'password'=>Hash::make('todak!'),
                ]);
            }
            DB::commit();
        }catch(Exception $exception) {
            DB::rollBack();
        }
    }
}
