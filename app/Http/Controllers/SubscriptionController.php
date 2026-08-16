<?php

namespace App\Http\Controllers;

use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        // futuramente: listar assinaturas do cliente
        return response()->json(['status' => 'ok']);
    }
}
