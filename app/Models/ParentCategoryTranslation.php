<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentCategoryTranslation extends Model
{
    use HasFactory;

    protected $table = 'parent_category_translations';

    protected $fillable = [
        'parent_category_id',
        'locale',
        'title',
        'slug',
        'description',
        'meta_title',
        'meta_desc',
        'meta_key',
    ];

    public function parentCategory()
    {
        return $this->belongsTo(ParentCategory::class, 'parent_category_id');
    }
}