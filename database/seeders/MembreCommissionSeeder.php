<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembreCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $membres = [
            ['fonction'=>'Président','fonction_occupe'=>'Secretaire General','full_name'=>'Président','category'=>'Commission'],
            ['fonction'=>'Rapporteur','fonction_occupe'=>'Directeur','full_name'=>'Rapporteur','category'=>'Commission'],
            ['fonction'=>'Membre', 'fonction_occupe'=>'Responsable','full_name'=>'Membre 1','category'=>'Commission'],
            ['fonction'=>'Membre', 'fonction_occupe'=>'Responsable','full_name'=>'Membre 2','category'=>'Commission'],
            ['fonction'=>'Membre', 'fonction_occupe'=>'Responsable','full_name'=>'Membre 3','category'=>'Commission'],
            ['fonction'=>'Membre', 'fonction_occupe'=>'Responsable','full_name'=>'Membre 4','category'=>'Commission'],
            ['fonction'=>'Membre', 'fonction_occupe'=>'Responsable','full_name'=>'Membre 5','category'=>'Commission'],
            ['fonction'=>'Président', 'fonction_occupe'=>'Fonction occupée','full_name'=>'Mariama DONZO','category'=>'HAC'],
            ['fonction'=>'Rapporteur', 'fonction_occupe'=>'Fonction occupée','full_name'=>'Ahmed Camille CAMARA','category'=>'HAC'],
            ['fonction'=>'Membre', 'fonction_occupe'=>'Responsable','full_name'=>'Membre 3','category'=>'HAC'],
            ['fonction'=>'Membre', 'fonction_occupe'=>'Responsable','full_name'=>'Membre 4','category'=>'HAC'],
            ['fonction'=>'Membre', 'fonction_occupe'=>'Responsable','full_name'=>'Membre 5','category'=>'HAC'],
        ];
        $commission = DB::table('user')->join('role','user.role_id','role.id')->where('role.nom','Commission')->select('user.*')->first();
        $hac = DB::table('user')->join('role','user.role_id','role.id')->where('role.nom','HAC')->select('user.*')->first();

        foreach($membres as $membre) {
            if($membre['fonction']=='Rapporteur'&& $membre['category']=='Commission')
            {
                DB::table('membre')->insert([
                    'full_name' => $membre['full_name'],
                    'fonction' => $membre['fonction'],
                    'category' => $membre['category'],
                    'fonction_occupe' => $membre['fonction_occupe'],
                    'user_id'=>$commission->id
                ]);
            }elseif($membre['fonction']=='Rapporteur'&& $membre['category']=='HAC'){
                DB::table('membre')->insert([
                    'full_name' => $membre['full_name'],
                    'fonction' => $membre['fonction'],
                    'category' => $membre['category'],
                    'fonction_occupe' => $membre['fonction_occupe'],
                    'user_id'=>$hac->id
                ]);
            }else{
                DB::table('membre')->insert([
                    'full_name' => $membre['full_name'],
                    'fonction' => $membre['fonction'],
                    'category' => $membre['category'],
                    'fonction_occupe' => $membre['fonction_occupe'],
                ]);
            }
        }

    }
}
