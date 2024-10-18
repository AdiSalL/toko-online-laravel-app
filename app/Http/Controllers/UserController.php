<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $new_user = new \App\Models\User;
        $new_user->name = $request->get('name');
        $new_user->username = $request->get('username');
        $new_user->roles = json_encode($request->get('roles'));
        $new_user->name = $request->get('name');
        $new_user->address = $request->get('address');
        $new_user->phone = $request->get('phone');
        $new_user->email = $request->get('email');
        $new_user->password = Hash::make($request->get('password'));

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
