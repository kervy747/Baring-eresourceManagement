<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
  public function create() {
    return view('auth.register');
  }

  public function store() {
    $validated = request()->validate([
      'fname' => ['required', 'min:3'],
      'lname' => ['required', 'min:2'],
      'email' => ['required', 'email'],
      'password' => ['required', Password::min(5), 'confirmed']
    ]);

    $user = User::create($validated);

    Auth::login($user);

    return redirect('/');
  }
}
