<?php

namespace Astrotomic\Tmdb\Eloquent\Relations;

use Astrotomic\Tmdb\Eloquent\Builders\CreditBuilder;
use Astrotomic\Tmdb\Requests\Movie\Credits;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin CreditBuilder
 */
class MorphManyCredits extends MorphMany
{
    public function all(array $columns = ['*']): Collection
    {
        $ids = Credits::request($this->getParentKey())->send()->json('*.*.credit_id');

        return $this->query->findMany($ids, $columns);
    }
}
