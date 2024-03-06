<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rapport
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $forme_juridique
 * @property string|null $capital_social
 * @property string|null $capital_montant
 * @property string|null $capital_unite
 * @property string|null $nombre_depart
 * @property string|null $nombre_part_value
 * @property string|null $pourcentage_investisseur_signe
 * @property string|null $pourcentage_investisseur_value
 * @property string|null $nombre_certificat
 * @property string|null $nombre_certificat_resident
 * @property string|null $nombre_certificat_casier_dirigeant
 * @property string|null $nombre_journaliste
 * @property string|null $nombre_diplome_technicien
 * @property string|null $categorie_chaine
 * @property string|null $public_cible
 * @property string|null $equipement_reception
 * @property string|null $equipement_studio
 * @property string|null $equipement_emission
 * @property string|null $programme_provenant_exterieur
 * @property string|null $programme_provenant_exterieur_value
 * @property string|null $production_interne_signe
 * @property string|null $production_interne_value
 * @property string|null $coproduction_signe
 * @property string|null $coproduction_value
 * @property string|null $echange_programme_signe
 * @property string|null $echange_programme_value
 * @property string|null $exigence_unite_nationale
 * @property string|null $capacite_financiere
 * @property string|null $capacite_financiere_interval
 * @property string|null $capacite_financier_personnalise
 * @property string|null $etat_financier
 * @property string|null $categorie_chaine_projet
 * @property string|null $orientation_chaine
 * @property string|null $conclusion
 * @property string|null $production_interne_label_value
 * @property string|null $programme_provenant_exterieur_label_value
 * @property string|null $coproduction_label_value
 * @property string|null $pourcentage_investisseur_label_value
 * @property string|null $echange_programme_label_value
 * @property Carbon|null $date_debut
 * @property string|null $heure_debut
 * @property Carbon|null $date_fin
 * @property string|null $heure_fin
 * @property int|null $nombre_present
 * @property string|null $type_commission
 * @property int|null $media_id
 *
 * @property Medium|null $medium
 *
 * @package App\Models
 */
class Rapport extends Model
{
	protected $table = 'rapport';

	protected $casts = [
		'date_debut' => 'date:Y-m-d',
		'date_fin' => 'date',
		'nombre_present' => 'int',
		'media_id' => 'int'
	];

	protected $fillable = [
		'forme_juridique',
		'capital_social',
		'capital_montant',
		'capital_unite',
		'nombre_depart',
		'nombre_part_value',
		'pourcentage_investisseur_signe',
		'pourcentage_investisseur_value',
		'nombre_certificat',
		'nombre_certificat_resident',
		'nombre_certificat_casier_dirigeant',
		'nombre_journaliste',
		'nombre_diplome_technicien',
		'categorie_chaine',
		'public_cible',
		'equipement_reception',
		'equipement_studio',
		'equipement_emission',
		'programme_provenant_exterieur',
		'programme_provenant_exterieur_value',
		'production_interne_signe',
		'production_interne_value',
		'coproduction_signe',
		'coproduction_value',
		'echange_programme_signe',
		'echange_programme_value',
		'exigence_unite_nationale',
		'capacite_financiere',
        'capacite_financiere_preuve',
		'capacite_financiere_interval',
		'capacite_financier_personnalise',
		'etat_financier',
		'categorie_chaine_projet',
		'orientation_chaine',
		'conclusion',
		'production_interne_label_value',
		'programme_provenant_exterieur_label_value',
		'coproduction_label_value',
		'pourcentage_investisseur_label_value',
		'echange_programme_label_value',
		'date_debut',
		'heure_debut',
		'date_fin',
		'heure_fin',
		'nombre_present',
		'type_commission',
		'media_id'
	];

	public function media()
	{
		return $this->belongsTo(Media::class, 'media_id');
	}
}
