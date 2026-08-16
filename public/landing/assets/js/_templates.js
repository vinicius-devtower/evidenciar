// =============================
// LOAD DATA
// =============================
let data = [];

fetch('/landing/assets/js/data/templates.json')
  .then(res => res.json())
  .then(json => {
    data = json;
    initTemplates();
  })
  .catch(err => console.error('Erro ao carregar JSON:', err));


// =============================
// STATE
// =============================
const cards = Array.from(document.querySelectorAll('.card'));
let active = 0;
let currentPlan = "start";
let tabsBound = false;


// =============================
// INIT
// =============================
function initTemplates() {
  createImages();
  bindEvents();
  update();
}


// =============================
// CREATE IMG INSIDE CARDS
// =============================
function createImages() {
  cards.forEach(card => {
    if (card.querySelector('img')) return;

    const img = document.createElement("img");
    img.className = "card-img";
    img.style.width = "100%";
    img.style.height = "auto";
    img.style.objectFit = "cover";

    card.appendChild(img);
  });
}


// =============================
// UPDATE UI (CAROUSEL)
// =============================
function update() {
  if (!data.length) return;

  cards.forEach((card, i) => {
    let pos = (i - active + cards.length) % cards.length;

    if (pos < 4) {
      card.style.display = "block";
      card.setAttribute("data-pos", pos);

      const dataIndex = (active + pos) % data.length;
      const img = card.querySelector("img");

      if (img) {
        img.src = data[dataIndex].img;
        img.alt = data[dataIndex].title;
      }

    } else {
      card.style.display = "none";
    }
  });

  const titleEl = document.getElementById('title');
  const descEl = document.getElementById('desc');

  if (titleEl) titleEl.innerText = data[active].title;
  if (descEl) descEl.innerText = data[active].desc;
}

// =============================
// NAVIGATION
// =============================
function next() {
  if (!data.length) return;
  active = (active + 1) % data.length;
  update();
}

function prev() {
  if (!data.length) return;
  active = (active - 1 + data.length) % data.length;
  update();
}

// =============================
// TEMPLATE PREVIEW (NOVO)
// =============================
function openTemplatePreview(item) {
  const modalEl = document.getElementById('templatePreviewModal');

  const titleEl = document.getElementById('previewTitle');
  const descEl = document.getElementById('previewDesc');
  const imgEl = document.getElementById('previewImg');
  const galleryEl = document.getElementById('previewGallery');

  if (!modalEl || !titleEl || !descEl || !imgEl || !galleryEl) {
    console.error("Preview modal elements not found");
    return;
  }

  // conteúdo principal
  titleEl.innerText = item.title;
  descEl.innerText = item.desc;
  imgEl.src = item.img;

  // limpa galeria
  galleryEl.innerHTML = "";

  // monta galeria
  if (item.gallery && item.gallery.length) {
    item.gallery.forEach(src => {
      const thumb = document.createElement("img");
      thumb.src = src;

      // ao clicar, troca imagem principal
      thumb.addEventListener("click", () => {
        imgEl.src = src;
      });

      galleryEl.appendChild(thumb);
    });
  }

  const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
  modal.show();
}

// =============================
// TEMPLATE
// =============================
function getTemplatesByPlan() {
  return data.filter(item => {
    return item.plan?.toLowerCase() === currentPlan;
  });
}


// =============================
// GRID (MODAL)
// =============================
const grid = document.getElementById("templatesGrid");

const planDescriptions = {
  start: "Sites one-page profissionais que você pode alternar a qualquer momento sem custo adicional. Ideal para quem quer uma presença digital rápida, moderna e de alto impacto com investimento acessível.",
  professional: "Inclui todos os templates do plano Start e também sites multi-page, com estrutura completa para empresas que já possuem equipe e estratégia. Contém páginas como Home, Sobre, Equipe, Serviços, páginas individuais por serviço e Contato.",
  vip: "Inclui tudo do plano Profissional, além da EVA, nossa IA que auxilia na criação de títulos e conteúdos. Também conta com blog, suporte na geração de conteúdo e imagens personalizadas para elevar sua presença digital ao máximo."
};

function updatePlanDescription() {
  const el = document.querySelector("#planDescription p");
  if (!el) return;

  el.innerText = planDescriptions[currentPlan] || "";
}



function renderTemplates() {
  if (!grid || !data.length) return;

  grid.innerHTML = "";

  const filtered = getTemplatesByPlan();

  filtered.forEach((item) => {
    const col = document.createElement("div");
    col.className = "col-md-6 mb-4";

    col.innerHTML = `
      <div class="card h-100 shadow-sm template-card" style="cursor:pointer">
        <img src="${item.img}" class="card-img-top" alt="${item.title}">
        <div class="card-body">
          <h5 class="card-title">${item.title}</h5>
          <p class="card-text">${item.desc}</p>
        </div>
      </div>
    `;

    // col.addEventListener("click", () => {
    //   active = data.indexOf(item); 
    //   update();

    //   const modalEl = document.getElementById('templatesModal');
    //   const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
    //   modal.hide();
    // });

    col.addEventListener("click", () => {
      active = data.indexOf(item);
      update();

      const templatesModalEl = document.getElementById('templatesModal');
      const templatesModal = bootstrap.Modal.getOrCreateInstance(templatesModalEl);

      templatesModal.hide();

      // abre preview depois que fechar
      templatesModalEl.addEventListener('hidden.bs.modal', function handler() {
        openTemplatePreview(item);
        templatesModalEl.removeEventListener('hidden.bs.modal', handler);
      });
    });

    grid.appendChild(col);
  });

}


// =============================
// TEMPLATE TABS
// =============================
function bindTemplateTabs() {
  if (tabsBound) return;

  const tabs = document.querySelectorAll("#templateTabs .nav-link");

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {

      tabs.forEach(t => t.classList.remove("active"));
      tab.classList.add("active");

      currentPlan = tab.dataset.plan;

      updatePlanDescription();
      renderTemplates();
    });
  });

  tabsBound = true;
}


// =============================
// EVENTS
// =============================
// function bindEvents() {
//   const modalEl = document.getElementById('templatesModal');

//   if (modalEl) {
//     modalEl.addEventListener('show.bs.modal', () => {
//       renderTemplates();
//       bindTemplateTabs();
//     });
//   }
// }

function bindEvents() {
  const templatesModalEl = document.getElementById('templatesModal');
  const previewModalEl = document.getElementById('templatePreviewModal');

  if (templatesModalEl) {
    templatesModalEl.addEventListener('show.bs.modal', () => {
      renderTemplates();
      bindTemplateTabs();
    });
  }

  if (previewModalEl) {
    previewModalEl.addEventListener('hidden.bs.modal', () => {
      const modal = bootstrap.Modal.getOrCreateInstance(templatesModalEl);
      modal.show();
    });
  }
}

updatePlanDescription();