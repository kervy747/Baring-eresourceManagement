<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{     
    public function index()
    {
      $categories = Category::where('status', 'approved')->get(); 
      $books = Book::where('status','approved')
      ->withCount('downloads')   
      ->when(request('search'), function ($query) {
        $query->where(function ($q) {
          $q->where('title','like','%'.request('search').'%')
          ->orWhere('author','like','%'.request('search').'%');
        });
      })
      ->when(request('catBox')&&request('catBox')!=='all', function ($query) {
        $query->where('category_id', request('catBox'));
      })
      ->latest()->paginate(12)->withQueryString();

      return view('books.index', compact('categories','books'));
    }

    public function pending() {
      if (!auth()->user()->isAdmins()) {
        abort(403, 'Unauthorized');
      }
      
      $categories = Category::whereHas('books', function($query) {
        $query->where('status','pending');
      })->get();

      $books = Book::where('status','pending')
      ->when(request('search'), function ($query) {
        $query->where(function ($q) {
          $q->where('title','like','%'.request('search').'%')
          ->orWhere('author','like','%'.request('search').'%');
        });
      })
      ->when(request('catBox')&&request('catBox')!=='all', function ($query) {
        $query->where('category_id', request('catBox'));
      })
      ->oldest()->paginate(12)->withQueryString();

      return view('books.pending', compact('categories','books'));
    }

    public function review(Book $book) {
        if(!auth()->user()->isAdmins()) {
          abort(403, 'Unauthorized');
        }

        return view('books.review', compact('book'));
    }

    public function approve(Book $book) {
        $attributes = request()->validate([
            'status' => ['required', 'in:approved,rejected'],
            'rejection_reason' => ['nullable', 'max:500']
        ]);

        $book->update($attributes);

        return redirect('/books/pending');
    }

    public function show(Book $book) {
        $hasPurchased = \App\Models\Transaction::where('user_id', auth()->id())
        ->where('book_id', $book->id)
        ->where('status', 'completed')
        ->exists();

        $book->loadCount('downloads');
        return view('books.show', compact('book', 'hasPurchased'));
    }
    
    public function create(){
      $categories = Category::where('status', 'approved')->get();
      return view('books.create', ['categories'=>$categories]);
    }

    public function store()
    {
      $attributes = request()->validate([
        'title'=>['required', 'min:5', 'max:255'],
        'author'=>['required', 'min:2'],
        'category_id'=>['required'],
        'access_type'=>['required'],
        'price'=>['nullable'],
        'cover_image'=>['required', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'file'=>['required', 'mimes:pdf', 'max:10240'],
        'description'=>['nullable']
            ], [
          'file.max' => 'File size must not exceed 10MB.',
          'cover_image.max' => 'Image size must not exceed 2MB.',
      ]);

      $attributes['cover_image'] = request()->file('cover_image')->store('covers', 'public');

      $attributes['file_path'] = request()->file('file')->store('uploads', 'public');
      unset($attributes['file']);

      $attributes['user_id'] = auth()->id();

      $attributes['status'] =
          auth()->user()->isAdmins()
          ? 'approved'
          : 'pending';

      Book::create($attributes);

      return redirect('/books',);
    }

    public function edit(Book $book) {
        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }

        $categories = Category::all();
        return view('books.edit', compact('book','categories'));
    }

    public function update(Book $book) {
        if (!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $attributes = request()->validate([
          'title'=>['required', 'min:5', 'max:255'],
          'author'=>['required', 'min:2'],
          'category_id'=>['required'],
          'access_type'=>['required'],
          'price'=>['nullable'],
          'description'=>['nullable']
          ]);

        $book->update($attributes);

        if ($book->status === 'pending') {
            return redirect('/books/' . $book->id . '/review');
        }

        return redirect('/books/'. $book->id);
    }

    // TBS
    public function download(Book $book)
    {
        
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'book_id'     => $book->id,
            'action'      => 'downloaded',
            'description' => auth()->user()->fname . ' downloaded ' . $book->title,
        ]);

        return Storage::disk('public')->download($book->file_path);
    }

    
}
