<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SistemaController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AiAssistController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\SiteEditorController;
use App\Http\Controllers\SitePreviewController;
use App\Http\Controllers\PublicationRequestController;
use App\Http\Controllers\Admin\PublicationQueueController;
use App\Http\Controllers\Suporte\InicioController as SuporteInicioController;
use App\Http\Controllers\Suporte\PublicacaoController as SuportePublicacaoController;
use App\Http\Controllers\Suporte\AssinanteController as SuporteAssinanteController;
use App\Http\Controllers\Suporte\LogController as SuporteLogController;
use App\Http\Controllers\Financeiro\InicioController as FinanceiroInicioController;
use App\Http\Controllers\Financeiro\AssinaturaController as FinanceiroAssinaturaController;
use App\Http\Controllers\Financeiro\PagamentoController as FinanceiroPagamentoController;
use App\Http\Controllers\Dev\InicioController as DevInicioController;
use App\Http\Controllers\Dev\TemplateController as DevTemplateController;
use App\Http\Controllers\Dev\PlanoController as DevPlanoController;
use App\Http\Controllers\Dev\IntegracoesController as DevIntegracoesController;
use App\Http\Controllers\Dev\PlanoNegocioController as DevPlanoNegocioController;
use App\Http\Controllers\Dev\TemplatePadraoController as DevTemplatePadraoController;
use App\Http\Controllers\PublicSiteController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\JornadaController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ImpersonateController;

/*
|--------------------------------------------------------------------------
| Rotas públicas
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $host    = request()->getHost();
    $appHost = parse_url(config('app.url'), PHP_URL_HOST);

    // Hosts "mestres" que sempre exibem a landing pública.
    $hostsMestre = array_filter([
        $appHost,
        'sites.evidenciar.com.br',
        'www.sites.evidenciar.com.br',
        'localhost',
        '127.0.0.1',
    ]);

    if (in_array($host, $hostsMestre, true)) {
        return app(LandingController::class)->index();
    }

    // Outros hosts: tenta servir o site publicado por domínio;
    // se não existir, cai na landing para nunca dar 404 na raiz.
    try {
        return app(PublicSiteController::class)->showByDomain(request());
    } catch (\Throwable $e) {
        return app(LandingController::class)->index();
    }
});

// Acesso canônico
Route::get('/s/{slug}', [PublicSiteController::class, 'showBySlug'])
    ->name('app.sites.public.show');

/*
|--------------------------------------------------------------------------
| Jornada do cliente (multi-step antes do pagamento)
|--------------------------------------------------------------------------
*/
Route::prefix('jornada')->name('jornada.')->group(function () {
    Route::get('/',           [JornadaController::class, 'start'])->name('start');
    Route::get('/passo-1',    [JornadaController::class, 'step1'])->name('step1');
    Route::post('/passo-1',   [JornadaController::class, 'saveStep1'])->name('step1.save');
    Route::get('/passo-2',    [JornadaController::class, 'step2'])->name('step2');
    Route::post('/passo-2',   [JornadaController::class, 'saveStep2'])->name('step2.save');
    Route::get('/passo-3',    [JornadaController::class, 'step3'])->name('step3');
    Route::post('/passo-3',   [JornadaController::class, 'saveStep3'])->name('step3.save');
});

/*
|--------------------------------------------------------------------------
| Checkout (PIX via Mercado Pago)
|--------------------------------------------------------------------------
| A ordem importa: rotas com segmento literal antes do wildcard {template}.
*/
// Gera o PIX a partir dos dados salvos na sessão da jornada
Route::get('/checkout/create', [CheckoutController::class, 'create'])
    ->name('checkout.create');

// Tela de "aguardando pagamento" com QR code PIX
Route::get('/checkout/aguardando/{intent}', [CheckoutController::class, 'awaiting'])
    ->name('checkout.awaiting');

// Retornos de checkout
Route::get('/checkout/success', fn () => view('checkout.success'))
    ->name('checkout.success');

Route::get('/checkout/failure', fn () => view('checkout.failure'))
    ->name('checkout.failure');

// Legacy: /checkout/{template} agora redireciona para a jornada (POR ÚLTIMO)
Route::get('/checkout/{template}', [CheckoutController::class, 'show'])
    ->name('checkout.show');


