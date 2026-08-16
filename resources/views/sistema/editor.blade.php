@extends('layouts.sistema')

@section('title', 'Editor do Site — Evidenciar')

@push('head')
<style>
/* ==========================
   PREVIEW (iframe)
========================== */
.editor-preview-frame {
    width: 100%;
    height: calc(100vh - 230px);
    min-height: 520px;
    border: none;
    border-radius: var(--radius-padrao);
    background: #fff;
    box-shadow: var(--sombra-card);
}

/* ==========================
   TOP ACTIONS (branding/contato)
========================== */
.editor-top-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-bottom: 12px;
    flex-wrap: wrap;
}
.editor-top-actions .btn {
    background: var(--cor-azul-medio);
    color: #fff;
    border: none;
    font-weight: 700;
    padding: 10px 22px;
    border-radius: 8px;
    font-size: 13px;
    letter-spacing: .3px;
}
.editor-top-actions .btn:hover {
    background: var(--cor-azul-escuro);
    color: #fff;
}

/* ==========================
   SIDEBAR
========================== */
.editor-sidebar {
    background: var(--cor-areia);
    border-radius: var(--radius-padrao);
    padding: 18px;
    box-shadow: var(--sombra-card);
    display: flex;
    flex-direction: column;
    gap: 14px;
    height: calc(100vh - 230px);
    min-height: 520px;
    overflow: hidden;
}
.editor-sidebar .section-selector {
    background: #fff;
    border: 1px solid rgba(19,45,70,.12);
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #132d46;
    padding: 10px 12px;
    width: 100%;
}
.editor-sidebar .section-title {
    font-size: 15px;
    font-weight: 800;
    color: #132d46;
    margin: 0;
    letter-spacing: .2px;
}
.editor-sidebar-body {
    overflow-y: auto;
    flex: 1;
    padding-right: 4px;
}
.editor-sidebar-body::-webkit-scrollbar { width: 6px; }
.editor-sidebar-body::-webkit-scrollbar-thumb { background: rgba(19,45,70,.15); border-radius: 3px; }

