{{--
    Template Clean v1 — Renderização pública/preview.
    Recebe:
      - $site    (App\Models\Site)
      - $content (array JSON salvo em sites.content)
    Cada seção puxa seu bloco de $content e cai em defaults se estiver vazio.
--}}
@php
    $hero     = $content['hero']     ?? [];
    $about    = $content['about']    ?? [];
    $services = $content['services'] ?? [];
    $contact  = $content['contact']  ?? [];
    $brand    = $content['_branding'] ?? [];
    $globalCt = $content['_contact_global'] ?? [];

    // Normaliza cada canal de contato: aceita novo shape ({enabled, value, message})
    // e shape legacy (string solta). Só retorna se enabled=true (ou se for string não-vazia).
    $ct = function (string $k) use ($globalCt) {
        $v = $globalCt[$k] ?? null;
        if (is_array($v)) {
            return !empty($v['enabled']) ? $v : null;
        }
        if (is_string($v) && $v !== '') {
            return ['enabled' => true, 'value' => $v, 'message' => ''];
        }
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
    $primary    = $brand['color_primary'] ?? ($brand['primary_color']   ?? '#2563eb');
    $secondary  = $brand['color_icons']   ?? ($brand['secondary_color'] ?? '#1d4ed8');
    $colorContact = $brand['color_contact'] ?? $primary;
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteName }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{
            --color-bg:       #ffffff;
            --color-fg:       #0f172a;
            --color-muted:    #64748b;
            --color-accent:   {{ $primary }};
            --color-accent-2: {{ $secondary }};
            --color-surface:  #f8fafc;
            --color-border:   #e2e8f0;
            --radius:         14px;
        }
        *{box-sizing:border-box;margin:0;padding:0;}
        html{scroll-behavior:smooth;}
        body{
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            color: var(--color-fg);
            background: var(--color-bg);
            line-height: 1.55;
            -webkit-font-smoothing: antialiased;
        }
        .container{max-width:1120px;margin:0 auto;padding:0 24px;}
        section{padding:88px 0;}
        h1,h2,h3{font-weight:700;letter-spacing:-0.02em;line-height:1.15;}
        h1{font-size:clamp(2rem,4vw,3.25rem);}
        h2{font-size:clamp(1.625rem,3vw,2.25rem);margin-bottom:16px;}
        h3{font-size:1.125rem;margin-bottom:8px;}
        p{color:var(--color-muted);}
        a{color:var(--color-accent);text-decoration:none;}
        img{max-width:100%;height:auto;display:block;}

        /* Header */
        .header{
            position:sticky;top:0;z-index:50;background:rgba(255,255,255,.92);
            backdrop-filter:saturate(180%) blur(8px);
            border-bottom:1px solid var(--color-border);
        }
        .header-inner{display:flex;justify-content:space-between;align-items:center;height:64px;}
        .brand{font-weight:800;font-size:1.1rem;color:var(--color-fg);}
        .nav a{color:var(--color-fg);margin-left:28px;font-weight:500;font-size:.95rem;}
        .nav a:hover{color:var(--color-accent);}

        /* Buttons */
        .btn{
            display:inline-block;padding:12px 22px;border-radius:10px;font-weight:600;
            font-size:.95rem;transition:transform .15s ease, background .15s ease;
            border:1px solid transparent;cursor:pointer;
        }
        .btn-primary{background:var(--color-accent);color:#fff;}
        .btn-primary:hover{background:var(--color-accent-2);transform:translateY(-1px);}
        .btn-ghost{border-color:var(--color-border);color:var(--color-fg);background:#fff;}

        /* Hero */
        .hero{padding:120px 0 96px;}
        .hero-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:56px;align-items:center;}
        .hero h1 + p{margin-top:20px;font-size:1.125rem;max-width:54ch;}
        .hero .cta{margin-top:32px;}
        .hero-image{
            border-radius:var(--radius);overflow:hidden;background:var(--color-surface);
            aspect-ratio:4/3;display:flex;align-items:center;justify-content:center;
            border:1px solid var(--color-border);
        }
        .hero-image--placeholder{
            background:linear-gradient(135deg,#dbeafe 0%,#eff6ff 50%,#f0f9ff 100%);
            font-size:3rem;color:#2563eb55;
        }
        @media (max-width: 860px){
            .hero-grid{grid-template-columns:1fr;}
        }

        /* About */
        .about{background:var(--color-surface);}
        .about-grid{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:start;}
        .highlights{display:grid;gap:16px;margin-top:8px;}
        .highlight{
            background:#fff;border:1px solid var(--color-border);border-radius:var(--radius);
            padding:18px 20px;font-weight:600;display:flex;align-items:center;gap:12px;
        }
        .highlight::before{
            content:"";width:10px;height:10px;border-radius:50%;
            background:var(--color-accent);display:inline-block;flex-shrink:0;
        }
        @media (max-width: 860px){
            .about-grid{grid-template-columns:1fr;}
        }

        /* Services */
        .services-intro{max-width:62ch;margin-bottom:48px;}
        .services-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;}
        .service-card{
            padding:28px;border:1px solid var(--color-border);border-radius:var(--radius);
            transition:border-color .15s, transform .15s;background:#fff;
        }
        .service-card:hover{border-color:var(--color-accent);transform:translateY(-2px);}
        .service-icon{
            width:44px;height:44px;border-radius:10px;background:#eff6ff;
            display:flex;align-items:center;justify-content:center;
            color:var(--color-accent);font-weight:800;font-size:1.1rem;margin-bottom:18px;
        }
        @media (max-width: 860px){
            .services-grid{grid-template-columns:1fr;}
        }

        /* Contact */
        .contact{background:var(--color-surface);}
        .contact-grid{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:start;}
        .contact-item{
            display:flex;align-items:flex-start;gap:14px;padding:16px 0;
            border-bottom:1px solid var(--color-border);
        }
        .contact-item:last-child{border-bottom:none;}
        .contact-label{font-weight:600;color:var(--color-fg);}
        .contact-value{color:var(--color-muted);margin-top:2px;}
        form input, form textarea{
            width:100%;padding:12px 14px;border:1px solid var(--color-border);
            border-radius:10px;font-family:inherit;font-size:.95rem;background:#fff;
            transition:border-color .15s;
        }
        form input:focus, form textarea:focus{
            outline:none;border-color:var(--color-accent);
        }
        form label{font-weight:500;font-size:.9rem;display:block;margin-bottom:6px;}
        form .field{margin-bottom:16px;}
        @media (max-width: 860px){
            .contact-grid{grid-template-columns:1fr;}
        }

        /* Footer */
        footer{
            padding:32px 0;border-top:1px solid var(--color-border);
            text-align:center;color:var(--color-muted);font-size:.875rem;
        }
    </style>
</head>
<body>

<header class="header">
    <div class="container header-inner">
        <div class="brand" style="display:flex;align-items:center;gap:10px;">
            @if ($logoUrl)<img src="{{ $logoUrl }}" alt="{{ $siteName }}" style="height:32px;">@endif
            <span>{{ $siteName }}</span>
        </div>
        <nav class="nav">
            <a href="#about">Sobre</a>
            <a href="#services">Serviços</a>
            <a href="#contact">Contato</a>
        </nav>
    </div>
</header>

{{-- HERO --}}
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div>
                @if(!empty($hero['eyebrow']))
                    <div style="color:var(--color-accent);font-weight:700;font-size:.75rem;letter-spacing:.15em;text-transform:uppercase;margin-bottom:16px;">
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
                @if(!empty($hero['image_url']))
                    <div class="hero-image">
                        <img src="{{ $hero['image_url'] }}" alt="{{ $hero['headline'] ?? $siteName }}">
                    </div>
                @else
                    <div class="hero-image hero-image--placeholder">✦</div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- ABOUT --}}
