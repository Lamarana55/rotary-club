<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocumentTypePromoteur
 * 
 * @property int $id
 * @property int|null $document_technique_id
 * @property int|null $type_promoteur_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property DocumentTechnique|null $document_technique
 * @property TypePromoteur|null $type_promoteur
 * @property Collection|Document[] $documents
 *
 * @package App\Models
 */
class DocumentTypePromoteur extends Model
{
	protected $table = 'document_type_promoteur';

	protected $casts = [
		'document_technique_id' => 'int',
		'type_promoteur_id' => 'int'
	];

	protected $fillable = [
		'document_technique_id',
		'type_promoteur_id'
	];

	public function document_technique()
	{
		return $this->belongsTo(DocumentTechnique::class);
	}

	public function type_promoteur()
	{
		return $this->belongsTo(TypePromoteur::class);
	}

	public function documents()
	{
		return $this->hasMany(Document::class);
	}
}
