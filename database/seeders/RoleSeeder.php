<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Admin', 'Promoteur', 'DAF', 'Commission', 'HAC', 'Direction', 'SGG','Conseiller','ARPT','Ministre'];

        foreach($roles as $role) {
            DB::table('role')->insert([
                'nom' => $role,
                'uuid' => Str::uuid(),
            ]);
        }

    }
}
