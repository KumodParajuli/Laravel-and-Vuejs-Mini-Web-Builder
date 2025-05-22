<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\PageBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageBannerController extends Controller
{
    public function show($pageId)
    {
        return PageBanner::where('page_id', $pageId)->first();
    }

    public function store(Request $request)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner = PageBanner::updateOrCreate(
            ['page_id' => $data['page_id']],
            $data
        );

        return response()->json($banner);
    }
}
