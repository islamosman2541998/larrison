@extends('admin.app')

@section('title', trans('parent_category.edit_parent_category'))
@section('title_page', trans('parent_category.edit_parent_category', ['name' => $category->trans ? @$category->trans->where('locale', $current_lang)->first()->title : '']))

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-12 m-3">
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.parent_category.index') }}"
                               class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <form class="row" method="post"
                                  action="{{ route('admin.parent_category.update', $category->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Title and description --}}
                                <div class="col-md-8">
                                    @foreach ($languages as $key => $locale)
                                        @php $trans = $category->trans()->where('locale', $locale)->first() @endphp
                                        @if(isset($trans))
                                            <div class="accordion mt-4 mb-4" id="accordionLang{{ $locale }}">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne{{ $key }}"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne{{ $key }}"
                                                         class="accordion-collapse collapse show mt-3"
                                                         aria-labelledby="headingOne{{ $key }}"
                                                         data-bs-parent="#accordionLang{{ $locale }}">
                                                        <div class="accordion-body">

                                                            {{-- title --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    {{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text"
                                                                           name="{{ $locale }}[title]" 
                                                                           id="title{{ $key }}"
                                                                           value="{{ $trans->title }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- slug --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    {{ trans('products.slug') . trans('lang.' . Locale::getDisplayName(@$locale)) }}
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control"
                                                                           name="{{ @$locale }}[slug]"
                                                                           id="slug{{ $key }}" type="text"
                                                                           value="{{ $trans->slug ?? old($locale . '.slug') }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.slug'))
                                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                @endif
                                                            </div>

                                                            @include('admin.layouts.scriptSlug')

                                                            {{-- description --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    @lang('admin.description_in') {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}"
                                                                              name="{{ $locale }}[description]">{{ $trans->description ?? old($locale . '.description') }}</textarea>

                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                            filebrowserUploadMethod: 'form'
                                                                        });
                                                                    </script>

                                                                    @if($errors->has($locale . '.description'))
                                                                        <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="accordion mt-4 mb-4" id="accordionLang{{ $locale }}">
                                                <div class="accordion-item border rounded">
                                                    <h2 class="accordion-header" id="headingOne{{ $key }}">
                                                        <button class="accordion-button fw-medium" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne{{ $key }}"
                                                                aria-expanded="true"
                                                                aria-controls="collapseOne{{ $key }}">
                                                            {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne{{ $key }}"
                                                         class="accordion-collapse collapse show mt-3"
                                                         aria-labelledby="headingOne{{ $key }}"
                                                         data-bs-parent="#accordionLang{{ $locale }}">
                                                        <div class="accordion-body">

                                                            {{-- title --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    {{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" 
                                                                           name="{{ $locale }}[title]"
                                                                           id="title{{ $key }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.title'))
                                                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                                @endif
                                                            </div>

                                                            {{-- slug --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    {{ trans('products.slug') . trans('lang.' . Locale::getDisplayName(@$locale)) }}
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control"
                                                                           name="{{ @$locale }}[slug]"
                                                                           id="slug{{ $key }}" type="text"
                                                                           value="{{ old($locale . '.slug') }}">
                                                                </div>
                                                                @if ($errors->has($locale . '.slug'))
                                                                    <span class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                                @endif
                                                            </div>

                                                            @include('admin.layouts.scriptSlug')

                                                            {{-- description --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    @lang('admin.description_in') {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea id="description{{ $key }}"
                                                                              name="{{ $locale }}[description]">{{ old($locale . '.description') }}</textarea>

                                                                    <script type="text/javascript">
                                                                        CKEDITOR.replace('description{{ $key }}', {
                                                                            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                            filebrowserUploadMethod: 'form'
                                                                        });
                                                                    </script>

                                                                    @if($errors->has($locale . '.description'))
                                                                        <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    {{-- Meta Info --}}
                                    <div class="accordion mt-4 mb-4 bg-success" id="accordionMeta">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingMeta">
                                                <button class="accordion-button fw-medium collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseMeta"
                                                        aria-expanded="false"
                                                        aria-controls="collapseMeta">
                                                    @lang('admin.meta')
                                                </button>
                                            </h2>
                                            <div id="collapseMeta"
                                                 class="accordion-collapse collapse mt-3"
                                                 aria-labelledby="headingMeta"
                                                 data-bs-parent="#accordionMeta">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                        @php $trans = $category->trans()->where('locale', $locale)->first() @endphp

                                                        {{-- meta_title --}}
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                {{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10">
                                                                <input class="form-control" type="text"
                                                                       name="{{ $locale }}[meta_title]"
                                                                       value="{{ $trans->meta_title ?? '' }}">
                                                            </div>
                                                            @if($errors->has($locale . '.meta_title'))
                                                                <span class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                            @endif
                                                        </div>

                                                        {{-- meta_desc --}}
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                @lang('admin.meta_description_in') {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                <textarea name="{{ $locale }}[meta_desc]"
                                                                          class="form-control description">{{ $trans->meta_desc ?? old($locale . '.meta_desc') }}</textarea>
                                                                @if($errors->has($locale . '.meta_description'))
                                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        {{-- meta_key --}}
                                                        <div class="row mb-3">
                                                            <label class="col-sm-2 col-form-label">
                                                                @lang('admin.meta_key_in') {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-10 mb-2">
                                                                <textarea name="{{ $locale }}[meta_key]"
                                                                          class="form-control description">{{ $trans->meta_key ?? old($locale . '.meta_key') }}</textarea>
                                                                @if($errors->has($locale . '.meta_key'))
                                                                    <span class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>

                                                        <hr>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Sidebar --}}
                                <div class="col-md-4">
                                    <div class="accordion mt-4 mb-4" id="accordionSettings">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingSettings">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseSettings"
                                                        aria-expanded="true"
                                                        aria-controls="collapseSettings">
                                                    {{ trans('admin.settings') }}
                                                </button>
                                            </h2>
                                            <div id="collapseSettings"
                                                 class="accordion-collapse collapse show"
                                                 aria-labelledby="headingSettings"
                                                 data-bs-parent="#accordionSettings">
                                                <div class="accordion-body">

                                                    {{-- Current image --}}
                                                    {{-- @if(@$category->image != null)
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <div class="col-sm-12">
                                                                    <a href="{{ asset($category->pathInView()) }}"
                                                                       target="_blank">
                                                                        <img src="{{ asset($category->pathInView()) }}"
                                                                             alt="" style="width:100%">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif --}}

                                                    {{-- image upload --}}
                                                    {{-- <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label class="col-form-label">
                                                                @lang('products.image')
                                                            </label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="file"
                                                                       placeholder="@lang('products.image')"
                                                                       name="image">
                                                            </div>
                                                        </div>
                                                    </div> --}}

                                                    {{-- sort --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label class="col-form-label">@lang('admin.sort')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" type="number"
                                                                       placeholder="@lang('admin.sort')"
                                                                       name="sort"
                                                                       value="{{ $category->sort }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Product Categories (multi-select) --}}
                                                    <div class="row mb-3">
                                                        <label class="col-sm-12 col-form-label">
                                                            @lang('parent_category.product_categories')
                                                        </label>
                                                        <div class="col-sm-12">
                                                            <select multiple
                                                                    class="form-select form-select-sm select2"
                                                                    name="product_categories[]"
                                                                    style="min-height: 150px;">
                                                                @php
                                                                    $selectedCats = $category->productCategories->pluck('id')->toArray();
                                                                @endphp
                                                                @forelse($productCategories as $pCat)
                                                                    <option value="{{ $pCat->id }}"
                                                                        {{ in_array($pCat->id, $selectedCats) ? 'selected' : '' }}>
                                                                        {{ isset($pCat->trans[0]) ? $pCat->trans[0]->title : '' }}
                                                                    </option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>

                                                    {{-- feature --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('admin.feature') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="feature"
                                                                   type="checkbox" id="switch1" switch="success"
                                                                   {{ $category->feature == 1 ? 'checked' : '' }}
                                                                   value="1">
                                                            <label class="form-label" for="switch1"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>

                                                    {{-- Status --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-12 col-form-label"
                                                               for="available">{{ trans('admin.status') }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-check form-switch" name="status"
                                                                   type="checkbox" id="switch3" switch="success"
                                                                   {{ $category->status == 1 ? 'checked' : '' }}
                                                                   value="1">
                                                            <label class="form-label" for="switch3"
                                                                   data-on-label=" @lang('admin.yes') "
                                                                   data-off-label=" @lang('admin.no')"></label>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 text-end">
                                    <div>
                                        <button type="submit"
                                                class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">
                                            @lang('button.submit')
                                        </button>
                                        <a href="{{ route('admin.parent_category.index') }}"
                                           class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('assets/js/ckeditor/ckeditor.js') }}"></script>
@endsection