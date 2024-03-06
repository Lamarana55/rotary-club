<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FormeJuridiqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $libelles = ["Entreprise individuelle", "Société Anonyme : SA", "Société à Responsabilité Limitée : SARL", "Groupement d'Intérêt Economique: GIE", "Société par Actions Simplifiées: SAS", "Succursale"];
        foreach ($libelles as $libelle) {
            DB::table('forme_juridique')->insert([
                'nom' => $libelle,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'is_deleted' => false,
                'description' => "Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer une mise en page, "

            ]);
        }
    }
}