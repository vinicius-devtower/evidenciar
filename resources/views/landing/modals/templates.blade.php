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