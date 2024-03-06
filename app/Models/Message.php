<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * 
 * @property int $id
 * @property string|null $etape
 * @property string|null $message
 * @property string|null $icon
 * @property string|null $uuid
 * @property string|null $nom
 * @property string|null $type_message
 * @property bool|null $is_deleted
 * @property int|null $stepper_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Stepper|null $stepper
 *
 * @package App\Models
 */
class Message extends Model
{
	protected $table = 'message';

	protected $casts = [
		'is_deleted' => 'bool',
		'stepper_id' => 'int'
	];

	protected $fillable = [
		'etape',
		'message',
		'icon',
		'uuid',
		'nom',
		'type_message',
		'is_deleted',
		'stepper_id'
	];

	public function stepper()
	{
		return $this->belongsTo(Stepper::class);
	}
}
