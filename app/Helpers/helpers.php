<?php

use App\Models\DelaisTraitement;
use App\Models\Document;
use App\Models\Meeting;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\MembreRapportMedia;
use App\Models\RolePermission;
use App\Models\SendMail;
use App\Models\Tracking;
use Illuminate\Support\Facades\DB;

define("PAGELOGINS","login");
define("PAGEINSCRIPTION","register");
define("PAGECHANGERMOTDEPASSE","form_update_password");
define("PAGEMOTDEPASSEOUBLIER","verify");

define("PAGELISTE", "liste");
define("PAGEPERMISSION", "permission");
define("PAGECREATEFORM", "create");
define("PAGEEDITFORM", "edit");
define("PAGEDETAILFORM", "detail");
define("COMMISSION", "Commission");

define("DEFAULTPASSOWRD", "password");
define("NOMBRE_PAR_PAGE", 20);

define("PREVIEWCOMMISSION", false);

function mb_ucfirst($string, $encoding = 'UTF-8'){
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}

function getDayIndex($day)
{
    switch ($day) {
        case "Lundi":
            return 1;
        case "Mardi":
            return 2;
        case "Mercredi":
            return 3;
        case "Jeudi":
            return 4;
        case "Vendredi":
            return 5;
        case "Samedi":
            return 6;
        case "Dimanche":
            return 0;
        default:
            break;
    }
}

function hasMeeting($id){
    return Meeting::where('media_id',$id)->first();
}

function hasProjetAgrement($id){
    return Document::where('media_id',$id)->where('categorie','projet_agrement')->first();
}

const SUCCESS = "#5cb85c";
const DANGER = "#d9534f";
const message_alert ="Votre de délai de traitement (2) sur le média nom et type a expiré. Veuillez vous connecter pour faire le traitement.";
const message_alert2 ="Votre de délai de traitement (2) sur le média nom et type expire bientôt. Veuillez vous connecter pour faire le traitement.";


function getMessageAlert($data, $media){
    $msg = "Votre délai de traitement $data->delais $data->unite sur le média $media->nom $media->type $media->type_media  a expiré. Veuillez vous connecter pour faire le traitement.";
    return $msg;
}

function getMessageAlert2($data, $media){
    $msg = "Votre délai de traitement $data->delais $data->unite sur le média $media->nom $media->type $media->type_media a expiré. Veuillez vous connecter pour faire le traitement.";
    return $msg;
}

function userFullName(){
    return auth()->user()->prenom . " " . auth()->user()->nom;
}

function setMenuClass($route, $classe){
    $routeActuel = request()->route()->getName();

    if(contains($routeActuel, $route) ){
        return $classe;
    }
    return "";
}

function setMenuActive($route){
    $routeActuel = request()->route()->getName();

    if($routeActuel === $route ){
        return "active";
    }
    return "";
}

function contains($container, $contenu){
    return Str::contains($container, $contenu);
}

function getRolesName(){
    $rolesName = "";
    $i = 0;
    foreach(auth()->user()->roles as $role){
        $rolesName .= $role->nom;

        //
        if($i < sizeof(auth()->user()->roles) - 1 ){
            $rolesName .= ",";
        }

        $i++;

    }

    return $rolesName;

}

if (! function_exists('formatGNF')) {
    function formatGNF($value) {
        return number_format($value, 0, '.', ' ') . ' GNF';
    }
}



function dateFormat($date, $type = 'table'){
	if (empty($date)) {
		return "";
	}
 	switch ($type) {
 		case 'table':
 			return Carbon::parse($date)->locale('fr_FR')->isoFormat('LL');
 			break;
 		case 'mysql':
 			return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
 			break;
 		case 'mysql_time':
 			return Carbon::createFromFormat('d/m/Y H:i', $date)->format('Y-m-d H:i');
 			break;
 		case 'only_time':
 			return Carbon::createFromFormat('H:i', $date)->format(' H:i');
 			break;
 		case 'form':
 			return Carbon::parse($date)->format('d/m/Y');
 			break;
 		case 'isoFormat':
 			if (empty($date)) {
 				return trans("Jamais");
 			}
 			return Carbon::parse($date)->locale('fr_FR')->isoFormat('LLLL');
 			break;
 		case 'human':
 			return Carbon::parse($date)->diffForHumans();
 			break;
 		default:
 			return "";
 			break;
 	}
}

