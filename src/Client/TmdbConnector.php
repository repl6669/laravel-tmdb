<?php

namespace Astrotomic\Tmdb\Client;

use Astrotomic\Tmdb\Client\Proxies\CollectionsProxy;
use Astrotomic\Tmdb\Client\Proxies\WatchProvidersProxy;
use Astrotomic\Tmdb\Client\Requests\WatchProviders\GetMovieProvidersRequest;
use Astrotomic\Tmdb\Facades\Tmdb;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use Saloon\Traits\Plugins\HasTimeout;

class TmdbConnector extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    use HasTimeout;

    protected array $requests = [
        GetMovieProvidersRequest::class,
    ];

    public function resolveBaseUrl(): string
    {
        return 'https://api.themoviedb.org/3';
    }

    public function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator(config('services.tmdb.token'));
    }

    public function defaultQuery(): array
    {
        return [
            'language' => Tmdb::language(),
            'region' => Tmdb::region(),
        ];
    }

    public function collections(): CollectionsProxy
    {
        return new CollectionsProxy($this);
    }

    public function watchProviders(): WatchProvidersProxy
    {
        return new WatchProvidersProxy($this);
    }
}
