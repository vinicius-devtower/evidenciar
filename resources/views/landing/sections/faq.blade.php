<style>
    /*--------------------------------------------------------------
# Faq Section
--------------------------------------------------------------*/
    .faq .faq-tabs .nav-pills {
        display: inline-flex;
        padding: 8px;
        background-color: var(--cor-azul-escuro);
        border-radius: 50px;
    }

    .faq .faq-tabs .nav-pills .nav-item {
        margin: 0 5px;
    }

    .faq .faq-tabs .nav-pills .nav-item:first-child {
        margin-left: 0;
    }

    .faq .faq-tabs .nav-pills .nav-item:last-child {
        margin-right: 0;
    }

    .faq .faq-tabs .nav-pills .nav-link {
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 500;
        color: var(--cor-areia);
        transition: all 0.3s ease;
    }

    .faq .faq-tabs .nav-pills .nav-link:hover {
        color: var(--cor-verde);
    }

    .faq .faq-tabs .nav-pills .nav-link.active {
        background-color: var(--cor-azul-medio);
        color: var(--contrast-color);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .faq .faq-tabs .nav-pills .nav-link i {
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .faq .faq-tabs .nav-pills {
            flex-wrap: wrap;
            justify-content: center;
        }

        .faq .faq-tabs .nav-pills .nav-item {
            margin: 5px;
        }
    }

    .faq .faq-list .faq-item {
        margin-bottom: 20px;
        border-radius: 10px;
        background-color: var(--surface-color);
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.3s ease;
        padding: 15px 30px;
    }

    .faq .faq-list .faq-item:hover {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }

    .faq .faq-list .faq-item h3 {
        display: flex;
        align-items: center;
        padding: 15px 0px;
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        background-color: var(--surface-color);
        transition: all 0.3s ease;
        position: relative;
    }

    .faq .faq-list .faq-item h3:hover {
        background-color: color-mix(in srgb, var(--accent-color), transparent 95%);
    }

    .faq .faq-list .faq-item h3 .num {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        margin-right: 15px;
        background-color: color-mix(in srgb, var(--accent-color), transparent 85%);
        color: var(--accent-color);
        border-radius: 50%;
        font-size: 0.9rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .faq .faq-list .faq-item h3 .question {
        flex: 1;
    }

    .faq .faq-list .faq-item h3 .faq-toggle {
        font-size: 1.2rem;
        transition: all 0.3s ease;
        color: color-mix(in srgb, var(--default-color), transparent 30%);
        margin-left: 15px;
    }

    .faq .faq-list .faq-item .faq-content {
        padding: 10px;
        display: none;
    }

    .faq .faq-list .faq-item .faq-content p {
        overflow: hidden;
        padding: 0;
        margin: 0;
    }

    .faq .faq-list .faq-item .faq-content p:last-child {
        margin-bottom: 0;
        overflow: hidden;
    }

    .faq .faq-list .faq-item.faq-active h3 {
        background-color: color-mix(in srgb, var(--accent-color), transparent 90%);
    }

    .faq .faq-list .faq-item.faq-active h3 .faq-toggle {
        transform: rotate(45deg);
        color: var(--accent-color);
    }

    .faq .faq-list .faq-item.faq-active .faq-content {
        display: block;
    }

    .faq .faq-cta {
        background-color: var(--cor-azul-medio);
        padding: 30px;
        border-radius: 10px;
        color: var(--cor-areia);
    }

    .faq .faq-cta p {
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .faq .faq-cta .btn-primary:hover {
        background-color: color-mix(in srgb, var(--accent-color), #000 15%);
        border-color: color-mix(in srgb, var(--accent-color), #000 15%);
        transform: translateY(-2px);
    }

    @media (max-width: 576px) {
        .faq .faq-list .faq-item h3 {
            padding: 15px 20px;
            font-size: 1rem;
        }

        .faq .faq-list .faq-item h3 .num {
            width: 24px;
            height: 24px;
            margin-right: 10px;
            font-size: 0.8rem;
        }

        .faq .faq-list .faq-item .faq-content .content-inner {
            padding: 0 20px;
        }

        .faq .faq-list .faq-item .faq-content.faq-active .content-inner {
            padding: 15px 20px;
        }
    }
</style>

<section id="faq" class="faq section">

    <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">

        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="faq-tabs mb-5">
                    <ul class="nav nav-pills justify-content-center" id="faqTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#faq-general" type="button" role="tab" aria-controls="general" aria-selected="true">
                                <i class="bi bi-question-circle me-2"></i>Geral
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pricing-tab" data-bs-toggle="pill" data-bs-target="#faq-pricing" type="button" role="tab" aria-controls="pricing" aria-selected="false" tabindex="-1">
                                <i class="bi bi-credit-card me-2"></i>Planos
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="support-tab" data-bs-toggle="pill" data-bs-target="#faq-support" type="button" role="tab" aria-controls="support" aria-selected="false" tabindex="-1">
                                <i class="bi bi-headset me-2"></i>Suporte
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="faqTabContent">
                    {{-- General FAQs --}}
                    <div class="tab-pane fade active show" id="faq-general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="faq-list">

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                <h3>
                                    <span class="num">1</span>
                                    <span class="question">Preciso saber programar pra usar a Evidenciar?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Não. O editor foi feito pra quem nunca mexeu em site na vida — se você sabe mandar um e-mail, você sabe editar o seu. É só clicar no texto, trocar pela sua informação e salvar.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                                <h3>
                                    <span class="num">2</span>
                                    <span class="question">O site funciona bem no celular?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Sim. Todos os templates são responsivos — se adaptam automaticamente pra ficar bem em celular, tablet e computador, sem nenhuma configuração extra da sua parte.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                                <h3>
                                    <span class="num">3</span>
                                    <span class="question">Vocês fazem o site pra mim, ou eu que preencho?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>No plano Start e Profissional, você mesmo edita — texto, foto e logo, leva poucos minutos. Se preferir não mexer em nada, o plano Gestão VIP inclui o serviço de Concierge: você manda o conteúdo pelo WhatsApp e nossa equipe atualiza o site pra você.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Pricing FAQs --}}
                    <div class="tab-pane fade" id="faq-pricing" role="tabpanel" aria-labelledby="pricing-tab">
                        <div class="faq-list">

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                <h3>
                                    <span class="num">1</span>
                                    <span class="question">Preciso pagar hospedagem ou domínio por fora?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Hospedagem, certificado SSL e suporte já estão inclusos em todos os planos. O registro do domínio (~R$40/ano) é cobrado à parte no plano mensal — no plano anual, o domínio sai por nossa conta.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                                <h3>
                                    <span class="num">2</span>
                                    <span class="question">Qual a diferença entre o plano mensal e o anual?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>O plano mensal tem fidelidade de 6 meses. O plano anual sai mais barato (equivalente a pagar 10 meses e ganhar 2 grátis) e já inclui o registro do domínio sem custo adicional.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate faq-active" data-aos="fade-up" data-aos-delay="400">
                                <h3>
                                    <span class="num">3</span>
                                    <span class="question">Posso trocar de plano depois de contratar?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Sim, o upgrade pode ser feito a qualquer momento direto pelo seu painel — sem precisar recomeçar o cadastro do zero.</p>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Support FAQs --}}
                    <div class="tab-pane fade" id="faq-support" role="tabpanel" aria-labelledby="support-tab">
                        <div class="faq-list">

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
                                <h3>
                                    <span class="num">1</span>
                                    <span class="question">E se eu quiser cancelar?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Fora do período de fidelidade, o cancelamento é livre, sem multa. Se ainda estiver dentro da fidelidade, é só chamar nosso suporte que explicamos as condições — sem letras miúdas.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                                <h3>
                                    <span class="num">2</span>
                                    <span class="question">Como funciona o suporte?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Atendimento via WhatsApp, com um humano de verdade do outro lado. Quem está no plano Gestão VIP tem prioridade máxima na fila.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                                <h3>
                                    <span class="num">3</span>
                                    <span class="question">Meus dados e o site do meu escritório ficam seguros?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Sim. Todo site tem certificado SSL (cadeado de segurança) incluso — essencial pra quem atende advogados e contadores — e seguimos a LGPD no tratamento dos seus dados.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="faq-cta text-center mt-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                    <p>Ficou alguma dúvida? Precisa de ajuda?</p>
                    <a href="#" class="btn btn-primary"><i class="bi bi-headset me-2"></i> Falar com Suporte</a>
                </div>

            </div>
        </div>

    </div>

</section>

<script>
    document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle, .faq-item .faq-header')
        .forEach((trigger) => {
            trigger.addEventListener('click', () => {
                trigger.parentNode.classList.toggle('faq-active');
            });
        });
</script>
