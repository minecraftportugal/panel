App.Iframe = (function() {

    var Iframe = {};

    Iframe.loadCSS = function(element, file) {
      element.contentWindow.$('head').append('<link rel="stylesheet" type="text/css" href="//' + window.location.hostname + '/css/' + file + '.css">');
    };

    Iframe.loadJS = function(element, file) {
      element.contentWindow.$('head').append('<script type="text/javascript" src="//' + window.location.hostname + '/js/' + file + '.js">');
    };

    return Iframe;

})();