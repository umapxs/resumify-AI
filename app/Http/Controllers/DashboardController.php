<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resume;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Count total Resumes from database
        $totalResumes = Resume::count();

        // Get the average length in characters for the 'raw texts'
        $averageLength = DB::table('resumes')->selectRaw('ROUND(AVG(LENGTH(input_text))) as average_length')->value('average_length');

        // Get total Resume from database again but save it in a different variable
        $totalSummarizations = Resume::count();

        // Only count the successful ones (the ones with summarized)
        $successfulSummarizations = Resume::whereNotNull('summarized')->count();

        // Calculate the efficiency percentage
        $efficiencyPercentage = 0;

        if ($totalSummarizations > 0) {
            $efficiencyPercentage = ($successfulSummarizations / $totalSummarizations) * 100;
        }

        $efficiencyPercentage = number_format($efficiencyPercentage, 1);

        // Resumify count for today
        $currentDate = Carbon::today();
        $startDate = $currentDate->copy()->subDays(7)->startOfDay();
        $endDate = $currentDate->endOfDay();

        $resumesCount = Resume::whereBetween('created_at', [$startDate, $endDate])->count();

        return view('dashboard', compact('totalResumes', 'averageLength', 'efficiencyPercentage', 'resumesCount'));
    }
}
