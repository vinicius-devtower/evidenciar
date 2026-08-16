<div class="modal fade" id="supportModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 modal-with-sidebar">

      <div class="modal-header">
        <h5 class="modal-title">Falar com Suporte</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form class="d-flex flex-column gap-3">

          <input type="text" class="form-control form-control-lg" placeholder="Seu nome" required>

          <input type="email" class="form-control form-control-lg" placeholder="Seu e-mail" required>

          <input type="tel" class="form-control form-control-lg" placeholder="Telefone / WhatsApp">
          <textarea class="form-control form-control-lg" rows="3" placeholder="Mensagem"></textarea>

          <div>
            <label class="form-label">Como prefere ser contatado?</label>

            <select class="form-select form-control">
              <option>Email</option>
              <option>WhatsApp</option>
              <option>Telefone</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary">
            Enviar mensagem
          </button>

        </form>

      </div>
    </div>
  </div>
</div>