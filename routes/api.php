<?php

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

Route::post('/user/register', [UsuariosController::class, 'register']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/users/lista', [UsuariosController::class, 'listar']);
    Route::get('/user', function(Request $request){
        return $request->user();
    });
});



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

Route::post('/logout', function (Request $request) {
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

        auth()->user()->tokens()->delete();

        return response()->json('Deslogado com sucesso!', 200);
    }
    return response()->json('Usuário invalido', 401);
});