/* ==========================
   FIELD
========================== */
.ed-field { margin-bottom: 14px; }
.ed-field-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #132d46;
    margin-bottom: 5px;
}
.ed-field-label small {
    color: #5a6470;
    font-weight: 400;
    margin-left: 4px;
    font-style: italic;
}
.ed-field-row {
    display: flex;
    gap: 6px;
    align-items: stretch;
}
.ed-field-row .form-control {
    background: #fff;
    border: 1px solid rgba(19,45,70,.1);
    border-radius: 6px;
    font-size: 13px;
    color: #132d46;
    padding: 8px 10px;
    height: auto;
}
.ed-field-row .form-control:focus {
    border-color: var(--cor-azul-medio);
    box-shadow: 0 0 0 3px rgba(38,126,135,.15);
}
.ed-field-counter {
    font-size: 11px;
    color: #5a6470;
    margin-top: 3px;
    text-align: right;
}
.ed-field-counter.over { color: #c92b2b; font-weight: 700; }

/* Botão EVA */
.btn-eva {
    background: var(--cor-azul-escuro);
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    padding: 0 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    height: auto;
    min-width: 62px;
    letter-spacing: .3px;
}
.btn-eva:hover { background: var(--cor-azul-medio); color: #fff; }
.btn-eva .eva-icon { font-size: 10px; }

/* Campo imagem */
.ed-image-wrap {
    display: flex;
    gap: 10px;
    align-items: center;
    background: #fff;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid rgba(19,45,70,.1);
}
.ed-image-thumb {
    width: 80px;
    height: 80px;
    flex-shrink: 0;
    background: #f1f0e8 center/cover no-repeat;
    border-radius: 6px;
    border: 1px solid rgba(19,45,70,.08);
}
.ed-image-thumb.is-empty {
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b919b;
    font-size: 11px;
    text-align: center;
    padding: 6px;
}
.btn-upload {
    background: var(--cor-verde);
    color: #fff;
    border: none;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 13px;
    font-weight: 600;
    flex: 1;
}
.btn-upload:hover { background: var(--cor-verde-hover); color: #fff; }
.ed-image-progress { font-size: 11px; color: #5a6470; margin-top: 4px; }

/* Ações fixas */
.editor-footer {
    display: flex;
    gap: 8px;
    padding-top: 12px;
    border-top: 1px solid rgba(19,45,70,.08);
}
.editor-footer .btn { flex: 1; font-weight: 700; font-size: 13px; padding: 10px; }
.editor-footer .btn-outline-preview {
    background: transparent;
    border: 1px solid var(--cor-azul-medio);
    color: var(--cor-azul-medio);
}
.editor-footer .btn-outline-preview:hover {
    background: var(--cor-azul-medio);
    color: #fff;
}

/* Modal EVA */
.modal-eva .modal-content {
    background: var(--cor-areia);
    border: none;
    border-radius: var(--radius-padrao);
}
.modal-eva .modal-header,
.modal-eva .modal-footer { border: none; }
.eva-option {
    border: 1px solid rgba(19,45,70,.15);
    background: #fff;
    border-radius: 8px;
    padding: 12px;
    font-size: 13px;
    color: #132d46;
    cursor: pointer;
    transition: .1s;
    display: flex;
    flex-direction: column;
    gap: 4px;
    text-align: left;
    width: 100%;
}
.eva-option:hover { border-color: var(--cor-azul-medio); background: #f7f6ed; }
.eva-option strong { font-weight: 700; }
.eva-suggestion {
    background: #fff;
    border: 1px solid rgba(19,45,70,.15);
    border-radius: 8px;
    padding: 12px;
    min-height: 80px;
    white-space: pre-wrap;
    font-size: 13px;
    color: #132d46;
}

/* ==========================
   MODAIS (placeholder p/ Fase 2)
========================== */
.modal-brand .modal-content {
    background: var(--cor-areia);
    border: none;
    border-radius: var(--radius-padrao);
}
.modal-brand .modal-header,
.modal-brand .modal-footer { border: none; }
.modal-brand .modal-title { color: #132d46; font-weight: 700; }
</style>
@endpush

@section('content')
@php
    $brand    = $content['_branding']       ?? [];
    $contactG = $content['_contact_global'] ?? [];
    $sections = $templateConfig['sections'] ?? [];
@endphp

{{-- Ações fixas no topo (Identidade Visual + Contato) --}}
<div class="editor-top-actions">
    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modalIdentidade">
        Identidade Visual
    </button>
    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modalContato">
        Contato
    </button>
</div>

<form id="editorForm" method="POST" action="{{ route('app.sites.update', $site) }}">
    @csrf

    <div class="row g-3">

        {{-- ===== PREVIEW (iframe) ===== --}}
        <div class="col-lg-8">
            <iframe id="previewFrame"
                    class="editor-preview-frame"
                    src="{{ route('app.sites.preview', $site) }}"
                    title="Pré-visualização do site"></iframe>
        </div>

        {{-- ===== SIDEBAR ===== --}}
        <div class="col-lg-4">
            <div class="editor-sidebar">

                <select id="sectionSelect" class="section-selector">
                    @foreach ($sections as $section)
                        <option value="{{ $section['id'] }}">{{ $section['label'] ?? $section['id'] }}</option>
                    @endforeach
                </select>

                <h6 class="section-title" id="sectionTitle"></h6>

                <div class="editor-sidebar-body" id="sidebarBody">
                    {{-- renderizado por JS --}}
                </div>

                <div class="editor-footer">
                    <a href="{{ route('app.sites.preview', $site) }}" target="_blank" class="btn btn-outline-preview">
                        Ver Site
                    </a>
                    <button type="submit" class="btn btn-green" style="background:var(--cor-verde);color:#fff;border:none;">
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </div>

    </div>

    {{-- Hidden fields (fonte da verdade para o POST) --}}
    <div id="hiddenFields" hidden>
        @foreach ($sections as $section)
            @foreach (($section['fields'] ?? []) as $field)
                @php
                    $fieldName  = "content[{$section['id']}][{$field['key']}]";
                    $fieldValue = $content[$section['id']][$field['key']] ?? ($field['default'] ?? '');
                @endphp
                @if ($field['type'] === 'textarea')
                    <textarea name="{{ $fieldName }}"
                              data-section="{{ $section['id'] }}"
                              data-key="{{ $field['key'] }}">{{ $fieldValue }}</textarea>
                @elseif ($field['type'] === 'boolean')
                    <input type="hidden" name="{{ $fieldName }}" value="{{ $fieldValue ? 1 : 0 }}"
                           data-section="{{ $section['id'] }}"
                           data-key="{{ $field['key'] }}">
                @else
                    <input type="text" name="{{ $fieldName }}" value="{{ $fieldValue }}"
                           data-section="{{ $section['id'] }}"
                           data-key="{{ $field['key'] }}">
                @endif
            @endforeach
        @endforeach
    </div>

</form>

{{-- ========================== --}}
{{-- MODAL IDENTIDADE VISUAL     --}}
{{-- ========================== --}}
<div class="modal fade modal-brand" id="modalIdentidade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form method="POST" action="{{ route('app.branding.save') }}" class="modal-content" id="formBranding">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Identidade Visual</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>

            <div class="modal-body">
                <div class="row g-4">

                    {{-- Logo principal --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="text-transform:uppercase;font-size:12px;letter-spacing:.4px;">Logotipo principal</label>
                        <div class="ed-image-wrap">
                            <div class="ed-image-thumb {{ empty($brand['logo_url']) ? 'is-empty' : '' }}"
                                 id="brandLogoThumb"
                                 style="{{ !empty($brand['logo_url']) ? 'background-image:url('.$brand['logo_url'].');' : '' }}">
                                {{ empty($brand['logo_url']) ? 'Sem logo' : '' }}
                            </div>
                            <button type="button" class="btn btn-upload"
                                    onclick="document.getElementById('brandLogoFile').click()">
                                Escolher
                            </button>
                        </div>
                        <input type="file" id="brandLogoFile" accept="image/*" hidden>
                        <input type="hidden" name="logo_url" id="brandLogoUrl" value="{{ $brand['logo_url'] ?? '' }}">
                    </div>

                    {{-- Logo alternativo --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold" style="text-transform:uppercase;font-size:12px;letter-spacing:.4px;">Logotipo alternativo (ícone)</label>
                        <div class="ed-image-wrap">
                            <div class="ed-image-thumb {{ empty($brand['logo_alt_url']) ? 'is-empty' : '' }}"
                                 id="brandLogoAltThumb"
                                 style="{{ !empty($brand['logo_alt_url']) ? 'background-image:url('.$brand['logo_alt_url'].');' : '' }}">
                                {{ empty($brand['logo_alt_url']) ? 'Sem ícone' : '' }}
                            </div>
                            <button type="button" class="btn btn-upload"
                                    onclick="document.getElementById('brandLogoAltFile').click()">
                                Escolher
                            </button>
                        </div>
                        <input type="file" id="brandLogoAltFile" accept="image/*" hidden>
                        <input type="hidden" name="logo_alt_url" id="brandLogoAltUrl" value="{{ $brand['logo_alt_url'] ?? '' }}">
                    </div>

                    {{-- Cores --}}
                    <div class="col-12">
                        <label class="form-label fw-bold" style="text-transform:uppercase;font-size:12px;letter-spacing:.4px;">Cores do site</label>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:12px;font-weight:600;color:#132d46;">Principal</label>
                                <input type="color" class="form-control form-control-color w-100"
                                       name="color_primary" id="colorPrimary"
                                       value="{{ $brand['color_primary'] ?? ($brand['primary_color'] ?? '#01c38e') }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:12px;font-weight:600;color:#132d46;">Contato</label>
                                <input type="color" class="form-control form-control-color w-100"
                                       name="color_contact" id="colorContact"
                                       value="{{ $brand['color_contact'] ?? '#132d46' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" style="font-size:12px;font-weight:600;color:#132d46;">Ícones</label>
                                <input type="color" class="form-control form-control-color w-100"
                                       name="color_icons" id="colorIcons"
                                       value="{{ $brand['color_icons'] ?? ($brand['secondary_color'] ?? '#267e87') }}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-green" style="background:var(--cor-verde);color:#fff;border:none;">Salvar identidade</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================== --}}
{{-- MODAL CONTATO GLOBAL        --}}
{{-- ========================== --}}
@include('sistema.partials.modal-contato', ['contactG' => $contactG])

{{-- ========================== --}}
{{-- MODAL EVA (apenas Profissional/VIP) --}}
{{-- ========================== --}}
@feature('eva')
<div class="modal fade modal-eva" id="modalEva" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="color:#132d46;font-weight:700;">EVA — assistente de conteúdo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="font-size:13px;color:#132d46;margin-bottom:12px;">
                    Campo: <strong id="evaFieldLabel">—</strong>
                </p>

                <div class="row g-2 mb-3">
                    <div class="col-6 col-md-3"><button type="button" class="eva-option" data-action="rewrite"><strong>Reescrever</strong><span>mesma ideia, texto melhor</span></button></div>
                    <div class="col-6 col-md-3"><button type="button" class="eva-option" data-action="shorten"><strong>Encurtar</strong><span>versão mais curta</span></button></div>
                    <div class="col-6 col-md-3"><button type="button" class="eva-option" data-action="expand"><strong>Expandir</strong><span>mais detalhes</span></button></div>
                    <div class="col-6 col-md-3"><button type="button" class="eva-option" data-action="generate"><strong>Gerar novo</strong><span>do zero</span></button></div>
                </div>

                <label class="form-label" style="font-size:12px;color:#132d46;font-weight:700;">Sugestão</label>
                <div class="eva-suggestion" id="evaSuggestion">Escolha uma ação acima.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-green" id="evaApply"
                        style="background:var(--cor-verde);color:#fff;border:none;" disabled>
                    Aplicar ao campo
                </button>
            </div>
        </div>
    </div>
</div>
@endfeature

@push('scripts')
<script>
// ==========================
// EDITOR — config vinda do server
// ==========================
const TEMPLATE_CONFIG = @json($templateConfig);
const SITE_CONTENT    = @json($content);
const EVA_ENABLED     = {{ app(\App\Services\PlanFeatureService::class)->userHas(auth()->user(), 'eva') ? 'true' : 'false' }};
const ROUTES = {
    upload:  @json(route('app.uploads.image')),
    aiSuggest: @json(route('app.ai.suggest')),
    preview: @json(route('app.sites.preview', $site)),
};
const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let currentSection = (TEMPLATE_CONFIG.sections && TEMPLATE_CONFIG.sections[0]?.id) || null;
let evaCtx = null; // { sectionId, key, label, maxChars, current, activeAction, lastSuggestion }

// ==========================
// RENDER DA SIDEBAR
// ==========================
function renderSection(sectionId) {
    const section = (TEMPLATE_CONFIG.sections || []).find(s => s.id === sectionId);
    const body    = document.getElementById('sidebarBody');
    const title   = document.getElementById('sectionTitle');
    if (!section) { body.innerHTML = '<p class="text-muted">Seção não encontrada.</p>'; return; }

    title.textContent = section.label || section.id;

    let html = '';
    (section.fields || []).forEach(field => {
        const current = (SITE_CONTENT[sectionId] && SITE_CONTENT[sectionId][field.key] !== undefined)
            ? SITE_CONTENT[sectionId][field.key]
            : (field.default ?? '');

        const maxChars = field.max_chars || 0;
        const labelSuffix = maxChars ? ` <small>- até ${maxChars} caracteres</small>` : '';
        html += `<div class="ed-field" data-field-key="${field.key}">`;
        html += `  <label class="ed-field-label">${escapeHtml(field.label || field.key)}${labelSuffix}</label>`;

        if (field.type === 'image') {
            const imgStyle = current ? `background-image:url('${escapeAttr(current)}');` : '';
            const emptyCls = current ? '' : 'is-empty';
            const emptyTxt = current ? '' : 'Sem imagem';
            html += `
              <div class="ed-image-wrap">
                <div class="ed-image-thumb ${emptyCls}" data-img-thumb="${field.key}" style="${imgStyle}">${emptyTxt}</div>
                <div style="flex:1;display:flex;flex-direction:column;gap:4px;">
                  <button type="button" class="btn btn-upload" data-img-btn="${field.key}">Escolher imagem</button>
                  <div class="ed-image-progress" data-img-progress="${field.key}"></div>
                </div>
                <input type="file" accept="image/*" hidden data-img-file="${field.key}">
              </div>`;
        } else if (field.type === 'textarea') {
            const rows = maxChars > 120 ? 4 : 3;
            html += `
              <div class="ed-field-row">
                <textarea class="form-control sidebar-input"
                          rows="${rows}"
                          data-section="${sectionId}"
                          data-key="${field.key}"
                          ${maxChars ? `maxlength="${maxChars}"` : ''}>${escapeHtml(current)}</textarea>
                ${field.eva ? evaButton(sectionId, field.key) : ''}
              </div>
              ${maxChars ? counterHtml(current, maxChars) : ''}
            `;
        } else if (field.type === 'boolean') {
            html += `
              <div class="form-check">
                <input type="checkbox" class="form-check-input sidebar-input"
                       data-section="${sectionId}" data-key="${field.key}"
                       ${current ? 'checked' : ''}>
              </div>`;
        } else {
            const inputType = (field.type === 'url') ? 'url' : 'text';
            html += `
              <div class="ed-field-row">
                <input type="${inputType}" class="form-control sidebar-input"
                       value="${escapeAttr(current)}"
                       data-section="${sectionId}" data-key="${field.key}"
                       ${maxChars ? `maxlength="${maxChars}"` : ''}>
                ${field.eva ? evaButton(sectionId, field.key) : ''}
              </div>
              ${maxChars ? counterHtml(current, maxChars) : ''}
            `;
        }

        html += `</div>`;
    });

    body.innerHTML = html;

    // Bind inputs
    body.querySelectorAll('.sidebar-input').forEach(input => {
        input.addEventListener('input', syncSidebarInput);
        input.addEventListener('change', syncSidebarInput);
    });
    // Bind EVA
    body.querySelectorAll('[data-eva]').forEach(btn => {
        btn.addEventListener('click', openEvaForField);
    });
    // Bind image uploads
    body.querySelectorAll('[data-img-btn]').forEach(btn => {
        btn.addEventListener('click', () => {
            const key = btn.dataset.imgBtn;
            body.querySelector(`[data-img-file="${key}"]`).click();
        });
    });
    body.querySelectorAll('[data-img-file]').forEach(input => {
        input.addEventListener('change', onSectionImageChange);
    });
}

function evaButton(sectionId, key) {
    if (!EVA_ENABLED) return '';
    return `<button type="button" class="btn btn-eva" data-eva data-section="${sectionId}" data-key="${key}">
              <span class="eva-icon">✨</span> EVA
            </button>`;
}
function counterHtml(current, max) {
    const len = String(current ?? '').length;
    const overCls = len > max ? 'over' : '';
    return `<div class="ed-field-counter ${overCls}" data-counter>${len} / ${max}</div>`;
}

// ==========================
// SYNC input → SITE_CONTENT + hidden
// ==========================
function syncSidebarInput(e) {
    const input = e.target;
    const section = input.dataset.section;
    const key = input.dataset.key;
    const value = input.type === 'checkbox' ? (input.checked ? 1 : 0) : input.value;

    SITE_CONTENT[section] = SITE_CONTENT[section] || {};
    SITE_CONTENT[section][key] = value;

    const hidden = document.querySelector(
        `#hiddenFields [data-section="${section}"][data-key="${key}"]`
    );
    if (hidden) {
        if (hidden.tagName === 'TEXTAREA') { hidden.textContent = value; hidden.value = value; }
        else { hidden.value = value; }
    }

    // Atualiza contador
    const field = input.closest('.ed-field');
    const counter = field?.querySelector('[data-counter]');
    if (counter) {
        const max = parseInt(input.getAttribute('maxlength') || '0', 10);
        if (max) {
            counter.textContent = `${String(value).length} / ${max}`;
            counter.classList.toggle('over', String(value).length > max);
        }
    }
}

// ==========================
// IMAGE UPLOAD (campo de seção)
// ==========================
async function onSectionImageChange(e) {
    const input = e.target;
    const key = input.dataset.imgFile;
    const file = input.files?.[0];
    if (!file) return;

    const progress = document.querySelector(`[data-img-progress="${key}"]`);
    const thumb    = document.querySelector(`[data-img-thumb="${key}"]`);
    progress.textContent = 'Enviando...';

    try {
        const url = await uploadImage(file);
        // Atualiza SITE_CONTENT + hidden
        SITE_CONTENT[currentSection] = SITE_CONTENT[currentSection] || {};
        SITE_CONTENT[currentSection][key] = url;
        const hidden = document.querySelector(
            `#hiddenFields [data-section="${currentSection}"][data-key="${key}"]`
        );
        if (hidden) hidden.value = url;

        thumb.classList.remove('is-empty');
        thumb.textContent = '';
        thumb.style.backgroundImage = `url('${url}')`;
        progress.textContent = 'Enviada! Clique em Salvar para aplicar.';
    } catch (err) {
        progress.textContent = 'Falha no upload. Tente novamente.';
        console.error(err);
    } finally {
        input.value = '';
    }
}

async function uploadImage(file) {
    const fd = new FormData();
    fd.append('file', file);
    const res = await fetch(ROUTES.upload, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        body: fd,
    });
    if (!res.ok) throw new Error('Upload falhou');
    const json = await res.json();
    return json.url;
}

// ==========================
// EVA
// ==========================
const evaModal = () => bootstrap.Modal.getOrCreateInstance(document.getElementById('modalEva'));

function openEvaForField(e) {
    const btn = e.currentTarget;
    const sectionId = btn.dataset.section;
    const key = btn.dataset.key;
    const section = (TEMPLATE_CONFIG.sections || []).find(s => s.id === sectionId);
    const field = (section?.fields || []).find(f => f.key === key);
    if (!field) return;

    const current = (SITE_CONTENT[sectionId] && SITE_CONTENT[sectionId][key] !== undefined)
        ? SITE_CONTENT[sectionId][key] : (field.default ?? '');

    evaCtx = {
        sectionId, key,
        label: field.label || key,
        maxChars: field.max_chars || 0,
        current,
        lastSuggestion: null,
    };
    document.getElementById('evaFieldLabel').textContent = evaCtx.label;
    document.getElementById('evaSuggestion').textContent = 'Escolha uma ação acima.';
    document.getElementById('evaApply').disabled = true;
    evaModal().show();
}

document.querySelectorAll('.eva-option').forEach(b => b.addEventListener('click', async (e) => {
    if (!evaCtx) return;
    const action = e.currentTarget.dataset.action;
    const el = document.getElementById('evaSuggestion');
    el.textContent = 'Gerando sugestão...';
    document.getElementById('evaApply').disabled = true;

    try {
        const res = await fetch(ROUTES.aiSuggest, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF,
            },
            body: JSON.stringify({
                action,
                field_label: evaCtx.label,
                current_text: evaCtx.current,
                max_chars: evaCtx.maxChars || null,
            }),
        });
        const json = await res.json();
        evaCtx.lastSuggestion = json.suggestion || '';
        el.textContent = evaCtx.lastSuggestion || '(sem sugestão)';
        document.getElementById('evaApply').disabled = !evaCtx.lastSuggestion;
    } catch (err) {
        el.textContent = 'Falha ao chamar a EVA. Tente novamente.';
    }
}));

document.getElementById('evaApply').addEventListener('click', () => {
    if (!evaCtx?.lastSuggestion) return;
    // Atualiza SITE_CONTENT + campo visível + hidden
    SITE_CONTENT[evaCtx.sectionId] = SITE_CONTENT[evaCtx.sectionId] || {};
    SITE_CONTENT[evaCtx.sectionId][evaCtx.key] = evaCtx.lastSuggestion;

    const live = document.querySelector(
        `#sidebarBody [data-section="${evaCtx.sectionId}"][data-key="${evaCtx.key}"]`
    );
    if (live) {
        live.value = evaCtx.lastSuggestion;
        if (live.tagName === 'TEXTAREA') live.textContent = evaCtx.lastSuggestion;
        live.dispatchEvent(new Event('input', { bubbles: true }));
    }
    const hidden = document.querySelector(
        `#hiddenFields [data-section="${evaCtx.sectionId}"][data-key="${evaCtx.key}"]`
    );
    if (hidden) hidden.value = evaCtx.lastSuggestion;

    evaModal().hide();
});

// ==========================
// MODAL IDENTIDADE VISUAL — uploads
// ==========================
['brandLogo', 'brandLogoAlt'].forEach(id => {
    const fileInput = document.getElementById(`${id}File`);
    const thumb     = document.getElementById(`${id}Thumb`);
    const hidden    = document.getElementById(`${id}Url`);
    if (!fileInput) return;
    fileInput.addEventListener('change', async (e) => {
        const file = e.target.files?.[0];
        if (!file) return;
        thumb.textContent = 'Enviando...';
        try {
            const url = await uploadImage(file);
            hidden.value = url;
            thumb.classList.remove('is-empty');
            thumb.textContent = '';
            thumb.style.backgroundImage = `url('${url}')`;
        } catch (err) {
            thumb.textContent = 'Erro';
        } finally {
            e.target.value = '';
        }
    });
});

// ==========================
// SELETOR DE SEÇÃO
// ==========================
document.getElementById('sectionSelect').addEventListener('change', (e) => {
    currentSection = e.target.value;
    renderSection(currentSection);
});

// ==========================
// HELPERS
// ==========================
function escapeHtml(s) {
    return String(s ?? '')
        .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
}
function escapeAttr(s) {
    return String(s ?? '')
        .replace(/&/g,'&amp;').replace(/"/g,'&quot;');
}

// Inicializa com a primeira seção
if (currentSection) renderSection(currentSection);
</script>
@endpush

@endsection
