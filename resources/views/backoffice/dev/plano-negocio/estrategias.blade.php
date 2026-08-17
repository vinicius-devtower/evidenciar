@extends('layouts.backoffice')
@section('title', 'Plano de Negócio — Estratégias de Venda')

@section('content')
    <h1 class="page-title mb-3">Estratégias de venda (custo zero)</h1>

    @include('backoffice.dev.plano-negocio._nav')

    <p class="text-muted mb-4">
        Foco em venda direta pra não gastar com anúncios enquanto a base de clientes ainda
        é pequena — cidades-alvo iniciais: <strong>Louveira, Jundiaí, Vinhedo e Campinas</strong>.
    </p>

    <div class="bo-card p-3 mb-3">
        <h6><i class="bi bi-people"></i> Networking presencial</h6>
        <p class="mb-2">Foco cirúrgico em "comissões", não eventos genéricos de empreendedorismo.</p>
        <ul class="small">
            <li><strong>Advogados:</strong> Comissão da Jovem Advocacia (OAB Jovem) da região — advogados
                em início de carreira são o público ideal, precisam de site barato e estão abertos a
                novidade.</li>
            <li><strong>Contadores:</strong> eventos do SESCON ou cafés de negócios locais — contadores
                são unidos, uma indicação boa puxa outras cinco.</li>
        </ul>
        <div class="alert alert-light border small mb-0">
            <strong>Discurso sugerido:</strong> "Olá, sou especialista em presença digital para
            advogados. Vi que muitos colegas seus estão com medo das novas regras de publicidade da
            OAB. Meu trabalho é garantir que o escritório tenha uma vitrine digital ética e segura.
            Você já tem seu 'Escritório Digital' ou só o físico?"
        </div>
    </div>

    <div class="bo-card p-3 mb-3">
        <h6><i class="bi bi-instagram"></i> Instagram — técnica da "Auditoria Gratuita"</h6>
        <p class="mb-2">Não ofereça nada no primeiro contato — aponte um problema, gere reciprocidade.</p>
        <div class="alert alert-light border small mb-0">
            "Olá, Dr. [Nome] / Equipe da [Escritório]. Tudo bem? Estava pesquisando advogados em
            [Cidade] para uma referência e notei que o link da bio de vocês não leva para um site
            oficial, apenas para o WhatsApp (ou está quebrado). Como especialista na área, achei
            importante avisar porque isso pode diminuir a autoridade do escritório no Google. Se
            precisarem de ajuda para resolver essa 'vitrine', estou à disposição. Abraço!"
        </div>
    </div>

    <div class="bo-card p-3 mb-3">
        <h6><i class="bi bi-envelope"></i> E-mail frio</h6>
        <p class="mb-2">Assunto focado em credibilidade/normas, nunca em "proposta de site" (vai direto pro lixo).</p>
        <p class="small mb-1"><strong>Assunto (advogado):</strong> "Sua presença digital x Regras da OAB"</p>
        <p class="small mb-2"><strong>Assunto (contador):</strong> "Dúvida sobre o escritório [Nome]"</p>
        <div class="alert alert-light border small mb-0">
            "Prezado Dr. [Nome], notei que seu escritório ainda não possui um Escritório Digital
            (Site Institucional). Sabia que, pelas normas da OAB, o site é a única forma de
            publicidade que permite detalhar suas áreas de atuação sem ser considerado 'captação
            indevida'? Na Evidenciar, criamos sites estritamente dentro das normas éticas da OAB, por
            um valor de assinatura que não pesa no caixa. Posso enviar nosso portfólio de modelos
            aprovados para advogados?"
        </div>
    </div>

    <div class="bo-card p-3 mb-3">
        <h6><i class="bi bi-geo-alt"></i> Google Maps (dica de ouro, custo zero)</h6>
        <ol class="small mb-2">
            <li>Abra o Google Maps, digite "Advogado em [cidade]" (ou cidade vizinha)</li>
            <li>Role a lista — quem tiver "Adicionar Website" no perfil é o alvo</li>
            <li>Ligue direto no telefone do perfil</li>
        </ol>
        <div class="alert alert-light border small mb-0">
            "Alô, é do escritório do Dr. João? Aqui é da Evidenciar. Eu vi no Google Maps que o
            escritório dele está sem o botão do site. Isso faz vocês perderem clientes que buscam no
            Google. Nós resolvemos isso em 24h. O Dr. João está?"
        </div>
    </div>

    <div class="bo-card p-3">
        <h6><i class="bi bi-calendar-week"></i> Rotina semanal sugerida (operação sem custo)</h6>
        <table class="table table-sm mb-0">
            <tbody>
                <tr><td class="fw-bold" style="width:120px">Segunda</td><td>Mapear 20 advogados/contadores no Google Maps sem site</td></tr>
                <tr><td class="fw-bold">Terça</td><td>Enviar a "Auditoria Gratuita" no Instagram/e-mail para esses 20</td></tr>
                <tr><td class="fw-bold">Quarta</td><td>Ligar para quem visualizou mas não respondeu</td></tr>
                <tr><td class="fw-bold">Quinta</td><td>Ir a um evento ou café local (OAB Jovem / SESCON)</td></tr>
                <tr><td class="fw-bold">Sexta</td><td>Follow-up — cobrar resposta de quem ficou de pensar</td></tr>
            </tbody>
        </table>
    </div>
@endsection
