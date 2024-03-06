<?php

namespace Database\Seeders;

use App\Models\DocumentTypePromoteur;
use App\Models\Stepper;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            RegionSeeder::class,
            CategoriePromoteurSeeder::class,
            UserSeeder::class,
            FormeJuridiqueSeeder::class,
            TypeDocumentSeeder::class,
            TypeMediaSeeder::class,
            // MediaSeeder::class,
            TypePaiementSeeder::class,
            ParametrePaiementSeeder::class,
            PermissionSeeder::class,
            StepperSeeder::class,
            MessageSeeder::class,
            CodeMarchand::class,
            TrakingSeeder::class,
            MembreCommissionSeeder::class,
            DelaisTraitementSeeder::class
        ]);




    }
}
