<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Sao_Paulo');

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Exceptions\InvalidOrderException;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class PermissionsController extends Controller
{
    
    public function listar()
    {
        return response()->json(['lista' => Permission::selectRaw("id, name, created_at")->get()], 200);
    }


    public function vincula(Request $request)
    {

        $fields = $request->validate(
            [
                'id' => ['required', 'int'],
                'permission' => ['required', 'string']
            ],
        );

        $user = User::find($fields['id']);

        if ($user->hasPermissionTo($request->permission)) 
        {
            return response()->json(['mensagem' => 'Usuário já tem a permissao'], 200);
        }

        return response()->json($user->givePermissionTo($request->permission), 200);

    }

    
    public function desvincula(Request $request)
    {

        $fields = $request->validate(
            [
                'id' => ['required', 'int'],
                'permission' => ['required', 'string']
            ],
        );

        $user = User::find($fields['id']);

        if (!$user->hasPermissionTo($request->permission)) 
        {
            return response()->json(['mensagem' => 'Usuário não tem a permissão'], 200);
        }

        return response()->json($user->revokePermissionTo($request->permission), 200);
    }

    public function createPermissions(Request $request)
    {
        $permission = Permission::create(['name' => $request->permission]);

        return response()->json($permission, 200);
    }

}
