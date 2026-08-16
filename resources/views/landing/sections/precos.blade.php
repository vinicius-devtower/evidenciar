<section id="pricing" class="pricing section light-background">

    <!-- Section Title -->
    <div class="container section-title">
        <div class="pricing-content aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
            <h2>Muito menos que uma hora dos seus honorários</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div>
    </div><!-- End Section Title -->

    <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 justify-content-center">

            <!-- Basic Plan -->
            <div class="col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <div class="pricing-item">
                    <div class="pricing-icon">
                        <i class="bi bi-star"></i>
                    </div>
                    <h3>Plano Start</h3>
                    <p class="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor.</p>
                    <div class="price">
                        <span class="currency">R$</span>46,32<span class="period">/mês</span>
                    </div>
                    <a href="{{ route('jornada.start', ['plan' => 'start']) }}" class="btn-pricing">Criar meu site agora</a>
                    <hr>

                    <ul class="features-list">
                        <li>
                            <i class="bi bi-check2"></i>
                            Domínio Grátis com Plano Anual
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Site One-Page (Tudo em uma página)
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Hospedagem e SSL inclusos
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Editor "Faça Você Mesmo"
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Integração com WhatsApp e Redes Sociais
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Sem páginas internas
                        </li>
                    </ul>

                </div>
            </div><!-- End Basic Plan -->

            <!-- Professional Plan -->
            <div class="col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                <div class="pricing-item featured">
                    <div class="pricing-badge">Recomendado</div>
                    <div class="pricing-icon">
                        <i class="bi bi-stars"></i>
                    </div>
                    <h3>Plano Profissional</h3>
                    <p class="description">Maecenas tempus tellus eget condimentum rhoncus semper.</p>
                    <div class="price">
                        <span class="currency">R$</span>97,70<span class="period">/mês</span>
                    </div>
                    <a href="{{ route('jornada.start', ['plan' => 'profissional']) }}" class="btn-pricing">Criar meu site agora</a>
                    <hr>

                    <ul class="features-list">
                        <li>
                            <i class="bi bi-check2"></i>
                            Tudo do plano Start
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Domínio Grátis com Plano Anual
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Site Multipage (Home, Sobre, Serviços e Contato)
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Assistente de IA (Escreve os textos para você)
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            1 Conta de E-mail Profissional (10GB)
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Armazenamento Expandido para Arquivos
                        </li>
                    </ul>

                </div>
            </div><!-- End Professional Plan -->

            <!-- Ultimate Plan -->
            <div class="col-lg-4 col-md-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                <div class="pricing-item">
                    <div class="pricing-icon">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <h3>Gestão VIP</h3>
                    <p class="description">Etiam rhoncus maecenas tempus tellus eget condimentum.</p>
                    <div class="price">
                        <span class="currency" data-bs-toggle="modal" data-bs-target="#leadModal">R$</span>297,90<span class="period">/mês</span>
                    </div>

                    <a href="{{ route('jornada.start', ['plan' => 'gestao_vip']) }}" class="btn-pricing">Criar meu site agora</a>
                    <hr>

                    <ul class="features-list">
                        <li>
                            <i class="bi bi-check2"></i>
                            Domínio Grátis com Plano Anual
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Serviço de Concierge: Nós editamos o site para você (solicite via WhatsApp)
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Blog Profissional (Opcional)
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Prioridade Máxima no Suporte
                        </li>
                        <li>
                            <i class="bi bi-check2"></i>
                            Consultoria Mensal de SEO/Melhorias
                        </li>
                    </ul>

                </div>
            </div><!-- End Ultimate Plan -->

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