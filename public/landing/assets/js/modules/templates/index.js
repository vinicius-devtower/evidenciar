import { fetchTemplates } from '../../api/templates.js';
import { setData } from './state.js';
import { updateCarousel } from './ui.js';
import { bindCarousel, bindTabs } from './events.js';

export async function initTemplates() {
  const data = await fetchTemplates();
  setData(data);

  const cards = Array.from(document.querySelectorAll('.card'));

  bindCarousel(cards);
  bindTabs();

  updateCarousel(cards);
}