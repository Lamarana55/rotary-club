<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DelaisTraitement
 * 
 * @property int $id
 * @property string|null $etape
 * @property string|null $delais
 * @property string|null $ordre
 * @property string|null $unite
 * @property bool|null $is_deleted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class DelaisTraitement extends Model
{
	protected $table = 'delais_traitement';

	protected $casts = [
		'is_deleted' => 'bool'
	];

	protected $fillable = [
		'etape',
		'delais',
		'ordre',
		'unite',
		'is_deleted'
	];
}
