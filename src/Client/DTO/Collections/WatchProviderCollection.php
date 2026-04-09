<?php

namespace Astrotomic\Tmdb\Client\DTO\Collections;

use Astrotomic\Tmdb\Client\DTO\WatchProvider;
use Illuminate\Support\Collection;

class WatchProviderCollection extends Collection
{
    /** @var WatchProvider[] */
    protected $items = [];

    public static function fromArray(array $data): self
    {
        return static::make($data)->map(
            fn (array $item) => WatchProvider::fromArray($item)
        );
    }
}
