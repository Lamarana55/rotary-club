<?php
namespace App\Gestions;

use App\Models\Programme;
use Illuminate\Support\Str;


class GestionDisponibilite
{
    public function store($data)
	{

        if(($data->heure_fin < $data->heure_debut) OR ($data->heure_fin == $data->heure_debut)) {
            return response()->json([
                'status' => false,
                'message' => "Disponibilité invalide"
            ]);
        }

        $check = Programme::whereJour($data->jour)->where(function ($query) use ($data){
            $query->whereHeureDebut($data->heure_debut)->orWhere("heure_fin", $data->heure_fin);
        });

        if($check->exists()) {
            return response()->json([
                'status' => false,
                'message' => "Cette disponibilité existe déjà"
            ]);
        }

        $check = Programme::whereJour($data->jour);

        if($check->exists()) {
            $checks = $check->orderBy("heure_fin", "DESC")->get();

            //($data->heure_debut > $check->heure_debut AND $data->heure_debut < $check->heure_fin)

            foreach ($checks as $key => $check) {
                if(($check->heure_fin > $data->heure_debut)) {
                    return response()->json([
                        'status' => false,
                        'message' => "Cette disponibilité existe déjà {($check->heure_fin < $data->heure_debut} $key"
                    ]);
                }
            }
        }

        $programme = Programme::firstOrCreate([
            'jour' => $data->jour,
            'heure_debut' => $data->heure_debut,
            'heure_fin' => $data->heure_fin,
            'uuid' => (string) Str::uuid()
        ]);

        return response()->json([
            'status' => true,
            'programme' => $programme,
            'close' =>  true,
            'message' => "Le programme a été ajouté"
        ]);
	}

    public function update($data, $key)
	{

        $programme = Programme::whereUuid($key)->first();

        if(($data->heure_fin < $data->heure_debut)) {
            return response()->json([
                'status' => false,
                'message' => "Disponibilité invalide"
            ]);
        }

        $check = Programme::whereJour($data->jour)->where(function ($query) use ($data){
            $query->whereHeureDebut($data->heure_debut)->orWhere("heure_fin", $data->heure_fin);
        });

        if($check->exists() AND !$check->get()->contains($programme)) {
            return response()->json([
                'status' => false,
                'message' => "Cette disponibilité existe déjà"
            ]);
        }

        $programme->update([
            'jour' => $data->jour,
            'heure_debut' => $data->heure_debut,
            'heure_fin' => $data->heure_fin,
        ]);

        return response()->json([
            'status' => true,
            'programme' => $programme,
            'close' =>  true,
            'message' => "Disponibilité mise à jour avec succès"
        ]);

	}

    public function delete($key)
	{
		Programme::whereUuid($key)->delete();
		return response()->json([
            'status' => true
        ]);
	}
}
