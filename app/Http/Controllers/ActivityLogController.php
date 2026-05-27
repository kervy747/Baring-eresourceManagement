<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ActivityLogController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperadmin()) {
          abort(403);
        }

        $totalBooks      = Book::where('status', 'approved')->count();
        $totalCategories = Category::where('status', 'approved')->count();
        $totalUsers      = User::count();
        $totalDownloads  = ActivityLog::count();

        $now = Carbon::now();

        $booksThisMonth = Book::where('status', 'approved')
            ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->count();

        $usersThisMonth = User::where('status', 'active')
            ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->count();

        $categoriesThisMonth = Category::where('status', 'approved')
            ->whereBetween('created_at', [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()])
            ->count();

        $downloadsThisMonth = ActivityLog::whereBetween('created_at', [
            $now->copy()->startOfMonth(),
            $now->copy()->endOfMonth(),
        ])->count();

        // ── Bar Chart: last 6 months of activity ─────────────────────────
        // Builds an array like: [['month' => 'Dec', 'count' => 12], ...]
        $monthlyActivity = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = Carbon::now()->subMonths($monthsAgo);

            $count = ActivityLog::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();

            return [
                'month' => $date->format('M Y'),
                'count' => $count,
            ];
        })->values()->toArray();

        $actionBreakdown = ActivityLog::select('action', DB::raw('count(*) as count'))
            ->groupBy('action')
            ->orderByDesc('count')
            ->get()
            ->map(fn($row) => ['action' => $row->action, 'count' => $row->count])
            ->toArray();

        $recentLogs = ActivityLog::with(['user', 'book'])
            ->latest('created_at')
            ->paginate(10);

        return view('activity.index', compact(
            'totalBooks',
            'totalCategories',
            'totalUsers',
            'totalDownloads',
            'booksThisMonth',
            'usersThisMonth',
            'downloadsThisMonth',
            'categoriesThisMonth',
            'monthlyActivity',
            'actionBreakdown',
            'recentLogs',
        ));
    }

    public function exportPdf()
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperadmin()) {
            abort(403);
        }
        
        $now = Carbon::now();

        $totalBooks      = Book::where('status', 'approved')->count();
        $totalCategories = Category::where('status', 'approved')->count();
        $totalUsers      = User::count();
        $totalDownloads  = ActivityLog::count();

        $monthlyActivity = collect(range(5, 0))->map(function ($monthsAgo) {
            $date  = Carbon::now()->subMonths($monthsAgo);
            $count = ActivityLog::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            return ['month' => $date->format('M Y'), 'count' => $count];
        })->values();

        $actionBreakdown = ActivityLog::select('action', DB::raw('count(*) as count'))
            ->groupBy('action')
            ->orderByDesc('count')
            ->get();

        $allLogs = ActivityLog::with(['user', 'book'])->latest('created_at')->get();

        $pdf = Pdf::loadView('activity.pdf_report', compact(
            'totalBooks', 'totalCategories', 'totalUsers', 'totalDownloads',
            'monthlyActivity', 'actionBreakdown', 'allLogs', 'now'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('activity-report-' . $now->format('Y-m-d') . '.pdf');
    }
}