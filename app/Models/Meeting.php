<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Meeting
 *
 * @property int $id
 * @property string $nom
 * @property string|null $agrement
 * @property bool $annuler
 * @property int|null $user_id
 * @property string|null $date
 * @property string|null $heure
 * @property bool $confirmer
 * @property bool|null $agrement_signer
 * @property string|null $motif
 * @property int|null $media_id
 * @property int|null $programme_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Medium|null $medium
 * @property Programme|null $programme
 * @property User|null $user
 *
 * @package App\Models
 */
class Meeting extends Model
{
	protected $table = 'meeting';

	protected $casts = [
		'annuler' => 'bool',
		'user_id' => 'int',
		'confirmer' => 'bool',
		'agrement_signer' => 'bool',
		'media_id' => 'int',
		'programme_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'agrement',
		'annuler',
		'user_id',
		'date',
		'heure',
		'confirmer',
        'licence',
		'agrement_signer',
		'motif',
		'media_id',
		'programme_id'
	];

	public function media()
	{
		return $this->belongsTo(Media::class, 'media_id');
	}

	public function programme()
	{
		return $this->belongsTo(Programme::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
