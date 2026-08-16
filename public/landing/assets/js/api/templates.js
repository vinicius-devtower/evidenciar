export async function fetchTemplates() {
  try {
    const res = await fetch('api/templates');
    return await res.json();
  } catch (err) {
    console.error('Erro ao carregar templates:', err);
    return [];
  }
}