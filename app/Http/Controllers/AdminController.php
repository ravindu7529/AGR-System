<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\Guide;
use App\Models\Visit;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = \App\Models\Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json([
            'message' => 'Admin created successfully',
            'admin' => $admin,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function addItem(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $item = \App\Models\Item::create($validated);

        return response()->json([
            'message' => 'Item added successfully',
            'item' => $item,
        ], 201);
    }
    public function getDashboardStats()
    {
        $guideCount = \App\Models\Guide::count();
        $visitCount = \App\Models\Visit::count();
        $monthlyVisitCount = \App\Models\Visit::whereMonth('created_at', now()->month)->count();
        $performance = $this->calculateSystemPerformance();
        $guides = Guide::with(['visits', 'redemptions'])
        ->withCount('visits')
        ->withSum('redemptions', 'points')
        ->get();

        return response()->json([
            'guideCount' => $guideCount,
            'visitCount' => $visitCount,
            'monthlyVisitCount' => $monthlyVisitCount,
            'touristCount' => Visit::sum('pax_count'),
            'monthlyTouristCount' => Visit::whereMonth('created_at', now()->month)->sum('pax_count'),
            'monthlyNewGuides' => Guide::whereMonth('created_at', now()->month)->count(),
            'performance' => $performance,
            'guides' => $guides
        ]);
    }

    // Add this new method to calculate real performance
private function calculateSystemPerformance()
{
    try {
        // Get current month data
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();
        
        // 1. Guide Activity Score (30% weight)
        $activeGuides = Guide::whereHas('visits', function ($query) use ($currentMonth) {
            $query->whereMonth('created_at', $currentMonth->month)
                  ->whereYear('created_at', $currentMonth->year);
        })->count();
        
        $totalGuides = Guide::count();
        $guideActivityScore = $totalGuides > 0 ? ($activeGuides / $totalGuides) * 100 : 0;
        
        // 2. Tourist Growth Score (25% weight)
        $currentMonthTourists = Visit::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->sum('pax_count');
            
        $lastMonthTourists = Visit::whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('pax_count');
            
        $touristGrowthScore = 85; // Default base score
        if ($lastMonthTourists > 0) {
            $growthRate = (($currentMonthTourists - $lastMonthTourists) / $lastMonthTourists) * 100;
            $touristGrowthScore = max(0, min(100, 85 + ($growthRate * 2))); // Scale growth rate
        }
        
        // 3. Visit Frequency Score (20% weight)
        $currentMonthVisits = Visit::whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();
            
        $avgTouristsPerVisit = $currentMonthVisits > 0 ? $currentMonthTourists / $currentMonthVisits : 0;
        $visitFrequencyScore = min(100, ($avgTouristsPerVisit / 5) * 100); // Assuming 5 is ideal avg
        
        // 4. System Utilization Score (15% weight)
        $guidesWithRedemptions = Guide::whereHas('redemptions')->count();
        $systemUtilizationScore = $totalGuides > 0 ? ($guidesWithRedemptions / $totalGuides) * 100 : 0;
        
        // 5. Consistency Score (10% weight)
        $recentMonthsVisits = Visit::where('created_at', '>=', Carbon::now()->subMonths(3))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as visit_count')
            ->groupBy('month')
            ->pluck('visit_count')
            ->toArray();
            
        $consistencyScore = 90; // Default
        if (count($recentMonthsVisits) > 1) {
            $avg = array_sum($recentMonthsVisits) / count($recentMonthsVisits);
            $variance = array_sum(array_map(function($x) use ($avg) { return pow($x - $avg, 2); }, $recentMonthsVisits)) / count($recentMonthsVisits);
            $consistencyScore = max(50, 100 - ($variance / $avg * 10)); // Lower variance = higher consistency
        }
        
        // Calculate weighted final score
        $finalScore = 
            ($guideActivityScore * 0.30) +
            ($touristGrowthScore * 0.25) +
            ($visitFrequencyScore * 0.20) +
            ($systemUtilizationScore * 0.15) +
            ($consistencyScore * 0.10);
        
        return round($finalScore) . '%';
        
    } catch (\Exception $e) {
        // Fallback to a reasonable default
        return '85%';
    }
}
    public function generatePDFReport(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m', $request->date);
            
            $data = [
                'guides' => Guide::whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year)
                                ->get(),
                'visits' => Visit::whereMonth('created_at', $date->month)
                                ->whereYear('created_at', $date->year)
                                ->with('guide')
                                ->get(),
                'totalTourists' => Visit::whereMonth('created_at', $date->month)
                                       ->whereYear('created_at', $date->year)
                                       ->sum('pax_count'),
                'month' => $date->format('F Y')
            ];

            $pdf = PDF::loadView('admin.reports.monthly', $data);
            
            return $pdf->download('monthly-report-' . $request->date . '.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate PDF'], 500);
        }
    }

    public function generateExcelReport(Request $request)
    {
        try {
            $date = Carbon::createFromFormat('Y-m', $request->date);
            
            $visits = Visit::whereMonth('created_at', $date->month)
                          ->whereYear('created_at', $date->year)
                          ->with('guide')
                          ->get();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            
            // Headers
            $sheet->setCellValue('A1', 'Date');
            $sheet->setCellValue('B1', 'Guide Name');
            $sheet->setCellValue('C1', 'Tourist Count');
            
            // Data
            $row = 2;
            foreach ($visits as $visit) {
                $sheet->setCellValue('A' . $row, $visit->created_at->format('Y-m-d'));
                $sheet->setCellValue('B' . $row, $visit->guide->full_name);
                $sheet->setCellValue('C' . $row, $visit->pax_count);
                $row++;
            }
            
            $writer = new Xlsx($spreadsheet);
            
            $fileName = 'monthly-report-' . $request->date . '.xlsx';
            $tempFile = tempnam(sys_get_temp_dir(), $fileName);
            $writer->save($tempFile);
            
            return response()->download($tempFile, $fileName)->deleteFileAfterSend();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate Excel file'], 500);
        }
    }

    public function getGuides()
    {
        $guidesnew = Guide::with(['visits', 'redemptions'])
            ->withCount('visits')
            ->withSum('redemptions', 'points')
            ->get();

        return response()->json(['guides' => $guidesnew]);
    }


    // Helper methods for detailed breakdown
