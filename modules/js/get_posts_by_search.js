$(document).ready(function() {
    var search_bar = $("#search_bar");
    var blog_posts = $(".blog__content");

    search_bar.empty();

    search_bar.keyup(function() {
        var search_string = search_bar.val();
        var lastChar = search_string.substr(search_string.length - 1)
        if (lastChar != " " && lastChar != "")
        {
            $(".blog__entry").remove();
            $.ajax({
                url: "backend/full_text_search.php",
                type: "POST",
                data: {search_tag: search_bar.val()}
            })
                    .done(function(data) {
                        $(".blog__entry").remove();
                        if (data.length > 0)
                        {
                            try
                            {
                                var return_ = JSON.parse(data);
                                for (var i = 0; i < return_.length; i++)
                                {
                                    console.log(return_);
                                    var id = generate_blog_id(return_[i]["post_title"]);
                                    var title = return_[i]["post_title"];
                                    var date = convert_date(return_[i]["post_date"]);
                                    var text = get_preview(return_[i]["post_text"]);
                                    var xy = '<a class="blog__entry" href="index.php?post=' + id + '"> \
                                                <div class="blog__entry__header"> \
                                                    <h2>' + title + '</h2> \
                                                    <span class="blog__entry__date">' + date + '</span> \
                                                </div> \
                                                <p>' + text + ' ...</p>\
                                                </a>';
                                    blog_posts.append(xy);
                                }
                                if (return_.length == 0)
                                {
                                    blog_posts.append('<a class="blog__entry"> \
                                                    <div class="blog__entry__header"> \
                                                    <h2>No Posts found!</h2> \
                                                    <span class="blog__entry__date"></span> \
                                                </div> \
                                                <p></p>\
                                                </a>');
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
        }
        else if (search_string == "")
        {
            $(".blog__entry").remove();
        }
    });

    function generate_blog_id(id) {
        id = id.replace(/~/g, "_");
        id = id.replace(/-/g, "_");
        id = id.replace(/ /g, '_');
        id = id.replace(/ä/g, "ae");
        id = id.replace(/ö/g, "oe");
        id = id.replace(/ü/g, "ue");
        id = id.replace(/ß/g, "ss");

        id = id.replace(/\./g, "");
        id = id.replace(/:/g, "");
        id = id.replace(/,/g, "");
        id = id.replace(/;/g, "");
        id = id.replace(/|/g, "");
        id = id.replace(/</g, "");
        id = id.replace(/>/g, "");
        id = id.replace(/@/g, "");
        id = id.replace(/µ/g, "");
        id = id.replace(/#/g, "");
        id = id.replace(/\+/g, "");
        id = id.replace(/'/g, "");
        id = id.replace(/!/g, "");
        id = id.replace(/\?/g, "");
        id = id.replace(/\\/g, "");
        id = id.replace(/\*/g, "");
        id = id.replace(/{/g, "");
        id = id.replace(/}/g, "");
        id = id.replace(/\(/g, "");
        id = id.replace(/\)/g, "");
        id = id.replace(/\[/g, "");
        id = id.replace(/\]/g, "");
        id = id.replace(/=/g, "");
        id = id.replace(/´/g, "");
        id = id.replace(/`/g, "");
        id = id.replace(/"/g, "");
        id = id.replace(/§/g, "");
        id = id.replace(/%/g, "");
        id = id.replace(/&/g, "und");
        id = id.replace(/\\/g, "");
        return id.toLowerCase();
    }

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