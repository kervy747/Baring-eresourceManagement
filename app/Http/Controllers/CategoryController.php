<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
  public function index() {
      $search = request('search');
  
      $categories = Category::where('status', 'approved')
          ->when($search, fn($query) => $query->where('name', 'like', "%{$search}%"))
          ->latest()
          ->paginate(20);

      return view('categories.index', ['categories' => $categories]);
  }

  public function pending() {
    $categories = Category::where('status', 'pending')->oldest()-> paginate(20);
      return view('categories.pending', ['categories' => $categories]);
  }

  public function create() {
    return view('categories.create');
  }

  public function store() {
    $attributes = request()->validate([
        'name' => ['required', 'min:3'],
    ]);

    $attributes['requested_by'] = auth()->id();
    $attributes['status'] = auth()->user()->isAdmins() ? 'approved' : 'pending';

    Category::create($attributes);

    return redirect('/categories');
  } 

  public function edit(Category $category) {
    return view('categories.edit', ['category' => $category]);
  }

  public function update(Category $category) {
    request()->validate([
      'name'=>['required', 'min:3'], 
    ]);

    $category->update([
      'name'=>request('name'),
    ]);

    return redirect('/categories');
  }

  public function destroy(Category $category) {
    $category->delete();
    return redirect('/categories');
  }
}
