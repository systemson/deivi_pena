<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Transaccion;

class SuperWalletzController extends Controller
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

        $validatedData["callback_url"] = "http://localhost:8000/api/v1/super_walletz/callback";

        $response = Http::post("http://localhost:3000/process", $validatedData);

        if ($response->successful()) {

            $transaccion->status = 'success';
            $transaccion->save();
            return response([
                'message' => 'success',
                'tx_id' => $response->json()['transaction_id'],
            ]);
        }


        $transaccion->status = 'failed';
        $transaccion->save();
        return $response->json();
    }

    public function callback(Request $request)
    {
        return response([
            'message' => "success",
            'tx_id' => $request->get('transaction_id'),
        ]);
    }
}
