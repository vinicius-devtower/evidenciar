<section id="pricing" class="pricing section">

    <div class="container section-title aos-init aos-animate" data-aos="fade-up">
        <div class="row text-center row-title">
            <div class="col-md-12">

                <div class="supporting-text mt-5">
                    <ul>
                        <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="18" height="18"> Somos Referência</li>
                    </ul>
                </div>

                <h2 class="pricing-title">
                    Menos que um <span class="highlight">cafezinho por dia.</span><br>
                    Uma agência cobraria R$ 2.500,00 por isso.
                </h2>

                <p class="pricing-subtitle">
                    Escolha o <span class="highlight">plano ideal</span> para o seu escritório.
                </p>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row gy-4 justify-content-center mt-5">

            @php
                $planStart        = $plans['start'] ?? null;
                $planProfissional = $plans['profissional'] ?? null;
                $planVip          = $plans['gestao_vip'] ?? null;
            @endphp

            {{-- START --}}
            <div class="col-lg-4">
                <div class="pricing-card" data-plan="start">

                    <h3>Plano Start</h3>
                    <p class="tagline">O essencial pra existir no Google</p>

                    @if ($planStart)
                        <div class="price">
                            <span class="price-monthly">{{ $planStart->priceFormatted() }}</span>
                            <span class="price-annual d-none">{{ $planStart->annualMonthlyEquivalentFormatted() }}</span>
                        </div>
                        <div class="price-annual-note d-none small text-muted">{{ $planStart->annualPriceFormatted() }} à vista/ano</div>

                        <hr>
                        <div class="billing-toggle">
                            <label class="switch">
                                <input type="checkbox" class="toggle-input">
                                <span class="slider"></span>
                            </label>
                            <span>Anual</span>
                            <span class="discount">{{ $planStart->annualDiscountPercent() }}% OFF | {{ $planStart->annualSavingsFormatted() }} economia</span>
                        </div>
                        <hr>

                        <a href="{{ route('jornada.start', ['plan' => 'start']) }}"
                           data-monthly-url="{{ route('jornada.start', ['plan' => 'start']) }}"
                           data-annual-url="{{ route('jornada.start', ['plan' => 'start', 'cycle' => 'annual']) }}"
                           class="btn btn-pricing w-100 js-plan-link">Escolher Plano ↗</a>
                    @endif

                    <div class="feature-group">
                        <h4>Personalize</h4>
                        <ul>
                            <li>Site One Page (tudo em uma página)</li>
                            <li>Editor do Site (Faça você mesmo)</li>
                            <li>Integração com WhatsApp e Redes Sociais</li>
                        </ul>
                    </div>

                    <div class="feature-group">
                        <h4>Publique</h4>
                        <ul>
                            <li>Domínio Grátis</li>
                            <li>1 Conta de E-mail Profissional (2GB)</li>
                            <li>Hospedagem e SSL Inclusos</li>
                        </ul>
                    </div>

                    <div class="feature-group">
                        <h4>Suporte</h4>
                        <ul>
                            <li>Manutenção</li>
                            <li>Backup do site</li>
                        </ul>
                    </div>

                </div>
            </div>

            {{-- PRO --}}
            <div class="col-lg-4 p-0 border-featured">
                <div class="pricing-card featured" data-plan="profissional">

                    <div class="badge-top">Recomendado</div>

                    <h3 class="text-white">Plano Profissional</h3>
                    <p class="tagline">Mais autoridade e conteúdo pro seu escritório</p>

                    @if ($planProfissional)
                        <div class="price">
                            <span class="price-monthly">{{ $planProfissional->priceFormatted() }}</span>
                            <span class="price-annual d-none">{{ $planProfissional->annualMonthlyEquivalentFormatted() }}</span>
                        </div>
                        <div class="price-annual-note d-none small text-white-50">{{ $planProfissional->annualPriceFormatted() }} à vista/ano</div>

                        <hr>
                        <div class="billing-toggle">
                            <label class="switch">
                                <input type="checkbox" class="toggle-input">
                                <span class="slider"></span>
                            </label>
                            <span>Anual</span>
                            <span class="discount">{{ $planProfissional->annualDiscountPercent() }}% OFF | {{ $planProfissional->annualSavingsFormatted() }} economia</span>
                        </div>
                        <hr>

                        <a href="{{ route('jornada.start', ['plan' => 'profissional']) }}"
                           data-monthly-url="{{ route('jornada.start', ['plan' => 'profissional']) }}"
                           data-annual-url="{{ route('jornada.start', ['plan' => 'profissional', 'cycle' => 'annual']) }}"
                           class="btn btn-pricing w-100 js-plan-link">Escolher Plano ↗</a>
                    @endif

                    <div class="feature-group">
                        <h4>Personalize</h4>
                        <ul>
                            <li>Site Multipage (Home, Sobre, Serviços, Contato)</li>
                            <li>Editor do Site (Faça você mesmo)</li>
                            <li>Assistente de I.A. (Escreve os textos para você)</li>
                            <li>Integração com WhatsApp e Redes Sociais</li>
                        </ul>
                    </div>

                    <div class="feature-group">
                        <h4>Publique</h4>
                        <ul>
                            <li>Domínio Grátis</li>
                            <li>1 Conta de E-mail Profissional (10GB)</li>
                            <li>Armazenamento Expandido para Arquivos</li>
                            <li>Hospedagem e SSL Inclusos</li>
                        </ul>
                    </div>

                    <div class="feature-group">
                        <h4>Suporte</h4>
                        <ul>
                            <li>Manutenção</li>
                            <li>Otimização básica de SEO</li>
                            <li>Backup do site</li>
                        </ul>
                    </div>

                </div>
            </div>

            {{-- VIP --}}
            <div class="col-lg-4">
                <div class="pricing-card" data-plan="gestao_vip">

                    <h3>Gestão VIP</h3>
                    <p class="tagline">Pra quem não tem tempo a perder com o site</p>

                    @if ($planVip)
                        <div class="price">
                            <span class="price-monthly">{{ $planVip->priceFormatted() }}</span>
                            <span class="price-annual d-none">{{ $planVip->annualMonthlyEquivalentFormatted() }}</span>
                        </div>
                        <div class="price-annual-note d-none small text-muted">{{ $planVip->annualPriceFormatted() }} à vista/ano</div>

                        <div class="billing-toggle">
                            <label class="switch">
                                <input type="checkbox" class="toggle-input">
                                <span class="slider"></span>
                            </label>
                            <span>Anual</span>
                            <span class="discount">{{ $planVip->annualDiscountPercent() }}% OFF | {{ $planVip->annualSavingsFormatted() }} economia</span>
                        </div>

                        <hr>

                        <a href="{{ route('jornada.start', ['plan' => 'gestao_vip']) }}"
                           data-monthly-url="{{ route('jornada.start', ['plan' => 'gestao_vip']) }}"
                           data-annual-url="{{ route('jornada.start', ['plan' => 'gestao_vip', 'cycle' => 'annual']) }}"
                           class="btn btn-pricing w-100 js-plan-link">Escolher Plano ↗</a>
                    @endif

                    <div class="feature-group">
                        <h4>Personalize</h4>
                        <ul>
                            <li>Site Multipage (Home, Sobre, Serviços, Contato)</li>
                            <li>Blog Profissional (Opcional)</li>
                            <li>Serviço de Concierge (Nós editamos para você)</li>
                            <li>Editor do Site</li>
                            <li>Assistente de I.A.</li>
                            <li>Integração com WhatsApp e Redes Sociais</li>
                        </ul>
                    </div>

                    <div class="feature-group">
                        <h4>Publique</h4>
                        <ul>
                            <li>Domínio Grátis</li>
                            <li>3 Contas de E-mail Profissional (15GB cada)</li>
                            <li>Hospedagem e SSL Inclusos</li>
                        </ul>
                    </div>

                    <div class="feature-group">
                        <h4>Suporte (Prioridade Máxima)</h4>
                        <ul>
                            <li>Manutenção</li>
                            <li>Backup do site</li>
                            <li>Consultoria Mensal de SEO e Melhorias</li>
                        </ul>
                    </div>

                </div>
            </div>

        </div>

        <div class="pricing-footer aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
            <p class="footer-text">Todos os planos incluem SSL</p>
            <div class="footer-links">
                <a href="#" data-bs-toggle="modal" data-bs-target="#compareModal">
                    <i class="bi bi-list-columns-reverse"></i> Compare os planos
                </a>

                <span class="divider">|</span>

                <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">
                    <i class="bi bi-question-circle"></i> Política de Privacidade
                </a>

                <span class="divider">|</span>

                <a href="#" data-bs-toggle="modal" data-bs-target="#supportModal">
                    <i class="bi bi-headset"></i> Falar com Suporte
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // Toggle Mensal/Anual por card — cada card tem seu próprio switch.
    // Desligado (padrão) = mensal. Ligado = anual (mostra equivalente/mês,
    // nota do valor à vista, desconto real do plano, e troca o link de
    // "Escolher Plano" pra levar ?cycle=annual pra jornada).
    document.querySelectorAll('.pricing-card').forEach(function (card) {
        var toggle = card.querySelector('.toggle-input');
        if (!toggle) return;

        function apply() {
            var annual = toggle.checked;
            card.querySelectorAll('.price-monthly').forEach(function (el) {
                el.classList.toggle('d-none', annual);
            });
            card.querySelectorAll('.price-annual').forEach(function (el) {
                el.classList.toggle('d-none', !annual);
            });
            card.querySelectorAll('.price-annual-note').forEach(function (el) {
                el.classList.toggle('d-none', !annual);
            });
            var link = card.querySelector('.js-plan-link');
            if (link) {
                link.href = annual ? link.dataset.annualUrl : link.dataset.monthlyUrl;
            }
        }

        toggle.addEventListener('change', apply);
        apply();
    });
</script>
