<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * One editable block of a static page (e.g. the "side" block of the contact
 * page). Which blocks exist, and which texts each one holds, is declared in
 * config/page_sections.php — this table only stores what the admin typed.
 */
class PageSection extends Model
{
    use HasFactory;

    protected $fillable = ['page', 'key'];

    public function trans()
    {
        return $this->hasMany(PageSectionTranslation::class, 'page_section_id');
    }

    public function transNow()
    {
        return $this->hasOne(PageSectionTranslation::class, 'page_section_id')
            ->where('locale', app()->getLocale());
    }

    public function scopeForPage($query, string $page)
    {
        return $query->where('page', $page);
    }

    /**
     * Stored value of one field in one locale, or null when never filled in.
     */
    public function value(string $field, ?string $locale = null): ?string
    {
        $locale = $locale ?: app()->getLocale();

        $translation = $this->relationLoaded('trans')
            ? $this->trans->firstWhere('locale', $locale)
            : $this->trans()->where('locale', $locale)->first();

        $value = $translation?->values[$field] ?? null;

        return is_string($value) && trim($value) !== '' ? $value : null;
    }
}
