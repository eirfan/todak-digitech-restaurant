<?php

namespace Database\Seeders;

use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class SeedRole extends Seeder
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
            Role::create([
                'name'=>'client',
                'guard_name'=>'web'
            ]);

            Role::create([
                'name'=>'manager',
                'guard_name'=>'web'
            ]);
            Role::create([
                'name'=>'admin',
                'guard_name'=>'web'
            ]);
            DB::commit();
        }catch(Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }
    }
}
