<!-- SECTION HERO -->
@php
    // $content é injetado apenas quando essa view é renderizada como Site
    // (SiteBuilderService/PublicSiteController). Na landing estática
    // (LandingController) essa variável não existe, então tudo cai no
    // texto padrão abaixo.
    $heroContent = ($content ?? [])['hero'] ?? null;
    $heroTags = !empty($heroContent['tags'])
        ? array_filter(array_map('trim', explode(',', $heroContent['tags'])))
        : ['Palestrantes', 'Mentores', 'Coaches', 'Professores'];
    $heroImage = !empty($heroContent['image_url']) ? $heroContent['image_url'] : asset('landing/assets/img/hero/banner-palestrante-v2.png');
@endphp
<section id="meu-escritorio" class="hero section light-background hero-slit">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row align-items-center">
      <div class="col-lg-12">
        <div class="hero-content">

          <div class="container-text">
            @if ($heroContent && !empty($heroContent['headline']))
              <h1 data-aos="fade-up" data-aos-delay="200">{{ $heroContent['headline'] }}</h1>
            @else
              <h1 data-aos="fade-up" data-aos-delay="200">Sua marca pessoal no <strong class="cor-verde">topo.</strong><br>O palco digital que ancora<br><strong class="cor-verde">sua autoridade.</strong></h1>
            @endif

            @if ($heroContent && !empty($heroContent['subheadline']))
              <p data-aos="fade-up" data-aos-delay="300" class="cor-azul-escuro mt-3">{{ $heroContent['subheadline'] }}</p>
            @else
              <p data-aos="fade-up" data-aos-delay="300" class="cor-azul-escuro mt-3">Reúna suas palestras, mentorias e contatos em um site que reflete o seu verdadeiro valor. Feito para quem vende conhecimento.</p>
            @endif
          </div>

          <div class="hero-cta" data-aos="fade-up" data-aos-delay="400">

            <div class="tags-hero">
              <ul>
                @foreach ($heroTags as $tag)
                  <li>{{ $tag }}</li>
                @endforeach
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
        <img src="{{ $heroImage }}" alt="" class="img-fluid">
      </div>

    </div>

  </div>

</section>
