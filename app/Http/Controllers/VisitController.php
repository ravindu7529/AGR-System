<?php
// app/Http/Controllers/VisitController.php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Guide;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'guide_id' => 'required|exists:guides,id',
            'visit_date' => 'required|date',
            'pax_count' => 'required|integer|min:0',
        ]);

        $visit = Visit::create($request->all());

        // Calculate points
        $paxPoints = $request->pax_count * 110;
        $totalPoints = $paxPoints;

        // Find or create redemption for this guide
        $redemption = \App\Models\Redemption::firstOrCreate(
            ['guide_id' => $request->guide_id],
            ['points' => 0]
        );

        // Update points
        $redemption->points += $totalPoints;
        $redemption->save();

        return response()->json([
            'success' => true,
            'message' => 'Visit added.',
            'visit' => $visit,
            'redemption' => $redemption
        ]);
    }

    public function update(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        $visit->update($request->only(['visit_date', 'pax_count']));

        return response()->json([
            'success' => true,
            'message' => 'Visit updated.',
            'visit' => $visit
        ]);
    }

    public function destroy($id)
    {
        Visit::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Visit deleted.'
        ]);
    }
}
