<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Medium
 *
 * @property int $id
 * @property string|null $uuid
 * @property string $nom
 * @property string|null $telephone
 * @property string|null $email
 * @property string $forme_juridique
 * @property string|null $sigle
 * @property string|null $description
 * @property string $type
 * @property string $type_media
 * @property string|null $stape
 * @property string|null $current_stape
 * @property string|null $numero_registre_sgg
 * @property string|null $logo
 * @property int|null $user_id
 * @property bool $is_deleted
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User|null $user
 * @property Collection|Document[] $documents
 * @property Collection|Dossier[] $dossiers
 * @property Collection|GenerateAgreement[] $generate_agreements
 * @property Collection|Meeting[] $meetings
 * @property Collection|Membre[] $membres
 * @property Collection|MembreRapportMedia[] $membre_rapport_media
 * @property Collection|Notification[] $notifications
 * @property Collection|Paiement[] $paiements
 * @property Collection|Rapport[] $rapports
 * @property Collection|SendMail[] $send_mails
 * @property Collection|Tracking[] $trackings
 *
 * @package App\Models
 */
class Media extends Model
{
	protected $table = 'media';

	protected $casts = [
		'user_id' => 'int',
        'region_id' => 'int',
        'prefecture_id' => 'int',
        'commune_id'=> 'int',
		'is_deleted' => 'bool'
	];

	protected $fillable = [
		'uuid',
		'nom',
		'telephone',
        'type',
		'email',
		'forme_juridique',
		'sigle',
		'description',
		'type_media',
        'is_cahier_charge',
        'is_frais_agrement',
        'isvalide',
		'stape',
		'current_stape',
		'numero_registre_sgg',
		'logo',
		'user_id',
		'is_deleted',
        'en_cours',
        'en_attente',
        'traite',
        'agree',
        'en_cours_commission',
        'en_attente_commission',
        'traite_commission',
        'en_cours_hac',
        'en_attente_hac',
        'traite_hac',
        'date_create',
        'date_enregistrement_agrement',
        'region_id',
        'prefecture_id',
        'commune_id',
        'status_sgg',
        'status_arpt',
        'status_conseiller',
        'status_direction'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function documents()
	{
		return $this->hasMany(Document::class, 'media_id');
	}

	public function dossiers()
	{
		return $this->hasMany(Dossier::class, 'media_id');
	}

    public function dossier()
	{
		return $this->belongsTo(Dossier::class);
	}

    public function region()
	{
		return $this->belongsTo(Region::class);
	}

    public function prefecture()
	{
		return $this->belongsTo(Prefecture::class);
	}

    public function commune()
	{
		return $this->belongsTo(Commune::class);
	}


	public function generate_agreements()
	{
		return $this->hasMany(GenerateAgreement::class, 'media');
	}

	public function meetings()
	{
		return $this->hasMany(Meeting::class, 'media_id');
	}

    public function meeting()
	{
		return $this->hasOne(Meeting::class, 'media_id');
	}

	public function membres()
	{
		return $this->hasMany(Membre::class, 'media_id');
	}

	public function membre_rapport_media()
	{
		return $this->hasMany(MembreRapportMedia::class, 'media_id');
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class, 'media_id');
	}

	public function paiements()
	{
		return $this->hasMany(Paiement::class, 'media_id');
	}

	public function rapports()
	{
		return $this->hasMany(Rapport::class, 'media_id');
	}

	public function send_mails()
	{
		return $this->hasMany(SendMail::class, 'media');
	}

	public function trackings()
	{
		return $this->hasMany(Tracking::class, 'media_id');
	}

    public function hasDocumentRejeteCommission() {
		$hasDocumentRejete = false;
        foreach($this->documents as $document) {
            if($document->is_validated_commission === 0) {
                $hasDocumentRejete = true;
                break;
            }
        }

		return $hasDocumentRejete;
	}

    public function getRecuAgrement()
    {
        return $this->paiements()->where('type_paiement','fraisAgrement')->first();
    }

}
