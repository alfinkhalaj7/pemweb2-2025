<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $data = Client::all();
        return response()->json([
            'massage' => 'List of Clients',
            'data' => $data
        ], 200);
    }
}
