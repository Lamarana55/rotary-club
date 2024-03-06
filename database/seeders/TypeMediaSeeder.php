<?php

namespace Database\Seeders;

use App\Models\CahierDeCharge;
use App\Models\TypeMedia;
use Faker\Core\File as CoreFile;
use File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = ['Commerciale', 'Communautaire'];
        $i = 1;
        foreach($types as $type) {
            $typeMedia = new TypeMedia();
            $typeMedia->nom = $type;
            $typeMedia->save();

            $cahierDeCharge = new CahierDeCharge();
            $cahierDeCharge->nom = "logos/docs".$i++.".pdf";
            $cahierDeCharge->isCurrent = true;
            $cahierDeCharge->type_media_id = $typeMedia->id;
            $cahierDeCharge->save();

        }
    }
}
