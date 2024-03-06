<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run(): void
    {
        $ministre = Role::whereNom("Ministre")->first();
        $admin = Role::whereNom("Admin")->first();
        $daf = Role::whereNom("DAF")->first();
        $hac = Role::whereNom("HAC")->first();
        $commission = Role::whereNom("Commission")->first();
        $direction = Role::whereNom("Direction")->first();
        $sgg = Role::whereNom("SGG")->first();
        $arpt = Role::whereNom("ARPT")->first();
        $promoteur = Role::whereNom("Promoteur")->first();
        $conseiller = Role::whereNom("Conseiller")->first();

        foreach (getPermissions() as $key => $value) {
            DB::table("permission")->insert([
                "nom"=>$key,
                "description"=>json_encode($value)
            ]);
            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $ministre ? $ministre->id:null,
                    "permission"=>$val
                ]);
            }

            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $admin ? $admin->id:null,
                    "permission"=>$val
                ]);
            }

        }

        foreach (getPermissionsDaf() as $key => $value) {
            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $daf ? $daf->id:null,
                    "permission"=>$val
                ]);
            }
        }

        foreach (getPermissionsHac() as $key => $value) {
            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $hac ? $hac->id:null,
                    "permission"=>$val
                ]);
            }
        }

        foreach (getPermissionsCommission() as $key => $value) {
            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $commission ? $commission->id:null,
                    "permission"=>$val
                ]);
            }
        }

        foreach (getPermissionsDirecteur() as $key => $value) {
            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $direction ? $direction->id:null,
                    "permission"=>$val
                ]);
            }
        }

        foreach (getPermissionsSgg() as $key => $value) {
            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $sgg ? $sgg->id:null,
                    "permission"=>$val
                ]);
            }
        }

        foreach (getPermissionsArpt() as $key => $value) {
            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $arpt ? $arpt->id:null,
                    "permission"=>$val
                ]);
            }
        }
        foreach (getPermissionsConseiller() as $key => $value) {
            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $conseiller ? $conseiller->id:null,
                    "permission"=>$val
                ]);
            }
        }
        foreach (getPermissionsPromoteur() as $key => $value) {
            //assignation de tout les permission au role Admin
            foreach ($value as $val) {
                DB::table("rolePermission")->insert([
                    'role_id' => $promoteur ? $promoteur->id:null,
                    "permission"=>$val
                ]);
            }
        }
    }
}

