<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{

    public function index()
    {
        // The listing itself is rendered by the livewire component (it owns the
        // category filter and the search box); this only supplies the chips.
        $categories = ProductCategory::active()
            ->with('transNow', 'trans')
            ->orderBy('sort', 'ASC')
            ->get();

        return view('site.pages.products.index', compact('categories'));
    }

    public function show($slug)
    {
        $relations = [
            'transNow',
            'trans',
            'categories.transNow',
            'categories.parentCategories.transNow',
            'tipsActive.transNow',
            'galleryGroup.images' => function ($q) {
                $q->active()->orderBy('sort', 'ASC');
            },
        ];

        $product = Product::findBySlug($slug);

        if (!$product) {
            abort(404);
        }

        $product->load($relations);

        $currentSlug = $product->transNow?->slug;

        if ($currentSlug && $currentSlug !== $slug) {
            return redirect()->route('site.product.show', $currentSlug, 301);
        }

        $category = $product->categories->first();
        $parentCategory = $category ? $category->parentCategories->first() : null;

        $relatedProducts = collect();

        if ($category) {
            $relatedProducts = $category->products()
                ->where('products.id', '!=', $product->id)
                ->where('products.status', 1)
                ->with('transNow')
                ->limit(4)
                ->get();
        }

        return view('site.pages.products.show', compact(
            'product',
            'category',
            'parentCategory',
            'relatedProducts'
        ));
    }
}
