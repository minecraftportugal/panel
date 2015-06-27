App.Forms = {

};

App.Forms.userOptions = function() {

    $("input#chk_sounds").prop("checked", App.Desktop.settings.sounds);
    $("input#input_url").val(App.Desktop.settings.background.image);

    $("form[name=bg_settings]").submit(function(e) {
        e.preventDefault();

        var loading_blocker = $(this).closest("div.body").next();
        loading_blocker.addClass("block-enabled");

        App.Desktop.settings.sounds = $("input#chk_sounds").prop("checked");

        var imageURL = $("input#input_url").val();
        var deferred = $.when(App.Desktop.setBackground({ image: imageURL }));

        deferred.then(function(data) {
            App.Desktop.settings.background = data;
            App.Toaster.fadeIn({
                "title" : "<i class=\"fa fa-check-circle\"></i> Sucesso!",
                "message" : "alterações efectuadas",
                "classes" : "success",
                "duration" : 3000
            });
        });

        deferred.fail(function(data) {
            App.Toaster.fadeIn({
                "title" : "<i class=\"fa fa-exclamation-triangle\"></i> Erro!",
                "message" : "O URL da imagem não funciona!",
                "classes" : "error",
                "duration": 3000,
                "sound" : "break"
            });
        });

        deferred.always(function() {
            loading_blocker.removeClass("block-enabled");
        });

        return false;
    });

};

