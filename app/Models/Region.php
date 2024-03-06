<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Region
 *
 * @property int $id
 * @property string $nom
 * @property string $slug
 * @property string $uuid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Prefecture[] $prefectures
 *
 * @package App\Models
 */
class Region extends Model
{
	protected $table = 'region';
	public static $snakeAttributes = false;

	protected $fillable = [
		'nom',
		'slug',
		'uuid'
	];

	public function prefectures()
	{
		return $this->hasMany(Prefecture::class);
	}

    function getOng()
    {
        return Ong::whereIn('commune_id', function ($query){
            $query->from("commune")->whereIn("prefecture_id", function ($query){
                $query->from("prefecture")->where('region_id', $this->id)->select('id')->get();
            })->select("id")->get();
        });
    }
}
