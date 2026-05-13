<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTranslation;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::active()
            ->with('transNow', 'categories.transNow')
            ->orderBy('sort', 'ASC')
            ->paginate(12);

        return view('site.pages.products.index', compact('products'));
    }

    public function show($slug)
    {
        $translation = ProductTranslation::where('slug', $slug)->first();

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

        if ($translation) {
            $product = Product::active()
                ->with($relations)
                ->find($translation->product_id);
        } else {
            $product = Product::active()
                ->with($relations)
                ->find($slug);
        }

        if (!$product) {
            abort(404);
        }

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
