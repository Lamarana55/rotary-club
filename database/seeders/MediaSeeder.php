<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Tracking;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        for($i = 2; $i < 17; $i++) {
            $faker = Faker::create();
            $media = new Media;
            $media->description = "Le lorem ipsum est, en imprimerie, une suite de mots sans signification utilisée à titre provisoire pour calibrer une mise en page, le texte définitif venant remplacer le faux-texte dès qu'il est prêt ou que la mise en page est achevée. Généralement, on utilise un texte en faux latin, le Lorem ipsum ou Lipsum.";
            $media->is_deleted =  false;
            $media->forme_juridique =  'Entreprise individuelle';
            $media->type_media =  'Radiodiffusion Commerciale';
            $media->uuid = Str::uuid();
            $media->nom =  ucfirst(strtolower($faker->word.''.$i));
            $media->email =  $faker->unique()->safeEmail();
            $media->telephone =  "62102".rand(1000,9999);
            $media->user_id = $i;
            $media->save();
            if ($i==2) {

                $i=7;

            }

        }

          for($j = 1; $j <= 10; $j++) {
            $trakin = new Tracking;
            $trakin->media_id = $j;
            $trakin->date_create_media = Carbon::now();
            $trakin->save();
        }
    }
}
