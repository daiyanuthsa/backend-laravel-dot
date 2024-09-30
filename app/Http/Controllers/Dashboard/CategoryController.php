<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $categories = Auth::user()->categories; // Only get category for the logged-in user

            return DataTables::of($categories)
                ->addColumn('action', function ($item) {
                    return '
                    <div class="dropdown">
                        <a href="#" class="btn btn-primary dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                        Action
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="' . route('category.edit', $item->id) . '">Edit</a>

                            <form action="' . route('category.delete', $item->id) . '" method="POST">
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

        return view("pages.category.index");
    }

    public function create()
    {
        return view("pages.category.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();

        Category::create($validated);
        return redirect()->route('category.index');
    }

    public function edit(string $id)
    {
        $category = Category::findOrFail($id);

        // Check if the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pages.category.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        // Check if the category belongs to the authenticated user
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Category::findOrFail($id);
        $item->delete();

        return redirect()->route('category.index')->with('success', 'Book deleted successfully.');
    }
}
