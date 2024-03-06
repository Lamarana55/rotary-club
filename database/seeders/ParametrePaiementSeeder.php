<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParametrePaiementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $typesMedia = ['Radiodiffusion Commerciale', 'Radiodiffusion Communautaire', 'Télévision Commerciale', 'Télévision Communautaire'];
        $types = [
            ['libelle' => 'cahier_de_charge', 'montant' => 2000000, 'is_cahier_charge' => true, 'id_type_media' => null],
        ];
        $frais_agrement = [
            ['libelle' => 'frais_agrement', 'montant' => 2500000, 'is_cahier_charge' => false, 'type_media' => 'Radio'],
            ['libelle' => 'frais_agrement', 'montant' => 3500000, 'is_cahier_charge' => false, 'type_media' => 'Télévision'],
        ];
        $montant = 2500000;
        for($i = 0; $i < count($typesMedia); $i++) {
            array_push($types, [
                'nom' => $typesMedia[$i],
                'montant' => $montant,
                'is_cahier_charge' => false,
                'type_media_id' => $i + 1]);
        }
        foreach($types as $key=> $type) {
            DB::table('parametre_paiement')->insert([
                'nom' => "cahier_de_charge",
                'montant'=> $type['montant'],
                'is_cahier_charge' => $type['is_cahier_charge'],
                'type_media_id' => 1
            ]);
        }
        foreach($frais_agrement as $key=> $type) {
            DB::table('parametre_paiement')->insert([
                'nom' => "frais_agrement",
                'montant'=> $type['montant'],
                'is_cahier_charge' => $type['is_cahier_charge'],
                'type_media_id' => $type['type_media'],
            ]);
        }

    }
}
