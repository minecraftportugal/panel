App.bootstrap = function() {

    $.ajax({
        url: "/js/data/userpreferences.json",
        method: "GET",
        success: function(data) {
            var image = '/images/backgrounds/bg' + data.background + '.jpg';
            App.Widget.setBackground(image);
            console.log(data);
        }
    });
};

App.bootstrap();