<style>
    /* ============================================================
       Templates Padrão — wireframe styles
       ============================================================ */
    :root {
        --tp-primary: #0F4D3A;
        --tp-accent:  #22A06B;
        --tp-light:   #F5F7F6;
        --tp-border:  #d5dcd8;
        --tp-muted:   #6B7570;
        --tp-text:    #1A1F1C;
        --tp-img-bg:  #e6ece9;
        --tp-note-bg: #FFF8E1;
        --tp-note-bd: #E5C45C;
    }

    /* TOC sticky */
    .tp-toc { position: sticky; top: 16px; }
    .tp-toc .card-header { font-weight: 600; font-size: 13px; }
    .tp-toc ul li a { color: var(--tp-text); border-radius: 4px; }
    .tp-toc ul li a:hover { background: var(--tp-light); }

    /* Page header */
    .tp-page__head { margin: 0 0 20px; padding-bottom: 12px; border-bottom: 2px solid var(--tp-primary); }
    .tp-page__num   { display: inline-block; font-size: 11px; color: var(--tp-accent); font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase; }
    .tp-page__title { font-size: 26px; font-weight: 800; margin: 4px 0 4px; color: var(--tp-text); }
    .tp-page__desc  { font-size: 14px; color: var(--tp-muted); margin: 0; font-style: italic; }

    /* Block */
    .tp-block { background: #fff; border: 1px solid #eef0ee; border-radius: 10px; padding: 16px; margin-bottom: 18px; box-shadow: 0 1px 2px rgba(0,0,0,.02); }
    .tp-block__head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 10px; }
    .tp-block__name { font-size: 15px; font-weight: 700; margin: 0; color: var(--tp-primary); }
    .tp-block__desc { font-size: 12.5px; color: var(--tp-muted); margin: 2px 0 0; }
    .tp-block__chip { font-size: 11px; padding: 4px 10px; background: var(--tp-primary); color: #fff; border-radius: 999px; white-space: nowrap; font-family: ui-monospace, SFMono-Regular, monospace; align-self: flex-start; }
    .tp-block__sketch { border: 1px dashed var(--tp-border); background: #fafbfa; border-radius: 8px; padding: 14px; margin: 8px 0 12px; }
    .tp-block__meta { display: flex; flex-direction: column; gap: 12px; }

    /* Meta tables */
    .tp-meta { background: var(--tp-light); border-radius: 6px; padding: 10px 12px; }
    .tp-meta__title { font-size: 11.5px; font-weight: 700; margin: 0 0 6px; color: var(--tp-text); text-transform: uppercase; letter-spacing: 0.4px; }
    .tp-fields { width: 100%; font-size: 12.5px; }
    .tp-fields th { font-size: 11px; color: var(--tp-muted); text-transform: uppercase; letter-spacing: 0.4px; font-weight: 700; padding: 4px 6px; border-bottom: 1px solid #e0e5e2; }
    .tp-fields td { padding: 6px; border-bottom: 1px solid #eaedeb; vertical-align: middle; }
    .tp-fields tr:last-child td { border-bottom: none; }

    /* Tag chips (H1, H2, P, CTA, etc.) */
    .tp-tag { display: inline-block; font-family: ui-monospace, SFMono-Regular, monospace; font-size: 10.5px; font-weight: 700; padding: 2px 7px; border-radius: 3px; background: var(--tp-primary); color: #fff; min-width: 32px; text-align: center; }
    .tp-tag--h1 { background: #B91C1C; }
    .tp-tag--h2 { background: #C2410C; }
    .tp-tag--h3 { background: #B45309; }
    .tp-tag--p,
    .tp-tag--p- { background: #374151; }
    .tp-tag--cta { background: var(--tp-primary); }
    .tp-tag--tag { background: #6B7280; }
    .tp-tag--img { background: #1D4ED8; }
    .tp-tag--nav { background: #5B21B6; }
    .tp-tag--inp { background: #047857; }
    .tp-tag--icn { background: #BE185D; }

    .tp-badge { display: inline-block; font-size: 10.5px; padding: 2px 7px; border-radius: 3px; background: #eee; color: var(--tp-text); }
    .tp-badge--req { background: #FEE2E2; color: #B91C1C; font-weight: 700; }

    /* Notas */
    .tp-notes { background: var(--tp-note-bg); border: 1px solid var(--tp-note-bd); }
    .tp-notes ul { padding-left: 18px; margin: 0; font-size: 12.5px; color: var(--tp-text); }
    .tp-notes li { margin-bottom: 3px; }

    /* ============================================================
       SKETCHES — visual wireframes
       ============================================================ */
    .sk { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif; color: var(--tp-text); }
    .sk-stack { display: flex; flex-direction: column; gap: 10px; }
    .sk-pad { padding: 6px 4px; }
    .sk-split { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
    .sk-col { display: flex; flex-direction: column; gap: 8px; }
    .sk-col--img { min-width: 0; }
    .sk-row { display: grid; grid-template-columns: 1.2fr 1fr; gap: 16px; align-items: center; padding: 10px 0; border-bottom: 1px dashed var(--tp-border); }
    .sk-row:last-child { border-bottom: none; }
    .sk-row--reverse { direction: rtl; }
    .sk-row--reverse > * { direction: ltr; }

    .sk-grid { display: grid; gap: 8px; }
    .sk-grid--3 { grid-template-columns: repeat(3, 1fr); }
    .sk-grid--4 { grid-template-columns: repeat(4, 1fr); }
    @media (max-width: 768px) {
        .sk-split, .sk-row { grid-template-columns: 1fr; }
        .sk-grid--3, .sk-grid--4 { grid-template-columns: repeat(2, 1fr); }
    }

    .sk-card { background: #fff; border: 1px solid #e6ebe7; border-radius: 6px; padding: 10px; display: flex; flex-direction: column; gap: 6px; }
    .sk-card--center { align-items: center; text-align: center; }

    .sk-h1 { font-size: 18px; font-weight: 800; line-height: 1.25; color: var(--tp-text); }
    .sk-h2 { font-size: 15px; font-weight: 700; color: var(--tp-text); }
    .sk-h3 { font-size: 12.5px; font-weight: 700; color: var(--tp-text); }
    .sk-h3--inverse { color: #fff; }
    .sk-p  { font-size: 11.5px; color: var(--tp-muted); line-height: 1.4; }
    .sk-p--mini { font-size: 10.5px; }

    .sk-tag { display: inline-block; font-size: 9.5px; font-weight: 700; padding: 3px 8px; background: var(--tp-accent); color: #fff; border-radius: 999px; letter-spacing: 0.4px; align-self: flex-start; }
    .sk-tag--mini { font-size: 8.5px; padding: 2px 6px; align-self: flex-start; }

    .sk-breadcrumb { font-size: 10px; color: var(--tp-muted); }

    .sk-bars { display: flex; flex-direction: column; gap: 4px; padding: 4px 0; }
    .sk-bars span { display: block; height: 6px; background: #c8d0cc; border-radius: 2px; width: 100%; }

    .sk-actions { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 4px; }
    .sk-btn { font-size: 10.5px; font-weight: 700; padding: 5px 12px; border-radius: 4px; border: 1px solid var(--tp-primary); cursor: default; }
    .sk-btn--primary { background: var(--tp-primary); color: #fff; }
    .sk-btn--outline { background: #fff; color: var(--tp-primary); }
    .sk-btn--inverse { background: #fff; color: var(--tp-primary); border-color: #fff; }

    .sk-icon { width: 32px; height: 32px; border-radius: 50%; background: var(--tp-accent); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 9.5px; font-weight: 700; }

    .sk-link { font-size: 11px; font-weight: 700; color: var(--tp-primary); }

    .sk-quote { font-size: 28px; font-weight: 900; color: var(--tp-accent); line-height: 1; }
    .sk-author { display: flex; align-items: center; gap: 8px; margin-top: 4px; }
    .sk-avatar { width: 28px; height: 28px; border-radius: 50%; background: #c8d0cc; flex-shrink: 0; }
    .sk-avatar--big { width: 56px; height: 56px; }

    .sk-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px; padding: 8px 0; }
    .sk-stats > div { text-align: center; }
    .sk-stats__num { font-size: 22px; font-weight: 800; color: var(--tp-primary); line-height: 1.1; }
    .sk-stats__lbl { font-size: 11px; color: var(--tp-muted); margin-top: 2px; }

    .sk-faq { display: flex; justify-content: space-between; align-items: center; background: #fff; border: 1px solid #e6ebe7; border-radius: 4px; padding: 8px 12px; font-size: 12px; font-weight: 600; }
    .sk-faq__plus { color: var(--tp-primary); font-weight: 800; }

    .sk-banner { background: var(--tp-primary); border-radius: 8px; padding: 22px 16px; display: flex; flex-direction: column; gap: 8px; }

    .sk-input { background: #fff; border: 1px solid #d5dcd8; border-radius: 4px; padding: 6px 10px; font-size: 11px; color: var(--tp-muted); }
    .sk-input--big { padding: 24px 10px 6px; }
    .sk-info { list-style: none; padding-left: 0; margin: 0; font-size: 11.5px; color: var(--tp-text); display: flex; flex-direction: column; gap: 4px; }
    .sk-info--inverse { color: rgba(255,255,255,.85); }

    .sk-chips { display: flex; gap: 6px; flex-wrap: wrap; }
    .sk-chip { font-size: 10.5px; font-weight: 600; padding: 4px 10px; border-radius: 999px; border: 1px solid var(--tp-border); background: #fff; color: var(--tp-text); }
    .sk-chip--active { background: var(--tp-primary); color: #fff; border-color: var(--tp-primary); }

    .sk-pagination { text-align: center; padding: 6px; font-size: 13px; color: var(--tp-muted); }
    .sk-page { display: inline-block; padding: 2px 8px; margin: 0 2px; border-radius: 3px; }
    .sk-page--active { background: var(--tp-primary); color: #fff; font-weight: 700; }

    .sk-recent { display: flex; gap: 8px; align-items: center; }
    .sk-thumb { width: 36px; height: 36px; border-radius: 4px; background: var(--tp-img-bg); flex-shrink: 0; }
    .sk-sidebar { background: #f9faf9; padding: 12px; border-radius: 6px; }

    .sk-author-row { display: flex; gap: 12px; align-items: center; padding: 8px; }

    /* Header sketch */
    .sk-header { display: flex; align-items: center; gap: 16px; padding: 8px 6px; border-bottom: 1px solid var(--tp-border); }
    .sk-logo { background: var(--tp-primary); color: #fff; font-weight: 800; padding: 6px 14px; border-radius: 4px; font-size: 11px; letter-spacing: 1px; }
    .sk-logo--inverse { background: #fff; color: var(--tp-primary); }
    .sk-nav { display: flex; gap: 18px; flex: 1; font-size: 11.5px; color: var(--tp-text); }

    /* Footer sketch */
    .sk-footer { background: #0B2A22; color: #fff; border-radius: 6px; overflow: hidden; }
    .sk-footer__top { display: grid; grid-template-columns: auto repeat(4, 1fr); gap: 18px; padding: 16px; }
    .sk-footer__bottom { display: flex; justify-content: space-between; padding: 10px 16px; background: rgba(0,0,0,.2); font-size: 10.5px; color: rgba(255,255,255,.7); }

    /* Image placeholder */
    .sk-img { position: relative; background: var(--tp-img-bg); border: 1px dashed var(--tp-border); border-radius: 4px; min-height: 90px; aspect-ratio: 16 / 10; color: rgba(0,0,0,.18); display: flex; align-items: center; justify-content: center; overflow: hidden; }
    .sk-img--tall { aspect-ratio: 4 / 3; min-height: 140px; }
    .sk-img--small { aspect-ratio: 16 / 10; min-height: 70px; }
    .sk-img--square { aspect-ratio: 1 / 1; min-height: 70px; }
    .sk-img svg { position: absolute; inset: 0; width: 100%; height: 100%; }
    .sk-img__label { position: relative; z-index: 1; text-align: center; padding: 4px 8px; background: rgba(255,255,255,.7); border-radius: 3px; }
    .sk-img__label strong { display: block; font-size: 10px; font-weight: 700; color: var(--tp-muted); letter-spacing: 0.5px; }
    .sk-img__label span { display: block; font-size: 9px; color: var(--tp-muted); margin-top: 1px; }

    /* Utility */
    .text-center { text-align: center; }
    .justify-content-center { justify-content: center; }
</style>
