<?php

namespace Astrotomic\Tmdb\Client\Requests\WatchProviders;

use Astrotomic\Tmdb\Client\DTO\Collections\WatchProviderCollection;
use Astrotomic\Tmdb\Client\TmdbConnector;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;

/**
 * @link https://developers.themoviedb.org/3/watch-providers/get-movie-providers
 */
class GetMovieProvidersRequest extends Request
{
    use CreatesDtoFromResponse;

    protected ?string $connector = TmdbConnector::class;

    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/watch/providers/movie';
    }

    protected function castToDto(Response $response): WatchProviderCollection
    {
        return WatchProviderCollection::fromArray(
            $response->json('results')
        );
    }
}
