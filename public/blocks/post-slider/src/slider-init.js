(function (window) {

    window.initBoldpoSlider = function (scope) {

        const wraps = (scope || document).querySelectorAll(
            '.boldpo-post-slider-block-wrap'
        );

        wraps.forEach(function (wrap) {

            // Check if Swiper is available
            if (typeof Swiper === 'undefined') {
                console.warn('BoldPost: Swiper is not defined. Retrying later or check enqueue.');
                return;
            }

            const unique = wrap.dataset.unique;
            const sliderElement = wrap.querySelector('.boldpo-post-slider-' + unique);

            // already initialized or no slider element
            if (wrap.dataset.initialized === 'true' || !sliderElement) {
                return;
            }

            // Initialize Swiper with element reference
            try {
                let slidesPerView = Number(wrap.dataset.slidesPerView) || 1;
                let spaceBetween = Number(wrap.dataset.spaceBetween) || 15;
                let slidesPerViewMobileSmall = Number(wrap.dataset.slidesPerViewMobileSmall) || 1;
                let slidesPerViewMobile = Number(wrap.dataset.slidesPerViewMobile) || 1;
                let slidesPerViewTablet = Number(wrap.dataset.slidesPerViewTablet) || 2;
                let slidesPerViewDesktop = Number(wrap.dataset.slidesPerViewDesktop) || slidesPerView;
                let slidesPerViewDesktopLarge = Number(wrap.dataset.slidesPerViewDesktopLarge) || slidesPerViewDesktop;

                new Swiper(sliderElement, {
                    slidesPerView: slidesPerView,
                    spaceBetween: spaceBetween,
                    centeredSlides: wrap.dataset.centeredSlides === 'true',
                    loop: wrap.dataset.loop === 'true',
                    effect: wrap.dataset.effect || 'slide',
                    speed: Number(wrap.dataset.speed) || 300,
                    autoplay: wrap.dataset.autoplay !== 'false' ? {
                        delay: Number(wrap.dataset.speed) || 3000,
                        disableOnInteraction: wrap.dataset.pauseOnInter === 'true',
                        pauseOnMouseEnter: wrap.dataset.pauseOnHover === 'true',
                    } : false,

                    navigation: {
                        nextEl: wrap.querySelector('.swiper-button-next'),
                        prevEl: wrap.querySelector('.swiper-button-prev'),
                    },

                    // Ensure we use the specific pagination inside this wrap if it exists
                    pagination: {
                        el: wrap.querySelector('.swiper-pagination'),
                        clickable: true,
                    },

                    // Better support for editor responsive preview
                    observer: true,
                    observeParents: true,
                    resizeObserver: true,
                    breakpointsBase: 'container',

                    breakpoints: {
                        0: {
                            slidesPerView: slidesPerViewMobileSmall,
                            spaceBetween: 10
                        },
                        360: {
                            slidesPerView: slidesPerViewMobile,
                            spaceBetween: 10,
                        },
                        600: {
                            slidesPerView: slidesPerViewTablet,
                            spaceBetween: spaceBetween,
                        },
                        960: {
                            slidesPerView: slidesPerViewDesktop,
                            spaceBetween: spaceBetween,
                        },
                        1200: {
                            slidesPerView: slidesPerViewDesktop,
                            spaceBetween: spaceBetween,
                        },
                        1600: {
                            slidesPerView: slidesPerViewDesktopLarge,
                            spaceBetween: spaceBetween,
                        },
                    },
                    on: {
                        init: function () {
                            wrap.dataset.initialized = 'true';
                        }
                    }
                });
            } catch (e) {
                console.error('BoldPost: Swiper init failed', e);
            }

            // Mark as initialized immediately to avoid double calls before Swiper finishes
            wrap.dataset.initialized = 'true';
        });
    };

    // Frontend initial load
    document.addEventListener('DOMContentLoaded', function () {
        window.initBoldpoSlider(document);
    });

})(window);