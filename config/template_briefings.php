<?php

/*
|--------------------------------------------------------------------------
| Briefings dos 3 templates padrão do Evidenciar
|--------------------------------------------------------------------------
|
| Spec viva pra equipe de criação. Cada template é uma sequência de páginas
| (1 só pra one-page, 5 pra multi-page, 8 pra site+blog), e cada página é
| uma sequência de blocos referenciando o registry em config/template_blocks.php.
|
*/

return [

    'one-page' => [
        'name' => 'Template padrão · One-Page',
        'subtitle' => 'Site de página única com navegação por âncora.',
        'description' => 'Indicado para landing pages, negócios locais e profissionais autônomos. '
            . 'Aproximadamente 11 blocos empilhados verticalmente com âncoras no header.',
        'pages' => [
            [
                'name' => 'Página única',
                'description' => null,
                'blocks' => [
                    'header_default',
                    'hero_split',
                    'about_columns',
                    'services_grid',
                    'stats_counters',
                    'gallery_grid',
                    'testimonials_carousel',
                    'faq_accordion',
                    'cta_banner',
                    'contact_form',
                    'footer_simple',
                ],
            ],
        ],
    ],

    'multi-page' => [
        'name' => 'Template padrão · Multi-Page',
        'subtitle' => 'Site institucional de 5 páginas (Home, Sobre, Serviços, Portfólio, Contato).',
        'description' => 'Header e footer compartilhados entre páginas. Indicado pra empresas '
            . 'que precisam aprofundar conteúdo por área (equipe, valores, casos detalhados).',
        'pages' => [
            [
                'name' => 'Home',
                'description' => 'Apresentação rápida do negócio com ponteiros para as outras páginas.',
                'blocks' => [
                    'header_default',
                    'hero_split',
                    'home_highlights',
                    'stats_counters',
                    'testimonials_carousel',
                    'cta_banner',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Sobre',
                'description' => 'História, equipe e valores da empresa.',
                'blocks' => [
                    'header_default',
                    'hero_short',
                    'about_columns',
                    'team_grid',
                    'values_columns',
                    'cta_banner',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Serviços',
                'description' => 'Detalhamento de cada serviço/produto oferecido.',
                'blocks' => [
                    'header_default',
                    'hero_short',
                    'services_list',
                    'faq_accordion',
                    'cta_banner',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Portfólio',
                'description' => 'Trabalhos realizados, projetos ou cases.',
                'blocks' => [
                    'header_default',
                    'hero_short',
                    'portfolio_filters',
                    'cta_banner',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Contato',
                'description' => 'Formulário, mapa e canais de atendimento.',
                'blocks' => [
                    'header_default',
                    'hero_short',
                    'contact_form',
                    'map_contact',
                    'footer_simple',
                ],
            ],
        ],
    ],

    'site-blog' => [
        'name' => 'Template padrão · Site + Blog',
        'subtitle' => 'Multi-page completo + módulo de blog (listagem, post, categoria).',
        'description' => 'Mesmas 5 páginas institucionais do multi-page, somando 3 páginas de blog. '
            . 'Item "Blog" é injetado no header automaticamente quando o módulo está ativo. '
            . 'Disponível apenas no plano Gestão VIP (gated por feature: blog).',
        'pages' => [
            // Páginas institucionais (idênticas ao multi-page)
            [
                'name' => 'Home',
                'description' => 'Mesma estrutura do multi-page.',
                'blocks' => [
                    'header_default',
                    'hero_split',
                    'home_highlights',
                    'stats_counters',
                    'testimonials_carousel',
                    'cta_banner',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Sobre',
                'description' => 'Mesma estrutura do multi-page.',
                'blocks' => [
                    'header_default',
                    'hero_short',
                    'about_columns',
                    'team_grid',
                    'values_columns',
                    'cta_banner',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Serviços',
                'description' => 'Mesma estrutura do multi-page.',
                'blocks' => [
                    'header_default',
                    'hero_short',
                    'services_list',
                    'faq_accordion',
                    'cta_banner',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Portfólio',
                'description' => 'Mesma estrutura do multi-page.',
                'blocks' => [
                    'header_default',
                    'hero_short',
                    'portfolio_filters',
                    'cta_banner',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Contato',
                'description' => 'Mesma estrutura do multi-page.',
                'blocks' => [
                    'header_default',
                    'hero_short',
                    'contact_form',
                    'map_contact',
                    'footer_simple',
                ],
            ],
            // Páginas exclusivas do blog
            [
                'name' => 'Blog · Listagem',
                'description' => 'Página principal do blog: post em destaque + grid de posts + sidebar.',
                'blocks' => [
                    'header_default',
                    'blog_featured',
                    'blog_grid',
                    'blog_sidebar',
                    'blog_pagination',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Blog · Post (detalhe)',
                'description' => 'Página de leitura de um post individual.',
                'blocks' => [
                    'header_default',
                    'post_detail_hero',
                    'post_body',
                    'post_author',
                    'related_posts',
                    'cta_banner',
                    'footer_simple',
                ],
            ],
            [
                'name' => 'Blog · Categoria',
                'description' => 'Listagem filtrada por categoria, sem post em destaque.',
                'blocks' => [
                    'header_default',
                    'hero_short',
                    'blog_grid',
                    'blog_pagination',
                    'footer_simple',
                ],
            ],
        ],
    ],

];
