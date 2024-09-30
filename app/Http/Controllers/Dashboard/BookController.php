<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BookController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $book = Book::with(['category']); // Only get books for the logged-in user

            return DataTables::of($book)
                ->addColumn('action', function ($book) {
                    return '
                    <div class="dropdown">
                        <a href="#" class="btn btn-primary dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                        Action
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('book.edit', $book->id) . '">Edit</a>

                            <form action="' . route('book.delete', $book->id) . '" method="POST">
                                ' . method_field('delete') . csrf_field() . '
                            <button class="dropdown-item text-danger" type="submit">Hapus</button>
                            </form>
                        </div>
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'year' => 'required|integer',
            'author' => 'required|string|max:255',
        ]);

        // Verify that the category belongs to the authenticated user
        $category = Category::where('id', $validated['category_id'])
            ->where('user_id', Auth::id())
            ->firstOrFail();

        Book::create($validated);
        return redirect()->route('book');
    }

    public function edit(string $id)
    {
        $book = Book::whereHas('category', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $categories = Auth::user()->categories;

        return view('pages.book.edit', [
            'item' => $book,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::whereHas('category', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'year' => 'sometimes|integer',
            'author' => 'sometimes|string|max:255',
        ]);

        if (isset($validated['category_id'])) {
            // Verify that the new category belongs to the authenticated user
            Category::where('id', $validated['category_id'])
                ->where('user_id', Auth::id())
                ->firstOrFail();
        }

        $book->update($validated);

        return redirect()->route('book')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Book::findOrFail($id);
        $item->delete();

        return redirect()->route('book')->with('success', 'Book deleted successfully.');
    }
}
