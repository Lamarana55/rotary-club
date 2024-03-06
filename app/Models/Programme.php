<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Programme
 *
 * @property int $id
 * @property string|null $uuid
 * @property bool $is_taken
 * @property Carbon|null $date
 * @property string|null $jour
 * @property int|null $heure_debut
 * @property int|null $heure_fin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Meeting[] $meetings
 *
 * @package App\Models
 */
class Programme extends Model
{
	protected $table = 'programme';

	protected $casts = [
		'is_taken' => 'bool',
		'date' => 'date',
		'heure_debut' => 'int',
		'heure_fin' => 'int'
	];

	protected $fillable = [
		'uuid',
		'is_taken',
		'date',
		'jour',
		'heure_debut',
		'heure_fin'
	];

	public function meetings()
	{
		return $this->hasMany(Meeting::class);
	}

    public function canDelete()
    {
        return !$this->meetings()->where("annuler", true)->orWhere("agrement_signer", true)->exists();
    }

    public function canNotUpdate()
    {
        return $this->meetings()->where("agrement_signer", false)->exists();
    }

    public static function getJours () {
		return ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
	}

	public static function getMois () {
		return ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet',
	'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
	}

	public function getFormatDateAttribute() {
		$format = $this->date->format('d') . " ";
		$format .= Programme::getMois()[((int)$this->date->format('m')) - 1] . " ";
		$format .= $this->date->format('Y à H:i');

        return $format;
	}

	public function getFormatDateAvecJourAttribute() {
		$format = Programme::getJours()[$this->date->formatLocalized('%u') - 1];
		$format .= " ".$this->date->format('d') . " ";
		$format .= Programme::getMois()[((int)$this->date->format('m')) - 1] . " ";
		$format .= $this->date->format('Y à H:i');

        return $format;
	}
}
