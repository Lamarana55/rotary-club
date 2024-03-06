<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dossier
 *
 * @property int $id
 * @property string|null $status_hac
 * @property string|null $status_commission
 * @property int|null $media_id
 * @property int|null $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Medium|null $medium
 * @property User|null $user
 *
 * @package App\Models
 */
class Dossier extends Model
{
	protected $table = 'dossier';

	protected $casts = [
		'media_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'status_hac',
		'status_commission',
        'is_valided_commission',
        'is_valided_hac',
		'media_id',
		'user_id',
        'is_termine_commission',
        'is_termine_hac'
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
