<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebPage;

class WebPageController extends Controller
{
    public function index()
    {
        return WebPage::orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'html_content' => 'required|string',
        ]);

        return WebPage::create($request->only('title', 'html_content'));
    }

    public function show($id)
    {
        return WebPage::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'html_content' => 'required|string',
        ]);

        $page = WebPage::findOrFail($id);
        $page->update($request->only('title', 'html_content'));

        return $page;
    }

    public function destroy($id)
    {
        $page = WebPage::findOrFail($id);
        $page->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
