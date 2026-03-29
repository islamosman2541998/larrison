<?php

namespace App\Http\Requests\Admin;

use App\Traits\FileHandler;
use Illuminate\Foundation\Http\FormRequest;

class ParentCategoryRequest extends FormRequest
{
    use FileHandler;

    public $parentPath;

    public function __construct()
    {
        $this->parentPath = '/attachments/parent_category/main_images/';
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $arr = [];

        $arr += ['ar' => 'nullable|array'];
        $arr += ['en' => 'nullable|array'];

        foreach (config('translatable.locales') as $locale) {
            $arr += [$locale . '.title' => 'nullable|min:1'];
            $arr += [$locale . '.slug' => 'nullable|min:1'];
            $arr += [$locale . '.description' => 'nullable|min:1'];
            $arr += [$locale . '.meta_title' => 'nullable|min:1'];
            $arr += [$locale . '.meta_desc' => 'nullable|min:1'];
            $arr += [$locale . '.meta_key' => 'nullable|min:1'];
        }

        $arr += ['image' => 'nullable|' . ImageValidate()];
        $arr += ['status' => 'nullable'];
        $arr += ['sort' => 'nullable'];
        $arr += ['feature' => 'nullable'];
        $arr += ['product_categories' => 'nullable|array'];
        $arr += ['product_categories.*' => 'nullable|exists:product_categories,id'];

        if (request()->isMethod('POST')) {
            $arr['image'] = 'nullable|' . ImageValidate();
        }

        return $arr;
    }

    public function getSanitized()
    {
        $data = $this->validated();

        if (request()->image) {
            $img = $this->storeImage2(request(), $this->parentPath, request()->image, 'image');
            $data['image'] = $img;
        }

        $data['status'] = isset($data['status']) ? 1 : 0;
        $data['feature'] = isset($data['feature']) ? 1 : 0;

        foreach (config('translatable.locales') as $locale) {
            $data[$locale]['slug'] = slug($data[$locale]['slug']);
        }

        if (request()->isMethod('PUT')) {
            $data['updated_by'] = @auth()->user()->id;
        } else {
            $data['created_by'] = @auth()->user()->id;
        }

        return $data;
    }
}