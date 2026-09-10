<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\ParentCategory;
use App\Models\ProductCategory;

class CategoryController extends Controller
{
    public function index()
    {
        $parentCategories = ParentCategory::active()
            ->with([
                'transNow',
                'trans',
                'productCategories' => function ($q) {
                    $q->where('product_categories.status', 1)
                      ->orderBy('product_categories.sort', 'ASC');
                },
                'productCategories.transNow',
                'productCategories.trans',
                'productCategories.parentCategories:id',
            ])
            ->orderBy('sort', 'ASC')
            ->get();

        // A product category may belong to several parents; without this the
        // same card would be rendered once per parent. Categories that are not
        // attached to any parent are appended so they are not invisible on the
        // site just because the admin forgot to tick a parent.
        $productCategories = $parentCategories
            ->pluck('productCategories')
            ->flatten()
            ->concat(
                ProductCategory::active()
                    ->whereDoesntHave('parentCategories')
                    ->with('transNow', 'trans', 'parentCategories:id')
                    ->orderBy('sort', 'ASC')
                    ->get()
            )
            ->unique('id')
            ->values();

        return view('site.pages.categories.index', compact('parentCategories', 'productCategories'));
    }

    public function categoryProducts($slug)
    {
        $category = ProductCategory::findBySlug($slug);

        if (! $category) {
            abort(404);
        }

        $currentSlug = $category->transNow?->slug;
        if ($currentSlug && $currentSlug !== $slug) {
            return redirect()->route('site.category.products', $currentSlug, 301);
        }

        $query = $category->products()
            ->where('products.status', 1)
            ->with('transNow', 'trans');

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

        $products = $query->orderBy('products.sort', 'ASC')->paginate(12);

        return view('site.pages.categories.products', compact('category', 'products'));
    }

    public function parentCategories($slug)
    {
        $parentCategory = ParentCategory::findBySlug($slug);

        if (! $parentCategory) {
            abort(404);
        }

        $currentSlug = $parentCategory->transNow?->slug;
        if ($currentSlug && $currentSlug !== $slug) {
            return redirect()->route('site.parent.categories', $currentSlug, 301);
        }

        $query = $parentCategory->productCategories()
            ->where('product_categories.status', 1)
            ->with('transNow', 'trans');

        if (request('search')) {
            $search = '%' . request('search') . '%';
            $query->whereHas('trans', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                  ->where('title', 'LIKE', $search);
            });
        }

        $categories = $query->orderBy('product_categories.sort', 'ASC')->paginate(12);

        return view('site.pages.categories.parent-categories', compact('parentCategory', 'categories'));
    }
}
