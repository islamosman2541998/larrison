@extends('admin.app')

@section('title', trans('parent_category.show_parent_category'))
@section('title_page', trans('parent_category.show_parent_category', ['name' => $category->trans ? @$category->trans->where('locale', $current_lang)->first()->title : '']))

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
                            <div class="row">
                                <div class="col-md-8">
                                    @foreach ($languages as $key => $locale)
                                        @php $trans = $category->trans()->where('locale', $locale)->first() @endphp
                                        @if($trans)
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
                                                                    <input class="form-control" type="text" disabled
                                                                           value="{{ $trans->title }}">
                                                                </div>
                                                            </div>

                                                            {{-- slug --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    {{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" disabled
                                                                           value="{{ $trans->slug }}">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    {{-- Meta info --}}
                                    <div class="accordion mt-4 mb-4 bg-success" id="accordionMeta">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingMeta">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseMeta"
                                                        aria-expanded="true"
                                                        aria-controls="collapseMeta">
                                                    @lang('admin.meta')
                                                </button>
                                            </h2>
                                            <div id="collapseMeta"
                                                 class="accordion-collapse collapse show mt-3"
                                                 aria-labelledby="headingMeta"
                                                 data-bs-parent="#accordionMeta">
                                                <div class="accordion-body">

                                                    @foreach ($languages as $key => $locale)
                                                        @php $trans = $category->trans()->where('locale', $locale)->first() @endphp
                                                        @if($trans)

                                                            {{-- meta_title --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    {{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10">
                                                                    <input class="form-control" type="text" disabled
                                                                           value="{{ $trans->meta_title }}">
                                                                </div>
                                                            </div>

                                                            {{-- meta_desc --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    @lang('admin.meta_description_in') {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    {!! $trans->meta_desc !!}
                                                                </div>
                                                            </div>

                                                            {{-- meta_key --}}
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label">
                                                                    @lang('admin.meta_key_in') {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                                </label>
                                                                <div class="col-sm-10 mb-2">
                                                                    <textarea class="form-control description"
                                                                              disabled>{{ $trans->meta_key }}</textarea>
                                                                </div>
                                                            </div>

                                                        @endif
                                                        <hr>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Product Categories List --}}
                                    <div class="accordion mt-4 mb-4 bg-info" id="accordionSubCats">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingSubCats">
                                                <button class="accordion-button fw-medium" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseSubCats"
                                                        aria-expanded="true"
                                                        aria-controls="collapseSubCats">
                                                    @lang('parent_category.product_categories')
                                                    <span class="badge bg-primary ms-2">{{ $category->productCategories->count() }}</span>
                                                </button>
                                            </h2>
                                            <div id="collapseSubCats"
                                                 class="accordion-collapse collapse show mt-3"
                                                 aria-labelledby="headingSubCats"
                                                 data-bs-parent="#accordionSubCats">
                                                <div class="accordion-body">
                                                    @if($category->productCategories && $category->productCategories->count())
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>@lang('admin.title')</th>
                                                                    <th>@lang('admin.status')</th>
                                                                    <th>@lang('articles.actions')</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($category->productCategories as $index => $subCat)
                                                                    <tr>
                                                                        <td>{{ $index + 1 }}</td>
                                                                        <td>{{ optional($subCat->transNow)->title }}</td>
                                                                        <td>
                                                                            @if($subCat->status == 1)
                                                                                <span class="badge bg-success">@lang('admin.active')</span>
                                                                            @else
                                                                                <span class="badge bg-danger">@lang('admin.dis_active')</span>
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                            <a href="{{ route('admin.product_category.show', $subCat->id) }}"
                                                                               class="btn btn-outline-info btn-sm">
                                                                                <i class="fas fa-eye"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <p class="text-muted">@lang('parent_category.no_sub_categories')</p>
                                                    @endif
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

                                                    @if(@$category->image != null)
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
                                                    @endif

                                                    {{-- sort --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label class="col-form-label">@lang('admin.sort')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" disabled type="text"
                                                                       value="{{ $category->sort }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- created_by --}}
                                                    <div class="col-12">
                                                        <div class="row mb-3">
                                                            <label class="col-form-label">@lang('admin.created_by')</label>
                                                            <div class="col-sm-12">
                                                                <input class="form-control" disabled type="text"
                                                                       value="{{ optional($category->createdBy)->name }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if($category->updatedBy && $category->updatedBy->id)
                                                        <div class="col-12">
                                                            <div class="row mb-3">
                                                                <label class="col-form-label">@lang('admin.updated_by'):</label>
                                                                <div class="col-sm-12">
                                                                    <input class="form-control" disabled type="text"
                                                                           value="{{ $category->updatedBy->name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- feature --}}
                                                    <div class="col-12">
                                                        <label class="col-md-3 col-form-label">{{ trans('admin.feature') }}</label>
                                                        @if($category->feature == 1)
                                                            <p class="badge bg-success h3"
                                                               style="font-size:20px">@lang("admin.yes")</p>
                                                        @else
                                                            <p class="badge bg-danger h3"
                                                               style="font-size:20px">@lang("admin.no")</p>
                                                        @endif
                                                    </div>

                                                    {{-- Status --}}
                                                    <div class="col-12">
                                                        <label class="col-sm-3 col-form-label">{{ trans('admin.status') }}</label>
                                                        @if($category->status == 1)
                                                            <p class="badge bg-success h3"
                                                               style="font-size:20px">@lang("admin.active")</p>
                                                        @else
                                                            <p class="badge bg-danger h3"
                                                               style="font-size:20px">@lang("admin.dis_active")</p>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3 text-end">
                                    <div>
                                        <a href="{{ route('admin.parent_category.index') }}"
                                           class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                    </div>
                                </div>
                            </div>

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