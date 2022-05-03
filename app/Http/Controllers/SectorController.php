<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Sao_Paulo');

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Exceptions\InvalidOrderException;
use App\Models\Sector;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class SectorController extends Controller
{

    public function listar()
    {
        return response()->json(['lista' => Sector::get()], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate(
            [
                'description' => ['required', 'string']
            ],
        );

        if (Sector::where('description', $fields['description'])->exists()) {
            return response()->json(['mensagem' => 'Setor já existe!'], 401);
        }

        Sector::create($fields);

        return response()->json(['mensagem' => 'Setor cadastrado com sucesso!', 'lista' => $fields], 200);
    }


    public function edit($id, Request $request)
    {

        $fields = $request->validate(
            [
                'description' => ['required', 'string']
            ],
        );

        if(!Sector::where('id', $id)->exists()){
            return response()->json(['mensagem' => 'ID do setor informado não foi encontrado!'], 401);
        }

        Sector::where('id', $id)->update($fields);


        return response()->json(['mensagem' => 'Setor editado com sucesso!', 'lista' => $fields], 200);
    }
}
