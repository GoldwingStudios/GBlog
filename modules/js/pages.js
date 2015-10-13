$(document).ready(function() {
    var post_count_per_site = 10;
    var posts_count = $(".blog__entry").length;
    var pages = Math.ceil(posts_count / 10);
    for (var i = 1; i <= pages; i++)
    {
        if (post_count_per_site / 10 == i)
        {
            $(".blog__content").append('<div class="post__page_disabled" id="post__page' + i + '">' + i + "</div>");
        }
        else
        {
            $(".blog__content").append('<div class="post__page" id="post__page' + i + '">' + i + "</div>");
        }
    }

    $(".blog__entry").slice(post_count_per_site, $(".blog__entry").length).removeClass("blog__entry").addClass("invisible_block");

    $(document).on("click", ".post__page", function() {
        $('[class^="post__page"]').removeClass("post__page_disabled post__page").addClass("post__page");
        $(this).removeClass("post__page").addClass("post__page_disabled");
        var ID = parseInt($(this).attr("id").replace('post__page', ''));
        var post_count_start = (ID - 1) * 10;
        post_count_per_site = ID * 10;
        $(".blog__content > a").removeClass("blog__entry").addClass("invisible_block");
        $(".blog__content > a").slice(post_count_start, post_count_per_site).removeClass("invisible_block").addClass("blog__entry");
    });
});