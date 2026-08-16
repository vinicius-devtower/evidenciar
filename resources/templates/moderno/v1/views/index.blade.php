{{--
    Template Moderno v1 — paleta vibrante (roxo + laranja).
    Lê:
      - $site, $content
      - Branding global: $content['_branding']
      - Contato global:  $content['_contact_global']
--}}
@php
    $hero     = $content['hero']     ?? [];
    $about    = $content['about']    ?? [];
    $services = $content['services'] ?? [];
    $contact  = $content['contact']  ?? [];
    $brand    = $content['_branding'] ?? [];
    $globalCt = $content['_contact_global'] ?? [];

    $ct = function (string $k) use ($globalCt) {
        $v = $globalCt[$k] ?? null;
        if (is_array($v))  return !empty($v['enabled']) ? $v : null;
        if (is_string($v) && $v !== '') return ['enabled' => true, 'value' => $v, 'message' => ''];
        return null;
    };
    $whatsapp  = $ct('whatsapp');
    $email     = $ct('email');
    $instagram = $ct('instagram');
    $facebook  = $ct('facebook');
    $linkedin  = $ct('linkedin');
    $xSocial   = $ct('x');
    $phone     = $ct('phone');

    $siteName   = $site->name ?? 'Meu Site';
    $logoUrl    = $brand['logo_url']     ?? null;
    $logoAltUrl = $brand['logo_alt_url'] ?? null;
    $primary    = $brand['color_primary'] ?? ($brand['primary_color']   ?? '#7c3aed');
    $secondary  = $brand['color_icons']   ?? ($brand['secondary_color'] ?? '#f97316');
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --cor-primaria:   {{ $primary }};
            --cor-secundaria: {{ $secondary }};
            --cor-texto:      #1a0a2e;
            --cor-muted:      #5a4a72;
            --cor-bg:         #fffaf5;
            --cor-surface:    #ffffff;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        html{scroll-behavior:smooth;}
        body{
            font-family:'Poppins',sans-serif;
            color:var(--cor-texto);
            background:var(--cor-bg);
            line-height:1.6;
        }
        .container{max-width:1200px;margin:0 auto;padding:0 24px;}
        section{padding:100px 0;}
        h1,h2,h3{font-weight:800;line-height:1.1;}
        h1{font-size:clamp(2.5rem,5vw,4rem);}
        h2{font-size:clamp(2rem,3.5vw,2.75rem);margin-bottom:24px;}
        a{text-decoration:none;color:inherit;}
        img{max-width:100%;display:block;}

        .header{
            position:sticky;top:0;z-index:50;
            background:rgba(255,250,245,.95);
            backdrop-filter:blur(10px);
            padding:18px 0;
        }
        .header-inner{display:flex;justify-content:space-between;align-items:center;}
        .brand{display:flex;align-items:center;gap:12px;font-weight:800;font-size:1.2rem;}
        .brand img{height:36px;}
        .nav a{margin-left:32px;font-weight:600;transition:color .2s;}
        .nav a:hover{color:var(--cor-primaria);}

        .btn{
            display:inline-block;padding:14px 28px;border-radius:999px;font-weight:700;
            font-size:1rem;transition:.2s;cursor:pointer;border:none;
        }
        .btn-primary{
            background:linear-gradient(135deg,var(--cor-primaria),var(--cor-secundaria));
            color:#fff;
        }
        .btn-primary:hover{transform:translateY(-2px);box-shadow:0 12px 24px rgba(124,58,237,.3);}

        .hero{
            padding:120px 0 100px;
            background:
                radial-gradient(circle at 10% 20%, rgba(124,58,237,.12), transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(249,115,22,.12), transparent 40%);
        }
        .hero-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:64px;align-items:center;}
        .hero h1 + p{margin-top:24px;font-size:1.2rem;color:var(--cor-muted);max-width:55ch;}
        .hero .cta{margin-top:36px;}
        .hero-image{
            border-radius:24px;overflow:hidden;aspect-ratio:1;
            background:linear-gradient(135deg,var(--cor-primaria) 0%,var(--cor-secundaria) 100%);
            display:flex;align-items:center;justify-content:center;
            font-size:6rem;color:rgba(255,255,255,.8);
            box-shadow:0 24px 60px rgba(124,58,237,.25);
        }
        @media (max-width:860px){.hero-grid{grid-template-columns:1fr;}}

        .about{background:var(--cor-surface);}
        .about-grid{display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center;}
        .highlights{display:grid;gap:16px;margin-top:24px;}
        .highlight{
            background:linear-gradient(90deg,rgba(124,58,237,.06),transparent);
            border-left:4px solid var(--cor-primaria);
            padding:16px 20px;border-radius:0 12px 12px 0;font-weight:600;
        }
        @media (max-width:860px){.about-grid{grid-template-columns:1fr;}}

        .services{background:linear-gradient(180deg,var(--cor-bg) 0%,var(--cor-surface) 100%);}
        .services-intro{max-width:62ch;margin-bottom:48px;color:var(--cor-muted);font-size:1.1rem;}
        .services-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px;}
        .service-card{
            background:#fff;padding:36px 28px;border-radius:20px;
            box-shadow:0 10px 40px rgba(26,10,46,.06);
            transition:.25s;
        }
        .service-card:hover{transform:translateY(-6px);box-shadow:0 20px 50px rgba(124,58,237,.15);}
        .service-icon{
            width:56px;height:56px;border-radius:14px;
            background:linear-gradient(135deg,var(--cor-primaria),var(--cor-secundaria));
            color:#fff;display:flex;align-items:center;justify-content:center;
            font-weight:800;font-size:1.2rem;margin-bottom:20px;
        }
        @media (max-width:860px){.services-grid{grid-template-columns:1fr;}}

        .contact{
            background:linear-gradient(135deg,var(--cor-primaria),var(--cor-secundaria));
            color:#fff;
        }
        .contact h2, .contact .label{color:#fff;}
        .contact p{color:rgba(255,255,255,.9);}
        .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:48px;}
        .contact-item{margin-bottom:20px;}
        .contact-label{font-weight:700;font-size:.85rem;opacity:.8;text-transform:uppercase;letter-spacing:.5px;}
        .contact-value{font-size:1.1rem;margin-top:4px;}
        form input, form textarea{
            width:100%;padding:14px 16px;border:none;border-radius:12px;
            background:rgba(255,255,255,.9);font-family:inherit;font-size:1rem;
            margin-bottom:14px;
        }
        form button{background:#fff;color:var(--cor-primaria);font-weight:700;}
        @media (max-width:860px){.contact-grid{grid-template-columns:1fr;}}

        footer{
            padding:40px 0;text-align:center;background:var(--cor-texto);color:rgba(255,255,255,.7);
        }
        .social-links{margin-top:12px;}
        .social-links a{margin:0 10px;color:#fff;opacity:.8;font-weight:600;}
        .social-links a:hover{opacity:1;}
    </style>
</head>
<body>

<header class="header">
    <div class="container header-inner">
        <div class="brand">
            @if ($logoUrl)<img src="{{ $logoUrl }}" alt="{{ $siteName }}">@endif
            <span>{{ $siteName }}</span>
        </div>
        <nav class="nav">
            <a href="#about">Sobre</a>
            <a href="#services">Serviços</a>
            <a href="#contact">Contato</a>
        </nav>
    </div>
</header>

<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div>
                @if(!empty($hero['eyebrow']))
                    <div style="color:var(--cor-primaria);font-weight:800;font-size:.8rem;letter-spacing:.22em;text-transform:uppercase;margin-bottom:18px;">
                        {{ $hero['eyebrow'] }}
                    </div>
                @endif
                <h1>{{ $hero['headline'] ?? 'Transforme seu negócio com soluções sob medida' }}</h1>
                <p>{{ $hero['subheadline'] ?? 'Atendimento especializado, entregas rápidas e resultados que você pode medir.' }}</p>
                @if(!empty($hero['cta_label']))
                    <div class="cta">
                        <a href="{{ $hero['cta_url'] ?? '#contact' }}" class="btn btn-primary">
                            {{ $hero['cta_label'] }}
                        </a>
                    </div>
                @endif
            </div>
            <div>
                @if (!empty($hero['image_url']))
                    <div class="hero-image"><img src="{{ $hero['image_url'] }}" alt=""></div>
                @else
                    <div class="hero-image">✦</div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="about" id="about">
    <div class="container">
        <div class="about-grid">
            <div>
                <h2>{{ $about['title'] ?? 'Quem somos' }}</h2>
                <p>{{ $about['description'] ?? 'Somos uma equipe dedicada a entregar qualidade em cada projeto.' }}</p>
            </div>
            <div>
                <div class="highlights">
                    @foreach (['highlight_1','highlight_2','highlight_3'] as $k)
                        @if (!empty($about[$k]))<div class="highlight">{{ $about[$k] }}</div>@endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="services" id="services">
    <div class="container">
        <h2>{{ $services['title'] ?? 'Nossos serviços' }}</h2>
        <p class="services-intro">{{ $services['intro'] ?? 'Soluções completas para o seu negócio.' }}</p>
        <div class="services-grid">
            @foreach ([1,2,3] as $n)
                @php
                    $t = $services["service_{$n}_title"] ?? null;
                    $d = $services["service_{$n}_description"] ?? null;
                @endphp
                @if ($t || $d)
                    <div class="service-card">
                        <div class="service-icon">0{{ $n }}</div>
                        <h3>{{ $t }}</h3>
                        <p style="margin-top:8px;color:var(--cor-muted);">{{ $d }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

<section class="contact" id="contact">
    <div class="container">
        <div class="contact-grid">
            <div>
                <h2>{{ $contact['title'] ?? 'Vamos conversar' }}</h2>
                <p style="margin-bottom:28px;">{{ $contact['intro'] ?? 'Preencha o formulário ou use os contatos abaixo.' }}</p>
                @if($whatsapp)
                    <div class="contact-item">
                        <div class="contact-label">WhatsApp</div>
                        <div class="contact-value">{{ $whatsapp['value'] }}</div>
                    </div>
                @endif
                @if($email)
                    <div class="contact-item">
                        <div class="contact-label">E-mail</div>
                        <div class="contact-value">{{ $email['value'] }}</div>
                    </div>
                @endif
                @if($phone)
                    <div class="contact-item">
                        <div class="contact-label">Telefone</div>
                        <div class="contact-value">{{ $phone['value'] }}</div>
                    </div>
                @endif
                @if(!empty($contact['address']))
                    <div class="contact-item">
                        <div class="contact-label">Endereço</div>
                        <div class="contact-value">{{ $contact['address'] }}</div>
                    </div>
                @endif
            </div>
            <div>
                <form onsubmit="event.preventDefault(); alert('Mensagem enviada! (demo)');">
                    <input type="text" placeholder="Nome" required>
                    <input type="email" placeholder="E-mail" required>
                    <textarea rows="5" placeholder="Mensagem" required></textarea>
                    <button type="submit" class="btn" style="width:100%;">Enviar mensagem</button>
                </form>
            </div>
        </div>
    </div>
</section>

<footer>
    <div class="container">
        &copy; {{ date('Y') }} {{ $siteName }}. Todos os direitos reservados.
        @php
            $socials = array_filter([
                'Instagram' => $instagram,
                'Facebook'  => $facebook,
                'LinkedIn'  => $linkedin,
                'X'         => $xSocial,
            ]);
        @endphp
        @if (count($socials) > 0)
            <div class="social-links">
                @foreach ($socials as $label => $channel)
                    <a href="{{ $channel['value'] }}" target="_blank">{{ $label }}</a>
                @endforeach
            </div>
        @endif
    </div>
</footer>

</body>
</html>
