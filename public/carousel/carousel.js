let breakpoint = {
    // Small screen / phone
    sm: 576,
    // Medium screen / tablet
    md: 768
};

// slick slider
$("#slick").slick({
    autoplay: true,
    autoplaySpeed: 2000,
    draggable: true,
    infinite: true,
    dots: true,
    arrows: true,
    prevArrow: '<button class="slide-arrow prev-arrow"></button>',
    nextArrow: '<button class="slide-arrow next-arrow"></button>',
    speed: 1000,
    mobileFirst: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: breakpoint.sm,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
            },
        },
        {
            breakpoint: breakpoint.md,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
            },
        }
    ],
});
