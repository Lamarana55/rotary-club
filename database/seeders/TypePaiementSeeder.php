<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypePaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['libelle' => 'Cahier de charges', 'iscahiercharge' => true, 'isagrement' => false],
            ['libelle' => 'Agrément', 'iscahiercharge' => false, 'isagrement' => true]
        ];
        foreach($types as $type) {
            DB::table('type_paiement')->insert([
                'nom' => $type['libelle'],
                'iscahiercharge' => $type['iscahiercharge'],
                'isagrement' => $type['isagrement']
            ]);
        }
    }
}