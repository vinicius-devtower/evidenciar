document.addEventListener('DOMContentLoaded', () => {

    /* =========================
       CONFIG
    ========================= */
    const CONFIG = {
        maxCategorias: 8,
        maxTags: 8
    };

    /* =========================
       CATEGORIAS (BOTÕES)
    ========================= */
    function initCategorias() {
        const botoes = document.querySelectorAll('.categoria');

        botoes.forEach(btn => {
            btn.addEventListener('click', () => {
                const selecionadas = document.querySelectorAll('.categoria.active');

                if (btn.classList.contains('active')) {
                    btn.classList.remove('active', 'btn-success');
                    btn.classList.add('btn-outline-secondary');
                    return;
                }

                if (selecionadas.length >= CONFIG.maxCategorias) {
                    Swal.fire({
                        imageUrl: 'assets/img/eva-1.svg',
                        title: 'Limite atingido',
                        text: `Você pode selecionar no máximo ${CONFIG.maxCategorias} categorias.`,
                        confirmButtonColor: '#01c38e'
                    });
                    return;
                }

                btn.classList.add('active', 'btn-success');
                btn.classList.remove('btn-outline-secondary');
            });
        });
    }

    /* =========================
       TAG INPUT
    ========================= */
    function initTagInput() {
        const input = document.getElementById('inputAtuacao');
        const container = document.getElementById('tagContainer');

        let tags = [];

        function criarTag(texto) {
            texto = texto.trim();

            if (!texto || tags.includes(texto)) return;

            if (tags.length >= CONFIG.maxTags) {
                Swal.fire({
                   imageUrl: 'assets/img/eva-1.svg',
                    title: 'Limite atingido',
                    text: `Você pode adicionar no máximo ${CONFIG.maxTags} áreas de atuação.`,
                    confirmButtonColor: '#01c38e'
                });
                return;
            }

            tags.push(texto);

            const tag = document.createElement('div');
            tag.classList.add('tag');
            tag.innerHTML = `${texto} <span>&times;</span>`;

            tag.querySelector('span').addEventListener('click', () => {
                container.removeChild(tag);
                tags = tags.filter(t => t !== texto);
            });

            container.insertBefore(tag, input);
        }

        input.addEventListener('keydown', (e) => {
            if (e.key === ',' || e.key === 'Enter') {
                e.preventDefault();
                criarTag(input.value);
                input.value = '';
            }
        });

        container.addEventListener('click', () => {
            input.focus();
        });
    }

    

    /* =========================
       INIT
    ========================= */
    initCategorias();
    initTagInput();

});

