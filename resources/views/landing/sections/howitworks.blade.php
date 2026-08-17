<section id="como-funciona" class="howitworks featured-services section">

    <div class="container section-title aos-init aos-animate" data-aos="fade-up">

        <div class="supporting-text mt-5">
            <ul>
                <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="18" height="18"> Personalização e publicação</li>
            </ul>
        </div>

        <div class="section-call mt-5">
            <h2>3 passos simples.<br>Não precisa de <strong class="cor-verde">programador.</strong></h2>
            <p>O maior medo de quem nunca teve site não é o preço, é achar que não vai saber usar. Na Evidenciar você mesmo cria o seu hoje — se sabe mandar um e-mail, sabe editar seu site.</p>
        </div>

    </div>

    <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">

        <div class="row d-flex justify-content-center align-items-center gap-35">

            <div class="col-lg-3 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                <div class="hwt-card">
                    <div class="hwt-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="hwt-image">
                        <img src="{{ asset('landing/assets/img/how-it-works/escolha-seu-palco.png') }}" alt="" class="img-fluid" loading="lazy">
                    </div>
                    <div class="hwt-content mt-5 cor-areia">
                        <h3>1. Crie sua conta</h3>
                        <p>Cadastro em 1 minuto e você já escolhe o modelo pronto pra sua profissão.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                <div class="hwt-card">
                    <div class="hwt-icon">
                        <i class="fas fa-brain"></i>
                    </div>
                    <div class="hwt-image">
                        <img src="{{ asset('landing/assets/img/how-it-works/personalize-rapido.png') }}" alt="" class="img-fluid" loading="lazy">
                    </div>
                    <div class="hwt-content mt-5 cor-areia">
                        <h3>2. Personalize rápido</h3>
                        <p>Troque texto, coloque seu logo e escolha a cor da sua marca. Impossível quebrar o design.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                <div class="hwt-card">
                    <div class="hwt-icon">
                        <i class="fas fa-bone"></i>
                    </div>
                    <div class="hwt-image">
                        <img src="{{ asset('landing/assets/img/how-it-works/publique-seu-link.png') }}" alt="" class="img-fluid" loading="lazy">
                    </div>
                    <div class="hwt-content mt-5 cor-areia">
                        <h3>3. Publique seu site</h3>
                        <p>Conecte seu domínio (ex: seuescritorio.com.br) e fique no ar hoje mesmo. Sem esperar 30-60 dias de agência.</p>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="container mt-5 mb-5">
        <div class="row text-center">
            <div>
                <a href="{{ route('jornada.start') }}" class="btn-primary">Quero meu site a partir de {{ optional($plans['start'] ?? null)->priceFormatted() ?? 'R$ 49,90' }} / mês</a>
            </div>
        </div>
    </div>

</section>
