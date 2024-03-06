<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CodeMarchand
 * 
 * @property int $id
 * @property string $code
 * @property string $status
 * @property string $modepaiement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CodeMarchand extends Model
{
	protected $table = 'code_marchands';

	protected $fillable = [
		'code',
		'status',
		'modepaiement'
	];
}
