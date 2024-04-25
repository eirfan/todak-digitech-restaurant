<?php

namespace Database\Seeders;

use App\Models\Restaurants;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeedRestaurant extends Seeder
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
            $restaurantFirstName = [
                'Nasi Kandar',
                'Tomyam',
                'Roti John',
                'Abu',
                'Masakan',
                'Air Tangan',
                'Dapur'
            ];
            $restaurantLastName=[
                'Barakat',
                'Seaford',
                'Mamak',
                'Western',
                'Bonda',
                'Ibu',
                'Viral'
            ];
            $categories =[
                'Asian',
                'Western',
                'Desserts',
                'Eastern',
                'Chinese',
            ];
           
            for($i = 0; $i<10;$i++) {
                Restaurants::create([
                    'name'=>$restaurantFirstName[array_rand($restaurantFirstName)]." ".$restaurantLastName[array_rand($restaurantLastName)],
                    'address'=>$faker->address(),
                    'categories'=>$categories[array_rand($categories)],
                    'manager_id'=>User::inRandomOrder()->first()->id,
                ]);
            }
            DB::commit();
        }catch(Exception $exception) 
        {
            DB::rollBack();
            Log::error($exception->getMessage());
        }
    }
}
