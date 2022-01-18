<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Palette;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    function __construct() {}

    public function index() {
        $users = User::all();

        return response()->json($users); 
    }

    public function show(Request $request, $id) {
        $user = User::find($id);

        return response()->json($user);
    }

    public function create(Request $request) {
        return view("user.create");
    }

    public function store(Request $request) {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        return response()->json([
            "data" => $user,
            "message" => "User created"
        ]);
    }

    public function edit(Request $request, $id) {
        $user = User::find($id);

        return view("user.edit")->with("user", $user);
    }

    public function update(Request $request, $id) {
        $user = User::find($id)->update($request->all());
        
        return response()->json([
            "data" => $user,
            "message" => "User updated"
        ]);
    }

    public function destroy(Request $request, $id) {
        try {
            Palette::where('id-user', $id)->delete();

            User::find($id)->delete();
            
            return response()->json([
                "data" => true,
                "message" => "User deleted"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "data" => false,
                "message" => "User could not be deleted"
            ], 400);
        }
    }

    public function authenticate(Request $request) {
        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json([
                "message" => "User doesn't exist"
            ], 404); 
        } 

        if(!Hash::check($request->password, $user->password)) {
            return response()->json([
                "message" => "Wrong password"
            ], 401);
        }

        $token = $user->createToken($user->id . Carbon::now()->format("YmdHis"));

        return response()->json([
            "data" => [
                "token" => $token->plainTextToken
            ]
        ]);
    }
}
