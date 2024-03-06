<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Commune
 *
 * @property int $id
 * @property string $nom
 * @property string $slug
 * @property string $uuid
 * @property int|null $prefecture_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Prefecture|null $prefecture
 * @property Collection|Ong[] $ongs
 *
 * @package App\Models
 */
class Commune extends Model
{
	protected $table = 'commune';
	public static $snakeAttributes = false;

	protected $casts = [
		'prefecture_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'slug',
		'uuid',
		'prefecture_id'
	];

	public function prefecture()
	{
		return $this->belongsTo(Prefecture::class);
	}

	public function ongs()
	{
		return $this->belongsToMany(Ong::class, 'ong_commune');
	}
}
