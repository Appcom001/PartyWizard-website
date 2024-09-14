$(document).ready(function(){
    var $carousel = $("#productCarousel");

    setTimeout(function() {
        $carousel.owlCarousel({
            loop: $carousel.children('.item').length > 1,
            margin: 10,
            nav: false,
            dots: true,
            responsive:{
                0:{
                    items: Math.min(2, $carousel.children('.item').length)
                },
                600:{
                    items: Math.min(3, $carousel.children('.item').length)
                },
                1000:{
                    items: Math.min(4, $carousel.children('.item').length)
                }
            }
        });

        $("#nextButton").click(function(){
            $carousel.trigger('next.owl.carousel');
        });
        $("#prevButton").click(function(){
            $carousel.trigger('prev.owl.carousel');
        });
    }, 100); 
});
