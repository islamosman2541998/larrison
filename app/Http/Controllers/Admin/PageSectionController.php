<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use App\Models\PageSectionTranslation;
use App\Support\PageSectionRepository;
use Illuminate\Http\Request;

/**
 * Dashboard > Settings > Page sections.
 *
 * Lets the admin edit the static texts of the site's fixed pages. Everything
 * shown here is declared in config/page_sections.php.
 */
class PageSectionController extends Controller
{
    public function index()
    {
        $pages = collect(config('page_sections', []))
            ->map(function ($config, $page) {
                return [
                    'key'      => $page,
                    'label'    => $this->localized($config['label'] ?? [], $page),
                    'icon'     => $config['icon'] ?? 'mdi mdi-file-document-outline',
                    'sections' => count($config['sections'] ?? []),
                    'fields'   => collect($config['sections'] ?? [])
                        ->sum(fn ($section) => count($section['fields'] ?? [])),
                    'url'      => $this->siteUrl($config),
                ];
            })
            ->values();

        return view('admin.dashboard.page_sections.index', compact('pages'));
    }

    public function edit(string $page)
    {
        $config = config("page_sections.$page");

        abort_if(!$config, 404);

        $sections = PageSection::forPage($page)->with('trans')->get()->keyBy('key');
        $locales  = config('translatable.locales');

        return view('admin.dashboard.page_sections.edit', [
            'page'      => $page,
            'config'    => $config,
            'pageLabel' => $this->localized($config['label'] ?? [], $page),
            'siteUrl'   => $this->siteUrl($config),
            'sections'  => $sections,
            'locales'   => $locales,
        ]);
    }

    public function update(Request $request, string $page)
    {
        $config = config("page_sections.$page");

        abort_if(!$config, 404);

        $submitted = (array) $request->input('values', []);
        $locales   = config('translatable.locales');

        foreach ($config['sections'] ?? [] as $sectionKey => $section) {
            $model = PageSection::firstOrCreate(['page' => $page, 'key' => $sectionKey]);

            foreach ($locales as $locale) {
                // Only fields declared in the config are stored, so a crafted
                // request cannot add arbitrary keys to the JSON column.
                $values = [];
                foreach (array_keys($section['fields'] ?? []) as $field) {
                    $value = $submitted[$sectionKey][$locale][$field] ?? null;

                    if (is_string($value) && trim($value) !== '') {
                        $values[$field] = trim($value);
                    }
                }

                PageSectionTranslation::updateOrCreate(
                    ['page_section_id' => $model->id, 'locale' => $locale],
                    ['values' => $values]
                );
            }
        }

        PageSectionRepository::getInstance()->forget($page);

        session()->flash('success', trans('message.admin.updated_sucessfully'));

        return redirect()->route('admin.page-sections.edit', $page);
    }

    /**
     * Restore a single section to the defaults declared in the config.
     */
    public function reset(string $page, string $section)
    {
        abort_if(!config("page_sections.$page.sections.$section"), 404);

        PageSection::forPage($page)->where('key', $section)->get()
            ->each(function (PageSection $model) {
                $model->trans()->delete();
                $model->delete();
            });

        PageSectionRepository::getInstance()->forget($page);

        session()->flash('success', trans('message.admin.updated_sucessfully'));

        return redirect()->route('admin.page-sections.edit', $page);
    }

    private function localized(array $values, string $fallback): string
    {
        return $values[app()->getLocale()]
            ?? $values[config('app.fallback_locale')]
            ?? $fallback;
    }

    private function siteUrl(array $config): ?string
    {
        $route = $config['route'] ?? null;

        return $route && \Illuminate\Support\Facades\Route::has($route) ? route($route) : null;
    }
}
