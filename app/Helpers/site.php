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