/*
|--------------------------------------------------------------------------
| Aliases úteis para views do Breeze
|--------------------------------------------------------------------------
*/
// O Breeze espera uma rota "dashboard" — redirecionamos conforme o papel
Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) return redirect()->route('login');
    return match ($user->role) {
        'admin'   => redirect()->route('suporte.inicio'),
        'support' => redirect()->route('suporte.inicio'),
        'finance' => redirect()->route('financeiro.inicio'),
        'dev'     => redirect()->route('dev.inicio'),
        default   => redirect()->route('app.inicio'),
    };
})->middleware('auth')->name('dashboard');

// Home name alias
Route::get('/home', fn () => redirect('/'))->name('landing');

// Sair do "ver como cliente" (impersonation) — reachable de qualquer
// página autenticada, não só de dentro de /suporte.
Route::post('/impersonate/sair', [ImpersonateController::class, 'stop'])
    ->middleware('auth')
    ->name('impersonate.stop');


/*
|--------------------------------------------------------------------------
| Perfil do usuário (Breeze)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',  [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Rotas do cliente (/app)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:client'])
    ->prefix('app')
    ->name('app.')
    ->group(function () {

        Route::get('/', [SistemaController::class, 'inicio'])
            ->name('inicio');

        Route::get('/editor',    [SistemaController::class, 'editor'])
            ->name('editor');

        Route::get('/tutoriais', [SistemaController::class, 'tutoriais'])
            ->name('tutoriais');

        Route::get('/conta',     [SistemaController::class, 'conta'])
            ->name('conta');

        // Mantém /app/visao-geral como alias da raiz
        Route::get('/visao-geral', [SistemaController::class, 'inicio'])
            ->name('visao-geral');

        /*
        |--------------------------------------------------------------------------
        | Sites
        |--------------------------------------------------------------------------
        */

        Route::get('/sites', [SiteController::class, 'index'])
            ->name('sites.index');

        Route::get('/sites/{site}', [SiteController::class, 'show'])
            ->name('sites.show');

        Route::get('/sites/{site}/edit', [SiteEditorController::class, 'edit'])
            ->name('sites.edit');

        Route::post('/sites/{site}/edit', [SiteEditorController::class, 'update'])
            ->name('sites.update');

        Route::get('/sites/{site}/preview', [SitePreviewController::class, 'show'])
            ->name('sites.preview');

        Route::post('/sites/{site}/request-publication', [PublicationRequestController::class, 'store'])
            ->name('sites.request-publication');

        /*
        |--------------------------------------------------------------------------
        | Publicação (wizard + acompanhamento do cliente)
        |--------------------------------------------------------------------------
        */
        Route::prefix('publicacao')->name('publicacao.')->group(function () {
            Route::get('/',        [PublicationRequestController::class, 'index'])->name('index');

            Route::get('/solicitar',      [PublicationRequestController::class, 'wizardStep1'])->name('wizard.step1');
            Route::post('/solicitar',     [PublicationRequestController::class, 'saveStep1'])->name('wizard.step1.save');

            Route::get('/solicitar/dominio',  [PublicationRequestController::class, 'wizardStep2'])->name('wizard.step2');
            Route::post('/solicitar/dominio', [PublicationRequestController::class, 'saveStep2'])->name('wizard.step2.save');

            Route::get('/solicitar/checklist',  [PublicationRequestController::class, 'wizardStep3'])->name('wizard.step3');
            Route::post('/solicitar/checklist', [PublicationRequestController::class, 'saveStep3'])->name('wizard.step3.save');

            Route::get('/solicitar/revisar', [PublicationRequestController::class, 'wizardReview'])->name('wizard.review');
            Route::post('/solicitar/enviar', [PublicationRequestController::class, 'submit'])->name('wizard.submit');

            Route::post('/{publicacao}/mensagem', [PublicationRequestController::class, 'message'])->name('message');
            Route::post('/{publicacao}/cancelar', [PublicationRequestController::class, 'cancel'])->name('cancel');
        });

        /*
        |--------------------------------------------------------------------------
        | Templates (visão do cliente)
        |--------------------------------------------------------------------------
        */

        // Biblioteca de templates do cliente (nova aba "Templates")
        Route::get('/templates', [SistemaController::class, 'templates'])
            ->name('templates');

        Route::post('/templates/switch', [SistemaController::class, 'switchTemplate'])
            ->name('templates.switch');

        // Alias legado, mantém a rota antiga apontando para a mesma view
        Route::get('/templates/index', [SistemaController::class, 'templates'])
            ->name('templates.index');

        /*
        |--------------------------------------------------------------------------
        | Identidade visual & contato global (salvos em site.content)
        |--------------------------------------------------------------------------
        */

        Route::post('/sites/branding', [SistemaController::class, 'saveBranding'])
            ->name('branding.save');

        Route::post('/sites/contact',  [SistemaController::class, 'saveContactGlobal'])
            ->name('contact-global.save');

        /*
        |--------------------------------------------------------------------------
        | Uploads (imagens do editor / identidade visual)
        |--------------------------------------------------------------------------
        */

        Route::post('/uploads/image', [UploadController::class, 'image'])
            ->name('uploads.image');

        /*
        |--------------------------------------------------------------------------
        | Assistente de conteúdo (EVA)
        |--------------------------------------------------------------------------
        */

        Route::post('/ai/suggest', [AiAssistController::class, 'suggest'])
            ->middleware('feature:eva')
            ->name('ai.suggest');
    });


