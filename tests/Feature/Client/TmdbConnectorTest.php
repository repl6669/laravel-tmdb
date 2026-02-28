<?php

use Astrotomic\Tmdb\Client\DTO\Collection;
use Astrotomic\Tmdb\Client\DTO\Collections\MovieCollection;
use Astrotomic\Tmdb\Client\DTO\Collections\WatchProviderCollection;
use Astrotomic\Tmdb\Client\DTO\Movie;
use Astrotomic\Tmdb\Client\DTO\WatchProvider;
use Astrotomic\Tmdb\Facades\Tmdb;
use Saloon\Http\Faking\MockClient;

it('can retrieve collection details', function (): void {
    $collection = Tmdb::client()->collections()->getDetails(10);

    expect($collection)
        ->toBeInstanceOf(Collection::class)
        ->parts
        ->toBeInstanceOf(MovieCollection::class)
        ->each->toBeInstanceOf(Movie::class);
})->skip(fn () => MockClient::global()->isEmpty());

it('can retrieve all movie watch providers', function (): void {
    $watchProviders = Tmdb::client()->watchProviders()->getMovieProviders();

    expect($watchProviders)
        ->toBeInstanceOf(WatchProviderCollection::class)
        ->each->toBeInstanceOf(WatchProvider::class);
})->skip(fn () => MockClient::global()->isEmpty());

it('can retrieve all tv watch providers', function (): void {
    $watchProviders = Tmdb::client()->watchProviders()->getTvProviders();

    expect($watchProviders)
        ->toBeInstanceOf(WatchProviderCollection::class)
        ->each->toBeInstanceOf(WatchProvider::class);
})->skip(fn () => MockClient::global()->isEmpty());
