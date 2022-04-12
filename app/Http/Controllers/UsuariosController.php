<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;


class UsuariosController extends Controller
{
    public function index()
    {
        return view('usuarios.ListarUsuarios');
    }

    public function listar()
    {

        return response()->json(['data' => User::get()], 200);
    }
}
