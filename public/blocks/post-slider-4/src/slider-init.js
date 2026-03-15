(function (window) {

    window.initBoldpoSlider4 = function (scope) {

        const wraps = (scope || document).querySelectorAll(
            '.boldpo-post-slider-4-block-wrap'
        );

        wraps.forEach(function (wrap) {

            // Check if Swiper is available
            if (typeof Swiper === 'undefined') {
                console.warn('BoldPost: Swiper is not defined. Retrying later or check enqueue.');
                return;
            }

            const unique = wrap.dataset.unique;
            const sliderElement = wrap.querySelector('.boldpo-post-slider-4-' + unique);

            // already initialized or no slider element
            if (wrap.dataset.initialized === 'true' || !sliderElement) {
                return;
            }

            // Initialize Swiper with element reference
            try {
                const thumbsEl = wrap.querySelector(".slider__thumbs .swiper-container");
                const imagesEl = wrap.querySelector(".slider__images .swiper-container");
                const spaceBetween = wrap.dataset.spaceBetween;
                const effect = wrap.dataset.effect;
                const speed = wrap.dataset.speed;

                if (thumbsEl && imagesEl) {
                    const sliderThumbs = new Swiper(thumbsEl, {
                        direction: "vertical",
                        slidesPerView: 4,
                        spaceBetween: spaceBetween,
                        speed: speed,
                        freeMode: true,
                        watchSlidesProgress: true,
                        watchOverflow: true,
                        slideToClickedSlide: true, // This is explicitly needed to make clicking thumbs change the main slide correctly
                        navigation: {
                            nextEl: wrap.querySelector(".slider__next"),
                            prevEl: wrap.querySelector(".slider__prev")
                        },
                        breakpoints: {
                            0: {
                                direction: "horizontal",
                                slidesPerView: 1,
                            },
                            768: {
                                direction: "vertical"
                            }
                        }
                    });

                    const sliderImages = new Swiper(imagesEl, {
                        spaceBetween: 0,
                        autoplay: wrap.dataset.autoplay !== 'false' ? {
                            delay: 7000, // 7 seconds delay as per default template
                            disableOnInteraction: wrap.dataset.pauseOnInter !== 'false',
                        } : false,
                        effect: effect,
                        parallax: true,
                        fadeEffect: { crossFade: true },
                        navigation: {
                            nextEl: wrap.querySelector(".slider__next"),
                            prevEl: wrap.querySelector(".slider__prev")
                        },
                        pagination: {
                            el: wrap.querySelector(".swiper-pagination"),
                            clickable: true,
                            type: 'bullets',
                            dynamicBullets: false,
                        },
                        grabCursor: true,
                        thumbs: {
                            swiper: sliderThumbs
                        }
                    });

                    // stop click event for all links
                    thumbsEl.querySelectorAll('a').forEach(function (link) {
                        link.addEventListener('click', function (e) {
                            e.preventDefault();
                        });
                    });
                }
            } catch (e) {
                console.error('BoldPost: Swiper init failed', e);
            }

            // Mark as initialized immediately to avoid double calls before Swiper finishes
            wrap.dataset.initialized = 'true';
        });
    };

    // Frontend initial load
    document.addEventListener('DOMContentLoaded', function () {
        window.initBoldpoSlider4(document);
    });

})(window);