function convertBase64($path){
	$path = base_path($path);
	$type = pathinfo($path,PATHINFO_EXTENSION);
	$data = file_get_contents($path);
	$file = 'data:image/' . $type . ';base64,' . base64_encode($data);
	return $file;
}

function select($name,$options){

	$option = "<option>--Sélectionner--</option>";
	foreach( $options as $opt ){
		$option .= "<option value='".$opt."'>". $option."</option>";
	}
 	return "<select name='" . $name . "' class='form-control'>" . $option . "</option></select>";
}

function checkedMemberForRapport($membre_id,$media_id) {
	$membre_commission_rapport = MembreRapportMedia::where('membre_id',$membre_id)->where('media_id', $media_id)->first();
	if($membre_commission_rapport){
		return true;
	}
	return false;
}

function getPermissions()
{
    return [
        'Tableau de bord' => ['afficher_dashboard', 'afficher_stats_type_media', 'afficher_stats_type_promoteur', 'afficher_stats_paiement_cahier', 'afficher_stats_frais_agrement', 'afficher_stats_commission', 'afficher_stats_hac', 'afficher_stats_sgg', 'afficher_stats_arpt'],
        'Utilisateur' => ['afficher_utilisateur','créer_utilisateur', 'modifier_utilisateur', 'supprimer_utilisateur', 'activate_utilisateur','assignation_permission'],
        'Type-Document' => ['afficher_type_document','créer_type_document', 'modifier_type_document', 'supprimer_type_document'],
        'Type-Media' => ['afficher_type_media','créer_type_media', 'modifier_type_media', 'supprimer_type_media'],
        'Type-Paiement' => ['afficher_type_paiement','créer_type_paiement', 'modifier_type_paiement', 'supprimer_type_paiement'],
        'Cahier des charges' => ['afficher_cahier_charge','créer_cahier_charge', 'modifier_cahier_charge', 'supprimer_cahier_charge'],
        'Media' => ['afficher_media','mes_medias','créer_media', 'modifier_media', 'supprimer_media','enregistrer_numero_agrement','importer_licence','chronologie', 'processus'],
        'Paiement frais agrément' => ['valider_paiement_frais_agrement', 'rejeter_paiement_frais_agrement'],
        'Parametrage du montant' => ['afficher_montant_paiement','créer_montant_paiement', 'modifier_montant_paiement', 'supprimer_montant_paiement'],
        'Disponibilité' => ['afficher_disponibilite','créer_disponibilite', 'modifier_disponibilite', 'supprimer_disponibilite'],
        'Paiement Cahier des charges' => ['valider_paiement_cahier_charge', 'rejeter_paiement_cahier_charge'],
        'Examen du dossier' => ['afficher_document','valider_document', 'rejeter_document', 'editer_rapport', 'editer_projet_agrement'],
        'Code Marchand' => ['afficher_code_marchand','créer_code_marchand', 'modifier_code_marchand', 'supprimer_code_marchand'],
        'Membre' => ['afficher_membre','créer_membre', 'modifier_membre', 'supprimer_membre'],
        'Delais traitement' => ['afficher_delai_traitement','créer_delai_traitement', 'modifier_delai_traitement', 'supprimer_delai_traitement'],
        'Forme Juridique' => ['afficher_forme_juridique','créer_forme_juridique', 'modifier_forme_juridique', 'supprimer_forme_juridique'],
        'Region' => ['afficher_region','créer_region', 'modifier_region', 'supprimer_region'],
        'Prefecture' => ['afficher_prefecture','créer_prefecture', 'modifier_prefecture', 'supprimer_prefecture'],
        'Commune' => ['afficher_commune','créer_commune', 'modifier_commune', 'supprimer_commune'],
        'Message' => ['afficher_message','créer_message', 'modifier_message', 'supprimer_message'],
        'Rendez vous' => ['afficher_rendez_vous', 'valider_rendez_vous'],
        'Rôle' => ['afficher_role'],
        'Statistique' => ['afficher_statistique'],
        'Permission' => ['afficher_permission'],
    ];
}