private function getGuideActivityScore()
{
    $currentMonth = Carbon::now();
    $activeGuides = Guide::whereHas('visits', function ($query) use ($currentMonth) {
        $query->whereMonth('created_at', $currentMonth->month)
              ->whereYear('created_at', $currentMonth->year);
    })->count();
    
    $totalGuides = Guide::count();
    return $totalGuides > 0 ? round(($activeGuides / $totalGuides) * 100) : 0;
}

private function getTouristGrowthScore()
{
    $currentMonth = Carbon::now();
    $lastMonth = Carbon::now()->subMonth();
    
    $currentMonthTourists = Visit::whereMonth('created_at', $currentMonth->month)
        ->whereYear('created_at', $currentMonth->year)
        ->sum('pax_count');
        
    $lastMonthTourists = Visit::whereMonth('created_at', $lastMonth->month)
        ->whereYear('created_at', $lastMonth->year)
        ->sum('pax_count');
        
    if ($lastMonthTourists > 0) {
        $growthRate = (($currentMonthTourists - $lastMonthTourists) / $lastMonthTourists) * 100;
        return max(0, min(100, round(85 + ($growthRate * 2))));
    }
    
    return 85;
}

private function getVisitFrequencyScore()
{
    $currentMonth = Carbon::now();
    $currentMonthVisits = Visit::whereMonth('created_at', $currentMonth->month)
        ->whereYear('created_at', $currentMonth->year)
        ->count();
        
    $currentMonthTourists = Visit::whereMonth('created_at', $currentMonth->month)
        ->whereYear('created_at', $currentMonth->year)
        ->sum('pax_count');
        
    $avgTouristsPerVisit = $currentMonthVisits > 0 ? $currentMonthTourists / $currentMonthVisits : 0;
    return min(100, round(($avgTouristsPerVisit / 5) * 100));
}

private function getSystemUtilizationScore()
{
    $totalGuides = Guide::count();
    $guidesWithRedemptions = Guide::whereHas('redemptions')->count();
    return $totalGuides > 0 ? round(($guidesWithRedemptions / $totalGuides) * 100) : 0;
}

private function getConsistencyScore()
{
    $recentMonthsVisits = Visit::where('created_at', '>=', Carbon::now()->subMonths(3))
        ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as visit_count')
        ->groupBy('month')
        ->pluck('visit_count')
        ->toArray();
        
    if (count($recentMonthsVisits) > 1) {
        $avg = array_sum($recentMonthsVisits) / count($recentMonthsVisits);
        $variance = array_sum(array_map(function($x) use ($avg) { return pow($x - $avg, 2); }, $recentMonthsVisits)) / count($recentMonthsVisits);
        return max(50, round(100 - ($variance / $avg * 10)));
    }
    
    return 90;
}
}



