<?php
namespace App\Http\Controllers;
use App\Models\Payment;
class PaymentController extends Controller
{
    public function index()
    {
        // futuramente: histórico de pagamentos
        return response()->json(['status' => 'ok']);
    }
}
