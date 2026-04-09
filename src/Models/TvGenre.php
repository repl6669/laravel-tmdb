<?php

namespace Astrotomic\Tmdb\Models;

use Astrotomic\Tmdb\Eloquent\Builders\TvGenreBuilder;
use Astrotomic\Tmdb\Models\Concerns\HasTranslations;
use Astrotomic\Tmdb\Requests\TvGenre\ListAll;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string|null $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read array $translations
 *
 * @method \Astrotomic\Tmdb\Eloquent\Builders\TvGenreBuilder newModelQuery()
 * @method \Astrotomic\Tmdb\Eloquent\Builders\TvGenreBuilder newQuery()
 * @method static \Astrotomic\Tmdb\Eloquent\Builders\TvGenreBuilder query()
 *
 * @mixin TvGenreBuilder
 */
class TvGenre extends Model
{
    use HasTranslations;

    public array $translatable = [
        'name',
    ];

    protected $fillable = [
        'id',
        'name',
    ];

    protected $casts = [
        'id' => 'int',
    ];

    public static function all($columns = ['*']): EloquentCollection
    {
        $data = rescue(fn () => ListAll::request()->send()->collect('genres'));

        if ($data instanceof Collection) {
            $data->each(fn (array $genre) => static::query()->updateOrCreate(
                ['id' => $genre['id']],
                ['name' => $genre['name']],
            ));
        }

        return parent::all($columns);
    }

    public function fillFromTmdb(array $data, ?string $locale = null): static
    {
        $genre = $this->fill([
            'id' => $data['id'],
        ]);

        $locale ??= $this->getLocale();

        $this->setTranslation('name', $locale, trim($data['name']) ?: null);

        return $genre;
    }

    public function updateFromTmdb(?string $locale = null, array $with = []): bool
    {
        $data = rescue(fn () => ListAll::request()->language($locale)->send()->collect('genres'));

        if ($data === null) {
            return false;
        }

        $data = $data->keyBy('id');

        if (! $data->has($this->id)) {
            return false;
        }

        return $this->fillFromTmdb($data->get($this->id), $locale)->save();
    }

    public function newEloquentBuilder($query): TvGenreBuilder
    {
        return new TvGenreBuilder($query);
    }
}
