@extends('admin.app')

@section('title', $pageLabel)
@section('title_page', trans('admin.edit_texts') . ' - ' . $pageLabel)

@section('content')
    @php
        $locale_now = app()->getLocale();
        $fallback = config('app.fallback_locale');
        $label_of = fn($values, $default = '') => $values[$locale_now] ?? $values[$fallback] ?? $default;
    @endphp

    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="alert alert-info d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <span>
                        <i class="mdi mdi-information-outline"></i>
                        @lang('admin.page_sections_edit_hint')
                    </span>
                    @if ($siteUrl)
                        <a href="{{ $siteUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-eye"></i> @lang('admin.view_page')
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <form action="{{ route('admin.page-sections.update', $page) }}" method="post">
            @csrf
            @method('put')

            @foreach ($config['sections'] ?? [] as $sectionKey => $section)
                @php $stored = $sections->get($sectionKey); @endphp

                <div class="card mb-4">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <h5 class="mb-0">{{ $label_of($section['label'] ?? [], $sectionKey) }}</h5>

                            @if ($stored)
                                <a href="{{ route('admin.page-sections.reset', [$page, $sectionKey]) }}"
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('{{ trans('admin.reset_section_confirm') }}')">
                                    <i class="fa fa-undo"></i> @lang('admin.reset_to_default')
                                </a>
                            @endif
                        </div>

                        @if (!empty($section['note']))
                            <p class="text-muted small">
                                <i class="mdi mdi-alert-circle-outline"></i>
                                {{ $label_of($section['note']) }}
                            </p>
                        @endif

                        <ul class="nav nav-tabs" role="tablist">
                            @foreach ($locales as $i => $locale)
                                <li class="nav-item">
                                    <a class="nav-link {{ $i === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                                       href="#tab-{{ $sectionKey }}-{{ $locale }}" role="tab">
                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content p-3 border border-top-0">
                            @foreach ($locales as $i => $locale)
                                <div class="tab-pane {{ $i === 0 ? 'active' : '' }}"
                                     id="tab-{{ $sectionKey }}-{{ $locale }}" role="tabpanel"
                                     dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

                                    @foreach ($section['fields'] ?? [] as $fieldKey => $field)
                                        @php
                                            $name = "values[$sectionKey][$locale][$fieldKey]";
                                            $default = $field['default'][$locale] ?? '';
                                            $value = old("values.$sectionKey.$locale.$fieldKey", $stored?->value($fieldKey, $locale));
                                        @endphp

                                        <div class="row mb-3">
                                            <label class="col-sm-3 col-form-label">
                                                {{ $label_of($field['label'] ?? [], $fieldKey) }}
                                            </label>
                                            <div class="col-sm-9">
                                                @if (($field['type'] ?? 'text') === 'textarea')
                                                    <textarea name="{{ $name }}" rows="3" class="form-control"
                                                              placeholder="{{ $default }}">{{ $value }}</textarea>
                                                @else
                                                    <input type="text" name="{{ $name }}" class="form-control"
                                                           value="{{ $value }}" placeholder="{{ $default }}">
                                                @endif

                                                @if ($default !== '')
                                                    <small class="text-muted">
                                                        @lang('admin.default_value'): {{ $default }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            @endforeach

            <div class="card">
                <div class="card-body text-center">
                    <button type="submit" class="btn btn-primary px-5">
                        <i class="fa fa-save"></i> @lang('admin.save')
                    </button>
                    <a href="{{ route('admin.page-sections.index') }}" class="btn btn-secondary px-4">
                        @lang('admin.back')
                    </a>
                </div>
            </div>

        </form>

    </div>
@endsection
