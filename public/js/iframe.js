App.Iframe = function() {

};

App.Iframe.loadCSS = function(element, file) {
  element.contentWindow.$('head').append('<link rel="stylesheet" type="text/css" href="' + App.url + '/css/' + file + '.css">');
};

App.Iframe.loadJS = function(element, file) {
  element.contentWindow.$('head').append('<script type="text/javascript" src="' + App.url + '/js/' + file + '.js">');
};