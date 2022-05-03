<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Sao_Paulo');

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Exceptions\InvalidOrderException;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class ProductController extends Controller
{

    
    public function listar()
    {
        
        $lista = Product::leftJoin('Stock', 'Product.id', '=', 'Stock.product_id')->selectRaw("Product.*, Stock.quantity")->get();

        return response()->json(['lista' => $lista], 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate(
            [
                'name' => ['required', 'string'],
                'description' => ['required', 'string'],
                'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'sku' => ['required', 'string']
            ],
        );

        $fields['create'] = date('Y-m-d H:i:s');

        $create = Product::create($fields);

        if ($create) {
            $reponse = 'Produto cadastrado com sucesso!';
        } else {
            $reponse = 'Erro ao cadastrar o produto!';
        }

        return response()->json(['message' => $reponse, 'produto' => $create], 200);

    }

    public function edit($id, Request $request)
    {
        $fields = $request->validate(
            [
                'name' => ['required', 'string'],
                'description' => ['required', 'string'],
                'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
                'sku' => ['required', 'string']
            ],
        );

        $update = Product::where('id', $id)->update($fields);

        
        if ($update) {
            $reponse = 'Produto editado com sucesso!';
        } else {
            $reponse = 'Erro ao editar o produto!';
        }

        return response()->json(['message' => $reponse, 'produto' => $fields], 200);
    }

    public function getProdutct($id)
    {
        
        $produto = Product::leftJoin('Stock', 'Product.id', '=', 'Stock.product_id')->selectRaw("Product.*, Stock.quantity")->where('Product.id', $id)->first();

        return response()->json(['produto' => $produto], 200);
    }

}
