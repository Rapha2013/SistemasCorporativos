<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class UsuariosController extends Controller
{
    public function index()
    {
        return view('usuarios.ListarUsuarios');
    }

    public function register(Request $request)
    {
        $fields = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'id_sector' => ['required', 'int', 'min:1'],
                'situation' => ['required', 'string', 'max:1']
            ],
        );

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'id_sector' => $fields['id_sector'],
            'situation' => $fields['situation']
        ]);


        $response = [
            'user' => $user
        ];

        return response($response, 201);
    }

    public function listar()
    {
        return response()->json(['lista' => User::join('sector', 'users.id_sector', 'sector.id')->selectRaw("users.*, sector.description as desc_sector")->get()], 200);
    }

    public function edit($id, Request $request)
    {

        $existe = User::find($id);

        if (!$existe) {
            return response(['erro' => 'Usuário inválido!'], 401);
        }

        $fields = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
                'situation' => ['required', 'string', 'max:1']
            ],
        );

        User::find($id)->update([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'situation' => $fields['situation']
        ]);

        return response(User::find($id), 200);
    }

    public function delete($id)
    {
        $existe = User::find($id);

        if (!$existe) {
            return response(['erro' => 'Usuário inválido!'], 401);
        }

        $delete = User::find($id)->update([
            'situation' => 'X'
        ]);

        if (!$delete) {
            return response(['Erro' => 'Erro ao desativar o usuário!'], 200);
        }

        return response(['Mensagem' => 'Usuário desativado com sucesso!'], 200);
    }

}
