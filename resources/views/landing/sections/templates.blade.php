<section id="templates" class="templates section">
  <div class="container section-title aos-init aos-animate" data-aos="fade-up">
    <div class="supporting-text mt-5">
      <ul>
        <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="18" height="18"> Modelos pensados em resultados</li>
      </ul>
    </div>
    @php $templatesContent = ($content ?? [])['templates_section'] ?? null; @endphp
    <div class="section-call mt-5">
      @if ($templatesContent && !empty($templatesContent['title']))
        <h2>{{ $templatesContent['title'] }}</h2>
      @else
        <h2>Modelos desenhados para<br>colocar <strong class="cor-verde">você em evidência</strong></h2>
      @endif
      @if ($templatesContent && !empty($templatesContent['subtitle']))
        <p>{{ $templatesContent['subtitle'] }}</p>
      @else
        <p>Esqueça a tela em branco e o design amador. Nossos templates foram estruturados dentro do que cada profissão exige — sério, sóbrio e <strong class="cor-verde">pensado pra gerar autoridade</strong> pra você.</p>
      @endif
    </div>
    <div class="text-center mt-5 d-flex justify-content-center align-items-center gap-35">
      <a href="{{ route('jornada.start') }}" class="btn-primary">Quero meu site a partir de {{ optional($plans['start'] ?? null)->priceFormatted() ?? 'R$ 49,90' }} / mês</a>
      <a href="#" class="btn-clean">Falar com Equipe no WhatsApp</a>
    </div>

    <div class="templates-carousel mt-5">

      <div class="stack">
        <div class="stack-layer layer-1"></div>
        <div class="stack-layer layer-2"></div>
        <div class="stack-layer layer-3"></div>
      </div>

      <div class="carousel-track" id="carouselTrack">

        <div class="template-card active"
          data-title="O Mentor"
          data-desc="Ideal para quem vende mentorias e programas de transformação.">
          <img src="{{ asset('landing/assets/img/templates/template1.jpeg') }}" alt="Template O Mentor" loading="lazy">
        </div>

        <div class="template-card"
          data-title="O Consultor"
          data-desc="Organizado e objetivo, transmite controle e confiança.">
          <img src="{{ asset('landing/assets/img/templates/template2.jpeg') }}" alt="Template O Consultor" loading="lazy">
        </div>

        <div class="template-card"
          data-title="Palestrante"
          data-desc="Perfeito para quem vive de palco, presença e autoridade.">
          <img src="{{ asset('landing/assets/img/templates/template3.jpeg') }}" alt="Template Palestrante" loading="lazy">
        </div>

      </div>

      <div class="template-meta">

        <div class="template-text">
          <h4 id="template-title">O Mentor</h4>
          <p id="template-desc">
            Ideal para quem vende mentorias e programas de transformação.
          </p>
        </div>

        <div class="carousel-controls">
          <button id="prev" aria-label="Anterior">
            <i class="bi bi-arrow-down"></i>
          </button>

          <button id="next" aria-label="Próximo">
            <i class="bi bi-arrow-up"></i>
          </button>
        </div>

      </div>

    </div>
  </div>

</section>