function getPermissionsPromoteur()
{
    return [
        'Media' => ['mes_medias','créer_media', 'modifier_media','processus'],
    ];
}

function getPermissionsDaf()
{
    return [
        'Tableau de bord' => ['afficher_dashboard','afficher_stats_type_media', 'afficher_stats_type_promoteur', 'afficher_stats_type_promoteur', 'afficher_stats_paiement_cahier', 'afficher_stats_frais_agrement', 'afficher_stats_commission', 'afficher_stats_hac', 'afficher_stats_sgg', 'afficher_stats_arpt'],
        'Media' => ['afficher_media', 'mes_medias'],
        'Utilisateur' => ['afficher_utilisateur'],
        'Paiement Cahier des charges' => ['valider_paiement_cahier_charge', 'rejeter_paiement_cahier_charge'],
    ];
}

function getPermissionsCommission()
{
    return [
        'Tableau de bord' => ['afficher_dashboard', 'afficher_stats_type_media', 'afficher_stats_type_promoteur', 'afficher_stats_type_promoteur', 'afficher_stats_paiement_cahier', 'afficher_stats_frais_agrement', 'afficher_stats_commission', 'afficher_stats_hac', 'afficher_stats_sgg', 'afficher_stats_arpt'],
        'Examen du dossier' => ['afficher_document','valider_document', 'rejeter_document', 'editer_rapport'],
        'Utilisateur' => ['afficher_utilisateur'],
        'Media' => ['afficher_media', 'mes_medias'],
    ];
}

function getPermissionsHac()
{
    return [
        'Tableau de bord' => ['afficher_dashboard', 'afficher_stats_type_media', 'afficher_stats_type_promoteur', 'afficher_stats_type_promoteur', 'afficher_stats_paiement_cahier', 'afficher_stats_frais_agrement', 'afficher_stats_commission', 'afficher_stats_hac', 'afficher_stats_sgg', 'afficher_stats_arpt'],
        'Examen du dossier' => ['afficher_document','valider_document', 'rejeter_document', 'editer_rapport'],
        'Utilisateur' => ['afficher_utilisateur'],
        'Media' => ['afficher_media', 'mes_medias'],
    ];
}

function getPermissionsDirecteur()
{
    return [
        'Tableau de bord' => ['afficher_dashboard', 'afficher_stats_type_media', 'afficher_stats_type_promoteur', 'afficher_stats_type_promoteur', 'afficher_stats_paiement_cahier', 'afficher_stats_frais_agrement', 'afficher_stats_commission', 'afficher_stats_hac', 'afficher_stats_sgg', 'afficher_stats_arpt'],
        'Utilisateur' => ['afficher_utilisateur'],
        'Media' => ['afficher_media', 'mes_medias'],
        'Disponibilité' => ['afficher_disponibilite','créer_disponibilite', 'modifier_disponibilite', 'supprimer_disponibilite'],
        'Paiement frais agrément' => ['valider_paiement_frais_agrement', 'rejeter_paiement_frais_agrement'],
        'Rendez vous' => ['afficher_rendez_vous', 'valider_rendez_vous'],
    ];
}

function getPermissionsConseiller()
{
    return [
        'Tableau de bord' => ['afficher_dashboard', 'afficher_stats_type_media', 'afficher_stats_type_promoteur', 'afficher_stats_type_promoteur', 'afficher_stats_paiement_cahier', 'afficher_stats_frais_agrement', 'afficher_stats_commission', 'afficher_stats_hac', 'afficher_stats_sgg', 'afficher_stats_arpt'],
        'Examen du dossier' => ['editer_projet_agrement'],
        'Utilisateur' => ['afficher_utilisateur'],
        'Media' => ['mes_medias', 'afficher_media'],
    ];
}

function getPermissionsSgg()
{
    return [
        'Tableau de bord' => ['afficher_dashboard', 'afficher_stats_type_media', 'afficher_stats_type_promoteur', 'afficher_stats_type_promoteur', 'afficher_stats_paiement_cahier', 'afficher_stats_frais_agrement', 'afficher_stats_commission', 'afficher_stats_hac','afficher_stats_sgg', 'afficher_stats_arpt'],
        'Examen du dossier' => ['editer_projet_agrement'],
        'Utilisateur' => ['afficher_utilisateur'],
        'Media' => ['afficher_media','enregistrer_numero_agrement', 'mes_medias'],
    ];
}

