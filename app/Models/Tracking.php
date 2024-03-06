<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Tracking
 *
 * @property int $id
 * @property string|null $date_create_media
 * @property string|null $date_achat_cahier
 * @property string|null $date_valide_cahier
 * @property string|null $date_soumis_pro
 * @property string|null $date_etude_commission
 * @property string|null $date_etude_hac
 * @property string|null $date_paiement_agrement
 * @property string|null $date_transmission_projet_agrement
 * @property string|null $date_enregistrement_media
 * @property string|null $date_prise_rdv
 * @property int|null $user_id
 * @property int|null $media_id
 * @property string|null $date_confirme_rdv
 * @property string|null $date_importer_agrement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Medium|null $medium
 * @property User|null $user
 *
 * @package App\Models
 */
class Tracking extends Model
{
	protected $table = 'tracking';

	protected $casts = [
		'user_id' => 'int',
		'media_id' => 'int'
	];

	protected $fillable = [
		'date_create_media',
        'date_create_promoteur',
        'date_create_valide_promoteur',
		'date_achat_cahier',
		'date_valide_cahier',
		'date_soumis_pro',
		'date_etude_commission',
		'date_etude_hac',
		'date_paiement_agrement',
		'date_transmission_projet_agrement',
		'date_enregistrement_media',
		'date_prise_rdv',
		'user_id',
		'media_id',
        'date_valide_paiement_agrement',
		'date_confirme_rdv',
        'date_licence',
		'date_importer_agrement'
	];

	public function media()
	{
		return $this->belongsTo(Media::class, 'media_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
