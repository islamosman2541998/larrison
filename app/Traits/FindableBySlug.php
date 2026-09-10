<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Resolves a translatable model from a URL slug.
 *
 * The lookup always starts from the model table (never from the translations
 * table), so translation rows that were left behind by a deleted / trashed
 * record can no longer hijack a slug and produce a false 404.
 *
 * Resolution order:
 *   1. a translation in the current locale,
 *   2. a translation in any locale (locale switching, legacy links),
 *   3. the primary key, when the segment is numeric.
 */
trait FindableBySlug
{
    /**
     * Restrict the query to records owning the given slug.
     */
    public function scopeWhereSlug(Builder $query, string $slug, ?string $locale = null): Builder
    {
        return $query->whereHas('trans', function ($q) use ($slug, $locale) {
            $q->where('slug', $slug);

            if ($locale) {
                $q->where('locale', $locale);
            }
        });
    }

    /**
     * Find a record by slug (or by id when the segment is numeric).
     *
     * @param  string|int  $slug
     * @return static|null
     */
    public static function findBySlug($slug, bool $onlyActive = true)
    {
        $slug = trim((string) $slug);

        if ($slug === '') {
            return null;
        }

        $base = static::query();

        if ($onlyActive && method_exists(static::class, 'scopeActive')) {
            $base->active();
        }

        $model = (clone $base)->whereSlug($slug, app()->getLocale())->first()
            ?: (clone $base)->whereSlug($slug)->first();

        if ($model) {
            return $model;
        }

        // Legacy / fallback links that carry the primary key instead of a slug.
        return ctype_digit($slug) ? (clone $base)->find((int) $slug) : null;
    }

    /**
     * Slug used to build canonical URLs for this record.
     */
    public function routeSlug(): string
    {
        return (string) ($this->transNow?->slug ?: $this->getKey());
    }
}
