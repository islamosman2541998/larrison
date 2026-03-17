<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentCategory extends Model
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'image',
        'sort',
        'feature',
        'status',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    protected $translationForeignKey = 'parent_category_id';

    public $translatedAttributes = [
        'parent_category_id',
        'locale',
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_desc',
        'meta_key',
    ];

    // ======================== Relations ========================

    public function trans()
    {
        return $this->hasMany(ParentCategoryTranslation::class, 'parent_category_id', 'id');
    }

    public function translations()
    {
        return $this->hasMany(ParentCategoryTranslation::class, 'parent_category_id', 'id');
    }

    public function transNow()
    {
        return $this->hasOne(ParentCategoryTranslation::class, 'parent_category_id', 'id')
            ->where('locale', app()->getLocale());
    }

    /**
     * Many-to-many relationship with ProductCategory
     */
    public function productCategories()
    {
        return $this->belongsToMany(
            ProductCategory::class,
            'parent_category_product_category',
            'parent_category_id',
            'product_category_id'
        )->withTimestamps();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ======================== Scopes ========================

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeFeature($query)
    {
        return $query->where('feature', 1);
    }

    // ======================== Boot ========================

    protected static function boot()
    {
        parent::boot();
    }

    // ======================== Images ========================

    public static function staticPath()
    {
        return "/attachments/parent_category/main_images/";
    }

    public function path()
    {
        return "/attachments/parent_category/main_images/";
    }

    public function pathInView()
    {
        if (file_exists(public_path() . $this->path() . $this->image) && $this->image) {
            $path = $this->path() . $this->image;
        } else {
            $path = '/attachments/no_image/no_image.png';
        }
        return $path;
    }
}