<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RolePermission
 *
 * @property int $id
 * @property int|null $role_id
 * @property int|null $permission_id
 *
 * @property Permission|null $permission
 * @property Role|null $role
 *
 * @package App\Models
 */
class RolePermission extends Model
{
	protected $table = 'rolePermission';
	public $timestamps = false;

	protected $casts = [
		'role_id' => 'int',
		'permission_id' => 'int'
	];

	protected $fillable = [
		'role_id',
		'permission_id',
        'permission'
	];

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}

	public function role()
	{
		return $this->belongsTo(Role::class);
	}

}
