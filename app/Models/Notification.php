<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * @property int $id
 * @property string|null $objet
 * @property string|null $contenu
 * @property string|null $type_notification
 * @property string|null $is_deleted
 * @property int|null $media_id
 * @property int|null $sender_id
 * @property int|null $recever_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Medium|null $medium
 * @property User|null $user
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notification';

	protected $casts = [
		'media_id' => 'int',
		'sender_id' => 'int',
		'recever_id' => 'int'
	];

	protected $fillable = [
		'objet',
		'contenu',
        'isUpdate',
		'type_notification',
		'is_deleted',
		'media_id',
		'sender_id',
		'recever_id'
	];

	public function media()
	{
		return $this->belongsTo(Media::class, 'media_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'sender_id');
	}
}