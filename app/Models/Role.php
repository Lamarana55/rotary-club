<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @property int $id
 * @property string $nom
 * @property bool|null $isAdmin
 * @property string|null $uuid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|RolePermission[] $role_permissions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Role extends Model
{
	protected $table = 'role';

	protected $casts = [
		'isAdmin' => 'bool'
	];

	protected $fillable = [
		'nom',
        'uuid',
		'isAdmin'
	];

	public function role_permissions()
	{
		return $this->hasMany(RolePermission::class);
	}

    public function permissions(){
        return $this->belongsToMany(Permission::class, "rolePermission", "role_id", "permission");
    }

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
