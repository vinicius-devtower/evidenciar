<?php

/*
|--------------------------------------------------------------------------
| Registry de blocos canônicos do Evidenciar
|--------------------------------------------------------------------------
|
| Cada bloco descreve a estrutura semântica (campos editáveis com h1/h2/h3/p),
| áreas de imagem com dimensões sugeridas e notas de comportamento. Esse
| registry alimenta a área /dev/templates-padrao, que serve como spec viva
| para a equipe de criação produzir templates por vertical.
|
| Chaves obrigatórias por bloco:
|   name        — nome legível
|   description — frase curta
|   sketch      — chave usada pelo renderer pra desenhar o wireframe
|   fields      — lista de campos editáveis (tag, label, max, required)
|   images      — lista de áreas de imagem (label, dimensions, format)
|   notes       — bullets com regras de comportamento
|
*/

return [

    // ---------- COMUNS ----------
    'header_default' => [
        'name' => 'Header + Navegação',
        'description' => 'Cabeçalho com logo, menu principal e CTA.',
        'sketch' => 'header_default',
        'fields' => [
            ['tag' => 'IMG',  'label' => 'Logo',                'spec' => 'SVG ou PNG 200×60', 'required' => true],
            ['tag' => 'NAV',  'label' => 'Itens de menu',       'spec' => '4–6 itens (texto + âncora ou rota)', 'required' => true],
            ['tag' => 'CTA',  'label' => 'Botão primário',      'spec' => 'Texto + link', 'max' => 24],
        ],
        'images' => [],
        'notes' => [
            'Sticky no scroll (sombra discreta após 80 px de scroll).',
            'Item ativo destacado por classe .active.',
            'Mobile colapsa em hambúrguer abaixo de 992 px.',
            'CTA do header é editável (texto + link).',
        ],
    ],

    'hero_split' => [
        'name' => 'Hero (split)',
        'description' => 'Primeira dobra: texto à esquerda, imagem à direita.',
        'sketch' => 'hero_split',
        'fields' => [
            ['tag' => 'TAG', 'label' => 'Etiqueta opcional',     'max' => 30],
            ['tag' => 'H1',  'label' => 'Título principal',       'max' => 60, 'required' => true],
            ['tag' => 'P',   'label' => 'Subtítulo descritivo',   'max' => 160, 'lines' => 2],
            ['tag' => 'CTA', 'label' => 'CTA primário',           'max' => 24, 'required' => true],
            ['tag' => 'CTA', 'label' => 'CTA secundário (outline)','max' => 24],
        ],
        'images' => [
            ['label' => 'Imagem do hero', 'dimensions' => '1600×1100 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'Primeira dobra obrigatória da página. H1 único na página.',
            'Imagem do hero NÃO usa lazy-loading (LCP).',
            'Background pode ser sólido, gradient ou imagem (variação hero_video).',
        ],
    ],

    'hero_centered' => [
        'name' => 'Hero (centralizado)',
        'description' => 'Hero com tudo centralizado e mockup/imagem embaixo.',
        'sketch' => 'hero_centered',
        'fields' => [
            ['tag' => 'TAG', 'label' => 'Etiqueta opcional',     'max' => 30],
            ['tag' => 'H1',  'label' => 'Título principal',       'max' => 60, 'required' => true],
            ['tag' => 'P',   'label' => 'Subtítulo (uma linha)',  'max' => 140],
            ['tag' => 'CTA', 'label' => 'CTA primário',           'max' => 24, 'required' => true],
            ['tag' => 'CTA', 'label' => 'CTA secundário',         'max' => 24],
        ],
        'images' => [
            ['label' => 'Mockup ou imagem ilustrativa', 'dimensions' => '1600×900 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'Variação preferida para SaaS, apps e produtos digitais.',
            'Imagem fica abaixo dos CTAs, com borda arredondada e leve sombra.',
        ],
    ],

    'hero_short' => [
        'name' => 'Hero curto (página interna)',
        'description' => 'Hero compacto com breadcrumb, H1 e subtítulo opcional.',
        'sketch' => 'hero_short',
        'fields' => [
            ['tag' => 'NAV', 'label' => 'Breadcrumb',             'spec' => 'Auto-gerado pelas rotas'],
            ['tag' => 'H1',  'label' => 'Título da página',        'max' => 60, 'required' => true],
            ['tag' => 'P',   'label' => 'Subtítulo opcional',      'max' => 160],
        ],
        'images' => [],
        'notes' => [
            'Usado em todas as páginas internas do multi-page (Sobre, Serviços, etc.).',
            'Sem CTA. Sem imagem. Foco em hierarquia clara.',
            'Background pode ser cor sólida da marca ou padrão sutil.',
        ],
    ],

    'about_columns' => [
        'name' => 'Sobre (texto + imagem)',
        'description' => 'Bloco de apresentação institucional com texto à esquerda e imagem à direita.',
        'sketch' => 'about_columns',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção',          'max' => 60, 'required' => true],
            ['tag' => 'P',  'label' => 'Parágrafos (2–4)',          'max' => 800, 'lines' => 6],
            ['tag' => 'CTA','label' => 'CTA secundário (outline)',  'max' => 24],
        ],
        'images' => [
            ['label' => 'Imagem institucional', 'dimensions' => '1200×900 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'Imagem opcional — cliente pode esconder pelo editor.',
            'Suporta variação reverse (imagem à esquerda).',
        ],
    ],

    'home_highlights' => [
        'name' => 'Destaques da home',
        'description' => '3 cards com imagem, título e descrição apontando para páginas internas.',
        'sketch' => 'home_highlights',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção',          'max' => 60],
            ['tag' => 'H3', 'label' => 'Título de cada card (×3)', 'max' => 40],
            ['tag' => 'P',  'label' => 'Descrição do card (×3)',   'max' => 140, 'lines' => 3],
            ['tag' => 'CTA','label' => 'Link de cada card',        'max' => 18],
        ],
        'images' => [
            ['label' => 'Capa de cada card (×3)', 'dimensions' => '800×600 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'Exclusivo do multi-page. Cada card aponta para uma página interna.',
            'Em mobile vira lista vertical (1 coluna).',
        ],
    ],

    'services_grid' => [
        'name' => 'Serviços (grid)',
        'description' => 'Grade de 3 a 6 cards de serviços com ícone, título e descrição curta.',
        'sketch' => 'services_grid',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção',           'max' => 60, 'required' => true],
            ['tag' => 'P',  'label' => 'Subtítulo da seção',         'max' => 140],
            ['tag' => 'ICN','label' => 'Ícone de cada card',         'spec' => 'Lucide icon'],
            ['tag' => 'H3', 'label' => 'Título de cada card',        'max' => 40, 'required' => true],
            ['tag' => 'P',  'label' => 'Descrição de cada card',     'max' => 120, 'lines' => 3],
            ['tag' => 'CTA','label' => 'Link "Saiba mais" (opcional)','max' => 18],
        ],
        'images' => [],
        'notes' => [
            '3, 4 ou 6 cards (desktop). Em tablet vira 2 colunas. Em mobile vira 1 coluna.',
            'Ícones do Lucide (já instalado). Cor do ícone vem do branding.',
            'Variação: services_carousel para muitos serviços (>6).',
        ],
    ],

    'services_list' => [
        'name' => 'Serviços (lista alternada)',
        'description' => 'Lista vertical com imagem alternando esquerda/direita por linha.',
        'sketch' => 'services_list',
        'fields' => [
            ['tag' => 'H3', 'label' => 'Título de cada serviço',     'max' => 60, 'required' => true],
            ['tag' => 'P',  'label' => 'Descrição (2–4 parágrafos)', 'max' => 600, 'lines' => 5],
            ['tag' => 'CTA','label' => 'Link "Saiba mais" (outline)','max' => 18],
        ],
        'images' => [
            ['label' => 'Imagem por serviço', 'dimensions' => '1000×800 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'Layout alternado (zigzag) para legibilidade.',
            'Cada serviço pode ter slug próprio para página de detalhe.',
            'Em mobile, imagem fica sempre acima do texto.',
        ],
    ],

    'stats_counters' => [
        'name' => 'Números / contadores',
        'description' => 'Faixa horizontal com 3 a 5 números de destaque.',
        'sketch' => 'stats_counters',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Valor numérico (×3-5)', 'max' => 10, 'required' => true],
            ['tag' => 'P',  'label' => 'Rótulo do contador',     'max' => 30, 'required' => true],
        ],
        'images' => [],
        'notes' => [
            'Animação de contagem ao entrar no viewport (intersection observer).',
            'Valor aceita prefixo/sufixo (+, %, K).',
        ],
    ],

    'gallery_grid' => [
        'name' => 'Galeria de imagens',
        'description' => 'Grade de 6 a 12 imagens com lightbox.',
        'sketch' => 'gallery_grid',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção (opcional)', 'max' => 60],
        ],
        'images' => [
            ['label' => 'Imagens da galeria (6–12)', 'dimensions' => '800×800 px (1:1)', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'Limite por plano (Start: 6, Profissional: 12, Gestão VIP: ilimitado).',
            'Lightbox com navegação por teclado e swipe em mobile.',
            'Lazy-loading em todas as imagens.',
        ],
    ],

    'testimonials_carousel' => [
        'name' => 'Depoimentos',
        'description' => '3 a 6 depoimentos de clientes com avatar, nome e cargo.',
        'sketch' => 'testimonials_carousel',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção',          'max' => 60],
            ['tag' => 'P',  'label' => 'Citação (×N)',              'max' => 280, 'lines' => 4, 'required' => true],
            ['tag' => 'H3', 'label' => 'Nome do cliente',           'max' => 60, 'required' => true],
            ['tag' => 'P',  'label' => 'Cargo · Empresa',           'max' => 60],
        ],
        'images' => [
            ['label' => 'Avatar do cliente (opcional)', 'dimensions' => '200×200 px', 'format' => 'WebP'],
        ],
        'notes' => [
            'Sem avatar, mostrar inicial em badge colorido.',
            'Em mobile vira carrossel swipeable.',
        ],
    ],

    'team_grid' => [
        'name' => 'Equipe',
        'description' => 'Grid de pessoas com foto, nome e cargo.',
        'sketch' => 'team_grid',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção',          'max' => 60],
            ['tag' => 'H3', 'label' => 'Nome (×N)',                 'max' => 60, 'required' => true],
            ['tag' => 'P',  'label' => 'Cargo (×N)',                'max' => 60],
            ['tag' => 'NAV','label' => 'Links sociais (opcionais)', 'spec' => 'LinkedIn, e-mail, Instagram'],
        ],
        'images' => [
            ['label' => 'Foto de cada pessoa (3–8)', 'dimensions' => '600×600 px (1:1)', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            '4 colunas (desktop), 2 (tablet), 1 (mobile).',
            'Foto usa enquadramento quadrado com object-fit:cover.',
        ],
    ],

    'values_columns' => [
        'name' => 'Valores / diferenciais',
        'description' => '3 colunas com ícone, título e descrição.',
        'sketch' => 'values_columns',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção',          'max' => 60],
            ['tag' => 'ICN','label' => 'Ícone (×3)',                'spec' => 'Lucide'],
            ['tag' => 'H3', 'label' => 'Nome do valor (×3)',        'max' => 40, 'required' => true],
            ['tag' => 'P',  'label' => 'Descrição (×3)',            'max' => 160, 'lines' => 3],
        ],
        'images' => [],
        'notes' => [
            'Sempre 3 colunas, mesmo em mobile usar 1 por linha.',
        ],
    ],

    'portfolio_filters' => [
        'name' => 'Portfólio com filtros',
        'description' => 'Chips de categoria + grid filtrável de projetos.',
        'sketch' => 'portfolio_filters',
        'fields' => [
            ['tag' => 'NAV','label' => 'Chips de categoria',        'spec' => 'Filtro JS sem reload'],
            ['tag' => 'H3', 'label' => 'Título do projeto (×N)',    'max' => 60, 'required' => true],
            ['tag' => 'P',  'label' => 'Categoria/tag (×N)',        'max' => 30],
        ],
        'images' => [
            ['label' => 'Capa de cada projeto', 'dimensions' => '1200×900 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'Chip "Todos" sempre presente, default ativo.',
            'Cada item abre lightbox ou página de detalhe (config por template).',
        ],
    ],

    'faq_accordion' => [
        'name' => 'Perguntas frequentes',
        'description' => 'Accordion com 4 a 10 perguntas/respostas.',
        'sketch' => 'faq_accordion',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção',          'max' => 60],
            ['tag' => 'H3', 'label' => 'Pergunta (×N)',             'max' => 120, 'required' => true],
            ['tag' => 'P',  'label' => 'Resposta (×N)',             'max' => 600, 'lines' => 4],
        ],
        'images' => [],
        'notes' => [
            'Accordion com apenas um item aberto por vez.',
            'Marcação JSON-LD FAQ (schema.org) automática para SEO.',
        ],
    ],

    'cta_banner' => [
        'name' => 'CTA banner',
        'description' => 'Faixa colorida com claim, subclaim e CTA.',
        'sketch' => 'cta_banner',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Claim',                    'max' => 60, 'required' => true],
            ['tag' => 'P',  'label' => 'Subclaim',                  'max' => 140],
            ['tag' => 'CTA','label' => 'CTA primário (invertido)',  'max' => 24, 'required' => true],
        ],
        'images' => [],
        'notes' => [
            'Background usa cor primária da marca; CTA fica em branco.',
            'Reforça conversão antes de Contato ou no fim do post.',
        ],
    ],

    'contact_form' => [
        'name' => 'Formulário de contato',
        'description' => 'Formulário à esquerda + informações à direita.',
        'sketch' => 'contact_form',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção',          'max' => 60, 'required' => true],
            ['tag' => 'INP','label' => 'Nome completo',             'spec' => 'text, required'],
            ['tag' => 'INP','label' => 'E-mail',                    'spec' => 'email, required'],
            ['tag' => 'INP','label' => 'Telefone / WhatsApp',       'spec' => 'tel'],
            ['tag' => 'INP','label' => 'Mensagem',                  'spec' => 'textarea, required'],
            ['tag' => 'CTA','label' => 'Botão "Enviar"',            'max' => 24, 'required' => true],
            ['tag' => 'H3', 'label' => 'Título do bloco lateral',   'max' => 40],
            ['tag' => 'P',  'label' => 'Telefone, e-mail, endereço, horário', 'spec' => 'lê do _branding'],
        ],
        'images' => [],
        'notes' => [
            'Honeypot anti-spam obrigatório (campo oculto trap).',
            'Envia para o e-mail do cliente + grava em ContactSubmission.',
            'reCAPTCHA v3 opcional (config por cliente).',
            'Lateral com canais vem do _branding (não duplicar dados).',
        ],
    ],

    'map_contact' => [
        'name' => 'Mapa + endereço',
        'description' => 'Mapa embed à esquerda, endereço e canais à direita.',
        'sketch' => 'map_contact',
        'fields' => [
            ['tag' => 'H3', 'label' => 'Título do bloco',           'max' => 40],
            ['tag' => 'P',  'label' => 'Endereço completo',          'max' => 200, 'required' => true],
            ['tag' => 'P',  'label' => 'Horário de atendimento',     'max' => 120],
            ['tag' => 'P',  'label' => 'Telefone · WhatsApp · e-mail','spec' => 'lê do _branding'],
        ],
        'images' => [
            ['label' => 'Mapa', 'dimensions' => '—', 'format' => 'iframe Google Maps'],
        ],
        'notes' => [
            'Endereço editável faz geocoding automático para atualizar coordenadas.',
            'Em mobile, mapa fica acima das informações.',
        ],
    ],

    'footer_simple' => [
        'name' => 'Footer',
        'description' => 'Rodapé com logo, 4 colunas de links e linha de copyright.',
        'sketch' => 'footer_simple',
        'fields' => [
            ['tag' => 'IMG', 'label' => 'Logo (versão clara)',     'spec' => 'SVG ou PNG'],
            ['tag' => 'H3',  'label' => 'Título de cada coluna',    'max' => 30],
            ['tag' => 'NAV', 'label' => 'Links de cada coluna',     'spec' => '3–5 links'],
            ['tag' => 'P',   'label' => 'Razão social, CNPJ, links legais', 'spec' => 'lê do _branding'],
        ],
        'images' => [],
        'notes' => [
            '4 colunas (desktop), 2 (tablet), 1 (mobile).',
            'Linha inferior obrigatória: razão social, CNPJ, termos, privacidade, selo Evidenciar.',
            'Background usa tom escuro do branding.',
        ],
    ],

    // ---------- BLOG ----------
    'blog_featured' => [
        'name' => 'Post em destaque',
        'description' => 'Hero da página de blog: imagem grande à esquerda + título e excerpt à direita.',
        'sketch' => 'blog_featured',
        'fields' => [
            ['tag' => 'TAG', 'label' => 'Categoria',                'max' => 30],
            ['tag' => 'H1',  'label' => 'Título do post',           'max' => 100, 'required' => true],
            ['tag' => 'P',   'label' => 'Excerpt',                  'max' => 240, 'lines' => 3],
            ['tag' => 'P',   'label' => 'Autor · data · tempo de leitura', 'spec' => 'meta auto'],
            ['tag' => 'CTA', 'label' => 'Botão "Ler post"',         'max' => 24],
        ],
        'images' => [
            ['label' => 'Capa do post', 'dimensions' => '1600×900 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'Mostra o post mais recente OU o post marcado como destaque no admin.',
            'H1 da página de listagem é o nome do blog (ex.: "Blog do Estúdio X"), não o título do post.',
        ],
    ],

    'blog_grid' => [
        'name' => 'Grid de posts',
        'description' => 'Cards de post com capa, categoria, título, excerpt e meta.',
        'sketch' => 'blog_grid',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção (opcional)', 'max' => 60],
            ['tag' => 'TAG','label' => 'Categoria de cada card',     'max' => 30],
            ['tag' => 'H3', 'label' => 'Título de cada post',        'max' => 100, 'required' => true],
            ['tag' => 'P',  'label' => 'Excerpt de cada post',       'max' => 160, 'lines' => 3],
            ['tag' => 'P',  'label' => 'Data · tempo de leitura',    'spec' => 'meta auto'],
        ],
        'images' => [
            ['label' => 'Capa de cada post', 'dimensions' => '800×500 px (16:10)', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            '3 colunas (desktop), 2 (tablet), 1 (mobile).',
            'Hover discreto (lift + shadow).',
            'Cliente sem capa em um post: usar capa padrão do branding.',
        ],
    ],

    'blog_sidebar' => [
        'name' => 'Sidebar do blog',
        'description' => 'Coluna lateral com busca, categorias, posts recentes e tags.',
        'sketch' => 'blog_sidebar',
        'fields' => [
            ['tag' => 'INP', 'label' => 'Campo de busca',           'spec' => 'GET ?q='],
            ['tag' => 'H3',  'label' => 'Título "Categorias"',      'max' => 30],
            ['tag' => 'NAV', 'label' => 'Lista de categorias',      'spec' => 'auto, com contagem'],
            ['tag' => 'H3',  'label' => 'Título "Posts recentes"',  'max' => 30],
            ['tag' => 'NAV', 'label' => 'Últimos 3–5 posts',        'spec' => 'thumbnail + título + data'],
        ],
        'images' => [],
        'notes' => [
            'Em desktop, fica em coluna direita do grid (largura ~320px).',
            'Em mobile vai para o final, colapsado por padrão (accordion).',
        ],
    ],

    'blog_pagination' => [
        'name' => 'Paginação',
        'description' => 'Numérica, máximo 10 por página.',
        'sketch' => 'blog_pagination',
        'fields' => [
            ['tag' => 'NAV', 'label' => 'Páginas anterior/próxima + números', 'spec' => 'GET ?page='],
        ],
        'images' => [],
        'notes' => [
            'Default: 10 posts por página.',
            'Em mobile, mostrar apenas anterior/próxima e indicador "página X de Y".',
        ],
    ],

    'post_detail_hero' => [
        'name' => 'Hero do post',
        'description' => 'Breadcrumb, categoria, H1 do post, meta e capa.',
        'sketch' => 'post_detail_hero',
        'fields' => [
            ['tag' => 'NAV', 'label' => 'Breadcrumb',               'spec' => 'Início › Blog › Categoria › Post'],
            ['tag' => 'TAG', 'label' => 'Categoria',                'max' => 30, 'required' => true],
            ['tag' => 'H1',  'label' => 'Título do post',           'max' => 100, 'required' => true],
            ['tag' => 'P',   'label' => 'Autor · data · tempo de leitura · comentários', 'spec' => 'meta auto'],
        ],
        'images' => [
            ['label' => 'Imagem de capa', 'dimensions' => '1600×900 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'H1 único na página = título do post.',
            'Capa NÃO usa lazy-loading (LCP).',
            'Compartilhar (WhatsApp, X, LinkedIn, copiar link) abaixo da capa.',
        ],
    ],

    'post_body' => [
        'name' => 'Corpo do post',
        'description' => 'Texto rico com H2/H3 intermediários e imagens inline.',
        'sketch' => 'post_body',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Subtítulos de seção',       'max' => 80],
            ['tag' => 'H3', 'label' => 'Sub-subtítulos',            'max' => 60],
            ['tag' => 'P',  'label' => 'Parágrafos',                'spec' => 'markdown ou rich-text'],
            ['tag' => 'IMG','label' => 'Imagens inline com legenda','spec' => '1200×500 ideal'],
        ],
        'images' => [
            ['label' => 'Imagens inline (opcionais)', 'dimensions' => '1200×500 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            'Largura máxima ~720px para legibilidade.',
            'Suporta blockquote, listas, code blocks, callouts.',
            'H2/H3 dentro do corpo são preservados para SEO e geração de TOC.',
        ],
    ],

    'post_author' => [
        'name' => 'Bio do autor',
        'description' => 'Avatar, nome, cargo e mini bio do autor do post.',
        'sketch' => 'post_author',
        'fields' => [
            ['tag' => 'H3', 'label' => 'Nome do autor',             'max' => 60, 'required' => true],
            ['tag' => 'P',  'label' => 'Cargo · Empresa',           'max' => 60],
            ['tag' => 'P',  'label' => 'Mini bio',                   'max' => 280, 'lines' => 3],
            ['tag' => 'NAV','label' => 'Links sociais (opcionais)', 'spec' => 'LinkedIn, X, site'],
        ],
        'images' => [
            ['label' => 'Avatar do autor', 'dimensions' => '200×200 px', 'format' => 'WebP'],
        ],
        'notes' => [
            'Aparece após o corpo do post, antes dos relacionados.',
        ],
    ],

    'related_posts' => [
        'name' => 'Posts relacionados',
        'description' => '3 posts da mesma categoria, recomendados ao final.',
        'sketch' => 'related_posts',
        'fields' => [
            ['tag' => 'H2', 'label' => 'Título da seção',          'max' => 60],
            ['tag' => 'H3', 'label' => 'Título de cada post (×3)', 'max' => 80, 'required' => true],
            ['tag' => 'P',  'label' => 'Data · tempo de leitura',   'spec' => 'meta auto'],
        ],
        'images' => [
            ['label' => 'Capa de cada post relacionado', 'dimensions' => '800×500 px', 'format' => 'WebP', 'alt' => true],
        ],
        'notes' => [
            '3 posts da mesma categoria, ordenados por proximidade temporal.',
            'Se não houver 3 da categoria, completar com mais recentes do blog.',
        ],
    ],
];
