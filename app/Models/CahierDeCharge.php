<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CahierDeCharge
 *
 * @property int $id
 * @property string|null $nom
 * @property bool $isCurrent
 * @property int|null $type_media_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property TypeMedia|null $type_media
 *
 * @package App\Models
 */
class CahierDeCharge extends Model
{
	protected $table = 'cahier_de_charge';

	protected $casts = [
		'isCurrent' => 'bool',
		'type_media_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'isCurrent',
		'type_media_id'
	];

	public function type_media()
	{
		return $this->belongsTo(TypeMedia::class);
	}
}
