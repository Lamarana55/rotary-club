<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $types = [
            /* ['id' =>1, 'libelle' => "Reçu","description" => "Reçu", "is_document_technique" => false], */
            //personne physique

            ['id' =>1, 'libelle' => "Copie pièce d'identité", "description" => "Copie pièce d'identité","is_document_technique" => true],
            ['id' =>2, 'libelle' => "Certificat de résidence daté de moins de trois (3) mois", "description" => "Certificat de résidence daté de moins de trois (3) mois","is_document_technique" => true],
            ['id' =>3, 'libelle' => "Extrait de casier judiciaire daté de moins de trois (3) mois","description" => "Extrait de casier judiciaire daté de moins de trois (3) mois", "is_document_technique" => true],
            ['id' =>4, 'libelle' => "Copie du diplôme certifié de trois (3) journalistes", "description" => "Copie du diplôme certifié de trois (3) journalistes", "is_document_technique" => true],
            ['id' =>5, 'libelle' => "Copie du diplôme de deux (2) techniciens professionnels, spécialites du type de la station","description" => "Copie du diplôme certifié de deux (2) techniciens professionnels, spécialites du type de la station", "is_document_technique" => true],

            //société
            ['id' =>6, 'libelle' => "Statut de la société","description" => "Statut de la société", "is_document_technique" => true],
            ['id' =>7, 'libelle' => "Montant capital social et nombre d'action ou parts sociales","description" => "Montant capital social et nombre d'action ou parts sociales", "is_document_technique" => true],
            ['id' =>8, 'libelle' => "Pourcentage du capital éventuellement réservé aux investisseurs nationaux","description" => "Pourcentage du capital éventuellement réservé aux investisseurs nationaux", "is_document_technique" => true],
            ['id' =>9, 'libelle' => "certificat de nationalité guinéenne des principaux dirigeants", "description" => "certificat de nationalité guinéenne des principaux dirigeants", "is_document_technique" => true],
            ['id' =>10, 'libelle' => "Extrait de casier judiciaire des principaux dirigeants daté de moins de trois (3) mois", "description" => "Extrait de casier judiciaire des principaux dirigeants daté de moins de trois (3) mois", "is_document_technique" => true],

            //ONG

            ['id' =>11, 'libelle' => "Extrait de casier judiciaire des principaux dirigeants", "description" => "Extrait de casier judiciaire des principaux dirigeants", "is_document_technique" => true],
            ['id' =>12, 'libelle' => "Certificat de résidence daté de moins de trois (3) mois des principaux dirigeants","description" => "Certificat de résidence daté de moins de trois (3) mois des principaux dirigeants", "is_document_technique" => true],
            ['id' =>13, 'libelle' => "Copie de diplôme journaliste", "description" => "Copie de diplôme journaliste", "is_document_technique" => true],
            ['id' =>14, 'libelle' => "Copie diplôme techniciens professionnels, spécialites du type de la station", "description" => "Copie diplôme techniciens professionnels, spécialites du type de la station", "is_document_technique" => true],

            //Tout le monde
            ['id' =>15, 'libelle' => "Equutl1','resuipements et normes techniques", "is_document_technique" => true,
             "description" => "équipements de réception de la chaîne;<br>
             équipements de studios et de régie;<br>
             équipements et normes techniques pour les radios et TV Web;<br>
             équipements d'émission et de diffusion (puissance des émetteurs et zones de couverture);<br>
             équipements de réception des usagers;<br>
             normes de production et évolutions envisagées;<br>
             sites envisagés pour l'implantation de l'émetteur;<br>
             l'installation de la station (Studio de production et de diffusion, des bureaux, etc.).<br>
             Les équipements techniques doivent être homologués par le Ministère en charge des Télécommunications, avant toute utilisation."],
            ['id' =>16, 'libelle' => "Objectifs du promoteurs", "is_document_technique" => true,
             "description" => "catégorie de la chaîne (commerciale ou communautaire);<br>
            orientation générale (généraliste et/ou thématique);<br>
            public cible;<br>
            stratégie commerciale;<br>
            audience escomptée."],
            ['id' =>17, 'libelle' => "Equipements et normes techniques", "is_document_technique" => true,
             "description" => "équipements de réception de la chaîne;<br>
             équipements de studios et de régie;<br>
             équipements et normes techniques pour les radios et TV Web;<br>
             équipements d'émission et de diffusion (puissance des émetteurs et zones de couverture);<br>
             équipements de réception des usagers;<br>
             normes de production et évolutions envisagées;<br>
             sites envisagés pour l'implantation de l'émetteur;<br>
             l'installation de la station (Studio de production et de diffusion, des bureaux, etc.).<br>
             Les équipements techniques doivent être homologués par le Ministère en charge des Télécommunications, avant toute utilisation."],

             ['id' =>18, 'libelle' => "Programmation", "is_document_technique" => true,
             "description" => "La grille des programmes et les évolutions éventuelles envisagées seront explicitées en faisant ressortir :<br>
             -la part réservée à la diffusion de programmes provenant de l'étranger, d'une part, et de programmes consacrés à l'Afrique, en général, et à la République de Guinée, en particulier, d'autre part;<br>
             la part en pourcentage des productions internes, de co-production, des échanges de programmes et d'achat de programmes <br><br>

             Réagir <br>

             Répondre <br>

             22 h 19 <br>
             la pait réservée aux programmes spéciaux, relatifs à la protection des couches vulnérables et aux téléthons.<br>
             Ces programmes doivent respecter les exigences de l'unité nationale, de l'ordre public et la préservation de notre identité culturelle"],

             ['id' =>19, 'libelle' => "Une surface financiere requise", "is_document_technique" => true,
             "description" => "On entend par « surface financière requise », le montant du financement complet de toutes les immobilisations, équipements techniques et d'autres rentrant dans le cadre de la création, de l'implantation et de l'exploitation d'une station de :<br>
             Radiodiffusion privée (Communautaire ou Commerciale);<br>
             Télévision privée (Communautaire ou Commerciale);<br>
             En tout état de cause, le montant de la « surface financière requise » pour une télévision privée (commerciale ou communautaire) ne doit pas être inférieure à la somme de quatre milliards de francs guinéens (4.000.000.000 GNF).<br>
             Aussi, le prix des Cahiers des charges est fixé à deux millions de francs gainéens
             (2.000.000 GNF). <br>
             En plus des pièces citées plus haut, toute demande d'autorisation, d'implantation et d'exploitation d'une Télévision privée doit comporter obligatoirement tous les documents relatifs aux engagements, protocoles et conventions de financement.<br>
             Ces financements doivent provenir du fonds propre, d'organismes autorisées ou d'établissements financiers de premier ordre"],

             ['id' =>20, 'libelle' => "Projections financieres", "is_document_technique" => true,
             "description" => "Les projections financières doivent être établies pour une période d'exploitation d'au moins trois (3) ans.<br>
             Elles doivent comporter <br>
             les modalités et conditions envisagées pour financer les investissements de l'entreprise; <br>
             . le plan de l'amortissement des investissements de la station; <br>
             -les tarifs d'accès aux apparcils de décodage et les tayifs d'abonnement pour les services cryptés"]

            ];


        foreach($types as $type){
            DB::table('document_technique')->insert([
            'nom' => $type['libelle'],
            'description' => $type['description'],
            'is_deleted'=>false,
            'created_at'=>Carbon::now()
        ]);
        }

    //Personne physique
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 1, 'document_technique_id' => 1,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 1, 'document_technique_id' => 2,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 1, 'document_technique_id' => 3,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 1, 'document_technique_id' => 4,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 1, 'document_technique_id' => 5,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 1, 'document_technique_id' => 6,'created_at'=>Carbon::now()
    ]);

    //Societe
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 2, 'document_technique_id' => 7,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 2, 'document_technique_id' => 8,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 2, 'document_technique_id' => 9,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 2, 'document_technique_id' => 10,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 2, 'document_technique_id' => 11,'created_at'=>Carbon::now()
    ]);

    //ONG
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 3, 'document_technique_id' => 12,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 3, 'document_technique_id' => 13,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 3, 'document_technique_id' => 14,'created_at'=>Carbon::now()
    ]);
    DB::table('document_type_promoteur')->insert(['type_promoteur_id' => 3, 'document_technique_id' => 15,'created_at'=>Carbon::now()
    ]);

    for ($i=16; $i < 21; $i++) {
        $a = 1;
            while ($a <= 7) {
                DB::table('document_type_promoteur')->insert(['type_promoteur_id' => $a, 'document_technique_id' => $i,'created_at'=>Carbon::now()
            ]);
            $a++;
            }
    }

    }
}