<section class="about" id="about">
    <div class="container">
        <div class="about-grid">
            <div>
                <h2>{{ $about['title'] ?? 'Quem somos' }}</h2>
                <p>{{ $about['description'] ?? 'Somos uma equipe dedicada a entregar qualidade em cada projeto.' }}</p>
            </div>
            <div class="highlights">
                @foreach (['highlight_1','highlight_2','highlight_3'] as $key)
                    @if (!empty($about[$key]))
                        <div class="highlight">{{ $about[$key] }}</div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- SERVICES --}}
<section id="services">
    <div class="container">
        <h2>{{ $services['title'] ?? 'Nossos serviços' }}</h2>
        <p class="services-intro">
            {{ $services['intro'] ?? 'Soluções completas para o seu negócio.' }}
        </p>
        <div class="services-grid">
            @foreach ([1,2,3] as $n)
                @php
                    $title = $services["service_{$n}_title"] ?? null;
                    $desc  = $services["service_{$n}_description"] ?? null;
                @endphp
                @if ($title || $desc)
                    <div class="service-card">
                        <div class="service-icon">0{{ $n }}</div>
                        <h3>{{ $title }}</h3>
                        <p>{{ $desc }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

{{-- CONTACT --}}
<section class="contact" id="contact">
    <div class="container">
        <div class="contact-grid">
            <div>
                <h2>{{ $contact['title'] ?? 'Vamos conversar' }}</h2>
                <p style="margin-bottom:24px;">
                    {{ $contact['intro'] ?? 'Preencha o formulário ou use os contatos abaixo.' }}
                </p>
                @if($whatsapp)
                    <div class="contact-item">
                        <div>
                            <div class="contact-label">WhatsApp</div>
                            <div class="contact-value">{{ $whatsapp['value'] }}</div>
                        </div>
                    </div>
                @endif
                @if($email)
                    <div class="contact-item">
                        <div>
                            <div class="contact-label">E-mail</div>
                            <div class="contact-value">{{ $email['value'] }}</div>
                        </div>
                    </div>
                @endif
                @if($phone)
                    <div class="contact-item">
                        <div>
                            <div class="contact-label">Telefone</div>
                            <div class="contact-value">{{ $phone['value'] }}</div>
                        </div>
                    </div>
                @endif
                @if(!empty($contact['address']))
                    <div class="contact-item">
                        <div>
                            <div class="contact-label">Endereço</div>
                            <div class="contact-value">{{ $contact['address'] }}</div>
                        </div>
                    </div>
                @endif
            </div>
            <div>
                <form onsubmit="event.preventDefault(); alert('Mensagem enviada! (demo)');">
                    <div class="field">
                        <label>Nome</label>
                        <input type="text" name="name" required>
                    </div>
                    <div class="field">
                        <label>E-mail</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="field">
                        <label>Mensagem</label>
                        <textarea name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar mensagem</button>
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
            <div style="margin-top:10px;">
                @foreach ($socials as $label => $channel)
                    <a href="{{ $channel['value'] }}" target="_blank" style="margin:0 8px;">{{ $label }}</a>
                @endforeach
            </div>
        @endif
    </div>
</footer>

</body>
</html>
