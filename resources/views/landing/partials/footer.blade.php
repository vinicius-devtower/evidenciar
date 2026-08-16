 <footer id="footer" class="footer dark-background">

     <div class="container footer-top">
         <div class="row gy-4">

             <!-- Branding -->
             <div class="col-lg-4 col-md-12 footer-about">
                 <a href="/" class="logo d-flex align-items-center">
                     <span class="sitename">Evidenciar</span>
                 </a>
                 <p>
                     Sites profissionais para advogados que querem aparecer no Google e fechar mais clientes — sem
                     complicação
                     técnica.
                 </p>

                 <div class="social-links d-flex mt-4">
                     <a href="#"><i class="bi bi-instagram"></i></a>
                     <a href="#"><i class="bi bi-linkedin"></i></a>
                     <a href="#"><i class="bi bi-youtube"></i></a>
                 </div>
             </div>

             <!-- Produto -->
             <div class="col-lg-2 col-6 footer-links">
                 <h4>Produto</h4>
                 <ul>
                     <li><a href="#">Como funciona</a></li>
                     <li><a href="#">Modelos</a></li>
                     <li><a href="#">Planos</a></li>
                     <li><a href="#">Demonstração</a></li>
                 </ul>
             </div>

             <!-- Conteúdo -->
             <div class="col-lg-2 col-6 footer-links">
                 <h4>Para Advogados</h4>
                 <ul>
                     <li><a href="#">SEO jurídico</a></li>
                     <li><a href="#">Marketing jurídico</a></li>
                     <li><a href="#">Blog</a></li>
                 </ul>
             </div>

             <!-- Suporte -->
             <div class="col-lg-2 col-6 footer-links">
                 <h4>Suporte</h4>
                 <ul>
                     <li><a href="#">Central de ajuda</a></li>
                     <li><a href="#">Fale conosco</a></li>
                     <li><a href="#">WhatsApp</a></li>
                 </ul>
             </div>

             <!-- Contato -->
             <div class="col-lg-2 col-md-12 footer-contact">
                 <h4>Contato</h4>
                 <p>Email: suporte@evidenciar.com</p>
                 <p>WhatsApp: (xx) xxxx-xxxx</p>
                 <p>Seg–Sex, 9h às 18h</p>

                 <a href="#" class="btn btn-primary mt-3">
                     Iniciar Agora
                 </a>
             </div>

         </div>
     </div>

     <!-- Bottom -->
     <div class="container copyright text-center mt-4">
         <p>
             © <strong>Evidenciar</strong> — Todos os direitos reservados
         </p>
         <div class="credits">
             <a href="#">Termos</a> ·
             <a href="#">Privacidade</a> ·
             <a href="#">LGPD</a>
         </div>
     </div>

 </footer>

 <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
         class="bi bi-arrow-up-short"></i></a>

 <div id="preloader"></div>

 <script src="{{ asset('landing/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/php-email-form/validate.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/aos/aos.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
 <script src="{{ asset('landing/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

 <script src="{{ asset('landing/assets/js/main.js') }}"></script>
 {{-- <script src="{{ asset('landing/assets/js/templates.js') }}"></script> --}}
 <script type="module">
     import {
         initTemplates
     } from './landing/assets/js/modules/templates/index.js';

     initTemplates();
 </script>
