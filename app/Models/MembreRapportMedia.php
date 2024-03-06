<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MembreRapportMedia
 *
 * @property int $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $membre_id
 * @property int|null $media_id
 * @property string|null $category
 *
 * @property Medium|null $medium
 * @property Membre|null $membre
 *
 * @package App\Models
 */
class MembreRapportMedia extends Model
{
	protected $table = 'membre_rapport_media';

	protected $casts = [
		'membre_id' => 'int',
		'media_id' => 'int'
	];

	protected $fillable = [
		'membre_id',
		'media_id',
		'category'
	];

	public function media()
	{
		return $this->belongsTo(Media::class, 'media_id');
	}

	public function membre()
	{
		return $this->belongsTo(Membre::class);
	}
}