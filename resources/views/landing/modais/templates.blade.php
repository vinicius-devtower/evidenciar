<style>
  /*--------------------------------------------------------------
# Templates Modal Tabs (mesmo padrão do FAQ)
--------------------------------------------------------------*/
  .templates-tabs {
    display: block;
    text-align: center;
    margin: 0 auto;
  }

  #planDescription {
    max-width: 700px;
    margin: 0 auto;
  }

  .templates-tabs .nav-pills {
    display: inline-flex;
    padding: 8px;
    background-color: var(--cor-azul-escuro);
    border-radius: 50px;
    max-height: 63px;
  }

  .templates-tabs .nav-pills .nav-item {
    margin: 0 5px;
  }

  .templates-tabs .nav-pills .nav-item:first-child {
    margin-left: 0;
  }

  .templates-tabs .nav-pills .nav-item:last-child {
    margin-right: 0;
  }

  .templates-tabs .nav-pills .nav-link {
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 500;
    color: var(--cor-areia);
    transition: all 0.3s ease;
    background: transparent;
    border: none;
  }

  .templates-tabs .nav-pills .nav-link:hover {
    color: var(--cor-verde);
  }

  .templates-tabs .nav-pills .nav-link.active {
    background-color: var(--cor-azul-medio);
    color: var(--contrast-color);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  }

  /* Responsivo igual FAQ */
  @media (max-width: 768px) {
    .templates-tabs .nav-pills {
      flex-wrap: wrap;
      justify-content: center;
    }

    .templates-tabs .nav-pills .nav-item {
      margin: 5px;
    }
  }


  #planDescription {
    font-size: 0.95rem;
    line-height: 1.6;
  }

  #planDescription p {
    margin: 0;
  }
</style>

<div class="modal fade" id="templatesModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content modal-with-sidebar">

      <div class="modal-header">
        <h5 class="modal-title">Escolha um modelo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="templates-tabs mt-3 mb-3">
          <ul class="nav nav-pills justify-content-center mb-4" id="templateTabs">
            <li class="nav-item">
              <button class="nav-link active" data-plan="start">Start</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-plan="professional">Profissional</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-plan="vip">VIP</button>
            </li>
          </ul>

          <div class="text-left mb-4" id="planDescription">
            <p class="mb-0 text-muted"></p>
          </div>
        </div>





        <div class="row" id="templatesGrid"></div>
      </div>

    </div>
  </div>
</div>