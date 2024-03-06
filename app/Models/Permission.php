<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 *
 * @property int $id
 * @property string $nom
 * @property string|null $description
 * @property string|null $isDelete
 *
 * @property Collection|RolePermission[] $role_permissions
 *
 * @package App\Models
 */
class Permission extends Model
{
	protected $table = 'permission';
	public $timestamps = false;

	protected $fillable = [
		'nom',
		'description',
		'isDelete'
	];

	public function role_permissions()
	{
		return $this->hasMany(RolePermission::class);
	}

    public function role_permission()
	{
		return $this->hasOne(RolePermission::class, 'permission_id');
	}

    public function roles(){
        return $this->belongsToMany(Role::class, "rolePermission",  "role_id", "permission_id");
    }
}