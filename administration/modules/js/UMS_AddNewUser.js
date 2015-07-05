/**
 * GBlog
 *
 * Autor: GOLDWINGSTUDIOS - goldwingstudios.de
 * License: (CC BY-SA 4.0) - http://creativecommons.org/licenses/by-sa/4.0/
 * 
 */

$(document).ready(function() {
    $("td[id^=AddUser_]").on("click", function() {
        var id = $(this).attr("id");
        var id_substr = id.split(/_(.+)?/)[1].replace("_", " ");
        $(".AddUserForm").css("display", "block");
        $("#NewUserRole").text(id_substr);
        $("#NewUser_Form_attr").val(id_substr);
    });

    $("#CloseAddForm").on("click", function() {
        $(".AddUserForm").css("display", "none");
        $("#NewUserRole").text("");
    });

    $("#submit_NewUser").on("click", function() {
        $("#NewUser_Form").submit();
    });
});