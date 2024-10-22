@extends('layouts.global')

@section('title') Edit Book @endsection

@section('content')
<div class="row">
    <div class="col-md-8">
        @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <form enctype="multipart/form-data" method="POST" action="{{ route('books.update', [$book->id]) }}" class="p-3 shadow-sm bg-white">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            
            <!-- Title -->
            <label for="title">Title</label>
            <input type="text" class="form-control {{ $errors->first('title') ? 'is-invalid' : '' }}" value="{{ old('title', $book->title) }}" name="title" placeholder="Book title">
            <div class="invalid-feedback">{{ $errors->first('title') }}</div>
            <br>

            <!-- Cover -->
            <label for="cover">Cover</label><br>
            <small class="text-muted">Current cover</small><br>
            @if($book->cover)
                <img src="{{ asset('storage/' . $book->cover) }}" width="96px"/>
            @endif
            <br><br>
            <input type="file" class="form-control {{ $errors->first('cover') ? 'is-invalid' : '' }}" name="cover">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah cover</small>
            <div class="invalid-feedback">{{ $errors->first('cover') }}</div>
            <br><br>

            <!-- Slug -->
            <label for="slug">Slug</label>
            <input type="text" class="form-control {{ $errors->first('slug') ? 'is-invalid' : '' }}" value="{{ old('slug', $book->slug) }}" name="slug" placeholder="enter-a-slug">
            <div class="invalid-feedback">{{ $errors->first('slug') }}</div>
            <br>

            <!-- Description -->
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control {{ $errors->first('description') ? 'is-invalid' : '' }}">{{ old('description', $book->description) }}</textarea>
            <div class="invalid-feedback">{{ $errors->first('description') }}</div>
            <br>

            <!-- Categories -->
            <label for="categories">Categories</label>
            <select class="form-control {{ $errors->first('categories') ? 'is-invalid' : '' }}" name="categories[]" id="categories" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (collect(old('categories', $book->categories->pluck('id')->toArray()))->contains($category->id)) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback">{{ $errors->first('categories') }}</div>
            <br><br>

            <!-- Stock -->
            <label for="stock">Stock</label>
            <input type="text" class="form-control {{ $errors->first('stock') ? 'is-invalid' : '' }}" placeholder="Stock" id="stock" name="stock" value="{{ old('stock', $book->stock) }}">
            <div class="invalid-feedback">{{ $errors->first('stock') }}</div>
            <br>

            <!-- Author -->
            <label for="author">Author</label>
            <input placeholder="Author" value="{{ old('author', $book->author) }}" type="text" id="author" name="author" class="form-control {{ $errors->first('author') ? 'is-invalid' : '' }}">
            <div class="invalid-feedback">{{ $errors->first('author') }}</div>
            <br>

            <!-- Publisher -->
            <label for="publisher">Publisher</label>
            <input class="form-control {{ $errors->first('publisher') ? 'is-invalid' : '' }}" type="text" placeholder="Publisher" name="publisher" id="publisher" value="{{ old('publisher', $book->publisher) }}">
            <div class="invalid-feedback">{{ $errors->first('publisher') }}</div>
            <br>

            <!-- Price -->
            <label for="price">Price</label>
            <input type="text" class="form-control {{ $errors->first('price') ? 'is-invalid' : '' }}" name="price" placeholder="Price" id="price" value="{{ old('price', $book->price) }}">
            <div class="invalid-feedback">{{ $errors->first('price') }}</div>
            <br>

            <!-- Status -->
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control {{ $errors->first('status') ? 'is-invalid' : '' }}">
                <option {{ old('status', $book->status) == 'PUBLISH' ? 'selected' : '' }} value="PUBLISH">PUBLISH</option>
                <option {{ old('status', $book->status) == 'DRAFT' ? 'selected' : '' }} value="DRAFT">DRAFT</option>
            </select>
            <div class="invalid-feedback">{{ $errors->first('status') }}</div>
            <br>

            <!-- Submit Button -->
            <button class="btn btn-primary" value="PUBLISH">Update</button>
        </form>
    </div>
</div>
@endsection

@section('footer-scripts')
<!-- Select2 Stylesheet -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<!-- Select2 Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $('#categories').select2();
</script>
@endsection
