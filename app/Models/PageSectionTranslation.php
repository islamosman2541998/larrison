<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSectionTranslation extends Model
{
    use HasFactory;

    protected $table = 'page_section_translations';

    protected $fillable = ['page_section_id', 'locale', 'values'];

    protected $casts = ['values' => 'array'];

    public function section()
    {
        return $this->belongsTo(PageSection::class, 'page_section_id');
    }
}
