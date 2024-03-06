<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['Admin', 'Promoteur', 'DAF','Commission', 'HAC', 'Direction', 'SGG','Conseiller','ARPT','Ministre'];

         for($i = 0; $i < count($roles); $i++) {
            if($roles[$i]!= 'Promoteur'){
                DB::table('user')->insert([
                    'nom' => $roles[$i],
                    'uuid'=>Str::uuid(),
                    'prenom' => strtolower($roles[$i]),
                    'telephone' => '62200000'. $i,
                    'photo' => '1676389331.jpg',
                    'role_id' => $i + 1,
                    'is_deleted' => false,
                    'genre' => 'Masculin',
                    'email' => strtolower($roles[$i]).'@gama.mic.gov.gn',
                    'password' => Hash::make('1234'),
                    'type_promoteur_id' => $roles[$i] === 'Promoteur' ? 1 : null
                ]);
            }
        }
    }
}