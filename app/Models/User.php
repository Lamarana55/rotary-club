<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $telephone
 * @property string $email
 * @property string|null $photo
 * @property string|null $adresse
 * @property string|null $uuid
 * @property bool|null $is_deleted
 * @property bool $isvalide
 * @property string $valide_compte
 * @property string|null $profession
 * @property string|null $quartier
 * @property string|null $commune
 * @property string $genre
 * @property string $password
 * @property Carbon|null $email_verified_at
 * @property int|null $role_id
 * @property int|null $type_promoteur_id
 * @property string|null $token_update_password
 * @property string|null $date_validated_token_password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Role|null $role
 * @property TypePromoteur|null $type_promoteur
 * @property Collection|Dossier[] $dossiers
 * @property Collection|Media[] $media
 * @property Collection|Meeting[] $meetings
 * @property Collection|Membre[] $membres
 * @property Collection|Notification[] $notifications
 * @property Collection|SendMail[] $send_mails
 * @property Collection|Tracking[] $trackings
 *
 * @package App\Models
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

	protected $table = 'user';

	protected $casts = [
		'is_deleted' => 'bool',
		'isvalide' => 'bool',
		'email_verified_at' => 'date',
		'role_id' => 'int',
		'type_promoteur_id' => 'int'
	];

	protected $hidden = [
		'password',
		'token_update_password',
		'date_validated_token_password',
		'remember_token'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'telephone',
		'email',
		'photo',
		'adresse',
		'uuid',
		'is_deleted',
		'isvalide',
		'valide_compte',
		'profession',
		'quartier',
		'commune',
		'genre',
		'password',
		'email_verified_at',
		'role_id',
		'type_promoteur_id',
		'token_update_password',
		'date_validated_token_password',
		'remember_token'
	];

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

	public function type_promoteur()
	{
		return $this->belongsTo(TypePromoteur::class);
	}

	public function dossiers()
	{
		return $this->hasMany(Dossier::class);
	}

	public function media()
	{
		return $this->hasMany(Media::class);
	}

	public function meetings()
	{
		return $this->hasMany(Meeting::class);
	}

	public function membres()
	{
		return $this->hasMany(Membre::class);
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class, 'sender_id');
	}

	public function send_mails()
	{
		return $this->hasMany(SendMail::class, 'user');
	}

	public function trackings()
	{
		return $this->hasMany(Tracking::class);
	}
}