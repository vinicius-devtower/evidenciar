{{--
    Template Elegante v1 — paleta sóbria (preto + dourado).
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
    $primary    = $brand['color_primary'] ?? ($brand['primary_color']   ?? '#c8a24a');
    $secondary  = $brand['color_icons']   ?? ($brand['secondary_color'] ?? '#0f0f10');
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root{
            --cor-primaria:   {{ $primary }};
            --cor-secundaria: {{ $secondary }};
            --cor-bg:         #0f0f10;
            --cor-surface:    #1a1a1c;
            --cor-texto:      #f5f1e8;
            --cor-muted:      #a8a29c;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        html{scroll-behavior:smooth;}
        body{
            font-family:'Inter',sans-serif;
            color:var(--cor-texto);
            background:var(--cor-bg);
            line-height:1.7;
        }
        .container{max-width:1200px;margin:0 auto;padding:0 32px;}
        section{padding:120px 0;}
        h1,h2,h3{font-family:'Playfair Display',serif;font-weight:700;letter-spacing:-.01em;line-height:1.15;}
        h1{font-size:clamp(2.5rem,5vw,4.5rem);}
        h2{font-size:clamp(2rem,3.5vw,3rem);margin-bottom:24px;}
        a{color:var(--cor-primaria);text-decoration:none;}
        img{max-width:100%;display:block;}

        .header{
            position:sticky;top:0;z-index:50;
            background:rgba(15,15,16,.92);
            backdrop-filter:blur(10px);
            padding:20px 0;
            border-bottom:1px solid rgba(200,162,74,.15);
        }
        .header-inner{display:flex;justify-content:space-between;align-items:center;}
        .brand{
            display:flex;align-items:center;gap:14px;
            font-family:'Playfair Display',serif;font-size:1.4rem;font-weight:700;
            color:var(--cor-primaria);letter-spacing:.02em;
        }
        .brand img{height:40px;}
        .nav a{margin-left:32px;color:var(--cor-texto);font-weight:500;font-size:.95rem;transition:color .2s;}
        .nav a:hover{color:var(--cor-primaria);}

        .btn{
            display:inline-block;padding:16px 36px;border-radius:2px;
            font-weight:600;font-size:.95rem;letter-spacing:.08em;text-transform:uppercase;
            transition:.2s;cursor:pointer;border:1px solid var(--cor-primaria);
        }
        .btn-primary{background:var(--cor-primaria);color:var(--cor-secundaria);}
        .btn-primary:hover{background:transparent;color:var(--cor-primaria);}
        .btn-ghost{background:transparent;color:var(--cor-primaria);}

        .hero{
            padding:140px 0 120px;
            background:
                radial-gradient(ellipse at top right, rgba(200,162,74,.08), transparent 60%),
                var(--cor-bg);
            position:relative;
        }
        .hero::before{
            content:"";position:absolute;inset:0;
            background-image:url("data:image/svg+xml,%3Csvg width='60' height='60' xmlns='http://www.w3.org/2000/svg'%3E%3Crect fill='%23c8a24a' fill-opacity='.02' width='30' height='30'/%3E%3Crect fill='%23c8a24a' fill-opacity='.02' x='30' y='30' width='30' height='30'/%3E%3C/svg%3E");
            pointer-events:none;
        }
        .hero-inner{position:relative;text-align:center;max-width:800px;margin:0 auto;}
        .hero-eyebrow{
            display:inline-block;color:var(--cor-primaria);font-size:.85rem;letter-spacing:.3em;
            text-transform:uppercase;margin-bottom:24px;
        }
        .hero h1{margin-bottom:24px;}
        .hero p{font-size:1.2rem;color:var(--cor-muted);max-width:60ch;margin:0 auto;}
        .hero .cta{margin-top:40px;}

        .about{background:var(--cor-surface);}
        .about-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center;}
        .about p{color:var(--cor-muted);font-size:1.05rem;margin-bottom:16px;}
        .highlights{display:flex;flex-direction:column;gap:20px;}
        .highlight{
            display:flex;align-items:center;gap:20px;padding:20px 0;
            border-bottom:1px solid rgba(200,162,74,.15);
        }
        .highlight:last-child{border-bottom:none;}
        .highlight::before{
            content:"—";color:var(--cor-primaria);font-size:1.5rem;font-weight:300;
        }
        @media (max-width:860px){.about-grid{grid-template-columns:1fr;gap:40px;}}

        .services-intro{max-width:62ch;color:var(--cor-muted);font-size:1.1rem;margin-bottom:64px;}
        .services-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:40px;}
        .service-card{
            padding:40px 32px;border:1px solid rgba(200,162,74,.2);
            background:var(--cor-surface);transition:.3s;
        }
        .service-card:hover{border-color:var(--cor-primaria);}
        .service-number{
            color:var(--cor-primaria);font-family:'Playfair Display',serif;font-size:2.5rem;
            margin-bottom:20px;display:block;font-weight:400;
        }
        .service-card p{color:var(--cor-muted);font-size:.95rem;margin-top:10px;}
        @media (max-width:860px){.services-grid{grid-template-columns:1fr;}}

        .contact{background:var(--cor-surface);}
        .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;}
        .contact-item{padding:20px 0;border-bottom:1px solid rgba(200,162,74,.15);}
        .contact-label{color:var(--cor-primaria);font-size:.8rem;letter-spacing:.3em;
            text-transform:uppercase;margin-bottom:8px;}
        .contact-value{color:var(--cor-texto);font-size:1.1rem;}
        form input, form textarea{
            width:100%;padding:16px;background:transparent;color:var(--cor-texto);
            border:1px solid rgba(200,162,74,.3);border-radius:2px;
            font-family:inherit;font-size:1rem;margin-bottom:16px;transition:border-color .2s;
        }
        form input:focus, form textarea:focus{outline:none;border-color:var(--cor-primaria);}
        form input::placeholder, form textarea::placeholder{color:var(--cor-muted);}
        @media (max-width:860px){.contact-grid{grid-template-columns:1fr;gap:40px;}}

        footer{
            padding:40px 0;text-align:center;color:var(--cor-muted);font-size:.85rem;
            border-top:1px solid rgba(200,162,74,.15);
        }
        .social-links{margin-top:12px;}
        .social-links a{margin:0 12px;color:var(--cor-primaria);font-weight:500;}
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
        <div class="hero-inner">
            <div class="hero-eyebrow">{{ $hero['eyebrow'] ?? 'Bem-vindo' }}</div>
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
    </div>
</section>

<section class="about" id="about">
    <div class="container">
        <div class="about-grid">
            <div>
                <h2>{{ $about['title'] ?? 'Quem somos' }}</h2>
                <p>{{ $about['description'] ?? 'Somos uma equipe dedicada a entregar qualidade em cada projeto.' }}</p>
            </div>
            <div class="highlights">
                @foreach (['highlight_1','highlight_2','highlight_3'] as $k)
                    @if (!empty($about[$k]))<div class="highlight">{{ $about[$k] }}</div>@endif
                @endforeach
            </div>
        </div>
    </div>
</section>

<section id="services">
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
                        <span class="service-number">0{{ $n }}</span>
                        <h3 style="font-size:1.3rem;">{{ $t }}</h3>
                        <p>{{ $d }}</p>
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
                <p style="color:var(--cor-muted);margin-bottom:32px;">
                    {{ $contact['intro'] ?? 'Preencha o formulário ou use os contatos abaixo.' }}
                </p>
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
                    <input type="text" placeholder="NOME" required>
                    <input type="email" placeholder="E-MAIL" required>
                    <textarea rows="5" placeholder="MENSAGEM" required></textarea>
                    <button type="submit" class="btn btn-primary" style="width:100%;">Enviar</button>
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
