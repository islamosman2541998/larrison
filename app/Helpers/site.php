<?php

use App\Models\Pages;
use App\Models\Settings;


if (!function_exists('SETTING_SITE')) {
    function SETTING_SITE($key = false){
        $setting = @Settings::query()->where('key', 'site_setting')->get()->first();
        if($setting != null){
            return  @$setting->values->where('key', $key)->first()->value;
        }
        else return "";
    }
}


if (!function_exists('MULTIPLE_SETTING_SITE')) {
    function MULTIPLE_SETTING_SITE($arr_key = false){
        $setting = @Settings::query()->where('key', 'site_setting')->get()->first();
        if($setting != null){
            return  @$setting->values->whereIn('key', $arr_key)->pluck('value' , 'key' );
        }
        else return "";
    }
}



if (!function_exists('getPages')) {
    function getPages($id = null) {
        if($id == ''){
            $pages = @Pages::query()->with('trans')->where('id','>',1)->Active()->get();
        }
        else{
            $pages = @Pages::query()->with('trans')->whereId($id)->first();
        }
        return $pages ;
    }
}


if (!function_exists('no_image_path')) {
    /**
     * Fallback image used whenever a record has no picture (or the uploaded
     * file is missing on disk).
     *
     * `/public/attachments` is git-ignored, so the old
     * `/attachments/no_image/no_image.png` placeholder never reaches the
     * server and every empty record rendered a broken image. This asset is
     * versioned with the code instead.
     */
    function no_image_path(): string
    {
        return '/images/no-image.svg';
    }
}


if (!function_exists('page_text')) {
    /**
     * Editable static text of a page section, managed from
     * Dashboard > Settings > Page sections.
     *
     * Usage: page_text('contact.side.title')
     *
     * Falls back to the active locale's stored value, then the fallback
     * locale, then the default declared in config/page_sections.php.
     */
    function page_text(string $path, ?string $locale = null): string
    {
        [$page, $section, $field] = array_pad(explode('.', $path, 3), 3, null);

        if (!$page || !$section || !$field) {
            return '';
        }

        return \App\Support\PageSectionRepository::getInstance()
            ->get($page, $section, $field, $locale);
    }
}


if (!function_exists('asset_v')) {
    /**
     * Asset URL with an automatic cache-busting version.
     *
     * The version is the file's last-modified time, so every deploy that
     * actually changes a file also changes its URL. A hand written
     * ?v=0.0.11 (or no version at all, as main.js had) leaves visitors on a
     * stale copy after a release, which looks exactly like the change never
     * happened.
     */
    function asset_v(string $path): string
    {
        $full = public_path($path);
        $version = is_file($full) ? filemtime($full) : null;

        return asset($path) . ($version ? '?v=' . $version : '');
    }
}