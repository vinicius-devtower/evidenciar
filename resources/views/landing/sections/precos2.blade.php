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
                    Menos que a venda de um único<br>
                    <span class="highlight">ingresso ou sessão.</span>
                </h2>

                <p class="pricing-subtitle">
                    Escolha o <span class="highlight">plano ideal</span> para o momento da sua carreira.
                </p>

            </div>
        </div>
    </div>

    <div class="container">
        <div class="row gy-4 justify-content-center mt-5">

            {{-- START --}}
            <div class="col-lg-4">
                <div class="pricing-card" data-plan="start">

                    <h3>Plano Start</h3>
                    <p class="tagline">Para quem está começando</p>

                    <div class="price" data-price="">R$ 46,32</div>

                    <hr>
                    <div class="billing-toggle">
                        <label class="switch">
                            <input type="checkbox" class="toggle-input" checked>
                            <span class="slider"></span>
                        </label>
                        <span>Anual</span>
                        <span class="discount">20% OFF | R$ 120,00 economia</span>
                    </div>
                    <hr>

                    <a href="{{ route('jornada.start', ['plan' => 'start']) }}" class="btn btn-pricing w-100">Escolher Plano ↗</a>

                    <div class="feature-group">
                        <h4>Personalize</h4>
                        <ul>
                            <li>Site One Page</li>
                            <li>Editor do Site (Faça você mesmo)</li>
                            <li>Integração com WhatsApp e Redes Sociais</li>
                        </ul>
                    </div>

                    <div class="feature-group">
                        <h4>Publique</h4>
                        <ul>
                            <li>Domínio Grátis</li>
                            <li>1 Conta de E-mail Profissional (10GB)</li>
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
                    <p class="tagline">Para escritórios em crescimento</p>

                    <div class="price" data-price="">R$ 97,70</div>

                    <hr>
                    <div class="billing-toggle">
                        <label class="switch">
                            <input type="checkbox" class="toggle-input" checked>
                            <span class="slider"></span>
                        </label>
                        <span>Anual</span>
                        <span class="discount">20% OFF | R$ 120,00 economia</span>
                    </div>
                    <hr>

                    <a href="{{ route('jornada.start', ['plan' => 'profissional']) }}" class="btn btn-pricing w-100">Escolher Plano ↗</a>

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
                    <p class="tagline">Para quem não tem tempo a perder</p>

                    <div class="price" data-price="">R$ 297,90</div>

                    <div class="billing-toggle">
                        <label class="switch">
                            <input type="checkbox" class="toggle-input" checked>
                            <span class="slider"></span>
                        </label>
                        <span>Anual</span>
                        <span class="discount">20% OFF | R$ 120,00 economia</span>
                    </div>

                    <hr>

                    <a href="{{ route('jornada.start', ['plan' => 'gestao_vip']) }}" class="btn btn-pricing w-100">Escolher Plano ↗</a>

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
                            <li>5 Contas de E-mail Profissional</li>
                            <li>Hospedagem e SSL Inclusos</li>
                        </ul>
                    </div>

                    <div class="feature-group">
                        <h4>Suporte (Prioridade Máxima)</h4>
                        <ul>
                            <li>Manutenção</li>
                            <li>Backup do site</li>
                            <li>Otimização básica de SEO</li>
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
