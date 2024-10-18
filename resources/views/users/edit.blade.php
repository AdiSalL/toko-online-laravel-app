@extends("layouts.global")

@section("title") Edit User @endsection

@section("content")
    <form  class="bg-white shadow-sm p-3" action="{{route('users.update', [$user->id])}}" method="POST">
        @csrf
        <input type="hidden" value="PUT" name="_method">
        <input type="text" value="{{$user->name}}" class="form-control" placeholder="Full Name" name="name" id="name">
        <br>
        <label for="">Status</label>
<br/>
<input {{$user->status == "ACTIVE" ? "checked" : ""}}
value="ACTIVE" type="radio"
class="form-control"
id="active"
name="status">
<label for="active">Active</label>
<input {{$user->status == "INACTIVE" ? "checked" : ""}}
value="INACTIVE"
type="radio"
class="form-control"
id="inactive"
name="status">
<label for="inactive">Inactive</label>
<br><br>
    <input type="checkbox" {{in_array("ADMIN", json_decode($user->roles)) ? "checked" : ""}}
    name="roles[]"
    id="ADMIN"
    value="ADMIN">
    <label for="ADMIN">Administrator</label>

    <input type="checkbox" {{in_array("STAFF", json_decode($user->roles)) ? "checked" : ""}}
    name="roles[]"
    id="STAFF"
    value="STAFF">
    <label for="STAFF">Staff</label>

    <input type="checkbox" {{in_array("CUSTOMER", json_decode($user->roles)) ? "checked" : ""}}
    name="roles[]"
    id="CUSTOMER"
    value="CUSTOMER">
    <label for="CUSTOMER">Customer</label>
    <br>
    <br>
    <label for="phone">Phone Number</label>
    <br>
    <input type="text"
    name="phone"
    class="form-control"
    value="{{$user->phone}}">
    <br>
    <label for="address">Address</label>
    <textarea name="address" id="address" class="form-control">
        {{$user->address}}
    </textarea>
    <br>
    <label for="avatar">Avatar Image</label>
    <br>
    Current Avatar:
    <br>
    @if($user->avatar)
    <img src="{{asset('storage/avatars/'. $user->avatar)}}" width="120px" alt="">
    @else
        No avatar
    @endif
    <br>
    <input type="file" name="avatar" id="avatar" class="form-control">
    <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>
    <hr class="my-3">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" value="{{$user->email}}" class="form-control" placeholder="email@email.com" disabled>
    <br>

    <input type="submit" class="btn btn-primary" value="save">
</form>

@endsection