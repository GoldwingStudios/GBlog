$(document).ready(function() {
    var Link_ID = 0;
    $("#AddSocialMediaLink").on("click", function() {
        var id = $('[id$="_type"]').attr("id");
        if (typeof id !== "undefined" && id != "" && id != 0)
        {
            id = id.replace("_type", "")
            Link_ID = parseInt(id) + 1;
        }
        else
        {
            Link_ID = parseInt(Link_ID) + 1;
        }
        var AddSML_HTML_String = '<div id="SML_ID_' + Link_ID + '" class = "social_media">\n\
                                    <input id="' + Link_ID + '_type" class="social_media_input_type" name="" type="text" placeholder="Input a Type!"/>\n\
                                    <input id="' + Link_ID + '_link" class="social_media_input_link" name="" type="text" placeholder="Input a link" / >\n\
                                    <img id="' + Link_ID + '" class="SML_delete_Link" src="../assets/images/delete.svg" />\n\
                                </div>';
        $(".SML_control_container").prepend(AddSML_HTML_String);
    });

    $(document).on('change', '[id$="_type"]', function() {
        var Link_ID = $(this).attr("id").replace("_type", "");
        var Link_Type = $(this).val();
        $(this).prop("name", Link_Type + "_type");
        $("#link_" + Link_ID).prop("name", Link_Type + "_link");
        var vf = $("#" + Link_ID + "_link");
        var x = $("#" + Link_ID + "_link").prop("placeholder", "Input a " + Link_Type + " link");
        var y = 0;
    });

    $(document).on('click', '.SML_delete_Link', function() {
        var id = "#SML_ID_" + $(this).attr("id");
        var remove_permission = confirm("Do you want to delete this link?")
        if (remove_permission)
        {
            $(id).remove();
        }
    });

});