<section id="about" class="about section">

  @php
      $aboutContent = ($content ?? [])['about'] ?? null;
      $aboutImg1 = !empty($aboutContent['image_1_url']) ? $aboutContent['image_1_url'] : asset('landing/assets/img/hero/banner-palestrante-v2.png');
      $aboutImg2 = !empty($aboutContent['image_2_url']) ? $aboutContent['image_2_url'] : asset('landing/assets/img/hero/banner-palestrante-v2.png');
  @endphp

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center gx-5 justify-content-center">
      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="image-wrapper">
          <img src="{{ $aboutImg1 }}" alt="" class="img-fluid">
        </div>
      </div>

      <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
        <div class="content">
          @if ($aboutContent && !empty($aboutContent['title_1']))
            <h2>{{ $aboutContent['title_1'] }}</h2>
          @else
            <h2>Cobrar caro exige <strong>parecer premium.</strong></h2>
          @endif

          @if ($aboutContent && !empty($aboutContent['text_1']))
            <p>{{ $aboutContent['text_1'] }}</p>
          @else
            <p>
              Sua expertise vale caro, mas o seu site (ou a falta dele) está entregando isso pro
              seu público? Um perfil de rede social bagunçado, sem organização, dilui sua
              autoridade e faz o cliente questionar seu preço antes mesmo de te conhecer.
            </p>
          @endif

        </div>
      </div>

    </div>

    <div class="row align-items-center justify-content-center gx-5 mt-5">

      <div class="col-lg-5" data-aos="fade-right" data-aos-delay="200">
        <div class="content">
          @if ($aboutContent && !empty($aboutContent['title_2']))
            <h2>{{ $aboutContent['title_2'] }}</h2>
          @else
            <h2>Ancoragem de Preço <strong>Imediata</strong></h2>
          @endif

          <div class="beneficios">
            <ul class="cor-verde">
              <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="14" height="14"> Ancoragem de Preço Imediata</li>
              <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="14" height="14"> O Seu Palco, Sem Distrações</li>
              <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="14" height="14"> Filtro para Clientes High-Ticket</li>
              <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="14" height="14"> Autonomia e Velocidade</li>
              <li><img src="{{ asset('landing/assets/img/icon/accept.svg') }}" alt="" width="14" height="14"> O Selo Definitivo de Profissionalismo</li>
            </ul>
          </div>

        </div>
      </div>

      <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
        <div class="image-wrapper">
          <img src="{{ $aboutImg2 }}" alt="" class="img-fluid">
        </div>
      </div>

    </div>

  </div>

</section>
