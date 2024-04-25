<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SeedTestingAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try{
            DB::beginTransaction();

            $user = User::create([
                'name'=>'Client todak',
                'email'=>'client@todak.my',
                'password'=>Hash::make('todak!'),
                'stripe_id'=>'cus_PzTfjffpfSIH0E',
            ]);
            DB::commit();
        }catch(Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }
    }
}
