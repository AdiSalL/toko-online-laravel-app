<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if(Gate::allows("manage-users")) return $next($request);
            abort(403, "Anda tidak memilliki cukup hak akses");
        });
    }
    
    public function index(Request $request)
    {
        $filteredKeyword = $request->get('keyword');
        $status = $request->get('status');
    
        $users = User::query();
    
        if ($filteredKeyword) {
            $users->where('email', 'LIKE', "%{$filteredKeyword}%");
        }
    
        if ($status) {
            $users->where('status', $status);
        }
    
        $users = $users->paginate(10);
    
        return view('users.index', [
            'users' => $users,
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        //
       $validated =  $request->validate([
            "name" => "required|min:5|max:100",
"username" => "required|min:5|max:20",
"roles" => "required|array",
"phone" => "required|digits_between:10,12",
"address" => "required|min:20|max:200",
"avatar" => "required",
"email" => "required|email",
"password" => "required",
"password_confirmation" => "required|same:password"
        ]);
        $new_user = new \App\Models\User;
        $new_user->name = $validated['name'];
        $new_user->username = $validated['username'];
        $new_user->roles = json_encode($validated['roles']); // Handling roles as a JSON string
        $new_user->address = $validated['address'];
        $new_user->phone = $validated['phone'];
        $new_user->email = $validated['email'];
        $new_user->password = Hash::make($validated['password']);

        if($request->file("avatar")) {
            $file = $request->file("avatar")->store("avatars", "public");
            $new_user->avatar = $file;
        }else {
            $new_user->avatar = null;
        }
        $new_user->save();
        return redirect()->route("users.create")->with("status", "User Successfully created");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::findOrFail($id);
        // dd($user->avatar);
        return view("users.show", [
            "user" => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( string $id)
    {
        //
        $user = User::findOrFail($id);
        return view("users.edit", [
            "user" => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        Validator::make($request->all(), [
            "name" => "required|min:5|max:100",
            "roles" => "required",
            "phone" => "required|digits_between:10,12",
            "address" => "required|min:20|max:200"
        ])->validate();
        $user = User::findOrFail($id);
        $user->name = $request->get("name");
        $user->roles = json_encode($request->get("roles"));
        $user->address = $request->get("address");
        $user->phone = $request->get("phone");
        $user->status = $request->get("status");
        if($request->file("avatar")){
            if($user->avatar && file_exists(storage_path("app/public/storage/avatars/" . $user->avatar))){
                Storage::delete("public/" . $user->avatar);
            }
            $file = $request->file("avatar")->store("avatars", "public");
            $user->avatar = $file;
        }
        $user->save();
        return redirect()->route("users.show", $id)->with("status", "User Succesfully updated");
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route("users.index")->with("status", "User successfully deleted");
    }

    public function deletePermanent($id) {
        
    }
}
