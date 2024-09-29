<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $books = Book::whereHas('category', function ($query) {
                $query->where('user_id', Auth::id());
            })->get();

            return response()->json([
                'success' => true,
                'message' => 'Book get successful',
                'data' => $books,
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Books does not exist or does not belong to you.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the book.',
                'error' => $e->getMessage(),
            ], 500);
        }



    }

    public function store(Request $request)
    {
        try {
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

            $book = Book::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Book created successfully',
                'data' => $book,
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The specified category does not exist or does not belong to you.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the book.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
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

            return response()->json([
                'success' => true,
                'message' => 'Book updated successfully',
                'data' => $book,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Book not found or the specified category does not exist or does not belong to you.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the book.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
