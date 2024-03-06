<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DelaisTraitementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['etape' => 'validation du compte promoteur', 'delais' => 48, 'unite' => 'heure(s)'],
            ['etape' => 'création du media', 'delais' => 48, 'unite' => 'heure(s)'],
            ['etape' => 'paiement de cahier des charges', 'delais' => 48, 'unite' => 'heure(s)'],
            ['etape' => 'validation du paiement de cahier des charges', 'delais' => 24, 'unite' => 'heure(s)'],
            ['etape' => 'soumission des documents technique', 'delais' => 10, 'unite' => 'jour(s)'],
            ['etape' => 'étude des documents techniques a la commission', 'delais' => 72, 'unite' => 'heure(s)'],
            ['etape' => 'étude des documents techniques a la hac', 'delais' => 72, 'unite' => 'heure(s)'],
            ['etape' => 'paiement de frais d\'agrément', 'delais' => 48, 'unite' => 'heure(s)'],
            ['etape' => 'validation de frais d\'agrément', 'delais' => 48, 'unite' => 'heure(s)'],
            ['etape' => 'élaboration du projet d\'agrément', 'delais' => 48, 'unite' => 'heure(s)'],
            ['etape' => 'enregistrement du numéro de l\'agrément', 'delais' => 72, 'unite' => 'heure(s)'],
            ['etape' => 'prise de rendez-vous par le promoteur', 'delais' => 24, 'unite' => 'heure(s)'],
            ['etape' => 'confirmation de rendez-vous', 'delais' => 24, 'unite' => 'heure(s)'],
            ['etape' => 'signature de l\'agrément a la direction', 'delais' => 24, 'unite' => 'heure(s)'],
            ['etape' => 'importation de licence', 'delais' => 14, 'unite' => 'jour(s)'],
        ];

        foreach($types as $type) {
            DB::table('delais_traitement')->insert([
                'etape' => $type['etape'],
                'delais' => $type['delais'],
                'unite' => $type['unite'],
                'is_deleted' =>false,
                'created_at' =>Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}