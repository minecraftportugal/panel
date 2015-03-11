App.Iframe = function() {

};

App.Iframe.loadCSS = function(element, file) {
  element.contentWindow.$('head').append('<link rel="stylesheet" type="text/css" href="//' + window.location.hostname + '/css/' + file + '.css">');
};

App.Iframe.loadJS = function(element, file) {
  element.contentWindow.$('head').append('<script type="text/javascript" src="//' + window.location.hostname + '/js/' + file + '.js">');
};