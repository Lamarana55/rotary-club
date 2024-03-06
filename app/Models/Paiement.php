<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Paiement
 *
 * @property int $id
 * @property string|null $nom
 * @property float|null $montant
 * @property string|null $description
 * @property string $mode
 * @property string|null $telephone
 * @property string|null $recu
 * @property string|null $recu_genere
 * @property bool|null $is_valided
 * @property string|null $type_paiement
 * @property string|null $date_paiement
 * @property string|null $commentaire_reject
 * @property string|null $numero_recu_bank
 * @property string|null $is_deleted
 * @property string|null $code_marchant
 * @property int|null $media_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Medium|null $medium
 *
 * @package App\Models
 */
class Paiement extends Model
{
	protected $table = 'paiement';

	protected $casts = [
		'montant' => 'float',
		'is_valided' => 'bool',
		'media_id' => 'int'
	];

	protected $fillable = [
		'montant',
		'description',
		'mode',
		'telephone',
		'recu',
		'recu_genere',
		'is_valided',
		'type_paiement',
		'date_paiement',
		'commentaire_reject',
		'numero_recu_bank',
		'is_deleted',
		'code_marchant',
		'media_id'
	];

	public function media()
	{
		return $this->belongsTo(Media::class, 'media_id');
	}
}