$(document).ready(function() {
    $('#menu-toggle').click(function() {
        $('menu').toggleClass('active close');
        $('body').toggleClass('body-expanded');
    });
});
