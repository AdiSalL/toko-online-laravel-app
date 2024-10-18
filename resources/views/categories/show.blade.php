@extends("layouts.global")

@section("title")
    Detail Category
@endsection

@section("content")
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <label for=""><b>Category Name</b></label>
                {{$category->name}}
                <br><br>
                <label for=""><b>Category Slug</b></label>
                {{$category->slug}}
                <br><br>
                <label for=""><b>Category Image</b></label>
                @if($category->image)
                <img src="{{asset('storage/' . $category->image)}}" width="120px" alt="">
                @endif
                <br><br>
            </div>
        </div>
    </div>
@endsection