<div class="modal fade" id="leadModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 modal-with-sidebar">

      <div class="modal-header">

        <button type="button" class="btn btn-link p-0 me-2" id="btnBack" onclick="goBack()">
          ← Voltar
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

      </div>

      <div class="modal-body">

        <div class="progress mb-4" style="height: 4px;">
          <div class="progress-bar" id="progressBar" style="width: 20%"></div>
        </div>

        <div class="step active" data-step="1">
          <h5 class="modal-title">Vamos começar seu site!</h5>
          <p class="text-muted">Leva menos de 1 minuto. Preencha com os seus dados</p>

          <form id="leadForm" class="d-flex flex-column gap-3">

            <input type="text" class="form-control form-control-lg" placeholder="Seu nome">
            <input type="email" class="form-control form-control-lg" placeholder="Seu e-mail">
            <input type="tel" class="form-control form-control-lg" id="whatsapp" placeholder="WhatsApp">

            <button type="submit" class="btn btn-primary btn-lg">
              Continuar
            </button>

          </form>

        </div>

        <div class="step" data-step="2">


          <h5 class="modal-title">Você já tem um domínio?</h5>
          <p class="text-muted">Lorem ipsun dolor sun amet sit</p>

          <div class="d-grid gap-3">
            <button class="btn btn-primary btn-lg" onclick="goToStep(3)">
              Já tenho um domínio
            </button>

            <button class="btn btn-primary btn-lg" onclick="goToStep(5)">
              Quero registrar um domínio
            </button>
          </div>

        </div>

        <div class="step" data-step="3">
          <h4 class="mb-3">Digite seu domínio</h4>
          <p class="text-muted">Lorem ipsun dolor sun amet sit</p>

          <input type="text" class="form-control form-control-lg mb-3"
            placeholder="seuescritorio.com.br" id="dominioInput">

          <button class="btn btn-primary w-100" onclick="validarDominio()">
            Continuar
          </button>
        </div>

        <div class="step" data-step="4">
          <h4 class="mb-3">Perfeito! Vamos usar seu domínio</h4>
          <p class="text-muted"> Após o pagamento, ajudaremos você a conectá-lo à Evidenciar.</p>


          <div class="d-grid gap-2">
            <button class="btn btn-primary" onclick="goToStep(6)">
              Eu configuro o DNS
            </button>

            <button class="btn btn-primary" onclick="goToStep(6)">
              Quero ajuda do suporte
            </button>
          </div>
        </div>

        <div class="step" data-step="5">
          <h4 class="mb-3">Escolha seu domínio</h4>
          <p class="text-muted">Lorem ipsun dolor sun amet sit</p>

          <div class="input-group input-group-lg mb-3">
            <div class="input-group input-group-lg mb-3">
              <input type="text" class="form-control" placeholder="Digite o nome">

              <select class="form-select" id="tldSelect" style="max-width: 140px;">
                <option>.com.br</option>
                <option>.adv.br</option>
                <option>.com</option>
              </select>
            </div>
          </div>

          <button class="btn btn-primary w-100" onclick="buscarDominio()">
            Pesquisar
          </button>
        </div>

        <div class="step" data-step="6">
          <h4 class="mb-3">Volto já kkkk</h4>
          <p class="text-muted">Lorem ipsun dolor sun amet sit</p>

          <div id="resultadoDominio"></div>
        </div>

      </div>


    </div>
  </div>
