<?php
namespace App\Gestions;

use App\Models\{DelaisTraitement};


class GestionDelaisTraitement
{
    function save_delais_traitement($data){
        $delais = DelaisTraitement::find($data->delaisId);

        if($delais){
            DelaisTraitement::where('id',$data->delaisId)->update([
                'etape' => $data->etape,
                'delais'=> $data->delais,
                'unite' => $data->unite
            ]);
        }else{
            DelaisTraitement::create([
                'etape' => $data->etape,
                'delais'=> $data->delais,
                'unite' => $data->unite,
                'is_deleted' => false,
            ]);
        }
    }
}
