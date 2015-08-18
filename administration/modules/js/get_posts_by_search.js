/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

$(document).ready(function() {
    var search_bar = $("#search_bar");
    var blog_posts = $(".blog_posts");

    search_bar.empty();

    search_bar.keyup(function() {
        $(".blog_link").remove();
        $.ajax({
            url: "modules/blog_core/full_text_search.php",
            type: "POST",
            data: {search_tag: search_bar.val()}
        })
                .done(function(data) {
                    $(".blog_link").remove();
                    if (data.length > 0)
                    {
                        try
                        {
                            var return_ = JSON.parse(data);
                            for (key in return_)
                            {
                                console.log(return_);
                                var id = generate_blog_id(return_[key]["sql"][0]["id"]);
                                var title = return_[key]["xml"]["title"];
                                var date = return_[key]["xml"]["date"];
                                var text = return_[key]["sql"][0]["post_preview"];
                                var xy = '<a class="blog_link" href="index.php?post=' + id + '">\n\
                                                <div class="blog_post">\n\
                                                <div class="post_title"><span class="post_title_t">' + title + '</span></div>\n\
                                                <div class="post_date"><span class="post_date_text">' + date + '</span></div>\n\
                                                <div class="post_text"><span class="post_text_t">' + text + ' ...</span></div>\n\
                                                </div>\n\
                                                </a>';
                                blog_posts.append(xy);
                            }
                        } catch (e)
                        {
                            console.log(e);
                        }
                    }
                })
                .fail(function() {

                })
                .always(function() {

                });
    });

    function generate_blog_id(id) {
        var return_ = id;
        while (return_.length <= 3) {
            return_ = "0" + return_;
        }
        return return_;
    }

    var getObjectSize = function(obj) {
        var len = 0, key;
        for (key in obj) {
            if (obj.hasOwnProperty(key))
                len++;
        }
        return len;
    };
});