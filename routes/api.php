<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user/data', function (Request $request) {
    return response()->json($request->user());
});

Route::get("/", function(Request $request) {
    return response()->json($request->all());
});

Route::post("/auth/token", [UserController::class, "authenticate"]);

Route::resource("user", UserController::class);