<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $query = Book::with(['category'])
                ->where('user_id', auth()->id()); // Only get books for the logged-in user

            return DataTables::of($query)
                ->addColumn('action', function ($book) {
                    return '
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="' . route('books.edit', $book->id) . '" class="btn btn-warning">Edit</a>
                            <form action="' . route('books.destroy', $book->id) . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this book?\');">
                                ' . method_field('DELETE') . csrf_field() . '
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view("pages.book.index");
    }

    public function create()
    {
        $categories = Auth::user()->categories;
        return view("pages.book.create", ["categories" => $categories]);
    }
}
