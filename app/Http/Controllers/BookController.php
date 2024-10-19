<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $status = $request->get("status");
        $keyword = $request->get("keyword") ? $request->get("keyword") : "";
        if($status) {
            $books = Book::with("categories")->where("status", strtoupper($status))->where("title", "LIKE", "%$keyword%")->paginate(10);
        }else {
            $books = Book::with("categories")->where("title", "LIKE", "%$keyword%")->paginate(10);
        }
        return view("books.index", ["books" => $books]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::all();
        return view("books.create", [
            "categories" => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $book = new Book();
        $book->title = $request->get("title");
        $book->description = $request->get("description");
        $book->author = $request->get("author");
        $book->publisher = $request->get("publisher");
        $book->price = $request->get("price");
        $book->stock = $request->get("stock");
        $book->status = $request->get("save_action");
        $cover = $request->file("cover");
        if($cover) {
            $cover_path = $cover->store("book-covers", "public");
            $book->cover = $cover_path;
        }
        $book->slug = Str::slug($request->get("title"));
        $book->created_by = Auth::user()->id;
        $book->save();
        $book->categories()->attach($request->get("categories"));
        if($request->get("save_action") == "PUBLISH") {
            return redirect()->route("books.index")->with("status", "Book successfullly saved and published");
        }else {
            return redirect()->route("books.index")->with("status", "Book saved as draft");
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $categories = Category::all();
        $book = Book::findOrFail($id);

        return view("books.edit", [
            "book" => $book,
            "categories" => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $book = Book::findOrFail($id);
        $book->title = $request->get("title");
        $book->slug = $request->get('slug');
 $book->description = $request->get('description');
 $book->author = $request->get('author');
 $book->publisher = $request->get('publisher');
 $book->stock = $request->get('stock');
 $book->price = $request->get('price');
 $new_cover = $request->file('cover');
 if($new_cover){
 if($book->cover && file_exists(storage_path('app/public/' . $book->cover))){
 Storage::delete('public/'. $book->cover);
 }
 $new_cover_path = $new_cover->store('book-covers', 'public');
 $book->cover = $new_cover_path;
 }
 $book->updated_by = Auth::user()->id;
 $book->status = $request->get('status');
 $book->save();
 $book->categories()->sync($request->get('categories'));
 return redirect()->route('books.edit', [$book->id])->with('status',
'Book successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route("books.index")->with("status", "Book moved to trash");
    }

    public function trash() {
        $books = Book::onlyTrashed()->paginate(10);
        return view("books.trash", [
            "books" => $books
        ]);
    }

    public function restore($id) {
        $book = Book::withTrashed()->findOrFail($id);

        if($book->trashed()) {
            $book->restore();
            return redirect()->route("books.trash")->with("status", "Book successfully resstored");
        }else {
            return redirect()->route("book.trash")->with("status", "book is not in trash");
        }
    }

    public function deletePermanent($id){
        $book = \App\Models\Book::withTrashed()->findOrFail($id);
        if(!$book->trashed()){
        return redirect()->route('books.trash')->with('status', 'Book is not
        in trash!')->with('status_type', 'alert');
        } else {
        $book->categories()->detach();
        $book->forceDelete();
        return redirect()->route('books.trash')->with('status', 'Book
        permanently deleted!');
        }
        }
}
