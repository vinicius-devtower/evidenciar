document.addEventListener('DOMContentLoaded', () => {
    const domainSearch = DomainSearch();
    const dominioUI = DominioUI(domainSearch);

    dominioUI.init();
    domainSearch.init();
});


/**
 * =========================
 * DOMAIN SEARCH (STATE + LOGIC)
 * =========================
 */
const DomainSearch = () => {

    const elements = {
        btnSearch: document.querySelector('.btnSearchDomain'),
        input: document.getElementById('inputDominio'),
        resultado: document.getElementById('resultadoDominio'),
        btnNext: document.getElementById('btnNext')
    };

    const clear = () => {
        elements.resultado.innerHTML = '';
        elements.btnNext.style.display = 'none';
    };

    const showMessage = (type, message) => {
        const classes = {
            success: 'text-success',
            error: 'text-danger',
            warning: 'text-warning'
        };

        elements.resultado.innerHTML = `
      <div class="${classes[type]}">
        ${message}
      </div>
    `;
    };

    const validateInput = (dominio) => {
        if (!dominio) {
            Swal.fire({
                imageUrl: 'assets/img/eva-1.svg',
                title: 'Oops...',
                text: 'Informe um domínio válido!',
                confirmButtonText: 'Entendi',
                confirmButtonColor: '#01c38e'
            });
            return false;
        }
        return true;
    };

    const checkDomain = async (dominio) => {
        if (dominio.toLowerCase().endsWith('.br')) {
            const res = await fetch(`https://rdap.registro.br/domain/${dominio}`);
            if (res.status === 404) return 'disponivel';
            if (res.status === 200) return 'registrado';
        }
        return 'indefinido';
    };


    const handleSearch = async () => {
        const dominio = elements.input.value.trim();

        if (!validateInput(dominio)) return;

        // ⏱ controle de tempo mínimo
        const startTime = Date.now();

        // Buscando
        Swal.fire({
            title: 'Verificando domínio...',
            text: 'Aguarde um momento',
            allowOutsideClick: false,
            allowEscapeKey: false,
            imageUrl: 'assets/img/eva-1.svg',
            didOpen: () => {
                Swal.showLoading();
            }
        });

        try {
            const status = await checkDomain(dominio);

            // ⏱ garante mínimo de 3 segundos
            const elapsed = Date.now() - startTime;
            const remaining = 3000 - elapsed;
            if (remaining > 0) {
                await new Promise(r => setTimeout(r, remaining));
            }

            Swal.close();

            // =========================
            // RESULTADO
            // =========================
            if (status === 'disponivel') {

                Swal.fire({
                    // icon: 'success',
                    imageUrl: 'assets/img/eva-1.svg',
                    html: `
          <div class="cor-azul-escuro" style="text-align: left;">
            <h5>Boas notícias</h5>
            <p>O domínio <strong>${dominio}</strong> está esperando você.</p>
            <p>Taxa do Registro.br:<br>R$40,00/ano (Grátis no Plano Anual)</p>
            <p>Após o pagamento nossa equipe ajudará você a conectá-lo à Evidenciar</p>
          </div>
        `,
                    confirmButtonText: 'Entendi. Próximo Passo',
                    confirmButtonColor: '#01c38e'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.assign('jornada-cadastro.php');
                    }
                });

            } else if (status === 'registrado') {

                // ❌ mostra mensagem inline (como você pediu)
                showMessage('error', `O domínio <strong>${dominio}</strong> já está registrado.`);

            } else {

                showMessage('warning', '⚠ Não foi possível verificar o domínio. As vezes isso acontece :( Entre em contato com nosso suporte para prosseguir');

            }

        } catch (error) {
            Swal.close();
            showMessage('error', 'Erro ao verificar domínio.');
        }
    };

    const bindEvents = () => {
        if (!elements.btnSearch || !elements.input) return;

        elements.btnSearch.addEventListener('click', handleSearch);

        elements.input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                handleSearch();
            }
        });
    };

    const init = () => {
        bindEvents();
    };

    return {
        init,
        clear
    };
};


/**
 * =========================
 * UI (DOM + INTERAÇÕES)
 * =========================
 */
const DominioUI = (domainSearch) => {

    const elements = {
        botoes: document.querySelectorAll('.btn-dominio button'),
        btnPossuo: document.getElementById('btnPossuoDominio'),
        btnNovo: document.getElementById('btnNovoDominio'),
        containerNovo: document.getElementById('containerNovoDominio'),
        containerExistente: document.getElementById('containerJaTenhoDominio')
    };

    const setActiveButton = (btn) => {
        elements.botoes.forEach(b => b.classList.remove('btn-dominio-active'));
        btn.classList.add('btn-dominio-active');
    };

    const toggleContainers = (btn) => {
        const isNovo = btn === elements.btnNovo;

        elements.containerNovo.style.display = isNovo ? 'block' : 'none';
        elements.containerExistente.style.display = isNovo ? 'none' : 'block';
    };

    const bindEvents = () => {
        elements.botoes.forEach(btn => {
            btn.addEventListener('click', () => {
                setActiveButton(btn);
                toggleContainers(btn);

                // 🔥 regra clara e desacoplada
                if (btn === elements.btnPossuo) {
                    domainSearch.clear();
                }
            });
        });
    };

    const init = () => {
        if (elements.btnNovo) {
            setActiveButton(elements.btnNovo);
            toggleContainers(elements.btnNovo);
        }

        bindEvents();
    };

    return { init };
};