/*
|--------------------------------------------------------------------------
| Rotas do admin (/admin)
|--------------------------------------------------------------------------
*/

// O /admin era um painel único, hoje substituído pelos painéis
// /suporte, /financeiro e /dev. Mantemos apenas aliases legados que
// redirecionam para o suporte.
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', fn () => redirect()->route('suporte.inicio'))->name('inicio');
        Route::get('/publication-requests',
            fn () => redirect()->route('suporte.publicacoes.index'))
            ->name('publication-requests.index');
    });


/*
|--------------------------------------------------------------------------
| Suporte (/suporte) — atende publicações, DNS, contato com assinante
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:support,admin'])
    ->prefix('suporte')
    ->name('suporte.')
    ->group(function () {

        Route::get('/', [SuporteInicioController::class, 'index'])->name('inicio');

        Route::get('/publicacoes',                     [SuportePublicacaoController::class, 'index'])->name('publicacoes.index');
        Route::get('/publicacoes/{publicacao}',        [SuportePublicacaoController::class, 'show'])->name('publicacoes.show');
        Route::post('/publicacoes/{publicacao}/assumir',    [SuportePublicacaoController::class, 'assign'])->name('publicacoes.assign');
        Route::post('/publicacoes/{publicacao}/status',     [SuportePublicacaoController::class, 'transition'])->name('publicacoes.transition');
        Route::post('/publicacoes/{publicacao}/dns',        [SuportePublicacaoController::class, 'saveDns'])->name('publicacoes.dns');
        Route::post('/publicacoes/{publicacao}/mensagem',   [SuportePublicacaoController::class, 'message'])->name('publicacoes.message');

        Route::get('/assinantes',              [SuporteAssinanteController::class, 'index'])->name('assinantes.index');
        Route::get('/assinantes/{assinante}',  [SuporteAssinanteController::class, 'show'])->name('assinantes.show');

        // "Ver como cliente" — restrito a admin (v1: support não impersona ainda).
        Route::post('/assinantes/{assinante}/impersonar', [ImpersonateController::class, 'start'])
            ->middleware('role:admin')
            ->name('assinantes.impersonate');

        /*
        |----------------------------------------------------------------------
        | Logs (estilo OMIE) — exceções, webhooks, atividade e e-mails
        |----------------------------------------------------------------------
        */
        Route::prefix('logs')->name('logs.')->group(function () {
            Route::get('/', [SuporteLogController::class, 'index'])->name('index');

            Route::get('/excecoes',         [SuporteLogController::class, 'excecoes'])->name('excecoes.index');
            Route::get('/excecoes/{id}',    [SuporteLogController::class, 'excecao'])
                ->whereNumber('id')->name('excecoes.show');

            Route::get('/webhooks',         [SuporteLogController::class, 'webhooks'])->name('webhooks.index');
            Route::get('/webhooks/{id}',    [SuporteLogController::class, 'webhook'])
                ->whereNumber('id')->name('webhooks.show');

            Route::get('/atividade',        [SuporteLogController::class, 'atividade'])->name('atividade.index');
            Route::get('/atividade/{id}',   [SuporteLogController::class, 'atividadeItem'])
                ->whereNumber('id')->name('atividade.show');

            Route::get('/emails',           [SuporteLogController::class, 'emails'])->name('emails.index');
            Route::get('/emails/{id}',      [SuporteLogController::class, 'email'])
                ->whereNumber('id')->name('emails.show');
        });
    });


