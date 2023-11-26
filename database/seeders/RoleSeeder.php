<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->upsert([
            ['name' => 'admin', 'guard_name' => 'api'],
            ['name' => 'patient', 'guard_name' => 'api'],
            ['name' => 'staff', 'guard_name' => 'api']
        ], 'name');
    }
}
