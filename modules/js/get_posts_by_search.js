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
                            for (var i = 0; i < return_.length; i++)
                            {
                                console.log(return_);
                                var id = generate_blog_id(return_[i]["post_id"]);
                                var title = return_[i]["post_title"];
                                var date = convert_date(return_[i]["post_date"]);
                                var text = get_preview(return_[i]["post_text"]);
                                var xy = '<a class="blog_link" href="index.php?post=' + id + '">\n\
                                                <div class="blog_post">\n\
                                                <div class="post_title"><span class="post_title_t">' + title + '</span></div>\n\
                                                <div class="post_date"><span class="post_date_text">' + date + '</span></div>\n\
                                                <div class="post_text"><span class="post_text_t">' + text + ' [...]</span></div>\n\
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

    var convert_date = function(date_) {
        var date_split = date_.split(" ");
        var year_month_day = date_split[0];
        year_month_day = year_month_day.split("-");
        var day_month_year = year_month_day[2] + "." + year_month_day[1] + "." + year_month_day[0];
        var time = date_split[1];
        time = time.substring(0, time.lastIndexOf(":"));

        return day_month_year + ", " + time;
    }

    var get_preview = function(text) {
        var steps = 100;
        var last_space = text[steps];
        if (text.length < steps) {
            return text;
        } else {
            if (last_space == " ") {
                return text.substring(0, steps);
            } else {
                while (steps <= text.length) {
                    steps++;
                    if (text[steps] == " ") {
                        return text.substring(0, steps);
                    }
                }
                return text.substring(0, steps);
            }
        }
    }
});