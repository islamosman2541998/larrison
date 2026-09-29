<?php

namespace App\Http\Livewire\Site\Products;

use App\Models\Product;
use Livewire\Component;

class Index extends Component
{
    public $categories;
    public $selectedCategory = 0;
    public $search = '';

    public function mount($categories)
    {
        $this->categories = $categories;
    }

    public function changeCategory($id)
    {
        $this->selectedCategory = $id;
    }

    /**
     * Products are resolved on render instead of being held in a public
     * property, so the search box and the category filter always agree and
     * the model collection is never round-tripped through the browser.
     */
    public function getProductsProperty()
    {
        return Product::active()
            ->with('transNow', 'trans', 'categories.transNow', 'categories.trans')
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
            ->get();
    }

    public function render()
    {
        return view('livewire.site.products.index', [
            'products' => $this->products,
        ]);
    }
}
