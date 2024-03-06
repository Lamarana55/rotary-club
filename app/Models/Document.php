<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Document
 *
 * @property int $id
 * @property string|null $nom
 * @property string|null $description
 * @property string $file_path
 * @property bool|null $is_validated_commission
 * @property bool|null $is_validated_hac
 * @property bool|null $comment_rejet_commission
 * @property bool|null $comment_rejet_hac
 * @property bool|null $is_deleted
 * @property string|null $categorie
 * @property int|null $media_id
 * @property int|null $document_type_promoteur_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property DocumentTypePromoteur|null $document_type_promoteur
 * @property Medium|null $medium
 *
 * @package App\Models
 */
class Document extends Model
{
	protected $table = 'document';

	protected $casts = [
		'is_validated_commission' => 'bool',
		'is_validated_hac' => 'bool',
		'comment_rejet_commission' => 'bool',
		'comment_rejet_hac' => 'bool',
		'is_deleted' => 'bool',
		'media_id' => 'int',
		'document_type_promoteur_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'description',
		'file_path',
		'is_validated_commission',
		'is_validated_hac',
		'comment_rejet_commission',
		'comment_rejet_hac',
		'is_deleted',
		'categorie',
		'media_id',
		'document_type_promoteur_id'
	];

	public function document_type_promoteur()
	{
		return $this->belongsTo(DocumentTypePromoteur::class);
	}

	public function media()
	{
		return $this->belongsTo(Media::class, 'media_id');
	}
}