<?php

namespace App\Http\Livewire\Site\Products;

use App\Models\Product;
use App\Models\ProductCategory;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Products listing with a category filter, a search box and pagination.
 *
 * Nothing heavy lives in public state on purpose: only the filter, the search
 * term and the page number travel to the browser and back. The categories and
 * the products are resolved on render, so no Eloquent collection is ever
 * serialised into the payload or re-queried during hydration.
 */
class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedCategory = 0;
    public $search = '';

    protected $queryString = [
        'selectedCategory' => ['except' => 0, 'as' => 'category'],
        'search'           => ['except' => ''],
        'page'             => ['except' => 1],
    ];

    public const PER_PAGE = 12;

    public function changeCategory($id)
    {
        $this->selectedCategory = (int) $id;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getCategoriesProperty()
    {
        return ProductCategory::active()
            ->with('trans')
            ->orderBy('sort', 'ASC')
            ->get();
    }

    public function getProductsProperty()
    {
        return Product::active()
            ->with(['trans', 'categories' => fn ($q) => $q->with('trans')])
            ->when($this->selectedCategory, function ($query) {
                $query->whereHas('categories', function ($q) {
                    $q->where('product_categories.id', $this->selectedCategory);
                });
            })
            ->when(trim($this->search) !== '', function ($query) {
                $search = '%' . trim($this->search) . '%';
                $query->whereHas('trans', function ($q) use ($search) {
                    $q->where('locale', app()->getLocale())
                      ->where(function ($q2) use ($search) {
                          $q2->where('title', 'LIKE', $search)
                             ->orWhere('description', 'LIKE', $search);
                      });
                });
            })
            ->orderBy('sort', 'ASC')
            ->orderBy('id', 'DESC')
            ->paginate(self::PER_PAGE);
    }

    public function render()
    {
        return view('livewire.site.products.index', [
            'categories' => $this->categories,
            'products'   => $this->products,
        ]);
    }
}
