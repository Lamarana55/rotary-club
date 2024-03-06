<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stepper
 * 
 * @property int $id
 * @property string $nom
 * @property int $level
 * @property string|null $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Message[] $messages
 *
 * @package App\Models
 */
class Stepper extends Model
{
	protected $table = 'stepper';

	protected $casts = [
		'level' => 'int'
	];

	protected $fillable = [
		'nom',
		'level',
		'description'
	];

	public function messages()
	{
		return $this->hasMany(Message::class);
	}
}
