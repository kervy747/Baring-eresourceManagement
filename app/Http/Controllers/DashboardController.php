<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Shared data (used in both admin and user/guest views) ─────────
        $totalBooks      = Book::where('status', 'approved')->count();
        $totalCategories = Category::where('status', 'approved')->count();
        $totalUsers      = User::count();
        $totalDownloads  = ActivityLog::count();

        $topCategories = Category::join('books', 'books.category_id', '=', 'categories.id')
            ->join('activity_logs', function ($join) {
                $join->on('activity_logs.book_id', '=', 'books.id')
                    ->where('activity_logs.action', '=', 'downloaded');
            })
            ->selectRaw('categories.id, categories.name, categories.status, categories.description,
                         categories.requested_by, categories.created_at, categories.updated_at,
                         COUNT(activity_logs.id) as downloads_count')
            ->groupBy('categories.id', 'categories.name', 'categories.status', 'categories.description',
                      'categories.requested_by', 'categories.created_at', 'categories.updated_at')
            ->orderByDesc('downloads_count')
            ->take(5)
            ->get();

        // ── Admin-only data ───────────────────────────────────────────────
        $isAdmin = Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isSuperadmin());

        if ($isAdmin) {
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

            $recentActivity = ActivityLog::with(['user', 'book'])
                ->latest('created_at')
                ->take(5)
                ->get();

            $booksByMonth = collect(range(5, 0))->map(function ($month) {
                $date = Carbon::now()->subMonths($month);
                return [
                    'month' => $date->format('M Y'),
                    'count' => Book::where('status', 'approved')
                        ->whereMonth('created_at', $date->month)
                        ->whereYear('created_at', $date->year)
                        ->count(),
                ];
            });

            return view('home', compact(
                'totalBooks', 'totalCategories', 'totalUsers', 'totalDownloads',
                'booksThisMonth', 'usersThisMonth', 'downloadsThisMonth', 'categoriesThisMonth',
                'recentActivity', 'booksByMonth', 'topCategories',
            ));
        }

        // ── User / Guest data ─────────────────────────────────────────────

        // Top 5 most downloaded books (with cover image)
        $topBooks = Book::where('status', 'approved')
            ->join('activity_logs', function ($join) {
                $join->on('activity_logs.book_id', '=', 'books.id')
                    ->where('activity_logs.action', '=', 'downloaded');
            })
            ->selectRaw('books.*, COUNT(activity_logs.id) as downloads_count')
            ->groupBy(
                'books.id', 'books.user_id', 'books.category_id', 'books.title',
                'books.author', 'books.cover_image', 'books.file_path', 'books.description',
                'books.access_type', 'books.price', 'books.status', 'books.rejection_reason',
                'books.created_at', 'books.updated_at'
            )
            ->orderByDesc('downloads_count')
            ->take(5)
            ->get();

        // 5 most recently approved books
        $recentBooks = Book::where('status', 'approved')
            ->latest()
            ->take(5)
            ->get();

        // Current user's recent downloads (empty collection for guests)
        $myDownloads = collect();
        if (Auth::check()) {
            $myDownloads = ActivityLog::with('book')
                ->where('user_id', Auth::id())
                ->where('action', 'downloaded')
                ->latest('created_at')
                ->take(5)
                ->get();
        }

        return view('home', compact(
            'totalBooks', 'totalCategories', 'totalDownloads',
            'topBooks', 'topCategories', 'recentBooks', 'myDownloads',
        ));
    }
}