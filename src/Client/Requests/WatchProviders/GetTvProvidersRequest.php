<?php

namespace Astrotomic\Tmdb\Client\Requests\WatchProviders;

use Astrotomic\Tmdb\Client\DTO\Collections\WatchProviderCollection;
use Astrotomic\Tmdb\Client\TmdbConnector;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;

/**
 * @link https://developers.themoviedb.org/3/watch-providers/get-tv-providers
 */
class GetTvProvidersRequest extends Request
{
    use CreatesDtoFromResponse;

    protected ?string $connector = TmdbConnector::class;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/watch/providers/tv';
    }

    protected function castToDto(Response $response): WatchProviderCollection
    {
        return WatchProviderCollection::fromArray(
            $response->json('results')
        );
    }
}