function getPermissionsArpt()
{
    return [
        'Tableau de bord' => ['afficher_dashboard', 'afficher_stats_type_media', 'afficher_stats_type_promoteur', 'afficher_stats_type_promoteur', 'afficher_stats_paiement_cahier', 'afficher_stats_frais_agrement', 'afficher_stats_commission', 'afficher_stats_hac', 'afficher_stats_sgg', 'afficher_stats_arpt'],
        'Examen du dossier' => ['editer_projet_agrement'],
        'Utilisateur' => ['afficher_utilisateur'],
        'Media' => ['afficher_media','importer_licence', 'mes_medias'],
    ];
}





function delais($key){
    return DelaisTraitement::whereEtape($key)->first();
}

function suivu($etape,$date){
    $resultat = dateDiff(date("Y-m-d H:i:s"),$date);
    $suivu = DelaisTraitement::whereEtape($etape)->first();

    if($suivu && $suivu->unite=='jour(s)'){
        return $suivu->delais-$resultat['jour'].' '.$suivu->unite;
    }elseif($suivu && $suivu->unite=='heure(s)'){
        return $suivu->delais-$resultat['heure'].' '.$suivu->unite;
    }elseif($suivu && $suivu->unite=='mois'){
        return $suivu->delais-$resultat['mois'].' '.$suivu->unite;
    }

}

function getTemps($etape,$date){
    $resultat = dateDiff(date("Y-m-d H:i:s"),$date);
    $suivu = DelaisTraitement::whereEtape($etape)->first();

    if($suivu && $suivu->unite=='jour(s)'){
        return $resultat['jour'];
    }elseif($suivu && $suivu->unite=='heure(s)'){
        return $resultat['heure'];
    }elseif($suivu && $suivu->unite=='mois'){
        return $resultat['mois'];
    }
}

function convertionDelais($delaiRest,$etape){
    $suivu = DelaisTraitement::whereEtape($etape)->first();
    if($suivu && $suivu->unite=='jour(s)'){
        $delai1 = $suivu->delais*86400;
        $delai2 = $delaiRest*86400;
        return floor($delai2*100/$delai1).'%';
    }elseif($suivu && $suivu->unite=='heure(s)'){
        $delai1 = $suivu->delais*3600;
        $delai2 = $delaiRest*3600;
        return floor($delai2*100/$delai1).'%';
    }elseif($suivu && $suivu->unite=='mois'){
        $delai1 = $suivu->delais*2629184;
        $delai2 = $delaiRest*2629184;
        return floor($delai2*100/$delai1).'%';
    }
}

// function delaisUilise($fin,$debut,$etape){
//     $suivu = DelaisTraitement::whereEtape($etape)->first();
//     if($suivu && $suivu->unite=='jour(s)'){
//         return $suivu->delais-dateDiff($fin,$debut)['jour'].' jour(s)';
//     }elseif($suivu && $suivu->unite=='heure(s)'){
//         return $suivu->delais-dateDiff($fin,$debut)['heure'].' heure(s)';
//     }elseif($suivu && $suivu->unite=='mois'){
//         return $suivu->delais-dateDiff($fin,$debut)['mois'].' mois';
//     }
// }

function delaisUilise($fin,$debut,$etape){
    $suivu = DelaisTraitement::whereEtape($etape)->first();
    if($suivu && $suivu->unite=='jour(s)'){
        return dateDiff($fin,$debut)['jour'].' jour(s)';
    }elseif($suivu && $suivu->unite=='heure(s)'){
        return dateDiff($fin,$debut)['heure'].' heure(s)';
    }elseif($suivu && $suivu->unite=='mois'){
        return dateDiff($fin,$debut)['mois'].' mois';
    }
}

function delaisUilise2($fin,$debut,$etape){
    $suivu = DelaisTraitement::whereEtape($etape)->first();
    if($suivu && $suivu->unite=='jour(s)'){
        return $suivu->delais-intval(dateDiff($fin,$debut)['jour']);
    }elseif($suivu && $suivu->unite=='heure(s)'){
        return $suivu->delais-intval(dateDiff($fin,$debut)['heure']);
    }elseif($suivu && $suivu->unite=='mois'){
        return $suivu->delais-intval(dateDiff($fin,$debut)['mois']);
    }
}

