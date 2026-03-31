<?php

namespace App\Http\Livewire\Site;

use App\Models\ParentCategory;
use Livewire\Component;

class CategoriesSection extends Component
{
    public $parentCategories;
    public $subCategories = [];
    public $activeParentId = 'all'; 

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

    $this->loadSubCategories('all');
}

 public function selectParent($parentId)
{
    $this->activeParentId = $parentId;
    $this->loadSubCategories($parentId);
}
private function loadSubCategories($parentId)
{
    if ($parentId === 'all') {
        $this->subCategories = $this->parentCategories
            ->pluck('productCategories')
            ->flatten()
            ->unique('id')
            ->values();
    } else {
        $parent = $this->parentCategories->find($parentId);
        $this->subCategories = $parent ? $parent->productCategories : collect();
    }
}

    public function render()
    {
        return view('livewire.site.categories-section');
    }
}