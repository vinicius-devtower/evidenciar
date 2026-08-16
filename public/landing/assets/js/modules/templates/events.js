import { next, prev, setPlan } from './state.js';
import { updateCarousel, renderTemplates } from './ui.js';

export function bindCarousel(cards) {
  window.next = () => {
    next();
    updateCarousel(cards);
  };

  window.prev = () => {
    prev();
    updateCarousel(cards);
  };
}

export function bindTabs() {
  const tabs = document.querySelectorAll("#templateTabs .nav-link");

  tabs.forEach(tab => {
    tab.addEventListener("click", () => {

      tabs.forEach(t => t.classList.remove("active"));
      tab.classList.add("active");

      setPlan(tab.dataset.plan);

      renderTemplates(document.getElementById("templatesGrid"));
    });
  });
}