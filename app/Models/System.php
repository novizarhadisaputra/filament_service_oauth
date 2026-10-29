<?php

namespace App\Models;

use App\Observers\SystemObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Class System
 *
 * Represents System database entity.
 *
 * @property mixed $name
 * @property mixed $slug
 * @property mixed $system_code
 * @property mixed $description
 * @property mixed $is_active
 * @property mixed $requires_2fa
 * @property mixed $is_internal
 * @property-read mixed $roles
 * @property-read mixed $users
 * @property-read mixed $clients
 */
#[ObservedBy(SystemObserver::class)]
class System extends Model
{
    use HasFactory, HasUuids;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'slug',
        'system_code',
        'description',
        'is_active',
        'requires_2fa',
        'is_internal',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'requires_2fa' => 'boolean',
            'is_internal' => 'boolean',
        ];
    }

    /**
     * Get the associated roles relationship.
     *
     * @return HasMany
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'team_id');
    }

    /**
     * Get the associated users relationship.
     *
     * @return BelongsTo
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('two_factor_enabled')
            ->withTimestamps();
    }

    /**
     * Get the associated clients relationship.
     *
     * @return MorphMany
     */
    public function clients(): MorphMany
    {
        return $this->morphMany(OAuthClient::class, 'owner');
    }
}
