$(".nav-menu-icon").click(function(){
    $(".nav-menu").toggleClass("nav-menu--open");
});
$("#index-s6-owl").owlCarousel({
    loop:true,
    responsive:{
        0:{items:1},
        600:{items:2},
        840:{items:3}
    }
});