<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriePromoteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ["Personne Physique", "Sociétés", "ONG", "Association", "Unions", "Université", "CRD"];
        foreach ($categories as $categorie) {
            DB::table('type_promoteur')->insert([
                'nom' => $categorie,
            ]);
        }

    }
}
