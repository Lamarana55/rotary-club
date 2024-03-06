<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GenerateAgreement
 *
 * @property int $id
 * @property string $document
 * @property int|null $media
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Medium|null $medium
 *
 * @package App\Models
 */
class GenerateAgreement extends Model
{
	protected $table = 'generate_agreements';

	protected $casts = [
		'media' => 'int'
	];

	protected $fillable = [
		'document',
		'media',
        'nomMinistre',
        'genreMinistre',
        'projet_agrement'
	];

	public function media()
	{
		return $this->belongsTo(Media::class, 'media');
	}
}
