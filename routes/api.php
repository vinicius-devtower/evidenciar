<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MercadoPagoWebhookController;
use App\Http\Controllers\MercadoPagoWebhookTestController;
use App\Http\Controllers\Api\TemplateController;

Route::get('/templates', [TemplateController::class, 'index']);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



/*
|--------------------------------------------------------------------------
| WebHook
|--------------------------------------------------------------------------
*/
// Endpoint interno de teste (sem assinatura) — não exponha publicamente.
Route::post('/webhooks/mercadopago/test', [MercadoPagoWebhookTestController::class, 'handle'])
    ->name('webhooks.mercadopago.test');

// Endpoint oficial do Mercado Pago: exige x-signature válida.
Route::post('/webhooks/mercadopago', [MercadoPagoWebhookController::class, 'handle'])
    ->middleware('mp.signature')
    ->name('webhooks.mercadopago');


/*
|--------------------------------------------------------------------------
| Template
|--------------------------------------------------------------------------
*/
Route::get('/templates', [TemplateController::class, 'index']);