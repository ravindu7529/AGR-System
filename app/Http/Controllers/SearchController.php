<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guide;

class SearchController extends Controller
{
    public function guide(Request $request)
    {
        $query = $request->input('q');

        $guides = Guide::where(function ($qB) use ($query) {
                $qB->whereRaw('LOWER(full_name) LIKE ?', ['%' . strtolower($query) . '%'])
                   ->orWhere('id', $query);
            })
            ->get();

        return response()->json(['guides' => $guides]);
    }
}
