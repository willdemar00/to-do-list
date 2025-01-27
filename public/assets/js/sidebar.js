$(document).ready(function() {
    $('[hide-toggle]').click(function(event) {
        event.stopPropagation();
        var target = $(this).attr('hide-toggle');
        $('[area-hide-toggle="' + target + '"]').toggleClass('active').toggleClass('close');
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('[area-hide-toggle], [hide-toggle]').length) {
            $('[area-hide-toggle]').removeClass('active').addClass('close');
        }
    });
});
