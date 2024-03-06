<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FormeJuridique
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property bool|null $is_deleted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class FormeJuridique extends Model
{
	protected $table = 'forme_juridique';

	protected $casts = [
		'is_deleted' => 'bool'
	];

	protected $fillable = [
		'nom',
		'description',
		'is_deleted'
	];
}