</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {

    const totalSteps = 6;

    updateBackButton();

    /* =========================
       STEPS + PROGRESS
    ========================= */
    let stepHistory = [];

    window.goToStep = function(step) {
      const current = document.querySelector('.step.active');
      const currentStep = current ? parseInt(current.dataset.step) : null;

      if (currentStep && currentStep !== step) {
        stepHistory.push(currentStep);
      }

      document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));

      const target = document.querySelector(`[data-step="${step}"]`);
      if (target) target.classList.add('active');

      updateProgress(step);
      updateBackButton();
    };

    function updateBackButton() {
      const btn = document.getElementById('btnBack');

      if (!btn) return;

      if (stepHistory.length === 0) {
        btn.style.visibility = 'hidden';
      } else {
        btn.style.visibility = 'visible';
      }
    }

    window.goBack = function() {
      if (stepHistory.length === 0) return;

      const previousStep = stepHistory.pop();

      document.querySelectorAll('.step').forEach(el => el.classList.remove('active'));

      const target = document.querySelector(`[data-step="${previousStep}"]`);
      if (target) target.classList.add('active');

      updateProgress(previousStep);
      updateBackButton();
    };

    function updateProgress(step) {
      const bar = document.getElementById('progressBar');
      if (!bar) return;

      const progress = (step / totalSteps) * 100;
      bar.style.width = progress + '%';
    }

    /* =========================
       STEP 1 — LEAD
    ========================= */

    const leadForm = document.getElementById('leadForm');

    if (leadForm) {
      leadForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const nome = leadForm.querySelector('input[type="text"]').value.trim();
        const email = leadForm.querySelector('input[type="email"]').value.trim();
        const whatsapp = leadForm.querySelector('#whatsapp').value.trim();

        if (!nome || !email || !whatsapp) {
          Swal.fire({
            icon: 'warning',
            title: 'Preencha todos os campos',
            text: 'Precisamos dessas informações para continuar'
          });
          return;
        }

        goToStep(2);
      });
    }

    /* =========================
       WHATSAPP MASK
    ========================= */

    const whatsappInput = document.getElementById('whatsapp');

    if (whatsappInput) {
      whatsappInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '').substring(0, 11);

        if (value.length > 10) {
          value = value.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
        } else if (value.length > 6) {
          value = value.replace(/^(\d{2})(\d{4})(\d{0,4})$/, '($1) $2-$3');
        } else if (value.length > 2) {
          value = value.replace(/^(\d{2})(\d{0,5})$/, '($1) $2');
        } else {
          value = value.replace(/^(\d*)$/, '($1');
        }

        e.target.value = value;
      });
    }

    /* =========================
       VALIDAÇÃO DE DOMÍNIO
    ========================= */

    function isValidDomain(domain) {
      const regex = /^(?!:\/\/)([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/;
      return regex.test(domain);
    }

    window.validarDominio = function() {
      const dominio = document.getElementById('dominioInput').value.trim();

      if (!dominio) {
        Swal.fire({
          icon: 'warning',
          title: 'Digite um domínio',
        });
        return;
      }

      if (!isValidDomain(dominio)) {
        Swal.fire({
          icon: 'error',
          title: 'Domínio inválido',
          text: 'Exemplo válido: seuescritorio.com.br'
        });
        return;
      }

      // Feedback positivo (rápido e elegante)
      Swal.fire({
        icon: 'success',
        title: 'Domínio válido!',
        timer: 1200,
        showConfirmButton: false
      });

      setTimeout(() => {
        goToStep(4);
      }, 1200);
    };

    /* =========================
       BUSCA DE DOMÍNIO (SIMULADA)
    ========================= */

    window.buscarDominio = function() {
      const nome = document.getElementById('searchDomain').value
        .toLowerCase()
        .replace(/\s+/g, '');

      const resultado = document.getElementById('resultadoDominio');

      if (!nome) {
        Swal.fire({
          icon: 'warning',
          title: 'Digite um nome para pesquisar'
        });
        return;
      }

      const indisponiveis = ['roberto', 'silva', 'advogado'];

      if (indisponiveis.includes(nome)) {

        resultado.innerHTML = `
        <p class="text-danger mb-3">Domínio indisponível 😕</p>

        <div class="d-grid gap-2">
          ${sugestao(nome + 'advogados.com.br')}
          ${sugestao('advocacia' + nome + '.com.br')}
          ${sugestao(nome + '.adv.br')}
        </div>
      `;

      } else {

        resultado.innerHTML = `
        <p class="text-success mb-3">Domínio disponível 🎉</p>

        <div class="card p-3 mb-3 text-center">
          <strong>${nome}.com.br</strong>
        </div>

        <button class="btn btn-success w-100 btn-lg">
          GARANTIR MEU DOMÍNIO E CONTINUAR
        </button>
      `;
      }

      goToStep(6);
    };

    function sugestao(dominio) {
      return `
      <button class="btn btn-outline-primary text-start" onclick="selecionarDominio('${dominio}')">
        ${dominio} <span class="float-end">Escolher</span>
      </button>
    `;
    }

    window.selecionarDominio = function(dominio) {
      const resultado = document.getElementById('resultadoDominio');

      resultado.innerHTML = `
      <p class="text-success mb-3">Ótima escolha 🎉</p>

      <div class="card p-3 mb-3 text-center">
        <strong>${dominio}</strong>
      </div>

      <button class="btn btn-success w-100 btn-lg">
        CONTINUAR COM ESTE DOMÍNIO
      </button>
    `;
    };

    function updateBackButton() {
      const btn = document.getElementById('btnBack');
      const current = document.querySelector('.step.active');

      if (!btn || !current) return;

      const currentStep = parseInt(current.dataset.step);

      // Regra: só mostra a partir do step 2
      if (currentStep === 1) {
        btn.style.visibility = 'hidden';
      } else {
        btn.style.visibility = 'visible';
      }
    }




  });
</script>