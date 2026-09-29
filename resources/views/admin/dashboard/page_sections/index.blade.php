@extends('admin.app')

@section('title', trans('admin.page_sections'))
@section('title_page', trans('admin.page_sections'))

@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="mdi mdi-information-outline"></i>
                    @lang('admin.page_sections_hint')
                </div>
            </div>
        </div>

        <div class="row">
            @forelse ($pages as $page)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">

                            <div class="d-flex align-items-center mb-3">
                                <i class="{{ $page['icon'] }} font-size-24 me-2"></i>
                                <h5 class="mb-0">{{ $page['label'] }}</h5>
                            </div>

                            <p class="text-muted mb-4">
                                {{ trans('admin.page_sections_count', [
                                    'sections' => $page['sections'],
                                    'fields' => $page['fields'],
                                ]) }}
                            </p>

                            <div class="mt-auto d-flex gap-2">
                                <a href="{{ route('admin.page-sections.edit', $page['key']) }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i> @lang('admin.edit_texts')
                                </a>

                                @if ($page['url'])
                                    <a href="{{ $page['url'] }}" target="_blank"
                                       class="btn btn-outline-secondary btn-sm">
                                        <i class="fa fa-eye"></i> @lang('admin.view_page')
                                    </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center text-muted py-5">
                            @lang('admin.no_data')
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
@endsection
