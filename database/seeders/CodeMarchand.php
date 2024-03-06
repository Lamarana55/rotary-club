<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CodeMarchand extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['code' => "610913", "modePaiement" => "Orange Money", 'status' => 1],
            ['code' => "452390", "modePaiement" => "Mobile Money", 'status' => 1],
            ['code' => "563209", "modePaiement" => "Paiement Bancaire", 'status' => 1],

        ];
        foreach($types as $type){
            DB::table('code_marchands')->insert([
                'code' => $type['code'],
                'modePaiement' => $type['modePaiement'],
                'status' => $type['status']
            ]);
        }
    }
}
