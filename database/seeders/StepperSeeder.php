<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StepperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $steps = [
            "Achat Cahier de charge (DAF)",
            "Commission Technique (MIC)",
            "Avis Consultatif (HAC)",
            "Paiement Agrement (Promoteur)",
            "Transmission Agrément (DNCRMP)",
            "Enregistrement de l'agrément (SGG)",
            "Prise de RDV (Promoteur)",
            "Télécharger mes Documents",
            "Sommaire"
        ];

        foreach ($steps as $key=>$step) {
            DB::table('stepper')->insert([
                'nom' => $step,
                'level' => $key + 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'description' => $step
            ]);
        }
    }
}
