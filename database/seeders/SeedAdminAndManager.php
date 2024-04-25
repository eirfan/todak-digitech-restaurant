<?php

namespace Database\Seeders;

use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SeedAdminAndManager extends Seeder
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
                'name'=>'manager',
                'email'=>'manager@todak.com',
                'password'=>Hash::make('todak88!'),
            ]);
            $user->assignRole(config('base.role_id.manager'));


            $user = User::create([
                'name'=>'admin',
                'email'=>'admin@todak.com',
                'password'=>Hash::make('todak88!'),
            ]);
            $user->assignRole(config('base.role_id.admin'));
            DB::commit();
        }catch(Exception $exception) 
        {
            DB::rollBack();
            Log::error($exception->getMessage());
        }
    }
}
