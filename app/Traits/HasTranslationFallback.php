<?php

namespace App\Traits;

/**
 * Makes `$model->transNow` degrade gracefully.
 *
 * The `transNow()` relation is restricted to the active locale, so a record
 * that was never translated into that locale (or that was saved with an empty
 * translation) renders as a blank card with an id-based URL. This accessor
 * leaves the relation itself untouched — eager loading still works — and only
 * steps in when the active-locale translation is missing or empty.
 *
 * Performance: an already eager-loaded `trans` collection is used first, so
 * `with('trans')` alone is enough to serve a whole listing without a single
 * extra query. Lazy loading only happens when nothing was eager-loaded.
 */
trait HasTranslationFallback
{
    public function getTransNowAttribute()
    {
        if ($this->relationLoaded('trans')) {
            return $this->pickTranslation($this->getRelation('trans'));
        }

        if (! $this->relationLoaded('transNow')) {
            $this->load('transNow');
        }

        $translation = $this->getRelation('transNow');

        if ($this->isUsableTranslation($translation)) {
            return $translation;
        }

        $this->load('trans');

        return $this->pickTranslation($this->getRelation('trans')) ?? $translation;
    }

    /**
     * Active locale, then the fallback locale, then anything usable.
     */
    protected function pickTranslation($translations)
    {
        $locale   = app()->getLocale();
        $fallback = config('app.fallback_locale');

        $current = $translations->firstWhere('locale', $locale);

        if ($this->isUsableTranslation($current)) {
            return $current;
        }

        $usable = $translations->first(fn ($row) => $row->locale === $fallback && $this->isUsableTranslation($row))
            ?? $translations->first(fn ($row) => $this->isUsableTranslation($row));

        return $usable ?? $current;
    }

    protected function isUsableTranslation($translation): bool
    {
        return $translation && trim((string) $translation->title) !== '';
    }
}
