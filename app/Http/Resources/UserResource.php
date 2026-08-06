<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->unsetRelation('roles');
        $this->unsetRelation('permissions');

        $teamId = getPermissionsTeamId();
        if ($teamId) {
            $roles = $this->roles()
                ->where(function ($q) use ($teamId) {
                    $q->where('roles.team_id', $teamId)
                      ->orWhereNull('roles.team_id');
                })
                ->pluck('name');
        } else {
            $roles = Role::whereIn(
                'id',
                DB::table(config('permission.table_names.model_has_roles'))
                    ->where('model_id', $this->id)
                    ->pluck('role_id')
            )->pluck('name');
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'metadata' => $this->metadata,
            'roles' => $roles,
            'permissions' => $this->getAllPermissions()->pluck('name'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
