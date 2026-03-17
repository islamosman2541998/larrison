<?php

namespace App\Http\Livewire\Site;

use App\Models\ParentCategory;
use Livewire\Component;

class CategoriesSection extends Component
{
    public $parentCategories;
    public $activeParentId = null;
    public $subCategories = [];

    public function mount()
    {
        $this->parentCategories = ParentCategory::active()
            ->with([
                'transNow',
                'productCategories' => function ($q) {
                    $q->where('status', 1);
                },
                'productCategories.transNow',
            ])
            ->orderBy('sort', 'ASC')
            ->get();

        // Set first parent as active by default
        if ($this->parentCategories->count() > 0) {
            $first = $this->parentCategories->first();
            $this->activeParentId = $first->id;
            $this->subCategories = $first->productCategories;
        }
    }

    public function selectParent($parentId)
    {
        $this->activeParentId = $parentId;

        $parent = $this->parentCategories->find($parentId);
        if ($parent) {
            $this->subCategories = $parent->productCategories;
        }
    }

    public function render()
    {
        return view('livewire.site.categories-section');
    }
}