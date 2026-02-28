<?php

namespace Astrotomic\Tmdb\Client\Requests\Collections;

use Astrotomic\Tmdb\Client\DTO\Collection;
use Astrotomic\Tmdb\Client\TmdbConnector;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Http\Response;
use Saloon\Traits\Request\CreatesDtoFromResponse;

/**
 * @link https://developers.themoviedb.org/3/collections/get-collection-details
 */
class GetCollectionDetailsRequest extends Request
{
    use CreatesDtoFromResponse;

    protected ?string $connector = TmdbConnector::class;

    protected Method $method = Method::GET;

    public function __construct(protected int $collectionId) {}

    public function resolveEndpoint(): string
    {
        return "/collection/{$this->collectionId}";
    }

    protected function castToDto(Response $response): Collection
    {
        return Collection::fromArray($response->json());
    }
}
