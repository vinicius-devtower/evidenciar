<section id="como-funciona" class="howitworks featured-services section">

    <div class="container section-title aos-init aos-animate" data-aos="fade-up">

        <div class="supporting-text mt-5">
            <ul>
                <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="18" height="18"> Personalização e publicação</li>
            </ul>
        </div>

        <div class="section-call mt-5">
            <h2>Do zero ao seu palco digital<br>em 3 passos <strong class="cor-verde">(Zero Código)</strong></h2>
            <p>Esqueça a complexidade. Na Evidenciar, você mesmo cira seu site hoje, tão fácil quanto usar suas redes sociais. Nós cuidamos da tecnologia, você foca no conteúdo.</p>
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
                        <h3>1. Escolha seu palco</h3>
                        <p>Templates estratégicos e prontos para vender palestras, cursos ou mentorias.</p>
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
                        <p>Altere textos, cores e suba sua foto em poucos cliques. É impossível quebrar o desing.</p>
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
                        <h3>3. Publique seu link</h3>
                        <p>Conecte seu domínio (ex: seunome.com.br) e tenhas um link de peso para enviar aos clientes.</p>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="container mt-5 mb-5">
        <div class="row text-center">
            <div>
                <a href="{{ route('jornada.start') }}" class="btn-primary">Quero meu site a partir de {{ optional($plans['start'] ?? null)->priceFormatted() ?? 'R$ 47,90' }} / mês</a>
            </div>
        </div>
    </div>

</section>
