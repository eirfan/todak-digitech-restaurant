<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Stripe\Token;

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
                $user = User::create([
                    'name'=> $faker->name(),
                    'email'=> $faker->email(),
                    'password'=>Hash::make('todak!'),
                ]);
                $user->createAsStripeCustomer();
                
            }
            DB::commit();
        }catch(Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }
    }
}
