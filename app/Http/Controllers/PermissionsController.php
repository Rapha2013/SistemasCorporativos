<?php

namespace App\Http\Controllers;

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


        // $user = User::find($id);


        // $user->assignRole('writer');

        // $user->removeRole('writer');

        // Permission::create(['name' => 'create']);
        // Permission::create(['name' => 'update']);

        // Permission::create(['name' => 'delete']);

        // $user->givePermissionTo($permission);

        // $role = Role::create(['name' => 'writer']);

        // $permissions = Permission::where('name', 'celete')->delete();


        return response()->json($user->revokePermissionTo($request->permission), 200);
    }
}
