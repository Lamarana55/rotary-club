<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Prefecture
 *
 * @property int $id
 * @property string $nom
 * @property string $slug
 * @property string $uuid
 * @property int|null $region_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Region|null $region
 * @property Collection|Commune[] $communes
 * @property Collection|Ong[] $ongs
 *
 * @package App\Models
 */
class Prefecture extends Model
{
	protected $table = 'prefecture';
	public static $snakeAttributes = false;

	protected $casts = [
		'region_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'slug',
		'uuid',
		'region_id'
	];

	public function region()
	{
		return $this->belongsTo(Region::class);
	}

	public function communes()
	{
		return $this->hasMany(Commune::class);
	}

	public function ongs()
	{
		return $this->hasMany(Ong::class);
	}
}
