<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TypePromoteur
 * 
 * @property int $id
 * @property string $nom
 * @property bool|null $is_deleted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|DocumentTypePromoteur[] $document_type_promoteurs
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class TypePromoteur extends Model
{
	protected $table = 'type_promoteur';

	protected $casts = [
		'is_deleted' => 'bool'
	];

	protected $fillable = [
		'nom',
		'is_deleted'
	];

	public function document_type_promoteurs()
	{
		return $this->hasMany(DocumentTypePromoteur::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
