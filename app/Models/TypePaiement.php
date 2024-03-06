<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypePaiement
 * 
 * @property int $id
 * @property string $nom
 * @property bool $iscahiercharge
 * @property bool $isagrement
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class TypePaiement extends Model
{
	protected $table = 'type_paiement';

	protected $casts = [
		'iscahiercharge' => 'bool',
		'isagrement' => 'bool'
	];

	protected $fillable = [
		'nom',
		'iscahiercharge',
		'isagrement'
	];
}
