<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use App\Models\Site;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $client = $user->client;
        $activityLogs = ActivityLog::where('subject_type', Site::class)
            ->whereHasMorph(
                'subject',
                [Site::class],
                function ($query) use ($user) {
                    $query->where('client_id', $user->client_id);
                }
            )
            ->with('user')
            ->latest()
            ->limit(10)
            ->get();
        return view('dashboard', compact('user', 'client', 'activityLogs'));
    }
}
