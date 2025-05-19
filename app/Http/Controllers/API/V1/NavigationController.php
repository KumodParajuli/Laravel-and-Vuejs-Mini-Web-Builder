<?php

namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Models\NavigationItem;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        $nav =   NavigationItem::orderBy('order')->get()->toArray();

        $navigation = array_map(function ($item, $index) {
            return [
                'label' => $item['label'],
                'page_id' => $item['page_id'],
                'order' => $index
            ];
        }, $nav, array_keys($nav));

        // Final output structure
        $output = ['navigation' => $navigation];

        // Convert to JSON (if needed)
        $jsonOutput = json_encode($output, JSON_PRETTY_PRINT);

        return json_decode($jsonOutput);
    }

    public function store(Request $request)
    {

        $navigation = $request->input('navigation'); // expecting array of items
        // Validate structure
        $request->validate([
            'navigation' => 'required|array',
            'navigation.*.label' => 'required|string|max:255',
            'navigation.*.page_id' => 'required|integer|exists:web_pages,id',
            'navigation.*.order' => 'required|integer'
        ]);

        // Delete all existing navigation items
        NavigationItem::truncate();

        // Insert new navigation items
        foreach ($navigation as $item) {
            NavigationItem::create([
                'label' => $item['label'],
                'page_id' => $item['page_id'],
                'order' => $item['order'],
            ]);
        }

        return response()->json(['message' => 'Navigation updated successfully.'], 200);
    }

    public function update(Request $request, NavigationItem $navigation)
    {
        $navigation->update($request->only(['label', 'url']));
        return $navigation;
    }

    public function destroy(NavigationItem $navigation)
    {
        $navigation->delete();
        return response()->noContent();
    }

    public function reorder(Request $request)
    {
        foreach ($request->navigations as $index => $nav) {
            NavigationItem::where('id', $nav['id'])->update(['order' => $index]);
        }

        return response()->json(['message' => 'Reordered successfully']);
    }
}
