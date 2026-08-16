import { state } from './state.js';

export function updateCarousel(cards) {
  if (!state.data.length) return;

  cards.forEach((card, i) => {
    let pos = (i - state.active + cards.length) % cards.length;

    if (pos < 4) {
      card.style.display = "block";
      card.setAttribute("data-pos", pos);

      const dataIndex = (state.active + pos) % state.data.length;
      const img = card.querySelector("img");

      if (img) {
        img.src = state.data[dataIndex].img;
        img.alt = state.data[dataIndex].title;
      }

    } else {
      card.style.display = "none";
    }
  });

  const current = state.data[state.active];

  const titleEl = document.getElementById('title');
  const descEl = document.getElementById('desc');

  if (titleEl) titleEl.innerText = current.title;
  if (descEl) descEl.innerText = current.desc;
}

export function renderTemplates(grid) {
  if (!grid) return;

  const filtered = state.data.filter(t => t.plan === state.currentPlan);

  grid.innerHTML = "";

  filtered.forEach(item => {
    const col = document.createElement("div");
    col.className = "col-md-6 mb-4";

    col.innerHTML = `
      <div class="card h-100 shadow-sm template-card">
        <img src="${item.img}" class="card-img-top">
        <div class="card-body">
          <h5>${item.title}</h5>
          <p>${item.desc}</p>
        </div>
      </div>
    `;

    col.addEventListener("click", () => {
      window.openTemplatePreview(item);
    });

    grid.appendChild(col);
  });
}