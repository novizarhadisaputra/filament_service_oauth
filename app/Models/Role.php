<?php

namespace App\Models;

use App\Observers\RoleObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

#[ObservedBy(RoleObserver::class)]
class Role extends SpatieRole
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    public function system(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(System::class, 'team_id');
    }

    /**
     * Override syncPermissions to touch updated_at and trigger Eloquent model events.
     */
    public function syncPermissions(...$permissions): static
    {
        parent::syncPermissions(...$permissions);

        $this->unsetRelation('permissions');
        $this->touch();

        return $this;
    }
}
