<?php

namespace Database\Seeders;

use App\Models\Menus;
use App\Models\Restaurants;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SeedMenu extends Seeder
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

            $localMenus = [
                'Nasi goreng',
                'Mee goreng',
                'Laksa penang',
                'Mee kari',
                'Bihun goreng',
                'Bihun tomyam',
                'Laksa johor',
                'Laksa sarawak'
            ];
            for($i = 0; $i<20; $i++) {
                Menus::create([
                    'name'=>$localMenus[array_rand($localMenus)],
                    'price'=>$faker->numberBetween(1,20),
                    'restaurant_id'=>Restaurants::inRandomOrder()->first()->id,
                ]);
            }
            DB::commit();
        }catch(Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }
    }
}
