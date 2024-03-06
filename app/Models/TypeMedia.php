<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypeMedia
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property string|null $is_deleted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|CahierDeCharge[] $cahier_de_charges
 * @property Collection|ParametrePaiement[] $parametre_paiements
 *
 * @package App\Models
 */
class TypeMedia extends Model
{
	protected $table = 'type_media';

	protected $fillable = [
		'nom',
		'description',
		'is_deleted'
	];

	public function cahier_de_charges()
	{
		return $this->hasMany(CahierDeCharge::class);
	}

	public function parametre_paiements()
	{
		return $this->hasMany(ParametrePaiement::class);
	}
}