function isSendMailToUser($user,$media,$objet){
    return SendMail::where('media',$media)->where('is_sent',false)->where('user',$user)->where('message',$objet)->first();
}

function pourcentage($delaiRest,$delai){
    return $delaiRest*100/$delai;
}

function traking($key){
    return Tracking::where('media_id',$key)->first();
}

function hasPermission($key){
    $isPermission=false;

    $permissions = RolePermission::where('role_id',auth()->user()->role_id)->where('permission',$key)->first();
    if($permissions){
        $isPermission=true;
    }
    return $isPermission;
}


function itemsRapports(){
	return [
			[
				"parametre"=>"Forme juridique",
				"valeur"=>["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=>"Capital social",
				"valeur"=>["Illimité","Limité"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre" => "Nombre de part",
				"valeur" => ["Illimité","Limité"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Pourcentage réservé aux investisseurs locaux",
				"valeur"=> ["≥ 60%)"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Nombre de Certificat de nationalités des principaux dirigeants",
				"valeur"=> ["(1 à 3)"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Nombre de Certificat de résidence des principaux dirigeants",
				"valeur"=> ["(1 à 3)"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
					"parametre"=> "Nombre de casiers judiciaires des principaux dirigeants",
					"valeur"=> ["(1 à 3)"],
					"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Nombre de diplôme des journalistes qualifiés",
				"valeur"=> ["3"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Nombre de diplôme detechniciens professionnels",
				"valeur"=> ["2"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Catégorie de la chaine",
				"valeur"=> ["Commerciale" ,"Communautaire"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Orientation de la chaine",
				"valeur"=> ["Généraliste" ,"Thématique"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Public cible",
				"valeur"=> ["Au choix"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Équipements de réception",
				"valeur"=> ["Hybride", "Numérique"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Équipement de studio",
				"valeur"=> ["Analogique", "Hybride" ,"Numérique"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Équipement démission",
				"valeur"=> ["500-1000 Watts"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Part reservce aux programmes provenant de l'extérieur",
				"valeur"=> ["<=10%"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Productions internes",
				"valeur"=> [">=60%"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Coproductions",
				"valeur"=> ["<30%"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Échanges de programmes",
				"valeur"=> ["<10%"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Respect des exigences de l'unité nationale et l'ordre public",
				"valeur"=>["OUI", "NON"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=> "Capacités financières",
				"valeur"=> ["Radio/illimité (en millions GNF)", "Télévision /4 milliards GNF", "Relevé de compte", "Attestation bancaire"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			],
			[
				"parametre"=>"Etats financiers prévisionnels",
				"valeur"=> ["Plan d'investissement initial", "Compte d'exploitation", "Amortissement sur 3ans", "Grilles tarifaires proposées"],
				"input" => select('forme_juridique',["Personne physique", "Personne morale, Société", "Personne Morale, ONG, Commmunaute,Association"])
			]
		];
}

function dateDiff($date1, $date2){
    $diff = abs(strtotime($date1) - strtotime($date2)); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative
    $retour = array();

    $tmp = $diff;
    $retour['seconde'] = $tmp % 60;

    $tmp = floor(($tmp - $retour['seconde']) /60 );
    $retour['minute'] = $tmp % 60;

    $tmp = floor(($tmp - $retour['minute'])/60 );
    $retour['heure'] = $tmp % 24;

    $tmp = floor(($tmp - $retour['heure'])  /24 );
    $retour['jour'] = $tmp;

    $tmp = floor(($tmp - $retour['jour'] *12 / 365));
    $retour['mois'] = $tmp;
    // Nombre de jours * 12 mois / 365 jours = Nombre de mois
    return $retour;
}

function getProgramme($media,$id,$date)
{
    return Meeting::where('media_id',$media)->where('programme_id',$id)->where('date',$date)->first();

}

function checkPermission($role,$permission){
    return DB::table('rolePermission')->where('role_id',$role)->where('permission',$permission)->first();
}