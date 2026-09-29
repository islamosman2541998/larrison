<?php

namespace App\Support;

use App\Models\PageSection;
use Illuminate\Support\Collection;

/**
 * Reads the texts of a page's sections.
 *
 * Resolution order for every field:
 *   1. what the admin typed for the active locale,
 *   2. the default declared in config/page_sections.php for that locale,
 *   3. whatever the fallback locale has (stored, then its default),
 *   4. an empty string — a missing text never leaks a raw key onto the page.
 *
 * The locale's own default comes before the other locale's text on purpose:
 * editing the English heading and leaving Arabic blank must not put English
 * text on the Arabic page.
 *
 * A field that declares no `default` at all skips steps 2-3 entirely: it is
 * empty until the admin fills it in for that exact locale, and the blade is
 * expected to render nothing in its place.
 *
 * Rows are loaded once per page per request.
 */
class PageSectionRepository
{
    private static ?self $instance = null;

    /** @var array<string, Collection> page => sections keyed by their key */
    private array $loaded = [];

    public static function getInstance(): self
    {
        return self::$instance ??= new self();
    }

    /**
     * Value of one field, e.g. get('contact', 'side', 'title').
     */
    public function get(string $page, string $section, string $field, ?string $locale = null): string
    {
        $locale = $locale ?: app()->getLocale();
        $model  = $this->sections($page)->get($section);

        if ($stored = $model?->value($field, $locale)) {
            return $stored;
        }

        // A field that declares no default has no substitute text at all: it
        // stays empty in this locale rather than borrowing the other one.
        if (! $this->hasDefault($page, $section, $field)) {
            return '';
        }

        $fallback = config('app.fallback_locale');

        return $this->default($page, $section, $field, $locale)
            ?: (string) $model?->value($field, $fallback)
            ?: $this->default($page, $section, $field, $fallback);
    }

    /**
     * Whether the field declares any default text at all. Fields without one
     * are meant to disappear from the page until the admin fills them in.
     */
    public function hasDefault(string $page, string $section, string $field): bool
    {
        return config("page_sections.$page.sections.$section.fields.$field.default") !== null;
    }

    /**
     * Declared default for a field in one locale, used until the admin saves
     * something. Strict: it never borrows another locale's text — get() owns
     * the fallback order.
     */
    public function default(string $page, string $section, string $field, ?string $locale = null): string
    {
        $locale   = $locale ?: app()->getLocale();
        $defaults = config("page_sections.$page.sections.$section.fields.$field.default", []);

        return (string) ($defaults[$locale] ?? '');
    }

    /**
     * Stored sections of a page, keyed by section key.
     */
    public function sections(string $page): Collection
    {
        return $this->loaded[$page] ??= PageSection::forPage($page)
            ->with('trans')
            ->get()
            ->keyBy('key');
    }

    /**
     * Forget the cached rows, so an admin save is visible straight away.
     */
    public function forget(?string $page = null): void
    {
        if ($page === null) {
            $this->loaded = [];
            return;
        }

        unset($this->loaded[$page]);
    }
}
