<style>
    
.pricing-table {
  border-collapse: separate;
  border-spacing: 0 10px;
}

.pricing-table thead th {
  border: none;
  font-size: 14px;
}

.pricing-table tbody tr {
  background: #f8f9fa;
  border-radius: 10px;
}

.pricing-table td {
  border: none;
  padding: 14px;
}

.pricing-table tbody tr td:first-child {
  border-radius: 10px 0 0 10px;
}

.pricing-table tbody tr td:last-child {
  border-radius: 0 10px 10px 0;
}

/* destaque do plano */
.pricing-table .highlight {
  font-weight: 500;
}

/* linha de botões */
.pricing-table tbody tr:last-child {
  background: transparent;
}
</style>
</style>

<div class="modal fade" id="compareModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content p-4 modal-with-sidebar">

      <div class="modal-header">

        <h5 class="modal-title fw-bold">Compare os planos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

      </div>

      <div class="modal-body">

        <div class="table-responsive">
          <table class="table table-striped align-middle text-center pricing-table">

            <thead>
              <tr>
                <th class="text-start">Recursos</th>

                <th>
                  <h6 class="fw-bold">Start</h6>
                  <small class="text-muted">{{ optional($plans['start'] ?? null)->priceFormatted() ?? 'R$ 49,90' }}/mês</small>
                </th>

                <th class="highlight">
                  <div class="badge bg-success mb-2">Mais popular</div>
                  <h6 class="fw-bold">Profissional</h6>
                  <small>{{ optional($plans['profissional'] ?? null)->priceFormatted() ?? 'R$ 89,90' }}/mês</small>
                </th>

                <th>
                  <h6 class="fw-bold">Gestão VIP</h6>
                  <small class="text-muted">{{ optional($plans['gestao_vip'] ?? null)->priceFormatted() ?? 'R$ 189,90' }}/mês</small>
                </th>
              </tr>
            </thead>

            <tbody>
              <tr>
                <td class="text-start">Domínio grátis</td>
                <td><i class="bi bi-check-lg text-success"></i></td>
                <td class="highlight"><i class="bi bi-check-lg text-success"></i></td>
                <td><i class="bi bi-check-lg text-success"></i></td>
              </tr>

              <tr>
                <td class="text-start">Tipo de site</td>
                <td>One Page</td>
                <td class="highlight">Multipage</td>
                <td>Multipage</td>
              </tr>

              <tr>
                <td class="text-start">Hospedagem + SSL</td>
                <td><i class="bi bi-check-lg text-success"></i></td>
                <td class="highlight"><i class="bi bi-check-lg text-success"></i></td>
                <td><i class="bi bi-check-lg text-success"></i></td>
              </tr>

              <tr>
                <td class="text-start">Assistente IA</td>
                <td><i class="bi bi-x text-danger"></i></td>
                <td class="highlight"><i class="bi bi-check-lg text-success"></i></td>
                <td><i class="bi bi-check-lg text-success"></i></td>
              </tr>

              <tr>
                <td class="text-start">Email profissional</td>
                <td>1 conta (2GB)</td>
                <td class="highlight">1 conta (10GB)</td>
                <td>3 contas (15GB cada)</td>
              </tr>

              <tr>
                <td class="text-start">Suporte prioritário</td>
                <td><i class="bi bi-x text-danger"></i></td>
                <td class="highlight"><i class="bi bi-x text-danger"></i></td>
                <td><i class="bi bi-check-lg text-success"></i></td>
              </tr>

              <tr>
                <td class="text-start">SEO / Consultoria</td>
                <td><i class="bi bi-x text-danger"></i></td>
                <td class="highlight">SEO básico</td>
                <td>Consultoria mensal</td>
              </tr>

             

            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>