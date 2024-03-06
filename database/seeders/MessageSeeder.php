<?php

namespace Database\Seeders;

use App\Models\Stepper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ["INFO", "EN COURS", "VALIDER", "REJETTER"];
        /* $etapes = [
            "Achat Cahier de charge (DAF)",
            "Commission Technique (MIC)",
            "Paiement Agrement (Promoteur)",
            "Transmission Agrément (DNCRMP)",
            "Enregistrement de l'agrément (SGG)",
            "Prise de RDV (Promoteur)",
            "Télécharger vos Documents"
        ]; */

        $messages = [
        ['level' => 1, 'type_message' => "INFO", 'message' => "Cher/Chère promoteur/trice votre média a été ajouté avec succès.
        Vous avez 48h pour effectuer le paiement du cahier des charges. Le montant du cahier des charges est de 2 000 000 GNF",
        ],
        ['level' => 1, 'type_message' => "EN COURS", 'message' => "Votre paiement est en cours de vérification à la division des affaires financières du ministère de l’information et de la communication"],
        ['level' => 1, 'type_message' => "VALIDER", 'message' => "Votre paiement a été validé"],
        ['level' => 1, 'type_message' => "REJETTER", 'message' => "Votre paiement a été rejeté"],
        ['level' => 2, 'type_message' => "INFO", 'message' => "Vos documents ont été soumis au comité en vue d'une étude."],
        ['level' => 2, 'type_message' => "EN COURS", 'message' => "Vos documents ont été soumis au comité en vue d'une étude."],
        ['level' => 2, 'type_message' => "VALIDER", 'message' => "Vos documents ont été validés."],
        ['level' => 2, 'type_message' => "REJETTER", 'message' => "Vos documents ont été rejetés."],
        ['level' => 3, 'type_message' => "INFO", 'message' => "Vos documents sont en cours d'études par la Haute Autorité de Communication (HAC)"],
        ['level' => 3, 'type_message' => "EN COURS", 'message' => "Vos documents sont en cours d'études par la Haute Autorité de Communication (HAC)"],
        ['level' => 3, 'type_message' => "VALIDER", 'message' => "Vos documents sont en cours d'études par la Haute Autorité de Communication (HAC)"],
        ['level' => 3, 'type_message' => "REJETTER", 'message' => "Vos documents ont été rejetés par la Haute Autorité de Communication (HAC)"],
        ['level' => 4, 'type_message' => "INFO", 'message' => ""],
        ];
        $etapes = Stepper::all();
        foreach ($etapes as $etape) {
            foreach ($types as $type) {
                if($type == "INFO"){

                }
                DB::table('message')->insert([
                    'stepper_id' => $etape->id,
                    'type_message' => $type,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'is_deleted' => false,
                    'message' => "Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer une mise en page, "
                ]);
            }
        }
    }
}