/*
|--------------------------------------------------------------------------
| Financeiro (/financeiro) — assinaturas e pagamentos, read-only
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:finance,admin'])
    ->prefix('financeiro')
    ->name('financeiro.')
    ->group(function () {

        Route::get('/', [FinanceiroInicioController::class, 'index'])->name('inicio');

        Route::get('/assinaturas',               [FinanceiroAssinaturaController::class, 'index'])->name('assinaturas.index');
        Route::get('/assinaturas/{assinatura}',  [FinanceiroAssinaturaController::class, 'show'])->name('assinaturas.show');

        Route::get('/pagamentos', [FinanceiroPagamentoController::class, 'index'])->name('pagamentos.index');
    });


/*
|--------------------------------------------------------------------------
| Desenvolvimento (/dev) — catálogo de templates, versões, planos
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:dev,admin'])
    ->prefix('dev')
    ->name('dev.')
    ->group(function () {

        Route::get('/', [DevInicioController::class, 'index'])->name('inicio');

        Route::get('/templates',                                 [DevTemplateController::class, 'index'])->name('templates.index');
        Route::get('/templates/{template}',                      [DevTemplateController::class, 'show'])->name('templates.show');
        Route::post('/templates/{template}/versoes/{version}/ativar',
            [DevTemplateController::class, 'activateVersion'])->name('templates.versions.activate');
        Route::post('/templates/{template}/planos',              [DevTemplateController::class, 'syncPlans'])->name('templates.plans.sync');

        Route::get('/planos',                [DevPlanoController::class, 'index'])->name('planos.index');
        Route::get('/planos/novo',           [DevPlanoController::class, 'create'])->name('planos.create');
        Route::post('/planos',               [DevPlanoController::class, 'store'])->name('planos.store');
        Route::get('/planos/{plano}/editar', [DevPlanoController::class, 'edit'])->name('planos.edit');
        Route::put('/planos/{plano}',        [DevPlanoController::class, 'update'])->name('planos.update');

        // Templates Padrão — referência viva pra equipe de criação
        Route::get('/templates-padrao',         [DevTemplatePadraoController::class, 'index'])->name('templates-padrao.index');
        Route::get('/templates-padrao/{slug}',  [DevTemplatePadraoController::class, 'show'])->name('templates-padrao.show');

        // Integrações — credenciais de provedores externos, editáveis pelo SuperAdmin
        Route::get('/integracoes/mercadopago',  [DevIntegracoesController::class, 'mercadoPago'])->name('integracoes.mercadopago');
        Route::put('/integracoes/mercadopago',  [DevIntegracoesController::class, 'updateMercadoPago'])->name('integracoes.mercadopago.update');

        // Plano de Negócio — "estamos no trilho?" (uso interno dos sócios)
        Route::prefix('plano-negocio')->name('plano-negocio.')->group(function () {
            Route::get('/',              [DevPlanoNegocioController::class, 'index'])->name('index');
            Route::get('/indicadores',   [DevPlanoNegocioController::class, 'indicadores'])->name('indicadores');
            Route::post('/indicadores',  [DevPlanoNegocioController::class, 'storeIndicador'])->name('indicadores.store');
            Route::put('/indicadores/{indicador}', [DevPlanoNegocioController::class, 'updateIndicador'])->name('indicadores.update');
            Route::get('/projecao',      [DevPlanoNegocioController::class, 'projecao'])->name('projecao');
            Route::get('/estrategias',   [DevPlanoNegocioController::class, 'estrategias'])->name('estrategias');
            Route::get('/contrato',      [DevPlanoNegocioController::class, 'contrato'])->name('contrato');
            Route::post('/contrato/aceitar', [DevPlanoNegocioController::class, 'aceitarContrato'])->name('contrato.aceitar');
        });
    });


/*
|--------------------------------------------------------------------------
| Auth (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';