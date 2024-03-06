<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SentMail
 *
 * @property int $id
 * @property string|null $title
 * @property string $message
 * @property bool $is_sent
 * @property string|null $fichier
 * @property string|null $url
 * @property int|null $media
 * @property int|null $user
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Medium|null $medium
 *
 * @package App\Models
 */
class SentMail extends Model
{
	protected $table = 'send_mail';

	protected $casts = [
		'is_sent' => 'bool',
		'media' => 'int',
		'user' => 'int'
	];

	protected $fillable = [
		'title',
		'message',
		'is_sent',
		'fichier',
		'url',
		'media',
		'user'
	];

	public function media()
	{
		return $this->belongsTo(Media::class, 'media');
	}

	public function getUser()
	{
		return $this->belongsTo(User::class, 'user');
	}
}
