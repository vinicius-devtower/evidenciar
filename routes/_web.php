<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SiteEditorController;
use App\Http\Controllers\SitePreviewController;
use App\Http\Controllers\PublicationRequestController;
use App\Http\Controllers\Admin\PublicationQueueController;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Models\Template;


/*
|--------------------------------------------------------------------------
| Rota públicas
|--------------------------------------------------------------------------
*/


Route::get('/', function () {
    $host = request()->getHost();

    // Domínio do SaaS
    if (in_array($host, [
        'sites.evidenciar.com.br',
        'localhost',
        '127.0.0.1'
    ])) {
        return app(LandingController::class)->index();
    }

    // Qualquer outro domínio → site do cliente
    return app(PublicSiteController::class)->showByDomain();
});

// Acesso canônico
Route::get('/s/{slug}', [PublicSiteController::class, 'showBySlug'])->name('app.sites.public.show');

// Rotas auxiliares de retorno
Route::get('/checkout/success', function () {
    return view('checkout.success');
})->name('checkout.success');

Route::get('/checkout/failure', function () {
    return view('checkout.failure');
})->name('checkout.failure');

// Checkout
Route::get('/checkout/{template}', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout/{template}', [CheckoutController::class, 'create'])->name('checkout.create');


/*
|--------------------------------------------------------------------------
| Rotas do cliente
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Rotas JSON
    Route::get('/api/templates', function () {
        return response()->json([
            [
                "title" => "Teste",
                "desc" => "Template teste",
                "img" => "/assets/img/570x760.png",
                "plan" => "start"
            ]
        ]);
    });

    /*
    |----------------------------------------------------------------------
    | Dashboard
    |----------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | Sites
    |----------------------------------------------------------------------
    */
    Route::get('/sites', [SiteController::class, 'index'])
        ->name('sites.index');

    Route::get('/sites/{site}', [SiteController::class, 'show'])
        ->name('sites.show');

    Route::get('/sites/{site}/edit', [SiteEditorController::class, 'edit'])
        ->name('app.sites.edit');

    Route::post('/sites/{site}/edit', [SiteEditorController::class, 'update'])
        ->name('sites.update');

    Route::get('/sites/{site}/preview', [SitePreviewController::class, 'show'])
        ->name('app.sites.preview');

    Route::post(
        '/sites/{site}/request-publication',
        [PublicationRequestController::class, 'store']
    )->name('sites.request-publication');

    /*
    |----------------------------------------------------------------------
    | Templates
    |----------------------------------------------------------------------
    */
    Route::get('/templates', [TemplateController::class, 'index'])
        ->name('templates.index');
});


/*
|--------------------------------------------------------------------------
| Rotas do suporte
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->group(function () {

        Route::get(
            '/publication-requests',
            [PublicationQueueController::class, 'index']
        )->name('admin.publication-requests.index');

        Route::post(
            '/publication-requests/{publicationRequest}/start',
            [PublicationQueueController::class, 'start']
        )->name('admin.publication-requests.start');

        Route::post(
            '/publication-requests/{publicationRequest}/publish',
            [PublicationQueueController::class, 'publish']
        )->name('admin.publication-requests.publish');

        Route::post(
            '/publication-requests/{publicationRequest}/reject',
            [PublicationQueueController::class, 'reject']
        )->name('admin.publication-requests.reject');
    });




/*
|--------------------------------------------------------------------------
| Rotas de autenticação (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
