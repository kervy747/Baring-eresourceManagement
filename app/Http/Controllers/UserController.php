<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request) {
        $query = User::latest();

        if ($request->has('roles') && $request->roles !== 'all') {
            if ($request->roles === 'admin') {
                $query->whereIn('role', ['admin', 'superadmin']);
            } else {
                $query->where('role', $request->roles);
            }
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(10)->withQueryString(); // move here + add withQueryString

        $totalAccounts = User::where('status', 'active')->count();
        $totalUsers = User::where(['role' => 'user', 'status' => 'active'])->count();
        $totalAdmin = User::whereIn('role', ['admin', 'superadmin'])->where('status', 'active')->count();

        return view('users.index', compact('users', 'totalAccounts', 'totalUsers', 'totalAdmin'));
    }

    public function create() {
      return view('users.create');
    }

    public function store() {
      $attributes = request()->validate([
        'fname'=>['required', 'min:2'],
        'lname'=>['required', 'min:2'],
        'email'=>['required', 'email'],
        'role'=>['required'],
        'password'=>['required'],
      ]);

      User::create($attributes);

      return redirect('/users');
    }

    public function edit (User $user) {
      return view('users.edit', ['user'=>$user]);
    }

    public function update(User $user) {
      $attributes = request()->validate([
        'fname'=>['required', 'min:2'],
        'lname'=>['required', 'min:2'],
        'email'=>['required', 'email'],
        'role'=>['required'],
        'status'=>['required']
      ]);

      $user->update($attributes);

      return redirect('/users');
    }
  }

