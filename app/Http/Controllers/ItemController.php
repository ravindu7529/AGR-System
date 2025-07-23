<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return response()->json(['items' => $items]);
    }
    public function show($id)
    {
        $item = Item::findOrFail($id);
        return response()->json(['item' => $item]);
    }
    // Only admin can access (add middleware as needed)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'points' => 'required|integer|min:1',
        ]);
        $item = Item::create($request->only('name', 'points'));
        return response()->json([
            'success' => true,  // Make sure this is exactly 'success' => true
            'message' => 'Item created successfully',
            'item' => $item
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        $request->validate([
            'name' => 'required|string',
            'points' => 'required|integer|min:1',
        ]);
        $item->update($request->only('name', 'points'));
        return response()->json([
            'success' => true,
            'item' => $item, 
            'message' => 'Item updated!'
        ]);
    }
    
    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();
        return response()->json(['message' => 'Item deleted!']);
    }
}
