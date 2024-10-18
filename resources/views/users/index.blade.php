@extends("layouts.global")

@section("title") Users list @endsection

@section("content")
@if(session('status'))
    <div class="alert alert-success">
        {{session('status')}}
    </div>
@endif
<div class="row mb-3">
    <div class="col-md-6">
    <form action="{{route('users.index')}}" method="GET">
    <div class="input-group">
        <!-- Keyword input for search -->
        <input 
            value="{{Request::get('keyword')}}"
            name="keyword"
            class="form-control"
            type="text"
            placeholder="Enter email to filter..." />

        <div class="input-group-append">
            <input type="submit" value="Search" class="btn btn-primary">
        </div>
    </div>

    <!-- Radio buttons for status filtering -->
    <div class="mt-2">
        <input 
            {{Request::get('status') == 'ACTIVE' ? 'checked' : ''}} 
            value="ACTIVE"
            name="status"
            type="radio"
            id="active">
        <label for="active">Active</label>

        <input 
            {{Request::get('status') == 'INACTIVE' ? 'checked' : ''}} 
            value="INACTIVE"
            name="status"
            type="radio"
            id="inactive">
        <label for="inactive">Inactive</label>
    </div>
</form>


    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('users.create')}}" class="btn btn-primary">
            Create User
        </a>    
    </div>
</div>

<table class="table table-bordered">
<thead>
<tr>
    <th><b>Name</b></th>
    <th><b>Username</b></th>
    <th><b>Email</b></th>
    <th><b>Avatar</b></th>
    <th><b>Status</b></th>
    <th><b>Action</b></th>
</tr>
</thead>
<tbody>

@foreach($users as $user)
<tr>
    <td>{{$user->name}}</td>
    <td>{{$user->username}}</td>
    <td>{{$user->email}}</td>
    <td>
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" width="70px"/>
        @else
            N/A
        @endif
    </td>
    <td>
        @if($user->status == "ACTIVE") 
        <span class="badge badge-success">{{$user->status}}</span>
        @else
        <span class="badge badge-danger">{{$user->status}}</span>
        @endif
    </td>
    <td>
        <a href="{{route('users.edit', [$user->id])}}" class="btn btn-info text-white btn-sm">Edit</a>
        <a href="{{route('users.show', [$user->id])}}" class="btn btn-primary btn-sm">Detail</a>
        <form action="{{route('users.destroy', [$user->id])}}" class="d-inline" onsubmit="return confirm('delete this user?')" method="post">
            @csrf
            <input type="hidden" name="_method" value="DELETE">
            <input type="submit" value="Delete" class="btn btn-danger btn-sm">
        </form>
    </td>
</tr>
</tbody>
<tfoot>
    <tr>
        <td colspan=10>
            {{$users->appends(Request::all())->links()}}
        </td>
    </tr>
</tfoot>
@endforeach
</table>
@endsection
