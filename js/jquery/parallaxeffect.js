jQuery(document).ready(function($){
    $('.bgimage').toggle(
        function() {
        $("html, body").animate({ scrollTop: ($(this).offset().top - _headerHeight) }, "slow");
        $(this).animate({ height: _winH }, 'slow', function() {
        });
        },
        function() {
        $(this).animate({ height: 300 }, 'slow', function() {
        });
    });
});