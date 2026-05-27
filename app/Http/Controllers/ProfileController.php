<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Book;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }

    public function requests(Request $request)
    {
        $status = $request->get('status', 'all');
        $type   = $request->get('type', 'books');

        if ($type === 'categories') {
            $query = \App\Models\Category::where('requested_by', auth()->id());
            if ($status !== 'all') {
                $query->where('status', $status);
            }
            $items = $query->latest()->paginate(5);
        } else {
            $query = \App\Models\Book::where('user_id', auth()->id())->with('category');
            if ($status !== 'all') {
                $query->where('status', $status);
            }
            $items = $query->latest()->paginate(5);
        }

        return view('profile.requests', compact('items', 'status', 'type'));
    }
}