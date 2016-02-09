$(document).ready(function() {
    $(".message-on-hover").on("mouseover", function() {
        var text = $(this).attr("data-message");
        $("body").append('<div class="hovering-message">' + text + '</div>');
        var top = $(this).offset().top + 35;
        var left = $(this).offset().left - (($(".hovering-message").outerWidth() / 2)) + $(this).width();
        $(".hovering-message").css("top", top).css("left", left);
        console.log(top + " " + left);
    });

    $(".message-on-hover").on("mouseleave", function() {
        $(".hovering-message").remove();
    });
});