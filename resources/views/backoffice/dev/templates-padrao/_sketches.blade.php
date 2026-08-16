{{-- Wireframes simplificados de cada bloco. --}}
{{-- Cada case é um pequeno HTML autoexplicativo, estilizado em _styles.blade.php --}}

@switch($sketch)

    @case('header_default')
        <div class="sk sk-header">
            <div class="sk-logo">LOGO</div>
            <nav class="sk-nav">
                <span>Início</span><span>Sobre</span><span>Serviços</span><span>Contato</span>
            </nav>
            <button class="sk-btn sk-btn--primary">CTA primário</button>
        </div>
        @break

    @case('hero_split')
        <div class="sk sk-split">
            <div class="sk-col">
                <span class="sk-tag">TAG · opcional</span>
                <div class="sk-h1">H1 · Título principal — proposta de valor (max 60 char)</div>
                <div class="sk-p">P · Subtítulo descritivo em 1–2 linhas (max 160 char)</div>
                <div class="sk-actions">
                    <button class="sk-btn sk-btn--primary">CTA primário</button>
                    <button class="sk-btn sk-btn--outline">CTA secundário</button>
                </div>
            </div>
            <div class="sk-col">
                @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'IMAGEM HERO', 'spec'=>'1600×1100 · WebP', 'tall'=>true])
            </div>
        </div>
        @break

    @case('hero_centered')
        <div class="sk sk-centered">
            <span class="sk-tag">TAG · opcional</span>
            <div class="sk-h1 text-center">H1 · Título principal centralizado</div>
            <div class="sk-p text-center">P · Subtítulo (uma linha · max 140 char)</div>
            <div class="sk-actions justify-content-center">
                <button class="sk-btn sk-btn--primary">CTA primário</button>
                <button class="sk-btn sk-btn--outline">CTA secundário</button>
            </div>
            @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'MOCKUP', 'spec'=>'1600×900 · WebP'])
        </div>
        @break

    @case('hero_short')
        <div class="sk sk-stack sk-pad">
            <div class="sk-breadcrumb">Início › Nome da página</div>
            <div class="sk-h1">H1 · Título da página</div>
            <div class="sk-p">P · Subtítulo opcional (max 160 char)</div>
        </div>
        @break

    @case('about_columns')
        <div class="sk sk-split">
            <div class="sk-col">
                <div class="sk-h2">H2 · Sobre nós — quem somos</div>
                <div class="sk-bars">
                    <span></span><span></span><span></span><span></span><span style="width:80%"></span>
                </div>
                <div class="sk-actions"><button class="sk-btn sk-btn--outline">CTA · saiba mais</button></div>
            </div>
            <div class="sk-col">
                @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'IMAGEM SOBRE', 'spec'=>'1200×900', 'tall'=>true])
            </div>
        </div>
        @break

    @case('home_highlights')
        <div class="sk sk-stack">
            <div class="sk-h2 text-center">H2 · Por que escolher a gente</div>
            <div class="sk-grid sk-grid--3">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="sk-card">
                        @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'IMG', 'spec'=>'800×600', 'small'=>true])
                        <div class="sk-h3">H3 · Diferencial {{ $i }}</div>
                        <div class="sk-bars"><span></span><span></span><span style="width:70%"></span></div>
                        <div class="sk-link">CTA · ver mais →</div>
                    </div>
                @endfor
            </div>
        </div>
        @break

    @case('services_grid')
        <div class="sk sk-stack">
            <div class="sk-h2 text-center">H2 · Nossos serviços</div>
            <div class="sk-p text-center">P · Subtítulo da seção (max 140 char)</div>
            <div class="sk-grid sk-grid--3">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="sk-card sk-card--center">
                        <div class="sk-icon">ICN</div>
                        <div class="sk-h3">H3 · Serviço {{ $i }}</div>
                        <div class="sk-bars"><span></span><span></span><span style="width:80%"></span></div>
                        <div class="sk-link">CTA · saiba mais →</div>
                    </div>
                @endfor
            </div>
        </div>
        @break

    @case('services_list')
        <div class="sk sk-stack">
            @for ($i = 1; $i <= 2; $i++)
                <div class="sk-row {{ $i % 2 === 0 ? 'sk-row--reverse' : '' }}">
                    <div class="sk-col sk-col--img">
                        @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>"IMG", 'spec'=>'1000×800'])
                    </div>
                    <div class="sk-col">
                        <div class="sk-h3">H3 · Serviço {{ $i }}</div>
                        <div class="sk-bars"><span></span><span></span><span></span><span style="width:75%"></span></div>
                        <div class="sk-actions"><button class="sk-btn sk-btn--outline">CTA · saiba mais</button></div>
                    </div>
                </div>
            @endfor
        </div>
        @break

    @case('stats_counters')
        <div class="sk sk-stats">
            @foreach ([['+200', 'Clientes'], ['15', 'Anos'], ['98%', 'Satisfação'], ['10', 'Prêmios']] as $s)
                <div>
                    <div class="sk-stats__num">{{ $s[0] }}</div>
                    <div class="sk-stats__lbl">{{ $s[1] }}</div>
                </div>
            @endforeach
        </div>
        @break

    @case('gallery_grid')
        <div class="sk sk-stack">
            <div class="sk-h2 text-center">H2 · Portfólio / Galeria</div>
            <div class="sk-grid sk-grid--4">
                @for ($i = 0; $i < 8; $i++)
                    @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'IMG', 'spec'=>'800×800', 'square'=>true])
                @endfor
            </div>
        </div>
        @break

    @case('testimonials_carousel')
        <div class="sk sk-stack">
            <div class="sk-h2 text-center">H2 · O que dizem nossos clientes</div>
            <div class="sk-grid sk-grid--3">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="sk-card">
                        <div class="sk-quote">"</div>
                        <div class="sk-bars"><span></span><span></span><span></span><span style="width:80%"></span></div>
                        <div class="sk-author">
                            <div class="sk-avatar"></div>
                            <div>
                                <div class="sk-h3">H3 · Cliente {{ $i }}</div>
                                <div class="sk-p sk-p--mini">P · Cargo · Empresa</div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        @break

    @case('team_grid')
        <div class="sk sk-stack">
            <div class="sk-h2 text-center">H2 · Nossa equipe</div>
            <div class="sk-grid sk-grid--4">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="sk-card sk-card--center">
                        @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'FOTO', 'spec'=>'600×600', 'square'=>true])
                        <div class="sk-h3">H3 · Nome {{ $i }}</div>
                        <div class="sk-p sk-p--mini">P · Cargo</div>
                    </div>
                @endfor
            </div>
        </div>
        @break

    @case('values_columns')
        <div class="sk sk-stack">
            <div class="sk-h2 text-center">H2 · Nossos valores</div>
            <div class="sk-grid sk-grid--3">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="sk-card sk-card--center">
                        <div class="sk-icon">ICN</div>
                        <div class="sk-h3">H3 · Valor {{ $i }}</div>
                        <div class="sk-bars"><span></span><span></span><span style="width:70%"></span></div>
                    </div>
                @endfor
            </div>
        </div>
        @break

    @case('portfolio_filters')
        <div class="sk sk-stack">
            <div class="sk-chips">
                <span class="sk-chip sk-chip--active">Todos</span>
                <span class="sk-chip">Categoria A</span>
                <span class="sk-chip">Categoria B</span>
                <span class="sk-chip">Categoria C</span>
            </div>
            <div class="sk-grid sk-grid--3">
                @for ($i = 1; $i <= 6; $i++)
                    @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>"PROJETO $i", 'spec'=>'1200×900'])
                @endfor
            </div>
        </div>
        @break

    @case('faq_accordion')
        <div class="sk sk-stack">
            <div class="sk-h2">H2 · Perguntas frequentes</div>
            @for ($i = 1; $i <= 4; $i++)
                <div class="sk-faq">
                    <span>H3 · Pergunta {{ $i }} — clicar para expandir</span>
                    <span class="sk-faq__plus">+</span>
                </div>
            @endfor
        </div>
        @break

    @case('cta_banner')
        <div class="sk sk-banner">
            <div class="sk-h2 text-white text-center">H2 · Pronto para começar?</div>
            <div class="sk-p text-white-50 text-center">P · Subtítulo que reforça o valor (max 140 char)</div>
            <div class="sk-actions justify-content-center">
                <button class="sk-btn sk-btn--inverse">CTA primário</button>
            </div>
        </div>
        @break

    @case('contact_form')
        <div class="sk sk-split">
            <div class="sk-col">
                <div class="sk-h2">H2 · Fale com a gente</div>
                <div class="sk-input">Nome completo (text · obrigatório)</div>
                <div class="sk-input">E-mail (email · obrigatório)</div>
                <div class="sk-input">Telefone / WhatsApp (tel)</div>
                <div class="sk-input sk-input--big">Mensagem (textarea · obrigatório)</div>
                <div class="sk-actions"><button class="sk-btn sk-btn--primary">CTA · enviar mensagem</button></div>
            </div>
            <div class="sk-col">
                <div class="sk-h3">H3 · Informações de contato</div>
                <ul class="sk-info">
                    <li>📞 Telefone (do _branding)</li>
                    <li>✉ E-mail (do _branding)</li>
                    <li>📍 Endereço (do _branding)</li>
                    <li>🕐 Horário de atendimento</li>
                    <li>▶ WhatsApp / Instagram / etc.</li>
                </ul>
            </div>
        </div>
        @break

    @case('map_contact')
        <div class="sk sk-split">
            <div class="sk-col">
                @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'MAPA · iframe Google Maps', 'spec'=>'embed', 'tall'=>true])
            </div>
            <div class="sk-col">
                <div class="sk-h3">H3 · Onde estamos</div>
                <ul class="sk-info">
                    <li>📍 Endereço completo (P)</li>
                    <li>🕐 Horário de atendimento</li>
                    <li>📞 Telefone · WhatsApp (do _branding)</li>
                    <li>✉ E-mail (do _branding)</li>
                </ul>
            </div>
        </div>
        @break

    @case('footer_simple')
        <div class="sk sk-footer">
            <div class="sk-footer__top">
                <div class="sk-logo sk-logo--inverse">LOGO</div>
                @foreach (['Mapa do site', 'Institucional', 'Atendimento', 'Newsletter'] as $t)
                    <div>
                        <div class="sk-h3 sk-h3--inverse">H3 · {{ $t }}</div>
                        <ul class="sk-info sk-info--inverse">
                            <li>link 1</li><li>link 2</li><li>link 3</li>
                        </ul>
                    </div>
                @endforeach
            </div>
            <div class="sk-footer__bottom">
                <span>© Razão social · CNPJ · termos · privacidade</span>
                <span>Feito com Evidenciar</span>
            </div>
        </div>
        @break

    {{-- BLOG --}}

    @case('blog_featured')
        <div class="sk sk-split">
            <div class="sk-col sk-col--img">
                @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'COVER POST', 'spec'=>'1600×900 · WebP', 'tall'=>true])
            </div>
            <div class="sk-col">
                <span class="sk-tag">CATEGORIA</span>
                <div class="sk-h1">H1 · Título do post em destaque</div>
                <div class="sk-p sk-p--mini">P · Por Autor · 12 abr 2026 · 5 min de leitura</div>
                <div class="sk-bars"><span></span><span></span><span style="width:75%"></span></div>
                <div class="sk-actions"><button class="sk-btn sk-btn--primary">CTA · ler post</button></div>
            </div>
        </div>
        @break

    @case('blog_grid')
        <div class="sk sk-stack">
            <div class="sk-h2">H2 · Últimos posts</div>
            <div class="sk-grid sk-grid--3">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="sk-card">
                        @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'COVER', 'spec'=>'800×500', 'small'=>true])
                        <span class="sk-tag sk-tag--mini">CATEGORIA</span>
                        <div class="sk-h3">H3 · Título do post {{ $i }}</div>
                        <div class="sk-bars"><span></span><span></span><span style="width:70%"></span></div>
                        <div class="sk-p sk-p--mini">12 abr · 4 min</div>
                    </div>
                @endfor
            </div>
        </div>
        @break

    @case('blog_sidebar')
        <div class="sk sk-stack sk-pad sk-sidebar">
            <div class="sk-input">🔍  Buscar no blog…</div>
            <div class="sk-h3">H3 · Categorias</div>
            <ul class="sk-info">
                <li>• Categoria A (12)</li><li>• Categoria B (8)</li><li>• Categoria C (5)</li><li>• Categoria D (3)</li>
            </ul>
            <div class="sk-h3">H3 · Posts recentes</div>
            @for ($i = 1; $i <= 3; $i++)
                <div class="sk-recent">
                    <div class="sk-thumb"></div>
                    <div>
                        <div class="sk-p sk-p--mini">Título do post {{ $i }}</div>
                        <div class="sk-p sk-p--mini text-muted">12 abr 2026</div>
                    </div>
                </div>
            @endfor
        </div>
        @break

    @case('blog_pagination')
        <div class="sk sk-pagination">
            ‹ &nbsp; <span class="sk-page sk-page--active">1</span> <span class="sk-page">2</span> <span class="sk-page">3</span> &nbsp;…&nbsp; <span class="sk-page">10</span> &nbsp; ›
        </div>
        @break

    @case('post_detail_hero')
        <div class="sk sk-stack sk-pad">
            <div class="sk-breadcrumb">Início › Blog › Categoria › Post atual</div>
            <span class="sk-tag">CATEGORIA</span>
            <div class="sk-h1">H1 · Título do post — claro e descritivo</div>
            <div class="sk-p sk-p--mini">P · Por Autor · 12 abr 2026 · 5 min de leitura · 3 comentários</div>
            @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'IMAGEM DE CAPA', 'spec'=>'1600×900 · WebP'])
        </div>
        @break

    @case('post_body')
        <div class="sk sk-stack sk-pad" style="max-width:560px;margin:0 auto">
            <div class="sk-h2">H2 · Subtítulo de seção do post</div>
            <div class="sk-bars"><span></span><span></span><span></span><span></span><span style="width:70%"></span></div>
            @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'IMAGEM INLINE', 'spec'=>'1200×500 · legenda opcional'])
            <div class="sk-h2">H2 · Outro subtítulo de seção</div>
            <div class="sk-bars"><span></span><span></span><span style="width:80%"></span></div>
            <div class="sk-h3">H3 · Subseção</div>
            <div class="sk-bars"><span></span><span style="width:65%"></span></div>
        </div>
        @break

    @case('post_author')
        <div class="sk sk-author-row">
            <div class="sk-avatar sk-avatar--big"></div>
            <div class="flex-grow-1">
                <div class="sk-h3">H3 · Nome do autor</div>
                <div class="sk-p sk-p--mini">P · Cargo · Empresa</div>
                <div class="sk-bars"><span></span><span style="width:70%"></span></div>
            </div>
        </div>
        @break

    @case('related_posts')
        <div class="sk sk-stack">
            <div class="sk-h2">H2 · Você também pode gostar</div>
            <div class="sk-grid sk-grid--3">
                @for ($i = 1; $i <= 3; $i++)
                    <div class="sk-card">
                        @include('backoffice.dev.templates-padrao._sketch_img', ['label'=>'COVER', 'spec'=>'800×500', 'small'=>true])
                        <div class="sk-h3">H3 · Título do post {{ $i }}</div>
                        <div class="sk-p sk-p--mini">12 abr · 4 min</div>
                    </div>
                @endfor
            </div>
        </div>
        @break

    @default
        <div class="sk sk-stack sk-pad">
            <div class="sk-p text-muted text-center">
                <i class="bi bi-question-circle"></i> Sketch não definido para "<code>{{ $sketch }}</code>".
            </div>
        </div>
@endswitch
