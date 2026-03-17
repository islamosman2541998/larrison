<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ParentCategoryRequest;
use App\Models\ParentCategory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Traits\TranslatableHandler;

class ParentCategoryController extends Controller
{
    use TranslatableHandler;

    public $parentPath;

    public function __construct()
    {
        $this->parentPath = '/attachments/parent_category/main_images/';
    }

    public function index(Request $request)
    {
        $query = ParentCategory::query()->orderBy('id', 'DESC');

        if ($request->status != '') {
            if ($request->status == 1) {
                $query->where('status', $request->status);
            } else {
                $query->where('status', '!=', 1);
            }
        }

        if ($request->title !== '') {
            $search = '%' . $request->input('title') . '%';
            $query->whereHas('trans', function ($q) use ($search) {
                $q->where('locale', app()->getLocale())
                    ->where('title', 'LIKE', $search);
            });
        }

        $items = $query->paginate($this->pagination_count);

        return view('admin.dashboard.parent_categories.index', compact('items'));
    }

    public function create()
    {
        $productCategories = ProductCategory::with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->active()->get();

        return view('admin.dashboard.parent_categories.create', compact('productCategories'));
    }

    public function store(ParentCategoryRequest $request)
    {
        $data = $request->getSanitized();

        $parentCategory = ParentCategory::create($data);
        $this->saveModelTranslation($parentCategory, $data);

        // Sync product categories
        if ($request->product_categories) {
            $parentCategory->productCategories()->sync($request->product_categories);
        }

        session()->flash('success', trans('message.admin.created_sucessfully'));
        return redirect(route('admin.parent_category.index'));
    }

    public function show($id)
    {
        $category = ParentCategory::with('trans', 'productCategories.trans')->find($id);

        if (!$category) {
            abort(404);
        }

        return view('admin.dashboard.parent_categories.show', compact('category'));
    }

    public function edit($id)
    {
        $category = ParentCategory::with('trans', 'productCategories')->find($id);

        if (!$category) {
            abort(404);
        }

        $productCategories = ProductCategory::with([
            'trans' => function ($q) {
                $q->where('locale', app()->getLocale());
            }
        ])->active()->get();

        return view('admin.dashboard.parent_categories.edit', compact('category', 'productCategories'));
    }

    public function update(ParentCategory $parentCategory, ParentCategoryRequest $request)
    {
        if ($parentCategory) {
            $data = $request->getSanitized();

            $parentCategory->update($data);
            $this->saveModelTranslation($parentCategory, $data);

            // Sync product categories
            if ($request->has('product_categories')) {
                $parentCategory->productCategories()->sync($request->product_categories ?? []);
            }
        }

        session()->flash('success', trans('message.admin.updated_sucessfully'));
        return redirect()->back();
    }

    public function destroy(ParentCategory $parentCategory)
    {
        // Check if has product categories attached
        if ($parentCategory->productCategories->count() > 0) {
            session()->flash('error', trans('message.admin.you can not delete this item until removing its categories first'));
            return redirect()->back();
        }

        $this->deleteImage($parentCategory, 'image');
        $parentCategory->delete();

        session()->flash('success', trans('message.admin.deleted_sucessfully'));
        return redirect()->route('admin.parent_category.index');
    }

    public function updateFeature($id)
    {
        $item = ParentCategory::find($id);
        $item->feature = $item->feature < 1 ? 1 : 0;
        $item->save();

        session()->flash('success', trans('message.admin.featured_changed_sucessfully'));
        return redirect()->back();
    }

    public function updateStatus($id)
    {
        $item = ParentCategory::find($id);
        $item->status = $item->status < 1 ? 1 : 0;
        $item->save();

        session()->flash('success', trans('message.admin.status_changed_sucessfully'));
        return redirect()->back();
    }

    public function actions(Request $request)
    {
        if ($request['publish'] == 1) {
            $items = ParentCategory::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 1]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }

        if ($request['unpublish'] == 1) {
            $items = ParentCategory::findMany($request['record']);
            foreach ($items as $item) {
                $item->update(['status' => 0]);
            }
            session()->flash('success', trans('pages.status_changed_sucessfully'));
        }

        if ($request['delete_all'] == 1) {
            $items = ParentCategory::findMany($request['record']);
            foreach ($items as $item) {
                if ($item->path() . $item->image) {
                    $this->deleteImage($item, 'image');
                    @unlink($item->path() . $item->image);
                    $item->delete();
                }
            }
            session()->flash('success', trans('pages.delete_all_sucessfully'));
        }

        return redirect()->back();
    }
}