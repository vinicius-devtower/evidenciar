<!DOCTYPE html>
<html lang="pt-br">

@include('landing.partials.head')

<body class="index-page">

    {{-- @include('landing.partials.header') --}}

    <main>
        @include('landing.sections.hero')
        @include('landing.sections.about')
        @include('landing.sections.howitworks')
        @include('landing.sections.templates')
        @include('landing.sections.professionals')
        @include('landing.sections.precos2')
        @include('landing.sections.faq')
    </main>

    @include('landing.modais.templates')
    @include('landing.modais.compare-planos')
    @include('landing.modais.termos')
    @include('landing.modais.falar-suporte')

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

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
    <script src="{{ asset('landing/assets/js/templates.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const track = document.getElementById('carouselTrack');
            if (!track) return;

            let cards = Array.from(document.querySelectorAll('.template-card'));

            const title = document.getElementById('template-title');
            const desc = document.getElementById('template-desc');

            function updateContent(card) {
                if (!title || !desc) return;
                title.textContent = card.dataset.title;
                desc.textContent = card.dataset.desc;
            }

            function nextCard() {
                const first = cards.shift();
                cards.push(first);
                track.appendChild(first);
                refreshClasses();
            }

            function prevCard() {
                const last = cards.pop();
                cards.unshift(last);
                track.prepend(last);
                refreshClasses();
            }

            function refreshClasses() {
                cards.forEach(card => card.classList.remove('active', 'prev'));
                cards[0]?.classList.add('active');
                cards[1]?.classList.add('prev');
                updateContent(cards[0]);
            }

            document.getElementById('next')?.addEventListener('click', nextCard);
            document.getElementById('prev')?.addEventListener('click', prevCard);

            refreshClasses();
        });

        document.querySelectorAll(".pricing-card").forEach(card => {
            const plan = card.dataset.plan;
            const toggle = card.querySelector(".toggle-input");
            const priceEl = card.querySelector("[data-price]");

            if (!toggle || !priceEl || typeof pricingData === 'undefined' || !pricingData[plan]) return;

            function updatePrice() {
                const isYearly = toggle.checked;
                const value = isYearly ? pricingData[plan].yearly : pricingData[plan].monthly;
                priceEl.innerText = "R$" + value.toFixed(2).replace(".", ",");
            }

            toggle.addEventListener("change", updatePrice);
            updatePrice();
        });
    </script>

</body>

</html>
