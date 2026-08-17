<div class="modal fade" id="privacyModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content p-4 modal-with-sidebar">

      <div class="modal-header">
        <h5 class="modal-title">Termos de Uso e Política de Privacidade</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body" style="max-height: 400px; overflow-y: auto;">

        <p class="text-muted small">Última atualização: 17/08/2026</p>

        <p>A Evidenciar respeita a sua privacidade e se compromete a proteger os dados
        pessoais de quem usa nossa plataforma, em conformidade com a Lei Geral de
        Proteção de Dados (Lei nº 13.709/2018 — LGPD).</p>

        <h6>1. Quais dados coletamos</h6>
        <p>Coletamos os dados que você nos fornece ao criar uma conta (nome, e-mail,
        telefone, CPF/CNPJ), dados de pagamento processados por nosso parceiro de
        cobrança (Mercado Pago), o conteúdo que você publica no seu site (textos,
        imagens, links de contato) e dados de navegação (cookies, endereço IP,
        páginas acessadas) coletados automaticamente para melhorar a plataforma.</p>

        <h6>2. Para que usamos seus dados</h6>
        <p>Usamos seus dados para criar e manter sua conta, processar pagamentos e
        emitir cobranças, publicar e hospedar o site que você monta na Evidenciar,
        enviar comunicações sobre sua assinatura e suporte, e melhorar a segurança
        e o funcionamento da plataforma.</p>

        <h6>3. Com quem compartilhamos</h6>
        <p>Compartilhamos dados apenas com prestadores de serviço essenciais para
        operar a plataforma — processador de pagamentos (Mercado Pago), provedor de
        hospedagem e serviços de e-mail transacional — e apenas na medida necessária
        para prestar o serviço. Não vendemos seus dados a terceiros.</p>

        <h6>4. Seus direitos</h6>
        <p>Você pode, a qualquer momento, solicitar acesso, correção, portabilidade
        ou exclusão dos seus dados pessoais, além de revogar consentimentos dados
        anteriormente. Para exercer esses direitos, entre em contato pelo e-mail
        <a href="mailto:contato@evidenciar.com.br">contato@evidenciar.com.br</a>.</p>

        <h6>5. Segurança e retenção</h6>
        <p>Adotamos medidas técnicas e organizacionais para proteger seus dados
        contra acesso não autorizado, perda ou vazamento. Mantemos seus dados
        apenas pelo tempo necessário para cumprir as finalidades descritas nesta
        política ou obrigações legais.</p>

        <h6>6. Alterações desta política</h6>
        <p>Esta política pode ser atualizada periodicamente para refletir melhorias
        na plataforma ou mudanças na legislação. A data da última atualização
        estará sempre indicada no topo deste documento.</p>

      </div>

      <!-- <div class="modal-footer">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="agreeTerms">
          <label class="form-check-label" for="agreeTerms">
            Li e concordo com os termos
          </label>
        </div>

        <button class="btn btn-primary" disabled id="acceptBtn">
          Continuar
        </button>
      </div> -->

    </div>
  </div>
</div>

<script>
  const checkbox = document.getElementById('agreeTerms');
  const button = document.getElementById('acceptBtn');

  checkbox.addEventListener('change', () => {
    button.disabled = !checkbox.checked;
  });
</script>