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
        // البحث في كل اللغات مش اللغة الحالية بس
        $translation = ProductTranslation::where('slug', $slug)->first();

        if ($translation) {
            $product = Product::active()
                ->with([
                    'transNow',
                    'trans',
                    'categories.transNow',
                    'categories.parentCategories.transNow',
                    'tipsActive.transNow',
                    'galleryGroup.images',
                ])
                ->find($translation->product_id);
        } else {
            $product = Product::active()
                ->with([
                    'transNow',
                    'trans',
                    'categories.transNow',
                    'categories.parentCategories.transNow',
                    'tipsActive.transNow',
                    'galleryGroup.images',
                ])
                ->find($slug);
        }

        if (!$product) {
            abort(404);
        }

        // لو الـ slug مش بتاع اللغة الحالية → redirect للـ slug الصح
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
                ->where('status', 1)
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