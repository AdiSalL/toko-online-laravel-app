@extends("layouts.global")

@section("title") 
Create user
@endsection

@section("content")

    @if(session("status"))
        <div class="alert alert-success">
            {{session("status")}}
        </div>
    @endif

    <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{route('users.store')}}" method="POST">
        @csrf
    

    <label for="name">Name:</label>
    <input type="text" class="form-control" placeholder="Full Name" name="name" id="name"><br>

    <label for="username">Username:</label>
    <input type="text" class="form-control" placeholder="Username" name="username" id="username"><br>
    
    <label for="">Roles</label>
    <br>
    <input type="checkbox" name="roles[]" id="ADMIN" value="ADMIN">
    <label for="ADMIN">Administrator</label>

    <input type="checkbox" name="roles[]" id="STAFF" value="STAFF">
    <label for="STAFF">Staff</label>
    
    
    <input type="checkbox" name="roles[]" id="CUSTOMER" value="CUSTOMER">
    <label for="CUSTOMER">Customer</label>
    <br>

    <label for="phone">Phone number</label>
    <br>
    <input type="text" name="phone" id="phone" >
    <br>
    <label for="address">Address</label>
    <textarea name="address" id="address" class="form-control"></textarea>
    <br>
    <label for="avatar">Avatar Image</label>
    <br>
    <input type="file"
    id="avatar"
    name="avatar"
    class="form-control">
    <hr class="my-3">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" type="text" placeholder="user@mail.com" class="form-control">

    <label for="password">Password</label>
    <input type="password" name="password" id="password" type="text" placeholder="password" class="form-control"><br>

    <label for="password_confirmation">Password Confirmation</label>
    <input type="password"
     class="form-control"
     placeholder="password confirmation"
    id="password_confirmation"
    name="password_confirmation"
     >
     <input type="submit" class="btn btn-primary" value="Save">
     </form>
@endsection