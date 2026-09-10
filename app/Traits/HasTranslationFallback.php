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
 */
trait HasTranslationFallback
{
    public function getTransNowAttribute()
    {
        if (! $this->relationLoaded('transNow')) {
            $this->load('transNow');
        }

        $translation = $this->getRelation('transNow');

        if ($this->isUsableTranslation($translation)) {
            return $translation;
        }

        if (! $this->relationLoaded('trans')) {
            $this->load('trans');
        }

        $usable = $this->getRelation('trans')
            ->first(fn ($row) => $row->locale === config('app.fallback_locale')
                && $this->isUsableTranslation($row))
            ?? $this->getRelation('trans')->first(fn ($row) => $this->isUsableTranslation($row));

        return $usable ?? $translation;
    }

    protected function isUsableTranslation($translation): bool
    {
        return $translation && trim((string) $translation->title) !== '';
    }
}
