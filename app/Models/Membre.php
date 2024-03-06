<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Membre
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $fonction_occupe
 * @property string|null $full_name
 * @property string|null $fonction
 * @property string|null $category
 * @property int|null $user_id
 * @property int|null $media_id
 *
 * @property Medium|null $medium
 * @property User|null $user
 * @property Collection|MembreRapportMedia[] $membre_rapport_media
 *
 * @package App\Models
 */
class Membre extends Model
{
	protected $table = 'membre';

	protected $casts = [
		'user_id' => 'int',
		'media_id' => 'int'
	];

	protected $fillable = [
		'fonction_occupe',
		'full_name',
		'fonction',
		'category',
		'user_id',
		'media_id'
	];

	public function media()
	{
		return $this->belongsTo(Media::class, 'media_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function membre_rapport_media()
	{
		return $this->hasMany(MembreRapportMedia::class);
	}
}