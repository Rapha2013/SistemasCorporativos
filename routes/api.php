<?php

use App\Http\Controllers\MovementController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['middleware' => ['auth:sanctum']], function () {
    //-- User routes
    Route::get('/users', [UsuariosController::class, 'listar'])->middleware('permission:read');
    Route::put('/users/{id}', [UsuariosController::class, 'edit'])->middleware('permission:update');
    Route::delete('/users/{id}', [UsuariosController::class, 'delete'])->middleware('permission:delete');
    Route::get('/user', function(Request $request){
        return $request->user();
    });

    //-- Router Permissions
    Route::get('/permissions', [PermissionsController::class, 'listar']);
    Route::post('/permissions/vincula', [PermissionsController::class, 'vincula']);
    Route::post('/permissions/desvincula', [PermissionsController::class, 'desvincula']);
    Route::post('/permissions/create', [PermissionsController::class, 'createPermissions']);
    
     //-- Router Products
     Route::get('/products', [ProductController::class, 'listar']);
     Route::get('/products/{id}', [ProductController::class, 'getProdutct']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'edit']);

    //-- Router Type Movement
    Route::get('/type/movement', [MovementController::class, 'getTypeMovement']);
    Route::post('/type/movement', [MovementController::class, 'setTypeMovement']);


     //-- Router Movement
     Route::get('/movement', [MovementController::class, 'listar']);
     Route::post('/movement', [MovementController::class, 'store']);
});


//-- EndPoint para registrar um novo usuario
Route::post('/user/register', [UsuariosController::class, 'register']);


//-- EndPoint para fazer login
Route::post('/login', function (Request $request) {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

        $user = Auth::user();

        $token = $user->createToken('JWT');

        $response = (Object) [
            'Token' => $token,
            'Mensagem' => 'Logado com sucesso!'
        ];

        return response()->json($response, 200);
    }
    return response()->json('Usuário invalido', 401);
});


//-- EndPoint para fazer logout
Route::post('/logout', function (Request $request) {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

        auth()->user()->tokens()->delete();

        return response()->json('Deslogado com sucesso!', 200);
    }
    return response()->json('Usuário invalido', 401);
});

