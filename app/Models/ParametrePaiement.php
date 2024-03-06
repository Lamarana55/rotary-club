<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ParametrePaiement
 *
 * @property int $id
 * @property string|null $nom
 * @property float|null $montant
 * @property string|null $description
 * @property string|null $is_deleted
 * @property bool|null $is_cahier_charge
 * @property int|null $type_media_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property TypeMedia|null $type_media
 *
 * @package App\Models
 */
class ParametrePaiement extends Model
{
	protected $table = 'parametre_paiement';

	protected $casts = [
		'montant' => 'float',
		'is_cahier_charge' => 'bool',
		'type_media_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'montant',
		'description',
		'is_deleted',
		'is_cahier_charge',
		'type_media_id'
	];

	public function type_media()
	{
		return $this->belongsTo(TypeMedia::class);
	}
}
