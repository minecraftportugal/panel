App.API = {};

App.API.bootstrap = function() {

    $.ajax({
        url: "/bootstrap",

        dataType: "json",

        success: function(data, textStatus, jqXHR) {
            App.Desktop.setBackground(data.background);
        },

        error: function(jqXHR, textStatus, errorThrown) {
            console.log(data);
            alert("BOOTSTRAP ERROR! mail@minecraft.pt");
        }
    });
};

App.API.save = function() {

};

App.API.load = function() {

};

App.API.bootstrap();