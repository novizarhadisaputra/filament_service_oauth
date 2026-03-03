<?php

namespace App\Models;

use App\Observers\OAuthClientObserver;
use Database\Factories\OAuthClientFactory;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Passport\Client as PassportClient;

#[ObservedBy(OAuthClientObserver::class)]
class OAuthClient extends PassportClient
{
    /** @use HasFactory<OAuthClientFactory> */
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (Filament::getCurrentPanel() && Filament::getCurrentPanel()->getId() === 'app' && $tenant = Filament::getTenant()) {
                $builder->where('owner_id', $tenant->id);
            }
        });

        static::saving(function ($model) {
            unset($model->attributes['secret']);
            unset($model->attributes['redirect']);
        });
    }

    // Observer handles auto-generation of ID, client_id, and client_secret

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'grant_types' => 'array',
        'scopes' => 'array',
        'redirect_uris' => 'array',
        'personal_access_client' => 'bool',
        'password_client' => 'bool',
        'revoked' => 'bool',
    ];

    /**
     * Interact with the client's secret, mapping it to client_secret for Passport compatibility.
     */
    protected function secret(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn () => $this->client_secret,
            set: function (?string $value) {
                $this->plainSecret = $value;
                return [
                    'client_secret' => $this->castAttributeAsHashedString('client_secret', $value)
                ];
            }
        );
    }

    /**
     * Interact with the client's redirect URI, mapping it to redirect_uris for Passport compatibility.
     */
    protected function redirect(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn () => $this->redirect_uris ? (is_array($this->redirect_uris) ? implode(',', $this->redirect_uris) : $this->redirect_uris) : null,
            set: fn (?string $value) => [
                'redirect_uris' => json_encode(explode(',', $value))
            ]
        );
    }




    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return OAuthClientFactory::new();
    }

    protected $table = 'oauth_clients';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'client_id',
        'owner_id',
        'owner_type',
        'name',
        'client_secret',
        'provider',
        'redirect_uris',
        'grant_types',
        'revoked',
    ];

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class, 'owner_id');
    }

    /**
     * Determine if the client should skip the authorization prompt.
     *
     * @return bool
     */
    public function skipsAuthorization(Authenticatable $user, array $scopes): bool
    {
        return true;
    }

    /**
     * Determine if the client is a confidential client.
     */
    public function confidential(): bool
    {
        return ! empty($this->getAttributes()['client_secret'] ?? null);
    }
}
