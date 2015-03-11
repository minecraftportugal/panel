App = function() {

};

App.settings = {
    "showBaloonTips" : true
};

App.logout = function() {
    var form = $('<form class="noajax"></form>');
    form.attr("method", "post");
    form.attr("action", "/logout");
    var field = $("<input></input>");
    field.attr("type", "hidden");
    field.attr("name", "logout");
    field.attr("value", "1");

    form.append(field);
    
    var xsrf_token = $("meta[name=xsrf_token]").attr("content");
    field = $("<input></input>");
    field.attr("type", "hidden");
    field.attr("name", "xsrf_token");
    field.attr("value", xsrf_token);

    form.append(field);

    $(document.body).append(form);
    form.submit(); 
};