<!-- SECTION HERO -->
<section id="meu-escritorio" class="hero section light-background hero-slit">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="hero-content">

          <div class="container-text">
            <h1 data-aos="fade-up" data-aos-delay="200">Sua empresa fora do Google <strong class="cor-verde">não existe.</strong><br>Tenha seu site profissional<br>no ar <strong class="cor-verde">hoje mesmo.</strong></h1>
            <p data-aos="fade-up" data-aos-delay="300" class="cor-azul-escuro mt-3">A vitrine digital pronta para Advogados, Contadores e Consultores. Sem custos de agência, sem complexidade técnica.</p>
          </div>

          <div class="hero-cta" data-aos="fade-up" data-aos-delay="400">

            <div class="tags-hero">
              <ul>
                <li>Advogados</li>
                <li>Contadores</li>
                <li>Consultores</li>
                <li>Arquitetos</li>
              </ul>
            </div>

            <div class="buttons-hero mt-5">
              <a href="{{ route('jornada.start') }}" class="btn-primary">Quero meu site a partir de {{ optional($plans['start'] ?? null)->priceFormatted() ?? 'R$ 49,90' }} / mês</a>
              <a href="#" class="btn-clean">Falar com Equipe no WhatsApp</a>
            </div>

            <div class="info mt-4">
              <span>Hospedagem inclusa. Sem taxa adicionais. Zero Código.</span>
            </div>

          </div>
        </div>
      </div>

      <div class="hero-image" data-aos="fade-left" data-aos-delay="300">
        <img src="{{ asset('landing/assets/img/hero/banner-palestrante-v2.png') }}" alt="" class="img-fluid">
      </div>

    </div>

  </div>

</section>
