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
                                    <span class="question">Lorem ipsum dolor sit amet, consectetur adipiscing elit?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae erat.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                                <h3>
                                    <span class="num">2</span>
                                    <span class="question">Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim.</p>
                                    <p>Mauris ultrices eros in cursus turpis massa tincidunt dui. Pellentesque nec nam aliquam sem et tortor. Habitant morbi tristique senectus et netus et malesuada.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                                <h3>
                                    <span class="num">3</span>
                                    <span class="question">Dolor sit amet consectetur adipiscing elit pellentesque?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus.</p>
                                    <p>Mauris ultrices eros in cursus turpis massa tincidunt dui. Pellentesque nec nam aliquam sem et tortor. Habitant morbi tristique senectus et netus et malesuada.</p>
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
                                    <span class="question">Ac odio tempor orci dapibus ultrices in iaculis?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                                <h3>
                                    <span class="num">2</span>
                                    <span class="question">Tempus quam pellentesque nec nam aliquam sem et tortor consequat?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.</p>
                                    <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate faq-active" data-aos="fade-up" data-aos-delay="400">
                                <h3>
                                    <span class="num">3</span>
                                    <span class="question">Varius vel pharetra vel turpis nunc eget lorem dolor?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.</p>
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
                                    <span class="question">Tortor vitae purus faucibus ornare suspendisse sed nisi lacus?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.</p>
                                    <p>Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="300">
                                <h3>
                                    <span class="num">2</span>
                                    <span class="question">Tortor dignissim convallis aenean et tortor at risus viverra?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>In hac habitasse platea dictumst vestibulum rhoncus est pellentesque. Dictumst vestibulum rhoncus est pellentesque elit ullamcorper. Non diam phasellus vestibulum lorem sed. Platea dictumst quisque sagittis purus sit.</p>
                                </div>
                            </div>

                            <div class="faq-item aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
                                <h3>
                                    <span class="num">3</span>
                                    <span class="question">Venenatis urna cursus eget nunc scelerisque viverra mauris in?</span>
                                    <i class="bi bi-plus-lg faq-toggle"></i>
                                </h3>
                                <div class="faq-content">
                                    <p>Mauris ultrices eros in cursus turpis massa tincidunt dui. Pellentesque nec nam aliquam sem et tortor. Habitant morbi tristique senectus et netus et malesuada.</p>
                                    <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit.</p>
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
