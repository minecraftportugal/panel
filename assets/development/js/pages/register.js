// bypass same origin policy
document.domain = "minecraft.pt";

$(document).ready(function() {

    $("form").submit(function() {
        var $form = $(this);
        var $status = $("div#status");
        var $waiting = $("div#waiting");
        var data = $form.serialize();
        var url = $form.attr("action");

        $.ajax({

            url: url,

            data: data,

            type: "post",

            dataType: "json",

            beforeSend: function(jqXHR, settings) {
                $form.find("input").attr("disabled", true).attr("readonly", true);
                $form.find("button").attr("disabled", true).attr("readonly", true);
                $status.removeClass("success").removeClass("error").addClass("waiting");
                $status.hide();
                $waiting.show();
            },

            success: function(data, textStatus, jqXHR) {
                $status.show();
                $waiting.hide();
                if (data.status == "ok") {
                    $status.html(data.notice.success.message);
                    $status.removeClass("error").addClass("success");
                } else if (data.status == "ko") {
                    $status.html(data.notice.error.message);
                    $status.removeClass("success").addClass("error");
                }
            },

            error: function(jqXHR, textStatus, errorThrown) {

            },

            complete: function(e, jqXHR, options) {
                $waiting.hide();
                $form.find("input").removeAttr("disabled").removeAttr("readonly");
                $form.find("button").removeAttr("disabled").removeAttr("readonly");
            }
        });

        return false;
    })
});
