// tooltips for hints
$('.f00-gtc-container').on({
    mouseenter: function () {
        $(this).tooltip('show');
    },

    mouseleave: function () {
        $(this).tooltip('hide');
    }
}, '.f00-mystery-card');

// check answers and refresh cards & form
$('.f00-gtc-container').on('click', '#guess-the-card input[type=submit]', function(event){
    event.preventDefault();

    $.post( document.location.pathname, { 
        'guesses[]': $('#guess-the-card input.f00-gtc-guess').map(function(){return $(this).val();}).get(),
    },
        function() {
            $(".f00-gtc-container").html('<i class="fa fa-spinner fa-spin fa-4x"></i>');
        }
    )
    .done( function( data ) {
        $('.f00-gtc-container').html( $(data).find('.f00-gtc-container').html() )
            .hide()
            .fadeIn();
    });
});