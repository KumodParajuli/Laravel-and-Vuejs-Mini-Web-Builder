<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\Auth\UpdateSettingRequest;
use App\Models\WebPage;
use App\Models\WebsiteSetting;

class WebsiteSettingController extends Controller
{
    public function index()
    {
        // return 1;
        return WebsiteSetting::first();
    }

    public function update(UpdateSettingRequest $request)
    {
        $settings = WebsiteSetting::first() ?? new WebsiteSetting();

        $settings->fill($request->validated());
        $settings->save();
        return response()->json($settings);
    }

    public function pages()
    {
        return WebPage::all();
    }
}
