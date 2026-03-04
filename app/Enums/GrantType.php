<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum GrantType: string implements HasLabel
{
    case AuthorizationCode = 'authorization_code';
    case ClientCredentials = 'client_credentials';
    case Password = 'password';
    case RefreshToken = 'refresh_token';
    case Implicit = 'implicit';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AuthorizationCode => 'Authorization Code',
            self::ClientCredentials => 'Client Credentials',
            self::Password => 'Password',
            self::RefreshToken => 'Refresh Token',
            self::Implicit => 'Implicit',
        };
    }
}
