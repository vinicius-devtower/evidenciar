@extends('layouts.backoffice')
@section('title', 'Plano de Negócio — Minuta de Contrato')

@section('content')
    <h1 class="page-title mb-3">Minuta de contrato (v{{ $version }})</h1>

    @include('backoffice.dev.plano-negocio._nav')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-triangle"></i> Isso NÃO é o contrato usado no checkout dos clientes.</strong>
        É a minuta gerada no plano de negócio original, com o próprio aviso do documento:
        recomenda revisão por um advogado antes de publicar. O "de acordo" abaixo é só pra
        registro interno dos sócios — que revisaram esta versão e concordam em usá-la como
        base pra próxima etapa (revisão jurídica → contrato real no checkout).
    </div>

    <div class="bo-card p-3 mb-4">
        <h6 class="mb-3">Quem já confirmou de acordo</h6>
        @forelse ($agreements as $a)
            <div class="mb-1">
                <i class="bi bi-check-circle-fill text-success"></i>
                <strong>{{ $a->user->name }}</strong>
                <span class="text-muted small">— {{ $a->agreed_at->format('d/m/Y H:i') }}</span>
            </div>
        @empty
            <p class="text-muted small mb-0">Ninguém confirmou ainda.</p>
        @endforelse

        <hr>

        @if ($meuAceite)
            <p class="text-success mb-0">
                <i class="bi bi-check-circle-fill"></i> Você já confirmou de acordo em
                {{ $meuAceite->agreed_at->format('d/m/Y H:i') }}.
            </p>
        @else
            <form method="POST" action="{{ route('dev.plano-negocio.contrato.aceitar') }}">
                @csrf
                <button class="btn btn-dark">
                    <i class="bi bi-pen"></i> Li e estou de acordo com esta minuta (v{{ $version }})
                </button>
            </form>
        @endif
    </div>

    <div class="bo-card p-4">
        <h5 class="text-center mb-1">TERMOS DE USO E POLÍTICA DE PRIVACIDADE – EVIDENCIAR</h5>
        <p class="text-center text-muted small mb-4">Versão 1.0 – Vigência a partir de Fevereiro de 2026</p>

        <p class="small">
            Este documento regula a contratação dos serviços da EVIDENCIAR SOLUÇÕES DIGITAIS
            (inserir CNPJ), doravante denominada CONTRATADA, pelo cliente, doravante denominado
            CONTRATANTE. Ao clicar em "ACEITO", o CONTRATANTE adere integralmente aos termos abaixo.
        </p>

        <h6 class="mt-4">1. DO OBJETO</h6>
        <p class="small">
            1.1. A CONTRATADA fornece, via assinatura (SaaS), acesso a uma plataforma para criação,
            edição e hospedagem de site profissional baseada em templates pré-formatados.
            1.2. O serviço inclui hospedagem em nuvem, manutenção da infraestrutura e suporte técnico
            conforme o plano contratado (Start, Profissional ou Gestão VIP).
            1.3. A CONTRATADA atua exclusivamente como fornecedora de tecnologia e meio. Todo o
            conteúdo (textos, imagens, logotipos) inserido no site é de única e exclusiva
            responsabilidade do CONTRATANTE.
        </p>

        <h6 class="mt-4">2. DO REGISTRO DE DOMÍNIO</h6>
        <p class="small">
            2.1. Nos planos anuais ou quando contratado à parte, a CONTRATADA realizará a
            intermediação do registro de domínio (.com.br) perante o Registro.br.
            2.2. Titularidade: o domínio será registrado diretamente no CPF ou CNPJ do
            CONTRATANTE, garantindo que a propriedade do endereço eletrônico seja do cliente.
            2.3. A CONTRATADA figurará apenas como "Contato Técnico" e "Contato de Cobrança" para
            facilitar a gestão e renovação enquanto o contrato estiver vigente.
            2.4. Em caso de não renovação da assinatura com a EVIDENCIAR, a responsabilidade pelo
            pagamento da taxa anual do domínio (aproximadamente R$ 40,00) passa a ser exclusivamente
            do CONTRATANTE junto ao Registro.br.
        </p>

        <h6 class="mt-4">3. DA VIGÊNCIA E FIDELIDADE</h6>
        <p class="small">
            3.1. Renovação: o contrato renova-se automaticamente por períodos iguais e sucessivos,
            salvo manifestação em contrário.
            3.2. Fidelidade (Plano Mensal): para garantir o valor promocional de entrada, o Plano
            Mensal possui fidelidade mínima de 6 (seis) meses.
            3.3. Multa por Quebra de Fidelidade: caso o CONTRATANTE solicite o cancelamento antes de
            completar o período de fidelidade (6 meses), será cobrada multa rescisória de 30% (trinta
            por cento) sobre o valor total das mensalidades restantes.
            3.4. Plano Anual: o Plano Anual não permite reembolso proporcional em caso de
            cancelamento antecipado após o prazo de arrependimento legal (7 dias), visto que o
            desconto concedido pressupõe a contratação pelo período integral de 12 meses.
        </p>

        <h6 class="mt-4">4. INADIMPLÊNCIA E SUSPENSÃO (POLÍTICA DE COBRANÇA)</h6>
        <p class="small">
            4.1. Atraso: o não pagamento da mensalidade na data de vencimento sujeita o CONTRATANTE
            a juros de mora de 1% ao mês e multa de 2%.
            4.2. Suspensão (5 dias): após 5 (cinco) dias corridos de atraso, o acesso ao painel de
            edição será bloqueado e o site poderá exibir uma página de "Manutenção" ou ser
            temporariamente suspenso, interrompendo a visualização pública.
            4.3. Cancelamento Definitivo (30 dias): após 30 (trinta) dias corridos de inadimplência, o
            contrato será rescindido automaticamente. Todos os dados, arquivos e configurações do
            site serão excluídos permanentemente dos servidores da CONTRATADA, sem possibilidade de
            recuperação (backup), liberando espaço em disco.
        </p>

        <h6 class="mt-4">5. RESPONSABILIDADE ÉTICA E CONTEÚDO (OAB/CRC)</h6>
        <p class="small">
            5.1. O CONTRATANTE declara-se ciente de que deve utilizar o site em conformidade com o
            Código de Ética de sua profissão (ex.: Provimento 205/2021 da OAB para advogados ou
            normas do CFC para contadores).
            5.2. A EVIDENCIAR isenta-se de qualquer responsabilidade sobre o teor da publicidade
            veiculada pelo CONTRATANTE, atuando apenas como provedora da ferramenta. Caso a
            CONTRATADA seja notificada judicialmente sobre conteúdo irregular, reserva-se o direito
            de suspender o site preventivamente até a regularização.
        </p>

        <h6 class="mt-4">6. SUPORTE E SLA (NÍVEL DE SERVIÇO)</h6>
        <p class="small">
            6.1. A CONTRATADA envidará esforços para manter o serviço disponível 99% do tempo (SLA).
            Interrupções para manutenção programada serão avisadas com antecedência.
            6.2. O Suporte Técnico limita-se ao funcionamento da plataforma e dúvidas sobre o uso do
            editor. A CONTRATADA não realiza serviços de design, criação de logotipos ou redação de
            textos, exceto se contratados no plano Gestão VIP.
        </p>

        <h6 class="mt-4">7. POLÍTICA DE PRIVACIDADE E PROTEÇÃO DE DADOS (LGPD)</h6>
        <p class="small">
            7.1. Dados do CONTRATANTE: a EVIDENCIAR coleta dados cadastrais (Nome, CPF, E-mail) para
            fins de faturamento e acesso ao sistema, atuando como "Controladora".
            7.2. Dados de Terceiros: caso o site do CONTRATANTE colete dados de seus clientes (ex.:
            formulário de contato), o CONTRATANTE atua como "Controlador" e a EVIDENCIAR como
            "Operadora", comprometendo-se a manter a segurança desses dados e não utilizá-los para
            fins próprios.
            7.3. Os dados não serão vendidos ou compartilhados, exceto com parceiros essenciais à
            operação (Gateway de Pagamento e Registro de Domínios).
        </p>

        <h6 class="mt-4">8. DO FORO</h6>
        <p class="small mb-0">
            8.1. As partes elegem o Foro da Comarca de Louveira/SP para dirimir quaisquer
            controvérsias oriundas deste contrato.
        </p>
    </div>

    <div class="bo-card p-3 mt-4">
        <h6>Pontos deixados em aberto no documento original — precisam de decisão dos sócios</h6>
        <ul class="small mb-0">
            <li><strong>Multa de fidelidade:</strong> 30% sobre o restante do contrato está proposto
                como padrão de mercado. Manter ou ajustar?</li>
            <li><strong>Prazo de inadimplência:</strong> 5 dias pra suspender, 30 pra deletar. Manter
                ou ser mais tolerante (ex.: 10 dias pra suspender)?</li>
            <li><strong>Titularidade do domínio:</strong> a minuta assume que o domínio vai sempre pro
                CPF/CNPJ do cliente (recomendação do próprio documento) — confirmar que é assim que
                vai funcionar na prática.</li>
        </ul>
    </div>
@endsection
