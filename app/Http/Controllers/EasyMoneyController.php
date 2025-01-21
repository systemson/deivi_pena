<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Transaccion;

class EasyMoneyController extends Controller
{
    function pay(Request $request)
    {
        $transaccion = new Transaccion();
        $transaccion->amount = $request->get("amount");
        $transaccion->currency = $request->get("currency");
        $transaccion->save();

        $validatedData = $request->validate([
            "amount" => "required|integer",
            "currency" => "required|string",
        ]);

        $response = Http::post("http://localhost:3000/process", $validatedData);

        if ($response->successful()) {
            return response([
                'message' => 'Transaccion recibida satisfactoriamente',
            ]);
        }

        return $response->json();
    }
}
