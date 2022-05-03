<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Sao_Paulo');

use App\Models\Movement;
use App\Models\MovementType;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function listar()
    {
        return response()->json(['movimentos' => Movement::join('Product', 'Movement.product_id', '=', 'Product.id')
            ->join('users', 'Movement.user_id', '=', 'users.id')
            ->join('movement_type', 'Movement.movement_type', '=', 'movement_type.id')
            ->selectRaw("Movement.id,
                                                                      Movement.product_id,
                                                                      Product.name as product_name,
                                                                      Movement.user_id,
                                                                      users.name as user_name,
                                                                      Movement.quantity,
                                                                      Movement.movement_date,
                                                                      movement_type.type as movement_type_name")
            ->get()], 200);
    }


    public function getTypeMovement()
    {
        return response()->json(['lista' => MovementType::get()], 200);
    }

    public function setTypeMovement(Request $request)
    {
        $fields = $request->validate(
            [
                'description' =>  ['required', 'string'],
                'type' =>  ['required', 'string'],
            ]
        );

        $create = MovementType::create($fields);

        if (!$create) {
            return response()->json(['mensagem' => 'Erro ao criar a categoria!'], 200);
        }

        return response()->json(['mensagem' => 'Categoria cadastrada com sucesso!'], 200);
    }

    public function store(Request $request)
    {

        $fields = $request->validate(
            [
                'product_id' => ['required'],
                'user_id' => ['required'],
                'quantity' => ['required'],
                'movement_type' => ['required']
            ],
        );

        $existe = Product::where('id', $fields['product_id'])->exists();

        if (!$existe) {
            return response()->json(['mensagem' => 'Produto não encontrado!'], 401);
        }

        $response = self::movimenta($fields);

        return response()->json(
            [
                'mensagem' => $response,
                'produto' =>
                 Product::leftJoin('Stock', 'Product.id', '=', 'Stock.product_id')
                        ->selectRaw("Product.*,
                                    (SELECT SUM(CASE 
                                    WHEN Stock.signal = 'S' 
                                        THEN -quantity
                                    ELSE quantity
                                    END) FROM Stock WHERE Stock.product_id = Product.id) AS quantity_total")
                        ->distinct()
                        ->get()
            ],
            200
        );
    }

    private function movimenta($fields)
    {

        $type = MovementType::where('id', $fields['movement_type'])->first()->type;

        $fields['movement_date'] = date('Y-m-d H:i:s');

        $createStock = Stock::create(
            [
                'product_id' => $fields['product_id'],
                'quantity' => $fields['quantity'],
                'signal' => $type,
                'source' => 'Movement'
            ]
        );

        if ($createStock) {
            Movement::create($fields);
        }

        return 'Movimentado com sucesso!';
    }
}
