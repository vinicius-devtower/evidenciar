<section id="templates" class="templates section">
  <div class="container section-title aos-init aos-animate" data-aos="fade-up">
    <div class="supporting-text mt-5">
      <ul>
        <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="18" height="18"> Modelos pensados em resultados</li>
      </ul>
    </div>
    <div class="section-call mt-5">
      <h2>Modelos desenhados para<br><strong class="cor-verde">colocar você</strong> em evidência</h2>
      <p>Esqueça a tela em branco e o design amador. Nossos templates premium foram estruturados por especialistas com um único objetivo: <strong class="cor-verde">transformar a sua audiência em clientes de alto valor.</strong></p>
    </div>
    <div class="text-center mt-5 d-flex justify-content-center align-items-center gap-35">
      <a href="{{ route('jornada.start') }}" class="btn-primary">Quero meu site a partir de R$46,32 / mês</a>
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
          data-title="Modelo: O Mentor"
          data-desc="Design clean e sofisticado para contratação corporativa.">
          <img src="{{ asset('landing/assets/img/templates/template1.jpeg') }}" alt="Template O Mentor" loading="lazy">
        </div>

        <div class="template-card"
          data-title="Modelo: O Consultor"
          data-desc="Alta conversão para serviços profissionais.">
          <img src="{{ asset('landing/assets/img/templates/template2.jpeg') }}" alt="Template Consultor" loading="lazy">
        </div>

        <div class="template-card"
          data-title="Modelo: Palestrante"
          data-desc="Perfeito lorem ipsun dolor sun amet si.">
          <img src="{{ asset('landing/assets/img/templates/template3.jpeg') }}" alt="Template Palestrante" loading="lazy">
        </div>

      </div>

      <div class="template-meta">

        <div class="template-text">
          <h4 id="template-title">O Mentor</h4>
          <p id="template-desc">
            Design clean e sofisticado para contratação corporativa.
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
