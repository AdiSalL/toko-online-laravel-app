<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::resource("users", UserController::class);

Route::get("/categories/trash", [CategoryController::class, "trash"])->name("categories.trash");
Route::get("/categories/{id}/restore", [CategoryController::class, "restore"])->name("categories.restore");
Route::delete("/categories/{category}/delete-permanent", [CategoryController::class, "deletePermanent"])->name("categories.delete-permanent");
Route::get("/ajax/categories/search", [CategoryController::class, "search"]);
Route::get("/books/trash", [BookController::class, "trash"])->name("books.trash");
Route::post("/books/{book}/restore", [BookController::class, "restore"])->name("books.restore");
Route::delete("/books/{id}/delete-permanent", [BookController::class, "deletePermanent"])->name("books.delete-permanent");

Route::resource("categories", CategoryController::class);
Route::resource("books", BookController::class);


Route::resource("orders", OrderController::class);

Route::group(["prefix" => "category"], function (){
    Route::get("all", [CategoryController::class, "index"]);
    Route::get("search", [CategoryController::class, "search"]);
    Route::get("delete/{id}", [CategoryController::class, "delete"]);
    Route::get("restore/{id}", [CategoryController::class, "restore"]);
    Route::get("permanent-delete/{id}", [CategoryController::class, "permanentDelete"]);
    Route::view("layouts", "child");
});
Auth::routes();
Route::match(["GET", "POST"], "/register", function () {
    return redirect("/login");
})->name("register");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
