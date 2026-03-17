<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ParentCategory;
use App\Models\ProductCategory;
use App\Models\ProductCategoryTranslation;
use App\Models\ParentCategoryTranslation;

class CategoryController extends Controller
{
    
    public function index()
    {
        $parentCategories = ParentCategory::active()
            ->with([
                'transNow',
                'productCategories' => function ($q) {
                    $q->where('status', 1)->orderBy('sort', 'ASC');
                },
                'productCategories.transNow',
            ])
            ->orderBy('sort', 'ASC')
            ->get();

        return view('site.pages.categories.index', compact('parentCategories'));
    }

  
    public function categoryProducts($slug)
    {
        $translation = ProductCategoryTranslation::where('slug', $slug)->first();

        if (!$translation) {
            $category = ProductCategory::active()->find($slug);
        } else {
            $category = ProductCategory::active()->find($translation->product_category_id);
        }

        if (!$category) {
            abort(404);
        }

        $currentSlug = $category->transNow?->slug;
        if ($currentSlug && $currentSlug !== $slug) {
            return redirect()->route('site.category.products', $currentSlug, 301);
        }

        $query = $category->products()
            ->where('products.status', 1)
            ->with('transNow');

        if (request('search')) {
            $search = '%' . request('search') . '%';
            $query->whereHas('trans', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                  ->where(function ($q2) use ($search) {
                      $q2->where('title', 'LIKE', $search)
                         ->orWhere('description', 'LIKE', $search);
                  });
            });
        }

        $products = $query->orderBy('sort', 'ASC')->paginate(12);

        return view('site.pages.categories.products', compact('category', 'products'));
    }

    
    public function parentCategories($slug)
    {
        $translation = ParentCategoryTranslation::where('slug', $slug)->first();

        if (!$translation) {
            $parentCategory = ParentCategory::active()->find($slug);
        } else {
            $parentCategory = ParentCategory::active()->find($translation->parent_category_id);
        }

        if (!$parentCategory) {
            abort(404);
        }

        $currentSlug = $parentCategory->transNow?->slug;
        if ($currentSlug && $currentSlug !== $slug) {
            return redirect()->route('site.parent.categories', $currentSlug, 301);
        }

        $query = $parentCategory->productCategories()
            ->where('product_categories.status', 1)
            ->with('transNow');

        if (request('search')) {
            $search = '%' . request('search') . '%';
            $query->whereHas('trans', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                  ->where('title', 'LIKE', $search);
            });
        }

        $categories = $query->orderBy('sort', 'ASC')->paginate(12);

        return view('site.pages.categories.parent-categories', compact('parentCategory', 'categories'));
    }
}