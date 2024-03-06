<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentTechnique
 * 
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property bool|null $is_deleted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|DocumentTypePromoteur[] $document_type_promoteurs
 *
 * @package App\Models
 */
class DocumentTechnique extends Model
{
	protected $table = 'document_technique';

	protected $casts = [
		'is_deleted' => 'bool'
	];

	protected $fillable = [
		'nom',
		'description',
		'is_deleted'
	];

	public function document_type_promoteurs()
	{
		return $this->hasMany(DocumentTypePromoteur::class);
	}
}
