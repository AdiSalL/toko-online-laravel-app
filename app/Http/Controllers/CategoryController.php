<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $filterKeyword = $request->get("name");
        if($filterKeyword) {
            $categories = Category::where("name", "LIKE", "%$filterKeyword%")->paginate(10);
        }else {
            $categories = Category::paginate(10);
        
        }
        return view("categories.index", [
            "categories" => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $user = Auth::user();
        $name = $request->get("name");
        $category = new Category();
        $category->name = $name;
        $category->created_by = $user->id;
        $category->slug = Str::slug($name, "-");
        if($request->file("image")) {
            $imagePath = $request->file("image")->store("category", "public");
            $category->image = $imagePath;
        }
        $category->save();
        return redirect()->route("categories.create")->with("status", "Category succesfully created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $category = Category::findOrFail($id);
        return view("categories.show", ["category" => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $category = Category::findOrFail($id);
        return view("categories.edit", [
            "category" => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $name = $request->get("name");
        $slug = $request->get("slug");
        $category = Category::findOrFail($id);

        $category->name = $name;
        $category->slug = $slug;

        if($request->file("image")) {
            if($category->image && file_exists(storage_path("app/public/" . $category->image))) {
                Storage::delete("public/" . $category->image);
            }
            $newImage = $request->file("image")->store("category", "public");
            $category->image = $newImage;
        }
        $category->updated_by = Auth::user()->id;
        $category->slug = Str::slug($name);
        $category->save();  
        return redirect()->route("categories.edit", [$id])->with("status", "Category successfully update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route("categories.index")->with("status", "Category successfully moved to trash");
    }

    public function trash() {
        $categories = Category::onlyTrashed()->paginate(10);
        return view("categories.trash", [
            "categories" => $categories
        ]);
    }

    public function restore($id) {
        $category = Category::withTrashed()->findOrFail($id);
        if($category->trashed()) {
            $category->restore();
        }else {
            return redirect()->route("categories.index")
            ->with("status", "Category is not in trash");
        }
        return redirect()->route("categories.index")
        ->with("status", "Category successfully restored");
    }

    public function deletePermanent($id) {
        $category = Category::withTrashed()->findOrFail($id);

        if(!$category->trashed()) {
            return redirect()->route("categories.index")->with("status", "Can't delete permanent active category");
        }else {
            $category->forceDelete();

            return redirect()->route("categories.index")
            ->with("status", "Category permanently deleted");
        }
    }
    public function search(Request $request)
    {
        $search = $request->input('q'); // Search term from Select2
    
        $categories = Category::where('name', 'LIKE', "%$search%")->get();
    
        return response()->json($categories->map(function ($category) {
            return ['id' => $category->id, 'text' => $category->name];
        }));
    }
    
}
